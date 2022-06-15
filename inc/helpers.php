<?php 
/**
 * Helpers 
 * 
 */

function ccs_get_field($args = []) {
  return (function_exists('get_field') ? get_field(...$args) : '');
}

/**
 * Load header template.
 * 
 */
function ccs_header($temp = '') {
  $temp_path = CCS_THEME_DIR . '/templates/header/';
  load_template($temp_path . $temp . '.php', false);
}

function ccs_site_logo() {
  $custom_logo_id = get_theme_mod('custom_logo');
  $logo = wp_get_attachment_image_src($custom_logo_id , 'full');
  $mobile_logo = ccs_get_field(['theme_mobile_logo', 'option']);
  if (has_custom_logo()) {
    echo '<a href="'. get_site_url() .'" class="__for-desktop"><img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo('name') . '"></a>';
    echo '<a href="'. get_site_url() .'" class="__for-mobi"><img src="' . esc_url( $mobile_logo ) . '" alt="' . get_bloginfo('name') . '"></a>';
  } else {
    echo '<a href="'. get_site_url() .'">'. get_bloginfo( 'name' ) .'</a>';
  }
}

function ccs_site_nav() {
  wp_nav_menu([
    'theme_location' => 'primary',
    'container' => false,
    'depth' => 0,
    'items_wrap' => '<ul class="site-main-menu">%3$s</ul>',
  ]);
}

function ccs_icon($name = '') {
  $icons = require(CCS_THEME_DIR . '/inc/svg.php');
  return isset($icons[$name]) ? $icons[$name] : '';
}

function ccs_site_header_extra() {
  load_template(CCS_THEME_DIR . '/templates/header/header-tool.php', false);
}