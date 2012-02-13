<?php
/**
 * Create a new taxonomy
 *
 * @param string $name The name of the taxonomy.
 * @param $post_types
 * @param boolean $hierarchical (optional)
 */

function new_taxonomy($name, $post_types, $hierarchical = true) {

  if (!is_array($name)) {
    $name = array(
      "singular" => $name,
      "plural" => pluralize($name)
    );
  }

  $uc_plural = ucwords(preg_replace("/_/", " ", $name["plural"]));
  $uc_singular = ucwords(preg_replace("/_/", " ", $name["singular"]));

  $labels = array(
    "name" => $uc_singular,
    "singular_name" => $uc_singular,
    "search_items" => sprintf(__("Search %s", "essence"), $uc_plural),
    "all_items" => sprintf(__("All %s", "essence"), $uc_plural),
    "parent_item" => sprintf(__("Parent %s", "essence"), $uc_singular),
    "parent_item_colon" => sprintf(__("Parent %s:", "essence"), $uc_singular),
    "edit_item" => sprintf(__("Edit %s", "essence"), $uc_singular),
    "update_item" => sprintf(__("Update %s", "essence"), $uc_singular),
    "add_new_item" => sprintf(__("Add new %s", "essence"), $uc_singular),
    "new_item_name" => sprintf(__("New %n Name", "essence"), $uc_singular),
    "menu_name" => $uc_plural
  );

  register_taxonomy(
    $name["singular"],
    $post_types,
    array(
      'hierarchical' => $hierarchical,
      'labels' => $labels,
      'show_ui' => true,
      'query_var' => true,
      'rewrite' => array('slug' => $name["plural"])
    )
  );
}

?>
