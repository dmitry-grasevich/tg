function makeDraggable(sortable_id) {
    $('.menu-item').each(function () {
        var self = $(this);
        $(this).draggable({
            helper: function () {
                var imgSrc = self.find('img').attr('src'),
                    fullSrc = imgSrc.replace('thumbs', 'full');
                return $('<div class="draggable-li" style="width: 294px;"><img src="' + imgSrc + '" width="294px" data-fullimg="' + fullSrc + '" /></div>');
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
}

function makeSortable(el) {
    el.sortable({
        //revert: true,
        placeholder: "drop-hover",
        beforeStop: function (event, ui) {
            var fullSrc = ui.helper.find('img').data('fullimg');
            ui.item.find('a').parent().html($('<img src="' + fullSrc + '" width="1200px" data-fullimg="' + fullSrc + '" />'));
        }
        //stop: function () {
        //
        //},
        //over: function () {
        //
        //}
    });
}

$(function () {
    makeDraggable('#sortable');
    makeSortable($('#sortable'));
});