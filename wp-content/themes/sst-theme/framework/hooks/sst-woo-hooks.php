<?php
/**
 * List of all custom hooks used for woocommerce only
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Framework
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

if ( ! function_exists( 'mok_woocommerce_share' ) ) {
	/**
	 * Adds social share on woocommerce share
	 */
	function mok_woocommerce_share() {
		global $wp_query;
		$post_id = $wp_query->post->ID;
		$url     = esc_url( get_permalink( $post_id ) );
		$title   = esc_html( get_the_title( $post_id ) ); ?>
        <ul>
            <li>
                <a class="post-share facebook"
                   href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>"
                   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=100,width=200');return false;">Facebook<span></span></a>

            </li>
            <li>
                <a class="post-share twitter"
                   href="https://twitter.com/share?url=<?php echo $url; ?>&text=<?php echo $title; ?>"
                   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Twitter<span></span></a>

            </li>
            <li>
                <a class="post-share gplus" href="https://plus.google.com/share?url=<?php echo $url; ?>"
                   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Google
                    Plus<span></span></a>
            </li>
        </ul>
	<?php }
}
add_action( 'woocommerce_share', 'mok_woocommerce_share' );

if ( ! function_exists( 'mok_woo_quantity_text' ) ) {
	/**
	 * Add select quantity text before quantity
	 */
	function mok_woo_quantity_text() {
		echo '<p>Select Quantity</p>';
	}
}
add_action( 'woocommerce_before_add_to_cart_quantity', 'mok_woo_quantity_text' );

if ( ! function_exists( 'mok_woocommerce_modify' ) ) {
	function mok_woocommerce_modify() {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 10 );
		add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 20 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 25 );
		add_action( 'mok_woo_breadcrumbs', 'woocommerce_breadcrumb', 20 );
	}
}
add_action( 'woocommerce_init', 'mok_woocommerce_modify' );

if ( ! function_exists( 'mok_short_desc_below_title' ) ) {
	/**
	 * Adds short description from post meta
	 */
	function mok_short_desc_below_title() {
		echo '<div class="product-entry">' . carbon_get_the_post_meta( 'below_title_short_desc' ) . '</div>';
	}
}
add_action( 'woocommerce_single_product_summary', 'mok_short_desc_below_title', 5 );

/**
 * fixes disqus comment issue
 */
remove_action( 'pre_comment_on_post', 'dsq_pre_comment_on_post' );

if ( ! function_exists( 'mok_remove_woocommerce_disqus' ) ) {
	/**
	 * Fixes woocommerce review and disqus compatibility issue
	 *
	 * @param $post
	 * @param $query
	 */
	function mok_remove_woocommerce_disqus( $post, $query ) {
		global $post, $wp_query;

		if ( $query->is_main_query() && $post->post_type == 'product' ):
			remove_filter( 'comments_template', 'dsq_comments_template' );
		endif;
	}
}
add_action( 'the_post', 'mok_remove_woocommerce_disqus', 10, 2 );