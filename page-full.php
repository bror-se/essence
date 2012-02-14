<?php get_header(); ?>

<div role="main">
  <?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('loop', 'page'); // Loop our Page content ?>

  <?php endwhile; ?>
</div>

<?php get_footer(); ?>
