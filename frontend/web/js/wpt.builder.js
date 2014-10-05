var thumbWidth = 294,
    fullWidth = 1200;

var initDraggable = function(sortable_id) {
    $('.menu-item').each(function () {
        var self = $(this);
        $(this).draggable({
            helper: function (ev) {
                var img = self.find('img'),
                    imgSrc = img.attr('src'),
                    templateId = img.data('id'),
                    fullSrc = imgSrc.replace('thumbs', 'full'),
                    dragWidth = img.parent().is('li') ? fullWidth : thumbWidth;
                return $('<div class="draggable-li" style="width: ' + dragWidth + 'px;" />')
                    .append($('<img src="' + imgSrc + '" width="' + dragWidth + 'px" data-fullimg="' + fullSrc + '" data-id="' + templateId + '" />'));
            },
            revert: 'invalid',
            appendTo: 'body',
            connectToSortable: sortable_id,
            stop: function () {
                $('.draggable-li').remove();
            },
            start: function () {
            }
        });
    });
};

var initSortable = function(el) {
    el.sortable({
        revert: true,
        placeholder: 'drop-hover',
        containment: 'document',
        beforeStop: function (event, ui) {
            var img = ui.helper.find('img'),
                templateId = img.data('id'),
                fullSrc = img.data('fullimg');
            ui.item.find('a').parent().html($('<img src="' + fullSrc + '" width="' + fullWidth + 'px" data-fullimg="' + fullSrc + '" data-id="' + templateId + '" />'));
            ui.item.addClass('ui-sortable-handle');
        },
        stop: function() {
           updateHistory();
        }
    });
    el.disableSelection();
};

var initDroppable = function(el) {
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
};

var dropBlock = function(el) {
    el.remove();
    updateHistory();
};

var initScrollbars = function() {
    $('.items-list').perfectScrollbar({ suppressScrollX: true });
    $('#main_container').perfectScrollbar({ suppressScrollX: true });
    $(window).resize(function() {
        $('.items-list').perfectScrollbar('update');
        $('#main_container').perfectScrollbar('update');
    });
};

var updateHistory = function() {
    var templates = $('#sortable').find('img'),
        ids = [];
    for (var i = 0; i < templates.length; i++) {
        ids.push($(templates[i]).data('id'));
    }
    var url = ids.join('-');
    History.pushState(null, null, '?t=' + url);
};

$(function () {
    initSortable($('#sortable'));
    initDraggable('#sortable');
    initDroppable($('#droppable'));
    initScrollbars();
});