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

});
