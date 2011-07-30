<?php
/**
 * Essence cleanup
 *
 * Here most of the action happens. We rewrite our URLs to remove the /wp-content/ thingy and also set them to relative. There is also some cleanup going on to remove some of the unnecessary stuff.
 *
 * @package Wordpress
 * @subpackage Essence
 */

$theme_name = next( explode('/themes/', get_stylesheet_directory() ) );

/**
 * Flush rewrite rules
 */
function essence_flush_rewrites() {
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}

/**
 * Set the permalink structure to /year/postname/
 */
if ( get_option( 'permalink_structure' ) != '/%year%/%postname%/' ) {
  update_option( 'permalink_structure', '/%year%/%postname%/' );
}

/**
 * Set upload folder to /assets/.
 */
update_option( 'uploads_use_yearmonth_folders', 0 );
update_option( 'upload_path', 'assets' );

/**
 * Apply rewrites (won't apply for child themes)
 */
function essence_add_rewrites( $content ) {
  $theme_name = next( explode( '/themes/', get_stylesheet_directory() ) );
  global $wp_rewrite;
  $essence_new_non_wp_rules = array(
    'css/(.*)'      => 'wp-content/themes/'. $theme_name . '/css/$1',
    'js/(.*)'       => 'wp-content/themes/'. $theme_name . '/js/$1',
    'img/(.*)'      => 'wp-content/themes/'. $theme_name . '/img/$1',
    'fonts/(.*)'    => 'wp-content/themes/'. $theme_name . '/fonts/$1',
    'plugins/(.*)'  => 'wp-content/plugins/$1'
  );
  $wp_rewrite->non_wp_rules += $essence_new_non_wp_rules;
}
add_action( 'admin_init', 'essence_flush_rewrites' );

/**
 * Apply new path to assets
 */
function essence_clean_assets( $content ) {
    $theme_name = next( explode( '/themes/', $content ) );
    $current_path = '/wp-content/themes/' . $theme_name;
    $new_path = '';
    $content = str_replace( $current_path, $new_path, $content );
    return $content;
}

/**
 * Apply new plugins
 */
function essence_clean_plugins( $content ) {
    $current_path = '/wp-content/plugins';
    $new_path = '/plugins';
    $content = str_replace( $current_path, $new_path, $content );
    return $content;
}

/**
 * Only use clean URLs if the theme isn't a child or an MU (Network) install
 */
if ( ( !defined( 'WP_ALLOW_MULTISITE' ) || ( defined( 'WP_ALLOW_MULTISITE' ) && WP_ALLOW_MULTISITE !== true) ) && !is_child_theme() ) {
  add_action( 'generate_rewrite_rules', 'essence_add_rewrites' );
  add_filter( 'plugins_url', 'essence_clean_plugins' );
  add_filter( 'bloginfo', 'essence_clean_assets' );
  add_filter( 'stylesheet_directory_uri', 'essence_clean_assets' );
  add_filter( 'template_directory_uri', 'essence_clean_assets' );
}

/**
 * Redirect /?s to /search/
 * http://txfx.net/wordpress-plugins/nice-search/
 */
function essence_search_redirect() {
  if ( is_search() && strpos( $_SERVER['REQUEST_URI'], '/wp-admin/' ) === false && strpos( $_SERVER['REQUEST_URI'], '/search/' ) === false ) {
    wp_redirect( home_url( '/search/' . str_replace( array( ' ', '%20' ), array( '+', '+' ), urlencode( get_query_var( 's' ) ) ) ), 301 );
    exit();
  }
}
add_action( 'template_redirect', 'essence_search_redirect' );

function essence_search_query( $escaped = true ) {
  $query = apply_filters( 'essence_search_query', get_query_var( 's' ) );
  if ( $escaped ) {
      $query = esc_attr( $query );
  }
    return urldecode( $query );
}
add_filter( 'get_search_query', 'essence_search_query' );

/**
 * Add root relative URLs
 */
