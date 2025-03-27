jQuery(function ($) {
    $( document ).ready(function() {
        if ($('.set_custom_images').length > 0) {
            if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
                $('.set_custom_images').on('click', function(e) {
                    e.preventDefault();
                    var button = $(this);
                    var ids = button.prev();


                    var custom_uploader = wp.media({
                        title: 'Select images for the slider',
                        button: {
                            text: 'Use these images'
                        },
                        multiple: 'add'
                    });

                    custom_uploader.on('select', function() {
                        var attachments = custom_uploader.state().get('selection').toJSON();
                        var attachmentIds = [];

                        $.each(attachments, function(index, attachment) {
                            attachmentIds.push(attachment.id);
                        });

                        console.log(JSON.stringify(attachments));
                        console.log(JSON.stringify(attachmentIds));

                        ids.val(JSON.stringify(attachmentIds));
                    });

                    custom_uploader.open();
                    return false;
                });
            }
        }
    });
});
