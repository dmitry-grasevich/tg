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



function getScrollableHeight() {
    var boxOffset = $('.items-list').offset().top;
    var viewportHeight = $(window).height();
    var elementHeight = viewportHeight - boxOffset;

    $('.items-list').css('height', elementHeight);
}

getScrollableHeight();

$(window).resize(function() {
    getScrollableHeight();
});



var initScrollbars = function() {
    $('.items-list').perfectScrollbar({ suppressScrollX: true });
    $('.project-container').perfectScrollbar({ suppressScrollX: true });
    $(window).resize(function() {
        $('.items-list').perfectScrollbar('update');
        $('.project-container').perfectScrollbar('update');
    });
};

var blockList = function() {
    var templates = $('#sortable').find('img'),
        ids = [];
    for (var i = 0; i < templates.length; i++) {
        ids.push($(templates[i]).data('id'));
    }
    return ids;
};

var updateHistory = function() {
    var ids = blockList(),
        url = ids.join('-'),
        t = url != '' ? '?t=' + url : '?';
    History.pushState(null, 'WordPress Template Generator', t);
};

$(function () {
    initSortable($('#sortable'));
    initDraggable('#sortable');
    initDroppable($('#droppable'));
    initScrollbars();

    $('#generateBtn').click(function (e) {
        e.preventDefault();
        var themeName = $('#theme_name').val();
        if (themeName == '') {
            alert('Please enter your Theme Name');
            return false;
        }
        var ids = blockList();
        if (ids.length == 0) {
            alert('Your template has no blocks! Why? Please add one or more.');
            return false;
        }

        $.post('/template', { name: themeName, blocks: ids.join(',') }, function (res) {
            console.log(res);
        });
    });
});