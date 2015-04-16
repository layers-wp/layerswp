<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Instantiate Inputs
$form_elements = new Layers_Form_Elements(); ?>

<?php // Get the API up and running for the plugin listing
$api = new Layers_API(); ?>

<?php // Load up Layers theme info
$theme_info = wp_get_theme( 'layerswp' ); ?>

<section id="layers-dashboard-page" class="layers-area-wrapper">

	<?php $this->header( __( 'Dashboard' , 'layerswp' ) ); ?>

	<div class="layers-row layers-well layers-content-large">
		<div class="layers-container-large">

			<div class="layers-row">

				<div class="layers-column layers-span-3">

					<?php if( count( layers_get_builder_pages() ) > 1 ) { ?>

						<?php /*
						* Check to see if we have dismissed or gone through any of the setup steps
						*/
						$dismissed_setup_steps = get_option( 'layers_dismissed_setup_steps' );
						foreach( array_keys( $this->site_setup_actions() ) as $key ) {
							if( !is_array( $dismissed_setup_steps ) || !in_array( $key, $dismissed_setup_steps ) ) {
								$setup_steps[] = $key;
							}
						} ?>

						<?php if( isset( $setup_steps ) ) { ?>
							<div class="layers-panel layers-site-setup-panel">
								<div class="layers-panel-title">
									<h4 class="layers-heading"><?php _e( 'Complete Your Site Setup' , 'layerswp' ); ?></h4>
								</div>
								<?php $setup_index = 0; ?>
								<?php foreach( $this->site_setup_actions() as $setup_key => $setup_details ) {

									if( !in_array( $setup_key, $setup_steps ) ) continue; ?>

									<div class="layers-dashboard-setup-form <?php echo ( 0 != $setup_index ) ? 'layers-hide' : ''; ?>">
										<div class="layers-content">
											<?php if( isset( $setup_details[ 'label' ] ) || isset( $setup_details[ 'excerpt' ] ) ) { ?>
												<div class="layers-section-title layers-tiny">
													<?php if( isset( $setup_details[ 'label' ] ) ) { ?>
														<h3 class="layers-heading"><?php echo $setup_details[ 'label' ]; ?></h3>
													<?php } ?>
													<?php if( isset( $setup_details[ 'excerpt' ] ) ) { ?>
														<p class="layers-excerpt">
															<?php echo $setup_details[ 'excerpt' ]; ?>
														</p>
													<?php } ?>
												</div>
											<?php } ?>
											<?php if( isset( $setup_details[ 'form' ] ) ){ ?>
												<?php foreach( $setup_details[ 'form' ] as $form_id => $form_details ) { ?>
													<div class="layers-form-item">
														<?php $form_elements->input( $form_details ); ?>
													</div>
												<?php } ?>
											<?php } ?>
										</div>
										<?php if( isset( $setup_details[ 'skip-action' ] ) || isset( $setup_details[ 'submit-action' ] ) ) { ?>
											<div class="layers-button-well">
												<?php if( isset( $setup_details[ 'skip-action' ] ) ) { ?>
													<a class="layers-button btn-link layers-pull-right layers-dashboard-skip" data-setup-step-key="<?php echo $setup_key; ?>" data-skip-action="<?php echo $setup_details[ 'skip-action' ]; ?>">
														<?php _e( 'Skip' , 'layerswp' ); ?>
													</a>
												<?php } ?>
												<?php if( isset( $setup_details[ 'submit-action' ] ) ) { ?>
													<a class="layers-button" href="" data-setup-step-key="<?php echo $setup_key; ?>" data-submit-action="<?php echo $setup_details[ 'submit-action' ]; ?>">
														<?php echo ( isset( $setup_details[ 'submit-text' ] ) ) ? $setup_details[ 'submit-text' ] : __( 'Save &amp; Proceed &rarr;' , 'layerswp' ); ?>
													</a>
												<?php } ?>
											</div>
										<?php } ?>
										<?php $setup_index++; ?>
									</div>
								<?php } ?>
							</div>
						<?php } else {
							// Site Setup Contrats
							$this->notice( 'good' , __( 'Well done, your site setup is complete!' , 'layerswp' ) ) ;
						} ?>

						<div class="layers-panel layers-push-bottom">
							<div class="layers-panel-title">
								<h4 class="layers-heading"><?php _e( 'Layers Pages' , 'layerswp' ); ?></h4>
							</div>
							<ul class="layers-list layers-page-list">
									<?php foreach( layers_get_builder_pages() as $page ) { ?>
										<li>
											<a class="layers-page-list-title" href="<?php echo admin_url( 'post.php?post=' . $page->ID . '&action=edit' ); ?>"><?php echo $page->post_title; ?></a>
											<span class="layers-page-edit-links">
												<a href="<?php echo admin_url( 'customize.php?url=' . esc_url( get_the_permalink( $page->ID ) ) ); ?>"><?php _e( 'Edit Layout' , 'layerswp' ); ?></a> |
												<a href="<?php echo admin_url( 'post.php?post=' . $page->ID . '&action=edit' ); ?>"><?php _e( 'Edit' , 'layerswp' ); ?></a> |
												<a href="<?php echo get_the_permalink( $page->ID ); ?>"><?php _e( 'View' , 'layerswp' ); ?></a>
											</span>
										</li>
									<?php }?>
							</ul>
							<div class="layers-button-well">
								<a class="layers-button" href="<?php echo admin_url( 'admin.php?page=layers-add-new-page' ); ?>">
									<?php _e( 'Add New Page' , 'layerswp' ); ?>
								</a>
							</div>
						</div>
					<?php } else { ?>
						<div class="layers-panel layers-content layers-push-bottom">
							<div class="layers-section-title layers-small">
								<h3 class="layers-heading"><?php _e( 'Start Using Layers' , 'layerswp' ); ?></h3>
								<p class="layers-excerpt">
									<?php _e( 'Follow the easy steps to creating amazing layouts quickly and easily. ' , 'layerswp' ); ?>
								</p>
							</div>
							<a href="<?php echo admin_url( 'admin.php?page=layers-get-started' ); ?>" class="layers-button btn-large btn-primary">
								<?php _e( 'Get Started &rarr;' , 'layerswp' ); ?>
							</a>
						</div>
					<?php }?>

				</div>

				<div class="layers-column layers-span-6">
					<div class="layers-panel layers-content layers-push-bottom">
						<div class="layers-section-title layers-tiny">
							<h3 class="layers-heading"><?php _e( 'Themes &amp; Extensions' , 'layerswp' ); ?></h3>
							<p class="layers-excerpt">
								<?php _e( 'Looking for a theme or plugin to achieve something unique with your website?
									Browse the massive Layers Marketplace on Envato and take your site to the next level.' , 'layerswp' ); ?>
							</p>
						</div>
						<a href="{themeforest.net/layers}" class="layers-button btn-primary">
							<?php _e( 'Browse &rarr;' , 'layerswp' ); ?>
						</a>
					</div>

					<?php if( 0 < count( layers_get_plugins() ) ) { ?>
						<div class="layers-panel">
							<div class="layers-panel-title">
								<h4 class="layers-heading"><?php _e( 'Installed Extensions' , 'layerswp' ); ?></h4>
							</div>

							<ul class="layers-list layers-extensions">
								 <?php foreach( layers_get_plugins() as $extension_key => $extension_details ) { ?>
									<li>
										<h4 class="layers-heading">
											<?php echo $extension_details[ 'Name' ]; ?>
										</h4>
										<?php if( isset( $extension_details[ 'Description' ] ) ){ ?>
											<p>
												<?php echo $extension_details[ 'Description' ]; ?>
											</p>
										<?php } ?>
										<?php if( version_compare( $theme_info->get( 'Version' ), $extension_details[ 'Layers Required Version' ], '<' ) ){ ?>
											<?php  $this->notice( 'bad' , __( sprintf( 'Requires Layers %s', $extension_details[ 'Layers Required Version' ] ), 'layerswp' ) ); ?>
										<?php } ?>
									</li>
								<?php } // foreach extensions ?>
							</ul>
						</div>
					<?php } ?>

				</div>
				<div class="layers-column layers-span-3">

					<?php /*
					* Grab the Quick Help Feed
					*/
					$docs = $this->get_layers_feed( 'docs', 10 );

					if( 0 < count( $docs ) && $docs ) { ?>

						<div class="layers-panel layers-push-bottom">
							<div class="layers-panel-title">
								<h4 class="layers-heading">
									<a href="http://docs.layerswp.com/">
										<?php _e( 'Quick Help' , 'layerswp' ); ?>
									</a>
								</h4>
							</div>
							<ul class="layers-list layers-extensions">
								<?php foreach( $docs as $docs_id => $docs_item ) { ?>
									<li>
										<a class="layers-page-list-title" target="_blank" href="<?php echo $docs_item[ 'link' ]; ?>"><?php echo $docs_item[ 'title' ]; ?></a>
									</li>
								<?php } ?>
							</ul>
							<div class="layers-button-well">
								<a class="layers-button" href="http://docs.layerswp.com/" target="_blank">
									<?php _e( 'Get more useful tips' , 'layerswp' ); ?>
								</a>
							</div>
						</div>
					<?php } ?>

					<div class="layers-panel layers-push-bottom">
						<div class="layers-content clearfix">
							<div class="layers-section-title layers-tiny">
								<h3 class="layers-heading"><?php _e( 'Stay in the Loop' , 'layerswp' ); ?></h3>
								<p class="layers-excerpt">
									<?php _e( 'Sign up to our monthly newsletter to find out when we launch new features, products.' , 'layerswp' ); ?>
								</p>
							</div>
							<form action="http://oboxdesign.createsend.com/t/r/s/ittddii/" method="post" id="subForm">
								<div class="layers-form-item layers-form-inline">
									<label for="fieldEmail"><?php _e( 'Email Address' , 'layerswp' ); ?></label>
									<input id="fieldEmail" name="cm-ittddii-ittddii" type="email" placeholder="john@smith.com" />
									<button class="layers-button btn-primary" type="submit">Subscribe</button>
								</div>
							</form>
						</div>
					</div>

					<div class="layers-panel layers-push-bottom">
						<div class="layers-media layers-image-left layers-content layers-no-push-bottom">
							<div class="layers-media-image layers-small">
								<img src="<?php echo LAYERS_TEMPLATE_URI; ?>/core/assets/images/github-badge.png" alt="<?php _e( 'Github badge' , 'layerswp' ); ?>"/>
							</div>
							<div class="layers-media-body">
								<h3 class="layers-heading"><?php _e( 'Contribute to Layers' , 'layerswp' ); ?></h3>
								<p class="layers-excerpt">
									<?php _e( sprintf( 'Get involved with the community of this awesome project
									and contribute enhancements, features, and bug fixes to the core code of
									<a href="%s" target="_blank">Layers on GitHub</a>. Check out the Issues tab for ways to help!',
									'http://github.com/Obox/layerswp/' ) , 'layerswp' ); ?>
								</p>
							</div>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
</section>

<?php /*
* Grab the News Feed
*/
$news = $this->get_layers_feed( 'news' );

if( 0 < count( $news ) && $news ) { ?>
	<section class="layers-area-wrapper">
		<div class="layers-row layers-well-alt layers-content-large">

			<div class="layers-section-title layers-small">
				<h3 class="layers-heading"><?php _e( 'Layers News' , 'layerswp' ); ?></h3>
			</div>

			<div class="layers-row">
				<?php foreach( $news as $news_id => $news_item ) { ?>
					<div class="layers-column layers-span-3">
						<div class="layers-panel">
							<div class="layers-content">
								<div class="layers-section-title layers-tiny">
									<h4 class="layers-heading">
										<a href="<?php echo $news_item[ 'link' ]; ?>">
											<?php echo $news_item[ 'title' ]; ?>
										</a>
									</h4>
								</div>
								<div class="layers-excerpt">
									<?php echo $news_item[ 'excerpt' ]; ?>
								</div>
							</div>
							<div class="layers-button-well">
								<a href="<?php echo $news_item[ 'link' ]; ?>" class="layers-button" target="_blank">
									<?php _e( 'Continue Reading' , 'layerswp' ); ?>
								</a>
							</div>
						</div>

					</div>
				<?php } ?>
			</div>
		</div>
	</section>
<?php } ?>

<?php $this->footer(); ?>