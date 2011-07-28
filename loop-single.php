<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Essence
 */
?>
<article>
  <heade>
    <h1><?php the_title(); ?></h1>

    <?php if ( 'post' == get_post_type() ) : ?>
      <?php essence_posted_on(); ?>
    <?php endif; ?>
  </header>

  <?php the_content(); ?>
  <?php essence_link_pages(); ?>

  <footer>
    <?php
      /* translators: used between list items, there is a space after the comma */
      $categories_list = get_the_category_list( __( ', ', THEME_NAME ) );

      /* translators: used between list items, there is a space after the comma */
      $tag_list = get_the_tag_list( '', __( ', ', THEME_NAME ) );
      if ( '' != $tag_list ) {
        $utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a> | Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>', THEME_NAME );
      } elseif ( '' != $categories_list ) {
        $utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a> | Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>', THEME_NAME );
      } else {
        $utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a> | Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>', THEME_NAME );
      }

      printf(
        $utility_text,
        $categories_list,
        $tag_list,
        esc_url( get_permalink() ),
        the_title_attribute( 'echo=0' ),
        get_the_author(),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
      );
    ?>

    <?php edit_post_link( __( 'Edit', THEME_NAME ), ' | ' ); ?>
  </footer>
</article>