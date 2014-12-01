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
									'title' => __( 'Content Area', HATCH_THEME_SLUG ),
									'description' => __( 'Control your content\'s default layout.' , HATCH_THEME_SLUG ), // @TODO Put a helper here
									'priority' => 45
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
													'panel' => 'header'
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
	* @return array Sections to be registered in the customizer
	*/

	public function sections(){

		$sections[ 'header' ] = array(
								'layout' => array(
									'title' =>__( 'Layout' , HATCH_THEME_SLUG ),
								),
								'scripts' => array(
									'title' =>__( 'Additional Scripts' , HATCH_THEME_SLUG ),
								),
							);

		$sections[ 'content' ] = array(
								'layout' => array(
									'title' =>__( 'Layout' , HATCH_THEME_SLUG ),
								)
							);;

		$sections[ 'footer' ] = array(
								'layout' => array(
									'title' =>__( 'Layout' , HATCH_THEME_SLUG ),
								),
								'text' => array(
									'title' =>__( 'Text' , HATCH_THEME_SLUG ),
								),
                                'scripts' => array(
                                    'title' =>__( 'Additional Scripts' , HATCH_THEME_SLUG ),
                                ),
							);


		return apply_filters( 'hatch_customizer_sections', $sections );
	}

	public function controls( $controls = array() ){

		// Setup some folder variables
		$customizer_dir = '/core/customizer/';

		// Header -> Layout -> Layout
		$controls['header-layout'] = array(
                                'width' => array(
                                    'type'     => 'select-icons',
                                    'default' => 'layout-boxed',
                                    'choices' => array(
                                        'layout-boxed' => __( 'Boxed' , HATCH_THEME_SLUG ),
                                        'layout-fullwidth' => __( 'Full Width' , HATCH_THEME_SLUG )
                                    )
                                ), // layout,
                                'break-' . rand() => array(
                                        'type'     => 'seperator'
                                    ),
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
                                'break-' . rand() => array(
                                    	'type'     => 'seperator'
                                    ),
                                'display-top-header' => array(
                                    'type'     => 'checkbox',
                                    'label'    => __( 'Display Top Header', HATCH_THEME_SLUG ),
                                    'default' => true,
                                ), // top header display
                                'break-' . rand(0, 10) => array(
                                    	'type'     => 'seperator'
                                    ),
                                'fixed' => array(
                                    'type'     => 'checkbox',
                                    'label'    => __( 'Fixed Header', HATCH_THEME_SLUG ),
                                    'description' => __( 'Ticking this option will force your header to the to stick to the top of the page screen when scrolling.', HATCH_THEME_SLUG ),
                                    'default' => false,
                                ) // fixed
							); // header-layout

		// Header -> Layout -> Scripts
		$controls['header-scripts'] = array(
                                'google-id' => array(
                                    'type'     => 'text',
                                    'label'    => __( 'Google Analytics ID', HATCH_THEME_SLUG ),
                                    'description' => __( 'Enter in your Google Analytics ID to enable your Google Analytics. eg. "UA-xxxxxx-xx', HATCH_THEME_SLUG ),
                                    'default' => '',
                                ), // scripts
                                'break-' . rand() => array(
                                    'type'     => 'seperator'
                                ),
			 					'scripts' => array(
                                    'type'     => 'textarea',
                                    'label'    => __( 'Scripts', HATCH_THEME_SLUG ),
                                    'description' => __( 'Enter in any custom tracking script to include in your site\'s header.', HATCH_THEME_SLUG ),
                                    'default' => '',
                                ) // scripts
							);

		// Header -> Layout -> Scripts
		$controls['content-layout'] = array(
                                'layout' => array(
                                    'label' => __( 'Content Width' , HATCH_THEME_SLUG ),
                                    'type'     => 'select-icons',
                                    'default' => 'layout-boxed',
                                    'choices' => array(
                                        'layout-boxed' => __( 'Boxed' , HATCH_THEME_SLUG ),
                                        'layout-fullwidth' => __( 'Full Width' , HATCH_THEME_SLUG )
                                    )
                                ), // layout,
                                'break-' . rand() => array(
                                    'type'     => 'seperator'
                                ),
                                'label-sidebar-archive' => array(
									'type'  => 'heading',
									'label'    => __( 'Post List Sidebar(s)', HATCH_THEME_SLUG ),
                                	'description' => __( 'This option affects your index page, category & tag pages as well as search pages.', HATCH_THEME_SLUG ),
                                ),
			 					'archive-left-sidebar' => array(
                                    'type'		=> 'checkbox',
                                    'label' 	=> __( 'Show Left Sidebar', HATCH_THEME_SLUG ),
                                    'default' 	=> FALSE,
                                ), // post-sidebar
			 					'archive-right-sidebar' => array(
                                    'type'		=> 'checkbox',
                                    'label' 	=> __( 'Show Right Sidebar', HATCH_THEME_SLUG ),
                                    'default' 	=> TRUE,
                                ), // post-sidebar
                                'break-' . rand() => array(
                                    'type'     => 'seperator'
                                ),
                                'label-sidebar-single' => array(
                                    'type'  => 'heading',
                                    'label'    => __( 'Single Post Sidebar(s)', HATCH_THEME_SLUG ),
                                    'description' => __( 'This option affects your single post pages.', HATCH_THEME_SLUG ),
                                ),
                                'single-left-sidebar' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __( 'Show Left Sidebar', HATCH_THEME_SLUG ),
                                    'default'   => FALSE,
                                ), // post-sidebar
                                'single-right-sidebar' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __( 'Show Right Sidebar', HATCH_THEME_SLUG ),
                                    'default'   => TRUE,
                                ), // post-sidebar
							);


		// Footer -> Layout -> Layout
		$controls['footer-layout'] = array(
                                'width' => array(
                                    'type'     => 'select-icons',
                                    'default' => 'layout-boxed',
                                    'choices' => array(
                                        'layout-boxed' => __( 'Boxed' , HATCH_THEME_SLUG ),
                                        'layout-fullwidth' => __( 'Full Width' , HATCH_THEME_SLUG )
                                    )
                                ), // layout,
                                'break-' . rand() => array(
                                        'type'     => 'seperator'
                                    ),
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

        // Footer -> Layout -> Scripts
        $controls['footer-scripts'] = array(
                    'scripts' => array(
                        'type'     => 'textarea',
                        'label'    => __( 'Scripts', HATCH_THEME_SLUG ),
                        'description' => __( 'Enter in any custom tracking script to include in your site\'s header.', HATCH_THEME_SLUG ),
                        'default' => '',
                    ), // scripts
                    'break-' . rand() => array(
                        'type'     => 'seperator'
                    ),
                ); // footer-scripts

		return apply_filters( 'hatch_customizer_controls', $controls );
	}
}