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
	 	function __construct() {

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
				'classname' => 'obox-layers-' . $this->widget_id .'-widget',
				'description' => __( 'This widget is used to display your ', 'layerswp' ) . $this->widget_title . '.',
				'customize_selective_refresh' => TRUE,
			);

			/* Widget control settings. */
			$control_ops = array(
				'width' => LAYERS_WIDGET_WIDTH_SMALL,
				'height' => NULL,
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
				'show_address' => 'on',
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
						'shadow' => NULL,
						'heading-type' => 'h3',
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

			// Use defaults if $instance is empty.
			if( empty( $instance ) && ! empty( $this->defaults ) ) {
				$instance = wp_parse_args( $instance, $this->defaults );
			}

			// Mix in new/unset defaults on every instance load (NEW)
			$instance = $this->apply_defaults( $instance );

			// Check if we have a map present
			if( isset( $instance['show_google_map'] ) && ( '' != $instance['google_maps_location'] || '' != $instance['google_maps_long_lat'] ) ) {
				$hasmap = true;
			}

			// Set the background styling
			if( !empty( $instance['design'][ 'background' ] ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id, 'background', array( 'background' => $instance['design'][ 'background' ] ) );
			if( !empty( $instance['design']['fonts'][ 'color' ] ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id, 'color', array( 'selectors' => array( '.section-title .heading' , '.section-title div.excerpt' , '.section-title small', '.form.content' , 'form p' , 'form label' ) , 'color' => $instance['design']['fonts'][ 'color' ] ) );

			// Set the map & form widths
			if( isset( $hasmap ) ) {
				$form_class = 'span-6';
			} else {
				$form_class = 'span-12';
			}
			$mapwidth = 'span-12';

			// Set Display Variables
			$show_address_or_contactform = ( ( '' != $instance['address_shown'] && isset( $instance['show_address'] ) ) || ( $this->check_and_return( $instance, 'contact_form' ) && $this->check_and_return( $instance, 'show_contact_form' ) ) ) ? TRUE : FALSE ;
			$show_title_or_excerpt = ( '' != $instance['title'] || '' != $instance['excerpt'] ) ? TRUE : FALSE ;

			// Apply the advanced widget styling
			$this->apply_widget_advanced_styling( $widget_id, $instance );

			/**
			* Generate the widget container class
			*/
			$widget_container_class = array();
			$widget_container_class[] = 'widget';
			$widget_container_class[] = 'layers-contact-widget';
			$widget_container_class[] = 'clearfix';
			$widget_container_class[] = 'content-vertical-massive';
			$widget_container_class[] = 'layers-contact-widget';
			$widget_container_class[] = ( 'on' == $this->check_and_return( $instance , 'design', 'background', 'darken' ) ? 'darken' : '' );
			$widget_container_class[] = $this->check_and_return( $instance , 'design', 'advanced', 'customclass' ); // Apply custom class from design-bar's advanced control.
			$widget_container_class[] = $this->get_widget_spacing_class( $instance );

			if( !$show_title_or_excerpt && !$show_address_or_contactform  ) $widget_container_class[] = 'no-inset-top no-inset-bottom';

			$widget_container_class = apply_filters( 'layers_contact_widget_container_class' , $widget_container_class, $this, $instance );
			$widget_container_class = implode( ' ', $widget_container_class );

			// Custom Anchor
			echo $this->custom_anchor( $instance ); ?>

			<div id="<?php echo esc_attr( $widget_id ); ?>" class="<?php echo esc_attr( $widget_container_class ); ?>" <?php $this->selective_refresh_atts( $args ); ?>>

				<?php do_action( 'layers_before_contact_widget_inner', $this, $instance ); ?>

				<?php if( $show_title_or_excerpt ) { ?>
					<div class="container clearfix">
						<?php /**f
						* Generate the Section Title Classes
						*/
						$section_title_class = array();
						$section_title_class[] = 'section-title clearfix';
						$section_title_class[] = $this->check_and_return( $instance , 'design', 'fonts', 'size' );
						$section_title_class[] = $this->check_and_return( $instance , 'design', 'fonts', 'align' );
						$section_title_class[] = ( $this->check_and_return( $instance, 'design', 'background' , 'color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $instance, 'design', 'background' , 'color' ) ) ? 'invert' : '' );
						$section_title_class = implode( ' ', $section_title_class ); ?>
						<div class="<?php echo $section_title_class; ?>">
							<?php if( '' != $this->check_and_return( $instance, 'title' ) ) { ?>
								<<?php echo $this->check_and_return( $instance, 'design', 'fonts', 'heading-type' ); ?> class="heading">
									<?php echo $instance['title']; ?>
								</<?php echo $this->check_and_return( $instance, 'design', 'fonts', 'heading-type' ); ?>>
							<?php } ?>
							<?php if( '' != $this->check_and_return( $instance, 'excerpt' ) ) { ?>
								<div class="excerpt"><?php echo layers_the_content( $instance['excerpt'] ); ?></div>
							<?php } ?>
						</div>
					</div>
				<?php } // if title || excerpt ?>

				<?php /**
				* Generate the Widget Body Class
				*/
				$widget_body_class = array();
				$widget_body_class[] = 'row';
				$widget_body_class[] = $this->get_widget_layout_class( $instance );
				$widget_body_class[] = ( $this->check_and_return( $instance, 'design', 'background' , 'color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $instance, 'design', 'background' , 'color' ) ) ? 'invert' : '' );
				$widget_body_class = implode( ' ', $widget_body_class ); ?>
				<div class="<?php echo $widget_body_class; ?>">
					<?php if( $show_address_or_contactform ) {?>
						<div class="column <?php echo $form_class; ?> form content">
							<?php if( $this->check_and_return( $instance, 'show_address' ) ) { ?>
								<address class="copy">
									<p><?php echo $instance['address_shown']; ?></p>
								</address>
							<?php } ?>
							<?php if( $this->check_and_return( $instance, 'contact_form' ) ) { ?>
								<?php echo do_shortcode( $instance['contact_form'] ); ?>
							<?php } ?>
						</div>
						<?php $mapwidth = 'span-6'; ?>
					<?php } // if show_contact_form || address_shown ?>

					<?php if( isset( $hasmap ) ) { ?>
						<div class="column no-push-bottom <?php echo esc_attr( $mapwidth ); ?>">
							<?php if ( isset( $wp_customize ) ) { ?>
								<?php if( $this->check_and_return( $instance, 'google_maps_location' ) ) {
									$map_center = $instance['google_maps_location'];
								} else if( $this->check_and_return( $instance, 'google_maps_long_lat' ) ) {
									$map_center =  $instance['google_maps_long_lat'];
								} ?>
								<div class="layers-map" style="height: <?php echo esc_attr( $instance['map_height'] ); ?>px; overflow: hidden;">
									<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo esc_attr( $map_center ); ?>&zoom=<?php echo ( isset( $instance['google_maps_zoom'] ) ? $instance['google_maps_zoom'] : 14 ) ; ?>&size=1960x<?php echo ( isset( $instance['map_height'] ) && '' != $instance['map_height'] ) ? $instance['map_height'] : 400; ?>&scale=2&markers=color:red|<?php echo esc_attr( $map_center ); ?>" class="google-map-img" />
								</div>
							<?php } else { ?>
								<div class="layers-map" style="height: <?php echo esc_attr( $instance['map_height'] ); ?>px;" data-zoom-level="<?php echo ( isset( $instance['google_maps_zoom'] ) ? $instance['google_maps_zoom'] : 14 ); ?>" <?php if( '' != $instance['google_maps_location'] ) { ?>data-location="<?php echo $instance['google_maps_location']; ?>"<?php } ?> <?php if( '' != $instance['google_maps_long_lat'] ) { ?>data-longlat="<?php echo $instance['google_maps_long_lat']; ?>"<?php } ?>></div>
							<?php } ?>
						</div>
					<?php } ?>
				</div>

				<?php do_action( 'layers_after_contact_widget_inner', $this, $instance );

				// Print the Inline Styles for this Widget
				$this->print_inline_css(); ?>

			</div>

			<?php if ( !isset( $wp_customize ) ) {
				wp_enqueue_script( LAYERS_THEME_SLUG . "-map-api" );
				wp_enqueue_script( LAYERS_THEME_SLUG . "-map-trigger" );
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

			// Use defaults if $instance is empty.
			if( empty( $instance ) && ! empty( $this->defaults ) ) {
				$instance = wp_parse_args( $instance, $this->defaults );
			}

			// Mix in new/unset defaults on every instance load (NEW)
			$instance = $this->apply_defaults( $instance );

			$this->design_bar(
				'side', // CSS Class Name
				array( // Widget Object
					'name' => $this->get_layers_field_name( 'design' ),
					'id' => $this->get_layers_field_id( 'design' ),
					'widget_id' => $this->widget_id,
				),
				$instance, // Widget Values
				apply_filters( 'layers_map_widget_design_bar_components' , array( // Components
					'layout',
					'display' => array(
						'icon-css' => 'icon-display',
						'label' => __( 'Display', 'layerswp' ),
						'elements' => array(
							'show_google_map' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_google_map' ) ,
								'id' => $this->get_layers_field_id( 'show_google_map' ) ,
								'value' => ( isset( $instance['show_google_map'] ) ) ? $instance['show_google_map'] : NULL,
								'label' => __( 'Show Google Map' , 'layerswp' ),
							),
							'map_height' => array(
								'type' => 'number',
								'name' => $this->get_layers_field_name( 'map_height' ) ,
								'id' => $this->get_layers_field_id( 'map_height' ) ,
								'min' => 150,
								'max' => 1600,
								'value' => ( isset( $instance['map_height'] ) ) ? $instance['map_height'] : NULL,
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
								'value' => ( isset( $instance['google_maps_zoom'] ) ) ? $instance['google_maps_zoom'] : NULL,
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
								'value' => ( isset( $instance['show_address'] ) ) ? $instance['show_address'] : NULL,
								'label' => __( 'Show Address' , 'layerswp' ),
							),
							'show_contact_form' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_contact_form' ) ,
								'id' => $this->get_layers_field_id( 'show_contact_form' ) ,
								'value' => ( isset( $instance['show_contact_form'] ) ) ? $instance['show_contact_form'] : NULL,
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
						<div class="layers-form-item">

							<?php echo $this->form_elements()->input(
								array(
									'type' => 'text',
									'name' => $this->get_layers_field_name( 'title' ) ,
									'id' => $this->get_layers_field_id( 'title' ) ,
									'placeholder' => __( 'Enter title here' , 'layerswp' ),
									'value' => ( isset( $instance['title'] ) ) ? $instance['title'] : NULL ,
									'class' => 'layers-text layers-large'
								)
							); ?>

							<?php $this->design_bar(
								'top', // CSS Class Name
								array( // Widget Object
									'name' => $this->get_layers_field_name( 'design' ),
									'id' => $this->get_layers_field_id( 'design' ),
									'widget_id' => $this->widget_id,
									'show_trash' => FALSE,
									'inline' => TRUE,
									'align' => 'right',
								),
								$instance, // Widget Values
								apply_filters( 'layers_map_widget_inline_design_bar_components', array( // Components
									'fonts',
								), $this, $instance )
							); ?>

						</div>
						<div class="layers-form-item">

							<?php echo $this->form_elements()->input(
								array(
									'type' => 'rte',
									'name' => $this->get_layers_field_name( 'excerpt' ) ,
									'id' => $this->get_layers_field_id( 'excerpt' ) ,
									'placeholder' =>  __( 'Short Excerpt' , 'layerswp' ),
									'value' => ( isset( $instance['excerpt'] ) ) ? $instance['excerpt'] : NULL ,
									'class' => 'layers-textarea layers-large'
								)
							); ?>

						</div>
					</div>
					<div class="layers-row layers-push-bottom clearfix">

						<p class="layers-form-item">
							<label for="<?php echo $this->get_layers_field_id( 'google_maps_location' ); ?>"><?php _e( 'Google Maps Location' , 'layerswp' ); ?></label>
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'text',
									'name' => $this->get_layers_field_name( 'google_maps_location' ) ,
									'id' => $this->get_layers_field_id( 'google_maps_location' ) ,
									'placeholder' => __( 'e.g. 300 Prestwich Str, Cape Town, South Africa' , 'layerswp' ),
									'value' => ( isset( $instance['google_maps_location'] ) ) ? $instance['google_maps_location'] : NULL
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
									'value' => ( isset( $instance['google_maps_long_lat'] ) ) ? $instance['google_maps_long_lat'] : NULL
								)
							); ?>
						</p>

						<small class="layers-small-note layers-push-bottom">
							Having issues with your maps not displaying? Make sure you have updated your Google Maps API Key under <strong>Site Settings > Additional Scripts</strong>.
						</small>

						<p class="layers-form-item layers-push-top">
							<label for="<?php echo $this->get_layers_field_id( 'address_shown' ); ?>"><?php _e( 'Address Shown' , 'layerswp' ); ?></label>
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'rte',
									'name' => $this->get_layers_field_name( 'address_shown' ) ,
									'id' => $this->get_layers_field_id( 'address_shown' ) ,
									'placeholder' => __( 'e.g. Prestwich Str, Cape Town' , 'layerswp' ),
									'value' => ( isset( $instance['address_shown'] ) ) ? $instance['address_shown'] : NULL,
									'class' => 'layers-textarea'
								)
							); ?>
						</p>
					</div>
					<div class="layers-row clearfix">
						<p class="layers-form-item">

							<label for="<?php echo $this->get_layers_field_id( 'contact_form' ); ?>"><?php _e( 'Contact Form Embed Code' , 'layerswp' ); ?></label>

							<?php echo $this->form_elements()->input(
								array(
									'type' => 'textarea',
									'name' => $this->get_layers_field_name( 'contact_form' ) ,
									'id' => $this->get_layers_field_id( 'contact_form' ) ,
									'placeholder' =>  __( 'Contact form embed code' , 'layerswp' ),
									'value' => ( isset( $instance['contact_form'] ) ) ? $instance['contact_form'] : NULL ,
									'class' => 'layers-textarea'
								)
							); ?>
							<small class="layers-small-note">
								<?php _e( sprintf( 'Need to create a contact form? Try <a href="%1$s" target="ejejcsingle">Gravity Forms</a>', 'https://www.e-junkie.com/ecom/gb.php?cl=54585&c=ib&aff=221037' ) , 'layerswp' ); ?>
							</small>
						</p>
					</div>
				</section>
			</div>

		<?php } // Form
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Layers_Contact_Widget");
}