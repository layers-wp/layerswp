<?php  /**
 * Contact Details &amp; Maps Widget
 *
 * This file is used to register and display the Hatch - Portfolios widget.
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_Contact_Widget' ) ) {
	class Hatch_Contact_Widget extends WP_Widget {

		/**
		* Widget variables
		*
	 	* @param  	varchar    		$widget_title    	Widget title
	 	* @param  	varchar    		$widget_id    		Widget slug for use as an ID/classname
	 	* @param  	varchar    		$post_type    		(optional) Post type for use in widget options
	 	* @param  	varchar    		$taxonomy    		(optional) Taxonomy slug for use as an ID/classname
	 	* @param  	array 			$checkboxes    	(optional) Array of checkbox names to be saved in this widget. Don't forget these please!
	 	*/
		private $widget_title = 'Contact Details &amp; Maps';
		private $widget_id = 'map';
		private $post_type = '';
		private $taxonomy = '';
		public $checkboxes = array(
				'show_google_map',
				'show_address',
				'show_contact_form'
			);

		/**
		*  Widget construction
		*/
	 	function Hatch_Contact_Widget(){
	 		/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-hatch-' . $this->widget_id .'-widget', 'description' => 'This widget is used to display your ' . $this->widget_title . '.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => 1000, 'height' => NULL, 'id_base' => HATCH_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( HATCH_THEME_SLUG . '-widget-' . $this->widget_id , $this->widget_title . ' Widget', $widget_ops, $control_ops );
	 	}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) { ?>
	 		<!-- Front-end HTML Here -->
	 		<pre><?php if( isset( $instance ) ) print_r( $instance ); ?></pre>
	 	<?php }

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

			// Initiate Widget Inputs
			$widget_elements = new Hatch_Widget_Elements();

			// $instance Defaults
			$instance_defaults = array (
				'title' => NULL,
				'excerpt' => NULL,
			);

			// Parse $instance
			$instance_args = wp_parse_args( $instance, $instance_defaults );
			extract( $instance_args, EXTR_SKIP );
		?>

			<div class="hatch-container-large">

				<?php $widget_elements->header( array(
					'title' => __( 'Contact', HATCH_THEME_SLUG ),
					'icon_class' =>'location'
				) ); ?>

				<ul class="hatch-accordions">
					<li class="hatch-accordion-item open">

						<?php $widget_elements->accordian_title(
							array(
								'title' => __( 'Content' , HATCH_THEME_SLUG ),
								'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
							)
						); ?>

						<section class="hatch-accordion-section hatch-content">
							<div class="hatch-row hatch-push-bottom clearfix">
								<p class="hatch-form-item">
									<?php echo $widget_elements->input(
										array(
											'type' => 'text',
											'name' => $this->get_field_name( 'title' ) ,
											'id' => $this->get_field_id( 'title' ) ,
											'placeholder' => __( 'Enter title here', HATCH_THEME_SLUG ),
											'value' => ( isset( $title ) ) ? $title : NULL ,
											'class' => 'hatch-text hatch-large'
										)
									); ?>
								</p>
								<p class="hatch-form-item">
									<?php echo $widget_elements->input(
										array(
											'type' => 'textarea',
											'name' => $this->get_field_name( 'excerpt' ) ,
											'id' => $this->get_field_id( 'excerpt' ) ,
											'placeholder' =>  __( 'Short Excerpt', HATCH_THEME_SLUG ),
											'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
											'class' => 'hatch-textarea hatch-large'
										)
									); ?>
								</p>
							</div>
						</section>

					</li>
					<li class="hatch-accordion-item">

						<?php $widget_elements->accordian_title(
							array(
								'title' => __( 'Map Details' , HATCH_THEME_SLUG ),
								'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
							)
						); ?>

						<section class="hatch-accordion-section hatch-content">

							<div class="hatch-map-container hatch-push-bottom"><!-- Map HTML here --></div>

							<div class="hatch-row clearfix">
								<div class="hatch-column hatch-span-6">
									<div class="hatch-panel">
										<?php $widget_elements->section_panel_title(
											array(
												'type' => 'panel',
												'title' => __( 'Address' , HATCH_THEME_SLUG ),
												'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
											)
										); ?>
										<div class="hatch-content">
											<p class="hatch-form-item">
												<label for="<?php echo $this->get_field_id( 'google_maps_location' ); ?>"><?php _e( 'Google Maps Location' , HATCH_THEME_SLUG ); ?></label>
												<?php echo $widget_elements->input(
													array(
														'type' => 'text',
														'name' => $this->get_field_name( 'google_maps_location' ) ,
														'id' => $this->get_field_id( 'google_maps_location' ) ,
														'placeholder' => __( 'e.g. 300 Prestwich Str, Cape Town, South Africa', HATCH_THEME_SLUG ),
														'value' => ( isset( $google_maps_location ) ) ? $google_maps_location : NULL
													)
												); ?>
											</p>
											<p class="hatch-form-item">
												<label for="<?php echo $this->get_field_id( 'google_maps_long_lat' ); ?>"><?php _e( 'Google Maps Latitude & Longitude (Optional)' , HATCH_THEME_SLUG ); ?></label>
												<?php echo $widget_elements->input(
													array(
														'type' => 'text',
														'name' => $this->get_field_name( 'google_maps_long_lat' ) ,
														'id' => $this->get_field_id( 'google_maps_long_lat' ) ,
														'placeholder' => __( 'e.g. 33.9253 S, 18.4239 E', HATCH_THEME_SLUG ),
														'value' => ( isset( $google_maps_long_lat ) ) ? $google_maps_long_lat : NULL
													)
												); ?>
											</p>
											<p class="hatch-form-item">
												<label for="<?php echo $this->get_field_id( 'address_shown' ); ?>"><?php _e( 'Address Shown' , HATCH_THEME_SLUG ); ?></label>
												<?php echo $widget_elements->input(
													array(
														'type' => 'textarea',
														'name' => $this->get_field_name( 'address_shown' ) ,
														'id' => $this->get_field_id( 'address_shown' ) ,
														'placeholder' => __( 'e.g. Prestwich Str, Cape Town', HATCH_THEME_SLUG ),
														'value' => ( isset( $address_shown ) ) ? $address_shown : NULL,
														'class' => 'hatch-textarea'
													)
												); ?>
											</p>
											<a href="" class="hatch-button"><?php _e( 'Check Address' , HATCH_THEME_SLUG ); ?></a>
										</div>
									</div>
								</div>

								<div class="hatch-column hatch-span-6">
									<div class="hatch-panel">
										<?php $widget_elements->section_panel_title(
											array(
												'type' => 'panel',
												'title' => __( 'Display Elements' , HATCH_THEME_SLUG ),
												'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
											)
										); ?>
										<div class="hatch-content">
											<ul class="hatch-checkbox-list">
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'show_google_map' ) ,
															'id' => $this->get_field_id( 'show_google_map' ) ,
															'value' => ( isset( $show_google_map ) ) ? $show_google_map : NULL,
															'label' => __( 'Show Google Map', HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'show_address' ) ,
															'id' => $this->get_field_id( 'show_address' ) ,
															'value' => ( isset( $show_address ) ) ? $show_address : NULL,
															'label' => __( 'Show Address', HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'show_contact_form' ) ,
															'id' => $this->get_field_id( 'show_contact_form' ) ,
															'value' => ( isset( $show_contact_form ) ) ? $show_contact_form : NULL,
															'label' => __( 'Show Contact Form', HATCH_THEME_SLUG )
														)
													); ?>
												</li>
											</ul>
										</div>
									</div>
								</div>

							</div>

						</section>
					</li>

					<li class="hatch-accordion-item">

						<?php $widget_elements->accordian_title(
							array(
								'title' => __( 'Design' , HATCH_THEME_SLUG ),
								'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
							)
						); ?>

						<section class="hatch-accordion-section hatch-content">
							<div class="hatch-row clearfix">
								<div class="hatch-column hatch-span-8">
									<p class="hatch-form-item">
										<label>Background Image</label>
										<a href="#" class="hatch-image-uploader hatch-animate hatch-push-bottom"></a>
									</p>
								</div>
								<div class="hatch-column hatch-span-4 no-gutter">
									<p class="hatch-form-item hatch-no-push-bottom">
										<label>Background Color</label>
										<a class="wp-color-result" tabindex="0" title="Select Color" data-current="Current Color"></a>
									</p>
									<p class="hatch-checkbox">
										<input type="checkbox" />
										<label>Darken to improve readability </label>
									</p>
								</div>
							</div>
						</section>
					</li>

				</ul>
			</div>



		<?php } // Form
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Hatch_Contact_Widget");
}