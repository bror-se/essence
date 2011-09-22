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
<!--[if lt IE 7]> <html <?php language_attributes(); ?> class="no-js ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html <?php language_attributes(); ?> class="no-js ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html <?php language_attributes(); ?> class="no-js ie8 oldie"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
  <meta charset="<?php bloginfo('charset'); ?>">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">

  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Feed" href="<?php echo home_url(); ?>/feed/">

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except this Modernizr build incl. Respond.js
       Respond is a polyfill for min/max-width media queries. Modernizr enables HTML5 elements & feature detects;
       for optimal performance, create your own custom Modernizr build: www.modernizr.com/download/ -->
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
      'walker' => new essence_nav_walker()));
    ?>
  </nav>