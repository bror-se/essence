<?php
/**
   Template Name: Sitemap
 *
 * The template for displaying a sitemap.
 *
 * @package WordPress
 * @subpackage Essence
 */

get_header(); ?>

  <div role="main">

    <?php the_post(); ?>
    <?php get_template_part('loop', 'page'); ?>
    <h2><?php _e('Pages', 'essence'); ?></h2>
    <ul><?php wp_list_pages('sort_column=menu_order&depth=0&title_li='); ?></ul>
    <h2><?php _e('Posts', 'essence'); ?></h2>
    <ul><?php wp_list_categories('title_li=&hierarchical=0&show_count=1'); ?></ul>
    <h2><?php _e('Archives', 'essence'); ?></h2>
    <ul><?php wp_get_archives('type=monthly&limit=12'); ?></ul>
    <?php comments_template('', true); ?>

  </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>