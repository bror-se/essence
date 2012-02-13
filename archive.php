<?php get_header(); ?>

<div role="main">
  <?php if (have_posts()) : ?>
    <header>
      <h1>
        <?php
          $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
          if ($term) {
            echo $term->name;
          } elseif (is_day()) {
            printf(__('Daily Archives: %s', 'essence'), get_the_date());
          } elseif (is_month()) {
            printf(__('Monthly Archives: %s', 'essence'), get_the_date('F Y'));
          } elseif (is_year()) {
            printf(__('Yearly Archives: %s', 'essence'), get_the_date('Y'));
          } elseif (is_author()) {
            global $post;
            $author_id = $post->post_author;
            printf(__('Author Archives: %s', 'essence'), get_the_author_meta('user_nicename', $author_id));
          } else {
            single_cat_title();
          }
        ?>
      </h1>
    </header>

    <?php while (have_posts()) : the_post(); ?>
      <?php get_template_part('loop', get_post_format()); // Loop posts ?>
    <?php endwhile; ?>

    <?php essence_content_nav() ?>

  <?php else: ?>

    <?php // If there is no posts ?>
    <article id="post-0" class="post no-results not-found">
      <header>
        <h1><?php _e('Nothing Found', 'essence'); ?></h1>
      </header>

      <div class="entry-content">
        <p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'essence'); ?></p>
        <?php get_search_form(); ?>
      </div>
    </article>

  <?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer() ?>
