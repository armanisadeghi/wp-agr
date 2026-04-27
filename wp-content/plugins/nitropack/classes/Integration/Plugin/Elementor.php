<?php

namespace NitroPack\Integration\Plugin;

class Elementor {

	const STAGE = "late";

	public static function isActive() {
		$activePlugins = apply_filters('active_plugins', get_option('active_plugins'));
		if (defined('ELEMENTOR_PRO_VERSION') || in_array( 'elementor-pro/elementor-pro.php', $activePlugins )) {
			return true;
		}
		if (defined('ELEMENTOR_VERSION') || in_array( 'elementor/elementor.php', $activePlugins )) {
			return true;
		}
		return false;
	}

	public function init($stage) {
		if ( ! self::isActive() ) {
			return;
		}

		add_action( 'save_post', array($this, 'purge_cache_on_custom_code_snippet_update'), 10, 3 );
		add_action( 'elementor/core/files/clear_cache', array($this, 'purge_cache_on_global_settings_update'), 10, 0);
	}

	public function purge_cache_on_custom_code_snippet_update( $post_id, $post, $update ) {

		if ( 'elementor_snippet' !== $post->post_type || defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || 'auto-draft' === $post->post_status ) {
			return;
		}

		if( strpos( wp_get_raw_referer(), 'post-new' ) > 0 ) {

			if ( empty( $_POST['code'] ) ) {
				return;
			}

			/* If new snippet is added */
			nitropack_sdk_invalidate(NULL, NULL, 'Elementor Custom Code Snippet Added');

		} else {

			/* If old snippet is Updated */
			nitropack_sdk_invalidate(NULL, NULL, 'Elementor Custom Code Snippet Updated');

		}

	}

	/**
 	* Listen for Elementor CSS Cache Clearing (The "Regenerate CSS" Tool)
 	* Perform light cache purge
 	*/
	public function purge_cache_on_global_settings_update() {
		if ( function_exists( 'nitropack_sdk_purge' ) ) {
			if ( nitropack_sdk_purge( NULL, NULL, 'Light purge, because of Elementor Settings/CSS Update', \NitroPack\SDK\PurgeType::LIGHT_PURGE )) {
				\NitroPack\WordPress\NitroPack::getInstance()->getLogger()->notice( 'Light purge, because of Elementor Settings/CSS Update' );
			}
		}
	} 

}
