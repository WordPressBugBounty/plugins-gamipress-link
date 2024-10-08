<?php
/**
 * Ajax Functions
 *
 * @package     GamiPress\Link\Ajax_Functions
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Link click listener
 */
function gamipress_ajax_link_click() {
    // Security check, forces to die if not security passed
    check_ajax_referer( 'gamipress_link', 'nonce' );

    $events_triggered = array();

    // Setup var
    $user_id    = get_current_user_id();
    $url        = isset( $_POST['url'] )    ? sanitize_text_field( $_POST['url'] ) : '';
    $id         = isset( $_POST['id'] )     ? sanitize_text_field( $_POST['id'] ) : '';
    $class      = isset( $_POST['class'] )  ? sanitize_text_field( $_POST['class'] ) : '';
    $post_id    = isset( $_POST['post'] )   ? absint( $_POST['post'] ) : 0;
    $comment_id = isset( $_POST['comment'] ) ? absint( $_POST['comment'] ) : 0;

    // Trigger link click action
    do_action( 'gamipress_link_click', (int) $user_id, $url, $id, $class );
    $events_triggered['gamipress_link_click'] = array( (int) $user_id, $url, $id, $class );

    // Trigger specific url link click action
    if( ! empty( $url ) ) {
        do_action( 'gamipress_specific_url_link_click', (int) $user_id, $url, $id, $class );
        $events_triggered['gamipress_specific_url_link_click'] = array( (int) $user_id, $url, $id, $class );
    }

    // Trigger specific id link click action
    if( ! empty( $id ) ) {
        do_action( 'gamipress_specific_id_link_click', (int) $user_id, $url, $id, $class );
        $events_triggered['gamipress_specific_id_link_click'] = array( (int) $user_id, $url, $id, $class );
    }

    // Trigger specific class link click action
    if( ! empty( $class ) ) {
        do_action( 'gamipress_specific_class_link_click', (int) $user_id, $url, $id, $class );
        $events_triggered['gamipress_specific_class_link_click'] = array( (int) $user_id, $url, $id, $class );
    }

    // If we are in a comment, award the author for receive clicks
    $comment = get_comment( $comment_id );

    // If we are in a post/page, award the author for receive clicks
    $post = get_post( $post_id );

    $author_id = 0;

    if( $comment && absint( $comment->user_id ) !== 0 ) {
        // Award to the comment author
        $author_id = absint( $comment->user_id );
    } else if( $post && absint( $post->post_author ) !== 0 ) {
        // Award to the post author
        $author_id = absint( $post->post_author );
    }

    if( $author_id !== 0 ) {

        // Trigger link click action to the post/comment author
        do_action( 'gamipress_user_link_click', $author_id, $url, $id, $class, $user_id );
        $events_triggered['gamipress_user_link_click'] = array( $author_id, $url, $id, $class, $user_id );

        // Trigger specific url link click action to the post/comment author
        if( ! empty( $url ) ) {
            do_action( 'gamipress_user_specific_url_link_click', $author_id, $url, $id, $class, $user_id );
            $events_triggered['gamipress_user_specific_url_link_click'] = array( $author_id, $url, $id, $class, $user_id );
        }

        // Trigger specific id link click action to the post/comment author
        if( ! empty( $id ) ) {
            do_action( 'gamipress_user_specific_id_link_click', $author_id, $url, $id, $class, $user_id );
            $events_triggered['gamipress_user_specific_id_link_click'] = array( $author_id, $url, $id, $class, $user_id );
        }

        // Trigger specific class link click action to the post/comment author
        if( ! empty( $class ) ) {
            do_action( 'gamipress_user_specific_class_link_click', $author_id, $url, $id, $class, $user_id );
            $events_triggered['gamipress_user_specific_class_link_click'] = array( $author_id, $url, $id, $class, $user_id );
        }

    }

    wp_send_json_success( $events_triggered );
    exit;
}
add_action( 'wp_ajax_gamipress_link_click', 'gamipress_ajax_link_click' );
add_action( 'wp_ajax_nopriv_gamipress_link_click', 'gamipress_ajax_link_click' );