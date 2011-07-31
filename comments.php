<?php function essence_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li>
		<article id="comment-<?php comment_ID(); ?>">
			<header>
				<?php echo get_avatar($comment,$size='32'); ?>

				<?php printf(__('<h3>%s</h3>', THEME_NAME), get_comment_author_link()) ?>

				<time datetime="<?php echo comment_date('c') ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s', THEME_NAME), get_comment_date(),  get_comment_time()) ?></a></time>

				<?php edit_comment_link(__('(Edit)', THEME_NAME), '', '') ?>
			</header>

			<?php if ($comment->comment_approved == '0') : ?>

				<p><?php _e('Your comment is awaiting moderation.', THEME_NAME) ?></p>

			<?php endif; ?>

			<?php comment_text() ?>

			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>

		</article>
<?php } ?>

<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (__('Please do not load this page directly. Thanks!', THEME_NAME));

	if ( post_password_required() ) { ?>
	<section id="comments">
		<p><?php _e('This post is password protected. Enter the password to view comments.', THEME_NAME); ?></p>
	</section>
	<?php
		return;
	}
?>

<?php // You can start editing here. ?>
<?php if ( have_comments() ) : ?>
	<section id="comments">
		<h1><?php comments_number(__('No Responses to', THEME_NAME), __('One Response to', THEME_NAME), __('% Responses to', THEME_NAME) ); ?> &#8220;<?php the_title(); ?>&#8221;</h1>
		<ol><?php wp_list_comments('type=comment&callback=essence_comments'); ?></ol>
		<footer>
			<nav>
				<ul>
					<li><?php previous_comments_link( __( '&larr; Older comments', THEME_NAME ) ); ?></li>
					<li><?php next_comments_link( __( 'Newer comments &rarr;', THEME_NAME ) ); ?></li>
				</ul>
			</nav>
		</footer>
	</section>
<?php else : // this is displayed if there are no comments so far ?>
	<?php if ( comments_open() ) : ?>
	<?php else : // comments are closed ?>
	<section id="comments">
		<p><?php _e('Comments are closed.', THEME_NAME) ?></p>
	</section>
	<?php endif; ?>
<?php endif; ?>
<?php if ( comments_open() ) : ?>
<section id="respond">
	<h1><?php comment_form_title( __('Comment on this post', THEME_NAME), __('Leave a reply to %s', THEME_NAME) ); ?></h1>
	<p><?php cancel_comment_reply_link(); ?></p>
	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
	<p><?php printf( __('You must be <a href="%s">logged in</a> to post a comment.', THEME_NAME), wp_login_url( get_permalink() ) ); ?></p>
	<?php else : ?>
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<?php if ( is_user_logged_in() ) : ?>
			<p><?php printf(__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>.', THEME_NAME), get_option('siteurl'), $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php __('Log out of this account', THEME_NAME); ?>"><?php _e('Log out &raquo;', THEME_NAME); ?></a></p>
		<?php else : ?>
			<label for="author"><?php _e('Name', THEME_NAME); if ($req) _e(' (required)', THEME_NAME); ?></label>
			<input type="text" class="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?>>
			<label for="email"><?php _e('Email (will not be published)', THEME_NAME); if ($req) _e(' (required)', THEME_NAME); ?></label>
			<input type="email" class="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?>>
			<label for="url"><?php _e('Website', THEME_NAME); ?></label>
			<input type="url" class="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3">
		<?php endif; ?>
		<label for="comment"><?php _e('Comment', THEME_NAME); ?></label>
		<textarea name="comment" id="comment" tabindex="4"></textarea>
		<input name="submit" class="button" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment', THEME_NAME); ?>">
		<?php comment_id_fields(); ?>
		<?php do_action('comment_form', $post->ID); ?>
	</form>
	<?php endif; // If registration required and not logged in ?>
</section>
<?php endif; // if you delete this the sky will fall on your head ?>
