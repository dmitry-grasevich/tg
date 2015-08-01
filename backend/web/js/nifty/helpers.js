function library(module) {
    $(function () {
        if (module.init) {
            module.init();
        }
    });
    return module;
}

var updateFormErrors = function (form_id, model, errors, skipCleanForm) {
        if (!skipCleanForm) {
            // clean form errors
            cleanFormErrors(form_id);
        }

        // add new errors
        var form = $('#' + form_id);
        $.each(errors, function (attr, field_errors) {
            var form_group = form.find('.field-' + model + '-' + attr);
            form_group.addClass('has-error');

            $.each(field_errors, function (idx, error) {
                form_group.find('.help-block').append(error + '<br />');
            });
        });
    },

    setFormErrors = function (model, errors) {
        $.each(errors[0], function (id, fields_error) {
            $.each(fields_error, function (field, errors) {
                var form_group = $('.field-' + model + '-' + id + '-' + field);
                form_group.addClass('has-error');
                $.each(errors, function (idx, error) {
                    form_group.find('.help-block').append(error + '<br />');
                });

            });
        });
    },

    cleanFormErrors = function (form_id) {
        var form = $('#' + form_id),
            errorFields = form.find('.has-error');

        errorFields.removeClass('has-error');
        form.find('.help-block-error').html('');
        form.find('.help-block').html('');
    },

    reInitMetisMenu = function () {
        var $menu = $('#mainnav-menu');
        $menu.removeData('mm');
        $menu.metisMenu();
    },

    showError = function (res) {
        if (!!res.responseJSON) {
            TgAlert.error(res.responseJSON.name, res.responseJSON.message);
        } else if (!!res.status && res.status != 200) {
            TgAlert.error(res.statusText, res.responseText);
        } else if (!!res.status && res.status == 200) {
            TgAlert.success(res.statusText, res.responseText);
        } else {
            TgAlert.error('Error', res);
        }
    };
