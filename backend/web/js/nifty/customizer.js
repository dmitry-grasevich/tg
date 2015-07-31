var TgCustomizer = library(function ($) {
    var sectionWidth = 297,
        controlWidth = 270;

    function initSectionsDraggable(id) {
        initDraggable(id, '.list-group.section');
    }

    function initControlsDraggable(id) {
        initDraggable(id, '.list-group.control');
    }

    function initDraggable(sortable_id, selector) {
        $('#aside').find(selector).each(function () {
            var $self = $(this);
            $(this).draggable({
                helper: function () {
                    var $img = $self.find('img'),
                        imgSrc = $img.attr('src'),
                        controlId = $img.attr('data-id'),
                        controlName = $img.attr('data-name'),
                        type = $img.attr('data-type'),
                        dragWidth = type == 'section' ? sectionWidth : controlWidth;

                    var $result = $('<div class="draggable-el" style="width: ' + dragWidth + 'px;" />');
                    if (type != 'section') {
                        $result = $result.append($('<div class="text-lg" style="padding: 3px;">' + controlName + '</div>'));
                    }
                    $result = $result.append($('<img src="' + imgSrc + '" width="' + dragWidth + 'px" data-id="' + controlId + '" ' +
                        'data-name="' + controlName + '" data-type="' + type + '" />'));

                    return $result;
                },
                revert: 'invalid',
                appendTo: 'body',
                connectToSortable: sortable_id,
                stop: function () {
                    //$('.draggable-el').remove();
                },
                start: function () {
                }
            });
        });
    }

    function initSectionsSortable(el) {
        initSortable(el);
    }

    function initControlsSortable(el) {
        initSortable(el);
    }

    function initSortable(el) {
        el.sortable({
            revert: true,
            placeholder: 'drop-hover',
            containment: 'document',
            beforeStop: function (event, ui) {
                var $img = ui.helper.find('img'),
                    controlId = $img.attr('data-id'),
                    imgSrc = $img.attr('src'),
                    controlName = $img.attr('data-name'),
                    type = $img.attr('data-type'),
                    fullWidth = type == 'section' ? sectionWidth : controlWidth,
                    $sortable = $('<a href="#" class="' + type + '-wrapper" data-id="' + controlId + '" />');

                if (type != 'section') {
                    $sortable = $sortable
                        .append($('<div class="text-lg control-label">' + controlName + '</div>'));
                }
                $sortable = $sortable
                    .append($('<img src="' + imgSrc + '" width="' + fullWidth + 'px" data-id="' + controlId + '"' +
                        'data-name="' + controlName + '" data-type="' + type + '" />'));

                if (type == 'section') {
                    $sortable = $sortable
                        .append($('<div class="controls-sortable"></div>'));
                }

                ui.item
                    .removeAttr('style')
                    .addClass('ui-sortable-handle')
                    .removeClass('draggable-el')
                    .html($sortable);

                initControlsSortable($('.controls-sortable'));
            },
            stop: function () {}
        });
        el.disableSelection();
    }

    function initDroppable(el) {
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
    }

    function initEditable() {
        $(document).on('click', '.section-wrapper', function(e) {
            e.preventDefault();
        });
    }

    return {
        init: function () {
            initSectionsDraggable('.sections-sortable');
            initControlsDraggable('.controls-sortable');
            initSectionsSortable($('.sections-sortable'));
            //initDroppable($('#droppable'));
            initEditable();
        }
    };
}(jQuery));