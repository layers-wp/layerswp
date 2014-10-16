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

		$panel_priority = 150;

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

			$this->customizer->add_section(
				$this->prefix . $panel_key . '-' . $section_key ,
				$section_data
			);

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
	public function register_controls( $panel_section_key = '' , $controls = array()){

		// If there are no sections, return
		if( empty( $controls ) ) return;

		// Make sure that there is actually section config for this panel
		if( !isset( $controls[ $panel_section_key ] ) ) return;

		$control_priority = 150;

		foreach( $controls[ $panel_section_key ] as $control_key => $control_data ){

			// Add settings
			$this->customizer->add_setting(
				$this->prefix . $panel_section_key . '-' . $control_key ,
				array(
					'default'    => $control_data['default'],
					'type'       => 'option',
					'capability' => 'edit_theme_options'
				)
			);

			// Assign control to the relevant section
			$control_data[ 'section' ] = $this->prefix . $panel_section_key;

			if ( 'radio' == $control_data['type'] ) {

				$this->customizer->add_control(
					new Hatch_Customize_Radio_Control(
						$this->customizer,
						$this->prefix . $panel_section_key . '-' . $control_key ,
						$control_data
					)
				);

			} else {

				$this->customizer->add_control(
					$this->prefix . $panel_section_key . '-' . $control_key ,
					$control_data
				);
			}

		} // foreach controls panel_section_key
	}

} // class Hatch_Customizer_Regsitrar

function hatch_register_customizer(){

	$hatch_customizer_reg = new Hatch_Customizer_Regsitrar();
	$hatch_customizer_reg->init();

}

add_action( 'customize_register', 'hatch_register_customizer', 99 );