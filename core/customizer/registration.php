<?php /**
 * Customizer Registration File
 *
 * This file is used to register panels, sections and controls
 *
 * @package Layers
 * @since Layers 1.0.0
 */

class Layers_Customizer_Regsitrar {

	public $customizer;

	public $config;

	public $prefix;

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

		// Register the customizer object
		global $wp_customize;

		$this->customizer = $wp_customize;

		// Set Prefix
		$this->prefix  = LAYERS_THEME_SLUG . '-';

		// Grab the customizer config
		$this->config = Layers_Customizer_Config::get_instance();

		//Register the panels and sections based on this instance's config

		// Start registration with the panels & sections
		$this->register_panels( $this->config->panels );
		$this->register_sections ( $this->config->sections );

		// Move default sections into Layers Panels
		$this->move_default_panels( $this->config->default_panels );
		$this->move_default_sections( $this->config->default_sections );
		$this->move_default_controls( $this->config->default_controls );

		// Change 'Widgets' panel title to 'Edit Layout'
		if ( method_exists( $wp_customize, 'add_panel' ) ) { // `add_panel` only arrived in WP 4.0
			$wp_customize->add_panel(
				'widgets', array(
					'priority' => 0,
					'title' => __( 'Edit Layout' , 'layerswp' ),
					'description' => Layers_Customizer::get_instance()->render_builder_page_dropdown() . __('Use this area to add widgets to your page, use the (Layers) widgets for the Body section.' , 'layerswp' ),
				)
			);
		}
	}

	/**
	* Check whether or not panels are supported by the customizer
	*
	* @return   boolean 	true if panels are supported
	*/

	function customizer_supports_panels(){
		return ( class_exists( 'WP_Customize_Manager' ) && method_exists( 'WP_Customize_Manager', 'add_panel' ) ) || function_exists( 'wp_validate_boolean' );
	}

	/**
	* Register Panels
	*
	* @panels   array 	Array of panel config
	*/

	function register_panels( $panels = array() ){

		// If there are no panels, return
		if( empty( $panels ) ) return;

		foreach( $panels as $panel_key => $panel_data ) {

			// If panels are supported, add this as a panel
			if( $this->customizer_supports_panels() ) {
				
				// Add Panel.
				if ( in_array( $panel_key, $this->customizer->panels() ) ) {
					// Panel exists without 'layers-' prepended, so shouldn't be added.
					continue;
				}
				else {
					// Add Panel with 'layers-' prepended.
					$this->customizer->add_panel( $this->prefix . $panel_key , $panel_data );
				}
			}

		} // foreach panel
	}

	/**
	* Register Sections
	*
	* @panel_key  string 		Unique key for which panel this section belongs to
	* @sections   array 		Array of sections config
	*/
	public function register_sections( $sections = array() ){

		// If there are no sections, return
		if( empty( $sections ) ) return;

		$section_priority = 150;

		foreach( $sections as $section_key => $section_data ){

			if( $this->customizer_supports_panels() && isset( $section_data[ 'panel' ] ) ) {
				
				// Add Section.
				if ( in_array( $section_data[ 'panel' ], $this->customizer->panels() ) ) {
					// Panel exists without 'layers-' prepended, so add the section to that panel.
					$section_data[ 'panel' ] = $section_data[ 'panel' ];
				}
				else {
					// Panel exists with 'layers-' prepended, so add the section to that panel.
					$section_data[ 'panel' ] = $this->prefix . $section_data[ 'panel' ];
				}
			}

			if( !isset( $section_data[ 'priority' ] ) ) {
				$section_data[ 'priority' ] = $section_priority;
			}

			$this->customizer->add_section(
				$this->prefix . $section_key ,
				$section_data
			);

			$section_priority++;

			// Register Sections for this Panel
			$this->register_controls ( $section_key , $this->config->controls );
		}

	}

	/**
	* Register Panels
	*
	* @panel_section_key  	string 		Unique key for which section this control belongs to
	* @controls   			array 			Array of controls config
	*/
	public function register_controls( $panel_section_key = '' , $controls = array() ){

		// If there are no sections, return
		if( empty( $controls ) ) return;

		// Make sure that there is actually section config for this panel
		if( !isset( $controls[ $panel_section_key ] ) ) return;

		$control_priority = 150;

		foreach( $controls[ $panel_section_key ] as $control_key => $control_data ){

			$setting_key = $this->prefix . $control_key;
			
			// Add Control.
			if ( $this->customizer->get_section( $panel_section_key ) ) {
				// Section exists without 'layers-' prepended, so add control to it.
				$control_data[ 'section' ] = $panel_section_key;
			}
			else {
				// Section exists with 'layers-' prepended, so add control to it.
				$control_data[ 'section' ] = $this->prefix . $panel_section_key;
			}

			// Set control priority to obey order of setup
			$control_data[ 'priority' ] = $control_priority;
			
			// Add the default into the control data so it can be accessed if needed.
			$control_data[ 'default' ] = isset( $control_data['default'] ) ? $control_data['default'] : NULL ;

			// Add Setting
			$this->customizer->add_setting(
				$setting_key,
				array(
					'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
					'type'       => 'theme_mod',
					'capability' => 'manage_options',
					'sanitize_callback' => $this->add_sanitize_callback( $control_data )
				)
			);

			if ( 'layers-select-images' == $control_data['type'] ) {
				
				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Select_Image_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-select-icons' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Select_Icon_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-seperator' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Seperator_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-heading' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Heading_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-color' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Color_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-checkbox' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Checkbox_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-select' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Select_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-textarea' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Textarea_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-rte' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_RTE_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);

			} else if( 'layers-font' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Font_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if ( 'layers-button' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Button_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-code' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Code_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-text' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Text_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-number' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Number_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-range' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Range_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-trbl-fields' == $control_data['type'] ) {

				// Add extra settings fields for Top/Right/Bottom/Left
				$this->customizer->add_setting(
					$setting_key . '-top',
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options',
						'sanitize_callback' => $this->add_sanitize_callback( $control_data )
					)
				);
				$this->customizer->add_setting(
					$setting_key . '-right',
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options',
						'sanitize_callback' => $this->add_sanitize_callback( $control_data )
					)
				);
				$this->customizer->add_setting(
					$setting_key . '-bottom',
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options',
						'sanitize_callback' => $this->add_sanitize_callback( $control_data )
					)
				);
				$this->customizer->add_setting(
					$setting_key . '-left',
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options',
						'sanitize_callback' => $this->add_sanitize_callback( $control_data )
					)
				);
				
				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_TRBL_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'text' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new WP_Customize_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'color' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new WP_Customize_Color_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'upload' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new WP_Customize_Upload_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'image' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new WP_Customize_Image_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'background-image' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new WP_Customize_Background_Image_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'header-image' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new WP_Customize_Header_Image_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else {

				// Add Control
				$this->customizer->add_control(
					$setting_key,
					$control_data
				);
			}

			$control_priority++;

		} // foreach controls panel_section_key
	}

	/**
	* Move Default Panels
	*/

	public function move_default_panels( $panels = array() ){
		
		if ( ! method_exists( $this->customizer, 'get_panel' ) ) return; // `get_panel` only arrived in WP 4.0

		foreach( $panels as $panel_key => $panel_data ){

			// Get the current panel
			$panel = $this->customizer->get_panel( $panel_key );

			// Panel Title
			if( isset( $panel->title ) && isset( $panel_data[ 'title' ] ) ) {
				$panel->title = $panel_data[ 'title' ];
			}

			// Panel Priority
			if( isset( $panel->priority ) && isset( $panel_data[ 'priority' ] ) ) {
				$panel->priority = $panel_data[ 'priority' ];
			}

		}

		// Remove the theme switcher Panel, Layers isn't ready for that
		$this->customizer->remove_section( 'themes' );
	}

	/**
	* Move Default Sections
	*/

	public function move_default_sections( $sections = array() ){

		foreach( $sections as $section_key => $section_data ){

			// Get the current section
			$section = $this->customizer->get_section( $section_key );

			// Move this section to a specific panel
			if( isset( $section->panel ) && isset( $section_data[ 'panel' ] ) ) {
				$section->panel = $this->prefix . $section_data[ 'panel' ];
			}

			// Section Title
			if( isset( $section->title ) && isset( $section_data[ 'title' ] ) ) {
				$section->title = $section_data[ 'title' ];
			}

			// Section Priority
			if( isset( $section->priority ) && isset( $section_data[ 'priority' ] ) ) {
				$section->priority = $section_data[ 'priority' ];
			}
		}
	}
	/**
	* Move Default Controls
	*/

	public function move_default_controls( $controls = array() ){

		foreach( $controls as $control_key => $control_data ){

			// Get the current control
			$control = $this->customizer->get_control( $control_key );

			// Move this control to a specific section
			if( isset( $control->section ) && isset( $control_data[ 'section' ] ) ) {
				$control->section = $this->prefix . $control_data[ 'section' ];
			}

			// Section Title
			if( isset( $control->title ) && isset( $control_data[ 'title' ] ) ) {
				$control->title = $control_data[ 'title' ];
			}

			// Section Priority
			if( isset( $control->priority ) && isset( $control_data[ 'priority' ] ) ) {
				$control->priority = $control_data[ 'priority' ];
			}
		}


		// Remove the header text color control, we don't support it yet
		$this->customizer->remove_section( 'colors' );
	}

	/**
	* Add Sanitization according to the control type (or use the explicit callback that has been set)
	*/

	function add_sanitize_callback( $control_data = FALSE ){

		// If there's an override, use the override rather than the automatic sanitization
		if( isset( $control_data[ 'sanitize_callback' ] ) ) {
			if( FALSE == $control_data[ 'sanitize_callback' ] ) {
				return FALSE;
			} else {
				return $control_data[ 'sanitize_callback' ];
			}
		}

		switch( $control_data[ 'type' ] ) {
			case 'layers-color' :
				$callback = 'sanitize_hex_color';
				break;
			case 'layers-checkbox' :
				$callback = 'layers_sanitize_checkbox';
				break;
			case 'layers-textarea' :
				$callback = 'esc_textarea';
				break;
			case 'layers-code' :
				$callback = false;
				break;
			case 'layers-rte' :
				$callback = false;
				break;
			default :
				$callback = 'sanitize_text_field';
		}

		return $callback;
	}

}

function layers_register_customizer(){
	$layers_customizer_reg = Layers_Customizer_Regsitrar::get_instance();
}

add_action( 'customize_register', 'layers_register_customizer', 99 );