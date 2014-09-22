<?php  /**
 * Team Widget
 *
 * This file is used to register and display the Hatch - Portfolios widget.
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_Team_Widget' ) ) {
	class Hatch_Team_Widget extends WP_Widget {

		/**
		* Widget variables
		*
	 	* @param  	varchar    		$widget_title    	Widget title
	 	* @param  	varchar    		$widget_id    		Widget slug for use as an ID/classname
	 	* @param  	varchar    		$post_type    		(optional) Post type for use in widget options
	 	* @param  	varchar    		$taxonomy    		(optional) Taxonomy slug for use as an ID/classname
	 	* @param  	array 			$checkboxes    	(optional) Array of checkbox names to be saved in this widget. Don't forget these please!
	 	*/
		private $widget_title = 'Team';
		private $widget_id = 'team';
		private $post_type = 'team';
		private $taxonomy = 'team-category';
		public $checkboxes = array(
				'show_name',
				'show_bio',
				'show_position',
				'show_social_links'
			);

		/**
		*  Widget construction
		*/
	 	function Hatch_Team_Widget(){
	 		/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-hatch-' . $this->widget_id .'-widget', 'description' => 'This widget is used to display your ' . $this->widget_title . '.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => HATCH_WIDGET_WIDTH_SMALL, 'height' => NULL, 'id_base' => HATCH_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( HATCH_THEME_SLUG . '-widget-' . $this->widget_id , '(' . HATCH_THEME_TITLE . ') ' . $this->widget_title . ' Widget', $widget_ops, $control_ops );
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
			$widget_elements = new Hatch_Form_Elements();

			// $instance Defaults
			$instance_defaults = array (
				'title' => NULL,
				'excerpt' => NULL,
			);

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );
		?>

			<div class="hatch-container-large">

				<?php $widget_elements->header( array(
					'title' =>'Team',
					'icon_class' =>'teams'
				) ); ?>

				<div class="hatch-container-large">

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

								<div class="hatch-row">
									<div class="hatch-column hatch-span-4">
										<div class="hatch-panel">
											<?php $widget_elements->section_panel_title(
												array(
													'type' => 'panel',
													'title' => __( 'Content Settings' , HATCH_THEME_SLUG ),
													'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
												)
											); ?>
											<div class="hatch-content">
												<?php // Grab the terms as an array and loop 'em to generate the $options for the input
												$terms = get_terms( $this->taxonomy );
												if( !is_wp_error( $terms ) ) { ?>
													<p class="hatch-form-item">
														<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php echo __( 'Category to Display' , HATCH_THEME_SLUG ); ?></label>
														<?php $category_options[ 0 ] ="All";
														foreach ( $terms as $t ) $category_options[ $t->term_id ] = $t->name;
														echo $widget_elements->input(
															array(
																'type' => 'select',
																'name' => $this->get_field_name( 'category' ) ,
																'id' => $this->get_field_id( 'category' ) ,
																'placeholder' => __( 'Select a Category' , HATCH_THEME_SLUG ),
																'value' => ( isset( $category ) ) ? $category : NULL ,
																'options' => $category_options
															)
														); ?>
													</p>
												<?php } // if !is_wp_error ?>

												<p class="hatch-form-item">
													<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php echo __( 'Number of items to show' , HATCH_THEME_SLUG ); ?></label>
													<?php $select_options[ '-1' ] = __( 'Show All' , HATCH_THEME_SLUG );
													$select_options = $widget_elements->get_incremental_options( $select_options , 1 , 20 , 1);
													echo $widget_elements->input(
														array(
															'type' => 'select',
															'name' => $this->get_field_name( 'posts_per_page' ) ,
															'id' => $this->get_field_id( 'posts_per_page' ) ,
															'value' => ( isset( $posts_per_page ) ) ? $posts_per_page : NULL ,
															'options' => $select_options
														)
													); ?>
												</p>

												<p class="hatch-form-item">
													<label for="<?php echo $this->get_field_id( 'order_by' ); ?>"><?php echo __( 'Sort by' , HATCH_THEME_SLUG ); ?></label>
													<?php echo $widget_elements->input(
														array(
															'type' => 'select',
															'name' => $this->get_field_name( 'order_by' ) ,
															'id' => $this->get_field_id( 'order_by' ) ,
															'value' => ( isset( $order_by ) ) ? $order_by : NULL ,
															'options' => $widget_elements->get_default_sort_options()
														)
													); ?>
												</p>
											</div>
										</div>
									</div>
									<div class="hatch-column hatch-span-4">
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
																'name' => $this->get_field_name( 'show_name' ) ,
																'id' => $this->get_field_id( 'show_name' ) ,
																'value' => ( isset( $show_name ) ) ? $show_name : NULL,
																'label' => __( 'Show Name', HATCH_THEME_SLUG )
															)
														); ?>
													</li>
													<li class="hatch-checkbox">
														<?php echo $widget_elements->input(
															array(
																'type' => 'checkbox',
																'name' => $this->get_field_name( 'show_position' ) ,
																'id' => $this->get_field_id( 'show_position' ) ,
																'value' => ( isset( $show_position ) ) ? $show_position : NULL,
																'label' => __( 'Show Position', HATCH_THEME_SLUG )
															)
														); ?>
													</li>
													<li class="hatch-checkbox">
														<?php echo $widget_elements->input(
															array(
																'type' => 'checkbox',
																'name' => $this->get_field_name( 'show_social_links' ) ,
																'id' => $this->get_field_id( 'show_social_links' ) ,
																'value' => ( isset( $show_social_links ) ) ? $show_social_links : NULL,
																'label' => __( 'Show Social Links', HATCH_THEME_SLUG )
															)
														); ?>
													</li>
													<li class="hatch-checkbox">
														<?php echo $widget_elements->input(
															array(
																'type' => 'checkbox',
																'name' => $this->get_field_name( 'show_bio' ) ,
																'id' => $this->get_field_id( 'show_bio' ) ,
																'value' => ( isset( $show_bio ) ) ? $show_bio : NULL,
																'label' => __( 'Show Bio', HATCH_THEME_SLUG )
															)
														); ?>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="hatch-column hatch-span-4">
										<div class="hatch-panel">
											<?php $widget_elements->section_panel_title(
												array(
													'type' => 'panel',
													'title' => __( 'Layout' , HATCH_THEME_SLUG ),
													'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
												)
											); ?>
											<div class="hatch-content">
												<?php echo $widget_elements->input(
													array(
														'type' => 'select-icons',
														'name' => $this->get_field_name( 'columns' ) ,
														'id' => $this->get_field_id( 'columns' ) ,
														'value' => ( isset( $columns ) ) ? $columns : NULL,
														'options' => array(
															'columns-1' => __( '1 Column' , HATCH_THEME_SLUG ),
															'columns-2' => __( '2 Column' , HATCH_THEME_SLUG ),
															'columns-3' => __( '3 Column' , HATCH_THEME_SLUG ),
															'columns-4' => __( '4 Column' , HATCH_THEME_SLUG ),
															'columns-5' => __( '5 Column' , HATCH_THEME_SLUG ),
															'columns-6' => __( '6 Column' , HATCH_THEME_SLUG )
														)
													)
												); ?>
											</div>
										</div>
									</div>
								</div>
							</section>

						</li>
						<li class="hatch-accordion-item">
							<?php $widget_elements->accordian_title(
								array(
									'title' => __( 'Background' , HATCH_THEME_SLUG ),
									'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
								)
							); ?>
							<section class="hatch-accordion-section hatch-content">
								<?php echo $widget_elements->input(
									array(
										'type' => 'background',
										'name' => $this->get_field_name( 'background' ) ,
										'id' => $this->get_field_id( 'background' ) ,
										'value' => ( isset( $background ) ) ? $background : NULL
									)
								); ?>
							</section>
						</li>
					</ul>

				</div>

			</div>

		<?php } // Form
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Hatch_Team_Widget");
}