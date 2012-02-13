<?php
/**
 * Get the latest posts of a post type
 */

function latest_posts_of_type($type, $limit = -1, $order = 'date', $ord = 'ASC') {
  return query_posts("posts_per_page=$limit&post_type=$type&orderby=$order&order=$ord");
}

function latest_post_of_type($type, $order = 'date') {
  $posts = latest_posts_of_type($type, 1, $order);
  return $posts[0];
}

?>
