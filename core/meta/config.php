<?php /**
  * Post & Page Meta Configuration File
 *
 * This file is used to define the post meta panels used the hatch theme for all post types
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Meta_Config {

	public function meta_data(){

		// Post Meta
		$custom_meta['post'] = array(
			'title' => HATCH_THEME_TITLE . __( ': Options' , HATCH_THEME_SLUG ),
			'description' => __( '' , HATCH_THEME_SLUG ), // @TODO
			'position' => 'normal',
			'custom-meta' => array(
				'media' => array(
						'title' => __( 'Rich Media' , HATCH_THEME_SLUG ),
						'elements' => array(
							'video-path' => array(
								'label' => __( 'Video URL' , HATCH_THEME_SLUG ),
								'description' => __( 'For use with <a href="' . esc_url( 'http://codex.wordpress.org/' ) . 'Embeds" target="_blank">oEmbed</a> supported media' , HATCH_THEME_SLUG ),
								'type' => 'text',
							),
							'video-embed' => array(
								'label' => __( 'Video Embed Code' , HATCH_THEME_SLUG ),
								'type' => 'textarea',
							),
						)
					),
				'layout' => array(
					'title' => __( 'Layout &amp; Styling' , HATCH_THEME_SLUG ),
					'elements' => array(
						'header-styling' => array(
							'label' => __( 'Header Styling' , HATCH_THEME_SLUG ),
							'type' => 'background',
							'default' => NULL
						),
						'sidebar-postition' => array(
							'label' => __( 'Sidebar Position' , HATCH_THEME_SLUG ),
							'type' => 'select',
							'default' => get_theme_mod( 'obox-hatch-sidebar-position' ),
							'options' => array(
								'none' => __( 'None' , HATCH_THEME_SLUG ),
								'left' => __( 'Left' , HATCH_THEME_SLUG ),
								'right' => __( 'Right' , HATCH_THEME_SLUG )
							),
						),
					)
				)
			)
		);

		// Page Meta we just emulate the post meta
		$custom_meta['page'] = $custom_meta['post'];

		return apply_filters( 'hatch_custom_meta', $custom_meta );
	}
}