var TgCustomizer = library(function ($) {
    var sectionWidth = 297,
        controlWidth = 270;

    function initDraggable (sortable_id) {
        $('#aside').find('.list-group').each(function () {
            var $self = $(this);
            $(this).draggable({
                helper: function (ev) {
                    var $img = $self.find('img'),
                        imgSrc = $img.attr('src'),
                        controlId = $img.attr('data-id'),
                        controlName = $img.attr('data-name'),
                        type = $img.attr('data-type'),
                        dragWidth = img.parent().is('li') ? fullWidth : thumbWidth;
                    return $('<div class="draggable-li" style="width: ' + dragWidth + 'px;" />')
                        .append($('<img src="' + imgSrc + '" width="' + dragWidth + 'px" data-fullimg="' + fullSrc + '" data-id="' + templateId + '" />'));
                },
                revert: 'invalid',
                appendTo: 'body',
                connectToSortable: sortable_id,
                stop: function () {
                    //  $('.draggable-li').remove();
                },
                start: function () {
                }
            });
        });
    }

    function initSortable (el) {
        el.sortable({
            revert: true,
            placeholder: 'drop-hover',
            containment: 'document',
            beforeStop: function (event, ui) {
                var img = ui.helper.find('img'),
                    templateId = img.data('id'),
                    fullSrc = img.data('fullimg');
                ui.item.removeAttr('style').html($('<img src="' + fullSrc + '" width="' + fullWidth + 'px" data-fullimg="' + fullSrc + '" data-id="' + templateId + '" />'));
                ui.item.addClass('ui-sortable-handle');
            },
            stop: function() {
                updateHistory();
            }
        });
        el.disableSelection();
    }

    function initDroppable (el) {
        el.droppable({
            accept: function (el) { return el.hasClass('ui-sortable-handle'); },
            activeClass: 'ui-state-hover',
            hoverClass: 'ui-state-active',
            tolerance: 'touch',
            greedy: true,
            drop: function(ev, ui) {
                dropBlock(ui.draggable);
            }
        });
    }

    return {
        init: function () {
            initSortable($('#sortable'));
            initDraggable('#sortable');
            initDroppable($('#droppable'));
        },
        success: function (title, message) {
        },
        error: function (title, message) {
        }
    };
}(jQuery));