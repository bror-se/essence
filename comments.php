<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to essence_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Essence
 */
?>

<div id="comments">
  <?php if (post_password_required()) : ?>
    <p class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'essence'); ?></p>
  </div>
  <?php
      /* Stop the rest of comments.php from being processed,
       * but don't kill the script entirely -- we still have
       * to fully load the template.
       */
      return;
    endif;
  ?>

  <?php // You can start editing here -- including this comment! ?>

  <?php if (have_comments()) : ?>
    <h2 id="comments-title">
      <?php
        printf(_n('One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'essence'),
          number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>');
      ?>
    </h2>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
    <nav id="comment-nav-above">
      <h3 class="assistive-text"><?php _e('Comment navigation', 'essence'); ?></h1>
      <div class="previous"><?php previous_comments_link(__('&larr; Older Comments', 'essence')); ?></div>
      <div class="next"><?php next_comments_link(__('Newer Comments &rarr;', 'essence')); ?></div>
    </nav>
    <?php endif; // Check for comment navigation ?>

    <ol class="commentlist">
      <?php
        /* Loop through and list the comments. Tell wp_list_comments()
         * to use essence_comment() to format the comments.
         * If you want to overload this in a child theme then you can
         * define essence_comment() and that will be used instead.
         * See essence_comment() in essence/functions.php for more.
         */
        wp_list_comments(array('callback' => 'essence_comment'));
      ?>
    </ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
    <nav id="comment-nav-below">
      <h1 class="assistive-text"><?php _e('Comment navigation', 'essence'); ?></h1>
      <div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'essence')); ?></div>
      <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'essence')); ?></div>
    </nav>
    <?php endif; // Check for comment navigation ?>

  <?php
    /* If there are no comments and comments are closed, let's leave a little note, shall we?
     * But we don't want the note on pages or post types that do not support comments.
     */
    elseif (! comments_open() && ! is_page() && post_type_supports(get_post_type(), 'comments')) :
  ?>
    <p class="nocomments"><?php _e('Comments are closed.', 'essence'); ?></p>
  <?php endif; ?>

  <?php comment_form(); ?>
</div>
