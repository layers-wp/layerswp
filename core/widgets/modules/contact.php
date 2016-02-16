<?php  /**
 * Contact Details &amp; Maps Widget
 *
 * This file is used to register and display the Layers - Portfolios widget.
 *
 * @package Layers
 * @since Layers 1.0.0
 */
if( !class_exists( 'Layers_Contact_Widget' ) ) {
	class Layers_Contact_Widget extends Layers_Widget {

		/**
		*  Widget construction
		*/
	 	function Layers_Contact_Widget(){

			/**
			* Widget variables
			*
		 	* @param  	string    		$widget_title    	Widget title
		 	* @param  	string    		$widget_id    		Widget slug for use as an ID/classname
		 	* @param  	string    		$post_type    		(optional) Post type for use in widget options
		 	* @param  	string    		$taxonomy    		(optional) Taxonomy slug for use as an ID/classname
		 	* @param  	array 			$checkboxes    	(optional) Array of checkbox names to be saved in this widget. Don't forget these please!
		 	*/
			$this->widget_title = __( 'Contact Details &amp; Maps' , 'layerswp' );
			$this->widget_id = 'map';
			$this->post_type = '';
			$this->taxonomy = '';
			$this->checkboxes = array(
					'show_google_map',
					'show_address',
					'show_contact_form'
				);

	 		/* Widget settings. */
			$widget_ops = array(
				'classname'   => 'obox-layers-' . $this->widget_id .'-widget',
				'description' => __( 'This widget is used to display your ', 'layerswp' ) . $this->widget_title . '.',
			);

			/* Widget control settings. */
			$control_ops = array( 'width' => LAYERS_WIDGET_WIDTH_SMALL,
				'height'  => NULL,
				'id_base' => LAYERS_THEME_SLUG . '-widget-' . $this->widget_id
			);

			/* Create the widget. */
			parent::__construct( LAYERS_THEME_SLUG . '-widget-' . $this->widget_id ,
				$this->widget_title,
				$widget_ops,
				$control_ops
			);

			/* Setup Widget Defaults */
			$this->defaults = array (
				'title' => __( 'Find Us', 'layerswp' ),
				'excerpt' => __( 'We are based in one of the most beautiful places on earth. Come visit us!', 'layerswp' ),
				'contact_form' => NULL,
				'address_shown' => NULL,
				'show_google_map' => 'on',
				'show_contact_form' => 'on',
				'google_maps_location' => NULL,
				'google_maps_long_lat' => NULL,
				'google_maps_zoom' => 14,
				'map_height' => 400,
				'design' => array(
					'layout' => 'layout-boxed',
					'background' => array(
						'position' => 'center',
						'repeat' => 'no-repeat'
					),
					'fonts' => array(
						'align' => 'text-center',
						'size' => 'medium',
						'color' => NULL,
						'shadow' => NULL
					)
				)
			);
		}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) {
			global $wp_customize;

			$this->backup_inline_css();

			// Turn $args array into variables.
			extract( $args );

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			$widget = wp_parse_args( $instance , $instance_defaults );

			// Check if we have a map present
			if( isset( $widget['show_google_map'] ) && ( '' != $widget['google_maps_location'] || '' != $widget['google_maps_long_lat'] ) ) {
				$hasmap = true;
			}
			// Set the background styling
			if( !empty( $widget['design'][ 'background' ] ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id, 'background', array( 'background' => $widget['design'][ 'background' ] ) );
			if( !empty( $widget['design']['fonts'][ 'color' ] ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id, 'color', array( 'selectors' => array( '.section-title h3.heading' , '.section-title div.excerpt' , '.section-title small', '.form.content' , 'form p' , 'form label' ) , 'color' => $widget['design']['fonts'][ 'color' ] ) );

			// Apply the advanced widget styling
			$this->apply_widget_advanced_styling( $widget_id, $widget );

			// Set the map & form widths
			if( isset( $hasmap ) ) {
				$form_class = 'span-6';
			} else {
				$form_class = 'span-12';
			}
			$mapwidth = 'span-12';

			// Set Display Variables
			$show_address_or_contactform = ( ( '' != $widget['address_shown'] && isset( $widget['show_address'] ) ) || ( $this->check_and_return( $widget, 'contact_form' ) && $this->check_and_return( $widget, 'show_contact_form' ) ) ) ? TRUE : FALSE ;
			$show_title_or_excerpt = ( '' != $widget['title'] || '' != $widget['excerpt'] ) ? TRUE : FALSE ;

			/**
			* Generate the widget container class
			*/
			$widget_container_class = array();
			$widget_container_class[] = 'widget';
			$widget_container_class[] = 'layers-contact-widget';
			$widget_container_class[] = 'row';
			$widget_container_class[] = 'content-vertical-massive';
			$widget_container_class[] = 'layers-contact-widget';
			$widget_container_class[] = $this->check_and_return( $widget , 'design', 'advanced', 'customclass' ); // Apply custom class from design-bar's advanced control.
			$widget_container_class[] = $this->get_widget_spacing_class( $widget );
			if( !$show_title_or_excerpt && !$show_address_or_contactform  ) $widget_container_class[] = 'no-inset-top no-inset-bottom';
			$widget_container_class = implode( ' ', apply_filters( 'layers_contact_widget_container_class' , $widget_container_class ) ); ?>
			<?php echo $this->custom_anchor( $widget ); ?>
			<section id="<?php echo esc_attr( $widget_id ); ?>" class="<?php echo esc_attr( $widget_container_class ); ?>">

				<?php do_action( 'layers_before_contact_widget_inner', $this, $widget ); ?>

				<?php if( $show_title_or_excerpt ) { ?>
					<div class="container clearfix">
						<?php /**f
						* Generate the Section Title Classes
						*/
						$section_title_class = array();
						$section_title_class[] = 'section-title clearfix';
						$section_title_class[] = $this->check_and_return( $widget , 'design', 'fonts', 'size' );
						$section_title_class[] = $this->check_and_return( $widget , 'design', 'fonts', 'align' );
						$section_title_class[] = ( $this->check_and_return( $widget, 'design', 'background' , 'color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $widget, 'design', 'background' , 'color' ) ) ? 'invert' : '' );
						$section_title_class = implode( ' ', $section_title_class ); ?>
						<div class="<?php echo $section_title_class; ?>">
							<?php if( '' != $widget['title'] ) { ?>
								<h3 class="heading"><?php echo $widget['title']; ?></h3>
							<?php } ?>
							<?php if( '' != $widget['excerpt'] ) { ?>
								<div class="excerpt"><?php echo $widget['excerpt']; ?></div>
							<?php } ?>
						</div>
					</div>
				<?php } // if title || excerpt ?>

				<?php /**
				* Generate the Widget Body Class
				*/
				$widget_body_class = array();
				$widget_body_class[] = 'row';
				$widget_body_class[] = $this->get_widget_layout_class( $widget );
				$widget_body_class[] = ( $this->check_and_return( $widget, 'design', 'background' , 'color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $widget, 'design', 'background' , 'color' ) ) ? 'invert' : '' );
				$widget_body_class = implode( ' ', $widget_body_class ); ?>
				<div class="<?php echo $widget_body_class; ?>">
					<?php if( $show_address_or_contactform ) {?>
						<div class="column <?php echo $form_class; ?> form content">
							<?php if( $this->check_and_return( $widget, 'show_address' ) ) { ?>
								<address class="copy">
									<p><?php echo $widget['address_shown']; ?></p>
								</address>
							<?php } ?>
							<?php if( $this->check_and_return( $widget, 'contact_form' ) ) { ?>
								<?php echo do_shortcode( $widget['contact_form'] ); ?>
							<?php } ?>
						</div>
						<?php $mapwidth = 'span-6'; ?>
					<?php } // if show_contact_form || address_shown ?>

					<?php if( isset( $hasmap ) ) { ?>
						<div class="column no-push-bottom <?php echo esc_attr( $mapwidth ); ?>">
							<?php if ( isset( $wp_customize ) ) { ?>
								<?php if( $this->check_and_return( $widget, 'google_maps_location' ) ) {
									$map_center = $widget['google_maps_location'];
								} else if( $this->check_and_return( $widget, 'google_maps_long_lat' ) ) {
									$map_center =  $widget['google_maps_long_lat'];
								} ?>
								<div class="layers-map" style="height: <?php echo esc_attr( $widget['map_height'] ); ?>px; overflow: hidden;">
									<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo esc_attr( $map_center ); ?>&zoom=<?php echo ( isset( $widget['google_maps_zoom'] ) ? $widget['google_maps_zoom'] : 14 ) ; ?>&size=1960x<?php echo $widget['map_height']; ?>&scale=2&markers=color:red|<?php echo esc_attr( $map_center ); ?>" class="google-map-img" />
								</div>
							<?php } else { ?>
								<div class="layers-map" style="height: <?php echo esc_attr( $widget['map_height'] ); ?>px;" data-zoom-level="<?php echo ( isset( $widget['google_maps_zoom'] ) ? $widget['google_maps_zoom'] : 14 ); ?>" <?php if( '' != $widget['google_maps_location'] ) { ?>data-location="<?php echo $widget['google_maps_location']; ?>"<?php } ?> <?php if( '' != $widget['google_maps_long_lat'] ) { ?>data-longlat="<?php echo $widget['google_maps_long_lat']; ?>"<?php } ?>></div>
							<?php } ?>
						</div>
					<?php } ?>
				</div>

				<?php do_action( 'layers_after_contact_widget_inner', $this, $widget );

				// Print the Inline Styles for this Widget
				$this->print_inline_css(); ?>

			</section>

			<?php if ( !isset( $wp_customize ) ) {
				wp_enqueue_script( LAYERS_THEME_SLUG . " -map-api","//maps.googleapis.com/maps/api/js?sensor=false");
				wp_enqueue_script( LAYERS_THEME_SLUG . "-map-trigger", get_template_directory_uri()."/core/widgets/js/maps.js", array( "jquery" ), LAYERS_VERSION );
			}  // Enqueue the map js
		}

		/**
		*  Widget update
		*/
		function update($new_instance, $old_instance) {
			if ( isset( $this->checkboxes ) ) {
				foreach( $this->checkboxes as $cb ) {
					if( isset( $old_instance[ $cb ] ) ) {
						$old_instance[ $cb ] = strip_tags( $new_instance[ $cb ] );
					}
				} // foreach checkboxes
			} // if checkboxes
			return $new_instance;
		}

		/**
		*  Widget form
		*
		* We use regulage HTML here, it makes reading the widget much easier than if we used just php to echo all the HTML out.
		*
		*/
		function form( $instance ){

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			// Parse $instance
			$widget = wp_parse_args( $instance, $instance_defaults );

			$this->design_bar(
				'side', // CSS Class Name
				array( // Widget Object
					'name' => $this->get_layers_field_name( 'design' ),
					'id' => $this->get_layers_field_id( 'design' ),
					'widget_id' => $this->widget_id,
				),
				$widget, // Widget Values
				apply_filters( 'layers_map_widget_design_bar_components' , array( // Components
					'layout',
					'fonts',
					'display' => array(
						'icon-css' => 'icon-display',
						'label' => __( 'Display', 'layerswp' ),
						'elements' => array(
							'show_google_map' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_google_map' ) ,
								'id' => $this->get_layers_field_id( 'show_google_map' ) ,
								'value' => ( isset( $widget['show_google_map'] ) ) ? $widget['show_google_map'] : NULL,
								'label' => __( 'Show Google Map' , 'layerswp' ),
							),
							'map_height' => array(
								'type' => 'number',
								'name' => $this->get_layers_field_name( 'map_height' ) ,
								'id' => $this->get_layers_field_id( 'map_height' ) ,
								'min' => 150,
								'max' => 1600,
								'value' => ( isset( $widget['map_height'] ) ) ? $widget['map_height'] : NULL,
								'label' => __( 'Map Height' , 'layerswp' ),
								'data' => array(
									'show-if-selector' => '#' . $this->get_layers_field_id( 'show_google_map' ),
									'show-if-value' => 'true',
								),
							),
							'google_maps_zoom' => array(
								'type' => 'select',
								'name' => $this->get_layers_field_name( 'google_maps_zoom' ) ,
								'id' => $this->get_layers_field_id( 'google_maps_zoom' ) ,
								'value' => ( isset( $widget['google_maps_zoom'] ) ) ? $widget['google_maps_zoom'] : NULL,
								'label' => __( 'Google Map Zoom Level' , 'layerswp' ),
								'options' => array(
									'16' => __( 'Close', 'layerswp' ),
									'14' => __( 'Default', 'layerswp' ),
									'12' => __( 'Far', 'layerswp' ),
								),
								'data' => array(
									'show-if-selector' => '#' . $this->get_layers_field_id( 'show_google_map' ),
									'show-if-value' => 'true',
								),
							),
							'show_address' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_address' ) ,
								'id' => $this->get_layers_field_id( 'show_address' ) ,
								'value' => ( isset( $widget['show_address'] ) ) ? $widget['show_address'] : NULL,
								'label' => __( 'Show Address' , 'layerswp' ),
							),
							'show_contact_form' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_contact_form' ) ,
								'id' => $this->get_layers_field_id( 'show_contact_form' ) ,
								'value' => ( isset( $widget['show_contact_form'] ) ) ? $widget['show_contact_form'] : NULL,
								'label' => __( 'Show Contact Form' , 'layerswp' ),
							),
						),
					),
					'background',
					'advanced'
				) )
			); ?>

			<div class="layers-container-large">

				<?php $this->form_elements()->header( array(
					'title' => __( 'Contact' , 'layerswp' ),
					'icon_class' =>'location'
				) ); ?>

				<section class="layers-accordion-section layers-content">
					<div class="layers-row layers-push-bottom clearfix">
						<p class="layers-form-item">
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'text',
									'name' => $this->get_layers_field_name( 'title' ) ,
									'id' => $this->get_layers_field_id( 'title' ) ,
									'placeholder' => __( 'Enter title here' , 'layerswp' ),
									'value' => ( isset( $widget['title'] ) ) ? $widget['title'] : NULL ,
									'class' => 'layers-text layers-large'
								)
							); ?>
						</p>
						<p class="layers-form-item">
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'rte',
									'name' => $this->get_layers_field_name( 'excerpt' ) ,
									'id' => $this->get_layers_field_id( 'excerpt' ) ,
									'placeholder' =>  __( 'Short Excerpt' , 'layerswp' ),
									'value' => ( isset( $widget['excerpt'] ) ) ? $widget['excerpt'] : NULL ,
									'class' => 'layers-textarea layers-large'
								)
							); ?>
						</p>
					</div>

					<div class="layers-row clearfix">
						<div class="layers-panel">
							<?php $this->form_elements()->section_panel_title(
								array(
									'type' => 'panel',
									'title' => __( 'Address' , 'layerswp' ),
									'tooltip' => __(  'Place your help text here please.' , 'layerswp' )
								)
							); ?>
							<div class="layers-content">
								<p class="layers-form-item">
									<label for="<?php echo $this->get_layers_field_id( 'google_maps_location' ); ?>"><?php _e( 'Google Maps Location' , 'layerswp' ); ?></label>
									<?php echo $this->form_elements()->input(
										array(
											'type' => 'text',
											'name' => $this->get_layers_field_name( 'google_maps_location' ) ,
											'id' => $this->get_layers_field_id( 'google_maps_location' ) ,
											'placeholder' => __( 'e.g. 300 Prestwich Str, Cape Town, South Africa' , 'layerswp' ),
											'value' => ( isset( $widget['google_maps_location'] ) ) ? $widget['google_maps_location'] : NULL
										)
									); ?>
								</p>
								<p class="layers-form-item">
									<label for="<?php echo $this->get_layers_field_id( 'google_maps_long_lat' ); ?>"><?php _e( 'Google Maps Latitude & Longitude (Optional)' , 'layerswp' ); ?></label>
									<?php echo $this->form_elements()->input(
										array(
											'type' => 'text',
											'name' => $this->get_layers_field_name( 'google_maps_long_lat' ) ,
											'id' => $this->get_layers_field_id( 'google_maps_long_lat' ) ,
											'placeholder' => __( 'e.g. -34.038181, 18.363826' , 'layerswp' ),
											'value' => ( isset( $widget['google_maps_long_lat'] ) ) ? $widget['google_maps_long_lat'] : NULL
										)
									); ?>
								</p>
								<p class="layers-form-item">
									<label for="<?php echo $this->get_layers_field_id( 'address_shown' ); ?>"><?php _e( 'Address Shown' , 'layerswp' ); ?></label>
									<?php echo $this->form_elements()->input(
										array(
											'type' => 'rte',
											'name' => $this->get_layers_field_name( 'address_shown' ) ,
											'id' => $this->get_layers_field_id( 'address_shown' ) ,
											'placeholder' => __( 'e.g. Prestwich Str, Cape Town' , 'layerswp' ),
											'value' => ( isset( $widget['address_shown'] ) ) ? $widget['address_shown'] : NULL,
											'class' => 'layers-textarea'
										)
									); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="layers-row clearfix">
						<div class="layers-panel">
							<?php $this->form_elements()->section_panel_title(
								array(
									'type' => 'panel',
									'title' => __( 'Contact Form' , 'layerswp' ),
									'tooltip' => __(  'Place your help text here please.' , 'layerswp' )
								)
							); ?>
							<div class="layers-content">
								<p class="layers-form-item">
									<?php echo $this->form_elements()->input(
										array(
											'type' => 'textarea',
											'name' => $this->get_layers_field_name( 'contact_form' ) ,
											'id' => $this->get_layers_field_id( 'contact_form' ) ,
											'placeholder' =>  __( 'Contact form embed code' , 'layerswp' ),
											'value' => ( isset( $widget['contact_form'] ) ) ? $widget['contact_form'] : NULL ,
											'class' => 'layers-textarea'
										)
									); ?>
									<small class="layers-small-note">
										<?php _e( sprintf( 'Need to create a contact form? Try <a href="%1$s" target="ejejcsingle">Gravity Forms</a>', 'https://www.e-junkie.com/ecom/gb.php?cl=54585&c=ib&aff=221037' ) , 'layerswp' ); ?>
									</small>
								</p>
							</div>
						</div>
				</section>
			</div>

		<?php } // Form
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Layers_Contact_Widget");
}