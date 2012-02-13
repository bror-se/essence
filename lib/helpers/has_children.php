<?php
/**
 * Looks for child pages
 *
 * @return bool: True if the post/page has children.
 */

function has_children(){
  global $post;
  $children = get_pages("child_of=".$post->ID);

  if($children || count($children) != 0)
    return true;
  else
    return false;
}

?>
