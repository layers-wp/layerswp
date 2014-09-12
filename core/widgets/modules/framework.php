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

<div class="hatch-visuals hatch-pull-right">
	<h6 class="hatch-visuals-title">
		<span class="icon-settings hatch-small"></span>
	</h6>
	<ul class="hatch-visuals-wrapper">
		<li class="hatch-visuals-item ">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-layout-fullwidth"></span>
				<span class="hatch-icon-description">
					Layout
				</span>
			</a>
			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-small">
				<div class="hatch-visuals-settings">
					<a href="" class="hatch-icon-wrapper hatch-active">
						<span class="icon-layout-boxed"></span>
						<span class="hatch-icon-description">
							Boxed
						</span>
					</a>
					<a href="" class="hatch-icon-wrapper">
						<span class="icon-layout-fullwidth"></span>
						<span class="hatch-icon-description">
							Full Width
						</span>
					</a>
				</div>
			</div>
		</li>
		<li class="hatch-visuals-item">

			<a href="" class="hatch-icon-wrapper">
				<span class="icon-list-masonry"></span>
				<span class="hatch-icon-description">
					List Style
				</span>
			</a>

			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-small">
				<div class="hatch-visuals-settings">
					<a href="" class="hatch-icon-wrapper">
						<span class="icon-list-grid"></span>
						<span class="hatch-icon-description">
							Grid
						</span>
					</a>
					<a href="" class="hatch-icon-wrapper">
						<span class="icon-list-masonry"></span>
						<span class="hatch-icon-description">
							Masonry
						</span>
					</a>
					<a href="" class="hatch-icon-wrapper hatch-active">
						<span class="icon-list-list"></span>
						<span class="hatch-icon-description">
							List
						</span>
					</a>
				</div>
			</div>
		</li>

		<li class="hatch-visuals-item">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-display"></span>
				<span class="hatch-icon-description">
					Display
				</span>
			</a>
			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-content-small">
				<div class="hatch-visuals-settings">
					<p class="hatch-checkbox-wrapper">
						<input type="checkbox"/>
						<label>Checkbox</label>
					</p>
					<p class="hatch-checkbox-wrapper">
						<input type="checkbox"/>
						<label>Checkbox</label>
					</p>
					<p class="hatch-radio-wrapper">
						<input type="radio"/>
						<label>Radio</label>
					</p>
					<p class="hatch-radio-wrapper">
						<input type="radio"/>
						<label>Radio</label>
					</p>
				</div>
			</div>
		</li>

		<li class="hatch-visuals-item">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-columns"></span>
				<span class="hatch-icon-description">
					Columns
				</span>
			</a>
		</li>

		<li class="hatch-visuals-item">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-font-size"></span>
				<span class="hatch-icon-description">
					Font
				</span>
			</a>
		</li>

		<li class="hatch-visuals-item">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-text-center"></span>
				<span class="hatch-icon-description">
					Text Align
				</span>
			</a>
			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-small">
				<div class="hatch-visuals-settings">
					<a href="" class="hatch-icon-wrapper hatch-active">
						<span class="icon-text-left"></span>
						<span class="hatch-icon-description">
							Left
						</span>
					</a>
					<a href="" class="hatch-icon-wrapper">
						<span class="icon-text-right"></span>
						<span class="hatch-icon-description">
							Right
						</span>
					</a>
					<a href="" class="hatch-icon-wrapper">
						<span class="icon-text-center"></span>
						<span class="hatch-icon-description">
							Center
						</span>
					</a>
					<a href="" class="hatch-icon-wrapper">
						<span class="icon-text-justify"></span>
						<span class="hatch-icon-description">
							Justify
						</span>
					</a>
				</div>
			</div>
		</li>

		<li class="hatch-visuals-item">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-slider"></span>
				<span class="hatch-icon-description">
					Slider
				</span>
			</a>
			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-content-small">
				<div class="hatch-visuals-settings">
					<p class="hatch-checkbox-wrapper">
						<input type="checkbox"/>
						<label>Hide Slider Arrows</label>
					</p>
					<!-- only appear if you click 'hide slider arrows' -->
						<p class="hatch-checkbox-wrapper">
							<input type="checkbox"/>
							<label>Autoplay Slides</label>
						</p>
						<p class="hatch-form-item">
							<label>Slide Time</label>
							<input type="text" placeholder="example: 8" />
						</p>
					<!-- /end -->
					<p class="hatch-form-item">
						<label>Banner Height</label>
						<input type="text" placeholder="example: 550" />
					</p>
					<p class="hatch-form-item">
						<label>Slide Effect</label>
						<select size="1">
							<option selected="selected" value="slide">Slide</option>
							<option value="fade">Fade</option>
							<option value="none">None</option>
						</select>
					</p>
				</div>
			</div>
		</li>

		<li class="hatch-visuals-item hatch-last">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-photo"></span>
				<span class="hatch-icon-description">
					Background
				</span>
			</a>
			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-content-small">
				<div class="hatch-visuals-settings">
					<section class="hatch-push-bottom">
						<img src="http://obox.beta/wp-content/uploads/2014/08/city-scape.jpg" />
					</section>
					<section class="hatch-push-bottom">
						<a href="#" class="hatch-button btn-primary btn-full">Upload Image</a>
					</section>
					<section>
						<p class="hatch-checkbox-wrapper">
							<input type="checkbox"/>
							<label>Tile</label>
						</p>
						<p class="hatch-checkbox-wrapper">
							<input type="checkbox"/>
							<label>Stretch</label>
						</p>
						<p class="hatch-checkbox-wrapper">
							<input type="checkbox"/>
							<label>Fixed</label>
						</p>
						<p class="hatch-checkbox-wrapper">
							<input type="checkbox"/>
							<label>Darken</label>
						</p>
					</section>
				</div>
			</div>
		</li>

		<li class="hatch-visuals-item hatch-last">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-image-left"></span>
				<span class="hatch-icon-description">
					Image Align
				</span>
			</a>
			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-small">
				<div class="hatch-visual-settings">
					<a href="" class="hatch-icon-wrapper">
						<span class="icon-image-left"></span>
						<span class="hatch-icon-description">
							Left
						</span>
					</a>
					<a href="" class="hatch-icon-wrapper hatch-active">
						<span class="icon-image-right"></span>
						<span class="hatch-icon-description">
							Right
						</span>
					</a>
					<a href="" class="hatch-icon-wrapper">
						<span class="icon-image-center"></span>
						<span class="hatch-icon-description">
							Center
						</span>
					</a>
				</div>
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
				<span>Design Bar Horizontal</span>
			</a>

			<section class="hatch-accordion-section hatch-content">

				<p>Check the slider accordion ;)</p>
					
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

								<div class="hatch-visuals hatch-visuals-horizontal">
									<ul class="hatch-visuals-wrapper hatch-clearfix">
										<li class="hatch-visuals-item">
											<a href="" class="hatch-icon-wrapper">
												<span class="icon-display"></span>
												<span class="hatch-icon-description">
													Display
												</span>
											</a>
											<div class="hatch-visuals-settings-wrapper hatch-animate hatch-content-small">
												<div class="hatch-visuals-settings">
													<p class="hatch-checkbox-wrapper">
														<input type="checkbox"/>
														<label>Checkbox</label>
													</p>
													<p class="hatch-checkbox-wrapper">
														<input type="checkbox"/>
														<label>Checkbox</label>
													</p>
													<p class="hatch-radio-wrapper">
														<input type="radio"/>
														<label>Radio</label>
													</p>
													<p class="hatch-radio-wrapper">
														<input type="radio"/>
														<label>Radio</label>
													</p>
												</div>
											</div>
										</li>

										<li class="hatch-visuals-item">
											<a href="" class="hatch-icon-wrapper">
												<span class="icon-font-size"></span>
												<span class="hatch-icon-description">
													Font
												</span>
											</a>
										</li>

										<li class="hatch-visuals-item">
											<a href="" class="hatch-icon-wrapper">
												<span class="icon-text-center"></span>
												<span class="hatch-icon-description">
													Text Align
												</span>
											</a>
											<div class="hatch-visuals-settings-wrapper hatch-animate hatch-small">
												<div class="hatch-visuals-settings">
													<a href="" class="hatch-icon-wrapper hatch-active">
														<span class="icon-text-left"></span>
														<span class="hatch-icon-description">
															Left
														</span>
													</a>
													<a href="" class="hatch-icon-wrapper">
														<span class="icon-text-right"></span>
														<span class="hatch-icon-description">
															Right
														</span>
													</a>
													<a href="" class="hatch-icon-wrapper">
														<span class="icon-text-center"></span>
														<span class="hatch-icon-description">
															Center
														</span>
													</a>
													<a href="" class="hatch-icon-wrapper">
														<span class="icon-text-justify"></span>
														<span class="hatch-icon-description">
															Justify
														</span>
													</a>
												</div>
											</div>
										</li>

										<li class="hatch-visuals-item hatch-last">
											<a href="" class="hatch-icon-wrapper">
												<span class="icon-photo"></span>
												<span class="hatch-icon-description">
													Background
												</span>
											</a>
											<div class="hatch-visuals-settings-wrapper hatch-animate hatch-content-small">
												<div class="hatch-visuals-settings">
													<section class="hatch-push-bottom">
														<img src="http://obox.beta/wp-content/uploads/2014/08/city-scape.jpg" />
													</section>
													<section class="hatch-push-bottom">
														<a href="#" class="hatch-button btn-primary btn-full">Upload Image</a>
													</section>
													<section>
														<p class="hatch-checkbox-wrapper">
															<input type="checkbox"/>
															<label>Tile</label>
														</p>
														<p class="hatch-checkbox-wrapper">
															<input type="checkbox"/>
															<label>Stretch</label>
														</p>
														<p class="hatch-checkbox-wrapper">
															<input type="checkbox"/>
															<label>Fixed</label>
														</p>
														<p class="hatch-checkbox-wrapper">
															<input type="checkbox"/>
															<label>Darken</label>
														</p>
													</section>
												</div>
											</div>
										</li>

										<li class="hatch-visuals-item hatch-last">
											<a href="" class="hatch-icon-wrapper">
												<span class="icon-image-left"></span>
												<span class="hatch-icon-description">
													Image Align
												</span>
											</a>
											<div class="hatch-visuals-settings-wrapper hatch-animate hatch-small">
												<div class="hatch-visual-settings">
													<a href="" class="hatch-icon-wrapper">
														<span class="icon-image-left"></span>
														<span class="hatch-icon-description">
															Left
														</span>
													</a>
													<a href="" class="hatch-icon-wrapper hatch-active">
														<span class="icon-image-right"></span>
														<span class="hatch-icon-description">
															Right
														</span>
													</a>
													<a href="" class="hatch-icon-wrapper">
														<span class="icon-image-center"></span>
														<span class="hatch-icon-description">
															Center
														</span>
													</a>
												</div>
											</div>
										</li>
									</ul>
								</div>

								<div class="hatch-row">
									<div class="hatch-panel">
										<div class="hatch-panel-title">
											<span class="tooltip" tooltip="Place your help text here please."></span>
											<h4 class="heading">Feature Image</h4>
										</div>
										<div class="hatch-content">
											<a href="#" class="hatch-image-uploader hatch-small hatch-animate hatch-push-bottom">
												<img class="image-reveal" src="http://demo.oboxsites.com/express/files/2013/12/graphy-tile.png">
											</a>
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