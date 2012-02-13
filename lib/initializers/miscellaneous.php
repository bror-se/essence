<?php
/**
 * Post excerpt lenght
 */

function essence_excerpt_length($length) {
  return POST_EXCERPT_LENGTH;
}
add_filter('excerpt_length', 'essence_excerpt_length');


/**
 * Returns a "Continue Reading" link for excerpts
 */

function essence_excerpt_more($more) {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continue reading', 'essence') . '</a>';
}
add_filter('excerpt_more', 'essence_excerpt_more');


/**
 * Check to see if the tagline is set to default
 * Show an admin notice to update if it hasn't been changed
 * You want to change this or remove it because it's used as the description in the RSS feed
 */

function essence_notice_tagline() {
  global $current_user;
  $user_id = $current_user->ID;

  if (!get_user_meta($user_id, 'ignore_tagline_notice')) {
    echo '<div class="error">';
    echo '<p>', sprintf(__('Please update your <a href="%s">site tagline</a> <a href="%s" style="float: right;">Hide Notice</a>', 'essence'), admin_url('options-general.php'), '?tagline_notice_ignore=0'), '</p>';
    echo '</div>';
  }
}
if ((get_option('blogdescription') === 'Just another WordPress site') && isset($_GET['page']) != 'theme_activation_options') {
  add_action('admin_notices', 'essence_notice_tagline');
}


/**
 * Ability to ignore tagline notice
 */

function essence_notice_tagline_ignore() {
  global $current_user;
  $user_id = $current_user->ID;
  if (isset($_GET['tagline_notice_ignore']) && '0' == $_GET['tagline_notice_ignore']) {
    add_user_meta($user_id, 'ignore_tagline_notice', 'true', true);
  }
}
add_action('admin_init', 'essence_notice_tagline_ignore');


/**
 * Set the post revisions to 5 unless the constant was set in wp-config.php to avoid DB bloat
 */

if (!defined('WP_POST_REVISIONS')) {
  define('WP_POST_REVISIONS', 5);
}


/**
 * Allow more tags in TinyMCE including iframes
 */

function essence_mce_options($options) {
  $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src],script[charset|defer|language|src|type]';
  if (isset($initArray['extended_valid_elements'])) {
    $options['extended_valid_elements'] .= ',' . $ext;
  } else {
    $options['extended_valid_elements'] = $ext;
  }
  return $options;
}
add_filter('tiny_mce_before_init', 'essence_mce_options');


/**
 * Set body class
 */

function essence_body_class() {
  $term = get_queried_object();

  if (is_single()) {
    $cat = get_the_category();
  }

  if (!empty($cat)) {
    return $cat[0]->slug;
  } elseif (isset($term->slug)) {
    return $term->slug;
  } elseif (isset($term->page_name)) {
    return $term->page_name;
  } elseif (isset($term->post_name)) {
    return $term->post_name;
  } else {
    return;
  }
}


/**
 * Entry meta
 */

function essence_entry_meta() {
  echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('Posted on %s at %s.', 'essence'), get_the_date(), get_the_time()) .'</time>';
  echo '<p class="byline author vcard">'. __('Written by', 'essence') .' <a href="'. get_author_posts_url(get_the_author_meta('id')) .'" rel="author" class="fn">'. get_the_author() .'</a></p>';
}


/**
 * First and last classes for widgets
 * http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
 */

function essence_widget_first_last_classes($params) {
  global $my_widget_num;
  $this_id                = $params[0]['id'];
  $arr_registered_widgets = wp_get_sidebars_widgets();

  if (!$my_widget_num) {
    $my_widget_num = array();
  }

  if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) {
    return $params;
  }

  if (isset($my_widget_num[$this_id])) {
    $my_widget_num[$this_id]++;
  } else {
    $my_widget_num[$this_id] = 1;
  }

  $class = 'class="widget-' . $my_widget_num[$this_id] . ' ';

  if ($my_widget_num[$this_id] == 1) {
    $class .= 'widget-first ';
  } elseif ($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) {
    $class .= 'widget-last ';
  }

  $params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']);

  return $params;
}
add_filter('dynamic_sidebar_params', 'essence_widget_first_last_classes');

 ?>
