<?php
/**
 * Theme setup
 * Sets up default theme settings
 *
 * @uses add_theme_support() to add support for post-formats.
 * @uses add_custom_background() To add support for a custom background.
 */

function essence_theme_setup() {
  // Tell the TinyMCE editor to use editor-style.css
  add_editor_style('editor-style.css');

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

  // Add support for post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
   add_theme_support('post-thumbnails');

  // Add support for custom backgrounds
  add_custom_background();
}
add_action('after_setup_theme', 'essence_theme_setup');

?>
