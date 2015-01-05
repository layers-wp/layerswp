<?php /**
  * Post & Page Meta Configuration File
 *
 * This file is used to define the post meta panels used the layers theme for all post types
 *
 * @package Layers
 * @since Layers 1.0
 */

class Layers_Meta_Config {

	public function meta_data(){

		// Post Meta
		$custom_meta['post'] = array(
			'title' => LAYERS_THEME_TITLE . __( ': Options' , LAYERS_THEME_SLUG ),
			'description' => __( '' , LAYERS_THEME_SLUG ), // @TODO
			'position' => 'normal',
			'custom-meta' => array(
				'media' => array(
						'title' => __( 'Rich Media' , LAYERS_THEME_SLUG ),
						'elements' => array(
							'video-path' => array(
								'label' => __( 'Video URL' , LAYERS_THEME_SLUG ),
								'description' => __( 'For use with <a href="' . esc_url( 'http://codex.wordpress.org/' ) . 'Embeds" target="_blank">oEmbed</a> supported media' , LAYERS_THEME_SLUG ),
								'type' => 'text',
							),
							'video-embed' => array(
								'label' => __( 'Video Embed Code' , LAYERS_THEME_SLUG ),
								'type' => 'textarea',
							),
						)
					),
				'layout' => array(
					'title' => __( 'Layout &amp; Styling' , LAYERS_THEME_SLUG ),
					'elements' => array(
						'header-styling' => array(
							'label' => __( 'Header Styling' , LAYERS_THEME_SLUG ),
							'type' => 'background',
							'default' => NULL
						),
						'sidebar-postition' => array(
							'label' => __( 'Sidebar Position' , LAYERS_THEME_SLUG ),
							'type' => 'select',
							'default' => get_theme_mod( 'obox-layers-sidebar-position' ),
							'options' => array(
								'none' => __( 'None' , LAYERS_THEME_SLUG ),
								'left' => __( 'Left' , LAYERS_THEME_SLUG ),
								'right' => __( 'Right' , LAYERS_THEME_SLUG )
							),
						)
					)
				)
			)
		);

		// Page Meta we just emulate the post meta
		$custom_meta['page'] = $custom_meta['post'];

		$custom_meta[ 'portfolio.php' ] = array(
			'title' => LAYERS_THEME_TITLE . __( ': Portfolio Options' , LAYERS_THEME_SLUG ),
			'description' => __( '' , LAYERS_THEME_SLUG ), // @TODO
			'position' => 'normal',
			'custom-meta' => array(
				'media' => array(
						'title' => __( 'Layout' , LAYERS_THEME_SLUG ),
						'elements' => array(
							'columns' => array(
								'label' => __( 'Columns' , LAYERS_THEME_SLUG ),
								'type' => 'select-icons',
								'default' => 'columns-3',
								'options' => array(
									'columns-1' => __( '1 Column' , LAYERS_THEME_SLUG ),
									'columns-2' => __( '2 Column' , LAYERS_THEME_SLUG ),
									'columns-3' => __( '3 Column' , LAYERS_THEME_SLUG ),
									'columns-4' => __( '4 Column' , LAYERS_THEME_SLUG ),
									// 'columns-5' => __( '5 Column' , LAYERS_THEME_SLUG ), @TODO: Figure Out a 5col method
									'columns-6' => __( '6 Column' , LAYERS_THEME_SLUG )
								)
							)
						)

				)
			)
		);

		return apply_filters( 'layers_custom_meta', $custom_meta );
	}
}