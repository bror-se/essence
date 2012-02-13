<?php get_header(); ?>

<div role="main">
  <?php if (have_posts()) : ?>

    <header>
      <h1><?php _e('Search Results for', 'essence'); ?> <?php echo get_search_query(); ?></h1>
    </header>

    <?php while (have_posts()) : the_post(); ?>
      <?php get_template_part('loop', get_post_format()); // Loop posts ?>
    <?php endwhile; ?>

    <?php essence_content_nav() ?>

  <?php else : ?>

    <article id="post-0" class="post no-results not-found">
      <header>
        <h1><?php _e('Nothing Found', 'essence'); ?>></h1>
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
