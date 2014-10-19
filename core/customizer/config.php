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
									'priority' => 30
								),
			'color-scheme'	=> array(
									'title' => __( 'Color Scheme', HATCH_THEME_SLUG ),
									'priority' => 35
								),
			'header'		=> array(
									'title' => __( 'Header', HATCH_THEME_SLUG ),
									'description' => __( 'Control your header\'s layout, colors, font-type and intro messages.' , HATCH_THEME_SLUG ), // @TODO Put a helper here
									'priority' => 40
								),
			'content'		=> array(
									'title' => __( 'Content', HATCH_THEME_SLUG ),
									'description' => __( 'Control your content\'s default layout.' , HATCH_THEME_SLUG ), // @TODO Put a helper here
									'priority' => 40
								),
			'footer'		=> array(
									'title' => __( 'Footer', HATCH_THEME_SLUG ),
									'description' => __( 'Control your footer\'s custom text, widget areas and layout.' , HATCH_THEME_SLUG ), // @TODO Put a helper here
									'priority' => 50
								),
		);

		return apply_filters( 'hatch_customizer_panels', $panels );
	}

	/**
	* Hatch Customiser Sections
	*
	* @return   array 			Sections to be registered in the customizer
	*/

	public function default_sections(){
		$default_sections[ 'title_tagline' ] = array(
													'panel' => 'general'
												);
		$default_sections[ 'static_front_page' ] = array(
													'panel' => 'general'
												);
		$default_sections[ 'nav' ] = array(
													'panel' => 'general'
												);
		return apply_filters( 'hatch_customizer_default_sections', $default_sections );
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
									'default' => 'header-logo-left',
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
                                    'description' => __( 'Ticking this option will force your header to the to stick to the top of the page screen when scrolling.', HATCH_THEME_SLUG ),
                                    'default' => false,
                                ) // fixed
							); // header-layout

		// Footer -> Layout -> Layout
		$controls['footer-layout'] = array(
								'widget-area-count' => array(
									'type'     => 'select',
									'label'    => __( 'Widget Areas', HATCH_THEME_SLUG ),
									'default' => 4,
									'choices' => array(
										'1' => __( '1' , HATCH_THEME_SLUG ),
										'2' => __( '2' , HATCH_THEME_SLUG ),
										'3' => __( '3' , HATCH_THEME_SLUG ),
										'4' => __( '4' , HATCH_THEME_SLUG ),
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