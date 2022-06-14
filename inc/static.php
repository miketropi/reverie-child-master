<?php 
/**
 * Static
 */

function ccs_enqueue_scripts() {
  /**
   * GG Fonts
   */
  wp_enqueue_style('Oswald-Roboto', 'https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Roboto:wght@300;400;700&display=swap', false);

  wp_enqueue_style('ccs-style', CCS_THEME_URI . '/dist/css/main.css', false, CCS_THEME_VER);
  wp_enqueue_script('ccs-script', CCS_THEME_URI . '/dist/main.js', ['jquery'], CCS_THEME_VER, true);

  wp_localize_script('ccs-script', 'CCS_PHP', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'lang' => []
  ]);
}

add_action('wp_enqueue_scripts', 'ccs_enqueue_scripts');