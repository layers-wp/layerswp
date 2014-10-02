<?php /**
 * Customizer Configuration File
 *
 * This file is used to define the different panels, sections and controls for Hatch
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Customizer_Config {

	public function settings( $settings = array() ){

		// Header Panel
		$settings['footer'] = array(
				'function' => 'add_panel',
				'priority' => 100,
				'key' => 'footer',
				'title' =>  __( 'Footer' , HATCH_THEME_SLUG ) ,
				'description' => __( 'Your description here' , HATCH_THEME_SLUG ) // @TODO Put a helper here
			);

		// Header Panel -> Sections
		$settings['footer']['sections'] = array(
			'layout' => array(
				'section_key' => 'layouts',
				'section_title' =>__( 'Layouts' , HATCH_THEME_SLUG )
			)
		);

		// Header Panel -> Sections -> Controls
		$settings['footer']['sections']['layout']['controls']['copyright'] = array(
				'type'     => 'text',
				'mode'     => 'image',
				'label'    => __( 'Copyright Text', HATCH_THEME_SLUG ),
				'default' => ' Made at the tip of Africa. &copy; '
			); // Copyright Text

		return apply_filters( 'hatch_customizer_settings', $settings );
	}
}