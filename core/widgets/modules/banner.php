<?php  /**
 * Banners Widget
 *
 * This file is used to register and display the Hatch - Banner widget.
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_Banner_Widget' ) ) {
	class Hatch_Banner_Widget extends Hatch_Widget {

		/**
		*  Widget variables
		*/
		private $widget_title = 'Sliders';
		private $widget_id = 'banner';
		private $post_type = '';
		private $taxonomy = '';
		public $checkboxes = array(
				'hide_slider_arrows',
				'autoplay_banners'
			);

		/**
		*  Widget construction
		*/
	 	function Hatch_Banner_Widget(){
	 		/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-hatch-' . $this->widget_id .'-widget', 'description' => 'This widget is used to display your ' . $this->widget_title . '.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => HATCH_WIDGET_WIDTH_LARGE, 'height' => NULL, 'id_base' => HATCH_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( HATCH_THEME_SLUG . '-widget-' . $this->widget_id , '(' . HATCH_THEME_TITLE . ') ' . $this->widget_title . ' Widget', $widget_ops, $control_ops );

			/* Setup Widget Defaults */
			$this->defaults = array (
				'title' => NULL,
				'excerpt' => NULL,
				'banner_height' => '550',
				'banner_ids' => rand( 1 , 1000 )
			);
			$this->banner_defaults = array (
				'title' => "Enter a Title",
				'excerpt' => "Add a description of your product, service or feature. Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
				'design' => array(
					'imagealign' => 'image-right',
					'imageratios' => NULL,
					'background' => array(
						'color' => '#000',
						'size' => 'cover',
						'position' => 'center'
					),
					'fonts' => array(
						'align' => 'text-left',
						'size' => 'large',
						'color' => '#fff',
						'shadow' => ''
					)
				)
			);
		}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) {

			// Turn $args array into variables.
			extract( $args );

			// Turn $instance into an object named $widget, makes for neater code
			$widget = (object) $instance; ?>

			<section class="widget row banner swiper-container <?php if( isset( $widget->design[ 'layout' ] ) && 'layout-boxed' == $widget->design[ 'layout' ] ) echo 'container'; ?>" id="<?php echo $widget_id; ?>" <?php if( isset( $widget->banner_height ) && '' != $widget->banner_height ) echo 'style="height: ' . $widget->banner_height . 'px;"' ?>>
				<?php if( !empty( $widget->banners ) ) { ?>
					<?php if( 1 < count( $widget->banners ) ) { ?>
						 <div class="arrows">
							<a href="" class="arrow-left animate"></a>
							<a href="" class="arrow-right animate"></a>
						</div>
					<?php } ?>
					<div class="pages animate">
						<?php for( $i = 0; $i < count( $widget->banners ); $i++ ) { ?>
							<a href="" class="page animate <?php if( 0 == $i ) echo 'active'; ?>"></a>
						<?php } ?>
					</div>
			 		<div class="swiper-wrapper">
						<?php $col = 1; ?>
						<?php foreach ( $widget->banners as $key => $banner) {
							$banner = (object) $banner;

							// Set the background styling
							if( !empty( $banner->design[ 'background' ] ) ) $this->widget_styles( $widget_id . '-' . $key , 'background', $banner->design[ 'background' ] );
							if( !empty( $banner->design['fonts'][ 'color' ] ) ) $this->widget_styles( $widget_id . '-' . $key , 'color', array( 'selectors' => array( 'h3.heading' , 'div.excerpt' ) , 'color' => $banner->design['fonts'][ 'color' ] ) );
							if( !empty( $banner->design['fonts'][ 'shadow' ] ) ) $this->widget_styles( $widget_id . '-' . $key , 'text-shadow', array( 'selectors' => array( 'h3.heading' , 'div.excerpt' )  , 'text-shadow' => $banner->design['fonts'][ 'shadow' ] ) );

							// Set Image Sizes
							if( isset( $banner->design[ 'imageratios' ] ) ){
									$imageratios = $banner->design[ 'imageratios' ] . '-medium';
							} else {
								$imageratios = 'medium';
							} ?>

							<div id="<?php echo $widget_id; ?>-<?php echo $key; ?>" class="invert swiper-slide
								<?php if( isset( $banner->design[ 'imagealign' ] ) && '' != $banner->design[ 'imagealign' ] ) echo $banner->design[ 'imagealign' ]; ?>
								<?php if( isset( $banner->design['fonts'][ 'align' ] ) && '' != $banner->design['fonts'][ 'align' ] ) echo $banner->design['fonts'][ 'align' ]; ?>
								"
								style="float: left; <?php if( isset( $widget->banner_height ) && '' != $widget->banner_height ) echo 'height: ' . $widget->banner_height . 'px;' ?>">
								<div class="container" <?php if( isset( $widget->banner_height ) && '' != $widget->banner_height ) echo 'style="height: ' . $widget->banner_height . 'px;"' ?>><!-- height important for vertical positioning. Must match container height -->
									<?php if( '' != $banner->title || '' != $banner->excerpt ) { ?>
										<div class="copy-container <?php if( !isset( $banner->image ) || ( isset( $banner->image ) && '' == $banner->image ) ) echo 'no-image'; ?>">
											<!-- your dynamic output goes here -->
											<div class="section-title <?php echo ( isset( $banner->design['fonts'][ 'size' ] ) ? $banner->design['fonts'][ 'size' ] : '' ); ?>">
												<?php if( isset( $banner->title ) && '' != $banner->title ) { ?>
													<h3 class="heading"><?php echo $banner->title; ?></h3>
												<?php } ?>
												<?php print_r( $banner->design['fonts'] );?>
												<?php if( isset( $banner->excerpt ) && '' != $banner->excerpt ) { ?>
													<div class="excerpt"><?php echo $banner->excerpt; ?></div>
												<?php } ?>
											</div>
											<div class="copy"></div>
										</div>
									<?php } // if title || excerpt ?>
									<?php if( isset( $banner->image ) && '' != $banner->image ) { ?>
										<div class="image-container">
											<?php echo wp_get_attachment_image( $banner->image , $imageratios ); ?>
										</div>
									<?php } // if $banner image ?>
								</div>
							</div>
						<?php } // foreach slides ?>
			 		</div>
				<?php } // if !empty( $widget->slides ) ?>
		 	</section>
		 	<?php if( !empty( $widget->banners ) ) { ?>
			 	<script>
					jQuery(function($){

						var swiper = $('#<?php echo $widget_id; ?>').swiper({
							//Your options here:
							mode:'horizontal',
							pagination: '.pages',
							// slidesPerView: 4,
							paginationClickable: true,
							watchActiveIndex: true,
							loop: true
							<?php if( isset( $widget->autoplay_banners ) && isset( $widget->slide_time ) && is_numeric( $widget->slide_time ) ) {?>, autoplay: <?php echo ($widget->slide_time*1000); ?><?php }?>
						});

						// Allow keyboard control
						swiper.enableKeyboardControl();

						$('#<?php echo $widget_id; ?>').find('.arrows a').on( 'click' , function(e){
							e.preventDefault();
							// "Hi Mom"
							$that = $(this);

							if( $that.hasClass( 'swiper-pagination-switch' ) ){ // Anchors
								swiper.swipeTo( $that.index() );
							} else if( $that.hasClass( 'arrow-left' ) ){ // Previous
								swiper.swipePrev();
							} else if( $that.hasClass( 'arrow-right' ) ){ // Next
								swiper.swipeNext();
							}
						});

					})
			 	</script>
			<?php } // if !empty( $widget->slides ) ?>

	 		<!-- Front-end HTML Here
	 		<?php print_r( $instance ); ?>-->
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
		* We use regular HTML here, it makes reading the widget much easier than if we used just php to echo all the HTML out.
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
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP ); ?>
			<!-- Form HTML Here -->
			<?php $design_controller = new Hatch_Design_Controller();
			$design_controller->bar(
				'side', // CSS Class Name
				array(
					'name' => $this->get_field_name( 'design' ),
					'id' => $this->get_field_id( 'design' ),
				), // Widget Object
				$instance, // Widget Values
				array(
					'layout',
					'custom',
				), // Standard Components
				array(
					'display' => array(
						'icon-css' => 'icon-slider',
						'label' => 'Slider',
						'elements' => array(
								'hide_slider_arrows' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'hide_slider_arrows' ) ,
									'id' => $this->get_field_id( 'hide_slider_arrows' ) ,
									'value' => ( isset( $hide_slider_arrows ) ) ? $hide_slider_arrows : NULL,
									'label' => __( 'Hide Slider Arrows', HATCH_THEME_SLUG )
								),
								'slider_arrow_color' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'slider_arrow_color' ) ,
									'id' => $this->get_field_id( 'slider_arrow_color' ) ,
									'value' => ( isset( $slider_arrow_color ) ) ? $slider_arrow_color : NULL,
									'label' => __( 'Slider Arrow Color', HATCH_THEME_SLUG )
								),
								'autoplay_banners' => array(
									'type' => 'checkbox',
									'name' => $this->get_field_name( 'autoplay_banners' ) ,
									'id' => $this->get_field_id( 'autoplay_banners' ) ,
									'value' => ( isset( $autoplay_banners ) ) ? $autoplay_banners : NULL,
									'label' => __( 'Autoplay Slides', HATCH_THEME_SLUG )
								),
								'slide_time' => array(
									'type' => 'number',
									'name' => $this->get_field_name( 'slide_time' ) ,
									'id' => $this->get_field_id( 'slide_time' ) ,
									'min' => 1,
									'max' => 10,
									'placeholder' => __( 'Leave blank for no slide', HATCH_THEME_SLUG ),
									'value' => ( isset( $slide_time ) ) ? $slide_time : NULL,
									'label' => __( 'Slide Interval', HATCH_THEME_SLUG )
								),
								'banner_height' => array(
									'type' => 'number',
									'name' => $this->get_field_name( 'banner_height' ) ,
									'id' => $this->get_field_id( 'banner_height' ) ,
									'value' => ( isset( $banner_height ) ) ? $banner_height : NULL,
									'label' => __( 'Slider Height', HATCH_THEME_SLUG )
								)
							)
					)
				)
			); ?>
			<div class="hatch-container-large" id="hatch-banner-widget-<?php echo $this->number; ?>">

				<?php $widget_elements->header( array(
					'title' =>'Slides',
					'icon_class' =>'slider'
				) ); ?>


				<ul class="hatch-accordions">
					<li class="hatch-accordion-item open">
						<?php $widget_elements->accordian_title(
							array(
								'title' => __( 'Slide Content' , HATCH_THEME_SLUG ),
								'tooltip' => __(  'Place your help text here please.', HATCH_THEME_SLUG )
							)
						); ?>
						<section class="hatch-accordion-section hatch-content">
								<?php echo $widget_elements->input(
									array(
										'type' => 'hidden',
										'name' => $this->get_field_name( 'banner_ids' ) ,
										'id' => 'banner_ids_input_' . $this->number,
										'value' => ( isset( $banner_ids ) ) ? $banner_ids : NULL
									)
								); ?>

								<?php // If we have some banners, let's break out their IDs into an array
								if( isset( $banner_ids ) && '' != $banner_ids ) $banners = explode( ',' , $banner_ids ); ?>

								<ul id="banner_list_<?php echo $this->number; ?>" class="hatch-accordions-sortable hatch-sortable" data-id_base="<?php echo $this->id_base; ?>" data-number="<?php echo $this->number; ?>">
									<?php if( isset( $banners ) && is_array( $banners ) ) { ?>
										<?php foreach( $banners as $banner ) {
											$this->banner_item( array(
														'id_base' => $this->id_base ,
														'number' => $this->number
													) ,
													$banner ,
													( isset( $instance[ 'banners' ][ $banner ] ) ) ? $instance[ 'banners' ][ $banner ] : NULL );
										} ?>
									<?php } else { ?>
										<?php $this->banner_item( array( 'id_base' => $this->id_base , 'number' => $this->number ) ); ?>
									<?php }?>
									<li class="hatch-button btn-primary hatch-add-widget-banner" data-number="<?php echo $this->number; ?>"><?php _e( '+ Add New Slide' , HATCH_THEME_SLUG ) ; ?></li>
								</ul>

						</section>
					</li>
				</ul>

			</div>

		<?php } // Form

		function banner_item( $widget_details = array() , $slide_guid = NULL , $instance = NULL ){

			// Extract Instance if it's there so that we can use the values in our inputs


			// $instance Defaults
			$instance_defaults = $this->banner_defaults;

			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );

			// If there is no GUID create one. There should always be one but this is a fallback
			if( ! isset( $slide_guid ) ) $slide_guid = rand( 1 , 1000 );

			// Initiate Widget Inputs
			$widget_elements = new Hatch_Form_Elements();

			// Turn the widget details into an object, it makes the code cleaner
			$widget_details = (object) $widget_details;

			// Set a count for each row
			if( !isset( $this->module_item_count ) ) {
				$this->banner_item_count = 0;
			} else {
				$this->banner_item_count++;
			}?>

				<li class="hatch-accordion-item  <?php if( !isset( $_REQUEST['action'] ) && $this->banner_item_count == 1 ) echo 'open'; ?>" data-guid="<?php echo $slide_guid; ?>">
					<a class="hatch-accordion-title">
						<span>
							<?php _e( 'Slide' , HATCH_THEME_SLUG ); ?><span class="hatch-detail"><?php echo ( isset( $title ) ? ': ' . $title : NULL ); ?></span>
						</span>
					</a>
					<section class="hatch-accordion-section hatch-content">
						<?php $design_controller = new Hatch_Design_Controller();
						$design_controller->bar(
							'top', // CSS Class Name
							array(
								'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][banners][' . $slide_guid . '][design]',
								'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $slide_guid . '-design',
								'number' => $widget_details->number,
								'show_trash' => true
							), // Widget Object
							$instance, // Widget Values
							array(
								'background',
								'fonts',
								'imagealign',
								'imageratios',
							), // Standard Components
							array(
								'fonts' => array(
									'icon-css' => 'icon-font-size',
									'label' => '',
									'elements' => array(
										'font-size' => array(
												'type' => 'select',
												'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][banners][' . $slide_guid . '][fonts][size]',
												'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $slide_guid . '-font-size',
												'value' => ( isset( $fonts[ 'size' ] ) ) ? $fonts[ 'size' ] : '',
												'label' => __( 'Text Size' , HATCH_THEME_SLUG ),
												'options' => array(
														'small' => __( 'Small' , HATCH_THEME_SLUG ),
														'' => __( 'Medium' , HATCH_THEME_SLUG ),
														'large' => __( 'Large' , HATCH_THEME_SLUG )
												)
											),
										'font-color' => array(
												'type' => 'color',
												'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][banners][' . $slide_guid . '][fonts][color]',
												'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $slide_guid . '-font-color',
												'value' => ( isset( $fonts[ 'color' ] ) ) ? $fonts[ 'color' ] : '',
												'label' => __( 'Text Color' , HATCH_THEME_SLUG )
											),
										'font-shadow' => array(
												'type' => 'color',
												'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][banners][' . $slide_guid . '][fonts][shadow]',
												'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $slide_guid . '-font-shadow',
												'value' => ( isset( $fonts[ 'shadow' ] ) ) ? $fonts[ 'shadow' ] : '',
												'label' => __( 'Text Shadow' , HATCH_THEME_SLUG )
											)
									)
								),
							)
						); ?>

						<div class="hatch-row">
							<div class="hatch-column hatch-span-4">
								<?php echo $widget_elements->input(
									array(
										'type' => 'image',
										'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][banners][' . $slide_guid . '][image]' ,
										'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $slide_guid . '-image' ,
										'value' => ( isset( $image ) ) ? $image : NULL
									)
								); ?>
							</div>
							<div class="hatch-column hatch-span-8">
								<p class="hatch-form-item">
									<?php echo $widget_elements->input(
										array(
											'type' => 'text',
											'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][banners][' . $slide_guid . '][title]' ,
											'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $slide_guid . '-title' ,
											'placeholder' => __( 'Enter title here', HATCH_THEME_SLUG ),
											'value' => ( isset( $title ) ) ? $title : NULL ,
											'class' => 'hatch-text'
										)
									); ?>
								</p>
								<p class="hatch-form-item">
									<?php echo $widget_elements->input(
										array(
											'type' => 'textarea',
											'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][banners][' . $slide_guid . '][excerpt]' ,
											'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $slide_guid . '-excerpt' ,
											'placeholder' => __( 'Short Excerpt', HATCH_THEME_SLUG ),
											'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
											'class' => 'hatch-textarea',
											'rows' => 6
										)
									); ?>
								</p>
							</div>
						</div>
					</section>
				</li>
		<?php }

	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Hatch_Banner_Widget");
}