jQuery(function ($) {
    $( document ).ready(function() {
        if ($('.set_custom_images').length > 0) {
            if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
                $('.set_custom_images').on('click', function(e) {
                    e.preventDefault();
                    var ids = $('input[type="hidden"][name="prixz-modules-slider-image-ids"]');


                    var custom_uploader = wp.media({
                        title: 'Select images for the slider',
                        button: {
                            text: 'Use these images'
                        },
                        multiple: 'add'
                    });

                    custom_uploader.on('select', function() {
                        var attachments = custom_uploader.state().get('selection').toJSON();
                        var attachment_ids = [];
                        var image_prev = $('#slider_images_preview');

                        $.each(attachments, function(index, attachment) {
                            attachment_ids.push(attachment.id);
                            image_prev.append('<div class="slider_image"><img src="' + attachment.sizes.thumbnail.url + '" alt="" /></div>');
                        });

                        ids.val(JSON.stringify(attachment_ids));
                    });

                    custom_uploader.open();
                    return false;
                });
            }
        }
    });
});
