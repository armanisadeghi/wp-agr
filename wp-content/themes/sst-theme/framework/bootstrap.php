<?php
/**
 * Loads post type and taxonomy
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Framework
 * @version 1.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

use Moksha\Core\PostType;

function mok_set_post_type_taxonomy() {
	$customPostType = new PostType();
	$postType             = [ ];
	$customPostType->createPostType( array_merge( $postType, apply_filters( 'mok_custom_post_type', [ ] ) ) );
	$taxonomy = [ ];
	$customPostType->addTaxonomy( array_merge_recursive( $taxonomy, apply_filters( 'mok_custom_taxonomy', [ ] ) ) );
}

add_action( 'init', 'mok_set_post_type_taxonomy', 99 );