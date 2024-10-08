<?php
/**
 * Logs
 *
 * @package GamiPress\Link\Logs
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Extended meta data for event trigger logging
 *
 * @since 1.0.6
 *
 * @param array 	$log_meta
 * @param integer 	$user_id
 * @param string 	$trigger
 * @param integer 	$site_id
 * @param array 	$args
 *
 * @return array
 */
function gamipress_link_log_event_trigger_meta_data( $log_meta, $user_id, $trigger, $site_id, $args ) {

    switch ( $trigger ) {
        case 'gamipress_link_click':
        case 'gamipress_specific_url_link_click':
        case 'gamipress_specific_id_link_click':
        case 'gamipress_specific_class_link_click':
            // Add the link URL, id and class
            $log_meta['link_url'] = $args[1];
            $log_meta['link_id'] = $args[2];
            $log_meta['link_class'] = $args[3];
            break;

        case 'gamipress_user_link_click':
        case 'gamipress_user_specific_url_link_click':
        case 'gamipress_user_specific_id_link_click':
        case 'gamipress_user_specific_class_link_click':
            // Add the link URL, id, class and clicker
            $log_meta['link_url'] = $args[1];
            $log_meta['link_id'] = $args[2];
            $log_meta['link_class'] = $args[3];
            $log_meta['clicker_id'] = $args[4]; // User that perform the click
            break;
    }

    return $log_meta;
}
add_filter( 'gamipress_log_event_trigger_meta_data', 'gamipress_link_log_event_trigger_meta_data', 10, 5 );

/**
 * Override the meta data to filter the logs count
 *
 * @since   1.0.6
 *
 * @param  array    $log_meta       The meta data to filter the logs count
 * @param  int      $user_id        The given user's ID
 * @param  string   $trigger        The given trigger we're checking
 * @param  int      $since 	        The since timestamp where retrieve the logs
 * @param  int      $site_id        The desired Site ID to check
 * @param  array    $args           The triggered args or requirement object
 *
 * @return array                    The meta data to filter the logs count
 */
function gamipress_link_get_user_trigger_count_log_meta( $log_meta, $user_id, $trigger, $since, $site_id, $args ) {

    switch( $trigger ) {

        // Specific URL
        case 'gamipress_specific_url_link_click':
        case 'gamipress_user_specific_url_link_click':
            // Add the link URL
            if( isset( $args[1] ))
                $log_meta['link_url'] = $args[1];

            // $args could be a requirement object
            if( isset( $args['link_url'] ) )
                $log_meta['link_url'] = $args['link_url'];
            break;

        // Specific id
        case 'gamipress_specific_id_link_click':
        case 'gamipress_user_specific_id_link_click':
            // Add the link id
            if( isset( $args[2] ))
                $log_meta['link_id'] = $args[2];

            // $args could be a requirement object
            if( isset( $args['link_id'] ) )
                $log_meta['link_id'] = $args['link_id'];
            break;

        // Specific class
        case 'gamipress_specific_class_link_click':
        case 'gamipress_user_specific_class_link_click':
            // Add the link class
            if( isset( $args[3] ))
                $link_class = $args[3];

            // $args could be a requirement object
            if( isset( $args['link_class'] ) )
                $link_class = $args['link_class'];

            // Since there are many classes, let's to add a log meta LIKE check per class
            if( isset( $link_class ) ) {
                $classes = explode( ' ', $link_class );

                foreach( $classes as $class ) {
                    $log_meta['link_class_' . $class] = array(
                        'key' => 'link_class',
                        'value' => '%' . $class . '%',
                        'compare' => 'LIKE',
                    );
                }
            }
            break;
    }

    return $log_meta;

}
add_filter( 'gamipress_get_user_trigger_count_log_meta', 'gamipress_link_get_user_trigger_count_log_meta', 10, 6 );

/**
 * Extra data fields
 *
 * @since 1.0.6
 *
 * @param array     $fields
 * @param int       $log_id
 * @param string    $type
 *
 * @return array
 */
function gamipress_link_log_extra_data_fields( $fields, $log_id, $type ) {

    $prefix = '_gamipress_';

    $log = ct_get_object( $log_id );
    $trigger = $log->trigger_type;

    if( $type !== 'event_trigger' ) {
        return $fields;
    }

    switch( $trigger ) {
        case 'gamipress_link_click':
        case 'gamipress_specific_url_link_click':
        case 'gamipress_specific_id_link_click':
        case 'gamipress_specific_class_link_click':
            // URL
            $fields[] = array(
                'name' 	            => __( 'Link URL', 'gamipress-link' ),
                'desc' 	            => __( 'Link URL user clicked.', 'gamipress-link' ),
                'id'   	            => $prefix . 'link_url',
                'type' 	            => 'text',
            );

            // id
            $fields[] = array(
                'name' 	            => __( 'Link identifier', 'gamipress-link' ),
                'desc' 	            => __( 'Link id attribute user clicked.', 'gamipress-link' ),
                'id'   	            => $prefix . 'link_id',
                'type' 	            => 'text',
            );

            // Class
            $fields[] = array(
                'name' 	            => __( 'Link CSS classes', 'gamipress-link' ),
                'desc' 	            => __( 'Link class attribute user clicked.', 'gamipress-link' ),
                'id'   	            => $prefix . 'link_class',
                'type' 	            => 'text',
            );
            break;
        case 'gamipress_user_link_click':
        case 'gamipress_user_specific_url_link_click':
        case 'gamipress_user_specific_id_link_click':
        case 'gamipress_user_specific_class_link_click':
            // URL
            $fields[] = array(
                'name' 	            => __( 'Link URL', 'gamipress-link' ),
                'desc' 	            => __( 'Link URL user clicked.', 'gamipress-link' ),
                'id'   	            => $prefix . 'link_url',
                'type' 	            => 'text',
            );

            // id
            $fields[] = array(
                'name' 	            => __( 'Link identifier', 'gamipress-link' ),
                'desc' 	            => __( 'Link id attribute user clicked.', 'gamipress-link' ),
                'id'   	            => $prefix . 'link_id',
                'type' 	            => 'text',
            );

            // Class
            $fields[] = array(
                'name' 	            => __( 'Link CSS classes', 'gamipress-link' ),
                'desc' 	            => __( 'Link class attribute user clicked.', 'gamipress-link' ),
                'id'   	            => $prefix . 'link_class',
                'type' 	            => 'text',
            );

            // Clicker
            $clicker_id = ct_get_object_meta( $log_id, $prefix . 'clicker_id', true );
            $clicker = get_userdata( $clicker_id );

            if( $clicker ) {
                $fields[] = array(
                    'name' 	            => __( 'Clicker', 'gamipress-link' ),
                    'desc' 	            => __( 'User that perform the click.', 'gamipress-link' ),
                    'id'   	            => $prefix . 'clicker_id',
                    'type' 	            => 'select',
                    'options'           => array(
                        $clicker_id => $clicker->display_name . ' (#' . $clicker_id . ')'
                    )
                );
            }
            break;
    }

    return $fields;

}
add_filter( 'gamipress_log_extra_data_fields', 'gamipress_link_log_extra_data_fields', 10, 3 );