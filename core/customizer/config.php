<?php /**
 * Customizer Configuration File
 *
 * This file is used to define the different panels, sections and controls for Hatch
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Customizer_Config {

	public function settings(){

		// Branding Section
		$settings['branding'] = array(
				'function' => 'add_panel',
				'priority' => 100,
				'key' => 'branding',
				'title' =>  __( 'Site Branding' , HATCH_THEME_SLUG ) ,
				'description' => __( 'Your description here' , HATCH_THEME_SLUG ) // @TODO Put a helper here
			);

		// Branding Panel -> Sections
		$settings['branding']['sections'] = array(
			'images' => array(
				'section_key' => 'images',
				'section_title' =>__( 'Images and Logos' , HATCH_THEME_SLUG )
			),
			'social-icons' => array(
				'section_key' => 'social-icons',
				'section_title' =>__( 'Social Icons' , HATCH_THEME_SLUG )
			)
		);

		// Branding Section -> Controls
		$settings['branding']['sections']['images']['controls']['logo'] = array(
				'type' => 'image',
				'label' => __( 'Logo' , HATCH_THEME_SLUG ),
				'description' => __( 'Your description here' , HATCH_THEME_SLUG ) // @TODO Put a helper here
			); // Image field

		$settings['branding']['sections']['images']['controls']['retina'] = array(
				'type' => 'image',
				'label' => __( 'Retina Logo' , HATCH_THEME_SLUG ),
				'description' => __( 'Your description here' , HATCH_THEME_SLUG ) // @TODO Put a helper here
			); // Image field

		$settings['branding']['sections']['images']['controls']['favicon'] = array(
				'type' => 'image',
				'label' => __( 'Favicon' , HATCH_THEME_SLUG ),
				'description' => __( 'Your description here' , HATCH_THEME_SLUG ) // @TODO Put a helper here
			); // Image field

		$settings['branding']['sections']['images']['controls']['apple-touch'] = array(
				'type' => 'image',
				'label' => __( 'Apple Touch App Icon' , HATCH_THEME_SLUG ),
				'description' => __( 'Your description here' , HATCH_THEME_SLUG ) // @TODO Put a helper here
			); // Image field

		// Header Panel
		$settings['header'] = array(
				'function' => 'add_panel',
				'priority' => 100,
				'key' => 'header',
				'title' =>  __( 'Header Settings' , HATCH_THEME_SLUG ) ,
				'description' => __( 'Your description here' , HATCH_THEME_SLUG ) // @TODO Put a helper here
			);

		// Header Panel -> Sections
		$settings['header']['sections'] = array(
			'layout' => array(
				'section_key' => 'layouts',
				'section_title' =>__( 'Layouts' , HATCH_THEME_SLUG )
			),
			'display' => array(
				'section_key' => 'display',
				'section_title' =>__( 'Display Options' , HATCH_THEME_SLUG )
			),
			'colors' => array(
				'section_key' => 'colors',
				'section_title' =>__( 'Colors' , HATCH_THEME_SLUG )
			)
		);

		// Header Panel -> Sections -> Controls
		$settings['header']['sections']['layout']['controls']['logo-layout'] = array(
				'type'     => 'radio',
				'mode'     => 'image',
				'label'    => __( 'Logo Layout', HATCH_THEME_SLUG ),
				'default' => 'logo-left',
				'choices' => array(
					'centered' => HATCH_TEMPLATE_URI . '/core/customizer/images/1c.png',
					'logo-left' => HATCH_TEMPLATE_URI . '/core/customizer/images/2cr.png',
					'logo-right' => HATCH_TEMPLATE_URI . '/core/customizer/images/2cl.png',
					'hide' => HATCH_TEMPLATE_URI . '/core/customizer/images/1c.png',
				)
			); // Image Radio
		$settings['header']['sections']['layout']['controls']['menu-alignment'] = array(
				'type'     => 'radio',
				'mode'     => 'image',
				'label'    => __( 'Menu Alignment', HATCH_THEME_SLUG ),
				'default' => 'left',
				'choices' => array(
					'centered' => HATCH_TEMPLATE_URI . '/core/customizer/images/1c.png',
					'left' => HATCH_TEMPLATE_URI . '/core/customizer/images/2cr.png',
					'right' => HATCH_TEMPLATE_URI . '/core/customizer/images/2cl.png',
					'new-line' => HATCH_TEMPLATE_URI . '/core/customizer/images/1c.png',
				)
			); // Image Radio
		$settings['header']['sections']['layout']['controls']['extras'] = array(
				'type'     => 'radio',
				'mode'     => 'image',
				'label'    => __( 'Additional Elements Alignment', HATCH_THEME_SLUG ),
				'choices' => array(
					'centered' => HATCH_TEMPLATE_URI . '/core/customizer/images/1c.png',
					'left' => HATCH_TEMPLATE_URI . '/core/customizer/images/2cr.png',
					'right' => HATCH_TEMPLATE_URI . '/core/customizer/images/2cl.png'
				),
				'default' => 'left'
			); // Image Radio
		$settings['header']['sections']['layout']['controls']['header-position'] = array(
				'type'     => 'radio',
				'mode'     => 'buttonset',
				'label'    => __( 'Header Position', HATCH_THEME_SLUG ),
				'default' => 'fixed',
				'choices' => array(
					'fixed' => 'Fixed',
					'scroll' => 'Scroll'
				)
			); // Image Radio

		$settings['header']['sections']['display']['controls']['shopping-cart'] = array(
				'type'     => 'premium',
				'label'    => __( 'Shopping Cart', HATCH_THEME_SLUG ),
				'description' => __( '' , HATCH_THEME_SLUG)
			); // Premium

		$settings['header']['sections']['display']['controls']['social-links'] = array(
				'type'     => 'radio',
				'mode'     => 'buttonset',
				'label'    => __( 'Social Links', HATCH_THEME_SLUG ),
				'default' => 'show',
				'choices' => array(
					'show' => __( 'Show', HATCH_THEME_SLUG ),
					'hide' => __( 'Hide', HATCH_THEME_SLUG ),
				)
			); // Image Radio

		$settings['header']['sections']['display']['controls']['extras'] = array(
				'type'     => 'radio',
				'mode'     => 'buttonset',
				'label'    => __( 'Extras', HATCH_THEME_SLUG ),
				'default' => 'show',
				'choices' => array(
					'show' => __( 'Show', HATCH_THEME_SLUG ),
					'hide' => __( 'Hide', HATCH_THEME_SLUG ),
				)
			); // Image Radio

		return apply_filters( 'hatch_customizer_settings', $settings );
	}
}