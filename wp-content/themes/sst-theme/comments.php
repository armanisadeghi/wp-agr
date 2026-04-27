<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.2.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
	<!-- COMMENTS AREA  -->
	<div id="comments" class="comments-area">
		<?php if ( have_comments() ) : ?>
			<h2 class="comments-title">
				<?php
				printf(
					_n( 'Comments (1)', ' Comments (%1$s) ', get_comments_number(), 'ultimate_holidays' ),
					number_format_i18n( get_comments_number() ), get_the_title()
				);
				?>
			</h2>
			<ol class="comment-list">
				<?php
				wp_list_comments(
					[
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 70,
					]
				);
				?>
			</ol>
		<?php endif; ?>
	</div><!-- comments-area ends -->
<?php
$comment_args = [
	'title_reply'          => 'Post a comment',
	'id_form'              => 'comment-respond-form',

	'fields'               => apply_filters(
		'comment_form_default_fields', [
			'author' => '<div class="form-group col-xs-6">' . '<label for="author" class="hidden">' . __( 'Full Name' ) . '</label> ' . ( $req ? '<span>*</span>' : '' ) .
							'<input id="author" name="author" class="input-md form-control" placeholder="Full Name" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" ' . ( $req ? 'required' : '' ) . ' /></div>',
			'email'  => '<div class="form-group col-xs-6">' .
							'<label for="email">' . __( 'Email Address' ) . '</label> ' .
							( $req ? '<span>*</span>' : '' ) .
							'<input id="email" name="email" type="text" class="input-md form-control" placeholder="Email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" ' . ( $req ? 'required' : '' ) . ' />' . '</div>',
			'url'    => '',
		]
	),
	'comment_field'        => '<div class="form-group">' .
							  '<label for="comment">' . __( 'Let us know what you have to say:' ) . '</label>' .
							  '<textarea name="comment" id="comment" cols="30" rows="4" class="form-control" placeholder="Message"></textarea>' .
							  '</div>',
	'comment_notes_after'  => '',
	'comment_notes_before' => '',
	'class_submit'         => 'button primary',
	'label_submit'         => 'Submit',
];
comment_form( $comment_args ); ?>
