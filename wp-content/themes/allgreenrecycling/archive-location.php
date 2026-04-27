<?php
/**
 * The template for displaying archive page for location post type
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.5.1
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header();
$sst_option        = get_option( 'sst_option' );
$location_template = is_array( $sst_option )
                     && array_key_exists( 'location-default-template', $sst_option )
	? $sst_option['location-default-template'] : 'location';
get_template_part( 'common/content', $location_template );
get_footer();