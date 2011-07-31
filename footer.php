<?php
/**
 * The template for displaying the footer.
 *
 * Contains the content after the closing div role=main
 *
 * @package WordPress
 * @subpackage Essence
 */
?>

  <footer role="contentinfo">
    <a href="<?php echo esc_url( __( 'http://wordpress.org/', THEME_NAME ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', THEME_NAME ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', THEME_NAME ), 'WordPress' ); ?></a>
  </footer>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/libs/jquery-1.6.2.min.js"><\/script>')</script>

  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="<?php echo get_template_directory_uri(); ?>/js/plugins.js"></script>
  <script defer src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
  <!-- end scripts-->

  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

  <?php wp_footer(); ?>

</body>
</html>