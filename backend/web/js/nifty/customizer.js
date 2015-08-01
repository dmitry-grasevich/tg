var TgCustomizerObj = library(function ($) {
    var storage,
        template = {},
        templateId,

        set = function (data) {
            template = JSON.parse(data);
        };

    return {
        /**
         *
         * @param id  template id
         */
        init: function (id) {
            if (!id) {
                return;
            }
            templateId = id;

            if (!storage) {
                storage = localStorage;
            }
            if (storage.customizer) {
                set(storage.customizer);
            } else {
                this.save();
            }
            return this;
        },
        save: function () {
            storage.customizer = JSON.stringify(template);
        },
        load: function (data) {
            if (_.has(template, templateId) && template[templateId].updated_at > parseInt(data.updated_at)) {
                console.log('Current date is later than saved in the DB');
                return this;
            }

            template[data.id.toString()] = { updated_at: data.updated_at, sections: data.sections };
            this.save();

            //console.log(Math.floor(Date.now() / 1000));

            var ee = [{
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
            return this;
        },
        addSection: function () {

        },
        addControl: function () {

        },
        render: function ($el) {
            if (!_.has(template[templateId], 'sections')) {
                return this;
            }
            var self = this;

            _.each(template[templateId].sections, function (section) {
                var $section = self.prepareSection(section);
                $el.append($section);

                if (!_.has(section, 'sectionControls')) {
                    return this;
                }

                var $controlsSortable = $section.find('.controls-sortable');

                _.each(section.sectionControls, function (sectionControl) {
                    sectionControl.img = '/images/controls/' + sectionControl.control.img;
                    var $sectionControl = self.prepareControl(sectionControl);
                    $controlsSortable.append($sectionControl);
                });
            });
        },
        prepareSection: function (data) {
            var $newImg = $('<img src="/images/controls/section.png" data-toggle="panel-overlay" data-target="#settings-wrapper" data-type="section" />')
                .niftyOverlay();
            if (!!data.id) {
                $newImg.attr('data-control-id', data.id);
            }
            if (!!data.title) {
                $newImg.attr('data-name', data.title);
            }

            return $('<a href="#" class="section-wrapper" />')
                .append($newImg)
                .append($('<div class="controls-sortable"></div>'));
        },
        prepareControl: function (data) {
            var $newImg = $('<img src="' + data.img + '" data-toggle="panel-overlay" data-target="#settings-wrapper" data-type="control" />')
                .niftyOverlay();
            var $control = $('<a href="#" class="control-wrapper" />');

            if (!!data.id) {
                $newImg.attr('data-control-id', data.id);
                $control.attr('data-control-id', data.id);
            }
            if (!!data.control_id) {
                $newImg.attr('data-id', data.control_id);
                $control.attr('data-id', data.control_id);
            }
            if (!!data.label) {
                $newImg.attr('data-name', data.label);
                $control = $control.append($('<div class="text-lg control-label">' + data.label + '</div>'));
            }

            return $control.append($newImg);
        }
    };
}(jQuery));

var TgCustomizer = library(function ($) {
    var sectionWidth = 300,
        controlWidth = 270,
        jqxhr = null,
        templateId = $('#tid').val(),
        storage = TgCustomizerObj.init(templateId),

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

                    var $sortable = type == 'section' ? TgCustomizerObj.prepareSection({}) :
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

                    clearSelected();

                    initControlsSortable($('.controls-sortable'));
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
                id = $el.data('control-id'),
                params = {type: type, tid: templateId};

            if (!!id) {
                params.id = id;
            }

            $el.niftyOverlay('show');

            jqxhr = $.get('/control/settings', params, function (res) {
                $('#setting-helper').addClass('hidden');
                $('#settings-container').html(res);
            })
                .fail(function (res) {
                    showError(res);
                })
                .always(function () {
                    $el.niftyOverlay('hide');
                });
        },

        loadControls = function ($el) {
            if (jqxhr && jqxhr.readyState != 4) { // check if request is executing now
                jqxhr.abort();
            }

            var params = {id: templateId};

            $el.niftyOverlay('show');

            jqxhr = $
                .get('/template/customizer', params, function (res) {
                    storage.load(res).render($('#customizer-controls'));

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
                    $el.niftyOverlay('hide');
                });
        };

    return {
        init: function () {
            $('#load-customizer-btn')
                .niftyOverlay()
                .on('click', function () {
                    loadControls($(this));
                })
                .trigger('click');
        }
    };
}(jQuery));