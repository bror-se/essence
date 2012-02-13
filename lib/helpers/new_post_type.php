<?php
/**
 * Creates a new post type
 *
 * This function use the WP APIs and functions to register a new post type.
 *
 * @param string|array $name The name of the new post type (will appear in the
 *   backend). If the name is a sting, the plural will be evaluated by the
 *   system; if is an array, must contains the singular and the plural
 *   versions of the name.
 *   Ex:
 *   @code
 *   $name = array(
 *     "singular" => 'My custom post type',
 *     "plural" => 'My custom post types'
 *   );
 *   @endcode
 * @param array $supports (optional) Extra fields added to this post type.
 *   Default fields (the fields you can find in page/post type) are added by default.
 */

function new_post_type($name, $supports = array("title", "editor")) {

  if (!is_array($name)) {
    $name = array(
      "singular" => $name,
      "plural" => pluralize($name)
    );
  }

  $uc_plural = __(ucwords(preg_replace("/_/", " ", $name["plural"])));
  $uc_singular = __(ucwords(preg_replace("/_/", " ", $name["singular"])));

  $labels = array(
    'name' => $uc_plural,
    'singular_name' => $uc_singular,
    'add_new_item' => sprintf(__("Add new %s", "essence"), $uc_singular),
    'edit_item' => sprintf(__("Edit %s", "essence"), $uc_singular),
    'new_item' => sprintf(__("New %s", "essence"), $uc_singular),
    'view_item' => sprintf(__("View %s", "essence"), $uc_singular),
    'search_items' => sprintf(__("Search %s", "essence"), $uc_plural),
    'not_found' => sprintf(__("No %s found.", "essence"), $uc_plural),
    'not_found_in_trash' => sprintf(__("No %s found in Trash", "essence"), $uc_plural),
    'parent_item_colon' => ',',
    'menu_name' => $uc_plural
  );

  register_post_type(
    $name["singular"],
    array(
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'query_var' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => $name["plural"]),
      'capability_type' => 'post',
      'hierarchical' => false,
      'menu_position' => null,
      'supports' => $supports
    )
  );
}

?>
