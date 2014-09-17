<?php  /**
 * Contact Details &amp; Maps Widget
 *
 * This file is used to register and display the Hatch - Portfolios widget.
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_Contact_Widget' ) ) {
	class Hatch_Contact_Widget extends Hatch_Widget {

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
			$control_ops = array( 'width' => HATCH_WIDGET_WIDTH_SMALL, 'height' => NULL, 'id_base' => HATCH_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( HATCH_THEME_SLUG . '-widget-' . $this->widget_id , '(' . HATCH_THEME_TITLE . ') ' . $this->widget_title . ' Widget', $widget_ops, $control_ops );

			/* Setup Widget Defaults */
			$this->defaults = array (
				'title' => NULL,
				'excerpt' => NULL,
				'address_shown' => NULL,
				'title_size' => '',
				'google_maps_location' => NULL,
				'google_maps_long_lat' => NULL
			);
		}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) {

			// Turn $args array into variables.
			extract( $args );

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			 $instance = wp_parse_args( $instance , $instance_defaults );

			// Turn $instance into an object named $widget, makes for neater code
			$widget = (object) $instance;

			// Set the background styling
			if( !empty( $widget->design[ 'background' ] ) ) $this->widget_styles( $widget_id , 'background', $widget->design[ 'background' ] ); ?>

			<section class="widget row" id="<?php echo $widget_id; ?>">
				<?php if( '' != $widget->title || '' != $widget->excerpt  || '' != $widget->address_shown ) { ?>
					<div class="container content clearfix">
						<div class="section-title <?php if( isset( $widget->design['textalign'] ) ) echo $widget->design['textalign']; ?> clearfix">
							<?php if( '' != $widget->address_shown && !isset( $widget->show_address ) ) { ?>
								<small class="pull-right span-2">
									<?php echo $widget->address_shown; ?>
								</small>
							<?php } ?>
							<?php if( '' != $widget->title ) { ?>
								<h3 class="heading"><?php echo $widget->title; ?></h3>
							<?php } ?>
							<?php if( '' != $widget->excerpt ) { ?>
								<p class="excerpt"><?php echo $widget->excerpt; ?></p>
							<?php } ?>
						</div>
					</div>
				<?php } // if title || excerpt ?>
				<?php if( !isset( $widget->show_google_map ) && ( '' != $widget->google_maps_location || '' != $widget->google_maps_long_lat ) ) { ?>
					<div class="hatch-map invert with-background <?php if( isset( $widget->layout ) && 'boxed' == $widget->layout ) echo 'container'; ?> " style="height: 670px;" <?php if( '' != $widget->google_maps_location ) { ?>data-location="<?php echo $widget->google_maps_location; ?>"<?php } ?> <?php if( '' != $widget->google_maps_long_lat ) { ?>data-longlat="<?php echo $widget->google_maps_long_lat; ?>"<?php } ?>></div>
				<?php } ?>
			</section>

	 		<!-- Front-end HTML Here
	 		<?php print_r( $instance ); ?>-->

	 		<?php // Enqueue the map js
	 			wp_enqueue_script( HATCH_THEME_SLUG . " -map-api","http://maps.googleapis.com/maps/api/js?sensor=false");
	 			wp_enqueue_script( HATCH_THEME_SLUG . "-map-trigger", get_template_directory_uri()."/core/widgets/js/maps.js", array( "jquery" ) );
	 		?>
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
			$widget_elements = new Hatch_Form_Elements();

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			// Parse $instance
			$instance_args = wp_parse_args( $instance, $instance_defaults );
			extract( $instance_args, EXTR_SKIP );
		?>
			<!-- Form HTML Here -->
			<?php $design_controller = new Hatch_Design_Controller();
			$design_controller->bar(
				$this, // Widget Object
				$instance, // Widget Values
				array(
					'layout',
					'custom',
					'liststyle',
					'textalign',
					'background'
				), // Standard Components
				array(
					'display' => array(
						'icon-css' => 'icon-display',
						'label' => 'Display',
						'elements' => array(
								'show_google_map' => array(
										'type' => 'checkbox',
										'name' => $this->get_field_name( 'show_google_map' ) ,
										'id' => $this->get_field_id( 'show_google_map' ) ,
										'value' => ( isset( $show_google_map ) ) ? $show_google_map : NULL,
										'label' => __( 'Hide Google Map', HATCH_THEME_SLUG )
									)
								),
								'show_address' => array(
										'type' => 'checkbox',
										'name' => $this->get_field_name( 'show_address' ) ,
										'id' => $this->get_field_id( 'show_address' ) ,
										'value' => ( isset( $show_address ) ) ? $show_address : NULL,
										'label' => __( 'Hide Address', HATCH_THEME_SLUG )
									)
								),
								'show_contact_form' => array(
										'type' => 'checkbox',
										'name' => $this->get_field_name( 'show_contact_form' ) ,
										'id' => $this->get_field_id( 'show_contact_form' ) ,
										'value' => ( isset( $show_contact_form ) ) ? $show_contact_form : NULL,
										'label' => __( 'Hide Contact Form', HATCH_THEME_SLUG )
									)
								)
							);?>
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

							<div class="hatch-row clearfix">
								<div class="hatch-column hatch-span-12">
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
										</div>
									</div>
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