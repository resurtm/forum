jQuery(function ($) {

    (function () {
        var rootSection = $('#post-rootsectionid'),
            section = $('#post-section_id');

        rootSection.on('change', function () {
            $.ajax({
                cache: false,
                dataType: 'json',
                url: window[window.appName].sectionChildrenUrl($(this).val()),
                success: function (data) {
                    section
                        .html('')
                        .prop('disabled', Object.keys(data).length === 0);

                    if (Object.keys(data).length > 0) {
                        for (var id in data) {
                            section.append('<option value="' + id + '">' + data[id] + '</option>');
                        }
                    }
                }
            });
        });
    })();

    (function () {
        var newComment = $('#create-new-comment'),
            replyToComment = $('.reply-to-comment'),
            form = $('#comment-create-form'),
            wrapper = form.closest('div');

        newComment.on('click', function (e) {
            e.preventDefault();
            form.detach().appendTo(wrapper);
            form.find('textarea').focus();
            form.find('.parent').val('');
            return false;
        });

        replyToComment.on('click', function (e) {
            e.preventDefault();
            form.detach().appendTo($(this).closest('.well'));
            form.find('textarea').focus();
            form.find('.parent').val($(this).data('parent'));
            return false;
        });
    })();

});
