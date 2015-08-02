var TgCustomizerObj = library(function ($) {
    var storage,
        template = {},
        templateId,
        unsaved = false,

        set = function (data) {
            template = data;
        },

        exitInStorage = function (key) {
            return $.parseJSON(storage.getItem(key) || 'false');
        };

    return {
        /**
         *
         * @param id        template id
         * @param handle    handler function
         */
        init: function (id, handle) {
            if (!id) {
                return;
            }
            templateId = id;

            if (!storage) {
                storage = localStorage;
            }
            var customizer = exitInStorage('customizer');
            if (customizer) {
                set(customizer);
            }

            return this;
        },
        save: function (isUpdate) {
            if (!_.has(template, templateId)) {
                template[templateId] = {};
            }
            if (isUpdate !== false) {
                template[templateId].updated_at = Math.floor(Date.now() / 1000);
                unsaved = true;
            }

            // event is not sent if the storage is not mutated!
            if (storage.getItem('customizer') !== null) {
                storage.removeItem('customizer');
            }
            storage.setItem('customizer', JSON.stringify(template));

            try {
                console.log('setItem');
                //storage.setItem('customizer', JSON.stringify(template));
                return true;
            } catch (e) {
                if (e.name === 'QUOTA_EXCEEDED_ERR') {
                    TgAlert.error('Local Storage', 'Oh no! We ran out of room!');
                    return false;
                }
            }
        },
        isUnsaved: function () {
            return unsaved;
        },
        load: function (data) {
            if (_.has(template, templateId) && template[templateId].updated_at > parseInt(data.updated_at)) {
                TgAlert.warning('Customizer', 'You have unsaved data!');
                unsaved = true;
                return this;
            } else if (_.has(template, templateId) && template[templateId].updated_at == parseInt(data.updated_at)) {
                TgAlert.purple('Customizer', 'Used data stored in th database');
                unsaved = false;
            }

            template[data.id.toString()] = {updated_at: data.updated_at, sections: data.sections};
            this.save(false);


            var input = [{
                "id": "17",
                "updated_at": "1438448768",
                "sections": [{
                    "id": "1",
                    "template_id": "17",
                    "alias": "test",
                    "title": "Test",
                    "description": "Rtrawfd auhf zsjf ozs osgj",
                    "priority": "10",
                    "sectionControls": [{
                        "id": "1",
                        "section_id": "1",
                        "control_id": "4",
                        "priority": "10",
                        "alias": "test-text",
                        "label": "Test Text",
                        "help": null,
                        "description": "skehf zsh lsh ",
                        "default": "Blah Blah",
                        "style": null,
                        "params": null,
                        "pseudojs": null,
                        "control": {
                            "id": "4",
                            "name": "Text",
                            "family": "kirki",
                            "type": "tg-text",
                            "class": "text",
                            "params": "",
                            "img": "text.png",
                            "css": ""
                        }
                    }]
                }]
            }];

            var saved = {
                "17": {
                    "updated_at": 1438496657,
                    "sections": [{
                        "id": "1",
                        "template_id": "17",
                        "alias": "test",
                        "title": "Test",
                        "description": "Rtrawfd auhf zsjf ozs osgj",
                        "priority": "10",
                        "sectionControls": [{
                            "id": "1",
                            "section_id": "1",
                            "control_id": "4",
                            "priority": "10",
                            "alias": "test-text",
                            "label": "Test Text",
                            "help": null,
                            "description": "skehf zsh lsh ",
                            "default": "Blah Blah",
                            "style": null,
                            "params": null,
                            "pseudojs": null,
                            "control": {
                                "id": "4",
                                "name": "Text",
                                "family": "kirki",
                                "type": "tg-text",
                                "class": "text",
                                "params": "",
                                "img": "text.png",
                                "css": ""
                            }
                        }]
                    }]
                }
            };
            return this;
        },
        addSection: function ($el) {
            this.save();
        },
        addControl: function ($el) {

        },
        removeEl: function ($el) {

        },
        render: function ($el) {
            $el.empty();

            if (!_.has(template[templateId], 'sections')) { // if no was stored
                return this;
            }
            var self = this;

            _.each(template[templateId].sections, function (section) {
                var sectionData = _.chain(section)
                        .clone()
                        .omit('sectionControls')
                        .value();
                var sectionEl = self.prepareSection(sectionData, true);
                $el.append(sectionEl);

                if (!_.has(section, 'sectionControls')) { // this section has no controls
                    return this;
                }

                var $controlsSortable = sectionEl.find('.controls-sortable');

                _.each(section.sectionControls, function (control) {
                    control.img = '/images/controls/' + control.control.img;
                    var controlData = _.chain(control)
                            .clone()
                            .omit('control')
                            .value();
                    var $control = self.prepareControl(controlData, true);
                    $controlsSortable.append($control);
                });
            });
        },
        prepareSection: function (data, isSaved) {
            var sectionTemplate = Handlebars.compile($('#section-template').html());
            var $section = $(sectionTemplate({
                isSaved: isSaved,
                settings: JSON.stringify(data)
            }));

            $section.find('img').niftyOverlay();
            return $section;
        },
        prepareControl: function (data, isSaved) {
            var controlTemplate = Handlebars.compile($('#control-template').html());
            var $control = $(controlTemplate({
                isSaved: isSaved,
                label: data.label,
                img: data.img,
                settings: JSON.stringify(data)
            }));

            $control.find('img').niftyOverlay();
            return $control;
        }
    };
}(jQuery));

