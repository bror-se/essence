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
    <a href="<?php echo esc_url(__('http://wordpress.org/', 'essence')); ?>" title="<?php esc_attr_e('Semantic Personal Publishing Platform', 'essence'); ?>" rel="generator"><?php printf(__('Proudly powered by %s', 'essence'), 'WordPress'); ?></a>
  </footer>

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/libs/jquery-1.6.4.min.js"><\/script>')</script>

  <!-- scripts concatenated and minified via build script -->
  <script defer src="<?php echo get_template_directory_uri(); ?>/js/plugins.js"></script>
  <script defer src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
  <!-- end scripts -->

  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
  <script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview'],['_trackPageLoadTime']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

  <?php wp_footer(); ?>

</body>
</html>