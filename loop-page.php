<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Essence
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <header>
    <h1><?php the_title(); ?></h1>
  </header>

  <?php the_content(); ?>
  <?php essence_link_pages(); ?>

  <footer>
    <?php edit_post_link(__('Edit', 'essence')); ?>
  </footer>

</article>