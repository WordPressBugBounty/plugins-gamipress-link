(function( $ ) {

    $('body').on('click', '.gamipress-link', function( e ) {

        // Setup vars
        var $this = $(this);
        var href = $this.attr('href');
        var id = $this.attr('id');
        var classes = $this.attr('class');
        var post = $this.data('post');
        var comment = $this.data('comment');

        // Default href attribute
        if( href === undefined )
            href = '';

        $.ajax({
            url: gamipress_link.ajaxurl,
            method: 'POST',
            data: {
                action: 'gamipress_link_click',
                nonce: gamipress_link.nonce,
                url: href,
                id: id,
                class: classes,
                post: post,
                comment: comment
            },
            success: function( response ) {

            }
        });
    });

})( jQuery );