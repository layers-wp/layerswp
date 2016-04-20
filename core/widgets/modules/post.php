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
			* @param  	string    		$widget_title    	Widget title
			* @param  	string    		$widget_id    		Widget slug for use as an ID/classname
			* @param  	string    		$post_type    		(optional) Post type for use in widget options
			* @param  	string    		$taxonomy    		(optional) Taxonomy slug for use as an ID/classname
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
			$widget_ops = array(

				'classname'   => 'obox-layers-' . $this->widget_id .'-widget',
				'description' => __( 'This widget is used to display your posts in a flexible grid.', 'layerswp' ),
			);

			/* Widget control settings. */
			$control_ops = array(
				'width'   => LAYERS_WIDGET_WIDTH_SMALL,
				'height'  => NULL,
				'id_base' => LAYERS_THEME_SLUG . '-widget-' . $this->widget_id,
			);

			/* Create the widget. */
			parent::__construct(
				LAYERS_THEME_SLUG . '-widget-' . $this->widget_id,
				$this->widget_title,
				$widget_ops,
				$control_ops
			);

			/* Setup Widget Defaults */
			$this->defaults = array (
				'title' => __( 'Latest Posts', 'layerswp' ),
				'excerpt' => __( 'Stay up to date with all our latest news and launches. Only the best quality makes it onto our blog!', 'layerswp' ),
				'text_style' => 'regular',
				'category' => 0,
				'show_media' => 'on',
				'show_titles' => 'on',
				'show_excerpts' => 'on',
				'show_dates' => 'on',
				'show_author' => 'on',
				'show_tags' => 'on',
				'show_categories' => 'on',
				'show_pagination' => 'on',
				'excerpt_length' => 200,
				'show_call_to_action' => 'on',
				'call_to_action' => __( 'Read More' , 'layerswp' ),
				'posts_per_page' => get_option( 'posts_per_page' ),
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
						'shadow' => NULL,
						'heading-type' => 'h3',
					),
					'buttons' => array(
						'buttons-size' => 'medium',
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

			// Enqueue Masonry if need be
			if( 'list-masonry' == $this->check_and_return( $instance , 'design', 'liststyle' ) ) $this->enqueue_masonry();

			// Set the span class for each column
			if( 'list-list' == $instance['design'][ 'liststyle' ] ) {
				$col_count = 1;
				$span_class = 'span-12';
			} else if( isset( $instance['design'][ 'columns']  ) ) {
				$col_count = str_ireplace('columns-', '', $instance['design'][ 'columns']  );
				$span_class = 'span-' . ( 12/ $col_count );
			} else {
				$col_count = 3;
				$span_class = 'span-4';
			}

			// Apply Styling
			$this->inline_css .= layers_inline_styles( '#' . $widget_id, 'background', array( 'background' => $instance['design'][ 'background' ] ) );
			$this->inline_css .= layers_inline_styles( '#' . $widget_id, 'color', array( 'selectors' => array( '.section-title .heading' , '.section-title div.excerpt' ) , 'color' => $instance['design']['fonts'][ 'color' ] ) );
			$this->inline_css .= layers_inline_styles( '#' . $widget_id, 'background', array( 'selectors' => array( '.thumbnail-body' ) , 'background' => array( 'color' => $this->check_and_return( $instance, 'design', 'column-background-color' ) ) ) );

			// Apply Button Styling.
			$button_size = '';
			if ( function_exists( 'layers_pro_apply_widget_button_styling' ) ) {
				// Apply Layers Pro Button Styling.
				$this->inline_css .= layers_pro_apply_widget_button_styling( $this, $instance, array( "#{$widget_id} .thumbnail-body a.button" ) );
				$button_size = $this->check_and_return( $instance, 'design', 'buttons-size' ) ? 'btn-' . $this->check_and_return( $instance, 'design', 'buttons-size' ) : '' ;
			}
			else {
				// Apply Button Styling.
				$this->inline_css .= layers_inline_button_styles( "#{$widget_id}", 'button', array( 'selectors' => array( '.thumbnail-body a.button' ) ,'button' => $this->check_and_return( $instance, 'design', 'buttons' ) ) );
			}

			// Set Image Sizes
			if( isset( $instance['design'][ 'imageratios' ] ) ){

				// Translate Image Ratio
				$image_ratio = layers_translate_image_ratios( $instance['design'][ 'imageratios' ] );

				if( 'layout-boxed' == $this->check_and_return( $instance , 'design', 'layout' ) && $col_count > 2 ){
					$use_image_ratio = $image_ratio . '-medium';
				} elseif( 'layout-boxed' != $this->check_and_return( $instance , 'design', 'layout' ) && $col_count > 3 ){
					$use_image_ratio = $image_ratio . '-large';
				} else {
					$use_image_ratio = $image_ratio . '-large';
				}
			} else {
				$use_image_ratio = 'large';
			}

			// Begin query arguments
			$query_args = array();
			if( get_query_var('paged') ) {
				$query_args[ 'paged' ] = get_query_var('paged') ;
			} else if ( get_query_var('page') ) {
				$query_args[ 'paged' ] = get_query_var('page');
			} else {
				$query_args[ 'paged' ] = 1;
			}

			$query_args[ 'post_type' ] = $this->post_type;
			$query_args[ 'posts_per_page' ] = $instance['posts_per_page'];
			if( isset( $instance['order'] ) ) {

				$decode_order = json_decode( $instance['order'], true );

				if( is_array( $decode_order ) ) {
					foreach( $decode_order as $key => $value ){
						$query_args[ $key ] = $value;
					}
				}
			}

			// Do the special taxonomy array()
			if( isset( $instance['category'] ) && '' != $instance['category'] && 0 != $instance['category'] ){

				$query_args['tax_query'] = array(
					array(
						"taxonomy" => $this->taxonomy,
						"field" => "id",
						"terms" => $instance['category']
					)
				);
			} elseif( !isset( $instance['hide_category_filter'] ) ) {
				$terms = get_terms( $this->taxonomy );
			} // if we haven't selected which category to show, let's load the $terms for use in the filter

			// Do the WP_Query
			$post_query = new WP_Query( $query_args );

			// Set the meta to display
			global $layers_post_meta_to_display;
			$layers_post_meta_to_display = array();
			if( isset( $instance['show_dates'] ) ) $layers_post_meta_to_display[] = 'date';
			if( isset( $instance['show_author'] ) ) $layers_post_meta_to_display[] = 'author';
			if( isset( $instance['show_categories'] ) ) $layers_post_meta_to_display[] = 'categories';
			if( isset( $instance['show_tags'] ) ) $layers_post_meta_to_display[] = 'tags';

			/**
			* Generate the widget container class
			*/
			$widget_container_class = array();

			$widget_container_class[] = 'widget';
			$widget_container_class[] = 'layers-post-widget';
			$widget_container_class[] = 'content-vertical-massive';
			$widget_container_class[] = 'clearfix';
			$widget_container_class[] = ( 'on' == $this->check_and_return( $instance , 'design', 'background', 'darken' ) ? 'darken' : '' );
			$widget_container_class[] = $this->check_and_return( $instance , 'design', 'advanced', 'customclass' ); // Apply custom class from design-bar's advanced control.
			$widget_container_class[] = $this->get_widget_spacing_class( $instance );

			$widget_container_class = apply_filters( 'layers_post_widget_container_class' , $widget_container_class, $this, $instance );
			$widget_container_class = implode( ' ', $widget_container_class ); ?>
			<?php echo $this->custom_anchor( $instance ); ?>
			<div id="<?php echo esc_attr( $widget_id ); ?>" class="<?php echo esc_attr( $widget_container_class ); ?>">

				<?php do_action( 'layers_before_post_widget_inner', $this, $instance ); ?>

				<?php if( '' != $this->check_and_return( $instance , 'title' ) ||'' != $this->check_and_return( $instance , 'excerpt' ) ) { ?>
					<div class="container clearfix">
						<?php /**
						* Generate the Section Title Classes
						*/
						$section_title_class = array();
						$section_title_class[] = 'section-title clearfix';
						$section_title_class[] = $this->check_and_return( $instance , 'design', 'fonts', 'size' );
						$section_title_class[] = $this->check_and_return( $instance , 'design', 'fonts', 'align' );
						$section_title_class[] = ( $this->check_and_return( $instance, 'design', 'background' , 'color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $instance, 'design', 'background' , 'color' ) ) ? 'invert' : '' );
						$section_title_class = implode( ' ', $section_title_class ); ?>
						<div class="<?php echo $section_title_class; ?>">
							<?php if( '' != $this->check_and_return( $instance, 'title' )  ) { ?>
								<<?php echo $this->check_and_return( $instance, 'design', 'fonts', 'heading-type' ); ?> class="heading">
									<?php echo $instance['title'] ?>
								</<?php echo $this->check_and_return( $instance, 'design', 'fonts', 'heading-type' ); ?>>
							<?php } ?>
							<?php if( '' != $this->check_and_return( $instance, 'excerpt' )  ) { ?>
								<div class="excerpt"><?php echo layers_the_content( $instance['excerpt'] ); ?></div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<?php if( $post_query->have_posts() ) { ?>
					<div class="<?php echo $this->get_widget_layout_class( $instance ); ?> <?php echo $this->check_and_return( $instance , 'design', 'liststyle' ); ?>">
						<div class="grid">
								<?php while( $post_query->have_posts() ) {
									$post_query->the_post();

									if( 'list-list' == $instance['design'][ 'liststyle' ] ) { ?>
										<article id="post-<?php the_ID(); ?>" class="clearfix push-bottom-large">
											<?php if( isset( $instance['show_titles'] ) ) { ?>
												<header class="section-title large">
													<h1 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
												</header>
											<?php } ?>

											<?php // Layers Featured Media );
											if( isset( $instance['show_media'] ) ) {
												echo layers_post_featured_media(
													array(
														'postid' => get_the_ID(),
														'wrap_class' => 'thumbnail push-bottom span-5 column' .  ( 'image-round' == $this->check_and_return( $instance, 'design', 'imageratios' ) ? ' image-rounded' : '' ),
														'size' => $use_image_ratio
													)
												);
											} // if Show Media ?>

											<?php if( isset( $instance['show_excerpts'] ) || $instance['show_call_to_action'] || ! empty( $layers_post_meta_to_display ) ) { ?>
												<div class="column span-7">
													<?php if( isset( $instance['show_excerpts'] ) ) {
														if( isset( $instance['excerpt_length'] ) && '' == $instance['excerpt_length'] ) {
															echo '<div class="copy push-bottom">';
																the_content();
															echo '</div>';
														} else if( isset( $instance['excerpt_length'] ) && 0 != $instance['excerpt_length'] && strlen( get_the_excerpt() ) > $instance['excerpt_length'] ){
															echo '<div class="copy push-bottom">' . substr( get_the_excerpt() , 0 , $instance['excerpt_length'] ) . '&#8230;</div>';
														} else if( '' != get_the_excerpt() ){
															echo '<div class="copy push-bottom">' . get_the_excerpt() . '</div>';
														}
													}; ?>

													<?php layers_post_meta( get_the_ID(), $layers_post_meta_to_display, 'footer' , 'meta-info push-bottom ' . ( '' != $this->check_and_return( $instance, 'design', 'column-background-color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $instance, 'design', 'column-background-color' ) ) ? 'invert' : '' ) );?>

													<?php if( isset( $instance['show_call_to_action'] ) && $this->check_and_return( $instance , 'call_to_action' ) ) { ?>
														<p><a href="<?php the_permalink(); ?>" class="button <?php echo $button_size; ?>"><?php echo $instance['call_to_action']; ?></a></p>
													<?php } // show call to action ?>
												</div>
											<?php } ?>
										</article>
									<?php } else {
										/**
										* Set Individual Column CSS
										*/
										$post_column_class = array();
										$post_column_class[] = 'layers-masonry-column';
										$post_column_class[] = 'thumbnail';
										$post_column_class[] = ( 'list-masonry' == $this->check_and_return( $instance, 'design', 'liststyle' ) ? 'no-gutter' : '' );
										$post_column_class[] = 'column' . ( 'on' != $this->check_and_return( $instance, 'design', 'gutter' ) ? '-flush' : '' );
										$post_column_class[] = $span_class;
										$post_column_class[] = ( 'overlay' == $this->check_and_return( $instance , 'text_style' ) ? 'with-overlay' : ''  ) ;
										$post_column_class[] = ( '' != $this->check_and_return( $instance, 'design', 'column-background-color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $instance, 'design', 'column-background-color' ) ) ? 'invert' : '' );
										$post_column_class = implode( ' ' , $post_column_class ); ?>

										<article class="<?php echo $post_column_class; ?>" data-cols="<?php echo $col_count; ?>">
											<?php // Layers Featured Media
											if( isset( $instance['show_media'] ) ) {
												echo layers_post_featured_media(
													array(
														'postid' => get_the_ID(),
														'wrap_class' => 'thumbnail-media' .  ( ( 'image-round' == $this->check_and_return( $instance, 'design', 'imageratios' ) ) ? ' image-rounded' : '' ),
														'size' => $use_image_ratio,
														'hide_href' => false
													)
												);
											} // if Show Media ?>
											<?php if( isset( $instance['show_titles'] ) || isset( $instance['show_excerpts'] ) ) { ?>
												<div class="thumbnail-body">
													<div class="overlay">
														<?php if( isset( $instance['show_titles'] ) ) { ?>
															<header class="article-title">
																<h4 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
															</header>
														<?php } ?>
														<?php if( isset( $instance['show_excerpts'] ) ) {
															if( isset( $instance['excerpt_length'] ) && '' == $instance['excerpt_length'] ) {
																echo '<div class="excerpt">';
																	the_content();
																echo '</div>';
															} else if( isset( $instance['excerpt_length'] ) && 0 != $instance['excerpt_length'] && strlen( get_the_excerpt() ) > $instance['excerpt_length'] ){
																echo '<div class="excerpt">' . substr( get_the_excerpt() , 0 , $instance['excerpt_length'] ) . '&#8230;</div>';
															} else if( '' != get_the_excerpt() ){
																echo '<div class="excerpt">' . get_the_excerpt() . '</div>';
															}
														}; ?>
														<?php if( 'overlay' != $this->check_and_return( $instance, 'text_style' ) ) { ?>
															<?php layers_post_meta( get_the_ID(), $layers_post_meta_to_display, 'footer' , 'meta-info ' . ( '' != $this->check_and_return( $instance, 'design', 'column-background-color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $instance, 'design', 'column-background-color' ) ) ? 'invert' : '' ) );?>
														<?php } // Don't show meta if we have chosen overlay ?>
														<?php if( isset( $instance['show_call_to_action'] ) && $this->check_and_return( $instance , 'call_to_action' ) ) { ?>
															<a href="<?php the_permalink(); ?>" class="button <?php echo $button_size; ?>"><?php echo $instance['call_to_action']; ?></a>
														<?php } // show call to action ?>
													</div>
												</div>
											<?php } // if show titles || show excerpt ?>
										</article>
									<?php }; // if list-list == liststyle ?>
								<?php }; // while have_posts ?>
						</div><!-- /row -->
					</div>
				<?php }; // if have_posts ?>
				<?php if( isset( $instance['show_pagination'] ) ) { ?>
					<div class="container">
						<?php layers_pagination( array( 'query' => $post_query ), 'div', 'pagination clearfix' ); ?>
					</div>
				<?php } ?>

				<?php do_action( 'layers_after_post_widget_inner', $this, $instance );

				// Print the Inline Styles for this Widget
				$this->print_inline_css();

				if( 'list-masonry' == $this->check_and_return( $instance , 'design', 'liststyle' ) ) { ?>
					<script type='text/javascript'>
						jQuery(function($){
							layers_masonry_settings[ '<?php echo $widget_id; ?>' ] = [{
									itemSelector: '.layers-masonry-column',
									gutter: <?php echo ( isset( $instance['design'][ 'gutter' ] ) ? 20 : 0 ); ?>
								}];

							$('#<?php echo $widget_id; ?>').find('.list-masonry').layers_masonry( layers_masonry_settings[ '<?php echo $widget_id; ?>' ][0] );
						});
					</script>
				<?php } // masonry trigger ?>

			</div>

			<?php // Reset WP_Query
			wp_reset_postdata();

			// Apply the advanced widget styling
			$this->apply_widget_advanced_styling( $widget_id, $instance );

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
				apply_filters( 'layers_post_widget_design_bar_components' , array( // Components
					'layout',
					'display' => array(
						'icon-css' => 'icon-display',
						'label' => __( 'Display', 'layerswp' ),
						'elements' => array(
							'text_style' => array(
								'type' => 'select',
								'name' => $this->get_layers_field_name( 'text_style' ) ,
								'id' => $this->get_layers_field_id( 'text_style' ) ,
								'value' => ( isset( $instance['text_style'] ) ) ? $instance['text_style'] : NULL,
								'label' => __( 'Title &amp; Excerpt Position' , 'layerswp' ),
								'options' => array(
										'regular' => __( 'Regular' , 'layerswp' ),
										'overlay' => __( 'Overlay' , 'layerswp' )
								)
							),
							'show_pagination' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_pagination' ) ,
								'id' => $this->get_layers_field_id( 'show_pagination' ) ,
								'value' => ( isset( $instance['show_pagination'] ) ) ? $instance['show_pagination'] : NULL,
								'label' => __( 'Show Pagination' , 'layerswp' )
							),
							'show_media' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_media' ) ,
								'id' => $this->get_layers_field_id( 'show_media' ) ,
								'value' => ( isset( $instance['show_media'] ) ) ? $instance['show_media'] : NULL,
								'label' => __( 'Show Featured Images' , 'layerswp' )
							),
							'show_titles' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_titles' ) ,
								'id' => $this->get_layers_field_id( 'show_titles' ) ,
								'value' => ( isset( $instance['show_titles'] ) ) ? $instance['show_titles'] : NULL,
								'label' => __( 'Show  Post Titles' , 'layerswp' )
							),
							'show_excerpts' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_excerpts' ) ,
								'id' => $this->get_layers_field_id( 'show_excerpts' ) ,
								'value' => ( isset( $instance['show_excerpts'] ) ) ? $instance['show_excerpts'] : NULL,
								'label' => __( 'Show Post Excerpts' , 'layerswp' ),
								'data' => array(
									'show-if-selector' => '#' . $this->get_layers_field_id( 'text_style' ),
									'show-if-value' => 'overlay',
									'show-if-operator' => '!='
								),
							),
							'excerpt_length' => array(
								'type' => 'number',
								'name' => $this->get_layers_field_name( 'excerpt_length' ) ,
								'id' => $this->get_layers_field_id( 'excerpt_length' ) ,
								'min' => 0,
								'max' => 10000,
								'value' => ( isset( $instance['excerpt_length'] ) ) ? $instance['excerpt_length'] : NULL,
								'label' => __( 'Excerpts Length' , 'layerswp' ),
								'data' => array( 'show-if-selector' => '#' . $this->get_layers_field_id( 'show_excerpts' ), 'show-if-value' => 'true' ),
							),
							'show_dates' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_dates' ) ,
								'id' => $this->get_layers_field_id( 'show_dates' ) ,
								'value' => ( isset( $instance['show_dates'] ) ) ? $instance['show_dates'] : NULL,
								'label' => __( 'Show Post Dates' , 'layerswp' ),
								'data' => array(
									'show-if-selector' => '#' . $this->get_layers_field_id( 'text_style' ),
									'show-if-value' => 'overlay',
									'show-if-operator' => '!='
								),
							),
							'show_author' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_author' ) ,
								'id' => $this->get_layers_field_id( 'show_author' ) ,
								'value' => ( isset( $instance['show_author'] ) ) ? $instance['show_author'] : NULL,
								'label' => __( 'Show Post Author' , 'layerswp' ),
								'data' => array(
									'show-if-selector' => '#' . $this->get_layers_field_id( 'text_style' ),
									'show-if-value' => 'overlay',
									'show-if-operator' => '!='
								),
							),
							'show_tags' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_tags' ) ,
								'id' => $this->get_layers_field_id( 'show_tags' ) ,
								'value' => ( isset( $instance['show_tags'] ) ) ? $instance['show_tags'] : NULL,
								'label' => __( 'Show Tags' , 'layerswp' ),
								'data' => array(
									'show-if-selector' => '#' . $this->get_layers_field_id( 'text_style' ),
									'show-if-value' => 'overlay',
									'show-if-operator' => '!='
								),
							),
							'show_categories' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_categories' ) ,
								'id' => $this->get_layers_field_id( 'show_categories' ) ,
								'value' => ( isset( $instance['show_categories'] ) ) ? $instance['show_categories'] : NULL,
								'label' => __( 'Show Categories' , 'layerswp' ),
								'data' => array(
									'show-if-selector' => '#' . $this->get_layers_field_id( 'text_style' ),
									'show-if-value' => 'overlay',
									'show-if-operator' => '!='
								),
							),
							'show_call_to_action' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_call_to_action' ) ,
								'id' => $this->get_layers_field_id( 'show_call_to_action' ) ,
								'value' => ( isset( $instance['show_call_to_action'] ) ) ? $instance['show_call_to_action'] : NULL,
								'label' => __( 'Show "Read More" Buttons' , 'layerswp' ),
							),
							'call_to_action' => array(
								'type' => 'text',
								'name' => $this->get_layers_field_name( 'call_to_action' ) ,
								'id' => $this->get_layers_field_id( 'call_to_action' ) ,
								'value' => ( isset( $instance['call_to_action'] ) ) ? $instance['call_to_action'] : NULL,
								'label' => __( '"Read More" Text' , 'layerswp' ),
								'data' => array( 'show-if-selector' => '#' . $this->get_layers_field_id( 'show_call_to_action' ), 'show-if-value' => 'true' ),
							),
						),
					),
					'columns',
					'buttons',
					'liststyle',
					'imageratios',
					'background',
					'advanced',
				), $this, $instance )
			); ?>
			<div class="layers-container-large">

				<?php $this->form_elements()->header( array(
					'title' =>  __( 'Post' , 'layerswp' ),
					'icon_class' =>'post'
				) ); ?>

				<section class="layers-accordion-section layers-content">

					<div class="layers-row layers-push-bottom">
						<div class="layers-form-item">

							<?php echo $this->form_elements()->input(
								array(
									'type' => 'text',
									'name' => $this->get_layers_field_name( 'title' ) ,
									'id' => $this->get_layers_field_id( 'title' ) ,
									'placeholder' => __( 'Enter title here' , 'layerswp' ),
									'value' => ( isset( $instance['title'] ) ) ? $instance['title'] : NULL,
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
								apply_filters( 'layers_post_widget_inline_design_bar_components', array( // Components
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
									'placeholder' => __( 'Short Excerpt' , 'layerswp' ),
									'value' => ( isset( $instance['excerpt'] ) ) ? $instance['excerpt'] : NULL,
									'class' => 'layers-textarea layers-large'
								)
							); ?>

						</div>
						<?php // Grab the terms as an array and loop 'em to generate the $options for the input
						$terms = get_terms( $this->taxonomy , array( 'hide_empty' => false ) );
						if( !is_wp_error( $terms ) ) { ?>
							<p class="layers-form-item">
								<label for="<?php echo $this->get_layers_field_id( 'category' ); ?>"><?php echo __( 'Category to Display' , 'layerswp' ); ?></label>
								<?php $category_options[ 0 ] = __( 'All' , 'layerswp' );
								foreach ( $terms as $t ) $category_options[ $t->term_id ] = $t->name;
								echo $this->form_elements()->input(
									array(
										'type' => 'select',
										'name' => $this->get_layers_field_name( 'category' ) ,
										'id' => $this->get_layers_field_id( 'category' ) ,
										'placeholder' => __( 'Select a Category' , 'layerswp' ),
										'value' => ( isset( $instance['category'] ) ) ? $instance['category'] : NULL,
										'options' => $category_options,
									)
								); ?>
							</p>
						<?php } // if !is_wp_error ?>
						<p class="layers-form-item">
							<label for="<?php echo $this->get_layers_field_id( 'posts_per_page' ); ?>"><?php echo __( 'Number of items to show' , 'layerswp' ); ?></label>
							<?php $select_options[ '-1' ] = __( 'Show All' , 'layerswp' );
							$select_options = $this->form_elements()->get_incremental_options( $select_options , 1 , 20 , 1);
							echo $this->form_elements()->input(
								array(
									'type' => 'number',
									'name' => $this->get_layers_field_name( 'posts_per_page' ) ,
									'id' => $this->get_layers_field_id( 'posts_per_page' ) ,
									'value' => ( isset( $instance['posts_per_page'] ) ) ? $instance['posts_per_page'] : NULL,
									'min' => '-1',
									'max' => '100'
								)
							); ?>
						</p>

						<p class="layers-form-item">
							<label for="<?php echo $this->get_layers_field_id( 'order' ); ?>"><?php echo __( 'Sort by' , 'layerswp' ); ?></label>
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'select',
									'name' => $this->get_layers_field_name( 'order' ) ,
									'id' => $this->get_layers_field_id( 'order' ) ,
									'value' => ( isset( $instance['order'] ) ) ? $instance['order'] : NULL,
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