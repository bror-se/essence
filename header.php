<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
  <meta charset="utf-8">

  <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width">

  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Feed" href="<?php echo home_url(); ?>/feed/">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">

  <script src="<?php echo get_template_directory_uri(); ?>/js/libs/modernizr-2.5.2.min.js"></script>

  <?php if (is_singular() && get_option('thread_comments'))
    wp_enqueue_script('comment-reply');
    wp_head();
  ?>
</head>
<body <?php body_class(essence_body_class()); ?>>

  <div class="container">
    <header role="banner">
      <h1><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
      <h2><?php bloginfo('description'); ?></h2>
    </header>

    <nav role="navigation">
      <?php wp_nav_menu(array(
        'theme_location' => 'primary_navigation',
        'walker' => new Essence_Navbar_Nav_Walker()
      ));
      ?>
    </nav>
