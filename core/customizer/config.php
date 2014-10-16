<?php /**
 * Customizer Configuration File
 *
 * This file is used to define the different panels, sections and controls for Hatch
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Customizer_Config {

	/**
	* Hatch Customiser Panels
	*
	* @return   array 			Panels to be registered in the customizer
	*/

	public function panels(){

		$panels = array(
			'general'		=> array(
									'title' => __( 'General', HATCH_THEME_SLUG ),
									'priority' => 100
								),
			'color-scheme'	=> array(
									'title' => __( 'Color Scheme', HATCH_THEME_SLUG ),
									'priority' => 300
								),
			'header'		=> array(
									'title' => __( 'Header', HATCH_THEME_SLUG ),
									'description' => __( 'Control your header\'s layout, colors, font-type and intro messages.' , HATCH_THEME_SLUG ), // @TODO Put a helper here
									'priority' => 400
								),
			'footer'		=> array(
									'title' => __( 'Footer', HATCH_THEME_SLUG ),
									'description' => __( 'Control your footer\'s custom text, widget areas and layout.' , HATCH_THEME_SLUG ), // @TODO Put a helper here
									'priority' => 600
								),
		);

		return apply_filters( 'hatch_customizer_panels', $panels );
	}

	/**
	* Hatch Customiser Sections
	*
	* @return   array 			Sections to be registered in the customizer
	*/

	public function sections(){

		$sections[ 'header' ] = array(
								'layout' => array(
									'title' =>__( 'Layout' , HATCH_THEME_SLUG ),
								)
							);

		$sections[ 'footer' ] = array(
								'layout' => array(
									'title' =>__( 'Layout' , HATCH_THEME_SLUG ),
								),
								'text' => array(
									'title' =>__( 'Text' , HATCH_THEME_SLUG ),
								),
							);


		return apply_filters( 'hatch_customizer_sections', $sections );
	}


	public function controls( $controls = array() ){

		// Setup some folder variables
		$customizer_dir = '/core/customizer/';

		// Header -> Layout -> Layout
		$controls['header-layout'] = array(
								'layout' => array(
									'type'     => 'radio',
									'mode'     => 'image',
									'label'    => __( 'Header Layout', HATCH_THEME_SLUG ),
									'default' => 'header-left',
									'options' => array(
										'left' => get_template_directory_uri() . $customizer_dir . '/images/header-layouts/header-left.png',
										'right' => get_template_directory_uri() . $customizer_dir . '/images/header-layouts/header-right.png',
										'nav-left' => get_template_directory_uri() . $customizer_dir . '/images/header-layouts/header-nav-left.png',
										'clear' => get_template_directory_uri() . $customizer_dir . '/images/header-layouts/header-clear.png',
										'inline' => get_template_directory_uri() . $customizer_dir . '/images/header-layouts/header-inline.png',
									)
								), // layout
							); // header-layout

		// Footer -> Layout -> Layout
		$controls['footer-layout'] = array(
								'layout' => array(
									'type'     => 'radio',
									'mode'     => 'image',
									'label'    => __( 'Header Layout', HATCH_THEME_SLUG ),
									'default' => 'header-left',
									'options' => array(
										'left' => get_template_directory_uri() . $customizer_dir . '/images/header-layouts/header-left.png',
										'right' => get_template_directory_uri() . $customizer_dir . '/images/header-layouts/header-right.png',
										'nav-left' => get_template_directory_uri() . $customizer_dir . '/images/header-layouts/header-nav-left.png',
										'clear' => get_template_directory_uri() . $customizer_dir . '/images/header-layouts/header-clear.png',
										'inline' => get_template_directory_uri() . $customizer_dir . '/images/header-layouts/header-inline.png',
									)
								), // layout
							); // footer-layout

		// Footer -> Layout -> Text
		$controls['footer-text'] = array(
				'copyright' => array(
					'type'     => 'text',
					'label'    => __( 'Copyright Text', HATCH_THEME_SLUG ),
					'default' => ' Made at the tip of Africa. &copy;'
				), // copyright
			); // footer-text

		return apply_filters( 'hatch_customizer_controls', $controls );
	}
}