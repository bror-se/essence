<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div role="main">
 *
 * @package Wordpress
 * @subpackage Essence
 */
?><!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <title><?php
  /*
   * Print the <title> tag based on what is being viewed.
   */
  global $page, $paged;

  wp_title('|', true, 'right');

  // Add the blog name.
  bloginfo('name');

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo('description', 'display');
  if ($site_description && (is_home() || is_front_page()))
    echo " | $site_description";

  // Add a page number if necessary:
  if ($paged >= 2 || $page >= 2)
    echo ' | ' . sprintf(__('Page %s', 'essence'), max($paged, $page));

  ?></title>
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
  <script src="<?php echo get_template_directory_uri(); ?>/js/libs/modernizr-2.0.6.min.js"></script>
  <?php
  if (is_singular() && get_option('thread_comments'))
    wp_enqueue_script('comment-reply');
  wp_head();
  ?>
</head>
<body>

  <header role="banner">
    <hgroup>
      <h1><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
      <h2><?php bloginfo('description'); ?></h2>
    </hgroup>
  </header>

  <nav role="navigation">
    <?php wp_nav_menu(array(
      'theme_location' => 'primary_navigation',
      'container' => '',
      'walker' => new essence_nav_walker()
    ));
    ?>
  </nav>
