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

<div class="hatch-design-bar">
	<h6 class="hatch-design-bar-title">
		<span class="icon-settings hatch-small"></span>
	</h6>
	<ul class="hatch-design-controllers">
		<li class="hatch-design-control-container">
			<a href="" class="hatch-design-control">
				<span class="icon-display"></span>
				<span class="hatch-control-description">
					Display
				</span>
			</a>
			<div class="hatch-design-properties">
				<ul class="hatch-checkbox-list">
					<li class="hatch-checkbox">
						<input type="checkbox" id="widget-hatch-widget-map-3-hide_google_map" name="widget-hatch-widget-map[3][hide_google_map]"   />
						<label for="widget-hatch-widget-map-3-hide_google_map">Hide Google Map</label>
					</li>
					<li class="hatch-checkbox">
						<input type="checkbox" id="widget-hatch-widget-map-3-hide_address" name="widget-hatch-widget-map[3][hide_address]"   />
						<label for="widget-hatch-widget-map-3-hide_address">Hide Address</label>
					</li>
					<li class="hatch-checkbox">
						<input type="checkbox" id="widget-hatch-widget-map-3-hide_contact_form" name="widget-hatch-widget-map[3][hide_contact_form]"   />
						<label for="widget-hatch-widget-map-3-hide_contact_form">Hide Contact Form</label>
					</li>
				</ul>
			</div>
		</li>

		<li class="hatch-design-control-container">
			<a href="" class="hatch-design-control">
				<span class="icon-columns"></span>
				<span class="hatch-control-description">
					Columns
				</span>
			</a>
		</li>

		<li class="hatch-design-control-container">
			<a href="" class="hatch-design-control">
				<span class="icon-list-masonry"></span>
				<span class="hatch-control-description">
					List Style
				</span>
			</a>
			<div class="hatch-design-properties hatch-small">
				<a href="" class="hatch-design-control">
					<span class="icon-list-grid"></span>
					<span class="hatch-control-description">
						Grid
					</span>
				</a>
				<a href="" class="hatch-design-control">
					<span class="icon-list-masonry"></span>
					<span class="hatch-control-description">
						Masonry
					</span>
				</a>
				<a href="" class="hatch-design-control">
					<span class="icon-list-list"></span>
					<span class="hatch-control-description">
						List
					</span>
				</a>
			</div>
		</li>

		<li class="hatch-design-control-container">
			<a href="" class="hatch-design-control">
				<span class="icon-slider"></span>
				<span class="hatch-control-description">
					Slider
				</span>
			</a>
		</li>

		<li class="hatch-design-control-container">
			<a href="" class="hatch-design-control">
				<span class="icon-photo"></span>
				<span class="hatch-control-description">
					Background
				</span>
			</a>
		</li>

		<li class="hatch-design-control-container">
			<a href="" class="hatch-design-control">
				<span class="icon-advanced-layout-left"></span>
				<span class="hatch-control-description">
					Layout
				</span>
			</a>
		</li>

		<li class="hatch-design-control-container hatch-last">
			<a href="" class="hatch-design-control">
				<span class="icon-image-left"></span>
				<span class="hatch-control-description">
					Image Align
				</span>
			</a>
			<div class="hatch-design-properties hatch-small">
				<a href="" class="hatch-design-control">
					<span class="icon-image-left"></span>
					<span class="hatch-control-description">
						Left
					</span>
				</a>
				<a href="" class="hatch-design-control">
					<span class="icon-image-right"></span>
					<span class="hatch-control-description">
						Right
					</span>
				</a>
				<a href="" class="hatch-design-control">
					<span class="icon-image-center"></span>
					<span class="hatch-control-description">
						Center
					</span>
				</a>
			</div>
		</li>
		<li class="hatch-quick-links">
			<a href="">
				<span class="icon-support"></span>
			</a>
			<a href="">
				<span class="icon-arrow-left"></span>
			</a>
		</li>
	</ul>
