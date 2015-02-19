<?php /**
 * Customizer Configuration File
 *
 * This file is used to define the different panels, sections and controls for Layers
 *
 * @package Layers
 * @since Layers 1.0.0
 */

class Layers_Customizer_Config {

	/**
	* Layers Customiser Panels
	*
	* @return   array 			Panels to be registered in the customizer
	*/

	public function panels(){

		$panels = array(
			'branding' => array(
							'title' => __( 'Branding' , 'layerswp' ),
							'priority' => 20
						),
			'site-settings' => array(
							'title' => __( 'Site Settings' , 'layerswp' ),
							'description' => __( 'Control your content\'s default layout.' , 'layerswp' ), // @TODO Put a helper here
							'priority' => 40
						),
			'header' => array(
							'title' => __( 'Header' , 'layerswp' ),
							'description' => __( 'Control your header\'s logo, layout, colors and font.' , 'layerswp' ), // @TODO Put a helper here
							'priority' => 60
						),
			'footer' => array(
							'title' => __( 'Footer' , 'layerswp' ),
							'description' => __( 'Control your footer\'s custom text, widget areas and layout.' , 'layerswp' ), // @TODO Put a helper here
							'priority' => 80
						),
			'woocommerce' => array(
							'title' => __( 'WooCommerce' , 'layerswp' ),
							'priority' => 100
						)
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
													'title' => __( 'Logo &amp; Title' , 'layerswp' ),
													'panel' => 'site-settings'
												);

		$default_sections[ 'colors' ] = array(
											'title' => __( 'Background Color' , 'layerswp' ),
											'panel' => 'site-settings',
											'priority' => 55,
										);
		$default_sections[ 'background_image' ] = array(
											'panel' => 'site-settings',
											'priority' => 55,
										);

		$default_sections[ 'nav' ] = array(
											'panel' => 'site-settings',
											'priority' => 50,
										);

		return apply_filters( 'layers_customizer_default_sections', $default_sections );
	}

	/**
	* Layers Customiser Sections
	*
	* @return array Sections to be registered in the customizer
	*/

	public function sections(){

		$sections = array(
						'nav' => array( // This is used before any menus are registered. Then replaced by WP Naviagation
							'title'       =>__( 'Navigation' , 'layerswp' ),
							'description' => __( 'First create a menu then come back here to place it.' , 'layerswp' ),
							'priority' => 50,
							'panel' => 'site-settings'
						),
						'content-layout' => array(
							'title' =>__( 'Layout' , 'layerswp' ),
							'panel' => 'site-settings'
						),
						'content-sidebars' => array(
							'title' =>__( 'Sidebars' , 'layerswp' ),
							'panel' => 'site-settings'
						),
						'fonts' => array(
							'title' =>__( 'Fonts' , 'layerswp' ),
							'panel' => 'site-settings'

						),
						'css' => array(
							'title' =>__( 'CSS' , 'layerswp' ),
						),
						'header-layout' => array(
							'title' =>__( 'Layout' , 'layerswp' ),
							'panel' => 'header'
						),
						'header-scripts' => array(
							'title' =>__( 'Additional Scripts' , 'layerswp' ),
							'panel' => 'header'
						),
						'footer-layout' => array(
							'title' =>__( 'Layout' , 'layerswp' ),
							'panel' => 'footer'
						),
						'footer-customization' => array(
							'title' =>__( 'Customization' , 'layerswp' ),
							'panel' => 'footer'
						),
						'footer-text' => array(
							'title' =>__( 'Text' , 'layerswp' ),
							'panel' => 'footer'
						),
						'footer-scripts' => array(
							'title' =>__( 'Additional Scripts' , 'layerswp' ),
							'panel' => 'footer'
						),
						'woocommerce-sidebars' => array(
							'title' =>__( 'Sidebars' , 'layerswp' ),
							'panel' => 'woocommerce'
						)
					);


		return apply_filters( 'layers_customizer_sections', $sections );
	}