var TgCustomizer = library(function ($) {
    var sectionWidth = 300,
        controlWidth = 270,
        jqxhr = null,
        templateId = $('#tid').val(),
        storage,

        initSectionsDraggable = function (id) {
            initDraggable(id, '.list-group.section');
        },

        initControlsDraggable = function (id) {
            initDraggable(id, '.list-group.control');
        },

        initDraggable = function (sortable_id, selector) {
            $('#aside').find(selector).each(function () {
                var $self = $(this);
                $(this).draggable({
                    helper: function () {
                        var $img = $self.find('img'),
                            imgSrc = $img.attr('src'),
                            controlId = $img.data('id'),
                            controlName = $img.data('name'),
                            type = $img.data('type'),
                            width = type == 'section' ? sectionWidth : controlWidth;

                        var $result = $('<div class="draggable-el" style="width: ' + width + 'px" />');
                        if (type != 'section') {
                            $result = $result.append($('<div class="text-lg" style="padding: 3px;">' + controlName + '</div>'));
                        }

                        var $dragImg = $('<img src="' + imgSrc + '" width="' + width + 'px" />');

                        if (!!controlId) {
                            $dragImg.attr('data-id', controlId);
                        }
                        if (!!controlName) {
                            $dragImg.attr('data-name', controlName);
                        }
                        if (!!type) {
                            $dragImg.attr('data-type', type);
                        }

                        $result = $result.append($dragImg);

                        return $result;
                    },
                    zIndex: 1100,
                    revert: 'invalid',
                    appendTo: 'body',
                    connectToSortable: sortable_id
                });
            });
        },

        initSectionsSortable = function (el) {
            initSortable(el);
        },

        initControlsSortable = function (el) {
            initSortable(el);
        },

        initSortable = function (el) {
            el.sortable({
                revert: true,
                placeholder: 'drop-hover',
                containment: 'document',
                opacity: 0.5,
                zIndex: 1100,
                beforeStop: function (event, ui) {
                    var $img = ui.helper.find('img'),
                        controlId = $img.data('id'),
                        imgSrc = $img.attr('src'),
                        controlName = $img.data('name'),
                        type = $img.data('type');

                    var $sortable = type == 'section' ? TgCustomizerObj.prepareSection() :
                        TgCustomizerObj.prepareControl({
                            img: imgSrc,
                            control_id: controlId,
                            label: controlName
                        });

                    ui.item
                        .removeAttr('style')
                        .addClass('ui-sortable-handle')
                        .removeClass('draggable-el')
                        .html($sortable);

                    if (type == 'section') {
                        storage.addSection($sortable);
                    }

                    clearSelected();

                    initControlsSortable($('.controls-sortable'));

                    $(window).trigger('customizerChanged');
                }
            }).disableSelection();
        },

        initDroppable = function ($el) {
            $el.droppable({
                accept: function ($el) {
                    return $el.hasClass('ui-sortable-handle');
                },
                activeClass: 'ui-state-hover',
                hoverClass: 'ui-state-active',
                tolerance: 'touch',
                greedy: true,
                drop: function (ev, ui) {
                    dropBlock(ui.draggable);
                }
            });
        },

        dropBlock = function ($el) {
            $el.remove();
            storage.removeEl($el);
        },

        initEditable = function () {
            $(document).on('click', '.section-wrapper > img,.control-wrapper', function (e) {
                e.preventDefault();

                if ($(this).hasClass('control-wrapper')) {
                    if ($(this).hasClass('selected')) {
                        clearSelected();
                        return;
                    }
                    highlightSelectedControl($(this));
                    loadSettings($(this).find('img'));
                } else {
                    if ($(this).parent().hasClass('selected')) {
                        clearSelected();
                        return;
                    }
                    highlightSelectedSection($(this).parent());
                    loadSettings($(this));
                }
            });
        },

        /**
         * Deselect section/control and empty settings container
         */
        clearSelected = function () {
            $('.sections-sortable').find('.section-wrapper,.control-wrapper').removeClass('selected');
            $('#settings-container').empty();
            $('#setting-helper').removeClass('hidden');
        },

        highlightSelectedSection = function ($el) {
            clearSelected();
            $el.addClass('selected');
        },

        highlightSelectedControl = function ($el) {
            clearSelected();
            $el.addClass('selected');
        },

        loadSettings = function ($el) {
            if (jqxhr && jqxhr.readyState != 4) { // check if request is executing now
                jqxhr.abort();
            }

            var type = $el.data('type'),
                settings = $el.data('settings'),
                params = {type: type, tid: templateId};

            $el.niftyOverlay('show');

            jqxhr = $.get('/control/settings', params, function (res) {
                $('#setting-helper').addClass('hidden');
                $('#settings-container').html(res);

                if (!_.isEmpty(settings)) {
                    fillForm(type, settings);
                }
            })
                .fail(function (res) {
                    showError(res);
                })
                .always(function () {
                    $el.niftyOverlay('hide');
                });
        },

        fillForm = function(type, settings) {
            _.each(settings, function (setting, index) {
                $('#' + type + '-' + index).val(setting);
            });
        },

        /**
         * Load saved sections and controls and render they in $el
         * @param $el
         */
        loadControls = function ($el) {
            if (jqxhr && jqxhr.readyState != 4) { // check if request is executing now
                jqxhr.abort();
            }

            var params = {id: templateId};

            $('#load-customizer-btn').niftyOverlay('show');

            jqxhr = $
                .get('/template/customizer', params, function (res) {
                    storage.load(res).render($el);

                    initSectionsDraggable('.sections-sortable');
                    initControlsDraggable('.controls-sortable');
                    initSectionsSortable($('.sections-sortable'));
                    initControlsSortable($('.controls-sortable'));
                    initDroppable($('#droppable'));
                    initEditable();

                }, 'json')
                .fail(function (res) {
                    showError(res);
                })
                .always(function () {
                    $('#load-customizer-btn').niftyOverlay('hide');
                });
        },

        customizerChanges = function () {
            if ($('#customizer-controls').find('.unsaved').length) {
                $('#save-customizer-btn').removeClass('hidden');
            } else {
                $('#save-customizer-btn').addClass('hidden');
            }
        };

    return {
        init: function () {
            storage = TgCustomizerObj.init(templateId, this.storageChanged);

            $('#load-customizer-btn')
                .niftyOverlay()
                .on('click', function () {
                    loadControls($('#customizer-controls'));
                })
                .trigger('click');

            $(window).bind('customizerChanged', function () {
                customizerChanges();
            });
        },

        storageChanged: function (e) {
            console.log(e);
            console.log('3213123');

            var event = e || window.event;

            console.log(event);
        }
    };
}(jQuery));
