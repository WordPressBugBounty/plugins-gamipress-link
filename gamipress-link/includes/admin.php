<?php
/**
 * Admin
 *
 * @package GamiPress\Link\Admin
 * @since 1.0.3
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Link automatic updates
 *
 * @since  1.0.3
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_link_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-link'] = __( 'GamiPress - Link', 'gamipress-link' );

    return $automatic_updates_plugins;
}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_link_automatic_updates' );