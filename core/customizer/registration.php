<?php /**
 * Customizer Registration File
 *
 * This file is used to register panels, sections and controls
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Customizer_Regsitrar {

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
		$this->prefix  = HATCH_THEME_SLUG . '-';

		// Grab the customizer config
		$this->config = new Hatch_Customizer_Config();

		// Start registration with the panels
		$this->register_panels( $this->config->panels() );

		// Move default sections into Hatch Panels
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

			// Register Sections for this Panel
			$this->register_sections ( $panel_key , $this->config->sections() );

		} // foreach panel
	}

	/**
	* Register Sections
	*
	* @panel_key  varchar 		Unique key for which panel this section belongs to
	* @sections   array 		Array of sections config
	*/
	public function register_sections( $panel_key = '', $sections = array() ){

		// If there are no sections, return
		if( empty( $sections ) ) return;

		// Make sure that there is actually section config for this panel
		if( !isset( $sections[ $panel_key ] ) ) return;

		$section_priority = 150;

		foreach( $sections[ $panel_key ] as $section_key => $section_data ){

			if( $this->customizer_supports_panels() ) {
				// Set which panel to use
				$section_data[ 'panel' ] = $this->prefix . $panel_key;
			}

			$section_data[ 'priority' ] = $section_priority;

			$this->customizer->add_section(
				$this->prefix . $panel_key . '-' . $section_key ,
				$section_data
			);

			$section_priority++;

			// Register Sections for this Panel
			$this->register_controls ( $panel_key . '-' . $section_key , $this->config->controls() );
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

			$setting_key = $this->prefix . $panel_section_key . '-' . $control_key;

			// Add settings
			$this->customizer->add_setting(
				$setting_key,
				array(
					'default'    => ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) ,
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				)
			);

			// Assign control to the relevant section
			$control_data[ 'section' ] = $this->prefix . $panel_section_key;

			// Set control priority to obey order of setup
			$control_data[ 'priority' ] = $control_priority;

			if ( 'select-images' == $control_data['type'] ) {

				$this->customizer->add_control(
					new Hatch_Customize_Select_Image_Control(
						$this->customizer,
						$setting_key ,
						$control_data
					)
				);
			} else if( 'select-icons' == $control_data['type'] ) {

				$this->customizer->add_control(
					new Hatch_Customize_Select_Icon_Control(
						$this->customizer,
						$setting_key ,
						$control_data
					)
				);
			} else if( 'seperator' == $control_data['type'] ) {

				$this->customizer->add_control(
					new Hatch_Customize_Seperator_Control(
						$this->customizer,
						$setting_key ,
						$control_data
					)
				);
			} else if( 'heading' == $control_data['type'] ) {

				$this->customizer->add_control(
					new Hatch_Customize_Heading_Control(
						$this->customizer,
						$setting_key ,
						$control_data
					)
				);
			} else {

				$this->customizer->add_control(
					$setting_key,
					$control_data
				);
			}

			$control_priority++;

		} // foreach controls panel_section_key
	}

	/**
	* Move Default Sections
	*/

	public function move_default_sections( $sections = array() ){

		foreach( $sections as $section_key => $setion_data ){

			// Get the current section
			$section = $this->customizer->get_section( $section_key );

			// Move Site Title & Tagline section to General panel
			$section->panel = $this->prefix . $setion_data[ 'panel' ];
		}
	}

} // class Hatch_Customizer_Regsitrar

function hatch_register_customizer(){

	$hatch_customizer_reg = new Hatch_Customizer_Regsitrar();
	$hatch_customizer_reg->init();

}

add_action( 'customize_register', 'hatch_register_customizer', 99 );