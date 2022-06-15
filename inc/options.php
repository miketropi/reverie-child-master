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

if( function_exists('acf_add_local_field_group') ):

  acf_add_local_field_group(array(
    'key' => 'group_62a97dab305fc',
    'title' => 'Theme Settings',
    'fields' => array(
      array(
        'key' => 'field_62a97dc7b1665',
        'label' => 'General Settings',
        'name' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'placement' => 'top',
        'endpoint' => 0,
      ),
      array(
        'key' => 'field_62a97de0b1666',
        'label' => 'Mobile Logo',
        'name' => 'theme_mobile_logo',
        'type' => 'file',
        'instructions' => 'Select mobile logo',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'return_format' => 'url',
        'library' => 'all',
        'min_size' => '',
        'max_size' => '',
        'mime_types' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'options_page',
          'operator' => '==',
          'value' => 'theme-general-settings',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'left',
    'instruction_placement' => 'field',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
  ));
  
  endif;