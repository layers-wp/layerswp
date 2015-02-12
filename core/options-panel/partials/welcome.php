<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Get builder pages
$find_builder_page = layers_get_builder_pages(); ?>

<section class="layers-area-wrapper">

	<div class="layers-page-title layers-section-title layers-large layers-content-large layers-no-push-bottom">
		<div class="layers-container">
			<a href="http://oboxthemes.com/layers" class="layers-logo"><?php _e( 'Layers', LAYERS_THEME_SLUG ); ?></a>
			<h2 class="layers-heading" id="layers-options-header"><?php _e( 'Dashboard', LAYERS_THEME_SLUG ); ?></h2>

			<nav class="layers-nav-horizontal layers-dashboard-nav">
				<ul>
					<?php foreach( $this->get_menu_pages()  as $menu_key => $menu_details ) { ?>
						<li <?php if( strpos( $menu_details[ 'link' ], 'layers-welcome' ) ) { ?>class="active"<?php } ?>>
							<a href="<?php echo $menu_details[ 'link' ]; ?>">
								<?php echo $menu_details[ 'label' ]; ?>
							</a>
						</li>
					<?php }?>
				</ul>
			</nav>

		</div>
	</div>

	<div class="layers-row layers-well layers-content-large">
		<div class="layers-container-large">


			<div class="layers-row">

				<div class="layers-column layers-span-4">

					<div class="layers-panel layers-content layers-push-bottom">
						<div class="layers-section-title layers-small">
							<h3 class="layers-heading"><?php _e( 'Start Using Layers', LAYERS_THEME_SLUG ); ?></h3>
							<p class="layers-excerpt">
								<?php _e( 'Follow the easy steps to creating amazing layouts quickly and easily. ', LAYERS_THEME_SLUG ); ?>
							</p>
						</div>
						<a href="<?php echo admin_url( 'admin.php?page=layers-get-started' ); ?>" class="layers-button btn-large btn-primary">
							<?php _e( 'Get Started &rarr;', LAYERS_THEME_SLUG ); ?>
						</a>
					</div>

					<div class="layers-panel layers-push-bottom">
						<div class="layers-panel-title">
							<h4 class="layers-heading"><?php _e( 'Layers Pages', LAYERS_THEME_SLUG ); ?></h4>
						</div>
						<ul class="layers-list layers-page-list">
							<?php foreach( layers_get_builder_pages() as $page ) { ?>
								<li>
									<a class="layers-page-list-title" href="<?php echo admin_url( 'post.php?post=' . $page->ID . '&action=edit' ); ?>"><?php echo $page->post_title; ?></a>
									<!-- <pre><?php print_r( $page ) ; ?></pre> -->
									<span class="layers-pull-right">
										<a href=""><?php _e( 'Edit Layout' , LAYERS_THEME_SLUG ); ?></a> |
										<a href="<?php echo admin_url( 'post.php?post=' . $page->ID . '&action=edit' ); ?>"><?php _e( 'Edit' , LAYERS_THEME_SLUG ); ?></a> |
										<a href="<?php echo get_the_permalink( $page->ID ); ?>"><?php _e( 'View' , LAYERS_THEME_SLUG ); ?></a>
									</span>
								</li>
							<?php }?>
						</ul>
						<div class="layers-button-well">
							<a href="<?php echo admin_url( 'admin.php?page=add-new-page' ); ?>" class="layers-button btn-primary">
								<?php _e( 'Add New Page', LAYERS_THEME_SLUG ); ?>
							</a>
						</div>
					</div>

				</div>

				<div class="layers-column layers-span-5">

					<div class="layers-panel">
						<div class="layers-panel-title">
							<h4 class="layers-heading"><?php _e( 'Extensions', LAYERS_THEME_SLUG ); ?></h4>
						</div>
						<ul class="layers-list layers-extensions">
							<li>
								<h3 class="layers-heading">
									<?php _e( 'Layers WooCommerce Extension', LAYERS_THEME_SLUG ); ?>
								</h3>
								<p>
									<?php _e( 'If you\'d like to test out eCommerce then you\'ll need to install the Layers WooCommerce Extension.', LAYERS_THEME_SLUG ); ?>
								</p>
								<div class="layers-btn-group">
									<?php if( class_exists( 'Layers_WooCommerce' ) ) { ?>
										<span class="layers-success"><?php _e( 'Installed!', LAYERS_THEME_SLUG ); ?></span>
									<?php } else { ?>
										<a class="layers-button btn-primary" href="<?php echo 'http://cdn.oboxsites.com/layers/layers-woocommerce.zip?ver=' . rand(0 , 100); ?>" target="_blank">
											<?php _e( 'Install WooCommerce for Layers', LAYERS_THEME_SLUG ); ?>
										</a>
									<?php } ?>
								</div>
							</li>
							<li>
								<h3 class="layers-heading">
									<?php _e( 'Name', LAYERS_THEME_SLUG ); ?>
								</h3>
								<p>
									<?php _e( '
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa.
										Sed ac orci libero, eu dignissim enim.
									', LAYERS_THEME_SLUG ); ?>
								</p>
								<div class="layers-btn-group">
									<a class="layers-button" href="" target="_blank">
										<?php _e( 'Purchase', LAYERS_THEME_SLUG ); ?>
									</a>
									<a class="layers-button btn-link" href="" target="_blank">
										<?php _e( 'More Details', LAYERS_THEME_SLUG ); ?>
									</a>
								</div>
							</li>
							<li>
								<h3 class="layers-heading">
									<?php _e( 'Name', LAYERS_THEME_SLUG ); ?>
								</h3>
								<p>
									<?php _e( '
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae massa velit, eu laoreet massa.
										Sed ac orci libero, eu dignissim enim.
									', LAYERS_THEME_SLUG ); ?>
								</p>
								<div class="layers-btn-group">
									<a class="layers-button" href="" target="_blank">
										<?php _e( 'Purchase', LAYERS_THEME_SLUG ); ?>
									</a>
									<a class="layers-button btn-link" href="" target="_blank">
										<?php _e( 'More Details', LAYERS_THEME_SLUG ); ?>
									</a>
								</div>
							</li>
						</ul>
						<div class="layers-button-well">
							<a class="layers-button btn-primary" href="" target="_blank">
								<?php _e( 'View More Extensions', LAYERS_THEME_SLUG ); ?>
							</a>
						</div>
					</div>
				</div>

				<div class="layers-column layers-span-3">
					<div class="layers-panel layers-push-bottom">
						<div class="layers-panel-title">
							<h4 class="layers-heading"><?php _e( 'What you need', LAYERS_THEME_SLUG ); ?></h4>
						</div>
						<ul class="layers-list layers-extensions">
							<li>
								<h4 class="layers-heading"><?php _e( 'WordPress 4.0', LAYERS_THEME_SLUG ); ?></h4>
								<p>
									<?php _e( 'Layers requires you run the latest version of WordPress, please make sure you\'re up to date!', LAYERS_THEME_SLUG ); ?>
								</p>
								<div class="layers-btn-group">
									<?php if( 4.0 <= get_bloginfo('version') ) { ?>
										<span class="layers-success"><?php _e( 'You\'re up to date' , LAYERS_THEME_SLUG ); ?></span>
									<?php } else { ?>
										<a class="layers-button btn-primary" href="<?php echo admin_url( '/update-core.php' ); ?>" target="_blank"><?php _e( 'Update WordPress', LAYERS_THEME_SLUG ); ?></a>
									<?php } ?>
								</div>
							</li>
						</ul>
					</div>
					<div class="layers-panel">
						<div class="layers-panel-title">
							<h4 class="layers-heading"><?php _e( 'Helpful Tips', LAYERS_THEME_SLUG ); ?></h4>
						</div>
						<div class="layers-content">
		                    <video width="490" height="auto" controls>
		                        <source src="http://cdn.oboxsites.com/layers/videos/adding-a-widget.mp4?v=<?php echo LAYERS_VERSION; ?>" type="video/mp4">
		                        Your browser does not support the video tag.
		                    </video>
	                    </div>
					</div>
				</div>

			</div>

		</div>
	</div>
</section>
<?php $this->footer(); ?>

