<?php /**
 * Customizer Registration File
 *
 * This file is used to register panels, sections and controls
 *
 * @package Layers
 * @since Layers 1.0.0
 */

class Layers_Customizer_Regsitrar {

	private static $instance;

	public $customizer;

	public $config;

	public $prefix;

	/**
	*  Initiator
	*/

	public static function get_instance(){
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Layers_Customizer_Regsitrar();
		}
		return self::$instance;
	}

	/**
	*  Constructor
	*/

	public function __construct() {

		// Register the customizer object
		global $wp_customize;
		$this->customizer = $wp_customize;

		//
		$this->prefix  = LAYERS_THEME_SLUG . '-';

		// Grab the customizer config
		$this->config = new Layers_Customizer_Config();
	}

	/**
	 * Register the panels and sections based on this instance's config
	 */
	public function init() {
		// Start registration with the panels & sections
		$this->register_panels( $this->config->panels() );
		$this->register_sections ( $this->config->sections() );

		// Move default sections into Layers Panels
		$this->move_default_sections( $this->config->default_sections() );
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
				$this->customizer->add_panel( $this->prefix . $panel_key , $panel_data );
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
				// Set which panel to use
				$section_data[ 'panel' ] = $this->prefix . $section_data[ 'panel' ];
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
			$this->register_controls ( $section_key , $this->config->controls() );
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

			// Register control default value
			$this->register_control_defaults( $setting_key, ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) );

			// Assign control to the relevant section
			$control_data[ 'section' ] = $this->prefix . $panel_section_key;

			// Set control priority to obey order of setup
			$control_data[ 'priority' ] = $control_priority;

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
						$setting_key ,
						$control_data
					)
				);
			} else if( 'layers-select-icons' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Select_Icon_Control(
						$this->customizer,
						$setting_key ,
						$control_data
					)
				);
			} else if( 'layers-seperator' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Seperator_Control(
						$this->customizer,
						$setting_key ,
						$control_data
					)
				);
			} else if( 'layers-heading' == $control_data['type'] ) {

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Heading_Control(
						$this->customizer,
						$setting_key ,
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
	* Register Control Defaults
	*/

	public function register_control_defaults( $key = NULL , $value = NULL ){

		global $layers_customizer_defaults;

		if( !isset( $layers_customizer_defaults ) ) $layers_customizer_defaults = array();

		if( NULL != $key ){
			$layers_customizer_defaults[ $key ] = esc_attr( $value );
		}

		return apply_filters( 'layers_customizer_defaults', $layers_customizer_defaults );
	}

	/**
	* Move Default Sections
	*/

	public function move_default_sections( $sections = array() ){

		foreach( $sections as $section_key => $section_data ){

			// Get the current section
			$section = $this->customizer->get_section( $section_key );

			// Move this section to a specific panel
			if( isset( $section_data[ 'panel' ] ) ) {
				$section->panel = $this->prefix . $section_data[ 'panel' ];
			}

			// Prioritize this section
			if( isset( $section_data[ 'title' ] ) ) {
				$section->title = $section_data[ 'title' ];
			}

			// Prioritize this section
			if( isset( $section_data[ 'priority' ] ) ) {
				$section->priority = $section_data[ 'priority' ];
			}
		}
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
				$callback = 'esc_textarea';
				break;
			default :
				$callback = 'sanitize_text_field';
		}

		return $callback;
	}

} // class Layers_Customizer_Regsitrar

function layers_register_customizer(){

	$layers_customizer_reg = new Layers_Customizer_Regsitrar();
	$layers_customizer_reg->init();

}

add_action( 'customize_register', 'layers_register_customizer', 99 );