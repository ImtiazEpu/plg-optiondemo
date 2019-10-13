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
    $(document).ready(function () {
        var images_url = $("#opd_images_url").val();
        images_url = images_url ? images_url.split(";") : [];

        for (i in images_url) {
            var _image_url = images_url[i];
            $("#images_container").append(`<img style="margin-left: 10px" src='${_image_url}' />`);
        }

        $("#upload_images").on("click", function () {

            if (mediaUploader) {
                mediaUploader.open();
                return false;
            }

            var mediaUploader = wp.media({
                title: "Select Images",
                button: {
                    text: "Insert Images"
                },
                multiple: true
            });

            mediaUploader.on('select', function () {
                var image_ids = [];
                var image_urls = [];
                var attachments = mediaUploader.state().get('selection').toJSON();
                $("#images_container").html('');
                for (i in attachments) {
                    var attachment = attachments[i];
                    image_ids.push(attachment.id);
                    image_urls.push(attachment.sizes.thumbnail.url);
                    $("#images_container").append(`<img style="margin-right: 10px;" src='${attachment.sizes.thumbnail.url}' />`);

                }
                $("#opd_images_id").val(image_ids.join(";"));
                $("#opd_images_url").val(image_urls.join(";"));

            });


            mediaUploader.open();
            return false;
        });
    });
})(jQuery);

