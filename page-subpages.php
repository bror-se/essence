<?php
/**
   Template Name: List Subpages
 *
 * The template for displaying all sub pages.
 *
 * @package WordPress
 * @subpackage Essence
 */

get_header(); ?>

  <div role="main">

    <?php the_post(); ?>
    <?php get_template_part('loop', 'page'); ?>
    <?php
      $children = wp_list_pages('title_li=&child_of='.$post->ID.'&echo=0');
      if ($children) { ?>
      <ul>
        <?php echo $children; ?>
      </ul>
    <?php } ?>
    <?php comments_template('', true); ?>

  </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>