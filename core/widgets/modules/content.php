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
		 	* @param  	varchar    		$widget_title    	Widget title
		 	* @param  	varchar    		$widget_id    		Widget slug for use as an ID/classname
		 	* @param  	varchar    		$post_type    		(optional) Post type for use in widget options
		 	* @param  	varchar    		$taxonomy    		(optional) Taxonomy slug for use as an ID/classname
		 	* @param  	array 			$checkboxes    	(optional) Array of checkbox names to be saved in this widget. Don't forget these please!
		 	*/
			$this->widget_title = __( 'Content' , 'layerswp' );
			$this->widget_id = 'column';
			$this->post_type = '';
			$this->taxonomy = '';
			$this->checkboxes = array();

			/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-layers-' . $this->widget_id .'-widget', 'description' => 'This widget is used to display your ' . $this->widget_title . '.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => LAYERS_WIDGET_WIDTH_LARGE, 'height' => NULL, 'id_base' => LAYERS_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( LAYERS_THEME_SLUG . '-widget-' . $this->widget_id , $this->widget_title, $widget_ops, $control_ops );

			/* Setup Widget Defaults */
			$this->defaults = array (
				'title' => 'Our Services',
				'excerpt' => 'Our services run deep and are backed by over ten years of experience.',
				'design' => array(
					'layout' => 'layout-boxed',
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
				),
				'column_ids' => rand( 1 , 1000 ).','.rand( 1 , 1000 ).','.rand( 1 , 1000 )
			);

			$this->column_defaults = array (
				'title' => 'Your service title',
				'excerpt' => 'Give us a brief description of the service that you are promoting. Try keep it short so that it is easy for people to scan your page.',
				'width' => '4',
				'design' => array(
					'imagealign' => 'image-top',
					'background' => NULL,
					'fonts' => array(
						'align' => 'text-left',
						'size' => 'medium',
						'color' => NULL,
						'shadow' => NULL
					)
				)
			);

			// Setup the defaults for each column object
			foreach( explode( ',', $this->defaults[ 'column_ids' ] ) as $column_id ) {
					$this->defaults[ 'columns' ][ $column_id ] = $this->column_defaults;
			}
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

			// Set the background styling
			if( !empty( $widget['design'][ 'background' ] ) ) layers_inline_styles( '#' . $widget_id, 'background', array( 'background' => $widget['design'][ 'background' ] ) );
			if( !empty( $widget['design']['fonts'][ 'color' ] ) ) layers_inline_styles( '#' . $widget_id, 'color', array( 'selectors' => array( '.section-title h3.heading' , '.section-title p.excerpt' ) , 'color' => $widget['design']['fonts'][ 'color' ] ) );

			// Apply the advanced widget styling
			$this->apply_widget_advanced_styling( $widget_id, $widget ); ?>

			<section class="widget row content-vertical-massive <?php echo $this->check_and_return( $widget , 'design', 'advanced', 'customclass' ) ?> <?php echo $this->get_widget_spacing_class( $widget ); ?>" id="<?php echo $widget_id; ?>">
				<?php if( '' != $this->check_and_return( $widget , 'title' ) ||'' != $this->check_and_return( $widget , 'excerpt' ) ) { ?>
					<div class="container">
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
				<?php if( !empty( $widget['columns'] ) ) { ?>
					<div class="row <?php echo $this->get_widget_layout_class( $widget ); ?> <?php echo $this->check_and_return( $widget , 'design', 'liststyle' ); ?>">
						<?php // Set total width so that we can apply .last to the final container
						$total_width = 0; ?>
						<?php foreach ( explode( ',', $widget[ 'column_ids' ] ) as $column_key ) {

							// Make sure we've got a column going on here
							if( !isset( $widget[ 'columns' ][ $column_key ] ) ) continue;

							// Setup the relevant slide
							$column = $widget[ 'columns' ][ $column_key ];

							// Set the background styling
							if( !empty( $column['design'][ 'background' ] ) ) layers_inline_styles( '#' . $widget_id . '-' . $column_key , 'background', array( 'background' => $column['design'][ 'background' ] ) );
							if( !empty( $column['design']['fonts'][ 'color' ] ) ) layers_inline_styles( '#' . $widget_id . '-' . $column_key , 'color', array( 'selectors' => array( 'h5.heading a', 'h5.heading' , 'div.excerpt' , 'div.excerpt p' ) , 'color' => $column['design']['fonts'][ 'color' ] ) );
							if( !empty( $column['design']['fonts'][ 'shadow' ] ) ) layers_inline_styles( '#' . $widget_id . '-' . $column_key , 'text-shadow', array( 'selectors' => array( 'h5.heading a', 'h5.heading' , 'div.excerpt' , 'div.excerpt p' )  , 'text-shadow' => $column['design']['fonts'][ 'shadow' ] ) );

							if( !isset( $column[ 'width' ] ) ) $column[ 'width' ] = $this->column_defaults[ 'width' ];
							// Add the correct span class
							$span_class = 'span-' . $column[ 'width' ];

							// Add .last to the final column
							$total_width += $column[ 'width' ];

							if( 12 == $total_width ) {
								$span_class .= ' last';
								$total_width = 0;
							} elseif( $total_width > 12 ) {
								$total_width = 0;
							}

							// Set Featured Media
							$featureimage = $this->check_and_return( $column , 'design' , 'featuredimage' );
							$featurevideo = $this->check_and_return( $column , 'design' , 'featuredvideo' );

							// Set Image Sizes
							if( isset( $column['design'][ 'imageratios' ] ) ){

								// Translate Image Ratio into something usable
								$image_ratio = layers_translate_image_ratios( $column['design'][ 'imageratios' ] );

								if( !isset( $column[ 'width' ] ) ) $column[ 'width' ] = 6;

								if( 4 > $column['width'] ){
									$use_image_ratio = $image_ratio . '-medium';
								} else {
									$use_image_ratio = $image_ratio . '-large';
								}

							} else {
								if( 4 > $column['width'] ){
									$use_image_ratio = 'medium';
								} else {
									$use_image_ratio = 'full';
								}
							}

							$media = layers_get_feature_media(
								$featureimage ,
								$use_image_ratio ,
								$featurevideo
							);

							// Set the column link
							$link = $this->check_and_return( $column , 'link' );

							// Set Column CSS Classes
							$column_class = array();
							$column_class[] = 'layers-masonry-column';
							$column_class[] = $span_class;
							if( !isset( $widget['design'][ 'gutter' ] ) ) {
								$column_class[] = 'column-flush';
							} else {
								$column_class[] = 'column';
							}
							if( '' != $this->check_and_return( $column, 'design' , 'background', 'image' ) || '' != $this->check_and_return( $column, 'design' , 'background', 'color' ) ) {
								$column_class[] = 'content';
							}
							if( false != $media ) {
								$column_class[] = 'has-image';
							}
							$column_class = implode( ' ', $column_class );

							// Set Column Inner CSS Classes
							$column_inner_class = array();
							$column_inner_class[] = 'media';
							if( !$this->check_and_return( $widget, 'design', 'gutter' ) ) {
								$column_inner_class[] = 'no-push-bottom';
							}
							$column_inner_class[] = $this->check_and_return( $column, 'design', 'imagealign' );
							$column_inner_class[] = $this->check_and_return( $column, 'design', 'fonts' , 'size' );
							$column_inner_class = implode( ' ', $column_inner_class ); ?>

							<div id="<?php echo $widget_id; ?>-<?php echo $column_key; ?>" class="<?php echo $column_class; ?>">
								<div class="<?php echo $column_inner_class; ?>">
									<?php if( NULL != $media ) { ?>
										<div class="media-image <?php echo ( ( isset( $column['design'][ 'imageratios' ] ) && 'image-round' == $column['design'][ 'imageratios' ] ) ? 'image-rounded' : '' ); ?>">
											<?php if( NULL != $link ) { ?><a href="<?php echo $link; ?>"><?php  } ?>
												<?php echo $media; ?>
											<?php if( NULL != $link ) { ?></a><?php  } ?>
										</div>
									<?php } ?>

									<?php if( $this->check_and_return( $column, 'title' ) || $this->check_and_return( $column, 'excerpt' ) ) { ?>
										<div class="media-body <?php echo ( isset( $column['design']['fonts'][ 'align' ] ) ) ? $column['design']['fonts'][ 'align' ] : ''; ?>">
											<?php if( $this->check_and_return( $column, 'title') ) { ?>
												<h5 class="heading">
													<?php if( NULL != $link && ! ( isset( $column['link'] ) && $this->check_and_return( $column , 'link_text' ) ) ) { ?><a href="<?php echo $column['link']; ?>"><?php } ?>
														<?php echo $column['title']; ?>
													<?php if( NULL != $link && ! ( isset( $column['link'] ) && $this->check_and_return( $column , 'link_text' ) ) ) { ?></a><?php } ?>
												</h5>
											<?php } ?>
											<?php if( $this->check_and_return( $column, 'excerpt' ) ) { ?>
												<div class="excerpt"><?php echo apply_filters( 'the_content', $column['excerpt'] ); ?></div>
											<?php } ?>
											<?php if( isset( $column['link'] ) && $this->check_and_return( $column , 'link_text' ) ) { ?>
												<a href="<?php echo $column['link']; ?>" class="button btn-<?php echo $this->check_and_return( $column , 'design' , 'fonts' , 'size' ); ?>"><?php echo $column['link_text']; ?></a>
											<?php } ?>
										</div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>

			</section>

			<script>
				jQuery(function($){
					layers_masonry_settings[ '<?php echo $widget_id; ?>' ] = [{
							itemSelector: '.layers-masonry-column',
							layoutMode: 'masonry',
							masonry: {
								gutter: <?php echo ( isset( $widget['design'][ 'gutter' ] ) ? 20 : 0 ); ?>
							}
						}];

					$('#<?php echo $widget_id; ?>').find('.list-masonry').layers_masonry( layers_masonry_settings[ '<?php echo $widget_id; ?>' ][0] );
				});
			</script>
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
					'custom',
					'fonts',
					'background',
					'advanced'
				), // Standard Components
				array(
					'liststyle' => array(
						'icon-css' => 'icon-list-masonry',
						'label' => 'List Style',
						'wrapper-class' => 'layers-small to layers-pop-menu-wrapper layers-animate',
						'elements' => array(
							'liststyle' => array(
								'type' => 'select-icons',
								'name' => $this->get_field_name( 'design' ) . '[liststyle]' ,
								'id' =>  $this->get_field_name( 'design-liststyle' ),
								'value' => ( isset( $design[ 'liststyle' ] ) ) ? $design[ 'liststyle' ] : NULL,
								'options' => array(
									'list-grid' => __( 'Grid' , 'layerswp' ),
									'list-masonry' => __( 'Masonry' , 'layerswp' )
								)
							),
							'gutter' => array(
								'type' => 'checkbox',
								'label' => __( 'Gutter' , 'layerswp' ),
								'name' => $this->get_field_name( 'design' ) . '[gutter]' ,
								'id' =>  $this->get_field_name( 'design-gutter' ),
								'value' => ( isset( $design['gutter'] ) ) ? $design['gutter'] : NULL
							)
						)
					)
				)
			); ?>
			<div class="layers-container-large" id="layers-column-widget-<?php echo $this->number; ?>">
				<?php $this->form_elements()->header( array(
					'title' =>'Content',
					'icon_class' =>'text'
				) ); ?>

				<section class="layers-accordion-section layers-content">
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
								'placeholder' =>  __( 'Short Excerpt' , 'layerswp' ),
								'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
								'class' => 'layers-textarea layers-large'
							)
						); ?>
					</p>

					<?php echo $this->form_elements()->input(
						array(
							'type' => 'hidden',
							'name' => $this->get_field_name( 'column_ids' ) ,
							'id' => 'column_ids_input_' . $this->number,
							'value' => ( isset( $column_ids ) ) ? $column_ids : NULL
						)
					); ?>

					<?php // If we have some columns, let's break out their IDs into an array
					if( isset( $column_ids ) && '' != $column_ids ) $columns = explode( ',' , $column_ids ); ?>

					<ul id="column_list_<?php echo esc_attr( $this->number ); ?>" class="layers-accordions layers-accordions-sortable layers-sortable" data-id_base="<?php echo $this->id_base; ?>" data-number="<?php echo $this->number; ?>">
						<?php if( isset( $columns ) && is_array( $columns ) ) { ?>
							<?php foreach( $columns as $columnguid ) {
								$this->column_item( array(
											'id_base' => $this->id_base ,
											'number' => $this->number
										) ,
										$columnguid ,
										( isset( $instance[ 'columns' ][ $columnguid ] ) ) ? $instance[ 'columns' ][ $columnguid ] : NULL );
							} ?>
						<?php }?>
					</ul>
					<button class="layers-button btn-full layers-add-widget-column add-new-widget" data-number="<?php echo esc_attr( $this->number ); ?>"><?php _e( 'Add New Column' , 'layerswp' ) ; ?></button>
				</section>
			</div>

		<?php } // Form

		function column_item( $widget_details = array() , $column_guid = NULL , $instance = NULL ){

			// Extract Instance if it's there so that we can use the values in our inputs

			// $instance Defaults
			$instance_defaults = $this->column_defaults;

			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );

			// If there is no GUID create one. There should always be one but this is a fallback
			if( ! isset( $column_guid ) ) $column_guid = rand( 1 , 1000 );

			// Turn the widget details into an object, it makes the code cleaner
			$widget_details = (object) $widget_details;

			// Set a count for each row
			if( !isset( $this->column_item_count ) ) {
				$this->column_item_count = 0;
			} else {
				$this->column_item_count++;
			} ?>

				<li class="layers-accordion-item" data-guid="<?php echo esc_attr( $column_guid ); ?>">
					<a class="layers-accordion-title">
						<span>
							<?php _e( 'Column' , 'layerswp' ); ?>
							<span class="layers-detail">
								<?php echo ( isset( $title ) ? ': ' . substr( stripslashes( strip_tags($title ) ), 0 , 50 ) : NULL ); ?>
								<?php echo ( isset( $title ) && strlen( $title ) > 50 ? '...' : NULL ); ?>
							</span>
						</span>
					</a>
					<section class="layers-accordion-section layers-content">
						<?php $this->design_bar(
							'top', // CSS Class Name
							array(
								'name' => $this->get_custom_field_name( $widget_details, 'columns',  $column_guid, 'design' ),
								'id' => $this->get_custom_field_id( $widget_details, 'columns',  $column_guid, 'design' ),
								'number' => $widget_details->number,
								'show_trash' => true
							), // Widget Object
							$instance, // Widget Values
							array(
								'background',
								'featuredimage',
								'imagealign',
								'fonts',
								'custom',
							), // Standard Components
							array(
								'width' => array(
									'icon-css' => 'icon-columns',
									'label' => 'Column Width',
									'elements' => array(
										'layout' => array(
											'type' => 'select',
											'label' => __( '' , 'layerswp' ),
											'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][columns][' . $column_guid . '][width]' ,
											'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $column_guid . '-width' ,
											'value' => ( isset( $width ) ) ? $width : NULL,
											'options' => array(
												'1' => __( '1 of 12 columns' , 'layerswp' ),
												'2' => __( '2 of 12 columns' , 'layerswp' ),
												'3' => __( '3 of 12 columns' , 'layerswp' ),
												'4' => __( '4 of 12 columns' , 'layerswp' ),
												'5' => __( '5 of 12 columns' , 'layerswp' ),
												'6' => __( '6 of 12 columns' , 'layerswp' ),
												'8' => __( '8 of 12 columns' , 'layerswp' ),
												'9' => __( '9 of 12 columns' , 'layerswp' ),
												'10' => __( '10 of 12 columns' , 'layerswp' ),
												'12' => __( '12 of 12 columns' , 'layerswp' )
											)
										)
									)
								),
							)
						); ?>

						<div class="layers-row">
							<p class="layers-form-item">
								<label for="<?php echo $this->get_custom_field_id( $widget_details, 'columns',  $column_guid, 'title' ); ?>"><?php _e( 'Title' , 'layerswp' ); ?></label>
								<?php echo $this->form_elements()->input(
									array(
										'type' => 'text',
										'name' => $this->get_custom_field_name( $widget_details, 'columns',  $column_guid, 'title' ),
										'id' => $this->get_custom_field_id( $widget_details, 'columns',  $column_guid, 'title' ),
										'placeholder' => __( 'Enter title here' , 'layerswp' ),
										'value' => ( isset( $title ) ) ? $title : NULL ,
										'class' => 'layers-text'
									)
								); ?>
							</p>
							<p class="layers-form-item">
								<label for="<?php echo $this->get_custom_field_id( $widget_details, 'columns',  $column_guid, 'excerpt' ); ?>"><?php _e( 'Excerpt' , 'layerswp' ); ?></label>
								<?php echo $this->form_elements()->input(
									array(
										'type' => 'textarea',
										'name' => $this->get_custom_field_name( $widget_details, 'columns',  $column_guid, 'excerpt' ),
										'id' => $this->get_custom_field_id( $widget_details, 'columns',  $column_guid, 'excerpt' ),
										'placeholder' => __( 'Short Excerpt' , 'layerswp' ),
										'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
										'class' => 'layers-form-item layers-textarea',
										'rows' => 6
									)
								); ?>
							</p>
							<div class="layers-row">
								<p class="layers-form-item layers-column layers-span-6">
									<label for="<?php echo $this->get_custom_field_id( $widget_details, 'columns',  $column_guid, 'link_text' ); ?>"><?php _e( 'Button Link' , 'layerswp' ); ?></label>
									<?php echo $this->form_elements()->input(
										array(
											'type' => 'text',
											'name' => $this->get_custom_field_name( $widget_details, 'columns',  $column_guid, 'link' ),
											'id' => $this->get_custom_field_id( $widget_details, 'columns',  $column_guid, 'link' ),
											'placeholder' => __( 'http://' , 'layerswp' ),
											'value' => ( isset( $link ) ) ? $link : NULL ,
											'class' => 'layers-text',
										)
									); ?>
								</p>
								<p class="layers-form-item layers-column layers-span-6">
									<label for="<?php echo $this->get_custom_field_id( $widget_details, 'columns',  $column_guid, 'link_text' ); ?>"><?php _e( 'Button Text' , 'layerswp' ); ?></label>
									<?php echo $this->form_elements()->input(
										array(
											'type' => 'text',
											'name' => $this->get_custom_field_name( $widget_details, 'columns',  $column_guid, 'link_text' ),
											'id' => $this->get_custom_field_id( $widget_details, 'columns',  $column_guid, 'link_text' ),
											'placeholder' => __( 'e.g. "Read More"' , 'layerswp' ),
											'value' => ( isset( $link_text ) ) ? $link_text : NULL ,
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
	 register_widget("Layers_Content_Widget");
}