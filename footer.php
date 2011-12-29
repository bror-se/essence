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
  <?php
  if (! is_404())
    get_sidebar('footer');
  ?>
  <a href="<?php echo esc_url(__('http://wordpress.org/', 'essence')); ?>" title="<?php esc_attr_e('Semantic Personal Publishing Platform', 'essence'); ?>"><?php printf( __('Proudly powered by %s', 'essence'), 'WordPress'); ?></a>
</footer>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/lib/jquery-1.7.1.min.js"><\/script>')</script>

<!-- scripts concatenated and minified via build script -->
<script defer src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
<!-- end scripts -->

<script>
  var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

<!--[if lt IE 7 ]>
<script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
<script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->

<?php wp_footer(); ?>

</body>
</html>
