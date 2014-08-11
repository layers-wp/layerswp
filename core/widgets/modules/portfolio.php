<?php  /**
 * Portfolio Widget
 *
 * This file is used to register and display the Hatch - Portfolio widget.
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_Portfolio_Widget' ) ) {
	class Hatch_Portfolio_Widget extends WP_Widget {

		/**
		* Widget variables
		*
	 	* @param  	varchar    		$widget_title    	Widget title
	 	* @param  	varchar    		$widget_id    		Widget slug for use as an ID/classname
	 	* @param  	varchar    		$post_type    		(optional) Post type for use in widget options
	 	* @param  	varchar    		$taxonomy    		(optional) Taxonomy slug for use as an ID/classname
	 	* @param  	array 			$checkboxes    	(optional) Array of checkbox names to be saved in this widget. Don't forget these please!
	 	*/
		private $widget_title = 'Portfolio';
		private $widget_id = 'portfolio';
		private $post_type = 'jetpack-portfolio';
		private $taxonomy = 'jetpack-portfolio-type';
		public $checkboxes = array(
				'show_titles',
				'show_dates',
				'show_excerpts',
				'show_author',
				'show_cagegories',
				'show_tags',
				'show_comment_count'
			); // @TODO: Try make this more dynamic, or leave a different note reminding users to change this if they add/remove checkboxes
		/**
		*  Widget construction
		*/
	 	function Hatch_Portfolio_Widget(){
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
			<!-- Form HTML Here -->

			<div class="hatch-container-large">

				<?php $widget_elements->header( array(
					'title' =>  __( 'Portfolio' , HATCH_THEME_SLUG ),
					'icon_class' =>'portfolio'
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

							<div class="hatch-row hatch-push-bottom">
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
											'placeholder' => __( 'Short Excerpt', HATCH_THEME_SLUG ),
											'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
											'class' => 'hatch-textarea hatch-large'
										)
									); ?>
								</p>
							</div>

							<div class="hatch-row clearfix">
								<div class="hatch-column hatch-span-6">
									<div class="hatch-panel">
										<?php $widget_elements->section_panel_title(
											array(
												'type' => 'panel',
												'title' => __( 'Content to Display' , HATCH_THEME_SLUG ),
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
															'name' => $this->get_field_name( 'show_titles' ) ,
															'id' => $this->get_field_id( 'show_titles' ) ,
															'value' => ( isset( $show_titles ) ) ? $show_titles : NULL,
															'label' => __( 'Show Item Titles' , HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'show_dates' ) ,
															'id' => $this->get_field_id( 'show_dates' ) ,
															'value' => ( isset( $show_dates ) ) ? $show_dates : NULL,
															'label' => __( 'Show Dates' , HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'show_excerpts' ) ,
															'id' => $this->get_field_id( 'show_excerpts' ) ,
															'value' => ( isset( $show_excerpts ) ) ? $show_excerpts : NULL,
															'label' => __( 'Show Excerpts' , HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'show_author' ) ,
															'id' => $this->get_field_id( 'show_author' ) ,
															'value' => ( isset( $show_author ) ) ? $show_author : NULL,
															'label' => __( 'Show Author' , HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'show_categories' ) ,
															'id' => $this->get_field_id( 'show_categories' ) ,
															'value' => ( isset( $show_categories ) ) ? $show_categories : NULL,
															'label' => __( 'Show Categories' , HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'show_tags' ) ,
															'id' => $this->get_field_id( 'show_tags' ) ,
															'value' => ( isset( $show_tags ) ) ? $show_tags : NULL,
															'label' => __( 'Show Tags' , HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'show_comment_count' ) ,
															'id' => $this->get_field_id( 'show_comment_count' ) ,
															'value' => ( isset( $show_comment_count ) ) ? $show_comment_count : NULL,
															'label' => __( 'Show Comment Count' , HATCH_THEME_SLUG )
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
								'title' => __( 'Layout' , HATCH_THEME_SLUG ),
								'tooltip' => __( 'Place your help text here please.' , HATCH_THEME_SLUG )
							)
						); ?>

						<section class="hatch-accordion-section hatch-content">

							<div class="hatch-row hatch-push-bottom">
								<div class="hatch-column hatch-span-4">
									<div class="hatch-panel">
										<?php $widget_elements->section_panel_title(
											array(
												'type' => 'panel',
												'title' => __( 'List Style' , HATCH_THEME_SLUG ),
												'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
											)
										); ?>
										<div class="hatch-content">
											<?php echo $widget_elements->input(
												array(
													'type' => 'select-icons',
													'name' => $this->get_field_name( 'content_display_type' ) ,
													'id' => $this->get_field_id( 'content_display_type' ) ,
													'value' => ( isset( $content_display_type ) ) ? $content_display_type : NULL,
													'options' => array(
														'grid' => __( 'Grid' , HATCH_THEME_SLUG ),
														'list' => __( 'List' , HATCH_THEME_SLUG ),
														'slider' => __( 'Slider' , HATCH_THEME_SLUG )
													)
												)
											); ?>
										</div>
									</div>
								</div>

								<div class="hatch-column hatch-span-4">
									<div class="hatch-panel">
										<?php $widget_elements->section_panel_title(
											array(
												'type' => 'panel',
												'title' => __( 'Columns' , HATCH_THEME_SLUG ),
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

								<div class="hatch-column hatch-span-4">
									<div class="hatch-panel">
										<?php $widget_elements->section_panel_title(
											array(
												'type' => 'panel',
												'title' => __( 'Image Layout' , HATCH_THEME_SLUG ),
												'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
											)
										); ?>
										<div class="hatch-content">
											<?php echo $widget_elements->input(
												array(
													'type' => 'select-icons',
													'name' => $this->get_field_name( 'image_layout' ) ,
													'id' => $this->get_field_id( 'image_layout' ) ,
													'value' => ( isset( $image_layout ) ) ? $image_layout : NULL,
													'options' => array(
														'image-left' => __( 'Image Left' , HATCH_THEME_SLUG ),
														'image-right' => __( 'Image Right' , HATCH_THEME_SLUG ),
														'image-top' => __( 'Image Top' , HATCH_THEME_SLUG )
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
								'title' => __( 'Design' , HATCH_THEME_SLUG ),
								'tooltip' => __( 'Add a custom background color, image or video to this section of your page.' , HATCH_THEME_SLUG )
							)
						); ?>

						<section class="hatch-accordion-section hatch-content">

							Background :)

						</section>

					</li>
				</ul>
			</div>
		<?php } // Form
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Hatch_Portfolio_Widget");
}