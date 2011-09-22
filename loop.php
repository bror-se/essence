<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Essence
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <header>
    <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
    <?php roots_entry_meta(); ?>
  </header>

  <?php if (is_archive() || is_search()) : // Only display Excerpts for Archive and Search ?>
    <?php the_excerpt(); ?>
  <?php else : ?>
    <?php the_content(__('Continue reading &rarr;', 'essence')); ?>
  <?php endif; ?>

  <footer>
    <?php $tag = get_the_tags(); if (!$tag) { } else { ?><p><?php the_tags(); ?></p><?php } ?>
  </footer>

</article>