function essence_root_relative_url( $input ) {
  $output = preg_replace_callback(
    '/(https?:\/\/[^\/|"]+)([^"]+)?/',
    create_function(
      '$matches',
      // if full URL is site_url, return a slash for relative root
      'if ( isset( $matches[0] ) && $matches[0] === site_url() ) { return "/";' .
      // if domain is equal to site_url, then make URL relative
      '} elseif ( isset( $matches[1] ) && strpos( $matches[1], site_url() ) !== false ) { return "$matches[2]";' .
      // if domain is not equal to site_url, do not make external link relative
      '} else { return $matches[0]; };'
    ),
    $input
  );
  return $output;
}
if ( !is_admin() ) {
  add_filter( 'bloginfo_url', 'essence_root_relative_url' );
  add_filter( 'theme_root_uri', 'essence_root_relative_url' );
  add_filter( 'stylesheet_directory_uri', 'essence_root_relative_url' );
  add_filter( 'template_directory_uri', 'essence_root_relative_url' );
  add_filter( 'the_permalink', 'essence_root_relative_url' );
  add_filter( 'wp_list_pages', 'essence_root_relative_url' );
  add_filter( 'wp_list_categories', 'essence_root_relative_url' );
  add_filter( 'wp_nav_menu', 'essence_root_relative_url' );
  add_filter( 'wp_get_attachment_url', 'essence_root_relative_url' );
  add_filter( 'wp_get_attachment_link', 'essence_root_relative_url' );
  add_filter( 'the_content_more_link', 'essence_root_relative_url' );
  add_filter( 'the_tags', 'essence_root_relative_url' );
  add_filter( 'get_pagenum_link', 'essence_root_relative_url' );
  add_filter( 'get_comment_link', 'essence_root_relative_url' );
  add_filter( 'month_link', 'essence_root_relative_url' );
  add_filter( 'day_link', 'essence_root_relative_url' );
  add_filter( 'year_link', 'essence_root_relative_url' );
  add_filter( 'tag_link', 'essence_root_relative_url' );
  add_filter( 'the_author_posts_link', 'essence_root_relative_url' );
}

/**
 * Remove root relative URLs on any attachments in the feed
 */
function essence_relative_feed_urls() {
  global $wp_query;
  if ( is_feed() ) {
    remove_filter( 'wp_get_attachment_url', 'essence_root_relative_url' );
    remove_filter( 'wp_get_attachment_link', 'essence_root_relative_url' );
  }
}
add_action( 'pre_get_posts', 'essence_relative_feed_urls' );

/**
 * Remove WordPress version from RSS feed
 */
function essence_no_generator() {
  return '';
}
add_filter( 'the_generator', 'essence_no_generator' );

/**
 * Function to hide blog from search engines
 */
function essence_noindex() {
  if ( get_option( 'blog_public' ) === '0' )
  echo '<meta name="robots" content="noindex, nofollow">', "\n";
}

/**
 * Add canonical link to head
 */
function essence_rel_canonical() {
  if ( !is_singular() )
    return;
  global $wp_the_query;
  if ( !$id = $wp_the_query->get_queried_object_id() )
    return;
  $link = get_permalink( $id );
  echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}

/**
 * Remove recent comments widget style
 */
function essence_remove_recent_comments_style() {
  global $wp_widget_factory;
  if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
  }
}

/**
 * Remove gallery style
 */
function essence_remove_gallery_style($css) {
  return preg_replace("/<style type='text\/css'>(.*?)<\/style>/s", '', $css);
}

/**
 * Head cleanup
 */
function essence_head_cleanup() {
  remove_action( 'wp_head', 'feed_links', 2 );
  remove_action( 'wp_head', 'feed_links_extra', 3 );
  remove_action( 'wp_head', 'rsd_link' );
  remove_action( 'wp_head', 'wlwmanifest_link' );
  remove_action( 'wp_head', 'index_rel_link' );
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
  remove_action( 'wp_head', 'wp_generator' );
  remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
  remove_action( 'wp_head', 'noindex', 1 );
  add_action( 'wp_head', 'essence_noindex' );
  remove_action( 'wp_head', 'rel_canonical' );
  add_action( 'wp_head', 'essence_rel_canonical' );
  add_action( 'wp_head', 'essence_remove_recent_comments_style', 1 );
  add_filter( 'gallery_style', 'essence_gallery_style' );

  // Deregister l10n.js (new since WordPress 3.1)
  // Why you might want to keep it: http://wordpress.stackexchange.com/questions/5451/what-does-l10n-js-do-in-wordpress-3-1-and-how-do-i-remove-it/5484#5484
  if ( !is_admin() ) {
    wp_deregister_script( 'l10n' );
  }

  // Don't load jQuery through WordPress since it's already linked in footer.php
  if ( !is_admin() ) {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', '', '', true );
  }
}
add_action( 'init', 'essence_head_cleanup' );

/**
 * Cleanup gallery_shortcode()
 */
