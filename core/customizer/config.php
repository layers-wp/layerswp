<?php /**
 * Customizer Configuration File
 *
 * This file is used to define the different panels, sections and controls for Layers
 *
 * @package Layers
 * @since Layers 1.0.0
 */

class Layers_Customizer_Config {

	public $panels;

	public $default_panels;

	public $default_sections;

	public $sections;

	public $controls;

	private static $instance; // stores singleton class

    /**
    *  Get Instance creates a singleton class that's cached to stop duplicate instances
    */
    public static function get_instance() {
        if ( ! self::$instance ) {
            self::$instance = new self();
            self::$instance->init();
        }
        return self::$instance;
    }

    /**
    *  Construct empty on purpose
    */

    private function __construct() {}

    /**
    *  Init behaves like, and replaces, construct
    */

    public function init() {

		// Init and store panels
		$this->panels = $this->panels();

		// Init and store default_sections
		$this->default_panels = $this->default_panels();
		$this->default_sections = $this->default_sections();
		$this->default_controls = $this->default_controls();

		// Init and store sections
		$this->sections = $this->sections();

		// Init and store controls
		$this->controls = $this->controls();
    }

	/**
	* Default WP Customiser Panels
	*
	* @return   array 			Panels to be registered in the customizer
	*/

	private function panels(){
		global $layers_customizer_panels;

		// Set intial config.
		$layers_customizer_panels = array(
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

			'blog-archive-single' => array(
							'title' => __( 'Blog' , 'layerswp' ),
							'description' => __( 'Control your sites\'s sidebars and blog layout.' , 'layerswp' ), // @TODO Put a helper here
							'priority' => 70
						),

			'footer' => array(
							'title' => __( 'Footer' , 'layerswp' ),
							'description' => __( 'Control your footer\'s custom text, widget areas and layout.' , 'layerswp' ), // @TODO Put a helper here
							'priority' => 80
						),

			'woocommerce' => array(
							'title' => __( 'WooCommerce' , 'layerswp' ),
							'priority' => 100
						),
		);

		return apply_filters( 'layers_customizer_panels', $layers_customizer_panels );
	}

	/**
	* Default WP Customiser Panels
	*
	* @return   array 			Panels to be registered in the customizer
	*/

	private function default_panels(){

		$default_panels = array();

		$default_panels[ 'nav_menus' ] = array(
			'priority' => 50,
		);

		return apply_filters( 'layers_customizer_default_panels', $default_panels );
	}

	/**
	* Layers Customiser Sections
	*
	* @return   array 			Sections to be registered in the customizer
	*/

	private function default_sections(){

		$default_sections = array();

		$default_sections[ 'title_tagline' ] = array(
			'title' => __( 'Logo &amp; Title' , 'layerswp' ),
			'panel' => 'site-settings'
		);

		$default_sections[ 'colors' ] = array(
			'panel' => 'site-settings',
			'priority' => 55,
		);

		$default_sections[ 'background_image' ] = array(
			'panel' => 'site-settings',
			'priority' => 55,
		);

		$default_sections[ 'static_front_page' ] = array(
			'panel' => 'site-settings',
		);

		return apply_filters( 'layers_customizer_default_sections', $default_sections );
	}

	/**
	* Default WP Customiser Controls
	*
	* @return   array Controls to be registered in the customizer
	*/

	private function default_controls(){

		$default_controls = array();

		$default_sections[ 'header_textcolor' ] = array(
			'section' => 'site-colors'
		);

		$default_sections[ 'background_color' ] = array(
			'section' => 'site-colors'
		);

		return apply_filters( 'layers_customizer_default_controls', $default_sections );
	}


	/**
	* Layers Customiser Sections
	*
	* @return array Sections to be registered in the customizer
	*/

