<?php
/**
 * Requirements
 *
 * @package GamiPress\Link\Requirements
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Add the link fields to the requirement object
 *
 * @param $requirement
 * @param $requirement_id
 *
 * @return array
 */
function gamipress_link_requirement_object( $requirement, $requirement_id ) {

    if( isset( $requirement['trigger_type'] ) ) {

        if( $requirement['trigger_type'] === 'gamipress_specific_url_link_click'
            || $requirement['trigger_type'] === 'gamipress_user_specific_url_link_click' ) {

            // The link url
            $requirement['link_url'] = gamipress_get_post_meta( $requirement_id, '_gamipress_link_url', true );

        }

        if( $requirement['trigger_type'] === 'gamipress_specific_id_link_click'
            || $requirement['trigger_type'] === 'gamipress_user_specific_id_link_click' ) {

            // The link id
            $requirement['link_id'] = gamipress_get_post_meta( $requirement_id, '_gamipress_link_id', true );

        }

        if( $requirement['trigger_type'] === 'gamipress_specific_class_link_click'
            || $requirement['trigger_type'] === 'gamipress_user_specific_class_link_click' ) {

            // The link class
            $requirement['link_class'] = gamipress_get_post_meta( $requirement_id, '_gamipress_link_class', true );

        }
    }

    return $requirement;
}
add_filter( 'gamipress_requirement_object', 'gamipress_link_requirement_object', 10, 2 );

/**
 * Link fields on requirements UI
 *
 * @param $requirement_id
 * @param $post_id
 */
function gamipress_link_requirement_ui_fields( $requirement_id, $post_id ) {

    $link_url = gamipress_get_post_meta( $requirement_id, '_gamipress_link_url', true );
    $link_id = gamipress_get_post_meta( $requirement_id, '_gamipress_link_id', true );
    $link_class = gamipress_get_post_meta( $requirement_id, '_gamipress_link_class', true ); ?>

    <input type="text" name="link_url" class="input-link-url" value="<?php echo $link_url; ?>" placeholder="http://example.com">
    <input type="text" name="link_id" class="input-link-id" value="<?php echo $link_id; ?>" placeholder="<?php echo __( 'Link id attribute', 'gamipress-link' ); ?>">
    <input type="text" name="link_class" class="input-link-class" value="<?php echo $link_class; ?>" placeholder="<?php echo __( 'Link class attribute', 'gamipress-link' ); ?>">

    <?php
}
add_action( 'gamipress_requirement_ui_html_after_achievement_post', 'gamipress_link_requirement_ui_fields', 10, 2 );

/**
 * Custom handler to save the link fields on requirements UI
 *
 * @param $requirement_id
 * @param $requirement
 */
function gamipress_link_ajax_update_requirement( $requirement_id, $requirement ) {

    if( isset( $requirement['trigger_type'] ) ) {

        if( $requirement['trigger_type'] === 'gamipress_specific_url_link_click'
            || $requirement['trigger_type'] === 'gamipress_user_specific_url_link_click' ) {

            // The link url
            update_post_meta( $requirement_id, '_gamipress_link_url', $requirement['link_url'] );
        }

        if( $requirement['trigger_type'] === 'gamipress_specific_id_link_click'
            || $requirement['trigger_type'] === 'gamipress_user_specific_id_link_click' ) {

            // The link id
            update_post_meta( $requirement_id, '_gamipress_link_id', $requirement['link_id'] );

        }

        if( $requirement['trigger_type'] === 'gamipress_specific_class_link_click'
            || $requirement['trigger_type'] === 'gamipress_user_specific_class_link_click' ) {

            // The link class
            update_post_meta( $requirement_id, '_gamipress_link_class', $requirement['link_class'] );

        }
    }
}
add_action( 'gamipress_ajax_update_requirement', 'gamipress_link_ajax_update_requirement', 10, 2 );

/**
 * Shortcode preview on requirements UI
 *
 * @since 1.0.0
 *
 * @param integer $requirement_id
 * @param integer $post_id
 */
function gamipress_link_shortcode_preview( $requirement_id, $post_id ) {
    $shortcode = GamiPress()->shortcodes['gamipress_link'];
    ?>
    <div class="gamipress-link-shortcode-preview" style="margin-top: 5px;">
        <label for="gamipress-link-shortcode-<?php echo $requirement_id; ?>"><?php _e( 'Code:', 'gamipress-link' ); ?></label>
        <input type="text" id="gamipress-link-shortcode-<?php echo $requirement_id; ?>" class="gamipress-link-shortcode" value="[gamipress_link]" readonly style="width: 400px;"/>
        <a href="#" style="display: block;margin-top: 5px;" onclick="jQuery(this).next().slideToggle('fast');return false;"><?php _e( 'See shortcode attributes', 'gamipress-link' ); ?></a>
        <ul style="display: none; list-style: disc; margin-left: 20px; margin-top: 5px;">
            <?php echo gamipress_shortcode_help_render_fields( $shortcode->fields ); ?>
        </ul>
    </div>
    <?php
}
add_action( 'gamipress_requirement_ui_html_after_requirement_title', 'gamipress_link_shortcode_preview', 10, 2 );