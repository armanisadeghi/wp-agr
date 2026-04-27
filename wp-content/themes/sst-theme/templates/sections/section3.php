<?php
global $sections;
$sections = get_post_meta( $post->ID, '_ttm_section_group', 1 );
get_template_part( 'common/content', 'section' );
	