	private function sections(){
		global $layers_customizer_sections;

		// Following default sections need to be added so our registration process can access them
		$layers_customizer_sections[ 'title_tagline' ] = array(
			'panel' => 'site-settings'
		);

		$layers_customizer_sections[ 'colors' ] = array(
			'panel' => 'site-settings',
		);

		$layers_customizer_sections[ 'background_image' ] = array(
			'panel' => 'site-settings',
		);

		$layers_customizer_sections[ 'static_front_page' ] = array(
			'panel' => 'site-settings',
		);

		// End default sections

		$layers_customizer_sections[ 'site-general' ] = array(
			'title' =>__( 'General' , 'layerswp' ),
			'panel' => 'site-settings',
			'priority' => 45,
		);

		$layers_customizer_sections[ 'site-scripts' ] = array(
			'title' =>__( 'Additional Scripts' , 'layerswp' ),
			'panel' => 'site-settings',
		);

		if( !class_exists( 'Layers_Pro' ) ) {
			$layers_customizer_sections[ 'buttons'] = array(
				'title' => __( 'Buttons', 'layerswp' ),
				'panel' => 'site-settings',
			);
		}

		$layers_customizer_sections[ 'site-colors' ] = array(
			'title' =>__( 'Colors' , 'layerswp' ),
			'panel' => 'site-settings',
			'priority' => 50,
		);

		$layers_customizer_sections[ 'fonts' ] = array(
			'title' =>__( 'Fonts' , 'layerswp' ),
			'panel' => 'site-settings',
			'priority' => 55,
		);

		$layers_customizer_sections[ 'dev-switches' ] = array(
			'title' =>__( 'Dev Switches', 'layerswp' ),
			'panel' => 'site-settings',
			'priority' => 100,
		);

		$layers_customizer_sections[ 'css' ] = array(
			'title' =>__( 'CSS' , 'layerswp' ),
		);

		$layers_customizer_sections[ 'header-layout' ] = array(
			'title' =>__( 'Styling' , 'layerswp' ),
			'panel' => 'header',
		);

		$layers_customizer_sections[ 'header-layout' ] = array(
			'title' =>__( 'Styling' , 'layerswp' ),
			'panel' => 'header',
		);

		if( !class_exists( 'Layers_Pro' ) ) {
			$layers_customizer_sections[ 'header-menu-styling' ] = array(
				'title' =>__( 'Menu Styling' , 'layerswp' ),
				'panel' => 'header',
			);
		}

		$layers_customizer_sections[ 'blog-styling' ] = array(
			'title' => __( 'Styling', 'layerswp' ),
			'panel' => 'blog-archive-single',
		);

		$layers_customizer_sections[ 'blog-archive' ] = array(
			'title' => __( 'Archive', 'layerswp' ),
			'panel' => 'blog-archive-single',
		);

		$layers_customizer_sections['blog-single' ] = array(
			'title' => __( 'Posts &amp; Pages', 'layerswp' ),
			'panel' => 'blog-archive-single',
		);

		$layers_customizer_sections['footer-layout' ] = array(
			'title' =>__( 'Styling' , 'layerswp' ),
			'panel' => 'footer',
		);

		$layers_customizer_sections['footer-text' ] = array(
			'title' =>__( 'Text' , 'layerswp' ),
			'panel' => 'footer',
		);

		$layers_customizer_sections['footer-scripts' ] = array(
			'title' =>__( 'Additional Scripts' , 'layerswp' ),
			'panel' => 'footer',
		);

		$layers_customizer_sections['woocommerce-sidebars' ] = array(
			'title' =>__( 'Sidebars' , 'layerswp' ),
			'panel' => 'woocommerce',
		);

		$layers_customizer_sections['body-customization' ] = array(
			'title' =>__( 'Customization' , 'layerswp' ),
			'panel' => 'body',
		);

		return apply_filters( 'layers_customizer_sections', $layers_customizer_sections );
	}

