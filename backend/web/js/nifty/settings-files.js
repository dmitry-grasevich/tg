$(document).ready(function () {
    function switchToEdit (el) {
        el.addClass('hidden');
        el.parent().find('.cancel-btn,.save-btn,.remove-btn').removeClass('hidden');

        var id = el.data('id');
        $('#view-' + id).addClass('hidden');
        $('#edit-' + id).removeClass('hidden');
    }

    function switchToView (el) {
        el.parent().find('.cancel-btn,.save-btn,.remove-btn').addClass('hidden');
        el.parent().find('.edit-btn').removeClass('hidden');

        var id = el.data('id');
        $('#edit-' + id).addClass('hidden');
        $('#view-' + id).removeClass('hidden');
    }

    function initHighlighting () {
        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
        $('pre.scroll').perfectScrollbar({ suppressScrollX: true });
    }

    function progressHandlingFunction (e) {
        if(e.lengthComputable){
            $('.progress-bar').css('width', e.loaded + '%');
        }
    }

    function initProgressBar () {
        $('.progress').removeClass('hidden');
        $('.progress-bar').css('width', '0%');
    }

    $(document).on('click', '.edit-btn', function (e) {
        e.preventDefault();
        switchToEdit($(this));
    });

    $(document).on('click', '.cancel-btn', function (e) {
        e.preventDefault();
        switchToView($(this));
    });

    $(document).on('click', '.save-btn', function (e) {
        e.preventDefault();

        var self = $(this),
            id = self.data('id'),
            isCommon = $('#isCommon').val(),
            isRemovable = $('#isRemovable').val();

        if (self.data('name') == 'screenshot') { // ajax file upload
            var formData = new FormData($('#form-' + id)[0]);
            $.ajax({
                url: '/settings/screenshot',  //Server script to process data
                type: 'POST',
                xhr: function() {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if(myXhr.upload){ // Check if upload property exists
                        // For handling the progress of the upload
                        myXhr.upload.addEventListener('progress', progressHandlingFunction, false);
                    }
                    return myXhr;
                },
                beforeSend: function () { initProgressBar(); },
                //Ajax events
                success: function (res) {
                    $('#view-' + id).html(res);
                    switchToView(self);
                    initHighlighting();
                    TgAlert.success('Common File', 'Screenshot was successfully updated');
                },
                error: function (res) { showError(res); },
                always: function() { $('.progress').addClass('hidden'); },
                // Form data
                data: formData,
                //Options to tell jQuery not to process data or worry about content-type.
                cache: false,
                contentType: false,
                processData: false
            });
        } else {    // post simple form
            $.post('/settings/save', $('#form-' + id).serialize() + '&isRemovable=' + isRemovable + '&isCommon=' + isCommon, function (res) {
                if (res.success) {
                    $('#panel-' + id).parent().replaceWith(res.success);
                    switchToView(self);
                    initHighlighting();
                    TgAlert.success('Files', 'File was successfully saved');
                } else if (res.errors) {
                    updateFormErrors('form-' + id, 'file', res.errors);
                }
            }, 'json')
            .fail(function (res) {
                showError(res);
            });
        }
    });

    $(document).on('click', '.remove-btn', function (e) {
        e.preventDefault();

        var self = $(this),
            id = self.data('id');

        $.post('/settings/remove', {id: id}, function () {
            $('#panel-' + id).parent().remove();
            TgAlert.success('Files', 'File was successfully removed');
        })
        .fail(function (res) {
            showError(res);
        });
    });

    $(document).on('click', '#add-file', function (e) {
        e.preventDefault();

        var time = new Date().getTime(),
            isCommon = $('#isCommon').val();

        $.get('/settings/file-panel', {id: 'new-' + time, isCommon: isCommon, isRemovable: 0}, function (res) {
            $('#page-content > div').append(res);
        })
        .fail(function (res) {
            showError(res);
        });
    });

    initHighlighting();
});