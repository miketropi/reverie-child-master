<?php

add_filter( 'acf/settings/save_json', 'accs__acf_json_save_point' );
function accs__acf_json_save_point( $path ) {
	// update path
	$path = get_stylesheet_directory() . '/acf-options';

	// return
	return $path;
}

add_filter( 'acf/settings/load_json', 'ccs__acf_json_load_point' );
function ccs__acf_json_load_point( $paths ) {
	// remove original path (optional)
	unset( $paths[0] );
	// append path
	$paths[] = get_stylesheet_directory() . '/acf-options';

	// return
	return $paths;
}
