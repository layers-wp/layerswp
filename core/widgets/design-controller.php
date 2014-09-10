<?php /**
 * Widget Design Controller Class
 *
 * This file is the source of the Widget Design Pop out  in Hatch.
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Design_Controller {

	/**
	* Generate incremental options
	*
	* @param  	array     	$options() 	Element Support
	* @param  	array     	$options() 	Array of custom elements which are not common
	*/

	function bar( $supports = array( 'columns' , 'background' , 'image-align' ) , $custom_elements = array() ) { ?>

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
					<div class="hatch-design-properties-wrapper">
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
					<div class="hatch-design-properties-wrapper">
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
	<?php }
} //class Hatch_Design_Controller