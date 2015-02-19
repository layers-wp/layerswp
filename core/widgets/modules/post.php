<?php  /**
 * Post Widget
 *
 * This file is used to register and display the Layers - Post widget.
 *
 * @package Layers
 * @since Layers 1.0.0
 */
if( !class_exists( 'Layers_Post_Widget' ) ) {
	class Layers_Post_Widget extends Layers_Widget {

		/**
		*  Widget construction
		*/
		function Layers_Post_Widget(){

			/**
			* Widget variables
			*
			* @param  	varchar    		$widget_title    	Widget title
			* @param  	varchar    		$widget_id    		Widget slug for use as an ID/classname
			* @param  	varchar    		$post_type    		(optional) Post type for use in widget options
			* @param  	varchar    		$taxonomy    		(optional) Taxonomy slug for use as an ID/classname
			* @param  	array 			$checkboxes    	(optional) Array of checkbox names to be saved in this widget. Don't forget these please!
			*/
			$this->widget_title = __( 'Posts' , 'layerswp' );
			$this->widget_id = 'post';
			$this->post_type = 'post';
			$this->taxonomy = 'category';
			$this->checkboxes = array(
					'show_media',
					'show_titles',
					'show_excerpts',
					'show_dates',
					'show_author',
					'show_tags',
					'show_categories',
					'show_call_to_action'
				); // @TODO: Try make this more dynamic, or leave a different note reminding users to change this if they add/remove checkboxes

			/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-layers-' . $this->widget_id .'-widget', 'description' => 'This widget is used to display your ' . $this->widget_title . '.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => LAYERS_WIDGET_WIDTH_SMALL, 'height' => NULL, 'id_base' => LAYERS_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( LAYERS_THEME_SLUG . '-widget-' . $this->widget_id , $this->widget_title, $widget_ops, $control_ops );

			/* Setup Widget Defaults */
			$this->defaults = array (
				'title' => 'Latest Posts',
				'excerpt' => 'Stay up to date with all our latest news and launches. Only the best quality makes it onto our blog!',
				'text_style' => 'regular',
				'category' => 0,
				'show_media' => 'on',
				'show_titles' => 'on',
				'show_excerpts' => 'on',
				'show_dates' => 'on',
				'show_author' => 'on',
				'show_tags' => 'on',
				'show_categories' => 'on',
				'excerpt_length' => 200,
				'show_call_to_action' => 'on',
				'call_to_action' => __( 'Read More' , 'layerswp' ),
                'posts_per_page' => 6,
				'design' => array(
					'layout' => 'layout-boxed',
					'imageratios' => 'image-square',
					'textalign' => 'text-left',
					'liststyle' => 'list-grid',
					'columns' => '3',
					'gutter' => 'on',
					'background' => array(
						'position' => 'center',
						'repeat' => 'no-repeat'
					),
					'fonts' => array(
						'align' => 'text-left',
						'size' => 'medium',
						'color' => NULL,
						'shadow' => NULL
					)
				)
			);
		}

		/**
		* Enqueue Scripts
		*/
		function enqueue_scripts(){
			wp_enqueue_script( 'jquery-masonry' ); // Wordpress Masonry

			wp_enqueue_script(
				LAYERS_THEME_SLUG . '-layers-masonry-js' ,
				get_template_directory_uri() . '/assets/js/layers.masonry.js',
				array(
					'jquery'
				)
			); // Layers Masonry Function
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

			// Parse $instance
			$widget = wp_parse_args( $instance, $instance_defaults );

			// Enqueue Scipts when needed
			$this->enqueue_scripts();

			// Set the span class for each column
			if( 'list-list' == $widget['design'][ 'liststyle' ] ) {
                $col_count = 1;
				$span_class = 'span-12';
			} else if( isset( $widget['design'][ 'columns']  ) ) {
				$col_count = str_ireplace('columns-', '', $widget['design'][ 'columns']  );
				$span_class = 'span-' . ( 12/ $col_count );
			} else {
				$col_count = 3;
				$span_class = 'span-4';
			}

			// Set the background & font styling
			if( !empty( $widget['design'][ 'background' ] ) ) layers_inline_styles( '#' . $widget_id, 'background', array( 'background' => $widget['design'][ 'background' ] ) );
			if( !empty( $widget['design']['fonts'][ 'color' ] ) ) layers_inline_styles( '#' . $widget_id, 'color', array( 'selectors' => array( '.section-title h3.heading' , '.section-title p.excerpt' ) , 'color' => $widget['design']['fonts'][ 'color' ] ) );

			// Apply the advanced widget styling
			$this->apply_widget_advanced_styling( $widget_id, $widget );

			// Set Image Sizes
			if( isset( $widget['design'][ 'imageratios' ] ) ){

				// Translate Image Ratio
				$image_ratio = layers_translate_image_ratios( $widget['design'][ 'imageratios' ] );

				if( 'layout-boxed' == $this->check_and_return( $widget , 'design', 'layout' ) && $col_count > 2 ){
					$use_image_ratio = $image_ratio . '-medium';
				} elseif( 'layout-boxed' != $this->check_and_return( $widget , 'design', 'layout' ) && $col_count > 3 ){
					$use_image_ratio = $image_ratio . '-large';
				} else {
					$use_image_ratio = $image_ratio . '-large';
				}
			} else {
				$use_image_ratio = 'large';
			}

			// Begin query arguments
			$query_args = array();
			$query_args[ 'paged' ] = (get_query_var('page')) ? get_query_var('page') : 1;
			$query_args[ 'post_type' ] = $this->post_type;
			$query_args[ 'posts_per_page' ] = $widget['posts_per_page'];
			if( isset( $widget['order'] ) ) {

				$decode_order = json_decode( $widget['order'], true );

				if( is_array( $decode_order ) ) {
					foreach( $decode_order as $key => $value ){
						$query_args[ $key ] = $value;
					}
				}
			}

			// Do the special taxonomy array()
			if( isset( $widget['category'] ) && '' != $widget['category'] && 0 != $widget['category'] ){
				$query_args['tax_query'] = array(
					array(
						"taxonomy" => $this->taxonomy,
						"field" => "id",
						"terms" => $widget['category']
					)
				);
			} elseif( !isset( $widget['hide_category_filter'] ) ) {
				$terms = get_terms( $this->taxonomy );
			} // if we haven't selected which category to show, let's load the $terms for use in the filter

			// Do the WP_Query
			$post_query = new WP_Query( $query_args );

			// Set the meta to display
			global $layers_post_meta_to_display;
			$layers_post_meta_to_display = array();
			if( isset( $widget['show_dates'] ) ) $layers_post_meta_to_display[] = 'date';
			if( isset( $widget['show_author'] ) ) $layers_post_meta_to_display[] = 'author';
			if( isset( $widget['show_categories'] ) ) $layers_post_meta_to_display[] = 'categories';
			if( isset( $widget['show_tags'] ) ) $layers_post_meta_to_display[] = 'tags'; ?>

			<section class="widget row content-vertical-massive <?php echo $this->check_and_return( $widget , 'design', 'advanced', 'customclass' ) ?> <?php echo $this->get_widget_spacing_class( $widget ); ?>" id="<?php echo $widget_id; ?>">
				<?php if( '' != $this->check_and_return( $widget , 'title' ) ||'' != $this->check_and_return( $widget , 'excerpt' ) ) { ?>
					<div class="container clearfix">
						<div class="section-title <?php echo $this->check_and_return( $widget , 'design', 'fonts', 'size' ); ?> <?php echo $this->check_and_return( $widget , 'design', 'fonts', 'align' ); ?> clearfix">
							<?php if( '' != $widget['title'] ) { ?>
								<h3 class="heading"><?php echo esc_html( $widget['title'] ); ?></h3>
							<?php } ?>
							<?php if( '' != $widget['excerpt'] ) { ?>
								<p class="excerpt"><?php echo $widget['excerpt']; ?></p>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<div class="row <?php echo $this->get_widget_layout_class( $widget ); ?> <?php echo $this->check_and_return( $widget , 'design', 'liststyle' ); ?>">
					<?php if( $post_query->have_posts() ) { ?>
						<?php while( $post_query->have_posts() ) {
							$post_query->the_post();
							global $post;

							if( 'list-list' == $widget['design'][ 'liststyle' ] ) { ?>
								<?php get_template_part( 'partials/content' , 'list' ); ?>
							<?php } else { ?>
								<article class="column<?php if( !isset( $widget['design'][ 'gutter' ] ) ) echo '-flush'; ?> <?php echo $span_class; ?> layers-masonry-column thumbnail <?php if( 'overlay' == $this->check_and_return( $widget , 'text_style' ) ) echo 'with-overlay'; ?>" data-cols="<?php echo $col_count; ?>">
									<?php // Layers Featured Media
									if( isset( $widget['show_media'] ) ) {
										echo layers_post_featured_media(
											array(
												'postid' => $post->ID,
												'wrap_class' => 'thumbnail-media' .  ( ( isset( $column['design'][ 'imageratios' ] ) && 'image-round' == $column['design'][ 'imageratios' ] ) ? ' image-rounded' : '' ),
												'size' => $use_image_ratio
											)
										);
									} // if Show Media ?>
									<?php if( isset( $widget['show_titles'] ) || isset( $widget['show_excerpts'] ) ) { ?>
										<div class="thumbnail-body">
											<div class="overlay">
												<?php if( isset( $widget['show_titles'] ) ) { ?>
													<header class="article-title">
														<h4 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
													</header>
												<?php } ?>
												<?php if( isset( $widget['show_excerpts'] ) ) {
													if( isset( $widget['excerpt_length'] ) && '' == $widget['excerpt_length'] ) {
														echo '<div class="excerpt">';
															the_content();
														echo '</div>';
                                                    } else if( isset( $widget['excerpt_length'] ) && 0 != $widget['excerpt_length'] && strlen( get_the_excerpt() ) > $widget['excerpt_length'] ){
                                                        echo '<p class="excerpt">' . substr( get_the_excerpt() , 0 , $widget['excerpt_length'] ) . '&#8230;</p>';
                                                    } else if( '' != get_the_excerpt() ){
                                                        echo '<p class="excerpt">' . get_the_excerpt() . '</p>';
                                                    }
                                                }; ?>
                                                <?php if( 'overlay' != $this->check_and_return( $widget, 'text_style' ) ) { ?>
    												<?php layers_post_meta( $post->ID, $layers_post_meta_to_display );?>
    											<?php } // Don't show meta if we have chosen overlay ?>
                                                <?php if( isset( $widget['show_call_to_action'] ) && $this->check_and_return( $widget , 'call_to_action' ) ) { ?>
													<a href="<?php the_permalink(); ?>" class="button"><?php echo $widget['call_to_action']; ?></a>
												<?php } // show call to action ?>
											</div>
										</div>
									<?php } // if show titles || show excerpt ?>
								</article>
							<?php }; // if list-list == liststyle ?>
						<?php }; // while have_posts ?>
					<?php }; // if have_posts ?>
					<?php if( isset( $widget['show_pagination'] ) ) layers_pagination( array( 'query' => $post_query ), 'div', 'pagination row span-12 text-center' ); ?>

				</div>
			</section>

			<script>
				jQuery(function($){
					layers_masonry_settings[ '<?php echo $widget_id; ?>' ] = [{
							itemSelector: '.layers-masonry-column',
							masonry: {
								gutter: <?php echo ( isset( $widget['design'][ 'gutter' ] ) ? 20 : 0 ); ?>
							}
						}];

					$('#<?php echo $widget_id; ?>').find('.list-masonry').layers_masonry( layers_masonry_settings[ '<?php echo $widget_id; ?>' ][0] );
				});
			</script>

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

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );

			extract( $instance, EXTR_SKIP ); ?>

			<!-- Form HTML Here -->
			<?php $this->design_bar(
				'side', // CSS Class Name
				array(
					'name' => $this->get_field_name( 'design' ),
					'id' => $this->get_field_id( 'design' ),
				), // Widget Object
				$instance, // Widget Values
				array(
					'layout',
					'fonts',
					'custom',
					'columns',
					'liststyle',
					'imageratios',
					'background',
					'advanced'
				), // Standard Components
				array(
					'display' => array(
						'icon-css' => 'icon-display',
						'label' => 'Display',
						'elements' => array(
								'text_style' => array(
									'type' => 'select',
									'name' => $this->get_field_name( 'text_style' ) ,
									'id' => $this->get_field_id( 'text_style' ) ,
									'value' => ( isset( $text_style ) ) ? $text_style : NULL,
									'label' => __( 'Title &amp; Excerpt Position' , 'layerswp' ),
									'options' => array(
											'regular' => __( 'Regular' , 'layerswp' ),
											'overlay' => __( 'Overlay' , 'layerswp' )
									)
								),
								'show_media' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_media' ) ,
									'id' => $this->get_field_id( 'show_media' ) ,
									'value' => ( isset( $show_media ) ) ? $show_media : NULL,
									'label' => __( 'Show Featured Images' , 'layerswp' )
								),
								'show_titles' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_titles' ) ,
									'id' => $this->get_field_id( 'show_titles' ) ,
									'value' => ( isset( $show_titles ) ) ? $show_titles : NULL,
									'label' => __( 'Show  Post Titles' , 'layerswp' )
								),
								'show_excerpts' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_excerpts' ) ,
									'id' => $this->get_field_id( 'show_excerpts' ) ,
									'value' => ( isset( $show_excerpts ) ) ? $show_excerpts : NULL,
									'label' => __( 'Show Post Excerpts' , 'layerswp' )
								),
                                'excerpt_length' => array(
                                    'type' => 'number',
                                    'name' => $this->get_field_name( 'excerpt_length' ) ,
                                    'id' => $this->get_field_id( 'excerpt_length' ) ,
                                    'min' => 0,
                                    'max' => 10000,
                                    'value' => ( isset( $excerpt_length ) ) ? $excerpt_length : NULL,
                                    'label' => __( 'Excerpts Length' , 'layerswp' )
                                ),
								'show_dates' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_dates' ) ,
									'id' => $this->get_field_id( 'show_dates' ) ,
									'value' => ( isset( $show_dates ) ) ? $show_dates : NULL,
									'label' => __( 'Show Post Dates' , 'layerswp' )
								),
								'show_author' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_author' ) ,
									'id' => $this->get_field_id( 'show_author' ) ,
									'value' => ( isset( $show_author ) ) ? $show_author : NULL,
									'label' => __( 'Show Post Author' , 'layerswp' )
								),
								'show_tags' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_tags' ) ,
									'id' => $this->get_field_id( 'show_tags' ) ,
									'value' => ( isset( $show_tags ) ) ? $show_tags : NULL,
									'label' => __( 'Show Tags' , 'layerswp' )
								),
								'show_categories' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_categories' ) ,
									'id' => $this->get_field_id( 'show_categories' ) ,
									'value' => ( isset( $show_categories ) ) ? $show_categories : NULL,
									'label' => __( 'Show Categories' , 'layerswp' )
								),
								'show_call_to_action' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_call_to_action' ) ,
									'id' => $this->get_field_id( 'show_call_to_action' ) ,
									'value' => ( isset( $show_call_to_action ) ) ? $show_call_to_action : NULL,
									'label' => __( 'Show "Read More" Buttons' , 'layerswp' )
								),
                                'call_to_action' => array(
                                    'type' => 'text',
                                    'name' => $this->get_field_name( 'call_to_action' ) ,
                                    'id' => $this->get_field_id( 'call_to_action' ) ,
                                    'value' => ( isset( $call_to_action ) ) ? $call_to_action : NULL,
                                    'label' => __( '"Read More" Text' , 'layerswp' )
                                ),
								'show_pagination' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'show_pagination' ) ,
									'id' => $this->get_field_id( 'show_pagination' ) ,
									'value' => ( isset( $show_pagination ) ) ? $show_pagination : NULL,
									'label' => __( 'Show Pagination' , 'layerswp' )
								),
							)
					)
				)
			); ?>
			<!-- Form HTML Here -->

			<div class="layers-container-large">

				<?php $this->form_elements()->header( array(
					'title' =>  __( 'Post' , 'layerswp' ),
					'icon_class' =>'post'
				) ); ?>

				<section class="layers-accordion-section layers-content">

					<div class="layers-row layers-push-bottom">
						<p class="layers-form-item">
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'text',
									'name' => $this->get_field_name( 'title' ) ,
									'id' => $this->get_field_id( 'title' ) ,
									'placeholder' => __( 'Enter title here' , 'layerswp' ),
									'value' => ( isset( $title ) ) ? $title : NULL ,
									'class' => 'layers-text layers-large'
								)
							); ?>
						</p>

						<p class="layers-form-item">
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'textarea',
									'name' => $this->get_field_name( 'excerpt' ) ,
									'id' => $this->get_field_id( 'excerpt' ) ,
									'placeholder' => __( 'Short Excerpt' , 'layerswp' ),
									'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
									'class' => 'layers-textarea layers-large'
								)
							); ?>
						</p>
						<?php // Grab the terms as an array and loop 'em to generate the $options for the input
						$terms = get_terms( $this->taxonomy );
						if( !is_wp_error( $terms ) ) { ?>
							<p class="layers-form-item">
								<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php echo __( 'Category to Display' , 'layerswp' ); ?></label>
								<?php $category_options[ 0 ] ="All";
								foreach ( $terms as $t ) $category_options[ $t->term_id ] = $t->name;
								echo $this->form_elements()->input(
									array(
										'type' => 'select',
										'name' => $this->get_field_name( 'category' ) ,
										'id' => $this->get_field_id( 'category' ) ,
										'placeholder' => __( 'Select a Category' , 'layerswp' ),
										'value' => ( isset( $category ) ) ? $category : NULL ,
										'options' => $category_options
									)
								); ?>
							</p>
						<?php } // if !is_wp_error ?>
						<p class="layers-form-item">
							<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php echo __( 'Number of items to show' , 'layerswp' ); ?></label>
							<?php $select_options[ '-1' ] = __( 'Show All' , 'layerswp' );
							$select_options = $this->form_elements()->get_incremental_options( $select_options , 1 , 20 , 1);
							echo $this->form_elements()->input(
								array(
									'type' => 'number',
									'name' => $this->get_field_name( 'posts_per_page' ) ,
									'id' => $this->get_field_id( 'posts_per_page' ) ,
									'value' => ( isset( $posts_per_page ) ) ? $posts_per_page : NULL ,
									'min' => '-1',
									'max' => '100'
								)
							); ?>
						</p>

						<p class="layers-form-item">
							<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php echo __( 'Sort by' , 'layerswp' ); ?></label>
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'select',
									'name' => $this->get_field_name( 'order' ) ,
									'id' => $this->get_field_id( 'order' ) ,
									'value' => ( isset( $order ) ) ? $order : NULL ,
									'options' => $this->form_elements()->get_sort_options()
								)
							); ?>
						</p>
					</div>
				</section>

			</div>
		<?php } // Form
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Layers_Post_Widget");
}