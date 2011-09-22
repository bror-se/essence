<?php
/**
 * Essence functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * @package Wordpress
 * @subpackage Essence
 */


/**
 * Load necessary files
 */
require_once get_template_directory() . '/inc/essence-cleanup.php';     # Code cleanup/removal
require_once get_template_directory() . '/inc/essence-htaccess.php';    # Rewrites and h5bp htaccess
require_once get_template_directory() . '/inc/essence-widget.php';      # Add custom WP_Widgets

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function essence_setup() {
  // Make Essense available for translation.
  // Translations can be added to the /lang/ directory.
  load_theme_textdomain('essence', get_template_directory() . '/lang');

  // Tell the TinyMCE editor to use editor-style.css
  add_editor_style();

  // Activate thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  add_theme_support('post-thumbnails');
  // set_post_thumbnail_size(150, 150, false);

  // Add support for a variety of post formats
  // http://codex.wordpress.org/Post_Formats
  // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

  // Add support for menus and setup default menus
  add_theme_support('menus');
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'essence'),
    'utility_navigation' => __('Utility Navigation', 'essence')
  ));
}
add_action('after_setup_theme', 'essence_setup');

/**
 * Register our sidebars and widgetized areas.
 */
$sidebars = array('Sidebar', 'Footer');
foreach ($sidebars as $sidebar) {
  register_sidebar(array('name'=> $sidebar,
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h1>',
    'after_title' => '</h1>'
  ));
}

/**
 * Display navigation to next/previous pages when applicable
 */
function essence_content_nav() {
  global $wp_query;

  if ($wp_query->max_num_pages > 1) : ?>
    <nav>
      <h1><?php _e('Post navigation', 'essence'); ?></h1>
      <ul>
        <li><?php next_posts_link(__('&larr; Older posts', 'essence')); ?></li>
        <li><?php previous_posts_link(__('Newer posts &rarr;', 'essence')); ?></li>
      </ul>
    </nav>
  <?php endif;
}

/**
 * Customized wp_link_pages for better markup
 * Use do_action( 'essence_link_pages' );
 */
function essence_link_pages($args = array ()) {
  $paged_page_nav = wp_link_pages(array(
    'before' =>'<nav><ul>',
    'after' => '</ul></nav>',
    'link_before' => '<span>',
    'link_after' => '</span>',
    'next_or_number' => 'next',
    'echo' => false
  ));
  // Now let's wrap the nav inside <li>-elements
    $paged_page_nav = str_replace('<a', '<li><a', $paged_page_nav);
    $paged_page_nav = str_replace('</span></a>', '</a></li>', $paged_page_nav);
    $paged_page_nav = str_replace('"><span>', '">', $paged_page_nav);
  // Here we need to wrap the currently displayed page element, which could even get a different class
    $paged_page_nav = str_replace('<span>', '<li>', $paged_page_nav);
    $paged_page_nav = str_replace('</span>', '</li>', $paged_page_nav);
  echo $paged_page_nav;
}

/**
 * Return post entry meta information
 */
function essence_entry_meta() {
  echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('Posted on %s at %s.', 'essence'), get_the_time('l, F jS, Y'), get_the_time()) .'</time>';
  echo '<p class="byline author vcard">'. __('Written by', 'essence') .' <a href="'. get_author_posts_url(get_the_author_meta('id')) .'" rel="author" class="fn">'. get_the_author() .'</a></p>';
}

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own essence_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
if (! function_exists('essence_comment')) :
function essence_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
  switch ($comment->comment_type) :
    case 'pingback' :
    case 'trackback' :
  ?>
  <li class="post pingback">
    <p><?php _e('Pingback:', 'essence'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('Edit', 'essence'), '<span class="edit-link">', '</span>'); ?></p>
  <?php
      break;
    default :
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <article id="comment-<?php comment_ID(); ?>" class="comment">
      <footer class="comment-meta">
        <div class="comment-author vcard">
          <?php
            $avatar_size = 68;
            if ('0' != $comment->comment_parent)
              $avatar_size = 39;

            echo get_avatar($comment, $avatar_size);

            /* translators: 1: comment author, 2: date and time */
            printf(__('%1$s on %2$s <span class="says">said:</span>', 'essence'),
              sprintf('<span class="fn">%s</span>', get_comment_author_link()),
              sprintf('<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                esc_url(get_comment_link( $comment->comment_ID)),
                get_comment_time('c'),
                /* translators: 1: date, 2: time */
                sprintf(__('%1$s at %2$s', 'essence'), get_comment_date(), get_comment_time())
              )
            );
          ?>

          <?php edit_comment_link(__('Edit', 'essence'), '<span class="edit-link">', '</span>'); ?>
        </div>

        <?php if ($comment->comment_approved == '0') : ?>
          <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'essence'); ?></em>
          <br />
        <?php endif; ?>

      </footer>

      <div class="comment-content"><?php comment_text(); ?></div>

      <div class="reply">
        <?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply <span>&darr;</span>', 'essence'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
      </div>
    </article>

  <?php
      break;
  endswitch;
}
endif;

?>