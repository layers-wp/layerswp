<?php /**
 * Customizer Configuration File
 *
 * This file is used to define the different panels, sections and controls for Layers
 *
 * @package Layers
 * @since Layers 1.0
 */

class Layers_Customizer_Config {

	/**
	* Layers Customiser Panels
	*
	* @return   array 			Panels to be registered in the customizer
	*/

	public function panels(){

		$panels = array(
			'general'		=> array(
									'title' => __( 'General', LAYERS_THEME_SLUG ),
									'priority' => 30
								),
			'color-scheme'	=> array(
									'title' => __( 'Color Scheme', LAYERS_THEME_SLUG ),
									'priority' => 35
								),
			'header'		=> array(
									'title' => __( 'Header', LAYERS_THEME_SLUG ),
									'description' => __( 'Control your header\'s layout, colors, font-type and intro messages.' , LAYERS_THEME_SLUG ), // @TODO Put a helper here
									'priority' => 40
								),
			'content'		=> array(
									'title' => __( 'Content Area', LAYERS_THEME_SLUG ),
									'description' => __( 'Control your content\'s default layout.' , LAYERS_THEME_SLUG ), // @TODO Put a helper here
									'priority' => 45
								),
			'footer'		=> array(
									'title' => __( 'Footer', LAYERS_THEME_SLUG ),
									'description' => __( 'Control your footer\'s custom text, widget areas and layout.' , LAYERS_THEME_SLUG ), // @TODO Put a helper here
									'priority' => 50
								),
		);

		return apply_filters( 'layers_customizer_panels', $panels );
	}

	/**
	* Layers Customiser Sections
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
		return apply_filters( 'layers_customizer_default_sections', $default_sections );
	}

	/**
	* Layers Customiser Sections
	*
	* @return array Sections to be registered in the customizer
	*/

