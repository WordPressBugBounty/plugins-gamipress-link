<?php
/**
 * GamiPress Link Shortcode
 *
 * @package     GamiPress\Shortcodes\Shortcode\GamiPress_Link
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register the [gamipress_link] shortcode.
 *
 * @since 1.0.0
 */
function gamipress_register_link_shortcode() {
    gamipress_register_shortcode( 'gamipress_link', array(
        'name'            => __( 'Link', 'gamipress' ),
        'description'     => __( 'Render a link.', 'gamipress' ),
        'output_callback' => 'gamipress_link_shortcode',
        'fields'      => array(
            'href' => array(
                'name'        => __( 'URL', 'gamipress' ),
                'description' => __( 'The link URL.', 'gamipress-link' ),
                'type' 	=> 'text',
            ),
            'label' => array(
                'name'        => __( 'Label', 'gamipress' ),
                'description' => __( 'The link label text.', 'gamipress-link' ),
                'type' 	=> 'text',
            ),
            'id' => array(
                'name'        => __( 'Link ID', 'gamipress' ),
                'description' => __( 'The link identifier.', 'gamipress-link' ),
                'type'        => 'text',
            ),
            'class' => array(
                'name'        => __( 'CSS Classes', 'gamipress' ),
                'description' => __( 'The link CSS classes.', 'gamipress-link' ),
                'type'        => 'text',
            ),
            'target' => array(
                'name'        => __( 'Link Target', 'gamipress' ),
                'description' => __( 'The link target attribute. The target attribute specifies where to open the linked page.', 'gamipress-link' ),
                'type' 	=> 'select',
                'options' => array(
                    '_self' => __( 'Same page (self)', 'gamipress-link' ),
                    '_blank' => __( 'New tab (blank)', 'gamipress-link' ),
                    '_parent' => __( 'Parent page (parent)', 'gamipress-link' ),
                    '_top' => __( 'Top page (top)', 'gamipress-link' ),
                ),
                'default' => '_self'
            ),
            'title' => array(
                'name'        => __( 'Link Title', 'gamipress' ),
                'description' => __( 'The link title attribute.', 'gamipress-link' ),
                'type'        => 'text',
            ),
        ),
    ) );
}
add_action( 'init', 'gamipress_register_link_shortcode' );

/**
 * Link Shortcode.
 *
 * @since  1.0.0
 *
 * @param  array $atts Shortcode attributes.
 * @return string 	   HTML markup.
 */
function gamipress_link_shortcode( $atts = array() ) {

    global $post, $comment;

    // Get the received shortcode attributes
    $atts = shortcode_atts( array(
        'href'      => '',
        'label'     => '',
        'id'        => '',
        'class'     => '',
        'target'    => '_self',
        'title'     => ''
    ), $atts, 'gamipress_link' );

    $post_id = ( $post ? $post->ID : 0 );
    $comment_id = ( $comment ? $comment->comment_ID : 0 );

    gamipress_link_enqueue_scripts();

    ob_start(); ?>
        <a href="<?php echo esc_url( esc_attr( $atts['href'] ) ); ?>"
           id="<?php echo esc_attr( $atts['id'] ); ?>"
           class="gamipress-link <?php echo esc_attr( $atts['class'] ); ?>"
           target="<?php echo esc_attr( $atts['target'] ); ?>"
           title="<?php echo esc_attr( $atts['title'] ); ?>"
           data-post="<?php echo $post_id; ?>"
           data-comment="<?php echo $comment_id; ?>"
        ><?php echo esc_html( $atts['label'] ); ?></a>
    <?php $output = ob_get_clean();

    // Return our rendered link
    return $output;
}
