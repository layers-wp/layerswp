<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Instantiate the widget migrator
$hatch_migrator = new Hatch_Widget_Migrator(); ?>

<?php // Get builder pages
$find_builder_page = hatch_get_builder_pages(); ?>

<section class="hatch-container hatch-content-large">

	<div class="hatch-section-title hatch-large invert hatch-content-massive" style="background: url(<?php echo get_template_directory_uri(); ?>/images/beta-zero.jpg) top repeat;">
		<div class="hatch-container hatch-t-center">
			<h2 class="hatch-heading" id="hatch-options-header">Thank you for installing Hatch!</h2>
			<p class="hatch-excerpt">
				Hatch is a site builder with a lightweight design interface built into the WordPress Visual Customizer.
			</p>
		</div>
	</div>

	<div class="hatch-row hatch-well hatch-content-large hatch-push-bottom">
		<div class="hatch-section-title hatch-push-bottom">
			<h4 class="hatch-heading">What you need for Hatch to work</h4>
			<p class="hatch-excerpt">
				During this phase of development there are a couple of requirements before you can get going:
			</p>
		</div>
		<div class="hatch-row">
			<div class="hatch-column hatch-span-4 hatch-media">
				<div class="hatch-media-image">
					<img src="<?php echo get_template_directory_uri() . '/core/assets/images/wordpress-4.png'; ?>" />
				</div>
				<div class="hatch-media-body">
					<h4 class="hatch-heading">WordPress 4.0</h4>
					<p class="hatch-excerpt">
						Hatch requires you run the latest version of WordPress, please make sure you're up to date!
					</p>
					<div class="hatch-btn-group">
						<a class="hatch-button btn-primary" href="">Update WordPress</a>
					</div>
				</div>
			</div>
			<div class="hatch-column hatch-span-4 hatch-media">
				<div class="hatch-media-image">
					<img src="<?php echo get_template_directory_uri() . '/core/assets/images/jetpack.png'; ?>" />
				</div>
				<div class="hatch-media-body">
					<h4 class="hatch-heading">Jetpack for WordPress</h4>
					<p class="hatch-excerpt">
						Jetpack is required for logo and portfolio functionality to work in this version of Hatch.
					</p>
					<div class="hatch-btn-group">
						<a class="hatch-button btn-primary" href="">Install Jetpack</a>
					</div>
				</div>
			</div>
			<div class="hatch-column hatch-span-4 hatch-media">
				<div class="hatch-media-image">
					<img src="<?php echo get_template_directory_uri() . '/core/assets/images/hatch-woo.png'; ?>" />
				</div>
				<div class="hatch-media-body">
					<h4 class="hatch-heading">Hatch WooCommerce Extension</h4>
					<p class="hatch-excerpt">
						If you'd like to test out eCommerce then you'll need to install the Hatch WooCommerce Extension.
					</p>
					<div class="hatch-btn-group">
						<a class="hatch-button btn-primary" href="">Install WooCommerce for Hatch</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="hatch-row hatch-well hatch-content-large hatch-push-bottom">
		<div class="hatch-section-title hatch-push-bottom">
			<h4 class="hatch-heading">What you can do and what can't do</h4>
			<p class="hatch-excerpt">
				We are calling this release 'Beta Zero,' as it's just grown up enough to be out of private Alpha.
				However, it's not yet fully functional, so please be patient :)
			</p>
		</div>
		<div class="hatch-row">
			<div class="hatch-column hatch-span-6">
				<div class="hatch-section-title hatch-tiny">
					<h5 class="hatch-heading">What you can do:</h5>
				</div>
				<ul class="hatch-feature-list">
					<li class="tick">Create a page builder template</li>
					<li class="tick">Mess around with the design bar</li>
					<li class="tick">Choose between 4 different Header layouts</li>
					<li class="tick">Configure: Slider widget</li>
					<li class="tick">Configure: Content widget</li>
					<li class="tick">Configure: Posts widget</li>
					<li class="tick">Configure: Portfolio widget</li>
					<li class="tick">Configure: Contact widget</li>
				</ul>
			</div>
			<div class="hatch-column hatch-span-6">
				<div class="hatch-section-title hatch-tiny">
					<h5 class="hatch-heading">What you can't do:</h5>
				</div>
				<ul class="hatch-feature-list">
					<li class="cross">Change footer layouts</li>
					<li class="cross">Switch fonts</li>
					<li class="cross">Edit colors</li>
					<li class="cross">Edit the blog layout</li>
				</ul>
			</div>
		</div>
	</div>
		
	<div class="hatch-row hatch-well hatch-content-large hatch-push-bottom">
		<div class="hatch-section-title hatch-push-bottom">
			<h3 class="hatch-heading">Get started by choosing a page template</h3>
			<p class="hatch-excerpt">
				Knowing where to start with your sites content is never easy, choose a starting point below to get the ball rolling.
				By choosing a preset layout below your new page will be automatically populated with some Hatch widgets to help get started.
			</p>
		</div>

		<div class="hatch-row">
			<?php foreach( $hatch_migrator->get_preset_layouts() as $template_key => $template ) { ?>
				<div class="hatch-column hatch-span-4 hatch-media <?php echo ( isset( $template[ 'container_css' ] ) ?  $template[ 'container_css' ] : '' ); ?>">
					
					<label for="hatch-preset-layout-<?php echo $template_key; ?>" id="hatch-generate-preset-layout-<?php echo $template_key; ?>">
						
						<div class="hatch-media-image">
							<?php echo $hatch_migrator->generate_preset_layout_screenshot( $template[ 'screenshot' ], $template[ 'screenshot_type' ] ); ?>
						</div>

						<h4 class="hatch-heading">
							<?php echo $template[ 'title' ]; ?>
						</h4>

						<?php if( isset( $template[ 'description' ] ) ) { ?>
							<p class="hatch-excerpt">
								<?php echo $template[ 'description' ]; ?>
							</p>
						<?php } ?>

						<input id="hatch-preset-layout-<?php echo $template_key; ?>-title" type="hidden" value="<?php echo $template[ 'title' ]; ?>" />
						<input id="hatch-preset-layout-<?php echo $template_key; ?>-widget_data" type="hidden" value="<?php echo esc_attr( $template[ 'json' ] ); ?>" />
					
					</label>

				</div>
			<?php } // Get Preset Layouts ?>
		</div>

	</div>

	<footer class="hatch-row">
		<p>
			Hatch is a product of <a href="http://oboxthemes.com/">Obox Themes</a>. For questions and feedback please <a href="mailto:david@obox.co.za">email David directly</a>.
		</p>
	</footer>


</section>

<?php $this->footer(); ?>