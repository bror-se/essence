<?php
/**
 * Get the latest posts of a category
 */

function latest_posts_of_category($category, $limit, $offset = 0, $post_type = 'post', $taxonomy = 'category',$order = 'date', $ord = 'ASC') {
  return query_posts(array(
    'posts_per_page' => $limit,
    'taxonomy' => $taxonomy,
    'term' => $category,
    'offset' => $offset,
    'post_type' => $post_type,
    'orderby' => $order,
    'order' => $ord
  ));
}

function latest_post_of_category($category, $post_type = 'post', $taxonomy = 'category') {
  $posts = latest_posts_of_category($category, 1, 0, $post_type, $taxonomy);
  return $posts[0];
}

?>
