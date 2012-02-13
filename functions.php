<?php
/**
 * Functions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 */

if (!defined('__DIR__'))
  define('__DIR__', dirname(__FILE__));


/**
 * Load helpers
 * Located in /lib/helpers/
 */

require_once locate_template('/lib/helpers/has_children.php');
require_once locate_template('/lib/helpers/is_child.php');
require_once locate_template('/lib/helpers/latest_posts_of_category.php');
require_once locate_template('/lib/helpers/latest_posts_of_type.php');
require_once locate_template('/lib/helpers/new_post_type.php');
require_once locate_template('/lib/helpers/new_taxanomy.php');
require_once locate_template('/lib/helpers/related_posts.php');


/**
 * Load initializers
 * Located in /lib/initializers
 */

require_once locate_template('/lib/initializers/settings.php');
require_once locate_template('/lib/initializers/locale.php');
require_once locate_template('/lib/initializers/menus.php');
require_once locate_template('/lib/initializers/cleanup.php');
require_once locate_template('/lib/initializers/url.php');
require_once locate_template('/lib/initializers/rewrites.php');
require_once locate_template('/lib/initializers/miscellaneous.php');
require_once locate_template('/lib/initializers/robots.php');

?>
