<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Essence
 */

get_header(); ?>

  <div rol="main">

    <?php if ( have_posts() ) : ?>

      <header>
        <h1>
          <?php if (is_day()) : ?>
            <?php printf(__('Daily Archives: %s', 'essence'), get_the_date()); ?>
          <?php elseif (is_month()) : ?>
            <?php printf(__('Monthly Archives: %s', 'essence'), get_the_date('F Y')); ?>
          <?php elseif (is_year()) : ?>
            <?php printf(__('Yearly Archives: %s', 'essence'), get_the_date('Y')); ?>
          <?php else : ?>
            <?php single_cat_title(); ?>
          <?php endif; ?>
        </h1>
      </header>
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