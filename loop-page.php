<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Essence
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <h1 class="entry-title"><?php the_title(); ?></h1>
  </header>

  <div class="entry-content">
    <?php the_content(); ?>
    <?php wp_link_pages(array('before' => '<div class="page-link"><span>' . __('Pages:', 'essence') . '</span>', 'after' => '</div>')); ?>
  </div>
  <footer class="entry-meta">
    <?php edit_post_link(__('Edit', 'essence'), '<span class="edit-link">', '</span>'); ?>
  </footer>
</article>
