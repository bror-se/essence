<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Essence
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <header>
    <h1><?php the_title(); ?></h1>
    <?php essence_entry_meta(); ?>
  </header>

  <?php the_content(); ?>
  <?php essence_link_pages(); ?>

  <footer>
    <p><?php the_tags(); ?></p>
  </footer>

</article>