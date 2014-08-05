<?php  /**
 * Module Widget
 *
 * This file is used to register and display the Hatch - Portfolios widget.
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_Module_Widget' ) ) {
	class Hatch_Module_Widget extends WP_Widget {

		/**
		*  Widget variables
		*/
		private $widget_title = 'Modules';
		private $widget_id = 'module';
		private $post_type = '';
		private $taxonomy = '';
		public $checkboxes = array();

		/**
		*  Widget construction
		*/
		function Hatch_Module_Widget(){
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
		function widget( $args, $instance ) {

			// Turn $args array into variables.
			extract( $args );

			// Turn $instance into an object named $widget, makes for neater code
			$widget = (object) $instance; ?>
			<section class="widget row" id="<?php echo $widget_id; ?>">

				<?php // Set the span class for each column
				$span_class = 'span-' . ( 12/$widget->columns );  ?>

				<div class="container content-main clearfix">
					<div class="row">
						<?php if( '' != $widget->title || '' != $widget->excerpt ) { ?>
							<div class="section-title <?php echo $widget->title_size; ?> clearfix">
								<?php if( '' != $widget->title ) { ?>
									<h3 class="heading"><?php echo $widget->title; ?></h3>
								<?php } ?>
								<?php if( '' != $widget->excerpt ) { ?>
									<p class="excerpt"><?php echo $widget->excerpt; ?></p>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
					<div class="row push-bottom-large">
						<?php if( !empty( $widget->modules ) ) { ?>
							<?php $col = 1; ?>
							<?php foreach ( $widget->modules as $key => $module) {
								$module = (object) $module;?>
								<?php if( $col <= $widget->columns ) { ?>
									<div class="column <?php echo $span_class; ?>">
										<div class="marketing marketing-centered">
											<?php if( isset( $module->image ) && '' != $module->image ) { ?>
												<div class="marketing-icon"><a href="<?php echo esc_url( $module->link ); ?>"><?php echo wp_get_attachment_image( $module->image , 'medium' ); ?></a></div>
											<?php } ?>
											<div class="marketing-body">
												<?php if( isset( $module->title ) && '' != $module->title ) { ?>
													<h5 class="heading"><a href="<?php echo esc_url( $module->link ); ?>"><?php echo $module->title; ?></a></h5>
												<?php } ?>
												<?php if( isset( $module->excerpt ) && '' != $module->excerpt ) { ?>
													<p class="excerpt"><?php echo $module->excerpt; ?></p>
												<?php } ?>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php $col++; ?>
							<?php } ?>
						<?php } ?>
					</div>
				</div>

			</section>
			<!-- Front-end HTML Here
			<?php print_r( $instance ); ?>
			 -->

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
				'title_size' => '',
				'title' => NULL,
				'excerpt' => NULL,
				'columns' => 3,
				'module_ids' => rand( 1 , 1000 ) . ',' . rand( 1 , 1000 ) . ',' . rand( 1 , 1000 ) . ',' . rand( 1 , 1000 )
			);

			// Parse $instance
			$instance_args = wp_parse_args( $instance, $instance_defaults );
			extract( $instance_args, EXTR_SKIP );
		?>
			<div class="hatch-container-large">

				<?php $widget_elements->header( array(
					'title' =>'Module',
					'icon_class' =>'module'
				) ); ?>

				<div class="hatch-container-large">

					<ul class="hatch-accordions">
						<li class="hatch-accordion-item">

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
									<p class="hatch-form-item">
										<?php echo $widget_elements->input(
											array(
												'type' => 'select',
												'name' => $this->get_field_name( 'title_size' ) ,
												'id' => $this->get_field_id( 'title_size' ) ,
												'value' => ( isset( $title_size ) ) ? $title_size : NULL ,
												'class' => 'hatch-select hatch-large',
												'options' => array(
														'small' => 'Small',
														'' => 'Medium',
														'large' => 'Large',
													)
											)
										); ?>
									</p>
								</div>
								<div class="hatch-row hatch-push-bottom clearfix">
									<p class="hatch-form-item hatch-span-2">
										<label for="<?php echo $this->get_field_id( 'columns' ); ?>"><?php _e( 'Columns' , HATCH_THEME_SLUG ); ?></label>
										<?php echo $widget_elements->input(
											array(
												'type' => 'select',
												'name' => $this->get_field_name( 'columns' ) ,
												'id' => 'module_columns_' . $this->number,
												'data' => array( 'module_list' => '#module_list_' . $this->number ),
												'value' => ( isset( $columns ) ) ? $columns : NULL,
												'options' => $widget_elements->get_incremental_options( array() , 1 , 4 , 1)
											)
										); ?>
									</p>

									<?php echo $widget_elements->input(
										array(
											'type' => 'hidden',
											'name' => $this->get_field_name( 'module_ids' ) ,
											'id' => 'module_ids_input_' . $this->number,
											'value' => ( isset( $module_ids ) ) ? $module_ids : NULL
										)
									); ?>

								</div>

								<?php // If we have some banners, let's break out their IDs into an array
								if( isset( $module_ids ) && '' != $module_ids ) $modules = explode( ',' , $module_ids ); ?>

								<div class="hatch-row hatch-columns-<?php echo $columns; ?>" id="module_list_<?php echo $this->number; ?>" data-id_base="<?php echo $this->id_base; ?>" data-number="<?php echo $this->number; ?>">

									<?php // Start the column counter from 0
									$this->column_count = 0; ?>

									<?php foreach( $modules as $module ) {
										$this->module_item( array(
												'id_base' => $this->id_base ,
												'number' => $this->number ) ,
												$module ,
												( isset( $instance[ 'modules' ][ $module ] ) ) ? $instance[ 'modules' ][ $module ] : NULL );
									} ?>
								</div>

							</section>

						</li>
					</ul>

				</div>
			</div>
		<?php } // Form

		function module_item( $widget_details = array() , $module_guid = NULL , $instance = NULL ){

			// Update count for the columns
			$this->column_count++;

			// Extract Instance if it's there so that we can use the values in our inputs
			if( NULL !== $instance ) {

				// $instance Defaults
				$instance_defaults = array (
					'columns' => 4,
					'image_layout' => 'image-left',
					'excerpt' => NULL
				);

				// Parse $instance
				$instance_args = wp_parse_args( $instance, $instance_defaults );
				extract( $instance_args, EXTR_SKIP );
			}

			// If there is no GUID create one. There should always be one but this is a fallback
			if( ! isset( $module_guid ) ) $module_guid = rand( 1 , 1000 );

			// Initiate Widget Inputs
			$widget_elements = new Hatch_Widget_Elements();

			// Turn the widget details into an object, it makes the code cleaner
			$widget_details = (object) $widget_details;  ?>
			<div class="hatch-column hatch-span hatch-span-position-<?php echo $this->column_count; ?>" data-guid="<?php echo $module_guid; ?>">
				<small class="hatch-drag"></small>
				<!-- Widget Column Extention -->
				<button class="hatch-button btn-subtle hatch-span-12"><?php _e( 'Convert to Widget Area' , HATCH_THEME_SLUG ); ?></button>
				<?php echo $widget_elements->input(
					array(
						'type' => 'image',
						'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][modules][' . $module_guid . '][image]' ,
						'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $module_guid . '-image' ,
						'value' => ( isset( $image ) ) ? $image : NULL
					)
				); ?>
				<?php echo $widget_elements->input(
					array(
						'type' => 'select-icons',
						'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][modules][' . $module_guid . '][image_layout]' ,
						'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $module_guid . '-image_layout' ,
						'value' => ( isset( $image_layout ) ) ? $image_layout : NULL,
						'options' => array(
							'image-left' => __( 'Left' , HATCH_THEME_SLUG ),
							'image-top' => __( 'Top' , HATCH_THEME_SLUG ),
							'image-right' => __( 'Right' , HATCH_THEME_SLUG )
						)
					)
				); ?>
				<p class="hatch-form-item">
					<?php echo $widget_elements->input(
						array(
							'type' => 'text',
							'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][modules][' . $module_guid . '][title]' ,
							'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $module_guid . '-title' ,
							'value' => ( isset( $title ) ) ? $title : NULL,
							'placeholder' => __( 'Enter title here' , HATCH_THEME_SLUG ),
							'class' => 'hatch-text'
						)
					); ?>
				</p>
				<p class="hatch-form-item">
					<?php echo $widget_elements->input(
						array(
							'type' => 'text',
							'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][modules][' . $module_guid . '][link]' ,
							'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $module_guid . '-link' ,
							'value' => ( isset( $link ) ) ? $link : NULL,
							'placeholder' => __( 'Enter custom link' , HATCH_THEME_SLUG ),
							'class' => 'hatch-text'
						)
					); ?>
				</p>
				<?php echo $widget_elements->input(
					array(
						'type' => 'textarea',
						'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][modules][' . $module_guid . '][excerpt]' ,
						'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $module_guid . '-excerpt' ,
						'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
						'class' => 'hatch-textarea hatch-large',
						'teeny' => true,
						'rows' => 10
					)
				); ?>
			</div>
		<?php }
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Hatch_Module_Widget");
}