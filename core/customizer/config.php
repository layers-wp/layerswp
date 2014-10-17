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
									'type'     => 'select-icons',
									'label'    => __( 'Header Layout', HATCH_THEME_SLUG ),
									'default' => 'header-left',
									'choices' => array(
                                        'header-logo-left' => __( 'Logo Left' , HATCH_THEME_SLUG ),
                                        'header-logo-right' => __( 'Logo Right' , HATCH_THEME_SLUG ),
                                        'header-logo-center-top' => __( 'Logo Center Top' , HATCH_THEME_SLUG ),
                                        'header-logo-top' => __( 'Logo Top' , HATCH_THEME_SLUG ),
                                        'header-logo-center' => __( 'Logo Center' , HATCH_THEME_SLUG )
									)
								), // layout,
                                'break' => array(
                                    	'type'     => 'seperator'
                                    ),
                                'fixed' => array(
                                    'type'     => 'checkbox',
                                    'label'    => __( 'Fixed Header', HATCH_THEME_SLUG ),
                                    'description' => __( 'Fixed header to the top of the screen when scrolling.', HATCH_THEME_SLUG ),
                                    'default' => false,
                                ) // fixed
							); // header-layout

		// Footer -> Layout -> Layout
		$controls['footer-layout'] = array(
								'layout' => array(
									'type'     => 'select-images',
									'label'    => __( 'Header Layout', HATCH_THEME_SLUG ),
									'default' => 'header-left',
									'choices' => array(
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