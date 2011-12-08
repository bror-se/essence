<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Essence
 */

get_header(); ?>

<div role="main">
  <?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('loop', 'single'); ?>
    <nav id="page-nav">
      <h3><?php _e('Post navigation', 'essence'); ?></h3>
      <div class="previous"><?php previous_post_link('%link', __('&larr; Previous', 'essence')); ?></div>
      <div class="next"><?php next_post_link('%link', __('Next &rarr;', 'essence')); ?></div>
    </nav>
    <?php comments_template('', true); ?>

  <?php endwhile; // End of the loop ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
