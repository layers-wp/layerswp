<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Instantiate Inputs
$form_elements = new Layers_Form_Elements(); ?>

<?php // Get the API up and running for the plugin listing
$api = new Layers_API(); ?>

<?php // Load up Layers theme info
$theme_info = wp_get_theme( 'layerswp' ); ?>

<section id="layers-dashboard-page" class="l_admin-area-wrapper">

	<?php $this->header( __( 'Dashboard' , 'layerswp' ) ); ?>

	<div class="l_admin-well l_admin-content">
		<div class="l_admin-container-large">
			<div class="l_admin-row">

				<div class="l_admin-column l_admin-span-3">

					<?php if( count( layers_get_builder_pages() ) > 0 ) { ?>

						<?php /*
						* Check to see if we have dismissed or gone through any of the setup steps
						*/
						$dismissed_setup_steps = get_option( 'layers_dismissed_setup_steps' );
						foreach( array_keys( $this->site_setup_actions() ) as $key ) {
							if( !is_array( $dismissed_setup_steps ) || !in_array( $key, $dismissed_setup_steps ) ) {
								$setup_steps[] = $key;
							}
						} ?>

						<?php if( isset( $setup_steps ) ) {
							$this->notice( 'neutral' , __( 'Click here to continue your site setup.' , 'layerswp' ), array( 'layers-continue-site-setup', 'l_admin-hide' ) ) ; ?>
							<div class="l_admin-panel l_admin-site-setup-panel">
								<div class="l_admin-panel-title">
									<h4 class="l_admin-heading"><?php _e( 'Complete Your Site Setup' , 'layerswp' ); ?></h4>
								</div>
								<?php $setup_index = 0; ?>
								<?php foreach( $this->site_setup_actions() as $setup_key => $setup_details ) {

									if( !in_array( $setup_key, $setup_steps ) ) continue; ?>

									<div class="l_admin-dashboard-setup-form <?php echo ( 0 != $setup_index ) ? 'l_admin-hide' : ''; ?>">
										<div class="l_admin-content">
											<?php if( isset( $setup_details[ 'label' ] ) || isset( $setup_details[ 'excerpt' ] ) ) { ?>
												<div class="l_admin-section-title l_admin-tiny">
													<?php if( isset( $setup_details[ 'label' ] ) ) { ?>
														<h3 class="l_admin-heading"><?php echo $setup_details[ 'label' ]; ?></h3>
													<?php } ?>
													<?php if( isset( $setup_details[ 'excerpt' ] ) ) { ?>
														<p class="l_admin-excerpt">
															<?php echo $setup_details[ 'excerpt' ]; ?>
														</p>
													<?php } ?>
												</div>
											<?php } ?>
											<?php if( isset( $setup_details[ 'form' ] ) ){ ?>
												<?php foreach( $setup_details[ 'form' ] as $form_id => $form_details ) { ?>
													<div class="l_admin-form-item">
														<?php $form_elements->input( $form_details ); ?>
													</div>
												<?php } ?>
											<?php } ?>
										</div>
										<?php if( isset( $setup_details[ 'skip-action' ] ) || isset( $setup_details[ 'submit-action' ] ) ) { ?>
											<div class="l_admin-button-well">
												<?php if( isset( $setup_details[ 'submit-action' ] ) ) { ?>
													<a class="button" href="" data-setup-step-key="<?php echo $setup_key; ?>" data-submit-action="<?php echo $setup_details[ 'submit-action' ]; ?>">
														<?php echo ( isset( $setup_details[ 'submit-text' ] ) ) ? $setup_details[ 'submit-text' ] : __( 'Save &amp; Proceed &rarr;' , 'layerswp' ); ?>
													</a>
												<?php } ?>
												<?php if( isset( $setup_details[ 'skip-action' ] ) ) { ?>
													<a class="button btn-link l_admin-dashboard-skip l_admin-pull-right" data-setup-step-key="<?php echo $setup_key; ?>" data-skip-action="<?php echo $setup_details[ 'skip-action' ]; ?>">
														<?php _e( 'Skip' , 'layerswp' ); ?>
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

						<div class="l_admin-panel l_admin-push-bottom">
							<div class="l_admin-panel-title">
								<h4 class="l_admin-heading"><?php _e( 'Layers Pages' , 'layerswp' ); ?></h4>
							</div>
							<ul class="l_admin-list l_admin-page-list l_admin-scroll">
								<?php foreach( layers_get_builder_pages() as $page ) { ?>
									<li>
										<a class="l_admin-page-list-title" href="<?php echo admin_url( 'post.php?post=' . $page->ID . '&action=edit' ); ?>"><?php echo $page->post_title; ?></a>
										<span class="l_admin-page-edit-links">
											<a href="<?php echo admin_url( 'customize.php?url=' . esc_url( get_permalink( $page->ID ) ) ); ?>"><?php _e( 'Edit Layout' , 'layerswp' ); ?></a> |
											<a href="<?php echo admin_url( 'post.php?post=' . $page->ID . '&action=edit' ); ?>"><?php _e( 'Edit' , 'layerswp' ); ?></a> |
											<a href="<?php echo get_permalink( $page->ID ); ?>"><?php _e( 'View' , 'layerswp' ); ?></a>
										</span>
									</li>
								<?php }?>
							</ul>
							<div class="l_admin-button-well">
								<a class="button" href="<?php echo admin_url( 'admin.php?page=layers-add-new-page' ); ?>">
									<?php _e( 'Add New Page' , 'layerswp' ); ?>
								</a>
							</div>
						</div>
					<?php } else { ?>
						<div class="l_admin-panel l_admin-content l_admin-push-bottom">
							<div class="l_admin-section-title l_admin-small">
								<h3 class="l_admin-heading"><?php _e( 'Start Using Layers' , 'layerswp' ); ?></h3>
								<p class="l_admin-excerpt">
									<?php _e( 'Follow the easy steps to creating amazing layouts quickly and easily. ' , 'layerswp' ); ?>
								</p>
							</div>
							<a href="<?php echo admin_url( 'admin.php?page=layers-get-started' ); ?>" class="button btn-large button-primary">
								<?php _e( 'Get Started &rarr;' , 'layerswp' ); ?>
							</a>
						</div>
					<?php }?>

				</div>

				<div class="l_admin-column l_admin-span-5">
					<?php if( !defined( 'LAYERS_DISABLE_MARKETPLACE' ) ){ ?>
						<div class="l_admin-panel l_admin-push-bottom">
							<div class="l_admin-section-title l_admin-content l_admin-tiny">
								<h3 class="l_admin-heading"><?php _e( 'Themes &amp; Extensions' , 'layerswp' ); ?></h3>
								<p class="l_admin-excerpt">
									<?php _e( 'Looking for a theme or plugin to achieve something unique with your website?
										Browse the Layers Add Ons and take your site to the next level.' , 'layerswp' ); ?>
								</p>
							</div>
							<div class="l_admin-button-well">
								<a href="<?php echo admin_url( 'admin.php?page=layers-marketplace' ); ?>" class="button button-primary">
									<?php _e( 'Themes &amp; Extensions' , 'layerswp' ); ?>
								</a>
							</div>
						</div>
					<?php } ?>
					<?php if( 0 < count( layers_get_plugins() ) ) { ?>
						<div class="l_admin-panel">
							<div class="l_admin-panel-title">
								<h4 class="l_admin-heading"><?php _e( 'Installed Extensions' , 'layerswp' ); ?></h4>
							</div>

							<ul class="l_admin-list l_admin-extensions">
								 <?php foreach( layers_get_plugins() as $extension_key => $extension_details ) { ?>
									<li>
										<h4 class="l_admin-heading">
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
				<div class="l_admin-column l_admin-span-4">

					<?php if( !defined( 'LAYERS_DISABLE_INTERCOM' ) ){ ?>
						<div class="l_admin-panel l_admin-push-bottom">
							<div class="l_admin-panel-title">
								<h4 class="l_admin-heading">
									<a href="http://docs.layerswp.com/">
										<?php _e( 'Layers Messenger' , 'layerswp' ); ?>
									</a>
								</h4>
							</div>
							<div class="l_admin-media l_admin-image-left l_admin-content l_admin-no-push-bottom">
								<div class="l_admin-media-image l_admin-small">
									<img src="<?php echo LAYERS_TEMPLATE_URI; ?>/core/assets/images/icon-layers-messenger.png" alt="<?php _e( 'Layers Messenger' , 'layerswp' ); ?>"/>
								</div>
								<div class="l_admin-media-body">
									<div class="l_admin-excerpt">
										<p>
											<?php _e( 'Enable the Layers Messenger to connect with the Layers team directly from inside your WordPress dashboard.' , 'layerswp' ); ?>
										</p>
										<div class="l_admin-checkbox-wrapper l_admin-form-item">
											<input id="layers-enable-intercom" name="layers_intercom" type="checkbox" <?php if( '1' == get_option( 'layers_enable_intercom' )  ){ echo 'checked="checked"'; }; ?> />
											<label for="layers-enable-intercom"><?php _e( 'Enable Layers Messenger', 'layerswp' ); ?></label>
										</div>
									</div>
								</div>
							</div>
							<div class="l_admin-button-well">
								<a class="button btn-link l_admin-pull-right" href="http://www.layerswp.com/privacy-policy/" target="_blank"><?php _e( 'Your data is safe with us', 'layerswp' ); ?></a>
								<a class="button" href="" data-setup-step-key="layers_enable_intercom" data-intercom-switch-action="layers_update_intercom">
									<?php _e( 'Save Setting' , 'layerswp' ); ?>
								</a>
							</div>
						</div>
					<?php } // If !disable intercom ?>

					<div class="l_admin-panel l_admin-push-bottom">
						<div class="l_admin-panel-title">
							<h4 class="l_admin-heading">
								<a href="http://docs.layerswp.com/">
									<?php _e( 'Quick Help' , 'layerswp' ); ?>
								</a>
							</h4>
						</div>
						<ul class="l_admin-list l_admin-extensions" data-layers-feed="docs" data-laters-feed-count="5">
							<li data-loading="1">
								<?php _e( "Loading feed..." , 'layerswp' ); ?>
							</li>
						</ul>
						<div class="l_admin-button-well">
							<a class="button" href="http://docs.layerswp.com/" target="_blank">
								<?php _e( 'Get more useful tips' , 'layerswp' ); ?>
							</a>
						</div>
					</div>

					<div class="l_admin-panel l_admin-push-bottom">
						<div class="l_admin-media l_admin-image-left l_admin-content">
							<div class="l_admin-media-image l_admin-small">
								<img src="<?php echo LAYERS_TEMPLATE_URI; ?>/core/assets/images/github-badge.png" alt="<?php _e( 'Github badge' , 'layerswp' ); ?>"/>
							</div>
							<div class="l_admin-media-body">
								<h3 class="l_admin-heading"><?php _e( 'Contribute to Layers' , 'layerswp' ); ?></h3>
								<p class="l_admin-excerpt">
									<?php _e( sprintf( 'Get involved with the community of this awesome project
									and contribute enhancements, features, and bug fixes to the core code of
									<a href="%s" target="_blank">Layers on GitHub</a>. Check out the Issues tab for ways to help!',
									'http://docs.layerswp.com/contributing-to-layers/' ) , 'layerswp' ); ?>
								</p>
							</div>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
</section>
<section class="l_admin-area-wrapper">
	<div class="l_admin-well-alt l_admin-content">

		<div class="l_admin-section-title l_admin-small">
			<h3 class="l_admin-heading"><?php _e( 'Layers News' , 'layerswp' ); ?></h3>
		</div>

		<div id="layers-dashboard-news-feed" class="l_admin-row" data-layers-feed="news" data-layers-feed-count="3">
			<div class="l_admin-column l_admin-span-3 l_admin-panel" data-loading="1">
				<div class="l_admin-content">
					<div class="l_admin-section-title l_admin-tiny">
						<h4 class="l_admin-heading"><?php _e( 'Loading Layers News' , 'layerswp' ); ?></h4>
					</div>
				</div>
			</div>
			<div class="l_admin-column l_admin-span-3">
				<div class="l_admin-panel l_admin-content clearfix">
					<div class="l_admin-section-title l_admin-tiny">
						<h3 class="l_admin-heading"><?php _e( 'Stay in the Loop' , 'layerswp' ); ?></h3>
						<p class="l_admin-excerpt">
							<?php _e( 'Sign up to our monthly newsletter to find out when we launch new features, products.' , 'layerswp' ); ?>
						</p>
					</div>
					<form id="layers-dashboard-newsletter" action="//oboxthemes.us10.list-manage.com/subscribe/post?u=5b9a020fcf797987098cc7bca&amp;id=069cfedbbc" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank"  validate>
						<div id="mc_embed_signup_scroll" class="l_admin-form-item l_admin-form-inline">
							<div class="mc-field-group">
								<label for="mce-EMAIL"><?php _e( 'Email Address' , 'layerswp' ); ?></label>
								<input type="email" value="" name="EMAIL" class="required email l_admin-form-inline input" id="mce-EMAIL">
								<button type="submit" name="subscribe" id="mc-embedded-subscribe" class="button button-primary"><?php _e( 'Subscribe' , 'layerswp' ); ?></button><input type="hidden" name="SIGNUP" id="SIGNUP" value="layerswp" />
							</div>
							<div id="mce-responses" class="clear">
								<div class="response" id="mce-error-response" style="display:none"></div>
								<div class="response" id="mce-success-response" style="display:none"></div>
							</div> <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							<div style="position: absolute; left: -5000px;"><input type="text" name="b_5b9a020fcf797987098cc7bca_069cfedbbc" tabindex="-1" value=""></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<?php $this->footer(); ?>