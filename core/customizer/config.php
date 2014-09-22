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

		// Framework Panel
		$settings['framework'] = array(
				'function' => 'add_panel',
				'priority' => 100,
				'key' => 'framework',
				'title' =>  __( 'Framework' , HATCH_THEME_SLUG ) ,
				'description' => __( 'Your description here' , HATCH_THEME_SLUG ) // @TODO Put a helper here
			);

		// Framework Panel -> Sections
		$settings['framework']['sections'] = array(
			'control_examples' => array(
				'section_key' => 'control_examples',
				'section_title' =>__( 'Control Examples' , HATCH_THEME_SLUG )
			)
		);

		// Framework Panel -> Controls Section -> Controls
		$settings['framework']['sections']['control_examples']['controls']['radio_buttonset'] = array(
				'type'     => 'radio',
				'mode'     => 'buttonset',
				'label'    => __( 'Radio Button Set', HATCH_THEME_SLUG ),
				'separator' => true,
				'default'  => 'option_1',
				'priority' => 1,
				'choices'  => array(
					'option_1' => __( 'Option 1', HATCH_THEME_SLUG ),
					'option_2' => __( 'Option 2', HATCH_THEME_SLUG ),
					'option_3' => __( 'Option 3', HATCH_THEME_SLUG ),
					'option_4' => __( 'Option 4', HATCH_THEME_SLUG ),
				),
			); // Radio Buttonset

		$settings['framework']['sections']['control_examples']['controls']['checkbox'] = array(
				'type'     => 'checkbox',
				'label'    => __( 'Checkbox', HATCH_THEME_SLUG ),
				'separator' => true,
				'default'  => 0,
				'priority' => 1,
			); //

		$settings['framework']['sections']['control_examples']['controls']['color'] = array(
				'type'     => 'color',
				'label'    => __( 'Color Picker', HATCH_THEME_SLUG ),
				'separator' => true,
				'default'  => '#1abc9c',
				'priority' => 1,
			); // Color

		$settings['framework']['sections']['control_examples']['controls']['image'] = array(
				'type'     => 'image',
				'label'    => __( 'Image Upload', HATCH_THEME_SLUG ),
				'separator' => true,
				'default'  => '',
				'priority' => 1,
			); // Image

		$settings['framework']['sections']['control_examples']['controls']['background'] = array(
				'type'         => 'background',
				'label'        => __( 'Background', HATCH_THEME_SLUG ),
				'separator' => true,
				'description'  =>   __( 'Background Color', HATCH_THEME_SLUG ),
				'default'      => array(
					'color'    => '#ffffff',
					'image'    => null,
					'repeat'   => 'repeat',
					'size'     => 'inherit',
					'attach'   => 'inherit',
					'position' => 'left-top',
					'opacity'  => 100,
				),
				'priority' => 3,
				'output' => 'body',
			); // Background

		$settings['framework']['sections']['control_examples']['controls']['radio_image'] = array(
			'type'     => 'radio',
			'mode'     => 'image',
			'label'    => __( 'Image Selector', HATCH_THEME_SLUG ),
			'separator' => true,
			'priority' => 1,
			'default'  => 1,
			'choices'  => array(
					0 => get_template_directory_uri() . '/core/customizer/images/1c.png',
					1 => get_template_directory_uri() . '/core/customizer/images/2cr.png',
					2 => get_template_directory_uri() . '/core/customizer/images/2cl.png',
					3 => get_template_directory_uri() . '/core/customizer/images/3cl.png',
					4 => get_template_directory_uri() . '/core/customizer/images/3cr.png',
					5 => get_template_directory_uri() . '/core/customizer/images/3cm.png',
				)
			); // Radio Images

		$settings['framework']['sections']['control_examples']['controls']['multicheck'] = array(
				'type'     => 'multicheck',
				'label'    => __( 'Multi Checkbox', HATCH_THEME_SLUG ),
				'separator' => true,
				'default'  => 'option_1',
				'priority' => 1,
				'choices'  => array(
					'option_1' => __( 'Option 1', HATCH_THEME_SLUG ),
					'option_2' => __( 'Option 2', HATCH_THEME_SLUG ),
					'option_3' => __( 'Option 3', HATCH_THEME_SLUG ),
					'option_4' => __( 'Option 4', HATCH_THEME_SLUG ),
				),
			); // Multicheck

		$settings['framework']['sections']['control_examples']['controls']['radio'] = array(
				'type'     => 'radio',
				'mode'     => 'radio',
				'label'    => __( 'Radio Control', HATCH_THEME_SLUG ),
				'separator' => true,
				'default'  => 'option_1',
				'priority' => 1,
				'choices'  => array(
					'option_1' => __( 'Option 1', HATCH_THEME_SLUG ),
					'option_2' => __( 'Option 2', HATCH_THEME_SLUG ),
					'option_3' => __( 'Option 3', HATCH_THEME_SLUG ),
					'option_4' => __( 'Option 4', HATCH_THEME_SLUG ),
				'separator' => true,
				),
			); // Regular Radio

		$settings['framework']['sections']['control_examples']['controls']['select'] = array(
				'type'     => 'select',
				'label'    => __( 'Select Control', HATCH_THEME_SLUG ),
				'separator' => true,
				'default'  => 'option_1',
				'priority' => 1,
				'choices'  => array(
					'option_1' => __( 'Option 1', HATCH_THEME_SLUG ),
					'option_2' => __( 'Option 2', HATCH_THEME_SLUG ),
					'option_3' => __( 'Option 3', HATCH_THEME_SLUG ),
					'option_4' => __( 'Option 4', HATCH_THEME_SLUG ),
				'separator' => true,
				)
			); // Select Box

		$settings['framework']['sections']['control_examples']['controls']['slider'] = array(
				'type'     => 'slider',
				'label'    => __( 'Slider', HATCH_THEME_SLUG ),
				'subtitle' => __( 'Mah Mah' , HATCH_THEME_SLUG ),
				'separator' => true,
				'default'  => 36,
				'priority' => 1,
				'choices'  => array(
					'min'  => 1,
					'max'  => 100,
					'step' => 2,
				),
			); // Slider

		$settings['framework']['sections']['control_examples']['controls']['text'] = array(
				'type'     => 'text',
				'label'    => __( 'Text', HATCH_THEME_SLUG ),
				'separator' => true,
				'default'  => __( 'Default text', HATCH_THEME_SLUG ),
				'priority' => 1,
			); // Text

		$settings['framework']['sections']['control_examples']['controls']['textarea'] = array(
				'type'     => 'textarea',
				'label'    => __( 'Text Area', HATCH_THEME_SLUG ),
				'separator' => true,
				'default'  => __( 'Default text', HATCH_THEME_SLUG ),
				'priority' => 1,
			); // Slider

		$settings['framework']['sections']['control_examples']['controls']['upload'] = array(
				'type'     => 'upload',
				'label'    => __( 'Upload Control', HATCH_THEME_SLUG ),
				'separator' => true,
				'default'  => '',
				'priority' => 1,
			); // Upload

		// Branding Panel
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

		/*
		return apply_filters( 'hatch_customizer_settings', $settings );
		*/
		return array();
	}
}