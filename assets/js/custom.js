;(function ($) {
    $(document).ready(function () {

        $('.optionsdemo-warp').on('click', '.button-primary', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $parent = $this.closest('.optionsdemo-warp');


            var mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                }, multiple: false
            });


            mediaUploader.on('select', function () {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $parent.find('.optionsdemo-input').val(attachment.title);

            });

            mediaUploader.open();
        });

        var $img_url = $("#opd_image_url").val();
        if ($img_url) {
            $("#image_container").html(`<img src='${$img_url}' />`);
        }

        $("#upload_image").on("click", function () {
            if (mediaUploader) {
                mediaUploader.open();
                return false;
            }

            var mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                }, multiple: false
            });

            mediaUploader.on('select', function () {
                var attachment = mediaUploader.state().get('selection').first().toJSON();

                $("#opd_image_id").val(attachment.id);
                $("#opd_image_url").val(attachment.sizes.thumbnail.url);
                $("#image_container").html(`<img src='${attachment.sizes.thumbnail.url}' />`);
            });

            mediaUploader.open();
            return false;
        });

        $('#opd_date').datepicker(
            {
                changeMonth: true,
                changeYear: true
            }
        );
    });
})(jQuery);

