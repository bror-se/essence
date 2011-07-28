<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Essence
 */

get_header(); ?>

  <div role="main">

    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'loop', 'single' ); ?>

      <nav>
        <ul>
          <li><?php previous_post_link( '&larr; %link' ); ?></li>
          <li><?php next_post_link( '%link &rarr;' ); ?></li>
        </ul>
      </nav>

      <?php comments_template( '', true ); ?>

    <?php endwhile; ?>

  </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>