<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Essence
 */

get_header(); ?>

  <div role="main">

    <?php the_post(); ?>

    <?php get_template_part( 'loop', 'page' ); ?>

    <?php comments_template( '', true ); ?>

  </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>