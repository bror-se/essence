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

    <?php if ( have_posts() ) : ?>

      <header>
        <h1>
          <?php if ( is_day() ) : ?>
            <?php printf( __( 'Daily Archives: %s', THEME_NAME ), get_the_date() ); ?>
          <?php elseif ( is_month() ) : ?>
            <?php printf( __( 'Monthly Archives: %s', THEME_NAME ), get_the_date( 'F Y' ) ); ?>
          <?php elseif ( is_year() ) : ?>
            <?php printf( __( 'Yearly Archives: %s', THEME_NAME ), get_the_date( 'Y' ) ); ?>
          <?php else : ?>
            <?php _e( 'Blog Archives', THEME_NAME ); ?>
          <?php endif; ?>
        </h1>
      </header>

      <?php essence_content_nav(); ?>

      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'loop', get_post_format() ); ?>

      <?php endwhile; ?>

      <?php essence_content_nav(); ?>

    <?php else : ?>

      <article>
        <heade>
          <h1><?php _e( 'Nothing Found', THEME_NAME ); ?></h1>
        </header>

        <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', THEME_NAME ); ?></p>
        <?php get_search_form(); ?>
      </article>

    <?php endif; ?>

  </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>