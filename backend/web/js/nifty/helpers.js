var updateFormErrors = function(form_id, model, errors, skipCleanForm) {
        if (!skipCleanForm) {
            // clean form errors
            cleanFormErrors(form_id);
        }

        // add new errors
        var form = $('#' + form_id);
        $.each(errors, function(attr, field_errors) {
            var form_group = form.find('.field-' + model + '-' + attr);
            form_group.addClass('has-error');

            $.each(field_errors, function(idx, error) {
                form_group.find('.help-block').append(error + '<br />');
            });
        });
    },

    setFormErrors = function(model, errors) {
        $.each(errors[0], function(id, fields_error) {
            $.each(fields_error, function(field, errors) {
                var form_group = $('.field-' + model + '-' + id +  '-' + field);
                form_group.addClass('has-error');
                $.each(errors, function(idx, error) {
                    form_group.find('.help-block').append(error + '<br />');
                });

            });
        });
    },

    cleanFormErrors = function(form_id) {
        var form = $('#' + form_id),
            errorFields = form.find('.has-error');

        errorFields.removeClass('has-error');
        form.find('.help-block-error').html('');
        form.find('.help-block').html('');
    },

    reInitMetisMenu = function() {
        var $menu = $('#mainnav-menu');
        $menu.removeData('mm');
        $menu.metisMenu();
    };
