<?php get_header(); ?>

<div role="main">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <?php get_template_part('loop', get_post_format()); // Loop posts ?>

  <?php endwhile; ?>

    <?php essence_content_nav() ?>

  <?php else: ?>

    <?php // If there is no posts ?>
    <article id="post-0" class="post no-results not-found">
      <header>
        <h1><?php _e('Nothing Found', 'essence'); ?></h1>
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
