<?php
/**
 * Check if the page is a child page
 *
 * @return bool: True if the page is a child.
 */

function is_child(){
  global $post;

  if($post->post_parent){
    $pages = get_pages("child_of=".$post->post_parent);
    if($pages)
      return true;
    else
      return false;
  }
}

?>
