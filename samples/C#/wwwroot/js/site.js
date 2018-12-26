
jQuery(document).ready(function ($) {

    // Set initial height of result-container
    $('.result-container').height($('.result-content').height());

    // Buttons event listeners
    $('.btn-action').click(function () {
        // API key
        var apiUrl = $('#APIUrl').val();

        if (apiUrl === '') {
            showResult('No API url is provided');
            return;
        }

        var data = {
            APIUrl: apiUrl,
            Action: $(this).data('action'),
        };

        $.post({
            url: '/',
            data: JSON.stringify(data),
            contentType: 'application/json',
        })
        .always(function (response) {
            showResult(response);
        });
    });

    function showResult(obj) {
        // Result container and content references
        $rContainer = $('.result-container');
        $rContent = $rContainer.find('.result-content');

        $rContent.fadeOut(250, function () {
            $rContent.html($('<pre />', { text: JSON.stringify(obj, null, 2) }));

            $rContainer.animate({ height: $rContent.height() }, 150);
            $rContent.fadeIn(250);
        });
    }
});