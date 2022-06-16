<?php
if(function_exists('acf_add_options_page')) {
	
	acf_add_options_page([
    'page_title' 	=> __('Theme General Settings', 'ccs'),
		'menu_title'	=> __('Theme Settings', 'ccs'),
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
  ]);
	
}
