(function( $ ) {

    // Listen for our change to our trigger type selectors
    $('.requirements-list').on( 'change', '.select-trigger-type', function() {

        // Grab our selected trigger type
        var trigger_type = $(this).val();
        var url_field = $(this).siblings('.input-link-url');
        var id_field = $(this).siblings('.input-link-id');
        var class_field = $(this).siblings('.input-link-class');

        url_field.hide();
        id_field.hide();
        class_field.hide();

        if( trigger_type === 'gamipress_specific_url_link_click'
            || trigger_type === 'gamipress_user_specific_url_link_click' ) {
            url_field.show();
        }

        if( trigger_type === 'gamipress_specific_id_link_click'
            || trigger_type === 'gamipress_user_specific_id_link_click' ) {
            id_field.show();
        }

        if( trigger_type === 'gamipress_specific_class_link_click'
            || trigger_type === 'gamipress_user_specific_class_link_click' ) {
            class_field.show();
        }

        gamipress_link_update_shortcode_preview( $(this).closest('.requirement-row') );

    });

    // Loop requirement list items to show/hide inputs on initial load
    $('.requirements-list li').each(function() {

        // Grab our selected trigger type
        var trigger_type = $(this).find('.select-trigger-type').val();
        var url_field = $(this).find('.input-link-url');
        var id_field = $(this).find('.input-link-id');
        var class_field = $(this).find('.input-link-class');

        url_field.hide();
        id_field.hide();
        class_field.hide();

        if( trigger_type === 'gamipress_specific_url_link_click'
            || trigger_type === 'gamipress_user_specific_url_link_click' ) {
            url_field.show();
        }

        if( trigger_type === 'gamipress_specific_id_link_click'
            || trigger_type === 'gamipress_user_specific_id_link_click' ) {
            id_field.show();
        }

        if( trigger_type === 'gamipress_specific_class_link_click'
            || trigger_type === 'gamipress_user_specific_class_link_click' ) {
            class_field.show();
        }

        gamipress_link_update_shortcode_preview( $(this) );

    });

    $('.requirements-list').on( 'update_requirement_data', '.requirement-row', function(e, requirement_details, requirement) {

        if( requirement_details.trigger_type === 'gamipress_specific_url_link_click'
            || requirement_details.trigger_type === 'gamipress_user_specific_url_link_click' ) {
            requirement_details.link_url = requirement.find( '.input-link-url' ).val();
        }

        if( requirement_details.trigger_type === 'gamipress_specific_id_link_click'
            || requirement_details.trigger_type === 'gamipress_user_specific_id_link_click' ) {
            requirement_details.link_id = requirement.find( '.input-link-id' ).val();
        }

        if( requirement_details.trigger_type === 'gamipress_specific_class_link_click'
            || requirement_details.trigger_type === 'gamipress_user_specific_class_link_click' ) {
            requirement_details.link_class = requirement.find( '.input-link-class' ).val();
        }

    });

    // Update shortcode preview on change involved inputs
    $('.requirements-list').on( 'keyup change', '.input-link-url, .input-link-id, .input-link-class', function(e, requirement_details, requirement) {
        gamipress_link_update_shortcode_preview( $(this).closest('.requirement-row') );
    });

    // Update the shortcode preview
    function gamipress_link_update_shortcode_preview( row ) {

        var triggers = [
            'gamipress_link_click',
            'gamipress_specific_url_link_click',
            'gamipress_specific_id_link_click',
            'gamipress_specific_class_link_click',
            'gamipress_user_link_click',
            'gamipress_user_specific_url_link_click',
            'gamipress_user_specific_id_link_click',
            'gamipress_user_specific_class_link_click',
        ];

        var trigger_type = row.find('.select-trigger-type').val();
        var url_field = row.find('.input-link-url');
        var id_field = row.find('.input-link-id');
        var class_field = row.find('.input-link-class');
        var preview = row.find('.gamipress-link-shortcode-preview');

        // Hide the shortcode preview
        preview.hide();

        if( triggers.indexOf( trigger_type ) !== -1 ) {

            var shortcode = '[gamipress_link label="Click here!"';

            // Setup specific triggers attributes
            if( trigger_type === 'gamipress_specific_url_link_click'
                || trigger_type === 'gamipress_user_specific_url_link_click' ) {
                shortcode += ' href="' + url_field.val() + '"';
            }

            if( trigger_type === 'gamipress_specific_id_link_click'
                || trigger_type === 'gamipress_user_specific_id_link_click' ) {
                shortcode += ' id="' + id_field.val() + '"';
            }

            if( trigger_type === 'gamipress_specific_class_link_click'
                || trigger_type === 'gamipress_user_specific_class_link_click' ) {
                shortcode += ' class="' + class_field.val() + '"';
            }

            shortcode += ']';

            preview.find('.gamipress-link-shortcode').val(shortcode);

            // Show the shortcode preview
            preview.show();
        }

    }

})( jQuery );