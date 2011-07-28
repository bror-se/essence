<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Essence
 */

get_header(); ?>

  <div role="main">

  <?php if ( have_posts() ) : ?>

    <header>
      <h1><?php
        printf( __( 'Category Archives: %s', THEME_NAME ), single_cat_title( '', false ) );
      ?></h1>

      <?php
        $category_description = category_description();
        if ( ! empty( $category_description ) )
          echo apply_filters( 'category_archive_meta' . $category_description );
      ?>
    </header>

    <?php essence_content_nav(); ?>

    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'loop', get_post_format() ); ?>

    <?php endwhile; ?>

    <?php essence_content_nav(); ?>

  <?php else : ?>

    <article>
      <header>
        <h1><?php _e( 'Nothing Found', THEME_NAME ); ?></h1>
      </header>

      <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', THEME_NAME ); ?></p>
      <?php get_search_form(); ?>
    </article>

  <?php endif; ?>

  </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>