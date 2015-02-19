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

	public static function init(){
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
	* @panel_key  varchar 		Unique key for which panel this section belongs to
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
	* @panel_section_key  	varchar 		Unique key for which section this control belongs to
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

			if ( 'layers-select-images' == $control_data['type'] ) {

				// Add Setting
				$this->customizer->add_setting(
					$setting_key,
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Select_Image_Control(
						$this->customizer,
						$setting_key ,
						$control_data
					)
				);
			} else if( 'layers-select-icons' == $control_data['type'] ) {

				// Add Setting
				$this->customizer->add_setting(
					$setting_key,
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Select_Icon_Control(
						$this->customizer,
						$setting_key ,
						$control_data
					)
				);
			} else if( 'layers-seperator' == $control_data['type'] ) {

				// Add Setting
				$this->customizer->add_setting(
					$setting_key,
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Seperator_Control(
						$this->customizer,
						$setting_key ,
						$control_data
					)
				);
			} else if( 'layers-heading' == $control_data['type'] ) {

				// Add Setting
				$this->customizer->add_setting(
					$setting_key,
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Heading_Control(
						$this->customizer,
						$setting_key ,
						$control_data
					)
				);
			} else if( 'layers-color' == $control_data['type'] ) {

				// Add Setting
				$this->customizer->add_setting(
					$setting_key,
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Color_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-checkbox' == $control_data['type'] ) {

				// Add Setting
				$this->customizer->add_setting(
					$setting_key,
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Checkbox_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-select' == $control_data['type'] ) {

				// Add Setting
				$this->customizer->add_setting(
					$setting_key,
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Select_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-font' == $control_data['type'] ) {

				// Add Setting
				$this->customizer->add_setting(
					$setting_key,
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Font_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if ( 'layers-button' == $control_data['type'] ) {

				// Add Setting
				$this->customizer->add_setting(
					$setting_key,
					array(
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Button_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-css' == $control_data['type'] ) {

				// Add Setting
				$this->customizer->add_setting(
					$setting_key,
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_CSS_Control(
						$this->customizer,
						$setting_key,
						$control_data
					)
				);
			} else if( 'layers-background' == $control_data['type'] ) {

				// Footer Background Heading

				$duplicate_control_data = wp_parse_args(
					array(
						'label' => __( 'Background' , 'layerswp' ),
						'subtitle' => __( 'Background Image' , 'layerswp' ),
						'type' => 'layers-heading', //wierd bug in WP4.1 that requires a type to be in the array, or will revert to default control,
					),
					$control_data
				);

				// Add Setting
				$this->customizer->add_setting(
					$setting_key . '-background-heading',
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Heading_Control(
						$this->customizer,
						$setting_key . '-background-heading',
						$duplicate_control_data
					)
				);

				// Footer Background Image

				// Modify Control data - so we can add uniqie subtitle, label, default
				$duplicate_control_data = wp_parse_args(
					array(
						'label' => '',
						'subtitle' => __( 'Background Image' , 'layerswp' ),
						'type' => 'layers-select-images', //wierd bug in WP4.1 that requires a type to be in the array, or will revert to default control
					),
					$control_data
				);

				// Add Setting
				$this->customizer->add_setting(
					$setting_key . '-background-image',
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				// Add Control
				$this->customizer->add_control(
					new Layers_Customize_Select_Image_Control(
						$this->customizer,
						$setting_key . '-background-image',
						$duplicate_control_data
					)
				);

				// Footer Background Color

				$duplicate_control_data = wp_parse_args(
					array(
						'label' => '',
						'subtitle' => __( 'Background Color' , 'layerswp' ),
						'type' => 'layers-color',
					),
					$control_data
				);

				$this->customizer->add_setting(
					$setting_key . '-background-color',
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				$this->customizer->add_control(
					new Layers_Customize_Color_Control(
						$this->customizer,
						$setting_key . '-background-color',
						$duplicate_control_data
					)
				);

				// Footer Background Repeat

				$duplicate_control_data = wp_parse_args(
					array(
						'label' => '',
						'subtitle' => __( 'Repeat' , 'layerswp' ),
						'type' => 'layers-select',
						'choices' => isset( $control_data['choices']['background-repeat'] ) ? $control_data['choices']['background-repeat'] : array(),
					),
					$control_data
				);

				$this->customizer->add_setting(
					$setting_key . '-background-repeat',
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				$this->customizer->add_control(
					new Layers_Customize_Select_Control(
						$this->customizer,
						$setting_key . '-background-repeat',
						$duplicate_control_data
					)
				);

				// Footer Background Position

				$duplicate_control_data = wp_parse_args(
					array(
						'label' => '',
						'subtitle' => __( 'Position' , 'layerswp' ),
						'type' => 'layers-select',
						'choices' => isset( $control_data['choices']['background-position'] ) ? $control_data['choices']['background-position'] : array(),
					),
					$control_data
				);

				$this->customizer->add_setting(
					$setting_key . '-background-position',
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				$this->customizer->add_control(
					new Layers_Customize_Select_Control(
						$this->customizer,
						$setting_key . '-background-position',
						$duplicate_control_data
					)
				);

				// Footer Background Stretch

				$duplicate_control_data = wp_parse_args(
					array(
						'label' => __( 'Stretch' , 'layerswp' ),
						'subtitle' => '',
						'type' => 'layers-checkbox',
					),
					$control_data
				);

				$this->customizer->add_setting(
					$setting_key . '-background-stretch',
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

				$this->customizer->add_control(
					new Layers_Customize_Checkbox_Control(
						$this->customizer,
						$setting_key . '-background-stretch',
						$duplicate_control_data
					)
				);

			} else {

				// Add Setting
				$this->customizer->add_setting(
					$setting_key,
					array(
						'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
						'type'       => 'theme_mod',
						'capability' => 'manage_options'
					)
				);

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

} // class Layers_Customizer_Regsitrar

function layers_register_customizer(){

	$layers_customizer_reg = new Layers_Customizer_Regsitrar();
	$layers_customizer_reg->init();

}

add_action( 'customize_register', 'layers_register_customizer', 99 );