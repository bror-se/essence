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

<div role="main">
  <?php if (have_posts()) : ?>

    <header class="page-header">
      <h1 class="page-title">
        <?php if (is_day()) : ?>
          <?php printf(__('Daily Archives: %s', 'essence'), '<span>' . get_the_date() . '</span>'); ?>
        <?php elseif (is_month()) : ?>
          <?php printf(__('Monthly Archives: %s', 'essence'), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'essence')) . '</span>'); ?>
        <?php elseif (is_year()) : ?>
          <?php printf(__('Yearly Archives: %s', 'essence'), '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'essence')) . '</span>'); ?>
        <?php else : ?>
          <?php _e('Blog Archives', 'essence'); ?>
        <?php endif; ?>
      </h1>
    </header>

    <?php /* Start the Loop */ ?>
    <?php while (have_posts()) : the_post(); ?>
      <?php get_template_part('loop', get_post_format()); ?>
    <?php endwhile; ?>
    <?php essence_content_nav('page-nav'); ?>

  <?php else : ?>

    <article id="post-0" class="post no-results not-found">
      <header class="entry-header">
        <h1 class="entry-title"><?php _e('Nothing Found', 'essence'); ?></h1>
      </header>

      <div class="entry-content">
        <p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'essence'); ?></p>
        <?php get_search_form(); ?>
      </div>
    </article>

  <?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