	public function sections(){

		$sections[ 'header' ] = array(
								'layout' => array(
									'title' =>__( 'Layout' , LAYERS_THEME_SLUG ),
								),
								'scripts' => array(
									'title' =>__( 'Additional Scripts' , LAYERS_THEME_SLUG ),
								),
							);

		$sections[ 'content' ] = array(
								'layout' => array(
									'title' =>__( 'Layout' , LAYERS_THEME_SLUG ),
								)
							);;

		$sections[ 'footer' ] = array(
								'layout' => array(
									'title' =>__( 'Layout' , LAYERS_THEME_SLUG ),
								),
								'text' => array(
									'title' =>__( 'Text' , LAYERS_THEME_SLUG ),
								),
                                'scripts' => array(
                                    'title' =>__( 'Additional Scripts' , LAYERS_THEME_SLUG ),
                                ),
							);


		return apply_filters( 'layers_customizer_sections', $sections );
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
                                        'layout-boxed' => __( 'Boxed' , LAYERS_THEME_SLUG ),
                                        'layout-fullwidth' => __( 'Full Width' , LAYERS_THEME_SLUG )
                                    )
                                ), // layout,
                                'break-' . rand() => array(
                                        'type'     => 'seperator'
                                    ),
								'layout' => array(
                                    'type'     => 'select-icons',
									'default' => 'header-logo-left',
									'choices' => array(
                                        'header-logo-left' => __( 'Logo Left' , LAYERS_THEME_SLUG ),
                                        'header-logo-right' => __( 'Logo Right' , LAYERS_THEME_SLUG ),
                                        'header-logo-center-top' => __( 'Logo Center Top' , LAYERS_THEME_SLUG ),
                                        'header-logo-top' => __( 'Logo Top' , LAYERS_THEME_SLUG ),
                                        'header-logo-center' => __( 'Logo Center' , LAYERS_THEME_SLUG )
									)
								), // layout,
                                'break-' . rand() => array(
                                    	'type'     => 'seperator'
                                    ),
                                'break-' . rand(0, 10) => array(
                                    	'type'     => 'seperator'
                                    ),
                                'fixed' => array(
                                    'type'     => 'checkbox',
                                    'label'    => __( 'Fixed Header', LAYERS_THEME_SLUG ),
                                    'description' => __( 'Ticking this option will force your header to the to stick to the top of the page screen when scrolling.', LAYERS_THEME_SLUG ),
                                    'default' => false,
                                ) // fixed
							); // header-layout

		// Header -> Layout -> Scripts
		$controls['header-scripts'] = array(
                                'google-id' => array(
                                    'type'     => 'text',
                                    'label'    => __( 'Google Analytics ID', LAYERS_THEME_SLUG ),
                                    'description' => __( 'Enter in your Google Analytics ID to enable your Google Analytics. eg. "UA-xxxxxx-xx', LAYERS_THEME_SLUG ),
                                    'default' => '',
                                ), // scripts
                                'break-' . rand() => array(
                                    'type'     => 'seperator'
                                ),
			 					'scripts' => array(
                                    'type'     => 'textarea',
                                    'label'    => __( 'Scripts', LAYERS_THEME_SLUG ),
                                    'description' => __( 'Enter in any custom tracking script to include in your site\'s header.', LAYERS_THEME_SLUG ),
                                    'default' => '',
                                ) // scripts
							);

		// Header -> Layout -> Scripts
		$controls['content-layout'] = array(
                                'layout' => array(
                                    'label' => __( 'Content Width' , LAYERS_THEME_SLUG ),
                                    'description' => __( 'This option affects list and single content pages.', LAYERS_THEME_SLUG ),
                                    'type'     => 'select-icons',
                                    'default' => 'layout-boxed',
                                    'choices' => array(
                                        'layout-boxed' => __( 'Boxed' , LAYERS_THEME_SLUG ),
                                        'layout-fullwidth' => __( 'Full Width' , LAYERS_THEME_SLUG )
                                    )
                                ), // layout,
                                'break-' . rand() => array(
                                    'type'     => 'seperator'
                                ),
                                'label-sidebar-archive' => array(
									'type'  => 'heading',
									'label'    => __( 'Post List Sidebar(s)', LAYERS_THEME_SLUG ),
                                	'description' => __( 'This option affects your index page, category & tag pages as well as search pages.', LAYERS_THEME_SLUG ),
                                ),
			 					'archive-left-sidebar' => array(
                                    'type'		=> 'checkbox',
                                    'label' 	=> __( 'Show Left Sidebar', LAYERS_THEME_SLUG ),
                                    'default' 	=> FALSE,
                                ), // post-sidebar
			 					'archive-right-sidebar' => array(
                                    'type'		=> 'checkbox',
                                    'label' 	=> __( 'Show Right Sidebar', LAYERS_THEME_SLUG ),
                                    'default' 	=> TRUE,
                                ), // post-sidebar
                                'break-' . rand() => array(
                                    'type'     => 'seperator'
                                ),
                                'label-sidebar-single' => array(
                                    'type'  => 'heading',
                                    'label'    => __( 'Single Post Sidebar(s)', LAYERS_THEME_SLUG ),
                                    'description' => __( 'This option affects your single post pages.', LAYERS_THEME_SLUG ),
                                ),
                                'single-left-sidebar' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __( 'Show Left Sidebar', LAYERS_THEME_SLUG ),
                                    'default'   => FALSE,
                                ), // post-sidebar
                                'single-right-sidebar' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __( 'Show Right Sidebar', LAYERS_THEME_SLUG ),
                                    'default'   => TRUE,
                                ), // post-sidebar
							);


		// Footer -> Layout -> Layout
		$controls['footer-layout'] = array(
                                'width' => array(
                                    'type'     => 'select-icons',
                                    'default' => 'layout-boxed',
                                    'choices' => array(
                                        'layout-boxed' => __( 'Boxed' , LAYERS_THEME_SLUG ),
                                        'layout-fullwidth' => __( 'Full Width' , LAYERS_THEME_SLUG )
                                    )
                                ), // layout,
                                'break-' . rand() => array(
                                    'type'     => 'seperator'
                                ),
								'widget-area-count' => array(
									'type'     => 'select',
									'label'    => __( 'Widget Areas', LAYERS_THEME_SLUG ),
									'default' => 4,
									'choices' => array(
                                        '0' => __( 'None' , LAYERS_THEME_SLUG ),
										'1' => __( '1' , LAYERS_THEME_SLUG ),
										'2' => __( '2' , LAYERS_THEME_SLUG ),
										'3' => __( '3' , LAYERS_THEME_SLUG ),
										'4' => __( '4' , LAYERS_THEME_SLUG ),
									)
								),
								'break-' . rand() => array(
                                    'type'     => 'seperator'
                                ),
                                /*
								'background' => array(
	                                'type'     => 'background',
	                                'label'    => __( 'RRR', LAYERS_THEME_SLUG ),
	                                'default' => '',
	                                'choices' => array(
                                        'background-position' => array(
											'center' => __( 'Center' , LAYERS_THEME_SLUG ),
											'top' => __( 'Top' , LAYERS_THEME_SLUG ),
											'bottom' => __( 'Bottom' , LAYERS_THEME_SLUG ),
											'left' => __( 'Left' , LAYERS_THEME_SLUG ),
											'right' => __( 'Right' , LAYERS_THEME_SLUG ),
										),
                                        'background-repeat' => array(
											'no-repeat' => __( 'No Repeat' , LAYERS_THEME_SLUG ),
											'repeat' => __( 'Repeat' , LAYERS_THEME_SLUG ),
											'repeat-x' => __( 'Repeat Horizontal' , LAYERS_THEME_SLUG ),
											'repeat-y' => __( 'Repeat Vertical' , LAYERS_THEME_SLUG ),
                                        ),
                                    )
                            	),
                            	*/
							); // footer-layout

		// Footer -> Layout -> Text
		$controls['footer-text'] = array(
				'copyright' => array(
					'type'     => 'text',
					'label'    => __( 'Copyright Text', LAYERS_THEME_SLUG ),
					'default' => ' Made at the tip of Africa. &copy;'
				), // copyright
			); // footer-text

        // Footer -> Layout -> Scripts
        $controls['footer-scripts'] = array(
                    'scripts' => array(
                        'type'     => 'textarea',
                        'label'    => __( 'Scripts', LAYERS_THEME_SLUG ),
                        'description' => __( 'Enter in any custom tracking script to include in your site\'s header.', LAYERS_THEME_SLUG ),
                        'default' => '',
                    ), // scripts
                    'break-' . rand() => array(
                        'type'     => 'seperator'
                    ),
                ); // footer-scripts

		return apply_filters( 'layers_customizer_controls', $controls );
	}
}