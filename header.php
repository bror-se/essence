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
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">

  <title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
  <script src="<?php echo get_template_directory_uri(); ?>/js/libs/modernizr-2.0.6.min.js"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/js/libs/respond.min.js"></script>

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