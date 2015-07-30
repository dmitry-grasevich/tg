$(document).ready(function () {
    $(document).on('click', '#save-block-btn', function (e) {
        e.preventDefault();

        var formId = 'block-form',
            modelClass = 'category';

        $.post('/category/save', $('#' + formId).serialize(), function(res) {
            if (res.success) {
                $('#block-list').html(res.success);
                $('.add-tooltip').tooltip();
                $('#block-modal').modal('hide');
                reInitMetisMenu();
                TgAlert.success('Yoohooo!', 'Block Category was successfully saved');
            } else if (res.errors) {
                updateFormErrors(formId, modelClass, res.errors);
                TgAlert.error('Form save error', 'Please, check your form');
            }
        }, 'json');
    });

    $(document).on('click', '#delete-block-btn', function (e) {
        e.preventDefault();

        bootbox.confirm('Are you really want to delete this Block Category?', function(result) {
            if (result) {
                removeCategory();
            }
        });
    });

    $('#block-modal').on('show.bs.modal', function (e) {
        var modal = $(this),
            button = $(e.relatedTarget);

        cleanFormErrors('block-form');

        modal.find('.modal-title').text(button.attr('data-title'));
        modal.find('#category-id').val(button.attr('data-id'));
        modal.find('#category-name').val(button.attr('data-name'));
        modal.find('#category-alias').val(button.attr('data-alias'));
        modal.find('#category-is_visible').prop('checked', button.attr('data-visible') == 1);

        if (button.attr('data-id')) {
            $('#delete-block-btn').removeClass('hidden');
        } else {
            $('#delete-block-btn').addClass('hidden');
        }
    });

    function removeCategory () {
        var catId = $('#block-modal').find('#category-id').val();

        $.post('/category/remove', { id: catId }, function(res) {
            if (res.success) {
                $('#block-list').html(res.success);
                $('.add-tooltip').tooltip();
                $('#block-modal').modal('hide');
                reInitMetisMenu();
                TgAlert.success('Yeah!', 'Block Category was successfully removed');
            } else if (res.error) {
                TgAlert.error('Can\'t remove a Block Category', res.error);
            }
        }, 'json');
    }
});