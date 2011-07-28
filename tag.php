<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package WordPress
 * @subpackage Essence
 */

get_header(); ?>

  <div role="main">

  <?php if ( have_posts() ) : ?>

    <header>
      <h1><?php
        printf( __( 'Tag Archives: %s', THEME_NAME ), single_tag_title( '', false ) );
      ?></h1>

      <?php
        $tag_description = tag_description();
        if ( ! empty( $tag_description ) )
          echo apply_filters( 'tag_archive_meta', $tag_description );
      ?>
    </header>

    <?php essence_content_nav(); ?>

    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'content', get_post_format() ); ?>

    <?php endwhile; ?>

    <?php essence_content_nav(); ?>

  <?php else : ?>

    <article>
      <header>
        <h1><?php _e( 'Nothing Found', THEME_NAME ); ?></h1>
      </header>

      <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', THEME_NAME ); ?></p>
      <?php get_search_form(); ?>
    </article><!-- #post-0 -->

  <?php endif; ?>

  </section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
