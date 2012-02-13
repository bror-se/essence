<?php // Comment template ?>
<?php function essence_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment; ?>

  <li <?php comment_class(); ?>>
    <article class="comment-<?php comment_ID(); ?>">
      <header class="comment-author vcard">
        <?php echo get_avatar($comment, $size = '32'); // Get avatar ?>

        <?php printf(__('<cite class="fn">%s</cite>', 'essence'), get_comment_author_link()); ?>
        <time datetime="<?php echo comment_date('c'); ?>"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>"><?php printf(__('%1$s', 'essence'), get_comment_date(),  get_comment_time()); ?></a></time>

        <?php edit_comment_link(__('(Edit)', 'essence'), '', ''); // Edit comment link?>
      </header>

      <?php if ($comment->comment_approved == '0') { ?>
        <div class="alert alert-block fade in">
          <a class="close" data-dismiss="alert">×</a>
          <p><?php _e('Your comment is awaiting moderation.', 'essence'); ?></p>
        </div>
      <?php } ?>

      <section class="comment">
        <?php comment_text() ?>
      </section>

      <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
    </article>
<?php } ?>

<?php // If password is required ?>
<?php if (post_password_required()) { ?>
  <section class="comments">
    <div class="alert alert-block fade in">
      <a class="close" data-dismiss="alert">×</a>
      <p><?php _e('This post is password protected. Enter the password to view comments.', 'essence'); ?></p>
    </div>
  </section>
<?php
  return;
} ?>

<?php // If there are comments to show, show 'em! ?>
<?php if (have_comments()) { ?>
  <section class="comments">
    <h3><?php printf(_n('One Response to &ldquo;%2$s&rdquo;', '%1$s Responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'essence'), number_format_i18n(get_comments_number()), get_the_title()); ?></h3>
    <ol>
      <?php wp_list_comments(array('callback' => 'essence_comment')); ?>
    </ol>
    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { // Are there comments to navigate through? ?>
      <ul class="pager">
        <li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'essence')); ?></li>
        <li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'essence')); ?></li>
      </ul>
    <?php } ?>
    <?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) { ?>
      <div class="alert alert-block fade in">
        <a class="close" data-dismiss="alert">×</a>
        <p><?php _e('Comments are closed.', 'essence'); ?></p>
      </div>
    <?php } ?>
  </section>
<?php } ?>

<?php // If there ain't no comments, or if they are closed; throw an error! ?>
<?php if (!have_comments() && !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) { ?>
  <section class="comments">
    <div class="alert alert-block fade in">
      <a class="close" data-dismiss="alert">×</a>
      <p><?php _e('Comments are closed.', 'essence'); ?></p>
    </div>
  </section>
<?php } ?>

<?php // Respond form ?>
<?php if (comments_open()) { ?>
  <section class="respond">
    <h3><?php comment_form_title(__('Leave a Reply', 'essence'), __('Leave a Reply to %s', 'essence')); ?></h3>
    <p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
    <?php if (get_option('comment_registration') && !is_user_logged_in()) { ?>
      <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'essence'), wp_login_url(get_permalink())); ?></p>
    <?php } else { ?>
      <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
        <?php if (is_user_logged_in()) { ?>
          <p><?php printf(__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>.', 'essence'), get_option('siteurl'), $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php __('Log out of this account', 'essence'); ?>"><?php _e('Log out &raquo;', 'essence'); ?></a></p>
        <?php } else { ?>
          <label for="author"><?php _e('Name', 'essence'); if ($req) _e(' (required)', 'essence'); ?></label>
          <input type="text" class="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?>>
          <label for="email"><?php _e('Email (will not be published)', 'essence'); if ($req) _e(' (required)', 'essence'); ?></label>
          <input type="email" class="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?>>
          <label for="url"><?php _e('Website', 'essence'); ?></label>
          <input type="url" class="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3">
        <?php } ?>
        <label for="comment"><?php _e('Comment', 'essence'); ?></label>
        <textarea name="comment" id="comment" class="input-xlarge" tabindex="4"></textarea>
        <input name="submit" class="btn btn-primary" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment', 'essence'); ?>">
        <?php comment_id_fields(); ?>
        <?php do_action('comment_form', $post->ID); ?>
      </form>
    <?php } // If registration required and not logged in ?>
  </section>
<?php } ?>
