<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage Essence
 */
?>

<aside role="complementary">
  <?php dynamic_sidebar('sidebar'); ?>
  <section>
    <h3><?php _e('Archives', 'essence'); ?></h3>
    <ul>
      <?php wp_get_archives(array('type' => 'monthly')); ?>
    </ul>
    </section>
</aside>