</div>

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
				<span>Icon Test</span>
			</a>

			<section class="hatch-accordion-section hatch-content">




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

				<div class="hatch-row clearfix">
					<div class="hatch-column hatch-span-6">

						<div class="hatch-panel">
							<div class="hatch-panel-title hatch-clearfix">


								<ul class="hatch-design-controls">
									<li class="hatch-design-controller">
										<a href="" class="hatch-design-action hatch-clearfix">
											<span class="hatch-icon-name">Color</span>
											<span class="hatch-carrot"></span>
										</a>
										<div class="hatch-option">
											<h5>Text Align</h5>
											<div class="hatch-radio-pills">
												<input type="radio" checked="checked" />
												<label>Small</label>
												<input type="radio" />
												<label>Medium</label>
												<input type="radio" />
												<label>Large</label>
											</div>
										</div>
									</li>
									<li class="hatch-design-controller">
										<a href="" class="hatch-design-action hatch-clearfix">
											<span class="hatch-icon-name">Color</span>
											<span class="hatch-carrot"></span>
										</a>
									</li>
									<li class="hatch-design-controller">
										<a href="" class="hatch-design-action hatch-clearfix">
											<span class="hatch-icon-name">Color</span>
											<span class="hatch-carrot"></span>
										</a>
									</li>
								</ul>



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

					</div>
					<div class="hatch-column hatch-span-6">
						<div class="hatch-panel">
							<div class="hatch-panel-title">
								<span class="tooltip" tooltip="Place your help text here please."></span>
								<h4 class="heading">Display Elements</h4>
							</div>
							<div class="hatch-content">
								<ul class="hatch-checkbox-list">
									<li class="hatch-checkbox">
										<input name="c1" type="checkbox" />
										<label for="c1">Show Item Title</label>
									</li>
									<li class="hatch-checkbox">
										<input name="c2" id="c2" type="checkbox" />
										<label for="c2">Show Date</label>
									</li>
									<li class="hatch-checkbox">
										<input name="c3" id="c3" type="checkbox" />
										<label for="c3">Show Excerpt</label>
									</li>
									<li class="hatch-radio">
										<input id="r1" type="radio" />
										<label for="r1">Show Author</label>
									</li>
									<li class="hatch-radio">
										<input id="r2" type="radio" />
										<label for="r2">Show Categories</label>
									</li>
									<li class="hatch-radio">
										<input id="r3" type="radio" />
										<label for="r3">Show Tags</label>
									</li>
									<li class="hatch-radio">
										<input id="r4" type="radio" />
										<label for="r4">Show Comment Count</label>
									</li>
								</ul>
							</div>
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
						<li class="active"><a href="" class="hatch-icon icon-bgimage-small">Background Image</a></li>
						<li><a href="" class="hatch-icon icon-video-small">Background Video</a></li>
					</ul>
					<div class="hatch-controller-elements">

						<!-- Image uploader -->
						<div class="hatch-content">
							<div class="hatch-form-item">
								<div class="hatch-image-uploader hatch-animate hatch-push-bottom">
									<p>Drop a file here or <a href="">select a file.</a></p>
								</div>
							</div>

							<ul class="hatch-checkbox-list">
								<li class="hatch-checkbox">
									<input type="checkbox" />
									<label>Darken to improve readability</label>
								</li>
								<li class="hatch-checkbox">
									<input type="checkbox" />
									<label>Tile Background</label>
								</li>
								<li class="hatch-checkbox">
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

							<ul class="hatch-checkbox-list">
								<li class="hatch-checkbox">
									<input type="checkbox" />
									<label>Darken to improve readability</label>
								</li>
								<li class="hatch-checkbox">
									<input type="checkbox" />
									<label>Tile Background</label>
								</li>
								<li class="hatch-checkbox">
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
				<span>Layout</span>
			</a>

			<section class="hatch-accordion-section hatch-content">

				<div class="hatch-row hatch-push-bottom">
					<a class="hatch-settings-icon hatch-icon-columns-1" href="">1 Column</a>
					<a class="hatch-settings-icon hatch-icon-columns-2 hatch-active" href="">2 Columns</a>
					<a class="hatch-settings-icon hatch-icon-columns-3" href="">3 Columns</a>
					<a class="hatch-settings-icon hatch-icon-columns-4" href="">4 Columns</a>
					<a class="hatch-settings-icon hatch-icon-columns-5" href="">5 Columns</a>
					<a class="hatch-settings-icon hatch-icon-columns-6" href="">6 Columns</a>
				</div>

				<div class="hatch-row hatch-push-bottom">
					<a class="hatch-settings-icon hatch-icon-image-left" href="">Image Left</a>
					<a class="hatch-settings-icon hatch-icon-image-right hatch-active" href="">Image Right</a>
					<a class="hatch-settings-icon hatch-icon-image-top" href="">Image Top</a>
				</div>

				<div class="hatch-row">
					<a class="hatch-settings-icon hatch-icon-grid" href="">Grid</a>
					<a class="hatch-settings-icon hatch-icon-list hatch-active" href="">List</a>
					<a class="hatch-settings-icon hatch-icon-slider" href="">Slider</a>
				</div>

			</section>

		</li>

		<li class="hatch-accordion-item">

			<a class="hatch-accordion-title">
				<span class="tooltip" tooltip="Place your help text here please."></span>
				<span>Buttons</span>
			</a>

			<section class="hatch-accordion-section hatch-content">

                <p><a href="#" class="hatch-button btn-large">Button Large</a> <a href="#" class="hatch-button">Button</a></p>
                <p><a href="#" class="hatch-button btn-error btn-large">Error Large</a> <a href="#" class="hatch-button btn-error">Error</a></p>
                <p><a href="#" class="hatch-button btn-primary btn-large">Primary Large</a> <a href="#" class="hatch-button btn-primary">Primary</a></p>
                <p><a href="#" class="hatch-button btn-secondary btn-large">Secondary Large</a> <a href="#" class="hatch-button btn-secondary">Secondary</a></p>
                <p><a href="#" class="hatch-button btn-subtle btn-large">Subtle Large</a> <a href="#" class="hatch-button btn-subtle">Subtle</a></p>
                <p><a href="#" class="hatch-button btn-link btn-large">Link Large</a> <a href="#" class="hatch-button btn-link">Link</a></p>

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
												<li class="active"><a href="" class="hatch-icon icon-bgimage-small">Background Image</a></li>
												<li><a href="" class="hatch-icon icon-video-small">Background Video</a></li>
											</ul>
											<div class="hatch-controller-elements">
												<div class="hatch-content section-active">
													<div class="hatch-form-item">
														<div class="hatch-image-uploader hatch-animate hatch-push-bottom">
															<p>Drop a file here or <a href="">select a file.</a></p>
														</div>
													</div>

													<ul class="hatch-checkbox-list">
														<li class="hatch-checkbox">
															<input type="checkbox" />
															<label>Darken to improve readability</label>
														</li>
														<li class="hatch-checkbox">
															<input type="checkbox" />
															<label>Tile Background</label>
														</li>
														<li class="hatch-checkbox">
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