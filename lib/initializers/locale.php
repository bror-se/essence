<?php
/**
 * Make theme available for translation.
 * Translations can be added to the /config/locale directory.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 */

function essence_language_setup() {
  load_theme_textdomain('essence', get_template_directory() . '/lang');
}
add_action('after_setup_theme', 'essence_language_setup');
