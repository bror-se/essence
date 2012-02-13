<?php get_header(); ?>

<div role="main">
  <?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('loop', 'single'); // Loop our content ?>

    <?php essence_content_nav() ?>

    <?php comments_template('', true); // Include comment template ?>

  <?php endwhile; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
