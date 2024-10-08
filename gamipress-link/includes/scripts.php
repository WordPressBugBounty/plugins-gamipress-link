<?php
/**
 * Scripts
 *
 * @package     GamiPress\Link\Scripts
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register frontend scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_link_register_scripts() {

    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Scripts
    wp_register_script( 'gamipress-link-js', GAMIPRESS_LINK_URL . 'assets/js/gamipress-link' . $suffix . '.js', array( 'jquery' ), GAMIPRESS_LINK_VER, true );

}
add_action( 'init', 'gamipress_link_register_scripts' );

/**
 * Enqueue frontend scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_link_enqueue_scripts( $hook = null ) {

    // Bail if this script has been already enqueued
    if( wp_script_is( 'gamipress-link-js', 'enqueued' ) ) return;

    // Scripts
    wp_localize_script( 'gamipress-link-js', 'gamipress_link', array(
        'ajaxurl' => esc_url( admin_url( 'admin-ajax.php', 'relative' ) ),
        'nonce' => wp_create_nonce( 'gamipress_link' )
    ) );

    wp_enqueue_script( 'gamipress-link-js' );

}
add_action( 'wp_enqueue_scripts', 'gamipress_link_enqueue_scripts', 100 );

/**
 * Register admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_link_admin_register_scripts() {
    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Scripts
    wp_register_script( 'gamipress-link-admin-js', GAMIPRESS_LINK_URL . 'assets/js/gamipress-link-admin' . $suffix . '.js', array( 'jquery' ), GAMIPRESS_LINK_VER, true );

}
add_action( 'admin_init', 'gamipress_link_admin_register_scripts' );

/**
 * Enqueue admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_link_admin_enqueue_scripts( $hook ) {

    global $post_type;

    $allowed_post_types = array_merge( gamipress_get_achievement_types_slugs(), gamipress_get_rank_types_slugs() );

    // Requirements ui script
    if ( $post_type === 'points-type' || in_array( $post_type, $allowed_post_types ) ) {
        wp_enqueue_script( 'gamipress-link-admin-js' );
    }

}
add_action( 'admin_enqueue_scripts', 'gamipress_link_admin_enqueue_scripts', 100 );