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

if (!defined('__DIR__'))
  define('__DIR__', dirname(__FILE__));

/**
 * Load necessary files
 */
require_once locate_template('/lib/essence-cleanup.php');   // Code cleanup
require_once locate_template('/lib/essence-htaccess.php');  // Custom rewrites and htaccess

function essence_setup() {
  // Make theme available for translation.
  // Translations can be added to the /lang/ directory.
  load_theme_textdomain('essence', get_template_directory() . '/lang');

  $locale      = get_locale();
  $locale_file = get_template_directory() . "/lang/$locale.php";
  if (is_readable($locale_file))
    require_once($locale_file);

  // Tell the TinyMCE editor to use editor-style.css
  add_editor_style('');

  // Activate thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  add_theme_support('post-thumbnails');

  // Add support for a variety of post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', array(
    'aside',
    'link',
    'gallery',
    'status',
    'quote',
    'image'
  ));

  // Setup default menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'essence'),
    'utility_navigation' => __('Utility Navigation', 'essence')
  ));
}
add_action('after_setup_theme', 'essence_setup');

/**
 * Register our sidebars and widgetized areas.
 * http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function essence_register_sidebars() {
  $sidebars = array('Sidebar', 'Footer');

  foreach($sidebars as $sidebar) {
    register_sidebar(array(
      'id'=> 'essence-' . strtolower($sidebar),
      'name' => __($sidebar, 'essence'),
      'description' => __($sidebar, 'essence'),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</div></section>',
      'before_title' => '<h3>',
      'after_title' => '</h3>'
    ));
  }
}

/**
 * Display navigation to next/previous pages when applicable
 */
if (!function_exists('essence_content_nav')):
  function essence_content_nav($nav_id) {
    global $wp_query;

    if ($wp_query->max_num_pages > 1): ?>
      <nav id="<?php echo $nav_id; ?>">
        <h3><?php _e('Post navigation', 'essence'); ?></h3>
        <div class="previous"><?php next_posts_link(__('&larr; Older posts', 'essence')); ?></div>
        <div class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'essence')); ?></div>
      </nav>
   <?php endif;
  }
endif;

/**
 * Return the URL for the first link found in the post content.
 *
 * @return string|bool URL or false when no link is present.
 */
function essence_url_grabber() {
  if (!preg_match('/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches))
    return false;

  return esc_url_raw($matches[1]);
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own essence_entry_meta to override in a child theme
 */
if (!function_exists('essence_entry_meta')):
  function essence_entry_meta() {
    printf(__('<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'essence'), esc_url(get_permalink()), esc_attr(get_the_time()), esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_url(get_author_posts_url(get_the_author_meta('ID'))), sprintf(esc_attr__('View all posts by %s', 'essence'), get_the_author()), esc_html(get_the_author()));
  }
endif;

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own essence_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
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
                esc_url(get_comment_link($comment->comment_ID)),
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
