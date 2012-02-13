<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header>
    <h2><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'essence'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
    <?php if ('post' == get_post_type()) : ?>
      <?php essence_entry_meta(); ?>
    <?php endif; ?>
  </header>

  <?php if (is_archive() || is_search()) : // Only display Excerpts for Search and Archives ?>
    <div class="entry-content">
      <?php the_excerpt(); ?>
    </div>
  <?php else : ?>
    <div class="entry-content">
      <?php the_content(__('Continue reading &rarr;', 'essence')); ?>
    </div>
  <?php endif; ?>

  <footer>
    <?php wp_link_pages(array(
      'before'           => '<nav class="pagination"><ul>',
      'after'            => '</ul></nav>',
      'link_before'      => '<li>',
      'link_after'       => '</li>',
      'next_or_number'   => 'number',
      'nextpagelink'     => __('Next page'),
      'previouspagelink' => __('Previous page'),
      'pagelink'         => '%'
    )); ?>
    <?php $tags = get_the_tags(); if ($tags) : ?>
      <p><?php the_tags(); ?></p>
    <?php endif; ?>
  </footer>
</article>
