var TgCustomizer = library(function ($) {
    var jqxhr = null,

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
                            type = $img.data('type');

                        var $result = $('<div class="draggable-el" style="width: auto" />');
                        if (type != 'section') {
                            $result = $result.append($('<div class="text-lg" style="padding: 3px;">' + controlName + '</div>'));
                        }

                        var $dragImg = $('<img src="' + imgSrc + '" />');

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
                        type = $img.data('type'),
                        $sortable = $('<a href="#" class="' + type + '-wrapper" />');

                    if (!!controlId) {
                        $sortable.attr('data-id', controlId);
                    }

                    if (type != 'section') {
                        $sortable = $sortable
                            .append($('<div class="text-lg control-label">' + controlName + '</div>'));
                    }

                    var $newImg = $('<img src="' + imgSrc + '" data-toggle="panel-overlay" data-target="#settings-wrapper" />');

                    if (!!controlId) {
                        $newImg.attr('data-id', controlId);
                    }
                    if (!!controlName) {
                        $newImg.attr('data-name', controlName);
                    }
                    if (!!type) {
                        $newImg.attr('data-type', type);
                    }

                    $sortable = $sortable.append($newImg);

                    if (type == 'section') {
                        var $controls = ui.helper.find('.controls-sortable');
                        if (!$controls.length) {
                            $controls = $('<div class="controls-sortable"></div>');
                        }
                        $sortable = $sortable.append($controls);
                    }

                    ui.item
                        .removeAttr('style')
                        .addClass('ui-sortable-handle')
                        .removeClass('draggable-el')
                        .html($sortable);

                    $newImg.niftyOverlay();
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
                    highlightSelectedControl($(this));
                    loadSettings($(this).find('img'));
                } else {
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
                tid = $('#tid').val(),
                params = {type: type, tid: tid};

            if (!!id) {
                params.id = id;
            }

            $el.niftyOverlay('show');

            jqxhr = $.get('/control/settings', params, function (res) {
                $('#setting-helper').addClass('hidden');
                $('#settings-container').html(res);
            })
                .fail(function (res) {
                    var json = res.responseJSON;
                    TgAlert.error(json.name, json.message);
                })
                .always(function () {
                    $el.niftyOverlay('hide');
                });
        };

    return {
        init: function () {
            initSectionsDraggable('.sections-sortable');
            initControlsDraggable('.controls-sortable');
            initSectionsSortable($('.sections-sortable'));
            initDroppable($('#droppable'));
            initEditable();
        }
    };
}(jQuery));