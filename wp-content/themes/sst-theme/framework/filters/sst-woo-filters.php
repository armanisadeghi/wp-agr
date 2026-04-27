<?php
/**
 * List of all custom filters used for woocommerce only
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Framework
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

/**
 * Woocommerce mini cart icon and link
 */
function mok_cart_link() { ?>
    <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>"
       title="<?php esc_attr_e( 'View your shopping cart', '_mok' ); ?>">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             width="20px" height="20px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                        <path id="cart_3-svg" d="M189,192.303c8.284,0,15-6.717,15-15V132c0-28.673,23.328-52,52-52c28.674,0,52,23.327,52,52
                        v45.303c0,8.283,6.716,15,15,15s15-6.717,15-15V132c0-45.287-36.713-82-82-82s-82,36.713-82,82v45.303
                        C174,185.586,180.716,192.303,189,192.303z M417.416,462H94.584l30.555-281.667h25.993c1.551,19.54,17.937,34.97,37.868,34.97
                        s36.317-15.43,37.868-34.97h58.264c1.551,19.54,17.937,34.97,37.868,34.97s36.317-15.43,37.868-34.97h26.103L417.416,462z"></path>
                        </svg>
        <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    </a>
	<?php
}

/**
 * Update woocommerce mini cart in ajax add to cart trigger
 *
 * @param $fragments
 *
 * @return mixed
 */
function mok_cart_link_fragment( $fragments ) {
	ob_start();
	mok_cart_link();
	$fragments['a.cart-contents'] = ob_get_clean();

	return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'mok_cart_link_fragment' );

/**
 * Changed woocommerce breadcrumb structure
 * @return array
 */
function mok_woocommerce_breadcrumbs() {
	return [
		'delimiter'   => ' &raquo; ',
		'wrap_before' => '<div class="breadcrumb">',
		'wrap_after'  => '</div>',
		'before'      => '<span>',
		'after'       => '</span>',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
	];
}

add_filter( 'woocommerce_breadcrumb_defaults', 'mok_woocommerce_breadcrumbs' );

/**
 * Changed woocommerce delimiter
 *
 * @param $defaults
 *
 * @return mixed
 */
function mok_change_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = ' &raquo; ';

	return $defaults;
}

add_filter( 'woocommerce_breadcrumb_defaults', 'mok_change_breadcrumb_delimiter' );