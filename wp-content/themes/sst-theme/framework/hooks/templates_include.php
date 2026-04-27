<?php

function mok_dynamic_sections() {
	$location = get_template_directory() . '/templates/sections';// location of icon
	if ( file_exists( $location ) ) {
		$sections = scandir( $location ); // getting all sections file names
		$count    = 1;
		foreach ( $sections as $section ) {
			$section_name = explode( '.', $section ); // removing extensions
			if ( $count > 2 ) { // removes first ' . ' and ' ..' from scandir array
				get_template_part( 'templates/sections/' . $section_name[0] );
			}
			$count ++;
		}
	}
}

add_action( 'mok_bottom_content', 'mok_dynamic_sections' );