	private function controls(){

		global $layers_customizer_controls;

		// Setup some folder variables
		$customizer_dir = '/core/customizer/';

		// Set intial config.
		$layers_customizer_controls = array();

		// Site Settings -> Logo & Title
		$layers_customizer_controls['title_tagline'] = array(
			'logo-upsell-layers-pro' => array(
				'type'  => 'layers-heading',
				'class' => 'layers-upsell-tag',
				'label'    => __( 'Upgrade to Layers Pro' , 'layerswp' ),
				'description' => __( 'Want more control over your Logo Size & Header Layout? <a target="_blank" href="https://www.layerswp.com/layers-pro/?ref=obox&utm_source=layers%20theme&utm_medium=link&utm_campaign=Layers%20Pro%20Upsell&utm_content=Site%20Settings%20Logo">Purchase Layers Pro</a> to unlock the full power of Layers!' , 'layerswp' ),
			),
		);

		// Site Settings -> Fonts
		$layers_customizer_controls['fonts'] = array(
			'typekit-id' => array(
				'type' => 'layers-text',
				'label'    => __( 'Typekit ID' , 'layerswp' ),
				'description' => sprintf( __( 'For more information on obtaining your Typekit ID, see <a href="%s" target="_blank">follow this link</a>.', 'layerswp' ), 'http://help.typekit.com/customer/portal/articles/6780' ),
			),
			'body-fonts' => array(
				'type' => 'layers-font',
				'label'    => __( 'Body' , 'layerswp' ),
				'selectors' => 'body',
				'choices' => layers_get_google_font_options(),
			),
			'heading-fonts' => array(
				'type' => 'layers-font',
				'label'    => __( 'Headings' , 'layerswp' ),
				'selectors' => 'h1,h2,h3,h4,h5,h6, .heading',
				'choices' => layers_get_google_font_options(),
			),
			'form-fonts' => array(
				'type' => 'layers-font',
				'label'    => __( 'Buttons' , 'layerswp' ),
				'selectors' => 'button, .button, input[type=submit]',
				'choices' => layers_get_google_font_options(),
			),
		);

		// Site Settings -> Layout
		$layers_customizer_controls['header-layout'] = array(
			'header-width' => array(
				'type'     => 'layers-select-icons',
				'heading_divider' => __( 'Header Width' , 'layerswp' ),
				'default' => 'layout-boxed',
				'choices' => array(
					'layout-boxed' => __( 'Boxed' , 'layerswp' ),
					'layout-fullwidth' => __( 'Full Width' , 'layerswp' ),
				),
			),
			'header-menu-layout' => array(
				'type'     => 'layers-select-icons',
				'heading_divider' => __( 'Header Arrangement' , 'layerswp' ),
				'default' => 'header-logo-left',
				'choices' => array(
					'header-logo-left' => __( 'Logo Left' , 'layerswp' ),
					'header-logo-right' => __( 'Logo Right' , 'layerswp' ),
					'header-logo-center-top' => __( 'Logo Center Top' , 'layerswp' ),
					'header-logo-top' => __( 'Logo Top' , 'layerswp' ),
					'header-logo-center' => __( 'Logo Center' , 'layerswp' ),
				),
			),
			'header-position-heading' => array(
				'type'  => 'layers-heading',
				'heading_divider' => __( 'Sticky Header' , 'layerswp' ),
			),
			'header-sticky' => array(
				'type'		=> 'layers-checkbox',
				'label'		=> __( 'Sticky' , 'layerswp' ),
				'class'		=> 'layers-pull-top layers-pull-bottom',
				'default'	=> FALSE,
			),
			'header-overlay' => array(
				'type'     => 'layers-checkbox',
				'label'    => __( 'Transparent Overlay' , 'layerswp' ),
				'default'	=> FALSE,
			),
			'header-upsell-layers-pro' => array(
				'type'  => 'layers-heading',
				'class' => 'layers-upsell-tag',
				'label'    => __( 'Upgrade to Layers Pro' , 'layerswp' ),
				'description' => __( 'Want more control over your Header Layout? <a target="_blank" href="https://www.layerswp.com/layers-pro/?ref=obox&utm_source=layers%20theme&utm_medium=link&utm_campaign=Layers%20Pro%20Upsell&utm_content=Site%20Settings%20Header%20Layout">Purchase Layers Pro</a> to unlock the full power of Layers!' , 'layerswp' ),
			),
		);
		// Site Settings -> Sidebars
		$layers_customizer_controls['blog-single'] = array(
			'single-sidebar-heading' => array(
				'type'  => 'layers-heading',
				'label'    => __( 'Single Post Sidebar(s)' , 'layerswp' ),
				'description' => __( 'This option affects your single post pages.' , 'layerswp' ),
			),
			'single-left-sidebar' => array(
				'type'      => 'layers-checkbox',
				'label'     => __( 'Display Left Sidebar' , 'layerswp' ),
				'default'   => FALSE,
			),
			'single-right-sidebar' => array(
				'type'      => 'layers-checkbox',
				'label'     => __( 'Display Right Sidebar' , 'layerswp' ),
				'default'   => TRUE,
			),
			'blog-single-upsell-layers-pro' => array(
				'type'  => 'layers-heading',
				'class' => 'layers-upsell-tag',
				'label'    => __( 'Upgrade to Layers Pro' , 'layerswp' ),
				'description' => __( 'Gain more layout and information customization options in your blog post pages by <a target="_blank" href="https://www.layerswp.com/layers-pro/?ref=obox&utm_source=layers%20theme&utm_medium=link&utm_campaign=Layers%20Pro%20Upsell&utm_content=Blog%20Single">upgrading to Layers Pro</a>.' , 'layerswp' ),
			),
		);

		$layers_customizer_controls['blog-archive'] = array(
			'archive-sidebar-heading' => array(
				'type'  => 'layers-heading',
				'label'    => __( 'Archive Sidebar(s)' , 'layerswp' ),
				'description' => __( 'This option affects your category, tag, author and search pages.' , 'layerswp' ),
			),
			'archive-left-sidebar' => array(
				'type'		=> 'layers-checkbox',
				'label' 	=> __( 'Display Left Sidebar' , 'layerswp' ),
				'default' 	=> FALSE,
			),
			'archive-right-sidebar' => array(
				'type'		=> 'layers-checkbox',
				'label' 	=> __( 'Display Right Sidebar' , 'layerswp' ),
				'default' 	=> TRUE,
			),
			'blog-archive-upsell-layers-pro' => array(
				'type'  => 'layers-heading',
				'class' => 'layers-upsell-tag',
				'label'    => __( 'Upgrade to Layers Pro' , 'layerswp' ),
				'description' => __( 'Gain more layout and information customization options in your blog archive pages by <a target="_blank" href="https://www.layerswp.com/layers-pro/?ref=obox&utm_source=layers%20theme&utm_medium=link&utm_campaign=Layers%20Pro%20Upsell&utm_content=Blog%20Archive">upgrading to Layers Pro</a>.' , 'layerswp' ),
			),
		);

		// Site Settings -> Colors
		$layers_customizer_controls['site-colors'] = array(
			'site-color-heading' => array(
				'type'  => 'layers-heading',
				'label'    => __( 'Site Wide Colors' , 'layerswp' ),
				'description' => __( 'These options allow you to change the key colors of your Layers website.' , 'layerswp' ),
			),
			'header-background-color' => array(
				'label' => '',
				'subtitle'		=> __( 'Header Color' , 'layerswp' ),
				'class' => 'group',
				'description' => __( 'This affects the background colors of your site header and page titles.', 'layerswp' ),
				'type'		=> 'layers-color',
				'default'	=> '#F3F3F3',
			),
			'site-accent-color' => array(
				'label' => '',
				'subtitle' => __( 'Site Accent Color', 'layerswp' ),
				'class' => 'group',
				'description' => __( 'Choose a color for your buttons and links.', 'layerswp' ),
				'type' => 'layers-color',
				'default' => FALSE,
			),
			'footer-background-color' => array(
				'label' => '',
				'subtitle' => __( 'Footer Color' , 'layerswp' ),
				'class' => 'group',
				'description' => __( 'This affects the background color of your site footer.', 'layerswp' ),
				'type' => 'layers-color',
				'default' => '#F3F3F3',
			),
			'colors-upsell-layers-pro' => array(
				'type'  => 'layers-heading',
				'class' => 'layers-upsell-tag',
				'label'    => __( 'Upgrade to Layers Pro' , 'layerswp' ),
				'description' => __( 'Want more color customzation? <a target="_blank" href="https://www.layerswp.com/layers-pro/?ref=obox&utm_source=layers%20theme&utm_medium=link&utm_campaign=Layers%20Pro%20Upsell&utm_content=Footer%20Layout">Purchase Layers Pro</a> and get the full box of crayons!' , 'layerswp' ),
			),
		);

		// Site Settings -> Dev Switches
		$layers_customizer_controls['dev-switches'] = array(
			'dev-switch-active' => array(
				'type'     => 'layers-checkbox',
				'label'    => __( 'Dev Switches Active' , 'layerswp' ),
				'description' => __( 'Unckecking this will immediately remove this panel. To switch it back on you will need to add #layers-develop to your url.' , 'layerswp' ),
				'default' => '',
			),
			'dev-switch-customizer-state-record' => array(
				'type'     => 'layers-checkbox',
				'label'    => __( 'Remember State in Customizer' , 'layerswp' ),
				'description' => __( 'This feature will add #hash values to the customizer URL so that when the page is refreshed the customizer will go back to it\'s same position.' , 'layerswp' ),
				'default' => '',
			),
			'dev-switch-widget-field-names' => array(
				'type'     => 'layers-checkbox',
				'label'    => __( "Display Widget Input 'name' Attributes", 'layerswp' ),
				'description' => __( 'This is used in preparation of a new Widget so developer can quickly see all the possible fields in a Widget and make sure to set defaults for them.', 'layerswp' ),
				'default' => '',
			),
			'dev-switch-button-css-testing' => array(
				'type'     => 'layers-checkbox',
				'label'    => __( "Display all Buttons CSS", 'layerswp' ),
				'description' => __( 'This will output the CSS generated by Layers Pro and Layers when customizing your Buttons Globally or in the Widgets.', 'layerswp' ),
				'default' => '',
			),
		);


		$layers_customizer_controls['site-scripts'] = array(
			'header-google-id' => array(
				'type'     => 'layers-text',
				'label'    => __( 'Google Analytics ID' , 'layerswp' ),
				'description' => __( 'Enter in your Google Analytics ID to enable website traffic reporting. eg. "UA-xxxxxx-xx' , 'layerswp' ),
				'default' => '',
			),
			'google-maps-api' => array(
				'type'     => 'layers-text',
				'label'    => __( 'Google Maps API Key' , 'layerswp' ),
				'description' => __( sprintf( 'Enter in your Maps API Key to enable your contact widget. <a href="%s" target="_blank">Click Here</a> to get your API Key.', 'https://developers.google.com/maps/documentation/javascript/get-api-key' ), 'layerswp' ),
				'default' => '',
			),
			'header-custom-scripts' => array(
				'type'     => 'layers-code',
				'label'    => __( 'Custom Header Scripts' , 'layerswp' ),
				'description' => __( 'Enter in any custom script to include in your site\'s header. Be sure to use double quotes for strings.' , 'layerswp' ),
				'default' => '',
			),
			'footer-custom-scripts' => array(
				'type'     => 'layers-code',
				'label'    => __( 'Custom Footer Scripts' , 'layerswp' ),
				'description' => __( 'Enter in any custom script to include in your site\'s footer. Be sure to use double quotes for strings.' , 'layerswp' ),
				'default' => '',
			),
		);

		// Footer -> Layout
		$layers_customizer_controls['footer-layout'] = array(
			'footer-width' => array(
				'type'     => 'layers-select-icons',
				'heading_divider' => __( 'Footer Width' , 'layerswp' ),
				'default' => 'layout-boxed',
				'choices' => array(
					'layout-boxed' => __( 'Boxed' , 'layerswp' ),
					'layout-fullwidth' => __( 'Full Width' , 'layerswp' ),
				),
			),
			'footer-sidebar-count' => array(
				'type'     => 'layers-select',
				'heading_divider'    => __( 'Widget Areas' , 'layerswp' ),
				'description' => __( 'Choose how many widget areas apear in the footer. Go here to <a class="customizer-link" href="#accordion-panel-widgets">customize footer widgets</a>.', 'layerswp' ),
				'default' => 4,
				'sanitize_callback' => 'layers_sanitize_number',
				'choices' => array(
					'0' => __( 'None' , 'layerswp' ),
					'1' => __( '1' , 'layerswp' ),
					'2' => __( '2' , 'layerswp' ),
					'3' => __( '3' , 'layerswp' ),
					'4' => __( '4' , 'layerswp' ),
				),
			),
			'footer-copyright-text' => array(
				'type'     => 'layers-text',
				'label'    => __( 'Copyright Text' , 'layerswp' ),
				'default' => ' Made at the tip of Africa. &copy;',
				'sanitize_callback' => FALSE
			),
			'show-layers-badge' => array(
				'label' => __( 'Support Layers' , 'layerswp' ),
				'description' => __( 'Support Layers by displaying the Layers badge on your site.', 'layerswp' ),
				'type' => 'layers-checkbox',
				'default' => true
			),
			'footer-upsell-layers-pro' => array(
				'type'  => 'layers-heading',
				'class' => 'layers-upsell-tag',
				'label'    => __( 'Upgrade to Layers Pro' , 'layerswp' ),
				'description' => __( 'Want more control over your Footer Layout? <a target="_blank" href="https://www.layerswp.com/layers-pro/?ref=obox&utm_source=layers%20theme&utm_medium=link&utm_campaign=Layers%20Pro%20Upsell&utm_content=Site%20Settings%20Footer%20Layout">Purchase Layers Pro</a> to unlock the full power of Layers!' , 'layerswp' ),
			),
		);

		// CSS
		$layers_customizer_controls['css'] = array(
			'custom-css' => array(
				'type'     => 'layers-code',
				'placeholder'	=> ".classname {\n\tbackground: #333;\n}",
				'sanitize_callback' => FALSE
			),
			'upsell-devkit-heading' => array(
				'type'  => 'layers-heading',
				'class' => 'layers-upsell-tag',
				'label'    => __( 'Upgrade to DevKit' , 'layerswp' ),
				'description' => __( 'Want the best CSS customization interface? <a target="_blank" href="http://bit.ly/layers-devkit">Purchase DevKit</a> and save bundles of time!' , 'layerswp' ),
			),
		);

		if( class_exists( 'WooCommerce' ) ) {
			$layers_customizer_controls[ 'woocommerce-sidebars' ] = array(
				'label-sidebar-single' => array(
					'type'  => 'layers-heading',
					'label'    => __( 'Single Product Sidebar(s)' , 'layerswp' ),
					'description' => __( 'This option affects your single product pages.' , 'layerswp' ),
				),
				'single-left-woocommerce-sidebar' => array(
					'type'      => 'layers-checkbox',
					'label'     => __( 'Display Left Sidebar' , 'layerswp' ),
					'default'   => FALSE,
				),
				'single-right-woocommerce-sidebar' => array(
					'type'      => 'layers-checkbox',
					'label'     => __( 'Display Right Sidebar' , 'layerswp' ),
					'default'   => TRUE,
				),
				'label-sidebar-archive' => array(
					'type'  => 'layers-heading',
					'label'    => __( 'Product List Sidebar(s)' , 'layerswp' ),
					'description' => __( 'This option affects your shop page, product category and product tag pages.' , 'layerswp' ),
				),
				'archive-left-woocommerce-sidebar' => array(
					'type'      => 'layers-checkbox',
					'label'     => __( 'Display Left Sidebar' , 'layerswp' ),
					'default'   => FALSE,
				),
				'archive-right-woocommerce-sidebar' => array(
					'type'      => 'layers-checkbox',
					'label'     => __( 'Display Right Sidebar' , 'layerswp' ),
					'default'   => TRUE,
				),
			);
		} // if WooCommerce

		/*
		* Layers Pro Upsells
		*/

		if( !class_exists( 'Layers_Pro' ) ){

			$layers_customizer_controls[ 'header-menu-styling' ] = array(
				'menu-upsell-layers-pro' => array(
					'type'  => 'layers-heading',
					'class' => 'layers-upsell-tag',
					'label'    => __( 'Upgrade to Layers Pro' , 'layerswp' ),
					'description' => __( 'Customize your menu colors, spacing and styles but upgrading to <a target="_blank" href="https://www.layerswp.com/layers-pro/?ref=obox&utm_source=layers%20theme&utm_medium=link&utm_campaign=Layers%20Pro%20Upsell&utm_content=Menu%20Styling">Layers Pro</a>.' , 'layerswp' ),
				),
			);

			$layers_customizer_controls['buttons'] = array(
				'buttons-upsell-layers-pro' => array(
					'type'  => 'layers-heading',
					'class' => 'layers-upsell-tag',
					'label'    => __( 'Upgrade to Layers Pro' , 'layerswp' ),
					'description' => __( 'Want to customize the color of your buttons as well as their hover states? <a target="_blank" href="https://www.layerswp.com/layers-pro/?ref=obox&utm_source=layers%20theme&utm_medium=link&utm_campaign=Layers%20Pro%20Upsell&utm_content=Buttons">Purchase Layers Pro</a> and gain full control over your button styling!' , 'layerswp' ),
				),
			);

			$layers_customizer_controls['blog-styling'] = array(
				'blog-styling-upsell-layers-pro' => array(
					'type'  => 'layers-heading',
					'class' => 'layers-upsell-tag',
					'label'    => __( 'Upgrade to Layers Pro' , 'layerswp' ),
					'description' => __( 'Want to customize the colors in your blog pages? <a target="_blank" href="https://www.layerswp.com/layers-pro/?ref=obox&utm_source=layers%20theme&utm_medium=link&utm_campaign=Layers%20Pro%20Upsell&utm_content=Blog%20Styling">Purchase Layers Pro</a> and gain full control over your blog!' , 'layerswp' ),
				),
			);
		}

		do_action( 'layers_customizer_controls_modify' );

		$layers_customizer_controls = apply_filters( 'layers_customizer_controls', $layers_customizer_controls );

		$layers_customizer_controls = $this->apply_defaults( $layers_customizer_controls );

		return $layers_customizer_controls;
	}

	private function apply_defaults( $controls ){

		$defaults = apply_filters( 'layers_customizer_control_defaults' , array() );

		if( empty( $defaults ) ) return $controls;

		foreach( $controls as $section_key => $control ){

			foreach( $control as $control_key => $control_data ) {
				if( isset( $defaults[ $control_key ] ) ){
					$controls[ $section_key ][ $control_key ][ 'default' ] = $defaults[ $control_key ];
				}
			}
		}

		return $controls;
	}
}