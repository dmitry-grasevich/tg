var TgCustomizer = library(function ($) {
    var
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
                        $result = $result.append($('<img src="' + imgSrc + '" data-id="' + controlId + '" ' +
                            'data-name="' + controlName + '" data-type="' + type + '" />'));

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
                        $sortable = $('<a href="#" class="' + type + '-wrapper" data-id="' + controlId + '" />');

                    if (type != 'section') {
                        $sortable = $sortable
                            .append($('<div class="text-lg control-label">' + controlName + '</div>'));
                    }
                    $sortable = $sortable
                        .append($('<img src="' + imgSrc + '" data-id="' + controlId + '"' +
                            'data-name="' + controlName + '" data-type="' + type + '" />'));

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

                    initControlsSortable($('.controls-sortable'));
                }
            }).disableSelection();
        },

        initDroppable = function (el) {
            el.droppable({
                accept: function (el) {
                    return el.hasClass('ui-sortable-handle');
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

        initEditable = function () {
            $(document).on('click', '.section-wrapper', function (e) {
                e.preventDefault();
            });
        },

        dropBlock = function (el) {
            el.remove();
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