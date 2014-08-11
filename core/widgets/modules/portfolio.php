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
				'hide_titles',
				'hide_dates',
				'hide_excerpts',
				'hide_author',
				'hide_cagegories',
				'hide_tags',
				'hide_comment_count'
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
	 	function widget( $args, $instance ) {

			// Turn $args array into variables.
			extract( $args );

			// Turn $instance into an object named $widget, makes for neater code
			$widget = (object) $instance;

 			// Set the span class for each column
			$col_count = str_ireplace('columns-', '', $widget->columns );
			$span_class = 'span-' . ( 12/ $col_count );

			// Begin query arguments
			$query_args = array();
			$query_args[ 'post_type' ] = $this->post_type;
			$query_args[ 'posts_per_page' ] = $widget->posts_per_page;
			$query_args[ 'order_by' ]  = $widget->order_by;

			// Do the special taxonomy array()
			if( isset( $widget->category ) && '' != $widget->category && 0 != $widget->category ){
				$args['tax_query'] = array(
					array(
						"taxonomy" => $this->taxonomy,
						"field" => "id",
						"terms" => $widget->category
					)
				);
			} elseif( !isset( $widget->hide_category_filter ) ) {
				$terms = get_terms( $this->taxonomy );
			} // if we haven't selected which category to show, let's load the $terms for use in the filter

			// Do the WP_Query
			$post_query = new WP_Query( $query_args ); ?>

			<section class="widget container" id="<?php echo $widget_id; ?>">
				<?php if( '' != $widget->title || '' != $widget->excerpt ) { ?>
					<div class="row basement t-center">
						<div class="section-title <?php if( isset( $widget->title_size ) ) echo $widget->title_size; ?> <?php if( isset( $widget->title_alignment ) ) echo $widget->title_alignment; ?> clearfix"> <?php // @TODO: get alignment to work here ?>
							<?php if( '' != $widget->title ) { ?>
								<h3 class="heading"><?php echo $widget->title; ?></h3>
							<?php } ?>
							<?php if( '' != $widget->excerpt ) { ?>
								<p class="excerpt"><?php echo $widget->excerpt; ?></p>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<?php if( !isset( $widget->hide_category_filter ) && !is_wp_error( $terms ) ) { ?>
					<ul class="nav nav-pills push-top">
						<li><span><?php echo $widget->filter_label; ?></span></li>
						<?php foreach( $terms as $term ) { ?>
							<li data-filter="<?php echo $term->slug; ?>"><a href="#"><?php echo $term->name; ?></a></li>
						<?php } // foreach $terms ?>
					</ul>
				<?php } ?>
				<div class="row masonry">
					<?php if( $post_query->have_posts() ) { ?>
						<?php while( $post_query->have_posts() ) { global $post; ?>
							<?php $terms = wp_get_post_terms( $post->ID, $this->taxonomy );
							$term_list = array();
							if( !empty( $terms ) ) {
								foreach( $terms as $term ){
									$term_list[] = $term->slug;
								}
							} ?>
							<?php $post_query->the_post() ?>
							<div class="column-flush <?php echo $span_class; ?> hatch-masonry-column <?php echo implode( $term_list, " " ); ?>">
								<div class="thumbnail">
									<a href="" class="thumbnail-media with-overlay">
										<?php the_post_thumbnail( 'large' ); ?>

										<!-- For non-overlay
										<div class="thumbnail-body">
											<h4 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											<?php the_excerpt(); ?>
											<a href="" class="button">Call to action</a>
										</div>
										-->

										<span class="overlay">
											<?php if( isset( $widget->hide_titles ) ) { ?>
												<span class="heading"><?php the_title(); ?></span>
											<?php } // if hide_titles ?>
											<span class="button">Call to action</span>
										</span>
									</a>
								</div>
							</div>
						<?php }; // while have_posts ?>
					<?php }; // if have_posts ?>
				</div>
			</section>
			<script>
				jQuery(function($){
					var masonry = $('#<?php echo $widget_id; ?>').find('.masonry').masonry();

					$('#<?php echo $widget_id; ?>').find('.nav-pills li').on( 'click' , function(e){
						e.preventDefault();

						// "Hi Mom"
						$that = $(this);

						// Get term slug
						$filter = $that.data( 'filter' );

						// Toggle active
						$that.toggleClass( 'active' ).siblings().removeClass('active');

						jQuery.each( $('#<?php echo $widget_id; ?>').find( '.hatch-masonry-column' ) , function(){
							if( jQuery(this).hasClass( $filter ) || !$that.hasClass( 'active' ) ){
								jQuery(this).fadeIn();
							} else {
								jQuery(this).hide();
							}
						});

						$('#<?php echo $widget_id; ?>').find('.masonry').masonry();
					});
				});
			</script>
			<!-- Front-end HTML Here
			<?php print_r( $instance ); ?>
			 -->

			<?php // Reset WP_Query
				wp_reset_postdata();
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
			$widget_elements = new Hatch_Widget_Elements();

			// $instance Defaults
			$instance_defaults = array (
				'title' => NULL,
				'excerpt' => NULL,
				'filter_label' => __( 'Filter:' , HATCH_THEME_SLUG ),
				'category' => 0
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
											<?php if( 0 == $category ) { ?>
												<p class="hatch-form-item">
													<label for="<?php echo $this->get_field_id( 'filter_label' ); ?>"><?php echo __( 'Category Filter Label' , HATCH_THEME_SLUG ); ?></label>
													<?php echo $widget_elements->input(
														array(
															'type' => 'text',
															'name' => $this->get_field_name( 'filter_label' ) ,
															'id' => $this->get_field_id( 'filter_label' ) ,
															'value' => ( isset( $filter_label ) ) ? $filter_label : NULL
														)
													); ?>
												</p>
											<?php } // if 0 == category ?>
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
															'name' => $this->get_field_name( 'hide_titles' ) ,
															'id' => $this->get_field_id( 'hide_titles' ) ,
															'value' => ( isset( $hide_titles ) ) ? $hide_titles : NULL,
															'label' => __( 'Hide Item Titles' , HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'hide_dates' ) ,
															'id' => $this->get_field_id( 'hide_dates' ) ,
															'value' => ( isset( $hide_dates ) ) ? $hide_dates : NULL,
															'label' => __( 'Hide Dates' , HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'hide_excerpts' ) ,
															'id' => $this->get_field_id( 'hide_excerpts' ) ,
															'value' => ( isset( $hide_excerpts ) ) ? $hide_excerpts : NULL,
															'label' => __( 'Hide Excerpts' , HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'hide_author' ) ,
															'id' => $this->get_field_id( 'hide_author' ) ,
															'value' => ( isset( $hide_author ) ) ? $hide_author : NULL,
															'label' => __( 'Hide Author' , HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<?php if( 0 == $category ) { ?>
													<li class="hatch-checkbox">
														<?php echo $widget_elements->input(
															array(
																'type' => 'checkbox',
																'name' => $this->get_field_name( 'hide_category_filter' ) ,
																'id' => $this->get_field_id( 'hide_category_filter' ) ,
																'value' => ( isset( $hide_category_filter ) ) ? $hide_category_filter : NULL,
																'label' => __( 'Hide Category Filter' , HATCH_THEME_SLUG )
															)
														); ?>
													</li>
												<?php } // if 0 == category ?>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'hide_tags' ) ,
															'id' => $this->get_field_id( 'hide_tags' ) ,
															'value' => ( isset( $hide_tags ) ) ? $hide_tags : NULL,
															'label' => __( 'Hide Tags' , HATCH_THEME_SLUG )
														)
													); ?>
												</li>
												<li class="hatch-checkbox">
													<?php echo $widget_elements->input(
														array(
															'type' => 'checkbox',
															'name' => $this->get_field_name( 'hide_comment_count' ) ,
															'id' => $this->get_field_id( 'hide_comment_count' ) ,
															'value' => ( isset( $hide_comment_count ) ) ? $hide_comment_count : NULL,
															'label' => __( 'Hide Comment Count' , HATCH_THEME_SLUG )
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