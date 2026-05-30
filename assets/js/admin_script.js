jQuery(function($){
    $('body').on('click', '.aw_upload_image_button', function(e){
        e.preventDefault();

        // aw_uploader = wp.media({
        let aw_uploader = wp.media({
            title: 'Location image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = aw_uploader.state().get('selection').first().toJSON();

            $('#cat-image').val(attachment.url);
        }).open();
    });


    var mediaUploader;
    // Support different button/field markup used by service meta boxes.
    $(document).on('click', '#service_meta_icon_button, .service_meta_icon_upload, .upload-service-meta-icon, #service_meta_icon, button[id*="service_meta_icon"], input[type="button"][id*="service_meta_icon"], .upload_image_button, .rwmb-file-input', function(e) {
        var $trigger = $(this);

        // If this is a text input, allow normal editing and skip uploader.
        if ($trigger.is('input[type="text"], input[type="url"], textarea')) {
            return;
        }

        e.preventDefault();

        if (typeof wp === 'undefined' || !wp.media) {
            return;
        }

        var $targetInput = $trigger.closest('td, .inside, .form-field, .field, .rwmb-field')
            .find('input[name="service_meta_icon"], #service_meta_icon')
            .first();

        if (!$targetInput.length) {
            $targetInput = $('input[name="service_meta_icon"], #service_meta_icon').first();
        }

        mediaUploader = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Select'
            },
            multiple: false,
            library: {
                type: 'image'
            }
        });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $targetInput.val(attachment.url).trigger('change');
        });

        mediaUploader.open();
    });

    var mediaUploaderButtonIcon;
    $(document).on('click', '#service_meta_button_icon, input[type="button"][id="service_meta_button_icon"]', function(e) {
        var $trigger = $(this);

        if ($trigger.is('input[type="text"], input[type="url"], textarea')) {
            return;
        }

        e.preventDefault();

        if (typeof wp === 'undefined' || !wp.media) {
            return;
        }

        var $targetInput = $trigger.closest('td, .inside, .form-field, .field')
            .find('input[name="service_meta_button_icon"]')
            .first();

        if (!$targetInput.length) {
            $targetInput = $('input[name="service_meta_button_icon"]').first();
        }

        mediaUploaderButtonIcon = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Select'
            },
            multiple: false,
            library: {
                type: 'image'
            }
        });

        mediaUploaderButtonIcon.on('select', function() {
            var attachment = mediaUploaderButtonIcon.state().get('selection').first().toJSON();
            $targetInput.val(attachment.url).trigger('change');
        });

        mediaUploaderButtonIcon.open();
    });

});
