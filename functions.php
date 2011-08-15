<?php
/**
 * essence functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * @package Wordpress
 * @subpackage Essence
 */

global $wpdb;

define( 'THEME_NAME', 'essence' );
define( 'THEME_URL', get_template_directory_uri() );
define( 'THEME_CSS_DIR', THEME_URL . '/css' );
define( 'THEME_JS_DIR', THEME_URL . '/js' );
define( 'THEME_IMG_DIR', THEME_URL . '/img' );
define( 'THEME_FONT_DIR', THEME_URL . '/font' );

require_once( dirname( __FILE__ ) . '/inc/essence-cleanup.php' );      # Code cleanup/removal
require_once( dirname( __FILE__ ) . '/inc/essence-htaccess.php' );     # Rewrites and h5bp htaccess

/**
 * Tell WordPress to run essence_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'essence_setup' );

if ( ! function_exists( 'essence_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function essence_setup() {
  // Make Essense available for translation.
  // Translations can be added to the /lang/ directory.
  load_theme_textdomain( THEME_NAME, get_template_directory() . '/languages' );

  // This theme styles the visual editor with editor-style.css to match the theme style.
  add_editor_style();

  // Add default posts and comments RSS feed links to <head>.
  add_theme_support( 'automatic-feed-links' );

  // Add support for custom backgrounds
  add_custom_background();

  // Add support for menus.
  add_theme_support( 'menus' );

  // This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
  // http://codex.wordpress.org/Post_Thumbnails
  add_theme_support( 'post-thumbnails' );
  // set_post_thumbnail_size( 150, 150, false );

  // This theme uses wp_nav_menu().
  register_nav_menus( array(
    'primary_navigation' => __( 'Primary Navigation', THEME_NAME )
  ) );

  // Add support for a variety of post formats
  add_theme_support( 'post-formats', array(
    'aside',
    'link',
    'gallery',
    'status',
    'quote',
    'image'
  ) );
}
endif;

/**
 * Register our sidebars and widgetized areas.
 */
$sidebars = array(
  'Sidebar'
);
foreach ( $sidebars as $sidebar ) {
  register_sidebar( array(
    'name'=> $sidebar,
    'before_widget' => '<section>',
    'after_widget' => '</section>',
    'before_title' => '<h1>',
    'after_title' => '</h1>'
  ));
}

/**
 * Return the URL for the first link found in the post content.
 */
function essence_url_grabber() {
  if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
    return false;

  return esc_url_raw( $matches[1] );
}

if ( ! function_exists( 'essence_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own essence_posted_on to override in a child theme
 */
function essence_posted_on() {
  printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time datetime="%3$s" pubdate>%4$s</time></a> by <a href="%5$s" title="%6$s" rel="author">%7$s</a>', THEME_NAME ),
    esc_url( get_permalink() ),
    esc_attr( get_the_time() ),
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
    sprintf( esc_attr__( 'View all posts by %s', THEME_NAME ), get_the_author() ),
    esc_html( get_the_author() )
  );
}
endif;

/**
 * Display navigation to next/previous pages when applicable
 */
function essence_content_nav() {
  global $wp_query;

  if ( $wp_query->max_num_pages > 1 ) : ?>
    <nav>
      <ul>
        <li><?php next_posts_link( __( '&larr; Older posts', THEME_NAME ) ); ?></li>
        <li><?php previous_posts_link( __( 'Newer posts &rarr;', THEME_NAME ) ); ?></li>
      </ul>
    </nav>
  <?php endif;
}

/**
 * Sets the post excerpt length to 40 words.
 */
function essence_excerpt_length( $length ) {
  return 40;
}
add_filter( 'excerpt_length', 'essence_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function essence_continue_reading_link() {
  return '<a href="'. esc_url( get_permalink() ) . __( 'Continue reading &rarr;', THEME_NAME ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and essence_continue_reading_link().
 */
function essence_auto_excerpt_more( $more ) {
  return '&hellip;' . essence_continue_reading_link();
}
add_filter( 'excerpt_more', 'essence_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 */
function essence_custom_excerpt_more( $output ) {
  if ( has_excerpt() && ! is_attachment() ) {
    $output .= essence_continue_reading_link();
  }
  return $output;
}
add_filter( 'get_the_excerpt', 'essence_custom_excerpt_more' );

/**
 * Add custom classes to body
 */
function essence_body_classes( $classes ) {

  if ( is_singular() && ! is_home() )
    $classes[] = 'singular';

  return $classes;
}
add_filter( 'body_class', 'essence_body_classes' );

?>