<?php
/**
 * RESPOND BOX
 *
 * This displays the comment response controls. The response form itself is included separately to keep both this file
 * and the response form as clean and simple as possible.
 */
?>
<div id="respond">

 
    <div id="cancel-comment-reply">
        <small><?php cancel_comment_reply_link() ?></small>
    </div>

    <?php
	// Not authenticated: Prompt login
    if( get_option( 'comment_registration' ) && !is_user_logged_in() ) {

        printf( '<p>%s</p>',
            sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'lumen-ambient' ),
                wp_login_url( get_permalink() )
            )
        );

    }
    
    // Authenticated: Show form
    else {
        include 'response-form.php';
    }
    ?>
</div>