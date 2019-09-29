jQuery(document).ready(function ($) {

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
});