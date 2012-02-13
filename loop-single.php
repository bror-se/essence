<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header>
    <h1><?php the_title(); ?></h1>
    <?php if ('post' == get_post_type()) : ?>
      <?php essence_entry_meta(); ?>
    <?php endif; ?>
  </header>

  <div class="entry-content">
    <?php the_content(); ?>
  </div>

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
