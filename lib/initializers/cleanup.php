<?php
/**
 * Remove WordPress version from RSS feed
 */

function essence_remove_generator() {
  return '';
}
add_filter('the_generator', 'essence_remove_generator');


/**
 * Add meta tags if the user chooses to hide blog from search engines
 */

function essence_noindex() {
  if (get_option('blog_public') === '0') {
    echo '<meta name="robots" content="noindex,nofollow">', "\n";
  }
}


/**
 * Add canonical links for single pages
 */

function essence_rel_canonical() {
  if (!is_singular()) {
    return;
  }

  global $wp_the_query;
  if (!$id = $wp_the_query->get_queried_object_id()) {
    return;
  }

  $link = get_permalink($id);
  echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}


/**
 * Remove CSS from recent comment widget
 */

function essence_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array(
      $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
      'recent_comments_style'
    ));
  }
}


/**
 * Remove CSS from gallery
 */

function essence_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


/**
 * Remove unnecessary stuff from head
 * http://wpengineer.com/1438/wordpress-header/
 */

function essence_head_cleanup() {
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  remove_action('wp_head', 'essence_noindex', 1);
  add_action('wp_head', 'essence_noindex');
  remove_action('wp_head', 'essence_rel_canonical');
  add_action('wp_head', 'essence_rel_canonical');
  add_action('wp_head', 'essence_remove_recent_comments_style', 1);
  add_filter('gallery_style', 'gallery_style');

  if (!is_admin()) {
    // Deregister l10n.js (new since WordPress 3.1)
    // Why you might want to keep it: http://wordpress.stackexchange.com/questions/5451/what-does-l10n-js-do-in-wordpress-3-1-and-how-do-i-remove-it/5484#5484
    wp_deregister_script('l10n');

    // Don't load jQuery through WordPress since it's linked manually
    wp_deregister_script('jquery');
    wp_register_script('jquery', '', '', '', true);
  }
}
add_action('init', 'essence_head_cleanup');


/**
 * Cleanup gallery_shortcode()
 */

