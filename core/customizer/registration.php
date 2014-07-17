<?php /**
 * Customizer Registration File
 *
 * This file is used to register panels, sections and controls
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Customizer_Regsitrar {

	function panels_and_sections( $panels_sections = array() ){

		global $wp_customize;

		$panel_priority = 150;
		$section_priority = 150;
		$control_priority = 150;

		// Loop through each Panel/Section
		foreach( $panels_sections as $panel_or_section ){

			/**
			* Register Panel
			*
			* Check http://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_panel
		 	*/
		 	$panel_priority = ( $panel_priority+10 );
			$wp_customize->$panel_or_section['function'](
					HATCH_THEME_SLUG . '-' . $panel_or_section['key'] ,
					array(
						'title'    => __( 'Hatch: ' , HATCH_THEME_SLUG ) . $panel_or_section['title'],
						'description' => $panel_or_section['description'],
						'priority' => $panel_priority
					)
				);

			// If we are adding a panel and there are sections to run through, let's register them
			if( 'add_panel' == $panel_or_section['function'] && isset( $panel_or_section[ 'sections'] ) ) {
				$section_priority = ( $section_priority+10 );

				foreach ( $panel_or_section[ 'sections'] as $section_key => $section_details ){

					/**
					* Register Section
					*
					* Check http://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section
				 	*/
					$wp_customize->add_section(
						HATCH_THEME_SLUG . '-' . $panel_or_section['key'] . '-' . $section_key ,
						array(
							'panel' => HATCH_THEME_SLUG . '-' . $panel_or_section['key'],
							'title'    => $section_details['section_title'],
							'priority' => $section_priority
						)
					);

					if( isset( $section_details[ 'controls'] ) ) {

						foreach( $section_details[ 'controls'] as $control_key => $control_details ) {
							$control_priority+10;
							$control_details[ 'priority' ] = $control_priority;
							$control_details[ 'section' ] = HATCH_THEME_SLUG . '-' . $panel_or_section['key'] . '-' . $section_key;
							$control_details[ 'setting' ] = HATCH_THEME_SLUG . '-' . $panel_or_section['key'] . '-' . $section_key . '-' . $control_key;
							$this->register_control( $control_details );
						} // foreach $section_details[ 'controls']

					} // if isset( $section_details[ 'controls'] )

				} // foreach $panel_or_section[ 'sections' ]
			} else {

				if( isset( $panel_or_section[ 'controls'] ) ) {

					foreach( $panel_or_section[ 'controls'] as $control_key => $control_details ) {
						$control_priority = ( $control_priority+10 );
						$control_details[ 'priority' ] = $control_priority;
						$control_details[ 'section' ] = HATCH_THEME_SLUG . '-' . $panel_or_section['key'];
						$control_details[ 'setting' ] = HATCH_THEME_SLUG . '-' . $panel_or_section['key'] . '-' . $control_key;
						$this->register_control( $control_details );
					} // foreach $section_details[ 'controls']

				} // if isset( $section_details[ 'controls'] )

			} // if 'add_panel' == $panel_or_section['function']

		}
	}

	function register_control( $control ) {

		global $wp_customize;

		if ( isset( $control ) ) {

			if( !isset( $control['priority'] ) ) $control['priority'] = 1;
			if( !isset( $control['default'] ) ) $control['default'] = NULL;

			if ( 'background' == $control['type'] ) {

				$wp_customize->add_setting( $control['setting'] . '_color', array(
					'default'    => $control['default']['color'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_image', array(
					'default'    => $control['default']['image'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_repeat', array(
					'default'    => $control['default']['repeat'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_size', array(
					'default'    => $control['default']['size'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_attach', array(
					'default'    => $control['default']['attach'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_position', array(
					'default'    => $control['default']['position'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

				if ( false != $control['default']['opacity'] ) {

					$wp_customize->add_setting( $control['setting'] . '_opacity', array(
						'default'    => $control['default']['opacity'],
						'type'       => 'theme_mod',
						'capability' => 'edit_theme_options'
					) );

				}
			} else {

				// Add settings
				$wp_customize->add_setting( $control['setting'], array(
					'default'    => $control['default'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options'
				) );

			}

			// Checkbox controls
			if ( 'checkbox' == $control['type'] ) {

				$wp_customize->add_control( new Hatch_Customize_Checkbox_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

			// Background Controls
			} elseif ( 'background' == $control['type'] ) {

				$wp_customize->add_control( new Hatch_Customize_Color_Control( $wp_customize, $control['setting'] . '_color', array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'] . '_color',
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => __( 'Background Color', HATCH_THEME_SLUG ),
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

				$wp_customize->add_control( new Hatch_Customize_Image_Control( $wp_customize, $control['setting'] . '_image', array(
						'label'       => null,
						'section'     => $control['section'],
						'settings'    => $control['setting'] . '_image',
						'priority'    => $control['priority'] + 1,
						'description' => null,
						'subtitle'    => __( 'Background Image', HATCH_THEME_SLUG ),
						'separator'   => false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

				$wp_customize->add_control( new Hatch_Select_Control( $wp_customize, $control['setting'] . '_repeat', array(
						'label'       => null,
						'section'     => $control['section'],
						'settings'    => $control['setting'] . '_repeat',
						'priority'    => $control['priority'] + 2,
						'choices'     => array(
							'no-repeat' => __( 'No Repeat', HATCH_THEME_SLUG ),
							'repeat'    => __( 'Repeat All', HATCH_THEME_SLUG ),
							'repeat-x'  => __( 'Repeat Horizontally', HATCH_THEME_SLUG ),
							'repeat-y'  => __( 'Repeat Vertically', HATCH_THEME_SLUG ),
							'inherit'   => __( 'Inherit', HATCH_THEME_SLUG )
						),
						'description' => null,
						'subtitle'    => __( 'Background Repeat', HATCH_THEME_SLUG ),
						'separator'   => false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

				$wp_customize->add_control( new Hatch_Customize_Radio_Control( $wp_customize, $control['setting'] . '_size', array(
						'label'       => null,
						'section'     => $control['section'],
						'settings'    => $control['setting'] . '_size',
						'priority'    => $control['priority'] + 3,
						'choices'     => array(
							'inherit' => __( 'Inherit', HATCH_THEME_SLUG ),
							'cover'   => __( 'Cover', HATCH_THEME_SLUG ),
							'contain' => __( 'Contain', HATCH_THEME_SLUG ),
						),
						'description' => null,
						'mode'        => 'buttonset',
						'subtitle'    => __( 'Background Size', HATCH_THEME_SLUG ),
						'separator'   => false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

				$wp_customize->add_control( new Hatch_Customize_Radio_Control( $wp_customize, $control['setting'] . '_attach', array(
						'label'       => null,
						'section'     => $control['section'],
						'settings'    => $control['setting'] . '_attach',
						'priority'    => $control['priority'] + 4,
						'choices'     => array(
							'inherit' => __( 'Inherit', HATCH_THEME_SLUG ),
							'fixed'   => __( 'Fixed', HATCH_THEME_SLUG ),
							'scroll'  => __( 'Scroll', HATCH_THEME_SLUG ),
						),
						'description' => null,
						'mode'        => 'buttonset',
						'subtitle'    => __( 'Background Attachment', HATCH_THEME_SLUG ),
						'separator'   => false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

				$wp_customize->add_control( new Hatch_Select_Control( $wp_customize, $control['setting'] . '_position', array(
						'label'       => null,
						'section'     => $control['section'],
						'settings'    => $control['setting'] . '_position',
						'priority'    => $control['priority'] + 5,
						'choices'     => array(
							'left-top'      => __( 'Left Top', HATCH_THEME_SLUG ),
							'left-center'   => __( 'Left Center', HATCH_THEME_SLUG ),
							'left-bottom'   => __( 'Left Bottom', HATCH_THEME_SLUG ),
							'right-top'     => __( 'Right Top', HATCH_THEME_SLUG ),
							'right-center'  => __( 'Right Center', HATCH_THEME_SLUG ),
							'right-bottom'  => __( 'Right Bottom', HATCH_THEME_SLUG ),
							'center-top'    => __( 'Center Top', HATCH_THEME_SLUG ),
							'center-center' => __( 'Center Center', HATCH_THEME_SLUG ),
							'center-bottom' => __( 'Center Bottom', HATCH_THEME_SLUG ),
						),
						'description' => null,
						'subtitle'    => __( 'Background Position', HATCH_THEME_SLUG ),
						'separator'   => ( false != $control['default']['opacity'] ) ? false : true,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

				if ( false != $control['default']['opacity'] ) {
					$wp_customize->add_control( new Hatch_Customize_Sliderui_Control( $wp_customize, $control['setting'] . '_opacity', array(
							'label'       => null,
							'section'     => $control['section'],
							'settings'    => $control['setting'] . '_opacity',
							'priority'    => $control['priority'] + 6,
							'choices'  => array(
								'min'  => 0,
								'max'  => 100,
								'step' => 1,
							),
							'description' => null,
							'subtitle'    => __( 'Background Opacity', HATCH_THEME_SLUG ),
							'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
							'required'    => isset( $control['required'] ) ? $control['required'] : array(),
							// 'transport'   => 'postMessage',
						) )
					);
				}

			// Color Controls
			} elseif ( 'color' == $control['type'] ) {

				$wp_customize->add_control( new Hatch_Customize_Color_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => isset( $control['priority'] ) ? $control['priority'] : '',
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

			// Image Controls
			} elseif ( 'image' == $control['type'] ) {

				$wp_customize->add_control( new Hatch_Customize_Image_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

			// Radio Controls
			} elseif ( 'radio' == $control['type'] ) {

				$wp_customize->add_control( new Hatch_Customize_Radio_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'mode'        => isset( $control['mode'] ) ? $control['mode'] : 'radio', // Can be 'radio', 'image' or 'buttonset'.
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

			// Select Controls
			} elseif ( 'select' == $control['type'] ) {

				$wp_customize->add_control( new Hatch_Select_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

			// Slider Controls
			} elseif ( 'slider' == $control['type'] ) {

				$wp_customize->add_control( new Hatch_Customize_Sliderui_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

			// Text Controls
			} elseif ( 'text' == $control['type'] ) {

				$wp_customize->add_control( new Hatch_Customize_Text_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

			// Text Controls
			} elseif ( 'textarea' == $control['type'] ) {

				$wp_customize->add_control( new Hatch_Customize_Textarea_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

			// Upload Controls
			} elseif ( 'upload' == $control['type'] ) {

				$wp_customize->add_control( new Hatch_Customize_Upload_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);

			// Number Controls
			} elseif ( 'number' == $control['type'] ) {

				$wp_customize->add_control( new Hatch_Customize_Number_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						// 'transport'   => 'postMessage',
					) )
				);

			// Multicheck Controls
			} elseif ( 'multicheck' == $control['type'] ) {

				$wp_customize->add_control( new Hatch_Customize_Multicheck_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						// 'transport'   => 'postMessage',
					) )
				);
			}
		}
	}
}
function hatch_customizer_register(){

	$hatch_config = new Hatch_Customizer_Config();
	$hatch_controls = new Hatch_Customizer_Regsitrar();

	$hatch_controls->panels_and_sections(
		$hatch_config->settings()
	);
}
add_action( 'customize_register', 'hatch_customizer_register', 99 );