function essence_gallery_shortcode( $attr ) {
  global $post, $wp_locale;

  static $instance = 0;
  $instance++;

  // Allow plugins/themes to override the default gallery template.
  $output = apply_filters( 'post_gallery', '', $attr );
  if ( $output != '' )
    return $output;

  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
      unset( $attr['orderby'] );
  }

  extract(shortcode_atts( array(
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post->ID,
    'icontag'    => 'figure',
    'captiontag' => 'figcaption',
    'columns'    => 3,
    'size'       => 'thumbnail',
    'include'    => '',
    'exclude'    => ''
  ), $attr));

  $id = intval($id);
  if ( 'RAND' == $order )
    $orderby = 'none';

  if ( !empty($include) ) {
    $include = preg_replace( '/[^0-9,]+/', '', $include );
    $_attachments = get_posts( array(
      'include' => $include,
      'post_status' => 'inherit',
      'post_type' => 'attachment',
      'post_mime_type' => 'image',
      'order' => $order,
      'orderby' => $orderby
    ) );

    $attachments = array();
    foreach ( $_attachments as $key => $val ) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  }
  elseif ( !empty($exclude) ) {
    $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
    $attachments = get_children( array(
      'post_parent' => $id,
      'exclude' => $exclude,
      'post_status' => 'inherit',
      'post_type' => 'attachment',
      'post_mime_type' => 'image',
      'order' => $order, 'orderby' => $orderby
    ) );
  }
  else {
    $attachments = get_children( array(
      'post_parent' => $id,
      'post_status' => 'inherit',
      'post_type' => 'attachment',
      'post_mime_type' => 'image',
      'order' => $order,
      'orderby' => $orderby
    ) );
  }

  if ( empty( $attachments ) )
    return '';

  if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment )
      $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
    return $output;
  }

  $captiontag = tag_escape( $captiontag );
  $columns = intval( $columns );
  $itemwidth = $columns > 0 ? floor( 100/$columns ) : 100;
  $float = is_rtl() ? 'right' : 'left';

  $selector = "gallery-{$instance}";

  $gallery_style = $gallery_div = '';
  if ( apply_filters( 'use_default_gallery_style', true ) )
    $gallery_style = "";
  $size_class = sanitize_html_class( $size );
  $gallery_div = "<section id='$selector' class='clearfix gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
  $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

  $i = 0;
  foreach ( $attachments as $id => $attachment ) {
    // make the gallery link to the file by default instead of the attachment
    // thanks to Matt Price (countingrows.com)
    $link = isset($attr['link']) && $attr['link'] === 'attachment' ?
      wp_get_attachment_link( $id, $size, true, false ) :
      wp_get_attachment_link( $id, $size, false, false );
    $output .= "
      <{$icontag} class=\"gallery-item\">
        $link
      ";
    if ( $captiontag && trim( $attachment->post_excerpt ) ) {
      $output .= "
        <{$captiontag} class=\"gallery-caption\">
        " . wptexturize( $attachment->post_excerpt ) . "
        </{$captiontag}>";
    }
    $output .= "</{$icontag}>";
    if ( $columns > 0 && ++$i % $columns == 0 )
      $output .= '';
  }

  $output .= "</section>\n";

  return $output;
}
remove_shortcode( 'gallery' );
add_shortcode( 'gallery', 'essence_gallery_shortcode' );

/**
 * Removes empty span
 */
function essence_remove_empty_read_more_span($content) {
  return eregi_replace("(<p><span id=\"more-[0-9]{1,}\"></span></p>)", "", $content);
}
add_filter('the_content', 'essence_remove_empty_read_more_span');

/**
 * Removes url hash to avoid the jump link
 */
function essence_remove_more_jump_link($link) {
   $offset = strpos($link, '#more-');
   if ($offset) {
      $end = strpos($link, '"',$offset);
   }
   if ($end) {
      $link = substr_replace($link, '', $offset, $end-$offset);
   }
   return $link;
}
add_filter('the_content_more_link', 'essence_remove_more_jump_link');

/**
 * Remove container from menus.
 */
function essence_nav_menu_args($args = '') {
  $args['container'] = false;
  return $args;
}

/**
 * Custom Walker for cleaner menu output
 */
class essence_nav_walker extends Walker_Nav_Menu {
  function start_el(&$output, $item, $depth, $args) {
    global $wp_query;
      $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

      $slug = sanitize_title($item->title);

      $class_names = $value = '';
      $classes = empty( $item->classes ) ? array() : (array) $item->classes;

      $classes = array_filter($classes, 'essence_check_current');

      $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
      $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

      $id = apply_filters( 'nav_menu_item_id', 'menu-' . $slug, $item, $args );
      $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

      $output .= $indent . '<li' . $id . $class_names . '>';

      $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
      $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
      $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
      $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

      $item_output = $args->before;
      $item_output .= '<a'. $attributes .'>';
      $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
      $item_output .= '</a>';
      $item_output .= $args->after;

      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
}

/**
 * Checks active page and adds active class to the menu item
 */
function essence_check_current( $val ) {
  return preg_match( '/current-menu/', $val );
}

?>