	public function controls( $controls = array() ){

		// Setup some folder variables
		$customizer_dir = '/core/customizer/';


		// Header -> Layout -> Layout  // This is used before any menus are registered. Then replaced by WP Naviagation
		if ( ! wp_get_nav_menus() ) {
			$controls['nav'] = array(
									'general-nav' => array(
										'type'        => 'layers-button',
										'text'        => __( 'Create Menu' , 'layerswp' ),
										'href'        => admin_url( 'nav-menus.php' ),
									),
								); // header-layout

		}

		// Header -> Layout -> Layout
		$controls['css'] = array(
								'custom-css' => array(
									'type'     => 'layers-css',
									'placeholder'	=> ".classname {\n\tbackground: #333;\n}"
								),
							); // css

		// Header -> Layout -> Layout
		$controls['fonts'] = array(
								'body-fonts' => array(
									'type' => 'layers-font',
									'label'    => __( 'Body' , 'layerswp' ),
									'selectors' => 'body',
									'choices' => layers_get_google_font_options()
								),
								'fonts-break-0' => array(
									'type'     => 'layers-seperator'
								),
								'heading-fonts' => array(
									'type' => 'layers-font',
									'label'    => __( 'Headings' , 'layerswp' ),
									'selectors' => 'h1,h2,h3,h4,h5,h6, .heading',
									'choices' => layers_get_google_font_options()
								),
								'fonts-break-1' => array(
									'type'     => 'layers-seperator'
								),
								'form-fonts' => array(
									'type' => 'layers-font',
									'label'    => __( 'Buttons' , 'layerswp' ),
									'selectors' => 'button, .button, input[type=submit]',
									'choices' => layers_get_google_font_options()
								),
							);

		// Header -> Layout -> Layout
		$controls['header-layout'] = array(
								'header-width' => array(
									'type'     => 'layers-select-icons',
									'label'    => __( 'Header Width' , 'layerswp' ),
									'default' => 'layout-boxed',
									'choices' => array(
										'layout-boxed' => __( 'Boxed' , 'layerswp' ),
										'layout-fullwidth' => __( 'Full Width' , 'layerswp' )
									)
								),
								'header-layout-break-0' => array(
									'type'     => 'layers-seperator'
								),
								'header-menu-layout' => array(
									'type'     => 'layers-select-icons',
									'label'    => __( 'Logo & Menu Position' , 'layerswp' ),
									'default' => 'header-logo-left',
									'choices' => array(
										'header-logo-left' => __( 'Logo Left' , 'layerswp' ),
										'header-logo-right' => __( 'Logo Right' , 'layerswp' ),
										'header-logo-center-top' => __( 'Logo Center Top' , 'layerswp' ),
										'header-logo-top' => __( 'Logo Top' , 'layerswp' ),
										'header-logo-center' => __( 'Logo Center' , 'layerswp' )
									)
								),
								'header-layout-break-1' => array(
									'type'     => 'layers-seperator'
								),
								'header-position-heading' => array(
									'type'  => 'layers-heading',
									'label'    => __( 'Header Position' , 'layerswp' ),
								),
								'header-sticky' => array(
									'type'		=> 'layers-checkbox',
									'label'		=> __( 'Sticky' , 'layerswp' ),
									'class'		=> 'layers-pull-top layers-pull-bottom',
									'default'	=> FALSE,
								),
								'header-overlay' => array(
									'type'     => 'layers-checkbox',
									'label'    => __( 'Overlay' , 'layerswp' ),
									'default'	=> FALSE,
								),
								'header-layout-break-2' => array(
									'type'     => 'layers-seperator',
								),
								'header-background-color' => array(
									'type'		=> 'layers-color',
									'label'		=> __( 'Background Color' , 'layerswp' ),
									'default'	=> '#F3F3F3',
								),
							); // header-layout

		// Header -> Layout -> Scripts
		$controls['header-scripts'] = array(
								'header-google-id' => array(
									'type'     => 'text',
									'label'    => __( 'Google Analytics ID' , 'layerswp' ),
									'description' => __( 'Enter in your Google Analytics ID to enable website traffic reporting. eg. "UA-xxxxxx-xx' , 'layerswp' ),
									'default' => '',
								), // scripts
								'header-custom-scripts-break-1' => array(
									'type'     => 'layers-seperator'
								),
								'header-custom-scripts' => array(
									'type'     => 'textarea',
									'label'    => __( 'Custom Scripts' , 'layerswp' ),
									'description' => __( 'Enter in any custom script (such as TypeKit etc) to include in your site\'s header. Include the &lt;script&gt;&lt;/script&gt; tags.' , 'layerswp' ),
									'default' => '',
								) // scripts
							);

		$controls['content-sidebars'] = array(
								'single-sidebar-heading' => array(
									'type'  => 'layers-heading',
									'label'    => __( 'Single Post Sidebar(s)' , 'layerswp' ),
									'description' => __( 'This option affects your single post pages.' , 'layerswp' ),
								),
								'single-left-sidebar' => array(
									'type'      => 'checkbox',
									'label'     => __( 'Display Left Sidebar' , 'layerswp' ),
									'default'   => FALSE,
								), // post-sidebar
								'single-right-sidebar' => array(
									'type'      => 'checkbox',
									'label'     => __( 'Display Right Sidebar' , 'layerswp' ),
									'default'   => TRUE,
								), // post-sidebar
								'content-layout-break-2' => array(
									'type'     => 'layers-seperator'
								),
								'archive-sidebar-heading' => array(
									'type'  => 'layers-heading',
									'label'    => __( 'Post List Sidebar(s)' , 'layerswp' ),
									'description' => __( 'This option affects your category, tag, author and search pages.' , 'layerswp' ),
								),
								'archive-left-sidebar' => array(
									'type'		=> 'checkbox',
									'label' 	=> __( 'Display Left Sidebar' , 'layerswp' ),
									'default' 	=> FALSE,
								), // post-sidebar
								'archive-right-sidebar' => array(
									'type'		=> 'checkbox',
									'label' 	=> __( 'Display Right Sidebar' , 'layerswp' ),
									'default' 	=> TRUE,
								), // post-sidebar
							);


		// Footer -> Layout -> Layout
		$controls['footer-layout'] = array(
								'footer-width' => array(
									'type'     => 'layers-select-icons',
									'default' => 'layout-boxed',
									'choices' => array(
										'layout-boxed' => __( 'Boxed' , 'layerswp' ),
										'layout-fullwidth' => __( 'Full Width' , 'layerswp' )
									)
								), // layout,
								'footer-layout-break-1' => array(
									'type'     => 'layers-seperator'
								),
								'footer-sidebar-count' => array(
									'type'     => 'select',
									'label'    => __( 'Widget Areas' , 'layerswp' ),
									'default' => 4,
									'choices' => array(
										'0' => __( 'None' , 'layerswp' ),
										'1' => __( '1' , 'layerswp' ),
										'2' => __( '2' , 'layerswp' ),
										'3' => __( '3' , 'layerswp' ),
										'4' => __( '4' , 'layerswp' ),
									)
								),
							); // footer-layout

		// Footer -> Layout -> Customization
		$controls['footer-customization'] = array(
								'footer-font-heading' => array(
									'type'  => 'layers-heading',
									'label'    => __( 'Text' , 'layerswp' ),
								),
								'footer-body-color' => array(
									'type'  => 'layers-color',
									'subtitle' => __( 'Text Color' , 'layerswp' ),
									'default' => '#000000',
								),
								'footer-link-color' => array(
									'type' => 'layers-color',
									'subtitle' => __( 'Link Color' , 'layerswp' ),
									'default' => '#35A6E8',
								),
								'footer-customization-break-1' => array(
									'type'     => 'layers-seperator'
								),
								'footer-background-heading' => array(
									'type'  => 'layers-heading',
									'label'    => __( 'Background' , 'layerswp' ),
								),
								'footer-background-image' => array(
									'label' => '',
									'subtitle' => __( 'Background Image' , 'layerswp' ),
									'type' => 'layers-select-images', //wierd bug in WP4.1 that requires a type to be in the array, or will revert to default control
								),
								'footer-background-color' => array(
									'label' => '',
									'subtitle' => __( 'Background Color' , 'layerswp' ),
									'type' => 'layers-color',
									'default' => '#F3F3F3',
								),
								'footer-background-repeat' => array(
									'label' => '',
									'subtitle' => __( 'Background Repeat' , 'layerswp' ),
									'type' => 'layers-select',
									'choices' => array(
										'no-repeat' => __( 'No Repeat' , 'layerswp' ),
										'repeat' => __( 'Repeat' , 'layerswp' ),
										'repeat-x' => __( 'Repeat Horizontal' , 'layerswp' ),
										'repeat-y' => __( 'Repeat Vertical' , 'layerswp' ),
									),
								),
								'footer-background-position' => array(
									'label' => '',
									'subtitle' => __( 'Background Position' , 'layerswp' ),
									'type' => 'layers-select',
									'choices' => array(
										'center' => __( 'Center' , 'layerswp' ),
										'top' => __( 'Top' , 'layerswp' ),
										'bottom' => __( 'Bottom' , 'layerswp' ),
										'left' => __( 'Left' , 'layerswp' ),
										'right' => __( 'Right' , 'layerswp' ),
									),
								),
								'footer-background-stretch' => array(
									'label' => __( 'Background Stretch' , 'layerswp' ),
									'subtitle' => '',
									'type' => 'layers-checkbox',
								),
							); // footer-customization

		// Footer -> Layout -> Text
		$controls['footer-text'] = array(
				'footer-copyright-text' => array(
					'type'     => 'text',
					'label'    => __( 'Copyright Text' , 'layerswp' ),
					'default' => ' Made at the tip of Africa. &copy;'
				), // copyright
			); // footer-text

		// Footer -> Layout -> Scripts
		$controls['footer-scripts'] = array(
					'footer-custom-scripts' => array(
						'type'     => 'textarea',
						'label'    => __( 'Custom Scripts' , 'layerswp' ),
						'description' => __( 'Enter in any custom script to include in your site\'s footer. Include the &lt;script&gt;&lt;/script&gt; tags.' , 'layerswp' ),
						'default' => '',
					), // scripts
				); // footer-scripts


		if( class_exists( 'WooCommerce' ) ) {
			$controls[ 'woocommerce-sidebars' ] = array(
								'label-sidebar-single' => array(
									'type'  => 'layers-heading',
									'label'    => __( 'Single Product Sidebar(s)' , 'layerswp' ),
									'description' => __( 'This option affects your single product pages.' , 'layerswp' ),
								),
								'single-left-woocommerce-sidebar' => array(
									'type'      => 'checkbox',
									'label'     => __( 'Display Left Sidebar' , 'layerswp' ),
									'default'   => FALSE,
								), // post-sidebar
								'single-right-woocommerce-sidebar' => array(
									'type'      => 'checkbox',
									'label'     => __( 'Display Right Sidebar' , 'layerswp' ),
									'default'   => TRUE,
								), // post-sidebar
								'woocommerce-break-1' => array(
									'type'     => 'layers-seperator'
								),
								'label-sidebar-archive' => array(
									'type'  => 'layers-heading',
									'label'    => __( 'Product List Sidebar(s)' , 'layerswp' ),
									'description' => __( 'This option affects your shop page, product category and product tag pages.' , 'layerswp' ),
								),
								'archive-left-woocommerce-sidebar' => array(
									'type'      => 'checkbox',
									'label'     => __( 'Display Left Sidebar' , 'layerswp' ),
									'default'   => FALSE,
								), // post-sidebar
								'archive-right-woocommerce-sidebar' => array(
									'type'      => 'checkbox',
									'label'     => __( 'Display Right Sidebar' , 'layerswp' ),
									'default'   => TRUE,
								), // post-sidebar
							);
		} // if WooCommerce

		return apply_filters( 'layers_customizer_controls', $controls );
	}
}