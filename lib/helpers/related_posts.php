<?php
/**
 * Related posts without plugin, based on tags and categories
 *
 * @args int $numberposts: How many posts to be shown. Defaults to 5.
 * @return An unordered list of related posts.
 */

function the_related_posts($numberposts = 5) {
  echo '<ul>';
    global $post;
    $tags = wp_get_post_tags($post->ID);

    if($tags) {
      foreach($tags as $tag) { $tag_string .= $tag->slug . ','; }

      $args = array(
        'tag' => $tag_string,
        'numberposts' => $numberposts,
        'post__not_in' => array($post->ID)
      );

      $related_posts = get_posts($args);
      if($related_posts) {
        foreach ($related_posts as $post) : setup_postdata($post); ?>
          <li>
            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
          </li>
        <?php endforeach;

      } else { ?>

        <li><?php _e('There are no related posts!', 'essence'); ?></li>

     <?php }
    }
  wp_reset_query();
  echo '</ul>';
}

?>
