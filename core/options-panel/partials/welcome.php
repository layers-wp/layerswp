<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Instantiate the widget migrator
$hatch_migrator = new Hatch_Widget_Migrator(); ?>

<?php // Get builder pages
$find_builder_page = hatch_get_builder_pages(); ?>

<section class="hatch-welcome">

	<div class="hatch-page-title hatch-section-title hatch-large hatch-content-massive invert hatch-no-push-bottom">
		<div class="hatch-container">
			<h2 class="hatch-heading" id="hatch-options-header">Thank you for installing Hatch!</h2>
			<p class="hatch-excerpt">
				<?php _e( 'Hatch is a site builder with a lightweight design interface built into the WordPress Visual Customizer.', HATCH_THEME_SLUG ); ?>
			</p>
		</div>
	</div>

	<div class="hatch-row hatch-well hatch-content-massive">
		<div class="hatch-container">

			<div class="hatch-row hatch-divide">
				<div class="hatch-section-title">
					<h4 class="hatch-heading"><?php _e( 'What you need', HATCH_THEME_SLUG ); ?></h4>
					<p class="hatch-excerpt">
						<?php _e( 'In order to get going you\'ll need to make sure you have the following:', HATCH_THEME_SLUG ); ?>
					</p>
				</div>
				<div class="hatch-row">
					<div class="hatch-column hatch-span-4 hatch-media hatch-t-center">
						<div class="hatch-media-image">
							<img src="<?php echo get_template_directory_uri() . '/core/assets/images/wordpress-4.png'; ?>" />
						</div>
						<div class="hatch-media-body">
							<h4 class="hatch-heading"><?php _e( 'WordPress 4.0', HATCH_THEME_SLUG ); ?></h4>
							<p class="hatch-excerpt">
								<?php _e( 'Hatch requires you run the latest version of WordPress, please make sure you\'re up to date!', HATCH_THEME_SLUG ); ?>
							</p>
							<div class="hatch-btn-group">
								<a class="hatch-button btn-primary" href="<?php echo admin_url( '/update-core.php' ); ?>" target="_blank"><?php _e( 'Update WordPress', HATCH_THEME_SLUG ); ?></a>
							</div>
						</div>
					</div>
					<div class="hatch-column hatch-span-4 hatch-media hatch-t-center">
						<div class="hatch-media-image">
							<img src="<?php echo get_template_directory_uri() . '/core/assets/images/jetpack.png'; ?>" />
						</div>
						<div class="hatch-media-body">
							<h4 class="hatch-heading"><?php _e( 'Jetpack for WordPress', HATCH_THEME_SLUG ); ?></h4>
							<p class="hatch-excerpt">
								<?php _e( 'Jetpack is required for logo and portfolio functionality to work in this version of Hatch.', HATCH_THEME_SLUG ); ?>
							</p>
							<div class="hatch-btn-group">
								<a class="hatch-button btn-primary" href="<?php echo admin_url( '/plugin-install.php?tab=search&s=Jetpack'); ?>" target="_blank"><?php _e( 'Install Jetpack', HATCH_THEME_SLUG ); ?></a>
							</div>
						</div>
					</div>
					<div class="hatch-column hatch-span-4 hatch-media hatch-t-center">
						<div class="hatch-media-image">
							<img src="<?php echo get_template_directory_uri() . '/core/assets/images/hatch-woo.png'; ?>" />
						</div>
						<div class="hatch-media-body">
							<h4 class="hatch-heading"><?php _e( 'Hatch WooCommerce Extension', HATCH_THEME_SLUG ); ?></h4>
							<p class="hatch-excerpt">
								<?php _e( 'If you\'d like to test out eCommerce then you\'ll need to install the Hatch WooCommerce Extension.', HATCH_THEME_SLUG ); ?>
							</p>
							<div class="hatch-btn-group">
								<a class="hatch-button btn-primary" href="<?php echo 'http://cdn.oboxsites.com/hatch/hatch-woocommerce.zip?ver=' . rand(0 , 100); ?>" target="_blank"><?php _e( 'Install WooCommerce for Hatch', HATCH_THEME_SLUG ); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="hatch-row hatch-divide">
				<div class="hatch-section-title">
					<h4 class="hatch-heading">What you can and can't do</h4>
					<p class="hatch-excerpt">
						<?php _e( 'Here\'s a breakdown of what works and what may cause you issues during testing:', HATCH_THEME_SLUG ); ?>
					</p>
				</div>
				<div class="hatch-row">
					<div class="hatch-column hatch-span-6 hatch-no-push-bottom">
						<ul class="hatch-feature-list">
							<li class="tick"><?php _e( 'Create a page builder template', HATCH_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Mess around with the design bar', HATCH_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Choose between 4 different Header layouts', HATCH_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Configure: Slider widget', HATCH_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Configure: Content widget', HATCH_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Configure: Posts widget', HATCH_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Configure: Portfolio widget', HATCH_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Configure: Contact widget', HATCH_THEME_SLUG ); ?></li>
						</ul>
					</div>
					<div class="hatch-column hatch-span-6 hatch-no-push-bottom">
						<ul class="hatch-feature-list">
							<li class="cross"><?php _e( 'Change footer layouts', HATCH_THEME_SLUG ); ?></li>
							<li class="cross"><?php _e( 'Switch fonts', HATCH_THEME_SLUG ); ?></li>
							<li class="cross"><?php _e( 'Edit colors', HATCH_THEME_SLUG ); ?></li>
							<li class="cross"><?php _e( 'Edit the blog layout', HATCH_THEME_SLUG ); ?></li>
							<li class="cross"><?php _e( 'Automatically update Hatch', HATCH_THEME_SLUG ); ?></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="hatch-row hatch-divide">
				<div class="hatch-section-title">
					<h3 class="hatch-heading"><?php _e( 'Get started by choosing a page template', HATCH_THEME_SLUG ); ?></h3>
					<p class="hatch-excerpt">
						<?php _e( 'Knowing where to begin with a site builder is never easy.
						Choosing a preset template below will pre-populate your page with some Hatch widgets to help get started.', HATCH_THEME_SLUG ); ?>
					</p>
					<a href="<?php echo admin_url( 'admin.php?page=hatch-preset-layouts' ); ?>" class="hatch-button btn-primary btn-large"><?php _e( 'Choose a Layout', HATCH_THEME_SLUG ); ?></a>
				</div>
			</div>

		</div>
	</div>
</section>
<?php $this->footer(); ?>