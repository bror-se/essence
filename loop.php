<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Essence
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'essence'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

    <?php if ('post' == get_post_type()) : ?>
    <div class="entry-meta">
      <?php essence_entry_meta(); ?>
    </div>
    <?php endif; ?>
  </header>

  <?php if (is_search()) : // Only display Excerpts for Search ?>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
  <?php else : ?>
  <div class="entry-content">
    <?php the_content(__('Continue reading &rarr;', 'essence')); ?>
    <?php wp_link_pages(array(
      'before' => '<div class="page-link"><span>' . __('Pages:', 'essence') . '</span>',
      'after' => '</div>'
    ));
    ?>
  </div>
  <?php endif; ?>

  <footer class="entry-meta">
    <?php if ('post' == get_post_type()) : // Hide category and tag text for pages on Search ?>
    <?php
      $categories_list = get_the_category_list(__(', ', 'essence'));
      if ( $categories_list ):
    ?>
    <span class="cat-links">
      <?php printf(__('<span class="%1$s">Posted in</span> %2$s', 'essence'), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list); ?>
    </span>
    <?php endif; // End if categories ?>

    <?php
    $tags_list = get_the_tag_list('', __(', ', 'essence'));
    if ($tags_list): ?>
    <span class="tag-links">
      <?php printf(__('<span class="%1$s">Tagged</span> %2$s', 'essence'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list); ?>
    </span>
    <?php endif; // End if $tags_list ?>
    <?php endif; // End if 'post' == get_post_type() ?>

    <?php if ( comments_open() ) : ?>
    <span class="comments-link"><?php comments_popup_link('<span class="leave-reply">' . __('Leave a reply', 'essence') . '</span>', __('<b>1</b> comment', 'essence'), __('<b>%</b> comments', 'essence'));?></span>
    <?php endif; // End if comments_open() ?>

    <?php edit_post_link(__('Edit', 'essence'), '<span class="edit-link">', '</span>'); ?>
  </footer>
</article>
