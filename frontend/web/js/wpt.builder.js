function makeDraggable(sortable_id) {
    $('.menu-item').each(function () {
        var self = $(this);
        $(this).draggable({
            helper: function () {
                var imgSrc = self.find('img').attr('src');
                return $('<div class="draggable-li"><img src="' + imgSrc + '" width="294px" /></div>');
            },
            revert: 'invalid',
            appendTo: 'body',
            connectToSortable: sortable_id,
            stop: function () {
                //pageEmpty();
                //allEmpty();
                $('.draggable-li').remove();
            },
            start: function () {
                //switch to block mode
                //$('input:radio[name=mode]').parent().addClass('disabled');
                //$('input:radio[name=mode]#modeBlock').radio('check');

                //show all iframe covers and activate designMode
                $('#pageList ul .zoomer-wrapper .zoomer-cover').each(function () {
                    $(this).show();
                });

                //deactivate designmode
                $('#pageList ul li iframe').each(function () {
                    this.contentDocument.designMode = "off";
                });
            }
        });
    });

    $('#elements li a').each(function () {
        $(this).unbind('click').bind('click', function (e) {
            e.preventDefault();
        })
    })
}

function makeSortable(el) {
    el.sortable({
        revert: true,
        placeholder: "drop-hover",
        beforeStop: function (event, ui) {
            //alert( ui.item.find('iframe').attr('src') )
            if (ui.item.find('.zoomer-cover > button').size() == 0) {
                var theHeight;
                if (ui.item.find('iframe').size() > 0) {
                    theHeight = ui.item.height() / 0.25 * 0.8;
                    var attr = ui.item.find('iframe').attr('sandbox');

                    var sandbox = typeof attr !== typeof undefined && attr !== false ? ' sandbox="allow-same-origin"' : '';
                    ui.item.html('<iframe src="' + ui.item.find('iframe').attr('src') + '" scrolling="no"' + sandbox + '><iframe>');

                    ui.item.find('iframe').uniqueId();
                    ui.item.find('iframe').zoomer({
                        zoom: 0.8,
                        width: $('#screen').width(),
                        height: theHeight
                    });

                    //remove the link if it excists
                    ui.item.find('.zoomer-cover a').remove();
                    ui.item.find('.zoomer-cover').text('');
                } else {
                    theHeight = ui.item.find('img').attr('data-height') * 0.8;

                    ui.item.html('<iframe src="' + ui.item.find('img').attr('data-src') + '" scrolling="no" frameborder="0"><iframe>');

                    ui.item.find('iframe').uniqueId();
                    ui.item.find('iframe').zoomer({
                        zoom: 0.8,
                        width: $('#screen').width(),
                        height: theHeight,
                        message: "Drag&Drop Me!"
                    });

                    ui.item.find('iframe').load(function () {
                        heightAdjustment(ui.item.find('iframe').attr('id'), true);
                    });

                    //remove the link if it excists
                    ui.item.find('.zoomer-cover a').remove();
                }

                //add a delete button
                var delButton = $('<button type="button" class="btn btn-danger deleteBlock"><span class="fui-trash"></span> remove</button>');
                var resetButton = $('<button type="button" class="btn btn-warning resetBlock"><i class="fa fa-refresh"></i> reset</button>');

                ui.item.find('.zoomer-cover')
                    .append(delButton)
                    .append($('<div style="clear:both; height:0">'))
                    .append(resetButton);
            }
        },
        stop: function () {
            $('#pageList ul:visible li').each(function () {
                $(this).find('.zoomer-cover > a').remove();
            });
        },
        over: function () {
            $('#start').hide();
        }
    });
}

$(function () {
    makeDraggable();
});