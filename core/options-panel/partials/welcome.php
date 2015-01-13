<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Instantiate the widget migrator
$layers_migrator = new Layers_Widget_Migrator(); ?>

<?php // Get builder pages
$find_builder_page = layers_get_builder_pages(); ?>

<section class="layers-welcome">

	<div class="layers-page-title highlight layers-section-title layers-large layers-content-massive invert layers-no-push-bottom">
		<div class="layers-container">
			<a href="http://oboxthemes.com/layers" class="layers-logo">Layers</a>
			<h2 class="layers-heading" id="layers-options-header">Thank you for installing Layers!</h2>
			<p class="layers-excerpt">
				<?php _e( 'Layers is a site builder with a lightweight design interface built into the WordPress Visual Customizer.', LAYERS_THEME_SLUG ); ?>
			</p>
		</div>
	</div>

	<div class="layers-row layers-well layers-content-massive">
		<div class="layers-container">

			<div class="layers-row layers-divide">
				<div class="layers-section-title">
					<h4 class="layers-heading"><?php _e( 'What you need', LAYERS_THEME_SLUG ); ?></h4>
					<p class="layers-excerpt">
						<?php _e( 'In order to get going you\'ll need to make sure you have the following:', LAYERS_THEME_SLUG ); ?>
					</p>
				</div>
				<div class="layers-row">
					<div class="layers-column layers-span-4 layers-media layers-t-center">
						<div class="layers-media-image">
							<img src="<?php echo get_template_directory_uri() . '/core/assets/images/wordpress-4.png'; ?>" />
						</div>
						<div class="layers-media-body">
							<h4 class="layers-heading"><?php _e( 'WordPress 4.0', LAYERS_THEME_SLUG ); ?></h4>
							<p class="layers-excerpt">
								<?php _e( 'Layers requires you run the latest version of WordPress, please make sure you\'re up to date!', LAYERS_THEME_SLUG ); ?>
							</p>
							<div class="layers-btn-group">
								<?php if( 4.0 <= get_bloginfo('version') ) { ?>
									<span class="tick"><?php _e( 'You\'re up to date.' , LAYERS_THEME_SLUG ); ?></span>
								<?php } else { ?>
									<a class="layers-button btn-primary" href="<?php echo admin_url( '/update-core.php' ); ?>" target="_blank"><?php _e( 'Update WordPress', LAYERS_THEME_SLUG ); ?></a>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="layers-column layers-span-4 layers-media layers-t-center">
						<div class="layers-media-image">
							<img src="<?php echo get_template_directory_uri() . '/core/assets/images/jetpack.png'; ?>" />
						</div>
						<div class="layers-media-body">
							<h4 class="layers-heading"><?php _e( 'Jetpack for WordPress', LAYERS_THEME_SLUG ); ?></h4>
							<p class="layers-excerpt">
							<?php _e( 'Jetpack is required for portfolio functionality to work in this version of Layers.', LAYERS_THEME_SLUG ); ?>
							</p>
							<div class="layers-btn-group">
								<?php if( defined( 'JETPACK__VERSION' ) ) { ?>
									<span class="tick"><?php _e( 'Jetpack is installed.', LAYERS_THEME_SLUG ); ?></span>
								<?php } else { ?>
									<a class="layers-button btn-primary" href="<?php echo admin_url( '/plugin-install.php?tab=search&s=Jetpack'); ?>" target="_blank"><?php _e( 'Install Jetpack', LAYERS_THEME_SLUG ); ?></a>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="layers-column layers-span-4 layers-media layers-t-center">
						<div class="layers-media-image">
							<img src="<?php echo get_template_directory_uri() . '/core/assets/images/layers-woo.png'; ?>" />
						</div>
						<div class="layers-media-body">
							<h4 class="layers-heading"><?php _e( 'Layers WooCommerce Extension', LAYERS_THEME_SLUG ); ?></h4>
							<p class="layers-excerpt">
								<?php _e( 'If you\'d like to test out eCommerce then you\'ll need to install the Layers WooCommerce Extension.', LAYERS_THEME_SLUG ); ?>
							</p>
							<div class="layers-btn-group">
								<?php if( class_exists( 'Layers_WooCommerce' ) ) { ?>
									<span class="tick"><?php _e( 'Instaled.', LAYERS_THEME_SLUG ); ?></span>
								<?php } else { ?>
									<a class="layers-button btn-primary" href="<?php echo 'http://cdn.oboxsites.com/layers/layers-woocommerce.zip?ver=' . rand(0 , 100); ?>" target="_blank"><?php _e( 'Install WooCommerce for Layers', LAYERS_THEME_SLUG ); ?></a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="layers-row layers-divide">
				<div class="layers-section-title">
					<h4 class="layers-heading">What you can and can't do</h4>
					<p class="layers-excerpt">
						<?php _e( 'Here\'s a breakdown of what works and what may cause you issues during testing:', LAYERS_THEME_SLUG ); ?>
					</p>
				</div>
				<div class="layers-row">
					<div class="layers-column layers-span-6 layers-no-push-bottom">
						<ul class="layers-feature-list">
							<li class="tick"><?php _e( 'Create a page builder template', LAYERS_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Mess around with the design bar', LAYERS_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Choose between 4 different Header layouts', LAYERS_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Configure: Slider widget', LAYERS_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Configure: Content widget', LAYERS_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Configure: Posts widget', LAYERS_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Configure: Portfolio widget', LAYERS_THEME_SLUG ); ?></li>
							<li class="tick"><?php _e( 'Configure: Contact widget', LAYERS_THEME_SLUG ); ?></li>
						</ul>
					</div>
					<div class="layers-column layers-span-6 layers-no-push-bottom">
						<ul class="layers-feature-list">
							<li class="cross"><?php _e( 'Change footer layouts', LAYERS_THEME_SLUG ); ?></li>
							<li class="cross"><?php _e( 'Switch fonts', LAYERS_THEME_SLUG ); ?></li>
							<li class="cross"><?php _e( 'Edit colors', LAYERS_THEME_SLUG ); ?></li>
							<li class="cross"><?php _e( 'Edit the blog layout', LAYERS_THEME_SLUG ); ?></li>
							<li class="cross"><?php _e( 'Automatically update Layers', LAYERS_THEME_SLUG ); ?></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="layers-row layers-divide">
				<div class="layers-section-title">
					<h3 class="layers-heading"><?php _e( 'Get started by choosing a page layout', LAYERS_THEME_SLUG ); ?></h3>
					<p class="layers-excerpt">
						<?php _e( 'Knowing where to begin with a site builder is never easy.
						Choosing a preset template below will pre-populate your page with some Layers widgets to help get started.', LAYERS_THEME_SLUG ); ?>
					</p>
					<a href="<?php echo admin_url( 'admin.php?page=layers-preset-layouts' ); ?>" class="layers-button btn-primary btn-large"><?php _e( 'Select a Layout &rarr;', LAYERS_THEME_SLUG ); ?></a>
				</div>
			</div>

		</div>
	</div>
</section>
<?php $this->footer(); ?>

