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

      <header>
        <h1><?php printf(__('Search Results for: %s', 'essence'), get_search_query()); ?></h1>
      </header>
      <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part( 'loop', get_post_format()); ?>
      <?php endwhile; ?>
      <?php essence_content_nav(); ?>

    <?php else : ?>

      <article id="post-0" class="post no-results not-found">
        <header>
          <h1><?php _e('Nothing Found', 'essence'); ?></h1>
        </header>
        <p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'essence'); ?></p>
        <?php get_search_form(); ?>
      </article>

    <?php endif; ?>

  </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>