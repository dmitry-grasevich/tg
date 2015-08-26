/**
 * @TODO: save template customizer setting in the localStorage ???
 * */
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
         * @param id        template id
         */
        init: function (id) {
            if (!id) {
                return;
            }
            templateId = id;

            if (!storage) {
                storage = localStorage;
            }
            var customizer = exitInStorage('customizer');
            if (customizer) {
                //set(customizer);
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
            //this.save(false);

            return this;
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
                var sectionEl = self.prepareSection(sectionData, true, true);
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
                    var $control = self.prepareControl(controlData, true, true);
                    $controlsSortable.append($control);
                });
            });
        },
        prepareSection: function (data, isSaved, isWrap) {
            var sectionTemplate = Handlebars.compile($('#section-template').html()),
                uid = data.ctrl_id ? data.ctrl_id : _.uniqueId('section__');
            var $section = $(sectionTemplate({
                uid: uid,
                isUnsaved: !isSaved,
                isWrap: isWrap,
                settings: JSON.stringify(data)
            }));

            $section.find('img').niftyOverlay();
            return $section;
        },
        prepareControl: function (data, isSaved, isWrap) {
            var controlTemplate = Handlebars.compile($('#control-template').html()),
                uid = data.ctrl_id ? data.ctrl_id : _.uniqueId('control__');
            var $control = $(controlTemplate({
                uid: uid,
                isUnsaved: !isSaved,
                isWrap: isWrap,
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
        needForceSave = false,

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

                        var controlTemplate = Handlebars.compile($('#draggable-template').html());
                        return $(controlTemplate({
                            width: width,
                            name: controlName,
                            isControl: type != 'section',
                            img: imgSrc,
                            controlId: controlId,
                            controlName: controlName,
                            type: type
                        }));
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
                        type = $img.data('type'),
                        settings = $img.attr('data-settings'),
                        controls = ui.helper.find('.control-wrapper');

                    settings = _.isUndefined(settings) || settings == '' ? {} : $.parseJSON(settings);
                    settings.control_id = controlId;
                    settings.img = imgSrc;
                    settings.label = controlName ? controlName : settings.label;

                    var $sortable = type == 'section' ? TgCustomizerObj.prepareSection(settings) :
                        TgCustomizerObj.prepareControl(settings);

                    if (type == 'section' && controls.length) {
                        _.each(controls, function ($control) {
                            $sortable.find('.controls-sortable').append($control);
                        })
                    }

                    ui.item
                        .removeAttr('style')
                        .addClass('ui-sortable-handle')
                        .removeClass('draggable-el')
                        .html($sortable);

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
                    dropControl(ui.draggable);
                }
            });
        },

        dropControl = function ($el) {
            var settings = $.parseJSON($el.find('img').attr('data-settings')),
                type = $el.find('img').attr('data-type');
            if (settings.id) {
                $.post('/control/remove', {id: settings.id, type: type}, function () {
                    $el.remove();
                    $(window).trigger('customizerChanged');
                    TgAlert.success('Success', 'Control was successfully removed');
                })
                .fail(function (res) {
                    showError(res);
                });
            } else {
                $el.remove();
                needForceSave = true;
                $(window).trigger('customizerChanged');
                TgAlert.success('Success', 'Control was successfully removed');
            }
        },

        initEditable = function () {
            $(document).on('click', '.section-wrapper > img', function (e) {
                e.preventDefault();

                if ($(this).parent().hasClass('selected')) {
                    clearSelected();
                    return;
                }
                highlightSelectedSection($(this).parent());
                loadSettings($(this));
            });

            $(document).on('click', '.section-wrapper > .duplicate-btn', function (e) {
                e.preventDefault();

                duplicateSection($(this).parent().parent());
            });

            $(document).on('click', '.control-wrapper', function (e) {
                e.preventDefault();

                if ($(this).hasClass('selected')) {
                    clearSelected();
                    return;
                }
                highlightSelectedControl($(this));
                loadSettings($(this).find('img'));
            });
        },

        duplicateSection = function ($el) {
            var $newSection = $el.clone(),
                sectionSettings = $.parseJSON($newSection.find('img:first').attr('data-settings'));
            {
                var settings = {};
                _.each(['alias', 'title', 'description'], function(attr) {
                    if (_.has(sectionSettings, attr)) {
                        settings[attr] = sectionSettings[attr];
                    }
                });
                $newSection.find('a:first').removeClass('selected');
                $newSection.find('img:first')
                    .attr('data-settings', JSON.stringify(settings))
                    .attr('id', _.uniqueId('section_'));
            }
            {
                _.each($newSection.find('.controls-sortable').find('.ui-sortable-handle'), function (el) {
                    var $control = $(el).find('img'),
                        controlSettings = $.parseJSON($control.attr('data-settings')),
                        settings = {};
                    _.each(['control_id', 'alias', 'label', 'help', 'description', 'default', 'style',' params', 'pseudojs', 'img'], function(attr) {
                        if (_.has(controlSettings, attr)) {
                            settings[attr] = controlSettings[attr];
                        }
                    });
                    $control
                        .attr('data-settings', JSON.stringify(settings))
                        .attr('id', _.uniqueId('control_'));
                });
            }

            $el.after($newSection);
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

            var type = $el.attr('data-type'),
                settings = $el.attr('data-settings'),
                errors = $el.attr('data-error'),
                params = {type: type, tid: templateId};

            settings = _.isUndefined(settings) || settings == '' ? {} : $.parseJSON(settings);
            errors = _.isUndefined(errors) ? {} : $.parseJSON(errors);

            $el.niftyOverlay('show');

            jqxhr = $.get('/control/settings', params, function (res) {
                var $settingContainer = $('#settings-container');
                $('#setting-helper').addClass('hidden');

                $settingContainer.html(res);

                if (!_.isEmpty(settings)) {
                    fillForm(type, settings);
                }

                if (!_.isEmpty(errors)) { // this control has errors
                    var formId = type + '-form',
                        model = type == 'section' ? 'section' : 'sectioncontrol';
                    updateFormErrors(formId, model, errors);
                }

                $settingContainer.find('input,textarea').on('change', function (e) {
                    var key = $(e.target).attr('id').replace(type + '-', '');
                    settings[key] = $(e.target).val();
                    updateSettings($el, settings);
                });
            })
                .fail(function (res) {
                    showError(res);
                })
                .always(function () {
                    $el.niftyOverlay('hide');
                });
        },

        updateSettings = function ($el, settings) {
            $el.attr('data-settings', JSON.stringify(settings));
            $el.parent().find('div.control-label').text(settings.label);
            $el.parent().addClass('unsaved');
            $(window).trigger('customizerChanged');
        },

        fillForm = function (type, settings) {
            _.each(settings, function (setting, index) {
                $('#' + type + '-' + index).val(setting);
            });
        },

        loadCustomizer = function (data) {
            storage.load(data).render($('#customizer-controls'));

            initSectionsDraggable('.sections-sortable');
            initControlsDraggable('.controls-sortable');
            initSectionsSortable($('.sections-sortable'));
            initControlsSortable($('.controls-sortable'));
            initDroppable($('#droppable'));

            clearSelected();

            $(window).trigger('customizerChanged');
        },

        /**
         * Load saved sections and controls
         */
        loadControls = function () {
            if (jqxhr && jqxhr.readyState != 4) { // check if request is executing now
                jqxhr.abort();
            }

            var params = {id: templateId};

            $('#load-customizer-btn').niftyOverlay('show');

            jqxhr = $
                .get('/template/customizer', params, function (res) {
                    loadCustomizer(res);
                }, 'json')
                .fail(function (res) {
                    showError(res);
                })
                .always(function () {
                    $('#load-customizer-btn').niftyOverlay('hide');
                });
        },

        customizerChanged = function () {
            if ($('#customizer-controls').find('.unsaved').length || needForceSave) {
                $('#save-customizer-btn').removeClass('hidden');
            } else {
                $('#save-customizer-btn').addClass('hidden');
            }
        },

        clearCustomizerErrors = function () {
            var $panel = $('#customizer-panel');
            $panel.find('.section-wrapper.has-error,.control-wrapper.has-error').removeClass('has-error');
            $panel.find('.section-wrapper.has-error > img,.control-wrapper.has-error > img').attr('data-error', null);
        },

        clearCustomizerUnsaved = function () {
            var $panel = $('#customizer-panel');
            $panel.find('.section-wrapper.unsaved,.control-wrapper.unsaved').removeClass('unsaved');
        },

        collectCustomizerData = function () {
            var sections = $('#customizer-panel').find('.section-wrapper');
            var result = {},
                priorityStep = 10,
                sectionPriority = priorityStep;

            _.each(sections, function (sectionWrapper) {
                var sectionData = $(sectionWrapper).find('img').attr('data-settings'),
                    sectionUid = $(sectionWrapper).find('img').attr('id');

                sectionData = _.isUndefined(sectionData) || sectionData == '' ? {} : $.parseJSON(sectionData);

                sectionData.priority = sectionPriority;
                sectionPriority += priorityStep;

                sectionData.controls = {};
                var controlPriority = priorityStep,
                    controls = $(sectionWrapper).find('.control-wrapper');

                _.each(controls, function (controlWrapper) {
                    var controlData = $(controlWrapper).find('img').attr('data-settings'),
                        controlUid = $(controlWrapper).find('img').attr('id');

                    controlData = _.isUndefined(controlData) || controlData == '' ? {} : $.parseJSON(controlData);

                    controlData.priority = controlPriority;
                    controlPriority += priorityStep;

                    sectionData.controls[controlUid] = controlData;
                });

                result[sectionUid] = sectionData;
            });

            return result;
        },

        saveCustomizer = function () {
            var customizerData = collectCustomizerData();

            $('#save-customizer-btn').niftyOverlay('show');

            clearCustomizerErrors();
            clearSelected();

            $.post('/template/customizer?id=' + templateId, {data: JSON.stringify(customizerData)}, function (res) {
                if (res.success) {
                    needForceSave = false;
                    TgAlert.success('Customizer', 'All settings was successfully saved');
                    loadCustomizer(res.success);
                } else if (res.error) {
                    if (res.error.section) {
                        _.each(res.error.section, function (data, id) {
                            var $section = $('#' + id);
                            $section.attr('data-error', JSON.stringify(data));
                            $section.parent().removeClass('unsaved').addClass('has-error');
                        });
                    }
                    if (res.error.control) {
                        _.each(res.error.control, function (data, id) {
                            var $control = $('#' + id);
                            $control.attr('data-error', JSON.stringify(data));
                            $control.parent().removeClass('unsaved').addClass('has-error');
                        });
                    }
                    TgAlert.error('Customizer Error', 'Customizer has errors. Please fix its before saving');
                } else {
                    TgAlert.error('Error', JSON.stringify(res));
                }
            }, 'json')
                .fail(function (res) {
                    showError(res);
                })
                .always(function () {
                    $('#save-customizer-btn').niftyOverlay('hide');
                });
        },

        removeBlock = function() {
            bootbox.confirm("Are you sure? This Block and his setting will be removed", function (result) {
                if (result) {
                    $.post('/template/remove', {id: templateId}, function () {
                        TgAlert.success('Success', 'Block was successfully removed');
                        setTimeout(function () {
                            window.location.href = '/template';
                        }, 1000);
                    })
                        .fail(function (res) {
                            showError(res);
                        });
                }
            });
        };

    return {
        init: function () {
            storage = TgCustomizerObj.init(templateId);

            initEditable();

            $('#load-customizer-btn')
                .niftyOverlay()
                .on('click', function () {
                    loadControls();
                })
                .trigger('click');

            $(window).bind('customizerChanged', function () {
                customizerChanged();
            });

            $('#save-customizer-btn')
                .on('click', function () {
                    saveCustomizer();
                });

            $('#remove-block')
                .on('click', function () {
                    removeBlock();
                });
        }
    };
}(jQuery));
