<?php
/**
 * Triggers
 *
 * @package GamiPress\Link\Triggers
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register plugin activity triggers
 *
 * @since  1.0.0
 *
 * @param array $activity_triggers
 * @return mixed
 */
function gamipress_link_activity_triggers( $activity_triggers ) {

    $activity_triggers[__( 'Link', 'gamipress-link' )] = array(

        // Triggers to the "clicker"
        'gamipress_link_click' 		                    => __( 'Click any link', 'gamipress-link' ),
        'gamipress_specific_url_link_click'  		    => __( 'Click a link with a specific URL', 'gamipress-link' ),
        'gamipress_specific_id_link_click'  		    => __( 'Click a link with a specific identifier', 'gamipress-link' ),
        'gamipress_specific_class_link_click'  		    => __( 'Click a link with a specific CSS class', 'gamipress-link' ),

        // Triggers to the post author that receives clicks
        'gamipress_user_link_click' 		            => __( 'Get a click on any link', 'gamipress-link' ),
        'gamipress_user_specific_url_link_click'  		=> __( 'Get a click on a link with a specific URL', 'gamipress-link' ),
        'gamipress_user_specific_id_link_click'  		=> __( 'Get a click on a link with a specific identifier', 'gamipress-link' ),
        'gamipress_user_specific_class_link_click'  	=> __( 'Get a click on a link with a specific CSS class', 'gamipress-link' ),

    );

    return $activity_triggers;

}
add_filter( 'gamipress_activity_triggers', 'gamipress_link_activity_triggers' );

/**
 * Build custom activity trigger label
 *
 * @since  1.0.0
 *
 * @param string    $title
 * @param integer   $requirement_id
 * @param array     $requirement
 *
 * @return string
 */
function gamipress_link_activity_trigger_label( $title, $requirement_id, $requirement ) {

    $link_url = ( isset( $requirement['link_url'] ) ) ? $requirement['link_url'] : '';
    $link_id = ( isset( $requirement['link_id'] ) ) ? $requirement['link_id'] : '';
    $link_class = ( isset( $requirement['link_class'] ) ) ? $requirement['link_class'] : '';

    switch( $requirement['trigger_type'] ) {

        case 'gamipress_specific_url_link_click':
            return sprintf( __( 'Click a link with the URL %s', 'gamipress-link' ), $link_url );
            break;
        case 'gamipress_specific_id_link_click':
            return sprintf( __( 'Click a link with the identifier %s', 'gamipress-link' ), $link_id );
            break;
        case 'gamipress_specific_class_link_click':
            return sprintf( __( 'Click a link of class %s', 'gamipress-link' ), $link_class );
            break;

        case 'gamipress_user_specific_url_link_click':
            return sprintf( __( 'Get a click on a link with the URL %s', 'gamipress-link' ), $link_url );
            break;
        case 'gamipress_user_specific_id_link_click':
            return sprintf( __( 'Get a click on a link with the identifier %s', 'gamipress-link' ), $link_id );
            break;
        case 'gamipress_user_specific_class_link_click':
            return sprintf( __( 'Get a click on a link of class %s', 'gamipress-link' ), $link_class );
            break;

    }

    return $title;
}
add_filter( 'gamipress_activity_trigger_label', 'gamipress_link_activity_trigger_label', 10, 3 );

/**
 * Get user for a given trigger action.
 *
 * @since  1.0.0
 *
 * @param  integer $user_id user ID to override.
 * @param  string  $trigger Trigger name.
 * @param  array   $args    Passed trigger args.
 *
 * @return integer          User ID.
 */
function gamipress_link_trigger_get_user_id( $user_id, $trigger, $args ) {

    switch ( $trigger ) {

        case 'gamipress_link_click':
        case 'gamipress_specific_url_link_click':
        case 'gamipress_specific_id_link_click':
        case 'gamipress_specific_class_link_click':

        case 'gamipress_user_link_click':
        case 'gamipress_user_specific_url_link_click':
        case 'gamipress_user_specific_id_link_click':
        case 'gamipress_user_specific_class_link_click':
            $user_id = $args[0];
            break;

    }

    return $user_id;

}
add_filter( 'gamipress_trigger_get_user_id', 'gamipress_link_trigger_get_user_id', 10, 3 );