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
						)
					)
				)
			)
		);

		// Page Meta we just emulate the post meta
		$custom_meta['page'] = $custom_meta['post'];

		$custom_meta[ 'portfolio.php' ] = array(
			'title' => HATCH_THEME_TITLE . __( ': Portfolio Options' , HATCH_THEME_SLUG ),
			'description' => __( '' , HATCH_THEME_SLUG ), // @TODO
			'position' => 'normal',
			'custom-meta' => array(
				'media' => array(
						'title' => __( 'Layout' , HATCH_THEME_SLUG ),
						'elements' => array(
							'columns' => array(
								'label' => __( 'Columns' , HATCH_THEME_SLUG ),
								'type' => 'select-icons',
								'default' => 'columns-3',
								'options' => array(
									'columns-1' => __( '1 Column' , HATCH_THEME_SLUG ),
									'columns-2' => __( '2 Column' , HATCH_THEME_SLUG ),
									'columns-3' => __( '3 Column' , HATCH_THEME_SLUG ),
									'columns-4' => __( '4 Column' , HATCH_THEME_SLUG ),
									// 'columns-5' => __( '5 Column' , HATCH_THEME_SLUG ), @TODO: Figure Out a 5col method
									'columns-6' => __( '6 Column' , HATCH_THEME_SLUG )
								)
							)
						)

				)
			)
		);

		return apply_filters( 'hatch_custom_meta', $custom_meta );
	}
}