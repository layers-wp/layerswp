<?php  /**
 * Modules Widget
 *
 * This file is used to register and display the Hatch - Module widget.
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_Module_Widget' ) ) {
	class Hatch_Module_Widget extends Hatch_Widget {

		/**
		*  Widget variables
		*/
		private $widget_title = 'Content';
		private $widget_id = 'module';
		private $post_type = '';
		private $taxonomy = '';
		public $checkboxes = array();

		/**
		*  Widget construction
		*/
		function Hatch_Module_Widget(){
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-hatch-' . $this->widget_id .'-widget', 'description' => 'This widget is used to display your ' . $this->widget_title . '.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => HATCH_WIDGET_WIDTH_LARGE, 'height' => NULL, 'id_base' => HATCH_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( HATCH_THEME_SLUG . '-widget-' . $this->widget_id , '(' . HATCH_THEME_TITLE . ') ' . $this->widget_title . ' Widget', $widget_ops, $control_ops );

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
				'module_ids' => rand( 1 , 1000 ).','.rand( 1 , 1000 ).','.rand( 1 , 1000 )
			);

			$this->module_defaults = array (
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

			// Setup the defaults for each module object
			foreach( explode( ',', $this->defaults[ 'module_ids' ] ) as $module_id ) {
					$this->defaults[ 'modules' ][ $module_id ] = $this->module_defaults;
			}
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

			// Set the background styling
			if( !empty( $widget['design'][ 'background' ] ) ) hatch_inline_styles( $widget_id, 'background', array( 'background' => $widget['design'][ 'background' ] ) );
			if( !empty( $widget['design']['fonts'][ 'color' ] ) ) hatch_inline_styles( $widget_id, 'color', array( 'selectors' => array( '.section-title h3.heading' , '.section-title p.excerpt' ) , 'color' => $widget['design']['fonts'][ 'color' ] ) ); ?>

			<section class="widget row content-vertical-massive" id="<?php echo $widget_id; ?>">
				<?php if( $this->check_and_return( $widget , 'title' ) || $this->check_and_return( $widget , 'excerpt' ) ) { ?>
					<div class="container">
						<div class="section-title <?php echo $this->check_and_return( $widget , 'design', 'fonts', 'size' ); ?> <?php echo $this->check_and_return( $widget , 'design', 'fonts', 'align' ); ?> clearfix">
							<?php if( '' != $widget['title'] ) { ?>
								<h3 class="heading"><?php echo $widget['title']; ?></h3>
							<?php } ?>
							<?php if( '' != $widget['excerpt'] ) { ?>
								<p class="excerpt"><?php echo $widget['excerpt']; ?></p>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<?php if( !empty( $widget['modules'] ) ) { ?>
					<div class="row <?php if('layout-boxed' == $this->check_and_return( $widget , 'design' , 'layout' ) ) echo 'container'; ?> <?php echo $this->check_and_return( $widget , 'design', 'liststyle' ); ?>">
						<?php // Set total width so that we can apply .last to the final container
						$total_width = 0; ?>
						<?php foreach ( $widget['modules'] as $key => $module) {
							// Set column link
							$link = ( $this->check_and_return( $module , 'link' ) ) ? $this->check_and_return( $module , 'link' ) : '#' . $widget_id . '-' . $key;

							// Set the background styling
							if( !empty( $module['design'][ 'background' ] ) ) hatch_inline_styles( $widget_id . '-' . $key , 'background', array( 'background' => $module['design'][ 'background' ] ) );
							if( !empty( $module['design']['fonts'][ 'color' ] ) ) hatch_inline_styles( $widget_id . '-' . $key , 'color', array( 'selectors' => array( 'h5.heading a' , 'div.excerpt' , 'div.excerpt p' ) , 'color' => $module['design']['fonts'][ 'color' ] ) );
							if( !empty( $module['design']['fonts'][ 'shadow' ] ) ) hatch_inline_styles( $widget_id . '-' . $key , 'text-shadow', array( 'selectors' => array( 'h5.heading a' , 'div.excerpt' , 'div.excerpt p' )  , 'text-shadow' => $module['design']['fonts'][ 'shadow' ] ) );

							if( !isset( $module[ 'width' ] ) ) $module[ 'width' ] = $this->module_defaults[ 'width' ];
							// Add the correct span class
							$span_class = 'span-' . $module[ 'width' ];

							// Add .last to the final column
							$total_width += $module[ 'width' ];

							if( 12 == $total_width ) {
								$span_class .= ' last';
								$total_width = 0;
							} elseif( $total_width > 12 ) {
								$total_width = 0;
							}

							// Set Image Sizes
							if( isset( $module['design'][ 'imageratios' ] ) ){

								// Translate Image Ratio
								$image_ratio = hatch_translate_image_ratios( $module['design'][ 'imageratios' ] );

								if( !isset( $module[ 'width' ] ) ) $module[ 'width' ] = 6;

								if( 6 > $module['width'] ){
									$imageratios = $image_ratio . '-medium';
								} else {
									$imageratios = $image_ratio . '-large';
								}

							} else {
								if( 6 > $module['width'] ){
									$imageratios = 'medium';
								} else {
									$imageratios = 'full';
								}
							} ?>

							<div id="<?php echo $widget_id; ?>-<?php echo $key; ?>" class="
								column<?php if( !isset( $widget['design'][ 'gutter' ] ) ) echo '-flush'; ?>
								<?php echo $span_class; ?>
								<?php if( '' != $this->check_and_return( $module, 'design' , 'background', 'image' ) || '' != $this->check_and_return( $module, 'design' , 'background', 'color' ) ) echo 'content'; ?>
								hatch-masonry-column">
								<a name="<?php echo $widget_id . '-' . $key; ?>"></a>
								<div class="media
									<?php echo $this->check_and_return( $module, 'design', 'imagealign' ); ?>
									<?php echo $this->check_and_return( $module, 'design', 'fonts' , 'size' ); ?>
									<?php if( !$this->check_and_return( $widget, 'design', 'gutter' ) ) echo 'no-push-bottom'; ?>
								">
									<?php if( $this->check_and_return( $module , 'design' , 'featuredimage' ) ) { ?>
										<div class="media-image"><a href="<?php echo $link; ?>"><?php echo wp_get_attachment_image( $module['design'][ 'featuredimage' ] , $imageratios ); ?></a></div>
									<?php } ?>
									<?php if( '' != $module['title'] || '' != $module['excerpt'] ) { ?>
										<div class="media-body <?php echo ( isset( $module['design']['fonts'][ 'align' ] ) ) ? $module['design']['fonts'][ 'align' ] : ''; ?>">
											<?php if( isset( $module['title'] ) && '' != $module['title'] ) { ?>
												<h5 class="heading"><a href="<?php echo $link; ?>"><?php echo $module['title']; ?></a></h5>
											<?php } ?>
											<?php if( isset( $module['excerpt'] ) && '' != $module['excerpt'] ) { ?>
												<div class="excerpt"><?php echo apply_filters( 'the_content', $module['excerpt'] ); ?></div>
											<?php } ?>
											<?php if( isset( $module['link'] ) && $this->check_and_return( $module , 'link_text' ) ) { ?>
												<a href="<?php echo $module['link']; ?>" class="button btn-<?php echo $this->check_and_return( $module , 'design' , 'fonts' , 'size' ); ?>"><?php echo $module['link_text']; ?></a>
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
					hatch_isotope_settings[ '<?php echo $widget_id; ?>' ] = [{
							itemSelector: '.hatch-masonry-column',
							layoutMode: 'masonry',
							masonry: {
								gutter: <?php echo ( isset( $widget['design'][ 'gutter' ] ) ? 20 : 0 ); ?>
							}
						}];

					$('#<?php echo $widget_id; ?>').find('.list-masonry').hatch_isotope( hatch_isotope_settings[ '<?php echo $widget_id; ?>' ][0] );
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
			<?php $this->design_bar()->bar(
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
					'background'
				), // Standard Components
				array(
					'liststyle' => array(
						'icon-css' => 'icon-list-masonry',
						'label' => 'List Style',
						'wrapper-css' => 'hatch-small to hatch-pop-menu-wrapper hatch-animate',
						'elements' => array(
							'liststyle' => array(
								'type' => 'select-icons',
								'name' => $this->get_field_name( 'design' ) . '[liststyle]' ,
								'id' =>  $this->get_field_name( 'design-liststyle' ),
								'value' => ( isset( $design[ 'liststyle' ] ) ) ? $design[ 'liststyle' ] : NULL,
								'options' => array(
									'list-grid' => __( 'Grid' , HATCH_THEME_SLUG ),
									'list-masonry' => __( 'Masonry' , HATCH_THEME_SLUG )
								)
							),
							'gutter' => array(
								'type' => 'checkbox',
								'label' => __( 'Gutter' , HATCH_THEME_SLUG ),
								'name' => $this->get_field_name( 'design' ) . '[gutter]' ,
								'id' =>  $this->get_field_name( 'design-gutter' ),
								'value' => ( isset( $design['gutter'] ) ) ? $design['gutter'] : NULL
							)
						)
					)
				)
			); ?>
			<div class="hatch-container-large" id="hatch-module-widget-<?php echo $this->number; ?>">

				<?php $this->form_elements()->header( array(
					'title' =>'Content',
					'icon_class' =>'text'
				) ); ?>

				<section class="hatch-accordion-section hatch-content">
					<p class="hatch-form-item">
						<?php echo $this->form_elements()->input(
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
						<?php echo $this->form_elements()->input(
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

					<?php echo $this->form_elements()->input(
						array(
							'type' => 'hidden',
							'name' => $this->get_field_name( 'module_ids' ) ,
							'id' => 'module_ids_input_' . $this->number,
							'value' => ( isset( $module_ids ) ) ? $module_ids : NULL
						)
					); ?>

					<?php // If we have some modules, let's break out their IDs into an array
					if( isset( $module_ids ) && '' != $module_ids ) $modules = explode( ',' , $module_ids ); ?>

					<ul id="module_list_<?php echo $this->number; ?>" class="hatch-accordions hatch-accordions-sortable hatch-sortable" data-id_base="<?php echo $this->id_base; ?>" data-number="<?php echo $this->number; ?>">
						<?php if( isset( $modules ) && is_array( $modules ) ) { ?>
							<?php foreach( $modules as $moduleguid ) {
								$this->module_item( array(
											'id_base' => $this->id_base ,
											'number' => $this->number
										) ,
										$moduleguid ,
										( isset( $instance[ 'modules' ][ $moduleguid ] ) ) ? $instance[ 'modules' ][ $moduleguid ] : NULL );
							} ?>
						<?php } else { ?>
							<?php $this->module_item( array( 'id_base' => $this->id_base , 'number' => $this->number ) ); ?>
						<?php }?>
						<li class="hatch-button btn-primary hatch-add-widget-module" data-number="<?php echo $this->number; ?>"><?php _e( '+ Add New Column' , HATCH_THEME_SLUG ) ; ?></li>
					</ul>
				</section>
			</div>

		<?php } // Form

		function module_item( $widget_details = array() , $column_guid = NULL , $instance = NULL ){

			// Extract Instance if it's there so that we can use the values in our inputs

			// $instance Defaults
			$instance_defaults = $this->module_defaults;

			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );

			// If there is no GUID create one. There should always be one but this is a fallback
			if( ! isset( $column_guid ) ) $column_guid = rand( 1 , 1000 );



			// Turn the widget details into an object, it makes the code cleaner
			$widget_details = (object) $widget_details;

			// Set a count for each row
			if( !isset( $this->module_item_count ) ) {
				$this->module_item_count = 0;
			} else {
				$this->module_item_count++;
			} ?>

				<li class="hatch-accordion-item" data-guid="<?php echo $column_guid; ?>">
					<a class="hatch-accordion-title">
						<span>
							<?php _e( 'Column' , HATCH_THEME_SLUG ); ?><span class="hatch-detail"><?php echo ( isset( $title ) ? ': ' . $title : NULL ); ?></span>
						</span>
					</a>
					<section class="hatch-accordion-section hatch-content">
						<?php $this->design_bar()->bar(
							'top', // CSS Class Name
							array(
								'name' => $this->get_custom_field_name( $widget_details, 'modules',  $column_guid, 'design' ),
								'id' => $this->get_custom_field_id( $widget_details, 'modules',  $column_guid, 'design' ),
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
											'label' => __( '', HATCH_THEME_SLUG ),
											'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][modules][' . $column_guid . '][width]' ,
											'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $column_guid . '-width' ,
											'value' => ( isset( $width ) ) ? $width : NULL,
											'options' => array(
												'1' => __( '1 of 12 columns' , HATCH_THEME_SLUG ),
												'2' => __( '2 of 12 columns' , HATCH_THEME_SLUG ),
												'3' => __( '3 of 12 columns' , HATCH_THEME_SLUG ),
												'4' => __( '4 of 12 columns' , HATCH_THEME_SLUG ),
												'5' => __( '5 of 12 columns' , HATCH_THEME_SLUG ),
												'6' => __( '6 of 12 columns' , HATCH_THEME_SLUG ),
												'8' => __( '8 of 12 columns' , HATCH_THEME_SLUG ),
												'10' => __( '10 of 12 columns' , HATCH_THEME_SLUG ),
												'12' => __( '12 of 12 columns' , HATCH_THEME_SLUG )
											)
										)
									)
								),
							)
						); ?>

						<div class="hatch-row">
							<p class="hatch-form-item">
								<label for="<?php echo $this->get_custom_field_id( $widget_details, 'modules',  $column_guid, 'title' ); ?>"><?php _e( 'Title' , HATCH_THEME_SLUG ); ?></label>
								<?php echo $this->form_elements()->input(
									array(
										'type' => 'text',
										'name' => $this->get_custom_field_name( $widget_details, 'modules',  $column_guid, 'title' ),
										'id' => $this->get_custom_field_id( $widget_details, 'modules',  $column_guid, 'title' ),
										'placeholder' => __( 'Enter title here', HATCH_THEME_SLUG ),
										'value' => ( isset( $title ) ) ? $title : NULL ,
										'class' => 'hatch-text'
									)
								); ?>
							</p>
							<p class="hatch-form-item">
								<label for="<?php echo $this->get_custom_field_id( $widget_details, 'modules',  $column_guid, 'excerpt' ); ?>"><?php _e( 'Excerpt' , HATCH_THEME_SLUG ); ?></label>
								<?php echo $this->form_elements()->input(
									array(
										'type' => 'textarea',
										'name' => $this->get_custom_field_name( $widget_details, 'modules',  $column_guid, 'excerpt' ),
										'id' => $this->get_custom_field_id( $widget_details, 'modules',  $column_guid, 'excerpt' ),
										'placeholder' => __( 'Short Excerpt', HATCH_THEME_SLUG ),
										'value' => ( isset( $excerpt ) ) ? $excerpt : NULL ,
										'class' => 'hatch-form-item hatch-textarea',
										'rows' => 6
									)
								); ?>
							</p>
							<p class="hatch-form-item">
								<label for="<?php echo $this->get_custom_field_id( $widget_details, 'modules',  $column_guid, 'link_text' ); ?>"><?php _e( 'Link' , HATCH_THEME_SLUG ); ?></label>
								<?php echo $this->form_elements()->input(
									array(
										'type' => 'text',
										'name' => $this->get_custom_field_name( $widget_details, 'modules',  $column_guid, 'link' ),
										'id' => $this->get_custom_field_id( $widget_details, 'modules',  $column_guid, 'link' ),
										'placeholder' => __( 'Link', HATCH_THEME_SLUG ),
										'value' => ( isset( $link ) ) ? $link : NULL ,
										'class' => 'hatch-text',
									)
								); ?>
							</p>
							<p class="hatch-form-item">
								<label for="<?php echo $this->get_custom_field_id( $widget_details, 'modules',  $column_guid, 'link_text' ); ?>"><?php _e( 'Button Text' , HATCH_THEME_SLUG ); ?></label>
								<?php echo $this->form_elements()->input(
									array(
										'type' => 'text',
										'name' => $this->get_custom_field_name( $widget_details, 'modules',  $column_guid, 'link_text' ),
										'id' => $this->get_custom_field_id( $widget_details, 'modules',  $column_guid, 'link_text' ),
										'placeholder' => __( 'e.g. "Read More"' , HATCH_THEME_SLUG ),
										'value' => ( isset( $link_text ) ) ? $link_text : NULL ,
									)
								); ?>
							</p>
						</div>
					</section>
				</li>
		<?php }

	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Hatch_Module_Widget");
}