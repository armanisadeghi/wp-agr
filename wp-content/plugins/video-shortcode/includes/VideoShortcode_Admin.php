<?php

/**
 * Class VideoShortcode_Admin
 * @version 1.0.0
 * @package Video Shotcode
 */
class VideoShortcode_Admin extends WDS_Shortcode_Admin {

    function js_button_data() {
        return [
            'qt_button_text' => __( 'Video Shortcode', 'video-shortcode' ),
            'button_tooltip' => __( 'Video Shortcode', 'video-shortcode' ),
            'icon'           => 'dashicons-media-interactive',
//			'include_close'  => true,
            'mceView'        => true,
        ];
    }

    function fields( $fields, $button_data ) {
        $fields[] = [
            'name'    => __( 'Video URL', 'video-shortcode' ),
            'desc'    => __( 'Add video link', 'video-shortcode' ),
            'type'    => 'text_url',
            'id'      => 'vds_video_link',
            'default' => $this->atts_defaults['vds_video_link'],
        ];

        $fields[] = [
            'name'    => __( 'Video Image Text', 'video-shortcode' ),
            'desc'    => __( 'Alternate text for video', 'video-shortcode' ),
            'type'    => 'text',
            'id'      => 'vds_image_title',
            'default' => $this->atts_defaults['vds_image_link'],
        ];

        $fields[] = [
            'name'    => __( 'Video Image Placeholder', 'video-shortcode' ),
            'desc'    => __( 'Upload placeholder image for video', 'video-shortcode' ),
            'type'    => 'file',
            'id'      => 'vds_image_link',
            'default' => $this->atts_defaults['vds_image_link'],
        ];

        return $fields;
    }
}