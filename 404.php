<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Essence
 */

get_header(); ?>

  <div role="main">

    <article>
      <header>
        <h1><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', THEME_NAME ); ?></h1>
      </header>

      <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', THEME_NAME ); ?></p>

      <?php get_search_form(); ?>

      <?php the_widget( 'WP_Widget_Recent_Posts', array(
        'number' => 10
      ),
      array(
        'widget_id' => '404',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2>'
      ) ); ?>

      <h2><?php _e( 'Most Used Categories', THEME_NAME ); ?></h2>
      <ul>
      <?php wp_list_categories( array(
        'orderby' => 'count',
        'order' => 'DESC',
        'show_count' => 1,
        'title_li' => '',
        'number' => 10
      ) ); ?>
      </ul>

      <?php
      /* translators: %1$s: smilie */
      $archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', THEME_NAME ), convert_smilies( ':)' ) ) . '</p>';
      the_widget( 'WP_Widget_Archives', array(
        'count' => 0 ,
        'dropdown' => 1
      ),
      array(
        'after_title' => '</h2>'.$archive_content
      ) );
      ?>

      <?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

    </article>

  </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>