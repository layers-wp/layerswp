<?php  /**
 * Sliders Widget
 *
 * This file is used to register and display the Layers - Slider widget.
 *
 * @package Layers
 * @since Layers 1.0.0
 */
if( !class_exists( 'Layers_Slider_Widget' ) ) {
	class Layers_Slider_Widget extends Layers_Widget {
	    
	    public $animation_class = "x-fade-in delay-200";

		/**
		*  Widget construction
		*/
	 	function __construct() {

			/**
			* Widget variables
			*
			* @param  	string    		$this->widget_id    	Widget title
			* @param  	string    		$widget_id    		Widget slug for use as an ID/classname
			* @param  	string    		$post_type    		(optional) Post type for use in widget options
			* @param  	string    		$taxonomy    		(optional) Taxonomy slug for use as an ID/classname
			* @param  	array 			$checkboxes    	(optional) Array of checkbox names to be saved in this widget. Don't forget these please!
			*/
			$this->widget_title = __( 'Slider' , 'layerswp' );
			$this->widget_id = 'slide';
			$this->post_type = '';
			$this->taxonomy = '';
			$this->checkboxes = array(
				'show_slider_arrows',
				'show_slider_dots',
				'autoplay_slides',
				'autoheight_slides',
			);

	 		/* Widget settings. */
			$widget_ops = array(
				'classname' => 'obox-layers-' . $this->widget_id .'-widget',
				'description' => __( 'This widget is used to display slides and can be used to display a page-banner.', 'layerswp' ) ,
				'customize_selective_refresh' => TRUE,
			);

			/* Widget control settings. */
			$control_ops = array(
				'width' => LAYERS_WIDGET_WIDTH_LARGE,
				'height' => NULL,
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
				'title' => NULL,
				'excerpt' => NULL,
				'slide_height' => '550',
				'show_slider_arrows' => 'on',
				'show_slider_dots' => 'on',
				'animation_type' => 'slide',
				'design' => array(
					'advanced' => array (
						'animation' => layers_get_theme_mod( 'enable-animations' ),
					)
				),
			);

			/* Setup Widget Repeater Defaults */
			$this->register_repeater_defaults( 'slide', 2, array(
				'title' => __( 'Slider Title', 'layerswp' ),
				'excerpt' => __( 'Short Excerpt', 'layerswp' ),
				'design' => array(
					'imagealign' => 'image-top',
					'imageratios' => NULL,
					'background' => array(
						'color' => '#f8f8f8',
						'position' => 'center',
						'repeat' => 'no-repeat',
						'size' => 'cover'
					),
					'fonts' => array(
						'color' => NULL,
						'align' => 'text-center',
						'size' => 'large',
						'shadow' => '',
						'heading-type' => 'h3',
					)
				),
				'button' => array(
					'link_type' => 'custom',
					'link_type_custom' => '#more',
					'link_text' => __( 'See More', 'layerswp' ),
				),
			) );

		}

		/**
		* Enqueue Scripts
		*/
		function enqueue_scripts(){

			// Enqueue Swiper Slider
			wp_enqueue_script( LAYERS_THEME_SLUG . '-slider-js' );
			wp_enqueue_style( LAYERS_THEME_SLUG . '-slider' );
		}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) {
			global $wp_customize;

			$this->backup_inline_css();

			// Turn $args array into variables.
			extract( $args );
			
			// Allow anyone to modify the instance.
			$instance = apply_filters( 'layers_modify_widget_instance', $instance, $this->widget_id, FALSE );

			// Use defaults if $instance is empty.
			if( empty( $instance ) && ! empty( $this->defaults ) ) {
				$instance = wp_parse_args( $instance, $this->defaults );
			}

			// Mix in new/unset defaults on every instance load (NEW)
			$instance = $this->apply_defaults( $instance );

			// Enqueue Scipts when needed
			$this->enqueue_scripts();

			// Apply slider arrow color
			if( $this->check_and_return( $instance, 'slider_arrow_color' ) ) $this->inline_css .= layers_inline_styles( ".{$widget_id}", 'color', array( 'selectors' => array( '.arrows a' ), 'color' => $this->check_and_return( $instance, 'slider_arrow_color' ) ) );
			if( $this->check_and_return( $instance, 'slider_arrow_color' ) ) $this->inline_css .= layers_inline_styles( ".{$widget_id}", 'border', array( 'selectors' => array( 'span.swiper-pagination-switch' ), 'border' => array( 'color' => $this->check_and_return( $instance, 'slider_arrow_color' ) ) ) );
			if( $this->check_and_return( $instance, 'slider_arrow_color' ) ) $this->inline_css .= layers_inline_styles( ".{$widget_id}", 'background', array( 'selectors' => array( 'span.swiper-pagination-switch' ), 'background' => array( 'color' => $this->check_and_return( $instance, 'slider_arrow_color' ) ) ) );
			if( $this->check_and_return( $instance, 'slider_arrow_color' ) ) $this->inline_css .= layers_inline_styles( ".{$widget_id}", 'background', array( 'selectors' => array( 'span.swiper-pagination-switch.swiper-active-switch' ), 'background' => array( 'color' => 'transparent !important' ) ) );


			// Get slider height css
			$slider_height_css = '';
			if( 'layout-full-screen' != $this->check_and_return( $instance , 'design', 'layout' ) && FALSE == $this->check_and_return( $instance , 'autoheight_slides' ) && $this->check_and_return( $instance , 'slide_height' ) ) {
				$slider_height_css = 'height: ' . $instance['slide_height'] . 'px; ';
			}

			// Apply the advanced widget styling
			$this->apply_widget_advanced_styling( $widget_id, $instance );

			/**
			* Generate the widget container class
			*/
			$widget_container_class = array();
			$widget_container_class[] = $widget_id;
			$widget_container_class[] = 'widget';
			$widget_container_class[] = 'layers-slider-widget';
			$widget_container_class[] = 'row';
			$widget_container_class[] = 'slide';
			$widget_container_class[] = 'swiper-container';
			$widget_container_class[] = 'loading'; // `loading` will be changed to `loaded` to fade in the slider.
			$widget_container_class[] = $this->check_and_return( $instance , 'design', 'advanced', 'customclass' ); // Apply custom class from design-bar's advanced control.
			$widget_container_class[] = $this->get_widget_spacing_class( $instance );
			$widget_container_class[] = $this->get_widget_layout_class( $instance );
		    $widget_container_class[] = $this->get_animation_class( $instance );

			if( $this->check_and_return( $instance , 'autoheight_slides' ) ) {
				if( FALSE !== ( $fullwidth = array_search( 'full-screen', $widget_container_class ) ) ){
					unset( $widget_container_class[ $fullwidth ] );
				}
				$widget_container_class[] = 'auto-height';
			}

			if( $this->check_and_return( $instance , 'design', 'layout') ) {
				// Slider layout eg 'slider-layout-full-screen'
				$widget_container_class[] = 'slider-' . $instance['design']['layout'];
			}
			if( ( ! isset( $instance['design']['layout'] ) || ( isset( $instance['design']['layout'] ) && 'layout-full-screen' != $instance['design']['layout'] ) ) ) {
				// If slider is not full screen
				$widget_container_class[] = 'not-full-screen';
			}
			if( 1 == count( $instance[ 'slides' ] ) ) {
				// If only one slide
				$widget_container_class[] = 'single-slide';
			}

			$widget_container_class = apply_filters( 'layers_slider_widget_container_class' , $widget_container_class, $this, $instance );
			$widget_container_class = implode( ' ', $widget_container_class );

			/**
			 * Slider HTML
			 */

			if( ! empty( $instance[ 'slides' ] ) ) { ?>

				<?php
				// Custom Anchor
				echo $this->custom_anchor( $instance ); ?>

				<div id="<?php echo esc_attr( $widget_id ); ?>" class="<?php echo esc_attr( $widget_container_class ); ?>" style="<?php echo esc_attr( $slider_height_css ); ?>" <?php $this->selective_refresh_atts( $args ); ?>>

					<?php do_action( 'layers_before_slider_widget_inner', $this, $instance ); ?>

					<?php if( 1 < count( $instance[ 'slides' ] ) && isset( $instance['show_slider_arrows'] ) ) { ?>
						 <div class="arrows">
							<a href="" class="l-left-arrow animate"></a>
							<a href="" class="l-right-arrow animate"></a>
						</div>
					<?php } ?>

					<div class="<?php echo $this->get_layers_field_id( 'pages' ); ?> pages animate">
						<?php for( $i = 0; $i < count( $instance[ 'slides' ] ); $i++ ) { ?>
							<a href="" class="page animate <?php if( 0 == $i ) echo 'active'; ?>"></a>
						<?php } ?>
					</div>

			 		<div class="swiper-wrapper">
						<?php foreach ( wp_parse_id_list( $instance[ 'slide_ids' ] ) as $slide_key ) {

							// Make sure we've got a column going on here
							if( !isset( $instance[ 'slides' ][ $slide_key ] ) ) continue;

							// Setup the relevant slide
							$item_instance = $instance[ 'slides' ][ $slide_key ];
							
							// Allow anyone to modify the instance.
							$item_instance = apply_filters( 'layers_modify_widget_instance', $item_instance, $this->widget_id, FALSE );

							// Mix in new/unset defaults on every instance load (NEW)
							$item_instance = $this->apply_defaults( $item_instance, 'slide' );

							// Set the background styling
							if( !empty( $item_instance['design'][ 'background' ] ) ) $this->inline_css .= layers_inline_styles( ".{$widget_id}-{$slide_key}", 'background', array( 'background' => $item_instance['design'][ 'background' ] ) );
							
							if( NULL !== $this->check_and_return( $item_instance, 'design', 'fonts', 'color' ) )	 
								$this->inline_css .= layers_inline_styles( ".{$widget_id}-{$slide_key}", 'color', array( 'selectors' => array( '.section-title .heading', '.section-title .heading a', '.section-title div.excerpt' ) , 'color' => $this->check_and_return( $item_instance, 'design', 'fonts', 'color' ) ) );


							if( NULL !== $this->check_and_return( $item_instance, 'design', 'fonts', 'excerpt-color' ) )	 
								$this->inline_css .= layers_inline_styles( ".{$widget_id}-{$slide_key}", 'color', array( 'selectors' => array( 'div.excerpt', 'div.excerpt p',  'div.excerpt a' ) , 'color' => $this->check_and_return( $item_instance, 'design', 'fonts', 'excerpt-color' ) ) );

							
							if( NULL !== $this->check_and_return( $item_instance, 'design', 'fonts', 'shadow' ) ) $this->inline_css .= layers_inline_styles( ".{$widget_id}-{$slide_key}", 'text-shadow', array( 'selectors' => array( '.heading', '.heading a',  'div.excerpt' )  , 'text-shadow' => $this->check_and_return( $item_instance, 'design', 'fonts', 'shadow' ) ) );

							// Set the button styling
							$button_size = '';
							if ( function_exists( 'layers_pro_apply_widget_button_styling' ) ) {
								$button_size = $this->check_and_return( $item_instance , 'design' , 'buttons-size' ) ? 'btn-' . $this->check_and_return( $item_instance , 'design' , 'buttons-size' ) : '' ;
								$this->inline_css .= layers_pro_apply_widget_button_styling( $this, $item_instance, array( ".{$widget_id}-{$slide_key} .button" ) );
							}

							// Get the button array.
							$link_array       = $this->check_and_return_link( $item_instance, 'button' );
							$link_href_attr   = ( $link_array['link'] ) ? 'href="' . esc_url( $link_array['link'] ) . '"' : '';
							$link_target_attr = ( '_blank' == $link_array['target'] ) ? 'target="_blank"' : '';

 							/**
							* Set Individual Slide CSS
							*/
							$slide_class = array();
							$slide_class[] = "{$widget_id}-{$slide_key}";
							$slide_class[] = 'swiper-slide';
							if( $this->check_and_return( $item_instance, 'design', 'background' , 'color' ) ) {
								if( 'dark' == layers_is_light_or_dark( $this->check_and_return( $item_instance, 'design', 'background' , 'color' ) ) ) {
									$slide_class[] = 'invert';
								}
							} else {
								$slide_class[] = 'invert';
							}
							if( false != $this->check_and_return( $item_instance , 'image' ) || 'image-left' == $item_instance['design'][ 'imagealign' ] || 'image-top' == $item_instance['design'][ 'imagealign' ] ) {
								$slide_class[] = 'has-image';
							}
							if( isset( $item_instance['design'][ 'imagealign' ] ) && '' != $item_instance['design'][ 'imagealign' ] ) {
								$slide_class[] = $item_instance['design'][ 'imagealign' ];
							}
							if( isset( $item_instance['design']['fonts'][ 'align' ] ) && '' != $item_instance['design']['fonts'][ 'align' ] ) {
								$slide_class[] = $item_instance['design']['fonts'][ 'align' ];
							}
							$slide_class[] = $this->check_and_return( $item_instance, 'design', 'advanced', 'customclass' ); // Apply custom class from design-bar's advanced control.

							$slide_class = apply_filters( 'layers_slider_widget_item_class', $slide_class, $this, $item_instance, $instance );
							$slide_class = implode( ' ', $slide_class );

							// Set link entire slide or not
							$slide_wrapper_tag = 'div';
							$slide_wrapper_href = '';

							if( $link_array['link'] && ! $link_array['text'] ) {
								$slide_wrapper_tag = 'a';
								$slide_wrapper_href = $link_href_attr;
							} ?>
							<<?php echo $slide_wrapper_tag; ?> <?php echo $slide_wrapper_href; ?> id="<?php echo esc_attr( "{$widget_id}-{$slide_key}" ); ?>" class="<?php echo esc_attr( $slide_class ); ?>" style="float: left; <?php echo $slider_height_css; ?>" <?php echo $link_target_attr; ?>>

								<?php do_action( 'layers_before_slider_widget_item_inner', $this, $item_instance, $instance ); ?>

								<?php
								/**
								* Set Overlay CSS Classes
								*/
								$overlay_class = array();
								$overlay_class[] = 'overlay';
								if( isset( $item_instance['design'][ 'background' ][ 'darken' ] ) ) {
									$overlay_class[] = 'darken';
								}
								if( '' != $this->check_and_return( $item_instance, 'design' , 'background', 'image' ) || '' != $this->check_and_return( $item_instance, 'design' , 'background', 'color' ) ) {
									$overlay_class[] = 'content';
								}
								$overlay_classes = implode( ' ', $overlay_class ); ?>

								<div class="<?php echo $overlay_classes; ?>" >
									<div class="container clearfix">
										<?php if( '' != $item_instance['title'] || '' != $item_instance['excerpt'] || '' != $link_array['link'] ) { ?>
											<div class="copy-container">
												<div class="section-title <?php echo ( isset( $item_instance['design']['fonts'][ 'size' ] ) ? $item_instance['design']['fonts'][ 'size' ] : '' ); ?>">
													<?php if( $this->check_and_return( $item_instance , 'title' ) ) { ?>
														<<?php echo $this->check_and_return( $item_instance, 'design', 'fonts', 'heading-type' ); ?> data-swiper-parallax="-100" class="heading">
															<?php echo $item_instance['title']; ?>
														</<?php echo $this->check_and_return( $item_instance, 'design', 'fonts', 'heading-type' ); ?>>
													<?php } ?>
													<?php if( $this->check_and_return( $item_instance , 'excerpt' ) ) { ?>
														<div data-swiper-parallax="-300" class="excerpt"><?php layers_the_content( $item_instance['excerpt'] ); ?></div>
													<?php } ?>
													<?php if( 'div' == $slide_wrapper_tag && $link_array['link'] && $link_array['text'] ) { ?>
														<a data-swiper-parallax="-200" <?php echo $link_href_attr; ?> <?php echo $link_target_attr; ?> class="button <?php echo $button_size; ?>">
															<?php echo $link_array['text']; ?>
														</a>
													<?php } ?>
												</div>
											</div>
										<?php } // if title || excerpt ?>
										
										<?php // Display featured image
										$this->featured_media( 'image-container', $item_instance, FALSE ); ?>

									</div> <!-- .container -->
								</div> <!-- .overlay -->

								<?php do_action( 'layers_after_slider_widget_item_inner', $this, $item_instance, $instance ); ?>

							</<?php echo $slide_wrapper_tag; ?>>
						<?php } // foreach slides ?>
					</div>

					<?php do_action( 'layers_after_slider_widget_inner', $this, $instance );

					// Print the Inline Styles for this Widget
					$this->print_inline_css( $this, $instance );

					/**
					 * Slider javascript initialize
					 */
					$swiper_js_obj = str_replace( '-' , '_' , $this->get_layers_field_id( 'slider' ) ); ?>
					<script type='text/javascript'>
						jQuery(function($){

							var <?php echo $swiper_js_obj; ?> = $('#<?php echo $widget_id; ?>').swiper({
							mode:'horizontal'
							,onInit: function(s){
								$(document).trigger( 'layers-slider-init', s);
							}
							,bulletClass: 'swiper-pagination-switch'
							,bulletActiveClass: 'swiper-active-switch swiper-visible-switch'
							,paginationClickable: true
							,watchActiveIndex: true
							<?php if( 'fade' ==  $this->check_and_return( $instance, 'animation_type' ) ) { ?>
								,effect: '<?php echo $instance['animation_type']; ?>'
							<?php } else if( 'parallax' ==  $this->check_and_return( $instance, 'animation_type' ) ) { ?>
								,speed: 700
								,parallax: true
								<?php } ?>
								<?php if( isset( $instance['show_slider_dots'] ) && ( !empty( $instance[ 'slides' ] ) && 1 < count( $instance[ 'slides' ] ) ) ) { ?>
								,pagination: '.<?php echo $this->get_layers_field_id( 'pages' ); ?>'
								<?php } ?>
								<?php if( 1 < count( $instance[ 'slides' ] ) ) { ?>
									,loop: true
							<?php } else { ?>
								,loop: false
								,noSwiping: true
								,allowSwipeToPrev: false
								,allowSwipeToNext: false
								<?php } ?>
								<?php if( isset( $instance['autoplay_slides'] ) && isset( $instance['slide_time'] ) && is_numeric( $instance['slide_time'] ) ) {?>
									, autoplay: <?php echo ($instance['slide_time']*1000); ?>
								<?php }?>
								<?php if( isset( $wp_customize ) && $this->check_and_return( $instance, 'focus_slide' ) ) { ?>
									,initialSlide: <?php echo $this->check_and_return( $instance, 'focus_slide' ); ?>
								<?php } ?>
							});

							<?php if( 1 < count( $instance[ 'slides' ] ) ) { ?>
								<?php echo $swiper_js_obj; ?>.enableKeyboardControl();
							<?php } // if > 1 slide ?>

							<?php if( TRUE == $this->check_and_return( $instance , 'autoheight_slides' ) ) { ?>
								$( '#<?php echo esc_attr( $widget_id ); ?>' ).imagesLoaded(function(){
									layers_swiper_resize( <?php echo $swiper_js_obj; ?> );
								});

								$(window).resize(function(){
									layers_swiper_resize( <?php echo $swiper_js_obj; ?> );
								});
							<?php } ?>

							$('#<?php echo $widget_id; ?>').find('.arrows a').on( 'click' , function(e){
								e.preventDefault();

								$that = $(this);

								if( $that.hasClass( 'swiper-pagination-switch' ) ){
									<?php echo $swiper_js_obj; ?>.slideTo( $that.index() );
								} else if( $that.hasClass( 'l-left-arrow' ) ){
									<?php echo $swiper_js_obj; ?>.slidePrev();
								} else if( $that.hasClass( 'l-right-arrow' ) ){
									<?php echo $swiper_js_obj; ?>.slideNext();
								}

								return false;
							});

							<?php echo $swiper_js_obj; ?>.init();
							if ( ! $('#<?php echo $widget_id; ?>').prev('.widget').length ) {
								if ( ! $('#<?php echo $widget_id; ?>').hasClass( 'full-screen' ) ) {
									jQuery('.header-site.header-overlay').css( 'transition', '0s' );
									setTimeout( function(){ jQuery('.header-site.header-overlay').css( 'transition', '' ); }, 1000 );
									jQuery('body').addClass( 'header-overlay-no-push' );
								}
							}

							$( '#<?php echo $widget_id; ?>' ).removeClass('loading').addClass('loaded');
						});
					</script>

				</div>
			<?php }

		}

		/**
		*  Widget update
		*/
	 	function update( $new_instance, $old_instance ) {

	 		if ( isset( $this->checkboxes ) ) {
				foreach( $this->checkboxes as $cb ) {
					if( isset( $old_instance[ $cb ] ) ) {
						$old_instance[ $cb ] = strip_tags( $new_instance[ $cb ] );
					}
				} // foreach checkboxes
			} // if checkboxes

			// Don't break the slider when
			if ( !isset( $new_instance['slides'] ) ) {
				$new_instance['slides'] = array();
			}

			return $new_instance;
		}

		/**
		*  Widget form
		*
		* We use regular HTML here, it makes reading the widget much easier than if we used just php to echo all the HTML out.
		*/
		function form( $instance ){

			// Use defaults if $instance is empty.
			if( empty( $instance ) && ! empty( $this->defaults ) ) {
				$instance = wp_parse_args( $instance, $this->defaults );
			}
			
			// Allow anyone to modify the instance.
			$instance = apply_filters( 'layers_modify_widget_instance', $instance, $this->widget_id, FALSE );

			// Mix in new/unset defaults on every instance load (NEW)
			$instance = $this->apply_defaults( $instance );

			$components = apply_filters( 'layers_slide_widget_design_bar_components', array(
				'display' => array(
					'icon-css' => 'icon-slider',
					'label' => __( 'Settings', 'layerswp' ),
					'elements' => array(
						'slider-layout-start' => array(
							'type' => 'group-start',
							'label' => __( 'Layout', 'layerswp' ),
						),
							'layout' => array(
								'type' => 'select-icons',
								'label' => __( '' , 'layerswp' ),
								'name' => $this->get_layers_field_name( 'design', 'layout' ) ,
								'id' => $this->get_layers_field_id( 'design', 'layout' ) ,
								'value' => ( isset( $instance['design']['layout'] ) ) ? $instance['design']['layout'] : NULL,
								'options' => array(
									'layout-boxed' => __( 'Boxed' , 'layerswp' ),
									'layout-fullwidth' => __( 'Full Width' , 'layerswp' ),
									'layout-full-screen' => __( 'Full Screen' , 'layerswp' )
								),
								'class' => 'layers-icon-group-inline layers-icon-group-inline-outline',
							),
							'autoheight_slides' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'autoheight_slides' ) ,
								'id' => $this->get_layers_field_id( 'autoheight_slides' ) ,
								'value' => ( isset( $instance['autoheight_slides'] ) ) ? $instance['autoheight_slides'] : NULL,
								'label' => __( 'Auto Height Slides' , 'layerswp' ),
							),
							'slide_height' => array(
								'type' => 'number',
								'name' => $this->get_layers_field_name( 'slide_height' ) ,
								'id' => $this->get_layers_field_id( 'slide_height' ) ,
								'value' => ( isset( $instance['slide_height'] ) ) ? $instance['slide_height'] : NULL,
								'label' => __( 'Slider Height (px)' , 'layerswp' ),
								'data' => array(
									'show-if-selector' => '#' . $this->get_layers_field_id( 'autoheight_slides' ),
									'show-if-value' => 'false',
								),
							),

							'padding' => array(
								'type' => 'inline-numbers-fields',
								'label' => __( 'Padding (px)', 'layerswp' ),
								'name' => $this->get_layers_field_name( 'design', 'advanced', 'padding' ),
								'id' => $this->get_layers_field_id( 'design', 'advanced', 'padding' ),
								'value' => ( isset( $instance['design']['advanced']['padding'] ) ) ? $instance['design']['advanced']['padding'] : NULL,
								'input_class' => 'inline-fields-flush',
							),

							'margin' => array(
								'type' => 'inline-numbers-fields',
								'label' => __( 'Margin (px)', 'layerswp' ),
								'name' => $this->get_layers_field_name( 'design', 'advanced', 'margin' ),
								'id' => $this->get_layers_field_id( 'design', 'advanced', 'margin' ),
								'value' => ( isset( $instance['design']['advanced']['margin'] ) ) ? $instance['design']['advanced']['margin'] : NULL,
								'input_class' => 'inline-fields-flush',
							),

						'slider-layout-end' => array(
							'type' => 'group-end',
						),

						'slider-navigation-start' => array(
							'type' => 'group-start',
							'label' => __( 'Slider Navigation', 'layerswp' ),
						),

							'show_slider_arrows' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_slider_arrows' ) ,
								'id' => $this->get_layers_field_id( 'show_slider_arrows' ) ,
								'value' => ( isset(  $instance['show_slider_arrows'] ) ) ?  $instance['show_slider_arrows'] : NULL,
								'label' => __( 'Show Slider Arrows' , 'layerswp' ),
							),
							'show_slider_dots' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'show_slider_dots' ) ,
								'id' => $this->get_layers_field_id( 'show_slider_dots' ) ,
								'value' => ( isset(  $instance['show_slider_dots'] ) ) ?  $instance['show_slider_dots'] : NULL,
								'label' => __( 'Show Slider Dots' , 'layerswp' ),
							),
							'slider_arrow_color' => array(
								'type' => 'color',
								'name' => $this->get_layers_field_name( 'slider_arrow_color' ) ,
								'id' => $this->get_layers_field_id( 'slider_arrow_color' ) ,
								'value' => ( isset( $instance['slider_arrow_color'] ) ) ? $instance['slider_arrow_color'] : NULL,
								'label' => __( 'Navigation Color' , 'layerswp' ),
								'data' => array(
									'show-if-selector' => '#' . $this->get_layers_field_id( 'show_slider_arrows' ),
									'show-if-value' => 'true',
								),
							),

						'slider-navigation-end' => array(
							'type' => 'group-end',
						),

						'slider-animation-start' => array(
							'type' => 'group-start',
							'label' => __( 'Animation Type', 'layerswp' ),
						),

							'animation_type' => array(
								'type' => 'select',
								'name' => $this->get_layers_field_name( 'animation_type' ) ,
								'id' => $this->get_layers_field_id( 'animation_type' ) ,
								'value' => ( isset(  $instance['animation_type'] ) ) ?  $instance['animation_type'] : 'slide',
								'options' => array(
									'slide' => __( 'Slide', 'layerswp' ),
									'fade' => __( 'Fade', 'layerswp' ),
									'parallax' => __( 'Parallax', 'layerswp' ),
								),
							),
							'autoplay_slides' => array(
								'type' => 'checkbox',
								'name' => $this->get_layers_field_name( 'autoplay_slides' ) ,
								'id' => $this->get_layers_field_id( 'autoplay_slides' ) ,
								'value' => ( isset( $instance['autoplay_slides'] ) ) ? $instance['autoplay_slides'] : NULL,
								'label' => __( 'Autoplay Slides' , 'layerswp' ),
							),
							'slide_time' => array(
								'type' => 'number',
								'name' => $this->get_layers_field_name( 'slide_time' ) ,
								'id' => $this->get_layers_field_id( 'slide_time' ) ,
								'min' => 1,
								'max' => 10,
								'placeholder' => __( 'Time in seconds, eg. 2' , 'layerswp' ),
								'value' => ( isset( $instance['slide_time'] ) ) ? $instance['slide_time'] : NULL,
								'label' => __( 'Slide Interval (seconds)' , 'layerswp' ),
								'data' => array(
									'show-if-selector' => '#' . $this->get_layers_field_id( 'autoplay_slides' ),
									'show-if-value' => 'true',
								),
							),
							
						'slider-animation-end' => array(
							'type' => 'group-end',
						),
					),
				),
				'advanced',
			), $this, $instance );

			// Legacy application of this filter - Do Not Use! (will be removed soon)
			$components = apply_filters( 'layers_slide_widget_design_bar_custom_components', $components );

			$this->design_bar(
				'side', // CSS Class Name
				array( // Widget Object
					'name' => $this->get_layers_field_name( 'design' ),
					'id' => $this->get_layers_field_id( 'design' ),
					'widget_id' => $this->widget_id,
					'widget_object' => $this,
				),
				$instance, // Widget Values
				$components // Components
			); ?>
			<div class="layers-container-large" id="layers-slide-widget-<?php echo esc_attr( $this->number ); ?>">

				<?php $this->form_elements()->header( array(
					'title' =>'Sliders',
					'icon_class' =>'slider'
				) ); ?>

				<?php echo $this->form_elements()->input(
					array(
						'type' => 'hidden',
						'name' => $this->get_layers_field_name( 'focus_slide' ) ,
						'id' => $this->get_layers_field_id( 'focus_slide' ) ,
						'value' => ( isset( $instance['focus_slide'] ) ) ? $instance['focus_slide'] : NULL,
						'data' => array(
							'focus-slide' => 'true'
						)
					)
				); ?>

				<section class="layers-accordion-section layers-content">
					<div class="layers-form-item">
						<?php $this->repeater( 'slide', $instance ); ?>
					</div>
				</section>

			</div>

		<?php }

		function slide_item( $item_guid, $item_instance ) {

			// Required - Get the name of this type.
			$type = str_replace( '_item', '', __FUNCTION__ );
			
			// Allow anyone to modify the instance.
			$item_instance = apply_filters( 'layers_modify_widget_instance', $item_instance, $this->widget_id, $item_guid );

			// Mix in new/unset defaults on every instance load (NEW)
			$item_instance = $this->apply_defaults( $item_instance, 'slide' );
			?>
			<li class="layers-accordion-item <?php echo $this->item_count; ?>" data-guid="<?php echo $item_guid; ?>">

				<a class="layers-accordion-title">
					<span>
						<?php echo ucfirst( $type ); ?><span class="layers-detail"><?php if ( isset( $item_instance['title'] ) ) echo $this->format_repeater_title( $item_instance['title'] ); ?></span>
					</span>
				</a>

				<section class="layers-accordion-section layers-content">
					<?php $this->design_bar(
						'top', // CSS Class Name
						array( // Widget Object
							'name' => $this->get_layers_field_name( 'design' ),
							'id' => $this->get_layers_field_id( 'design' ),
							'widget_id' => $this->widget_id . '_item',
							'widget_object' => $this,
							'number' => $this->number,
							'show_trash' => TRUE
						),
						$item_instance, // Widget Values
						apply_filters( 'layers_slide_widget_slide_design_bar_components', array( // Components
							'background',
							'featuredimage',
							'imagealign' => array(
								'elements' => array(
									'imagealign' => array(
										'options' => array(
											'image-left' => __( 'Left', 'layerswp' ),
											'image-right' => __( 'Right', 'layerswp' ),
											'image-top' => __( 'Top', 'layerswp' ),
											'image-bottom' => __( 'Bottom', 'layerswp' ),
										),
									),
								),
							),
							'header_excerpt',
							'buttons' => array(
								'icon-css' => 'icon-call-to-action',
								'label' => __( 'Buttons', 'layerswp' ),
								'elements' => array(
									'layers-pro-upsell' =>array(
										'type' => 'html',
										'html' => '<div class="layers-upsell-tag">
											<span class="layers-upsell-title">Upgrade to Layers Pro</span>
											<div class="description customize-control-description">
												Want more control over your button styling and sizes?
												<a target="_blank" href="https://www.layerswp.com/layers-pro/?ref=obox&amp;utm_source=layers%20theme&amp;utm_medium=link&amp;utm_campaign=Layers%20Pro%20Upsell&amp;utm_content=Widget%20Button%20Control">Purchase Layers Pro</a>
												and gain more control over your button styling!
											</div>
										</div>'
									)
								),
								'elements_combine' => 'replace',
							),
							'advanced' => array(
								'elements' => array(
										
									'customclass',

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
									'placeholder' => __( 'Enter a Title' , 'layerswp' ),
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
									'disallow_buttons' => array( 'insertOrderedList','insertUnorderedList' ),
									'class' => 'layers-textarea',
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
	 register_widget("Layers_Slider_Widget");
}