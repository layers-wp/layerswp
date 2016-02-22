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
				'description' => __( 'This widget is used to display your ', 'layerswp' ) . $this->widget_title . '.',
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
						'shadow' => NULL
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

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// If we have information in this widget, then ignore the defaults
			if( !empty( $instance ) ) $instance_defaults = array();

			// Parse $instance
			$widget = wp_parse_args( $instance, $instance_defaults );

			// Enqueue Masonry if need be
			if( 'list-masonry' == $this->check_and_return( $widget , 'design', 'liststyle' ) ) $this->enqueue_masonry();

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

			// Apply Styling
			$this->inline_css .= layers_inline_styles( '#' . $widget_id, 'background', array( 'background' => $widget['design'][ 'background' ] ) );
			$this->inline_css .= layers_inline_styles( '#' . $widget_id, 'color', array( 'selectors' => array( '.section-title h3.heading' , '.section-title div.excerpt' ) , 'color' => $widget['design']['fonts'][ 'color' ] ) );
			$this->inline_css .= layers_inline_styles( '#' . $widget_id, 'background', array( 'selectors' => array( '.thumbnail-body' ) , 'background' => array( 'color' => $this->check_and_return( $widget, 'design', 'column-background-color' ) ) ) );
			$this->inline_css .= layers_inline_button_styles( '#' . $widget_id, 'button', array( 'selectors' => array( '.thumbnail-body a.button' ) ,'button' => $this->check_and_return( $widget, 'design', 'buttons' ) ) );

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
			if( get_query_var('paged') ) {
				$query_args[ 'paged' ] = get_query_var('paged') ;
			} else if ( get_query_var('page') ) {
				$query_args[ 'paged' ] = get_query_var('page');
			} else {
				$query_args[ 'paged' ] = 1;
			}

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
			if( isset( $widget['show_tags'] ) ) $layers_post_meta_to_display[] = 'tags';

			/**
			* Generate the widget container class
			*/
			$widget_container_class = array();
			$widget_container_class[] = 'widget';
			$widget_container_class[] = 'layers-post-widget';
			$widget_container_class[] = 'row';
			$widget_container_class[] = 'content-vertical-massive';
			$widget_container_class[] = $this->check_and_return( $widget , 'design', 'advanced', 'customclass' ); // Apply custom class from design-bar's advanced control.
			$widget_container_class[] = $this->get_widget_spacing_class( $widget );
			$widget_container_class = implode( ' ', apply_filters( 'layers_post_widget_container_class' , $widget_container_class ) ); ?>
			<?php echo $this->custom_anchor( $widget ); ?>
			<section id="<?php echo esc_attr( $widget_id ); ?>" class="<?php echo esc_attr( $widget_container_class ); ?>">

				<?php do_action( 'layers_before_post_widget_inner', $this, $widget ); ?>

				<?php if( '' != $this->check_and_return( $widget , 'title' ) ||'' != $this->check_and_return( $widget , 'excerpt' ) ) { ?>
					<div class="container clearfix">
						<?php /**
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
								<h3 class="heading"><?php echo $widget['title'] ?></h3>
							<?php } ?>
							<?php if( '' != $widget['excerpt'] ) { ?>
								<div class="excerpt"><?php echo $widget['excerpt']; ?></div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<div class="row <?php echo $this->get_widget_layout_class( $widget ); ?> <?php echo $this->check_and_return( $widget , 'design', 'liststyle' ); ?>">
					<?php if( $post_query->have_posts() ) { ?>
						<?php while( $post_query->have_posts() ) {
							$post_query->the_post();

							if( 'list-list' == $widget['design'][ 'liststyle' ] ) { ?>
								<article id="post-<?php the_ID(); ?>" class="row push-bottom-large">
									<?php if( isset( $widget['show_titles'] ) ) { ?>
										<header class="section-title large">
											<h1 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
										</header>
									<?php } ?>

									<?php // Layers Featured Media );
									if( isset( $widget['show_media'] ) ) {
										echo layers_post_featured_media(
											array(
												'postid' => get_the_ID(),
												'wrap_class' => 'thumbnail push-bottom span-5 column' .  ( 'image-round' == $this->check_and_return( $widget, 'design', 'imageratios' ) ? ' image-rounded' : '' ),
												'size' => $use_image_ratio
											)
										);
									} // if Show Media ?>

									<?php if( isset( $widget['show_excerpts'] ) || $widget['show_call_to_action'] || ! empty( $layers_post_meta_to_display ) ) { ?>
										<div class="column span-7">
											<?php if( isset( $widget['show_excerpts'] ) ) {
												if( isset( $widget['excerpt_length'] ) && '' == $widget['excerpt_length'] ) {
													echo '<div class="copy push-bottom">';
														the_content();
													echo '</div>';
												} else if( isset( $widget['excerpt_length'] ) && 0 != $widget['excerpt_length'] && strlen( get_the_excerpt() ) > $widget['excerpt_length'] ){
													echo '<div class="copy push-bottom">' . substr( get_the_excerpt() , 0 , $widget['excerpt_length'] ) . '&#8230;</div>';
												} else if( '' != get_the_excerpt() ){
													echo '<div class="copy push-bottom">' . get_the_excerpt() . '</div>';
												}
											}; ?>

											<?php layers_post_meta( get_the_ID(), $layers_post_meta_to_display, 'footer' , 'meta-info push-bottom ' . ( '' != $this->check_and_return( $widget, 'design', 'column-background-color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $widget, 'design', 'column-background-color' ) ) ? 'invert' : '' ) );?>

											<?php if( isset( $widget['show_call_to_action'] ) && $this->check_and_return( $widget , 'call_to_action' ) ) { ?>
												<p><a href="<?php the_permalink(); ?>" class="button"><?php echo $widget['call_to_action']; ?></a></p>
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
								$post_column_class[] = ( 'list-masonry' == $this->check_and_return( $widget, 'design', 'liststyle' ) ? 'no-gutter' : '' );
								$post_column_class[] = 'column' . ( 'on' != $this->check_and_return( $widget, 'design', 'gutter' ) ? '-flush' : '' );
								$post_column_class[] = $span_class;
								$post_column_class[] = ( 'overlay' == $this->check_and_return( $widget , 'text_style' ) ? 'with-overlay' : ''  ) ;
								$post_column_class[] = ( '' != $this->check_and_return( $widget, 'design', 'column-background-color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $widget, 'design', 'column-background-color' ) ) ? 'invert' : '' );
								$post_column_class = implode( ' ' , $post_column_class ); ?>

								<article class="<?php echo $post_column_class; ?>" data-cols="<?php echo $col_count; ?>">
									<?php // Layers Featured Media
									if( isset( $widget['show_media'] ) ) {
										echo layers_post_featured_media(
											array(
												'postid' => get_the_ID(),
												'wrap_class' => 'thumbnail-media' .  ( ( 'image-round' == $this->check_and_return( $widget, 'design', 'imageratios' ) ) ? ' image-rounded' : '' ),
												'size' => $use_image_ratio,
												'hide_href' => false
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
														echo '<div class="excerpt">' . substr( get_the_excerpt() , 0 , $widget['excerpt_length'] ) . '&#8230;</div>';
													} else if( '' != get_the_excerpt() ){
														echo '<div class="excerpt">' . get_the_excerpt() . '</div>';
													}
												}; ?>
												<?php if( 'overlay' != $this->check_and_return( $widget, 'text_style' ) ) { ?>
													<?php layers_post_meta( get_the_ID(), $layers_post_meta_to_display, 'footer' , 'meta-info ' . ( '' != $this->check_and_return( $widget, 'design', 'column-background-color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $widget, 'design', 'column-background-color' ) ) ? 'invert' : '' ) );?>
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
				</div>
				<?php if( isset( $widget['show_pagination'] ) ) { ?>
					<div class="row products container list-grid">
						<?php layers_pagination( array( 'query' => $post_query ), 'div', 'pagination row span-12 text-center' ); ?>
					</div>
				<?php } ?>

				<?php do_action( 'layers_after_post_widget_inner', $this, $widget );

				// Print the Inline Styles for this Widget
				$this->print_inline_css();

				if( 'list-masonry' == $this->check_and_return( $widget , 'design', 'liststyle' ) ) { ?>
					<script type='text/javascript'>
						jQuery(function($){
							layers_masonry_settings[ '<?php echo $widget_id; ?>' ] = [{
									itemSelector: '.layers-masonry-column',
									gutter: <?php echo ( isset( $widget['design'][ 'gutter' ] ) ? 20 : 0 ); ?>
								}];

							$('#<?php echo $widget_id; ?>').find('.list-masonry').layers_masonry( layers_masonry_settings[ '<?php echo $widget_id; ?>' ][0] );
						});
					</script>
				<?php } // masonry trigger ?>

				</section>

			<?php // Reset WP_Query
			wp_reset_postdata();

			// Apply the advanced widget styling
			$this->apply_widget_advanced_styling( $widget_id, $widget );

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
				apply_filters( 'layers_post_widget_design_bar_components' , array( // Components
					'layout',
					'fonts',
					'display' => array(
						'icon-css' => 'icon-display',
						'label' => __( 'Display', 'layerswp' ),
						'elements' => array(
							'text_style' => array(
								'type' => 'select',
								'name' => $this->get_layers_field_name( 'text_style' ) ,
								'id' => $this->get_layers_field_id( 'text_style' ) ,
								'value' => ( isset( $widget['text_style'] ) ) ? $widget['text_style'] : NULL,
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
								'value' => ( isset( $widget['show_pagination'] ) ) ? $widget['show_pagination'] : NULL,
								'label' => __( 'Show Pagination' , 'layerswp' )
							),
							'show_media' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_media' ) ,
								'id' => $this->get_layers_field_id( 'show_media' ) ,
								'value' => ( isset( $widget['show_media'] ) ) ? $widget['show_media'] : NULL,
								'label' => __( 'Show Featured Images' , 'layerswp' )
							),
							'show_titles' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_titles' ) ,
								'id' => $this->get_layers_field_id( 'show_titles' ) ,
								'value' => ( isset( $widget['show_titles'] ) ) ? $widget['show_titles'] : NULL,
								'label' => __( 'Show  Post Titles' , 'layerswp' )
							),
							'show_excerpts' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_excerpts' ) ,
								'id' => $this->get_layers_field_id( 'show_excerpts' ) ,
								'value' => ( isset( $widget['show_excerpts'] ) ) ? $widget['show_excerpts'] : NULL,
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
								'value' => ( isset( $widget['excerpt_length'] ) ) ? $widget['excerpt_length'] : NULL,
								'label' => __( 'Excerpts Length' , 'layerswp' ),
								'data' => array( 'show-if-selector' => '#' . $this->get_layers_field_id( 'show_excerpts' ), 'show-if-value' => 'true' ),
							),
							'show_dates' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_dates' ) ,
								'id' => $this->get_layers_field_id( 'show_dates' ) ,
								'value' => ( isset( $widget['show_dates'] ) ) ? $widget['show_dates'] : NULL,
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
								'value' => ( isset( $widget['show_author'] ) ) ? $widget['show_author'] : NULL,
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
								'value' => ( isset( $widget['show_tags'] ) ) ? $widget['show_tags'] : NULL,
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
								'value' => ( isset( $widget['show_categories'] ) ) ? $widget['show_categories'] : NULL,
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
								'value' => ( isset( $widget['show_call_to_action'] ) ) ? $widget['show_call_to_action'] : NULL,
								'label' => __( 'Show "Read More" Buttons' , 'layerswp' ),
							),
							'call_to_action' => array(
								'type' => 'text',
								'name' => $this->get_layers_field_name( 'call_to_action' ) ,
								'id' => $this->get_layers_field_id( 'call_to_action' ) ,
								'value' => ( isset( $widget['call_to_action'] ) ) ? $widget['call_to_action'] : NULL,
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
				) )
			); ?>
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
									'name' => $this->get_layers_field_name( 'title' ) ,
									'id' => $this->get_layers_field_id( 'title' ) ,
									'placeholder' => __( 'Enter title here' , 'layerswp' ),
									'value' => ( isset( $widget['title'] ) ) ? $widget['title'] : NULL,
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
									'placeholder' => __( 'Short Excerpt' , 'layerswp' ),
									'value' => ( isset( $widget['excerpt'] ) ) ? $widget['excerpt'] : NULL,
									'class' => 'layers-textarea layers-large'
								)
							); ?>
						</p>
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
										'value' => ( isset( $widget['category'] ) ) ? $widget['category'] : NULL,
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
									'value' => ( isset( $widget['posts_per_page'] ) ) ? $widget['posts_per_page'] : NULL,
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
									'value' => ( isset( $widget['order'] ) ) ? $widget['order'] : NULL,
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