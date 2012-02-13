<?php
/**
 * Setup default menus
 * http://codex.wordpress.org/Function_Reference/register_nav_menus
 *
 * @uses register_nav_menu() To add support for navigation menus.
 */

function essence_setup_menus() {
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'essence')
  ));
}
add_action('after_setup_theme', 'essence_setup_menus');


/**
 * Custom Walker for cleaner menu output
 */

class Essence_Nav_Walker extends Walker_Nav_Menu {
  function check_current($val) {
    return preg_match('/(current-)/', $val);
  }

  function start_el(&$output, $item, $depth, $args) {
    global $wp_query;
    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $slug = sanitize_title($item->title);

    $class_names = $value = '';
    $classes     = empty($item->classes) ? array() : (array) $item->classes;

    $classes = array_filter($classes, array(
      &$this,
      'check_current'
    ));

    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
    $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

    $id = apply_filters('nav_menu_item_id', 'menu-' . $slug, $item, $args);
    $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

    $output .= $indent . '<li' . $id . $class_names . '>';

    $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}

class Essence_Navbar_Nav_Walker extends Walker_Nav_Menu {
  function check_current($val) {
    return preg_match('/(current-)|active|dropdown/', $val);
  }

  function start_lvl(&$output, $depth) {
    $output .= "\n<ul class=\"dropdown-menu\">\n";
  }

  function start_el(&$output, $item, $depth, $args) {
    global $wp_query;
    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $slug = sanitize_title($item->title);

    $li_attributes = '';
    $class_names   = $value = '';

    $classes = empty($item->classes) ? array() : (array) $item->classes;
    if ($args->has_children) {
      $classes[] = 'dropdown';
      $li_attributes .= 'data-dropdown="dropdown"';
    }
    $classes[] = ($item->current) ? 'active' : '';
    $classes   = array_filter($classes, array(
      &$this,
      'check_current'
    ));

    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
    $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

    $id = apply_filters('nav_menu_item_id', 'menu-' . $slug, $item, $args);
    $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

    $output .= $indent . '<li' . $id . $class_names . $li_attributes . '>';

    $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
    $attributes .= ($args->has_children) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= ($args->has_children) ? ' <b class="caret"></b>' : '';
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
  function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
    if (!$element) {
      return;
    }

    $id_field = $this->db_fields['id'];

    // Display this element
    if (is_array($args[0])) {
      $args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
    } elseif (is_object($args[0])) {
      $args[0]->has_children = !empty($children_elements[$element->$id_field]);
    }
    $cb_args = array_merge(array(
      &$output,
      $element,
      $depth
    ), $args);
    call_user_func_array(array(
      &$this,
      'start_el'
    ), $cb_args);

    $id = $element->$id_field;

    // Descend only when the depth is right and there are childrens for this element
    if (($max_depth == 0 || $max_depth > $depth + 1) && isset($children_elements[$id])) {
      foreach ($children_elements[$id] as $child) {
        if (!isset($newlevel)) {
          $newlevel = true;
          // Start the child delimiter
          $cb_args  = array_merge(array(
            &$output,
            $depth
          ), $args);
          call_user_func_array(array(
            &$this,
            'start_lvl'
          ), $cb_args);
        }
        $this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
      }
      unset($children_elements[$id]);
    }

    if (isset($newlevel) && $newlevel) {
      // End the child delimiter
      $cb_args = array_merge(array(
        &$output,
        $depth
      ), $args);
      call_user_func_array(array(
        &$this,
        'end_lvl'
      ), $cb_args);
    }

    // End this element
    $cb_args = array_merge(array(
      &$output,
      $element,
      $depth
    ), $args);
    call_user_func_array(array(
      &$this,
      'end_el'
    ), $cb_args);
  }
}


/**
 * Format wp_nav_menu()
 */

function essence_nav_menu_args($args = '') {
  $args['container']  = false;
  $args['depth']      = 2;
  $args['items_wrap'] = '<ul class="nav">%3$s</ul>';
  if (!$args['walker']) {
    $args['walker'] = new Essence_Nav_Walker();
  }
  return $args;
}
add_filter('wp_nav_menu_args', 'essence_nav_menu_args');


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link
 */

function essence_page_menu_args($args) {
  $args['show_home'] = true;
  return $args;
}
add_filter('wp_page_menu_args', 'essence_page_menu_args');


/**
 * Display navigation to next/previous pages when applicable
 */

if (!function_exists('content_nav')):
  function essence_content_nav() {
    global $wp_query;

    if ($wp_query->max_num_pages > 1): ?>
      <ul class="pager">
        <li class="previous"><?php next_posts_link(__('&larr; Older posts', 'essence')); ?></li>
        <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'essence')); ?></li>
      </nav>
   <?php endif;
  }
endif;


/**
 * Register our sidebars and widgetized areas
 * http://codex.wordpress.org/Function_Reference/register_sidebar
 */

function essence_widgets() {
  register_sidebar(array(
    'name' => __('Main Sidebar', 'essence'),
    'id' => 'sidebar',
    'before_widget' => '<section id="%1$s" class="well widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));

  register_sidebar(array(
    'name' => __('Footer', 'essence'),
    'id' => 'footer-widget',
    'before_widget' => '<section id="%1$s" class="span4 widget %2$s">',
    'after_widget' => '</section><',
    'before_title' => '<h4>',
    'after_title' => '</h4>'
  ));
}
add_action('widgets_init', 'essence_widgets');

?>
