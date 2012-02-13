<?php get_header(); ?>

<div role="main">
  <article id="post-0" class="post error404 not-found">
    <header>
      <h1><?php _e('Nothing Found', 'essence'); ?></h1>
    </header>

    <div class="entry-content">
      <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'essence'); ?></p>
      <?php get_search_form(); ?>
    </div>
  </article>
</div>

<?php get_footer(); ?>
