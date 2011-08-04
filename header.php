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
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">

  <title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS concatenated and minified via ant build script-->
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
  <!-- end CSS-->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="<?php echo get_template_directory_uri(); ?>/js/libs/modernizr-2.0.6.min.js"></script>

  <?php
    if ( is_singular() && get_option( 'thread_comments' ) )
      wp_enqueue_script( 'comment-reply' );
    wp_head();
  ?>
</head>
<body <?php body_class(); ?>>
  <header role="banner">
    <hgroup>
      <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
      <h2><?php bloginfo( 'description' ); ?></h2>
    </hgroup>
    <nav role="navigation">
      <?php
      wp_nav_menu( array(
        'theme_location' => 'primary_navigation',
        'container' => '',
        'walker' => new essence_nav_walker()
      ) );
      ?>
    </nav>
  </header>