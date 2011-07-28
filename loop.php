<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Essence
 */
?>
<article>
  <header>
    <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', THEME_NAME ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
    <?php if ( 'post' == get_post_type() ) : ?>
      <?php essence_posted_on(); ?>
    <?php endif; ?>

    <?php if ( comments_open() && ! post_password_required() ) : ?>
      <?php comments_popup_link( __( 'Reply', THEME_NAME ), _x( '1 reply', 'comments number', THEME_NAME ), _x( '% replies', 'comments number', THEME_NAME ) ); ?>
    <?php endif; ?>
  </header>

  <?php if (is_archive() || is_search()) : // Only display Excerpts for Archive and Search ?>
    <?php the_excerpt(); ?>
  <?php else : ?>
    <?php the_content( __( 'Continue reading &rarr;', THEME_NAME ) ); ?>
    <?php essence_link_pages(); ?>
  <?php endif; ?>

  <footer>
    <?php $show_sep = false; ?>
    <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
      <?php
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( __( ', ', THEME_NAME ) );
        if ( $categories_list ):
      ?>
      <?php printf( __( 'Posted in %1$s', THEME_NAME ), $categories_list );
      $show_sep = true; ?>
      <?php endif; // End if categories ?>
      <?php
        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', __( ', ', THEME_NAME ) );
        if ( $tags_list ):
        if ( $show_sep ) : ?>
          |
      <?php endif; // End if $show_sep ?>
      <?php printf( __( 'Tagged %1$s', THEME_NAME ), $tags_list );
      $show_sep = true; ?>
      <?php endif; // End if $tags_list ?>
    <?php endif; // End if 'post' == get_post_type() ?>

    <?php if ( comments_open() ) : ?>
      <?php if ( $show_sep ) : ?>
        |
      <?php endif; // End if $show_sep ?>
      <?php comments_popup_link( __( 'Leave a reply', THEME_NAME ), __( '1 reply', THEME_NAME ), __( '% replies', THEME_NAME ) ); ?>
    <?php endif; // End if comments_open() ?>

    <?php edit_post_link( __( 'Edit', THEME_NAME ), ' | ' ); ?>
  </footer>
</article>