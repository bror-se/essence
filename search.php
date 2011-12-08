<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Essence
 */

get_header(); ?>

<div role="main">
  <?php if (have_posts()) : ?>

    <header class="page-header">
      <h1 class="page-title"><?php printf(__('Search Results for: %s', 'essence'), '<span>' . get_search_query() . '</span>'); ?></h1>
    </header>

    <?php /* Start the Loop */ ?>
    <?php while (have_posts()) : the_post(); ?>
      <?php get_template_part('loop', get_post_format()); ?>
    <?php endwhile; ?>
    <?php essence_content_nav('post-nav'); ?>

  <?php else : ?>

    <article id="post-0" class="post no-results not-found">
      <header class="entry-header">
        <h1 class="entry-title"><?php _e('Nothing Found', 'essence'); ?></h1>
      </header>

      <div class="entry-content">
        <p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'essence'); ?></p>
        <?php get_search_form(); ?>
      </div>
    </article>

  <?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
