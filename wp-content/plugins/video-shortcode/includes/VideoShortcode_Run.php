<?php

/**
 * Class VideoShortcode_Run
 * @version 1.0.0
 * @package Video Shotcode
 */
class VideoShortcode_Run extends WDS_Shortcodes {
	/**
	 * The Shortcode Tag
	 * @var string
	 */
	public $shortcode = 'vds';

	/**
	 * Default attributes applied to the shortcode.
	 * @var array
	 */
	public $atts_defaults = [
		'vds_video_link'  => '',
		'vds_image_title' => '',
		'vds_image_link'  => '',
	];

	/**
	 * Whether css has been output yet.
	 * @var bool
	 */
	protected static $css_done = false;

	/**
	 * Whether js has been output yet.
	 * @var bool
	 */
	protected static $js_done = false;

	/**
	 * Shortcode Output
	 */
	public function shortcode() {

		$video_link  = esc_url( $this->att( 'vds_video_link' ) );
		$image_link  = esc_url( $this->att( 'vds_image_link' ) );
		$image_title = wp_strip_all_tags( $this->att( 'vds_image_title' ) );
		$video_embed = $this->getYoutubeEmbedUrl( $video_link ) ? $this->getYoutubeEmbedUrl( $video_link ) : $this->getVimeoEmbedUrl( $video_link );
		$output      = '';
//		$output .= $this->css();
		$output .= '<figure class="ytb-iframe"><img src="' . $image_link . '" data-video="' . $video_embed . '" alt="'.$image_title.'"></figure>';
//		$output .= $this->js();

		return $output;
	}

	public function css() {
		// Only output once, not once per shortcode.
		if ( self::$css_done ) {
			return '';
		}

		ob_start();
		?>
		<style>
			.ytb-iframe {
				position: relative;
				cursor: pointer;
			}

			.ytb-iframe:after {
				content: "";
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				display: inline-block;
				background: url("<?php echo plugins_url( 'assets/ytb-player.png', dirname(__FILE__) ); ?>") no-repeat -78px -8px;
				width: 66px;
				height: 41px;
			}

			.ytb-iframe:hover:after {
				background-position: -5px -8px;
			}

			.ytb-iframe.active:after {
				display: none;
			}
		</style>
		<?php

		self::$css_done = true;

		return ob_get_clean();
	}

	public function js() {
		// Only output once, not once per shortcode.
		if ( self::$js_done ) {
			return '';
		}

		ob_start();
		?>
		<script>
			jQuery(document).ready(function () {
				jQuery('.ytb-iframe').click(function () {
					var video = '<iframe width="560" height="315" src="' + jQuery(this).find('img').attr('data-video') + '?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1" frameborder="0" allowfullscreen></iframe>';
					jQuery(this).find('img').replaceWith(video);
					jQuery(this).addClass('active');
				});
			});
		</script>
		<?php

		self::$js_done = true;

		return ob_get_clean();
	}

	/**
	 * Extracts the vimeo id from a vimeo url.
	 * Returns false if the url is not recognized as a vimeo url.
	 *
	 * @param $url
	 *
	 * @return bool
	 */
	private function getVimeoEmbedUrl( $url ) {
		if ( preg_match( '#(?:https?://)?(?:www.)?(?:player.)?vimeo.com/(?:[a-z]*/)*([0-9]{6,11})[?]?.*#', $url, $m ) ) {
			return 'https://player.vimeo.com/video/' . $m[1] . '?title=0&amp;byline=0&amp;portrait=0';
		}

		return false;
	}

	/**
	 * Extracts the youtube id from a youtube url.
	 * Returns false if the url is not recognized as a youtube url.
	 *
	 * @param $url
	 *
	 * @return bool
	 */
	private function getYoutubeEmbedUrl( $url ) {
		$parts = parse_url( $url );
		if ( isset( $parts['host'] ) ) {
			$host = $parts['host'];
			if (
				false === strpos( $host, 'youtube' ) &&
				false === strpos( $host, 'youtu.be' )
			) {
				return false;
			}
		}
		if ( isset( $parts['query'] ) ) {
			parse_str( $parts['query'], $qs );
			if ( isset( $qs['v'] ) ) {
				return 'https://www.youtube.com/embed/' . $qs['v'];
			} else if ( isset( $qs['vi'] ) ) {
				return 'https://www.youtube.com/embed/' . $qs['vi'];
			}
		}
		if ( isset( $parts['path'] ) ) {
			$path = explode( '/', trim( $parts['path'], '/' ) );

			return 'https://www.youtube.com/embed/' . $path[ count( $path ) - 1 ];
		}

		return false;
	}
}