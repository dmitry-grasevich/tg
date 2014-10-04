var initDraggable = function(sortable_id) {
    $('.menu-item').each(function () {
        var self = $(this);
        $(this).draggable({
            helper: function () {
                var img = self.find('img'),
                    imgSrc = img.attr('src'),
                    templateId = img.data('id'),
                    fullSrc = imgSrc.replace('thumbs', 'full');
                return $('<div class="draggable-li" style="width: 294px;">' +
                    '<img src="' + imgSrc + '" width="294px" data-fullimg="' + fullSrc + '" data-id="' + templateId + '" />' +
                    '</div>'
                );
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
        //revert: true,
        placeholder: "drop-hover",
        beforeStop: function (event, ui) {
            var img = ui.helper.find('img'),
                templateId = img.data('id'),
                fullSrc = img.data('fullimg');
            ui.item.find('a').parent().html($('<img src="' + fullSrc + '" width="1200px" data-fullimg="' + fullSrc + '" data-id="' + templateId + '" />'));
            updateHistory();
        }
        //stop: function () {
        //
        //},
        //over: function () {
        //
        //}
    });
};

var initScrollbars = function() {
    $('.items-list').perfectScrollbar({ suppressScrollX: true });
    $('.project-container').perfectScrollbar({ suppressScrollX: true });
    $(window).resize(function() {
        $('.items-list').perfectScrollbar('update');
        $('.project-container').perfectScrollbar('update');
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
    initDraggable('#sortable');
    initSortable($('#sortable'));
    initScrollbars();
});