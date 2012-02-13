    <footer role="contentinfo">
      <?php dynamic_sidebar('footer-widget'); ?>
    </footer>

  </div>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/libs/jquery-1.7.1.min.js"><\/script>')</script>

  <!-- scripts concatenated and minified via build script -->
  <script defer src="<?php echo get_template_directory_uri(); ?>/js/plugins.js"></script>
  <script defer src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
  <!-- end scripts -->

  <?php wp_footer(); ?>

</body>
</html>
