<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Essence
 */

get_header(); ?>

  <div role="main">

    <?php if (have_posts()) : ?>

      <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('loop', get_post_format()); ?>
      <?php endwhile; ?>
      <?php essence_content_nav(); ?>

    <?php else : ?>

      <article id="post-0" class="post no-results not-found">
        <header>
          <h1><?php _e('Nothing Found', 'essence'); ?></h1>
        </header>
        <p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'essence'); ?></p>
        <?php get_search_form(); ?>
      </article>

    <?php endif; ?>

  </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>