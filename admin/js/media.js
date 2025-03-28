jQuery(function ($) {
    $( document ).ready(function() {
        // Handle first time loading.
        var sliderImageIds = $('input[type="hidden"][name="prixz-modules-slider-image-ids"]').val();
        if (sliderImageIds !== "" && sliderImageIds !== "[]") {
            var ids = JSON.parse(sliderImageIds);
            var image_prev = $('#slider_images_preview');
            
            $.each(ids, function(index, id) {
                /* This might not work properly if the file name has special characters, slashes, etc.
                * @see https://core.trac.wordpress.org/ticket/41445
                * @see https://github.com/WP-API/WP-API/issues/2596
                * @todo: Fix this issue. A workaround might be to add a new endpoint to the REST API
                * that returns the thumbnail URL based on the ID.
                */
                $.ajax({
                    url: wpApiSettings.root + 'wp/v2/media/' + id,
                    type: 'GET',
                    dataType: 'json',
                    async: false,
                    success: function(data) {
                        image_prev.append(get_image_html(id, data.media_details.sizes.thumbnail.source_url));
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error retrieving image:', textStatus, errorThrown);
                    }
                });
            });
        }

        // Handle the image selector
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
                        $('#slider_images_preview').empty();
                        var attachments = custom_uploader.state().get('selection').toJSON();
                        var attachment_ids = [];
                        var image_prev = $('#slider_images_preview');

                        $.each(attachments, function(index, attachment) {
                            attachment_ids.push(attachment.id);
                            image_prev.append(get_image_html(attachment.id, attachment.sizes.thumbnail.url));
                        });

                        ids.val(JSON.stringify(attachment_ids));
                    });

                    custom_uploader.open();
                    return false;
                });
            }
        }

        // Handle image removal
        $(document).on('click', '.slider_image_close', function() {
            $(this).parent('.slider_image').remove();
            var ids = $('input[type="hidden"][name="prixz-modules-slider-image-ids"]');
            var attachment_ids = [];

            $('#slider_images_preview .slider_image img').each(function() {
                attachment_ids.push($(this).parent().data('id'));
            });

            ids.val(JSON.stringify(attachment_ids));
        });

        // Handle image sorting
        $('#slider_images_preview').sortable({
            items: '.slider_image',
            update: function(event, ui) {
                var ids = $('input[type="hidden"][name="prixz-modules-slider-image-ids"]');
                var attachment_ids = [];

                $('#slider_images_preview .slider_image img').each(function() {
                    attachment_ids.push($(this).parent().data('id'));
                });

                ids.val(JSON.stringify(attachment_ids));
            }
        });

        // Retrieve the image item html structure
        function get_image_html(id, thumbnail_url) {
            return '<div class="slider_image"'
                + ' data-id="' + id + '"'
                +'><img src="'
                + thumbnail_url
                + '" alt="" /><span class="slider_image_close">x</span></div>';
        }
    });
});