function essence_gallery_shortcode($attr) {
  global $post, $wp_locale;

  static $instance = 0;
  $instance++;

  // Allow plugins/themes to override the default gallery template.
  $output = apply_filters('post_gallery', '', $attr);
  if ($output != '') {
    return $output;
  }

  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if (isset($attr['orderby'])) {
    $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
    if (!$attr['orderby']) {
      unset($attr['orderby']);
    }
  }

  extract(shortcode_atts(array(
    'order' => 'ASC',
    'orderby' => 'menu_order ID',
    'id' => $post->ID,
    'icontag' => 'li',
    'captiontag' => 'p',
    'columns' => 3,
    'size' => 'thumbnail',
    'include' => '',
    'exclude' => ''
  ), $attr));

  $id = intval($id);
  if ('RAND' == $order) {
    $orderby = 'none';
  }

  if (!empty($include)) {
    $include      = preg_replace('/[^0-9,]+/', '', $include);
    $_attachments = get_posts(array(
      'include' => $include,
      'post_status' => 'inherit',
      'post_type' => 'attachment',
      'post_mime_type' => 'image',
      'order' => $order,
      'orderby' => $orderby
    ));

    $attachments = array();
    foreach ($_attachments as $key => $val) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif (!empty($exclude)) {
    $exclude     = preg_replace('/[^0-9,]+/', '', $exclude);
    $attachments = get_children(array(
      'post_parent' => $id,
      'exclude' => $exclude,
      'post_status' => 'inherit',
      'post_type' => 'attachment',
      'post_mime_type' => 'image',
      'order' => $order,
      'orderby' => $orderby
    ));
  } else {
    $attachments = get_children(array(
      'post_parent' => $id,
      'post_status' => 'inherit',
      'post_type' => 'attachment',
      'post_mime_type' => 'image',
      'order' => $order,
      'orderby' => $orderby
    ));
  }

  if (empty($attachments)) {
    return '';
  }

  if (is_feed()) {
    $output = "\n";
    foreach ($attachments as $att_id => $attachment)
      $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    return $output;
  }

  $captiontag = tag_escape($captiontag);
  $columns    = intval($columns);
  $itemwidth  = $columns > 0 ? floor(100 / $columns) : 100;
  $float      = is_rtl() ? 'right' : 'left';

  $selector = "gallery-{$instance}";

  $gallery_style = $gallery_div = '';
  if (apply_filters('use_default_gallery_style', true)) {
    $gallery_style = "";
  }
  $size_class  = sanitize_html_class($size);
  $gallery_div = "<ul id='$selector' class='thumbnails gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
  $output      = apply_filters('gallery_style', $gallery_style . "\n\t\t" . $gallery_div);

  $i = 0;
  foreach ($attachments as $id => $attachment) {
    $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

    $output .= "
      <{$icontag} class=\"gallery-item\">
        $link
      ";
    if ($captiontag && trim($attachment->post_excerpt)) {
      $output .= "
        <{$captiontag} class=\"gallery-caption hidden\">
        " . wptexturize($attachment->post_excerpt) . "
        </{$captiontag}>";
    }
    $output .= "</{$icontag}>";
    if ($columns > 0 && ++$i % $columns == 0) {
      $output .= '';
    }
  }

  $output .= "</ul>\n";

  return $output;
}
remove_shortcode('gallery');
add_shortcode('gallery', 'essence_gallery_shortcode');


/**
 * Add "thumbnail" class to attachment link
 */

function essence_attachment_link_class($html) {
  $postid = get_the_ID();
  $html   = str_replace('<a', '<a class="thumbnail"', $html);
  return $html;
}
add_filter('wp_get_attachment_link', 'essence_attachment_link_class', 10, 1);


/**
 * Captions
 * http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */

function essence_caption($output, $attr, $content) {
  // We're not worried abut captions in feeds, so just return the output here.
  if (is_feed()) {
    return $output;
  }

  // Set up the default arguments.
  $defaults = array(
    'id' => '',
    'align' => 'alignnone',
    'width' => '',
    'caption' => ''
  );

  // Merge the defaults with user input.
  $attr = shortcode_atts($defaults, $attr);

  // If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags.
  if (1 > $attr['width'] || empty($attr['caption'])) {
    return $content;
  }

  // Set up the attributes for the caption <div>.
  $attributes = (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '');
  $attributes .= ' class="thumbnail wp-caption ' . esc_attr($attr['align']) . '"';
  $attributes .= ' style="width: ' . esc_attr($attr['width']) . 'px"';

  // Open the caption <div>.
  $output = '<div' . $attributes . '>';

  // Allow shortcodes for the content the caption was created for.
  $output .= do_shortcode($content);

  // Append the caption text.
  $output .= '<div class="caption"><p class="wp-caption-text">' . $attr['caption'] . '</p></div>';

  // Close the caption </div>
  $output .= '</div>';

  // Return the formatted, clean caption
  return $output;
}
add_filter('img_caption_shortcode', 'essence_caption', 10, 3);


/**
 * We don't need to self-close these tags in html5:
 * <img>, <input>
 */

function essence_remove_self_closing_tags($input) {
  return str_replace(' />', '>', $input);
}
add_filter('get_avatar', 'essence_remove_self_closing_tags');
add_filter('comment_id_fields', 'essence_remove_self_closing_tags');
add_filter('post_thumbnail_html', 'essence_remove_self_closing_tags');


/**
 * Clean up the default WordPress style tags
 */

function essence_clean_style_tag($input) {
  preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
  //only display media if it's print
  $media = $matches[3][0] === 'print' ? ' media="print"' : '';
  return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}
add_filter('style_loader_tag', 'essence_clean_style_tag');


/**
 * Remove dashboard widgets
 */

function essence_remove_dashboard_widgets() {
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
  remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
  remove_meta_box('dashboard_primary', 'dashboard', 'normal');
  remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
}
add_action('admin_init', 'essence_remove_dashboard_widgets');

 ?>
