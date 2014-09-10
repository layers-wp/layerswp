<?php  /**
 * Obox HTML Widget
 *
 * This file is used to register and display the Hatch - Projects widget.
 *
 * @package Hatch
 * @since Hatch 1.0
 */
if( !class_exists( 'Hatch_Framework_Widget' ) ) {
	class Hatch_Framework_Widget extends WP_Widget {

		/**
		*  Widget variables
		*/
		private $widget_title = 'HTML Framework';
		private $widget_id = 'framework';
		private $post_type = '';
		private $taxonomy = '';

		/**
		*  Widget construction
		*/
	 	function Hatch_Framework_Widget(){
	 		/* Widget settings. */
			$widget_ops = array( 'classname' => 'obox-hatch-' . $this->widget_id .'-widget', 'description' => 'This widget is used to display general HTML framework.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => 1000, 'height' => NULL, 'id_base' => HATCH_THEME_SLUG . '-widget-' . $this->widget_id );

			/* Create the widget. */
			$this->WP_Widget( HATCH_THEME_SLUG . '-widget-' . $this->widget_id , '(' . HATCH_THEME_TITLE . ') ' . $this->widget_title . ' Widget', $widget_ops, $control_ops );
	 	}

		/**
		*  Widget front end display
		*/
	 	function widget( $args, $instance ) { ?>
	 		<!-- Front-end HTML Here -->
	 	<?php }

		/**
		*  Widget update
		*/
	 	function update($new_instance, $old_instance) {
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
			$instance_defaults = array (
				// 'key' => 'value',
			);

			// Parse $instance
			$instance_args = wp_parse_args( $instance, $instance_defaults );
			extract( $instance_args, EXTR_SKIP );
		?>

		<!-- Form HTML Here -->
		<?php $design_controller = new Hatch_Design_Controller();
		$design_controller->bar(
			$this, // Widget Object
			$instance, // Widget Values
			array(
				'custom',
				'columns',
				'layout',
				'liststyle',
				'textalign',
				'imagealign',
				'background',

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
						'autoplay_banners' => array(
							'type' => 'checkbox',
							'name' => $this->get_field_name( 'autoplay_banners' ) ,
							'id' => $this->get_field_id( 'autoplay_banners' ) ,
							'value' => ( isset( $autoplay_banners ) ) ? $autoplay_banners : NULL,
							'label' => __( 'Autoplay Slides', HATCH_THEME_SLUG )
						),
						'slide_time' => array(
							'type' => 'text',
							'name' => $this->get_field_name( 'slide_time' ) ,
							'id' => $this->get_field_id( 'slide_time' ) ,
							'placeholder' => __( 'Leave blank for no slide', HATCH_THEME_SLUG ),
							'value' => ( isset( $slide_time ) ) ? $slide_time : NULL,
							'label' => __( 'Slide Time', HATCH_THEME_SLUG )
						),
						'slide_effect' => array(
							'type' => 'select',
							'name' => $this->get_field_name( 'slide_effect' ) ,
							'id' => $this->get_field_id( 'slide_effect' ) ,
							'value' => ( isset( $slide_effect ) ) ? $slide_effect : NULL ,
							'options' => array(
									'slide' => __( 'Slide', HATCH_THEME_SLUG ),
									'fade' => __( 'Fade', HATCH_THEME_SLUG ),
									'none' => __( 'None', HATCH_THEME_SLUG ),

								),
							'label' => __( 'Slide Effect', HATCH_THEME_SLUG )
						),
						'banner_height' => array(
							'type' => 'text',
							'name' => $this->get_field_name( 'banner_height' ) ,
							'id' => $this->get_field_id( 'banner_height' ) ,
							'value' => ( isset( $banner_height ) ) ? $banner_height : NULL,
							'label' => __( 'Slider Height', HATCH_THEME_SLUG )
						),
						'banner_width' => array(
							'type' => 'select',
							'name' => $this->get_field_name( 'banner_width' ) ,
							'id' => $this->get_field_id( 'banner_width' ) ,
							'value' => ( isset( $banner_height ) ) ? $banner_height : NULL ,
							'options' => array(
									'full-width' => __( 'Full Width', HATCH_THEME_SLUG ),
									'boxed' => __( 'Boxed', HATCH_THEME_SLUG )

								),
							'label' => __( 'Slider Width', HATCH_THEME_SLUG )
						)
					)
				)
			) // Custom Elements
		); ?>
<div class="hatch-container-large">

<div class="hatch-controls-title">
		<h2 class="hatch-heading hatch-icon hatch-icon-services">
			Framework
		</h2>
	</div>

	<!-- NEW Slider AREA -->
	<ul class="hatch-accordions">
		<li class="hatch-accordion-item">

			<a class="hatch-accordion-title">
				<span class="tooltip" tooltip="Place your help text here please."></span>
				<span>Content</span>
			</a>

			<section class="hatch-accordion-section hatch-content">
				<div class="hatch-row hatch-push-bottom clearfix">
					<p class="hatch-form-item">
						<input type="text" class="hatch-text hatch-large" placeholder="Enter title here" />
					</p>
					<p class="hatch-form-item">
						<textarea class="hatch-textarea hatch-large" placeholder="Short excerpt"></textarea>
					</p>
				</div>

				<div class="hatch-row clearfix">

					<div class="hatch-panel">
						<div class="hatch-panel-title hatch-clearfix">
							<h4 class="heading">Content Type</h4>
						</div>
						<div class="hatch-content">
							<p class="hatch-form-item">
								<label>Category to Display</label>
								<select>
									<option>Select a Category</option>
								</select>
							</p>

							<p class="hatch-form-item">
								<label>Number of items to show</label>
								<select>
									<option>4</option>
								</select>
							</p>

							<p class="hatch-form-item">
								<label>Sort by</label>
								<select>
									<option>Newest First</option>
								</select>
							</p>
						</div>
					</div>

					<div class="hatch-panel">
						<div class="hatch-panel-title">
							<span class="tooltip" tooltip="Place your help text here please."></span>
							<h4 class="heading">Display Elements</h4>
						</div>
						<div class="hatch-content">
							<p class="hatch-checkbox-wrapper">
								<input name="c1" type="checkbox" />
								<label for="c1">Show Item Title</label>
							</p>
							<p class="hatch-checkbox-wrapper">
								<input name="c2" id="c2" type="checkbox" />
								<label for="c2">Show Date</label>
							</p>
							<p class="hatch-checkbox-wrapper">
								<input name="c3" id="c3" type="checkbox" />
								<label for="c3">Show Excerpt</label>
							</p>
							<p class="hatch-radio-wrapper">
								<input id="r1" type="radio" />
								<label for="r1">Show Author</label>
							</p>
							<p class="hatch-radio-wrapper">
								<input id="r2" type="radio" />
								<label for="r2">Show Categories</label>
							</p>
							<p class="hatch-radio-wrapper">
								<input id="r3" type="radio" />
								<label for="r3">Show Tags</label>
							</p>
							<p class="hatch-radio-wrapper">
								<input id="r4" type="radio" />
								<label for="r4">Show Comment Count</label>
							</p>
						</div>
					</div>
				</div>
			</section>
		</li>
		<li class="hatch-accordion-item open">

			<a class="hatch-accordion-title">
				<span class="tooltip" tooltip="Place your help text here please."></span>
				<span>New Background Uploader</span>
			</a>

			<section class="hatch-accordion-section hatch-content">

				<div class="hatch-media-controller">
					<ul class="hatch-section-links">
						<li class="active">
							<a href="" class="hatch-icon-wrapper">
								<span class="icon-photo"></span>
							</a>
						</li>
						<li>
							<a href="" class="hatch-icon-wrapper">
								<span class="icon-video"></span>
							</a>
						</li>
					</ul>
					<div class="hatch-controller-elements">

						<!-- Image uploader -->
						<div class="hatch-content">
							<div class="hatch-form-item">
								<div class="hatch-image-uploader hatch-animate hatch-push-bottom">
									<p>Drop a file here or <a href="">select a file.</a></p>
								</div>
							</div>

							<ul class="hatch-checkbox-wrapper-list">
								<li class="hatch-checkbox-wrapper">
									<input type="checkbox" />
									<label>Darken to improve readability</label>
								</li>
								<li class="hatch-checkbox-wrapper">
									<input type="checkbox" />
									<label>Tile Background</label>
								</li>
								<li class="hatch-checkbox-wrapper">
									<input type="checkbox" />
									<label>Fixed Background</label>
								</li>
							</ul>
						</div>

						<!-- Video uploader -->
						<div class="hatch-content">
							<p class="hatch-form-item">
								<label>Please add your .mp4 link</label>
								<input type="text" />
							</p>
							<p class="hatch-form-item">
								<label>Please add your .ogv link</label>
								<input type="text" />
							</p>

							<ul class="hatch-checkbox-wrapper-list">
								<li class="hatch-checkbox-wrapper">
									<input type="checkbox" />
									<label>Darken to improve readability</label>
								</li>
								<li class="hatch-checkbox-wrapper">
									<input type="checkbox" />
									<label>Tile Background</label>
								</li>
								<li class="hatch-checkbox-wrapper">
									<input type="checkbox" />
									<label>Fixed Background</label>
								</li>
							</ul>
						</div>

					</div>
				</div>

			</section>
		</li>

		<li class="hatch-accordion-item">

			<a class="hatch-accordion-title">
				<span class="tooltip" tooltip="Place your help text here please."></span>
				<span>Content</span>
			</a>

			<section class="hatch-accordion-section hatch-content">

				<div class="hatch-row hatch-push-bottom clearfix">
					<p class="hatch-form-item">
						<input type="text" class="hatch-text hatch-large" placeholder="Enter title here" />
					</p>
					<p class="hatch-form-item">
						<textarea class="hatch-textarea hatch-large" placeholder="Short excerpt"></textarea>
					</p>
				</div>

				<div class="hatch-row hatch-sortable">
					<div class="hatch-column hatch-span-4">
						<small class="hatch-drag"></small>
						<a href="#" class="hatch-image-uploader hatch-animate hatch-push-bottom"></a>
						<p class="hatch-form-item">
							<input class="hatch-text" type="text" placeholder="Enter title here" />
						</p>
						<p class="hatch-form-item">
							<input class="hatch-text" type="text" placeholder="Enter custom link" />
						</p>
						<div>Simple Wissy goes here</div>
					</div>
					<div class="hatch-column hatch-span-4">
						<small class="hatch-drag"></small>
						<a href="#" class="hatch-image-uploader hatch-animate hatch-push-bottom"></a>
						<p class="hatch-form-item">
							<input class="hatch-text" type="text" placeholder="Enter title here" />
						</p>
						<p class="hatch-form-item">
							<input class="hatch-text" type="text" placeholder="Enter custom link" />
						</p>
						<div>Simple Wissy goes here</div>
					</div>
					<div class="hatch-column hatch-span-4">
						<small class="hatch-drag"></small>
						<a href="#" class="hatch-image-uploader hatch-animate hatch-push-bottom"></a>
						<p class="hatch-form-item">
							<input class="hatch-text" type="text" placeholder="Enter title here" />
						</p>
						<p class="hatch-form-item">
							<input class="hatch-text" type="text" placeholder="Enter custom link" />
						</p>
						<div>Simple Wissy goes here</div>
					</div>
				</div>

			</section>

		</li>

		<li class="hatch-accordion-item">

			<a class="hatch-accordion-title">
				<span class="tooltip" tooltip="Place your help text here please."></span>
				<span>Buttons</span>
			</a>

			<section class="hatch-accordion-section hatch-content">

                <p><a href="#" class="button">Button WordPress</a> <a href="#" class="button button-primary">Button WordPress</a></p>

                <p>
                	<a href="#" class="hatch-button btn-massive">Button Massive</a>
                	<a href="#" class="hatch-button btn-large">Button Large</a>
                	<a href="#" class="hatch-button">Button</a>
                	<a href="#" class="hatch-button btn-small">Button Small</a>
                </p>
                <p><a href="#" class="hatch-button btn-primary btn-large">Primary Large</a> <a href="#" class="hatch-button btn-primary">Primary</a></p>
                <p><a href="#" class="hatch-button btn-secondary btn-large">Secondary Large</a> <a href="#" class="hatch-button btn-secondary">Secondary</a></p>
                <p><a href="#" class="hatch-button btn-error btn-large">Error Large</a> <a href="#" class="hatch-button btn-error">Error</a></p>

			</section>

		</li>

		<li class="hatch-accordion-item">
			<a class="hatch-accordion-title">
				<span class="tooltip" tooltip="Place your help text here please."></span>
				<span>Slider Content</span>
			</a>
			<section class="hatch-accordion-section hatch-content">


					<a href="" class="hatch-button btn-large hatch-push-bottom">Add New Slide</a>

					<ul class="hatch-accordions-sortable">
						<li class="hatch-accordion-item open">
							<a class="hatch-accordion-title">
								<span>Slide 1</span>
							</a>
							<section class="hatch-accordion-section hatch-content">

								<div class="hatch-row">

									<div class="hatch-column hatch-span-8">

										<div class="hatch-media-controller">
											<ul class="hatch-section-links">
												<li class="active">
													<a href="" class="hatch-icon-wrapper">
														<span class="icon-photo"></span>
													</a>
												</li>
												<li>
													<a href="" class="hatch-icon-wrapper">
														<span class="icon-video"></span>
													</a>
												</li>
											</ul>
											<div class="hatch-controller-elements">
												<div class="hatch-content section-active">
													<div class="hatch-form-item">
														<div class="hatch-image-uploader hatch-animate hatch-push-bottom">
															<p>Drop a file here or <a href="">select a file.</a></p>
														</div>
													</div>

													<ul class="hatch-checkbox-wrapper-list">
														<li class="hatch-checkbox-wrapper">
															<input type="checkbox" />
															<label>Darken to improve readability</label>
														</li>
														<li class="hatch-checkbox-wrapper">
															<input type="checkbox" />
															<label>Tile Background</label>
														</li>
														<li class="hatch-checkbox-wrapper">
															<input type="checkbox" />
															<label>Fixed Background</label>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>

									<div class="hatch-column hatch-span-4 no-gutter">
										<div class="hatch-panel">
											<div class="hatch-panel-title">
												<span class="tooltip" tooltip="Place your help text here please."></span>
												<h4 class="heading">Feature Image</h4>
											</div>
											<div class="hatch-content">
												<a href="#" class="hatch-image-uploader hatch-small hatch-animate hatch-push-bottom">
													<img class="image-reveal" src="http://demo.oboxsites.com/express/files/2013/12/graphy-tile.png">
												</a>
												<a class="hatch-settings-icon hatch-icon-image-left" href="">Image Left</a>
												<a class="hatch-settings-icon hatch-icon-image-right" href="">Image Right</a>
												<a class="hatch-settings-icon hatch-icon-image-top" href="">Image Top</a>
											</div>
										</div>
									</div>
								</div>

								<div class="hatch-row">
									wzg goes here
								</div>
							</section>
						</li>
						<li class="hatch-accordion-item">
							<a class="hatch-accordion-title">
								<span>Slide 2</span>
							</a>
						</li>
					</ul>

			</section>
		</li>

		<li class="hatch-accordion-item">

			<a class="hatch-accordion-title">
				<span class="tooltip" tooltip="Place your help text here please."></span>
				<span>Animation Tests</span>
			</a>

			<section class="hatch-accordion-section hatch-content">

				<div class="hatch-row hatch-push-bottom clearfix">
					<div class="test-container">
						<ul>
							<li class="thisli">This is an animation test. Do not remove.</li>
							<li class="thisli">Good day</li>
							<li class="thisli">Good bye</li>
						</ul>
					</div>
				</div>

			</section>

		</li>
	</ul>
</div>




		<?php } // Form
	} // Class

	// Add our function to the widgets_init hook.
	 register_widget("Hatch_Framework_Widget");
}