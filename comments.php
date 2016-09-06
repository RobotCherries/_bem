<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _bem
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area _comments"> 
	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title _comments__title">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', '_bem' ) ),
					number_format_i18n( get_comments_number() ),
					'<span class="_comments__post-title">' . get_the_title() . '</span>'
				);
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation _comments__nav" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', '_bem' ); ?></h2>
			<div class="nav-links _comments__nav-links">

				<div class="nav-previous _comments__nav-link _comments__nav-link--previous"><?php previous_comments_link( esc_html__( 'Older Comments', '_bem' ) ); ?></div>
				<div class="nav-next _comments__nav-link _comments__nav-link--next"><?php next_comments_link( esc_html__( 'Newer Comments', '_bem' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<div class="comment-list _comments__list">
			<?php
				wp_list_comments( array(
					'style'      => 'div',
					'short_ping' => true,
					'callback'	 => '_bem_comments',
				) );
			?>
		</div><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation _comments__nav" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', '_bem' ); ?></h2>
			<div class="nav-links _comments__nav-links">

				<div class="nav-previous _comments__nav-link _comments__nav-link--previous"><?php previous_comments_link( esc_html__( 'Older Comments', '_bem' ) ); ?></div>
				<div class="nav-next _comments__nav-link _comments__nav-link--next"><?php next_comments_link( esc_html__( 'Newer Comments', '_bem' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments _comments__no-comment"><?php esc_html_e( 'Comments are closed.', '_bem' ); ?></p>
	<?php
	endif;

  $fields =  array(
    'author' =>
      '<p class="comment-form-author _comments__field"><label for="author" class="_comments__field-label">' . __( 'Name', '_bem' ) . '</label> ' .
      ( $req ? '<span class="required _comments__field-required">*</span>' : '' ) .
      '<input class="_comments__field-input _comments__field-input--name" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
      '" size="30"' . $aria_req . ' /></p>',

    'email' =>
      '<p class="comment-form-email _comments__field"><label for="email" class="_comments__field-label">' . __( 'Email', '_bem' ) . '</label> ' .
      ( $req ? '<span class="required _comments__field-required">*</span>' : '' ) .
      '<input class="_comments__field-input _comments__field-input--email" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
      '" size="30"' . $aria_req . ' /></p>',

    'url' =>
      '<p class="comment-form-url _comments__field"><label for="url" class="_comments__field-label">' . __( 'Website', '_bem' ) . '</label>' .
      '<input class="_comments__field-input _comments__field-input--website" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
      '" size="30" /></p>',
  );

  comment_form(array(
    'id_form' => 'commentform',
    'class_form' => 'comment-form _comments__form',
    'id_submit' => 'submit',
    'class_submit' => 'submit _comments__form-submit',
    'name_submit' => 'submit',
    'title_reply' => __( 'Leave a Reply', '_bem' ),
    'title_reply_to' => __( 'Leave a Reply to %s', '_bem' ),
    'cancel_reply_link' => __( 'Cancel Reply', '_bem' ),
    'label_submit' => __( 'Post Comment', '_bem' ),
    'format' => 'xhtml',
    'comment_field' =>  '<p class="comment-form-comment _comments__field"><label for="comment" class="_comments__field-label">' . _x( 'Comment', 'noun' ) .
      '</label><textarea class="_comments__field-input _comments__field-input--comment" id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
      '</textarea></p>',
    'must_log_in' => '<p class="must-log-in _comments__warning _comments__warning--not-logged-in">' .
      sprintf(
        __( 'You must be <a href="%s">logged in</a> to post a comment.', '_bem' ),
        wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
      ) . '</p>',

    'logged_in_as' => '<p class="logged-in-as _comments__user">' .
      sprintf(
      __( 'Logged in as <a href="%1$s" class="_comments__user-name">%2$s</a>. <a href="%3$s" class="_comments__logout-link" title="Log out of this account">Log out?</a>', '_bem' ),
        admin_url( 'profile.php' ),
        $user_identity,
        wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
      ) . '</p>',

    'comment_notes_before' => '<p class="comment-notes _comments__notes">' .
      __( 'Your email address will not be published.', '_bem' ) . ( $req ? $required_text : '' ) .
      '</p>',

    'comment_notes_after' => '<p class="form-allowed-tags _comments__notes">' .
      sprintf(
        __( 'You may use these HTML tags and attributes: %s', '_bem' ),
        ' <code class="_comments__notes-code">' . allowed_tags() . '</code>'
      ) . '</p>',

    'fields' => apply_filters( 'comment_form_default_fields', $fields ),
  ));
  
  #comment_form(array(
	#	'class_form' => '_comments__form',
	#	'class_submit' => '_comments__form-submit'
	#));
	?>

</div><!-- #comments -->
