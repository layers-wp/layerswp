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
									'title' => __( 'General', 'layers' ),
									'priority' => 30
								),
			'color-scheme'	=> array(
									'title' => __( 'Color Scheme', 'layers' ),
									'priority' => 35
								),
			'header'		=> array(
									'title' => __( 'Header', 'layers' ),
									'description' => __( 'Control your header\'s logo, layout, colors and font.' , 'layers' ), // @TODO Put a helper here
									'priority' => 40
								),
			'content'		=> array(
									'title' => __( 'Content Area', 'layers' ),
									'description' => __( 'Control your content\'s default layout.' , 'layers' ), // @TODO Put a helper here
									'priority' => 45
								),
			'footer'		=> array(
									'title' => __( 'Footer', 'layers' ),
									'description' => __( 'Control your footer\'s custom text, widget areas and layout.' , 'layers' ), // @TODO Put a helper here
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
									'title' =>__( 'Layout' , 'layers' ),
								)
							);

		$sections[ 'content' ] = array(
								'layout' => array(
									'title' =>__( 'Layout' , 'layers' ),
								)
							);;

		$sections[ 'footer' ] = array(
								'layout' => array(
									'title' =>__( 'Layout' , 'layers' ),
								),
								'customization' => array(
									'title' =>__( 'Customization' , 'layers' ),
								),
								'text' => array(
									'title' =>__( 'Text' , 'layers' ),
								)
							);


		return apply_filters( 'layers_customizer_sections', $sections );
	}

	public function controls( $controls = array() ){

		// Setup some folder variables
		$customizer_dir = '/core/customizer/';

		// Header -> Layout -> Layout
		$controls['header-layout'] = array(
								'width' => array(
									'type'     => 'layers-select-icons',
									'label'    => __( 'Header Width', 'layers' ),
									'default' => 'layout-boxed',
									'choices' => array(
										'layout-boxed' => __( 'Boxed' , 'layers' ),
										'layout-fullwidth' => __( 'Full Width' , 'layers' )
									)
								),
								'break-0' => array(
									'type'     => 'layers-seperator'
								),
								'layout' => array(
									'type'     => 'layers-select-icons',
									'label'    => __( 'Logo & Menu Position', 'layers' ),
									'default' => 'header-logo-left',
									'choices' => array(
										'header-logo-left' => __( 'Logo Left' , 'layers' ),
										'header-logo-right' => __( 'Logo Right' , 'layers' ),
										'header-logo-center-top' => __( 'Logo Center Top' , 'layers' ),
										'header-logo-top' => __( 'Logo Top' , 'layers' ),
										'header-logo-center' => __( 'Logo Center' , 'layers' )
									)
								),
								'break-1' => array(
									'type'     => 'layers-seperator'
								),
								'header-position-heading' => array(
									'type'  => 'layers-heading',
									'label'    => __( 'Header Position', 'layers' ),
								),
								'sticky' => array(
									'type'		=> 'layers-checkbox',
									'label'		=> __( 'Sticky', 'layers' ),
									'class'		=> 'layers-pull-top layers-pull-bottom',
									'default'	=> FALSE,
								),
								'overlay' => array(
									'type'     => 'layers-checkbox',
									'label'    => __( 'Overlay', 'layers' ),
									'default'	=> FALSE,
								),
								'break-2' => array(
									'type'     => 'layers-seperator',
								),
								'background-color' => array(
									'type'		=> 'layers-color',
									'label'		=> __( 'Background Color', 'layers' ),
									'default'	=> '#F3F3F3',
								),
							); // header-layout

		// Header -> Layout -> Scripts
		$controls['content-layout'] = array(
								'layout' => array(
									'label' => __( 'Content Width' , 'layers' ),
									'description' => __( 'This option affects list and single content pages.', 'layers' ),
									'type'     => 'layers-select-icons',
									'default' => 'layout-boxed',
									'choices' => array(
										'layout-boxed' => __( 'Boxed' , 'layers' ),
										'layout-fullwidth' => __( 'Full Width' , 'layers' )
									)
								), // layout,
								'break-1' => array(
									'type'     => 'layers-seperator'
								),
								'label-sidebar-archive' => array(
									'type'  => 'layers-heading',
									'label'    => __( 'Post List Sidebar(s)', 'layers' ),
									'description' => __( 'This option affects your category, tag, author and search pages.', 'layers' ),
								),
								'archive-left-sidebar' => array(
									'type'		=> 'checkbox',
									'label' 	=> __( 'Display Left Sidebar', 'layers' ),
									'default' 	=> FALSE,
								), // post-sidebar
								'archive-right-sidebar' => array(
									'type'		=> 'checkbox',
									'label' 	=> __( 'Display Right Sidebar', 'layers' ),
									'default' 	=> TRUE,
								), // post-sidebar
								'break-2' => array(
									'type'     => 'layers-seperator'
								),
								'label-sidebar-single' => array(
									'type'  => 'layers-heading',
									'label'    => __( 'Single Post Sidebar(s)', 'layers' ),
									'description' => __( 'This option affects your single post pages.', 'layers' ),
								),
								'single-left-sidebar' => array(
									'type'      => 'checkbox',
									'label'     => __( 'Display Left Sidebar', 'layers' ),
									'default'   => FALSE,
								), // post-sidebar
								'single-right-sidebar' => array(
									'type'      => 'checkbox',
									'label'     => __( 'Display Right Sidebar', 'layers' ),
									'default'   => TRUE,
								), // post-sidebar
							);


		// Footer -> Layout -> Layout
		$controls['footer-layout'] = array(
								'width' => array(
									'type'     => 'layers-select-icons',
									'default' => 'layout-boxed',
									'choices' => array(
										'layout-boxed' => __( 'Boxed' , 'layers' ),
										'layout-fullwidth' => __( 'Full Width' , 'layers' )
									)
								), // layout,
								'break-1' => array(
									'type'     => 'layers-seperator'
								),
								'widget-area-count' => array(
									'type'     => 'select',
									'label'    => __( 'Widget Areas', 'layers' ),
									'default' => 4,
									'choices' => array(
										'0' => __( 'None' , 'layers' ),
										'1' => __( '1' , 'layers' ),
										'2' => __( '2' , 'layers' ),
										'3' => __( '3' , 'layers' ),
										'4' => __( '4' , 'layers' ),
									)
								),
							); // footer-layout

		// Footer -> Layout -> Customization
		$controls['footer-customization'] = array(
								'font-color-heading' => array(
									'type'  => 'layers-heading',
									'label'    => __( 'Text', 'layers' ),
								),
								'font-color-main' => array(
									'type'  => 'layers-color',
									'subtitle' => __( 'Text Color', 'layers' ),
								),
								'font-color-link' => array(
									'type' => 'layers-color',
									'subtitle' => __( 'Link Color', 'layers' ),
								),
								'background' => array(
									'type'     => 'layers-background',
									'label'    => __( 'RRR', 'layers' ),
									'default' => '',
									'choices' => array(
										'background-position' => array(
											'center' => __( 'Center' , 'layers' ),
											'top' => __( 'Top' , 'layers' ),
											'bottom' => __( 'Bottom' , 'layers' ),
											'left' => __( 'Left' , 'layers' ),
											'right' => __( 'Right' , 'layers' ),
										),
										'background-repeat' => array(
											'no-repeat' => __( 'No Repeat' , 'layers' ),
											'repeat' => __( 'Repeat' , 'layers' ),
											'repeat-x' => __( 'Repeat Horizontal' , 'layers' ),
											'repeat-y' => __( 'Repeat Vertical' , 'layers' ),
										),
									),
								),
							); // footer-customization

		// Footer -> Layout -> Text
		$controls['footer-text'] = array(
				'copyright' => array(
					'type'     => 'text',
					'label'    => __( 'Copyright Text', 'layers' ),
					'default' => ' Made at the tip of Africa. &copy;'
				), // copyright
			); // footer-text

		return apply_filters( 'layers_customizer_controls', $controls );
	}
}