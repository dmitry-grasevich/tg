var TgAlert = library(function ($) {
    var autoClose = true,
        typeIcons = {
            info: 'bolt',
            success: 'check',
            danger: 'exclamation',
            warning: 'fire',
            purple: 'flash'
        };

    function callNotify (type, title, message) {
        $.niftyNoty({
            type: type,
            icon: 'fa fa-' + typeIcons[type],
            container: 'floating',
            title: title,
            message: message,
            timer: autoClose ? 3000 : 0
        });
    }

    return {
        init: function () {
        },
        success: function (title, message) {
            callNotify('success', title, message);
        },
        error: function (title, message) {
            callNotify('danger', title, message);
        },
        warning: function (title, message) {
            callNotify('warning', title, message);
        },
        purple: function (title, message) {
            callNotify('purple', title, message);
        }
    };
}(jQuery));