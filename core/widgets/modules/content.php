<?php  /**
 * Content Widget
 *
 * This file is used to register and display the Layers - Content widget.
 *
 * @package Layers
 * @since Layers 1.0.0
 */
if( !class_exists( 'Layers_Content_Widget' ) ) {
	class Layers_Content_Widget extends Layers_Widget {

		/**
		*  Widget construction
		*/
		function Layers_Content_Widget(){

			/**
			* Widget variables
			*
			* @param  	string    		$widget_title    	Widget title
			* @param  	string    		$widget_id    		Widget slug for use as an ID/classname
			* @param  	string    		$post_type    		(optional) Post type for use in widget options
			* @param  	string    		$taxonomy    		(optional) Taxonomy slug for use as an ID/classname
			* @param  	array 			$checkboxes    	(optional) Array of checkbox names to be saved in this widget. Don't forget these please!
			*/
			$this->widget_title = __( 'Content' , 'layerswp' );
			$this->widget_id = 'column';
			$this->post_type = '';
			$this->taxonomy = '';
			$this->checkboxes = array();

			/* Widget settings. */
			$widget_ops = array(

				'classname'   => 'obox-layers-' . $this->widget_id .'-widget',
				'description' => __( 'This widget is used to display text and images in a flexible grid.', 'layerswp' ),
			);

			/* Widget control settings. */
			$control_ops = array(
				'width'   => LAYERS_WIDGET_WIDTH_LARGE,
				'height'  => NULL,
				'id_base' => LAYERS_THEME_SLUG . '-widget-' . $this->widget_id,
			);

			/* Create the widget. */
			parent::__construct(
				LAYERS_THEME_SLUG . '-widget-' . $this->widget_id ,
				$this->widget_title,
				$widget_ops,
				$control_ops
			);

			/* Setup Widget Defaults */
			$this->defaults = array (
				'title' => __( 'Our Services', 'layerswp' ),
				'excerpt' => __( 'Our services run deep and are backed by over ten years of experience.', 'layerswp' ),
				'design' => array(
					'layout' => 'layout-boxed',
					'liststyle' => 'list-grid',
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
					)
				),
			);

			/* Setup Widget Repeater Defaults */
			$this->register_repeater_defaults( 'column', 3, array(
				'title' => __( 'Your service title', 'layerswp' ),
				'excerpt' => __( 'Give us a brief description of the service that you are promoting. Try keep it short so that it is easy for people to scan your page.', 'layerswp' ),
				'width' => '4',
				'design' => array(
					'featuredimage-size' => '',
					'imagealign' => 'image-top',
					'background' => NULL,
					'fonts' => array(
						'align' => 'text-left',
						'size' => 'medium',
						'color' => NULL,
						'shadow' => NULL,
						'heading-type' => 'h5',
					),
				),
			) );
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

			// Set the background styling
			if( !empty( $instance['design'][ 'background' ] ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id, 'background', array( 'background' => $instance['design'][ 'background' ] ) );
			if( !empty( $instance['design']['fonts'][ 'color' ] ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id, 'color', array( 'selectors' => array( '.section-title .heading' , '.section-title div.excerpt' ) , 'color' => $instance['design']['fonts'][ 'color' ] ) );

			/**
			* Generate the widget container class
			*/
			$widget_container_class = array();
			$widget_container_class[] = 'widget';
			$widget_container_class[] = 'layers-content-widget';
			$widget_container_class[] = 'content-vertical-massive';
			$widget_container_class[] = ( 'on' == $this->check_and_return( $instance , 'design', 'background', 'darken' ) ? 'darken' : '' );
			$widget_container_class[] = $this->check_and_return( $instance , 'design', 'advanced', 'customclass' ); // Apply custom class from design-bar's advanced control.
			$widget_container_class[] = $this->get_widget_spacing_class( $instance );

			$widget_container_class = apply_filters( 'layers_content_widget_container_class' , $widget_container_class, $this, $instance );
			$widget_container_class = implode( ' ', $widget_container_class ); ?>

			<?php echo $this->custom_anchor( $instance ); ?>
			<div id="<?php echo esc_attr( $widget_id ); ?>" class="<?php echo esc_attr( $widget_container_class ); ?>">

				<?php do_action( 'layers_before_content_widget_inner', $this, $instance ); ?>

				<?php if ( NULL !== $this->check_and_return( $instance , 'title' ) || NULL !== $this->check_and_return( $instance , 'excerpt' ) ) { ?>

					<div class="container clearfix">
						<?php
						/**
						* Generate the Section Title Classes
						*/
						$section_title_class = array();
						$section_title_class[] = 'section-title clearfix';
						$section_title_class[] = $this->check_and_return( $instance , 'design', 'fonts', 'size' );
						$section_title_class[] = $this->check_and_return( $instance , 'design', 'fonts', 'align' );
						$section_title_class[] = ( $this->check_and_return( $instance, 'design', 'background' , 'color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $instance, 'design', 'background' , 'color' ) ) ? 'invert' : '' );
						$section_title_class = implode( ' ', $section_title_class );
						?>
						<div class="<?php echo $section_title_class; ?>">
							<?php if( '' != $this->check_and_return( $instance, 'title' ) ) { ?>
								<<?php echo $this->check_and_return( $instance, 'design', 'fonts', 'heading-type' ); ?> class="heading">
									<?php echo $instance['title'] ?>
								</<?php echo $this->check_and_return( $instance, 'design', 'fonts', 'heading-type' ); ?>>
							<?php } ?>
							<?php if( '' != $this->check_and_return( $instance, 'excerpt' ) ) { ?>
								<div class="excerpt"><?php echo layers_the_content( $instance['excerpt'] ); ?></div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<?php if ( ! empty( $instance[ 'columns' ] ) ) {

					$column_ids = explode( ',', $instance[ 'column_ids' ] );

					// Set total width
					$col_no = 0;
					$first_last_class = '';
					$row_width = 0; ?>
					<div class="<?php echo $this->get_widget_layout_class( $instance ); ?> <?php echo $this->check_and_return( $instance , 'design', 'liststyle' ); ?>">
						<div class="grid">
							<?php foreach ( $column_ids as $column_key ) {

								// Make sure we've got a column going on here
								if( !isset( $instance[ 'columns' ][ $column_key ] ) ) continue;

								// Setup Internal Vars.
								$item_instance = $instance[ 'columns' ][ $column_key ];
								$item_id_attr  = "{$widget_id}-tabs-{$column_key}";
								
								// Mix in new/unset defaults on every instance load (NEW)
								$item_instance = $this->apply_defaults( $item_instance, 'column' );
								
								// Get the Next Column for use later.
								if( isset( $column_ids[ ($col_no+1) ] ) ) {
									$next_item = $instance[ 'columns' ][ $column_ids[ ($col_no+1) ] ];
								}
								
								// Set the background styling
								if( !empty( $item_instance['design'][ 'background' ] ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id . '-' . $column_key , 'background', array( 'background' => $item_instance['design'][ 'background' ] ) );
								if( !empty( $item_instance['design']['fonts'][ 'color' ] ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id . '-' . $column_key , 'color', array( 'selectors' => array( '.heading a', '.heading' , 'div.excerpt' , 'div.excerpt p' ) , 'color' => $item_instance['design']['fonts'][ 'color' ] ) );
								if( !empty( $item_instance['design']['fonts'][ 'shadow' ] ) ) $this->inline_css .= layers_inline_styles( '#' . $widget_id . '-' . $column_key , 'text-shadow', array( 'selectors' => array( '.heading a', '.heading' , 'div.excerpt' , 'div.excerpt p' )  , 'text-shadow' => $item_instance['design']['fonts'][ 'shadow' ] ) );

								// Set column margin & padding
								if ( !empty( $item_instance['design']['advanced']['margin'] ) ) $this->inline_css .= layers_inline_styles( "#{$widget_id}-{$column_key}", 'margin', array( 'margin' => $item_instance['design']['advanced']['margin'] ) );
								if ( !empty( $item_instance['design']['advanced']['padding'] ) ) $this->inline_css .= layers_inline_styles( "#{$widget_id}-{$column_key}", 'padding', array( 'padding' => $item_instance['design']['advanced']['padding'] ) );

								if( !isset( $item_instance[ 'width' ] ) ) $item_instance[ 'width' ] = $this->column_defaults[ 'width' ];
								
								// Set the button styling
								$button_size = '';
								if ( function_exists( 'layers_pro_apply_widget_button_styling' ) ) {
									$this->inline_css .= layers_pro_apply_widget_button_styling( $this, $item_instance, array( "#{$widget_id}-{$column_key} .button" ) );
									$button_size = $this->check_and_return( $item_instance , 'design' , 'buttons-size' ) ? 'btn-' . $this->check_and_return( $item_instance , 'design' , 'buttons-size' ) : '' ;
								}

								// Add the correct span class
								$span_class = 'span-' . $item_instance[ 'width' ];

								$col_no++;
								$max = 12;
								$initial_width = $row_width;
								$item_width = $item_instance[ 'width' ];
								$next_item_width = ( isset( $next_item[ 'width' ] ) ? $next_item[ 'width' ] : 0 );
								$row_width += $item_width;

								if(  $max == $row_width ){
									$first_last_class = 'last';
									$row_width = 0;
								} elseif(  $max < $next_item_width + $row_width ){
									$first_last_class = 'last';
									$row_width = 0;
								} elseif( 0 == $initial_width ){
									$first_last_class = 'first';
								} else {
									$first_last_class = '';
								}

								// Set Featured Media
								$featureimage = $this->check_and_return( $item_instance , 'design' , 'featuredimage' );
								$featurevideo = $this->check_and_return( $item_instance , 'design' , 'featuredvideo' );

								// Calculate which cut based on ratio.
								if( isset( $item_instance['design'][ 'imageratios' ] ) ){

									// Translate Image Ratio into something usable
									$image_ratio = layers_translate_image_ratios( $item_instance['design'][ 'imageratios' ] );

									if( !isset( $item_instance[ 'width' ] ) ) $item_instance[ 'width' ] = 6;

									if( 4 >= $item_instance['width'] && 'layout-fullwidth' != $this->check_and_return( $instance, 'design', 'layout' ) ) $use_image_ratio = $image_ratio . '-medium';

									else $use_image_ratio = $image_ratio . '-large';

								} else {
									if( 4 > $item_instance['width'] ) $use_image_ratio = 'medium';
									else $use_image_ratio = 'full';
								}

								$media = layers_get_feature_media(
									$featureimage ,
									$use_image_ratio ,
									$featurevideo
								);

								// Set Image Size
								if( isset( $item_instance['design']['featuredimage-size'] ) && 0 != $item_instance['design']['featuredimage-size'] && '' != $item_instance['design']['featuredimage-size'] ) {
									$image_width = $item_instance['design'][ 'featuredimage-size' ].'px';
									$this->inline_css .= layers_inline_styles( "
										@media only screen and ( min-width: 769px ) {
											#{$widget_id}-{$column_key} .media-image img {
												max-width : {$image_width};
											}
										}
									");
								}

								// Get the link array.
								$link_array       = $this->check_and_return_link( $item_instance, 'button' );
								$link_href_attr   = ( $link_array['link'] ) ? 'href="' . esc_url( $link_array['link'] ) . '"' : '';
								$link_target_attr = ( '_blank' == $link_array['target'] ) ? 'target="_blank"' : '';

								/**
								* Set Individual Column CSS
								*/
								$classes = array();
								$classes[] = 'layers-masonry-column';
								$classes[] = $this->id_base . '-' . $column_key;
								$classes[] = $span_class;
								$classes[] = ( 'on' == $this->check_and_return( $item_instance , 'design', 'background', 'darken' ) ? 'darken' : '' );
								$classes[] = ( '' != $first_last_class ? $first_last_class : '' );
								$classes[] = ( 'list-masonry' == $this->check_and_return( $instance, 'design', 'liststyle' ) ? '' : '' );
								$classes[] = 'column' . ( 'on' != $this->check_and_return( $instance, 'design', 'gutter' ) ? '-flush' : '' );
								$classes[] = $this->check_and_return( $item_instance, 'design', 'advanced', 'customclass' ); // Apply custom class from design-bar's advanced control.
								if( $this->check_and_return( $item_instance, 'design' , 'background', 'image' ) || '' != $this->check_and_return( $item_instance, 'design' , 'background', 'color' ) )
									$classes[] = 'content';
								if( false != $media )
									$classes[] = 'has-image';

								$classes = apply_filters( 'layers_content_widget_item_class', $classes, $this, $item_instance );
								$classes = implode( ' ', $classes ); ?>

								<div id="<?php echo $widget_id; ?>-<?php echo $column_key; ?>" class="<?php echo esc_attr( $classes ); ?>">
									<?php
									/**
									* Set Overlay CSS Classes
									*/
									$column_inner_classes = array();
									$column_inner_classes[] = 'media';
									if( !$this->check_and_return( $instance, 'design', 'gutter' ) ) {
										$column_inner_classes[] = 'no-push-bottom';
									}
									if( $this->check_and_return( $item_instance, 'design', 'background' , 'color' ) ) {
										if( 'dark' == layers_is_light_or_dark( $this->check_and_return( $item_instance, 'design', 'background' , 'color' ) ) ) {
											$column_inner_classes[] = 'invert';
										}
									} else {
										if( $this->check_and_return( $instance, 'design', 'background' , 'color' ) && 'dark' == layers_is_light_or_dark( $this->check_and_return( $instance, 'design', 'background' , 'color' ) ) ) {
											$column_inner_classes[] = 'invert';
										}
									}

									$column_inner_classes[] = $this->check_and_return( $item_instance, 'design', 'imagealign' );
									$column_inner_classes[] = $this->check_and_return( $item_instance, 'design', 'fonts' , 'size' );
									$column_inner_classes = implode( ' ', $column_inner_classes );
									?>

									<div class="<?php echo $column_inner_classes; ?>">
										<?php if( NULL != $media ) { ?>
											<div class="media-image <?php echo ( ( isset( $item_instance['design'][ 'imageratios' ] ) && 'image-round' == $item_instance['design'][ 'imageratios' ] ) ? 'image-rounded' : '' ); ?>">
												<?php if ( $link_array['link'] ) { ?>
													<a <?php echo $link_href_attr; ?> <?php echo $link_target_attr; ?>>
												<?php  } ?>
													<?php echo $media; ?>
												<?php if ( $link_array['link'] ) { ?>
													</a>
												<?php  } ?>
											</div>
										<?php } ?>

										<?php if( $this->check_and_return( $item_instance, 'title' ) || $this->check_and_return( $item_instance, 'excerpt' ) || $this->check_and_return( $item_instance, 'link_text' ) ) { ?>
											<div class="media-body <?php echo ( isset( $item_instance['design']['fonts'][ 'align' ] ) ) ? $item_instance['design']['fonts'][ 'align' ] : ''; ?>">
												<?php if( $this->check_and_return( $item_instance, 'title') ) { ?>
													<<?php echo $this->check_and_return( $item_instance, 'design', 'fonts', 'heading-type' ) ?> class="heading">
														<?php if ( $link_array['link'] ) { ?>
															<a <?php echo $link_href_attr; ?> <?php echo $link_target_attr; ?>>
														<?php } ?>
															<?php echo $item_instance['title']; ?>
														<?php if ( $link_array['link'] ) { ?>
															</a>
														<?php } ?>
													</<?php echo $this->check_and_return( $item_instance, 'design', 'fonts', 'heading-type' ) ?>>
												<?php } ?>
												<?php if( $this->check_and_return( $item_instance, 'excerpt' ) ) { ?>
													<div class="excerpt"><?php layers_the_content( $item_instance['excerpt'] ); ?></div>
												<?php } ?>
												<?php if ( $link_array['link'] && $link_array['text'] ) { ?>
													<a <?php echo $link_href_attr; ?> class="button <?php echo $button_size; ?>" <?php echo $link_target_attr; ?>>
														<?php echo $link_array['text']; ?>
													</a>
												<?php } ?>
											</div>
										<?php } ?>
									</div>
								</div>
							<?php } ?>
						</div><!-- /row -->
					</div>
				<?php }

				do_action( 'layers_after_content_widget_inner', $this, $instance );

				// Print the Inline Styles for this Widget
				$this->print_inline_css();

				if( 'list-masonry' == $this->check_and_return( $instance , 'design', 'liststyle' ) ) { ?>
					<script>
						jQuery(function($){
							layers_masonry_settings[ '<?php echo $widget_id; ?>' ] = [{
								itemSelector: '.layers-masonry-column',
								layoutMode: 'masonry',
								gutter: <?php echo ( isset( $instance['design'][ 'gutter' ] ) ? 20 : 0 ); ?>
							}];

							$('#<?php echo $widget_id; ?>').find('.list-masonry').layers_masonry( layers_masonry_settings[ '<?php echo $widget_id; ?>' ][0] );
						});
					</script>
				<?php } // masonry trigger ?>

			</div>
		<?php
			
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
		* We use regular HTML here, it makes reading the widget much easier than if we used just php to echo all the HTML out.
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
				apply_filters( 'layers_column_widget_design_bar_components', array( // Components
					'layout',
					'liststyle' => array(
						'icon-css' => 'icon-list-masonry',
						'label' => __( 'List Style', 'layerswp' ),
						'wrapper-class' => 'layers-small to layers-pop-menu-wrapper layers-animate',
						'elements' => array(
							'liststyle' => array(
								'type' => 'select-icons',
								'name' => $this->get_layers_field_name( 'design', 'liststyle' ) ,
								'id' =>  $this->get_layers_field_id( 'design', 'liststyle' ) ,
								'value' => ( isset( $instance['design'][ 'liststyle' ] ) ) ? $instance['design'][ 'liststyle' ] : NULL,
								'options' => array(
									'list-grid' => __( 'Grid' , 'layerswp' ),
									'list-masonry' => __( 'Masonry' , 'layerswp' )
								)
							),
							'gutter' => array(
								'type' => 'checkbox',
								'label' => __( 'Gutter' , 'layerswp' ),
								'name' => $this->get_layers_field_name( 'design', 'gutter' ) ,
								'id' =>  $this->get_layers_field_id( 'design', 'gutter' ) ,
								'value' => ( isset( $instance['design']['gutter'] ) ) ? $instance['design']['gutter'] : NULL
							)
						)
					),
					'background',
					'advanced',
				), $this, $instance )
			); ?>
			<div class="layers-container-large" id="layers-column-widget-<?php echo $this->number; ?>">

				<?php $this->form_elements()->header( array(
					'title' =>'Content',
					'icon_class' =>'text'
				) ); ?>

				<section class="layers-accordion-section layers-content">
					<div class="layers-form-item">
					
						<?php echo $this->form_elements()->input(
							array(
								'type' => 'text',
								'name' => $this->get_layers_field_name( 'title' ) ,
								'id' => $this->get_layers_field_id( 'title' ) ,
								'placeholder' => __( 'Enter title here' , 'layerswp' ),
								'value' => ( isset( $instance['title'] ) ) ? $instance['title'] : NULL ,
								'class' => 'layers-text layers-large layers-input-has-controls',
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
							apply_filters( 'layers_column_widget_inline_design_bar_components', array( // Components
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
				</section>
				<section class="layers-accordion-section layers-content">
					<div class="layers-form-item">
					
						<?php $this->repeater( 'column', $instance ); ?>
						
					</div>
				</section>

			</div>

		<?php }

		function column_item( $item_guid, $item_instance ) {
			
			// Mix in new/unset defaults on every instance load (NEW)
			$item_instance = $this->apply_defaults( $item_instance, 'column' );
			?>
			<li class="layers-accordion-item" data-guid="<?php echo esc_attr( $item_guid ); ?>">
				<a class="layers-accordion-title">
					<span>
						<?php _e( 'Column' , 'layerswp' ); ?><span class="layers-detail"><?php echo ( isset( $item_instance['title'] ) ? ': ' . substr( stripslashes( strip_tags( $item_instance['title'] ) ), 0 , 50 ) : NULL ); ?><?php echo ( isset( $item_instance['title'] ) && strlen( $item_instance['title'] ) > 50 ? '...' : NULL ); ?></span>
					</span>
				</a>
				<section class="layers-accordion-section layers-content">
					<?php $this->design_bar(
						'top', // CSS Class Name
						array( // Widget Object
							'name' => $this->get_layers_field_name( 'design' ),
							'id' => $this->get_layers_field_id( 'design' ),
							'widget_id' => $this->widget_id . '_item',
							'number' => $this->number,
							'show_trash' => TRUE,
						),
						$item_instance, // Widget Values
						apply_filters( 'layers_column_widget_column_design_bar_components', array( // Components
							'background',
							'featuredimage',
							'imagealign',
							'fonts',
							'width' => array(
								'icon-css' => 'icon-columns',
								'label' => 'Column Width',
								'elements' => array(
									'layout' => array(
										'type' => 'select',
										'label' => __( '' , 'layerswp' ),
										'name' => $this->get_layers_field_name( 'width' ),
										'id' => $this->get_layers_field_id( 'width' ),
										'value' => ( isset( $item_instance['width'] ) ) ? $item_instance['width'] : NULL,
										'options' => array(
											'1' => __( '1 of 12 columns' , 'layerswp' ),
											'2' => __( '2 of 12 columns' , 'layerswp' ),
											'3' => __( '3 of 12 columns' , 'layerswp' ),
											'4' => __( '4 of 12 columns' , 'layerswp' ),
											'5' => __( '5 of 12 columns' , 'layerswp' ),
											'6' => __( '6 of 12 columns' , 'layerswp' ),
											'7' => __( '7 of 12 columns' , 'layerswp' ),
											'8' => __( '8 of 12 columns' , 'layerswp' ),
											'9' => __( '9 of 12 columns' , 'layerswp' ),
											'10' => __( '10 of 12 columns' , 'layerswp' ),
											'11' => __( '11 of 12 columns' , 'layerswp' ),
											'12' => __( '12 of 12 columns' , 'layerswp' )
										)
									)
								)
							),
							'advanced' => array(
								'elements' => array(
									'customclass',
									'padding' => array(
										'type' => 'trbl-fields',
										'label' => __( 'Padding (px)', 'layerswp' ),
										'name' => $this->get_layers_field_name( 'design', 'advanced', 'padding' ),
										'id' => $this->get_layers_field_id( 'design', 'advanced', 'padding' ),
										'value' => ( isset( $item_instance['design']['advanced']['padding'] ) ) ? $item_instance['design']['advanced']['padding'] : NULL,
										'fields' => array(
											'top',
											'right',
											'bottom',
											'left',
										),
									),
									'margin' => array(
										'type' => 'trbl-fields',
										'label' => __( 'Margin (px)', 'layerswp' ),
										'name' => $this->get_layers_field_name( 'design', 'advanced', 'margin' ),
										'id' => $this->get_layers_field_id( 'design', 'advanced', 'margin' ),
										'value' => ( isset( $item_instance['design']['advanced']['margin'] ) ) ? $item_instance['design']['advanced']['margin'] : NULL,
										'fields' => array(
											'top',
											'bottom',
										),
									),
								),
								'elements_combine' => 'replace',
							),
						), $this, $item_instance )
					); ?>
					<div class="layers-row">
						<p class="layers-form-item">
							<label for="<?php echo $this->get_layers_field_id( 'title' ); ?>"><?php _e( 'Title' , 'layerswp' ); ?></label>
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'text',
									'name' => $this->get_layers_field_name( 'title' ),
									'id' => $this->get_layers_field_id( 'title' ),
									'placeholder' => __( 'Enter title here' , 'layerswp' ),
									'value' => ( isset( $item_instance['title'] ) ) ? $item_instance['title'] : NULL ,
									'class' => 'layers-text'
								)
							); ?>
						</p>
						<p class="layers-form-item">
							<label for="<?php echo $this->get_layers_field_id( 'excerpt' ); ?>"><?php _e( 'Excerpt' , 'layerswp' ); ?></label>
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'rte',
									'name' => $this->get_layers_field_name( 'excerpt' ),
									'id' => $this->get_layers_field_id( 'excerpt' ),
									'placeholder' => __( 'Short Excerpt' , 'layerswp' ),
									'value' => ( isset( $item_instance['excerpt'] ) ) ? $item_instance['excerpt'] : NULL ,
									'class' => 'layers-form-item layers-textarea',
									'rows' => 6
								)
							); ?>
						</p>

						<?php
						// Fix widget's that were created before dynamic linking structure.
						$item_instance = $this->convert_legacy_widget_links( $item_instance, 'button' );
						?>

						<div class="layers-form-item">
							<label>
								<?php _e( 'Insert Link' , 'layerswp' ); ?>
							</label>
							<?php echo $this->form_elements()->input(
								array(
									'type' => 'link-group',
									'name' => $this->get_layers_field_name( 'button' ),
									'id' => $this->get_layers_field_id( 'button' ),
									'value' => ( isset( $item_instance['button'] ) ) ? $item_instance['button'] : NULL,
								)
							); ?>
						</div>

					</div>
				</section>
			</li>
			<?php
		}

	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Layers_Content_Widget");
}