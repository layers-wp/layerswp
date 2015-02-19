<?php /**
  * Post & Page Meta Configuration File
 *
 * This file is used to define the post meta panels used the layers theme for all post types
 *
 * @package Layers
 * @since Layers 1.0.0
 */

class Layers_Meta_Config {

	public function meta_data(){

		// Post Meta
		$custom_meta['post'] = array(
			'title' => LAYERS_THEME_TITLE . __( ': Options' , 'layerswp' ),
			'description' => __( '' , 'layerswp' ), // @TODO
			'position' => 'normal',
			'custom-meta' => array(
				'media' => array(
					'title' => __( 'Rich Media' , 'layerswp' ),
					'elements' => array(
						'video-url' => array(
							'label' => __( 'Video URL' , 'layerswp' ),
							'description' => __( 'For use with <a href="' . esc_url( 'http://codex.wordpress.org/' ) . 'Embeds" target="_blank">oEmbed</a> supported media' , 'layerswp' ),
							'type' => 'text',
						)
					)
				)
			)
		);

		// Page Meta we just emulate the post meta
		$custom_meta['page'] = $custom_meta['post'];

		return apply_filters( 'layers_custom_meta', $custom_meta );
	}
}