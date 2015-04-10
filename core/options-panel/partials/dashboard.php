<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Instantiate Inputs
$form_elements = new Layers_Form_Elements(); ?>

<?php // Get the API up and running for the extension listing
$api = new Layers_API(); ?>

<section id="layers-dashboard-page" class="layers-area-wrapper">

	<?php $this->header( __( 'Dashboard' , 'layerswp' ) ); ?>

	<div class="layers-row layers-well layers-content-large">
		<div class="layers-container-large">

			<div class="layers-row">

				<div class="layers-column layers-span-4">

					<div class="layers-panel layers-push-bottom">
						<div class="layers-panel-title">
							<h4 class="layers-heading"><?php _e( 'Layers Pages' , 'layerswp' ); ?></h4>
						</div>
						<ul class="layers-list layers-page-list">
							<?php if( count( layers_get_builder_pages() ) > 1 ) { ?>
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
							<?php } else { ?>
								<li><?php _e( 'You have not created any Layers Pages yet' , 'layerswp' ); ?></li>
							<?php }?>
						</ul>
						<div class="layers-button-well">
							<a class="layers-button" href="<?php echo admin_url( 'admin.php?page=layers-add-new-page' ); ?>">
								<?php _e( 'Add New Page' , 'layerswp' ); ?>
							</a>
						</div>
					</div>

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

				</div>

				<div class="layers-column layers-span-4">

					<?php /*
					* Check to see if we have dismissed or gone through any of the setup steps
					*/
					$dismissed_setup_steps = get_option( 'layers_dismissed_setup_steps' );
					foreach( array_keys( $this->site_setup_actions() ) as $key ) {
						if( !is_array( $dismissed_setup_steps ) || !in_array( $key, $dismissed_setup_steps ) ) {
							$setup_steps[] = $key;
						}
					} ?>

					<div class="layers-status-notice layers-site-setup-completion uptodate  layers-hide">
						<h5 class="layers-status-notice-heading">
							<i class="icon-tick"></i>
							<span><?php _e( 'Congrats your site is setup!' , 'layerswp' ); ?></span>
						</h5>
					</div>

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
													<?php _e( 'Dismiss' , 'layerswp' ); ?>
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
					<?php } ?>

					<div class="layers-panel layers-content layers-push-bottom">
						<div class="layers-section-title layers-tiny">
							<h3 class="layers-heading"><?php _e( 'Themes &amp; Extensions' , 'layerswp' ); ?></h3>
							<p class="layers-excerpt">
								<?php _e( '
									Looking for a theme or extension to achieve something unique with your website?
									Browse the massive Layers Marketplace on Envato and take your site to the next level.
								' , 'layerswp' ); ?>
							</p>
						</div>
						<a href="{themeforest.net/layers}" class="layers-button btn-primary">
							<?php _e( 'Browse &rarr;' , 'layerswp' ); ?>
						</a>
					</div>

					<div class="layers-panel">
						<div class="layers-panel-title">
							<h4 class="layers-heading"><?php _e( 'Extensions' , 'layerswp' ); ?></h4>
						</div>

						<ul class="layers-list layers-extensions">
							<?php foreach( $api->get_extension_list() as $extension_key => $extension_details ) { ?>
								<li>
									<h4 class="layers-heading">
										<?php echo $extension_details[ 'title' ]; ?>
									</h4>
									<?php if( isset( $extension_details[ 'description' ] ) ){ ?>
										<p>
											<?php echo $extension_details[ 'description' ]; ?>
										</p>
									<?php } ?>
									<?php if( isset( $extension_details[ 'available' ] ) && false == $extension_details[ 'available' ] ) { ?>
										<div class="layers-btn-group">
											<button class="layers-button btn-subtle" disabled="disabled"><?php _e( 'Coming soon' , 'layerswp' ); ?></button>
										</div>
									<?php } else { ?>
										<?php if( isset( $extension_details[ 'links' ] ) && ( isset( $extension_details[ 'links' ][ 'purchase' ] ) || isset( $extension_details[ 'links' ][ 'details' ] ) ) ){ ?>
											<div class="layers-btn-group">
												<div class="layers-btn-group">
													<?php if( NULL != $extension_details[ 'links' ][ 'purchase' ] ) { ?>
														<a class="layers-button" href="<?php echo $extension_details[ 'links' ][ 'purchase' ]; ?>" target="_blank">
															<?php _e( 'Purchase' , 'layerswp' ) ;?>
														</a>
													<?php } ?>
													<?php if( NULL != $extension_details[ 'links' ][ 'details' ] ) { ?>
														<a class="layers-button btn-link" href="<?php echo $extension_details[ 'links' ][ 'details' ]; ?>" target="_blank">
															<?php _e( 'More Details' , 'layerswp' ) ;?>
														</a>
													<?php } ?>
												</div>
											</div>
										<?php } ?>
									<?php } ?>
								</li>
							<?php } // foreach extensions ?>
						</ul>
					</div>
				</div>
				<div class="layers-column layers-span-4">

					<div class="layers-status-notice uptodate">
						<h5 class="layers-status-notice-heading">
							<i class="icon-tick"></i>
							<span><?php _e( 'Layers is up-to-date' , 'layerswp' ); ?></span>
						</h5>
					</div>
					<a class="layers-status-notice outdated" href="">
						<h5 class="layers-status-notice-heading">
							<i class="icon-cross"></i>
							<span><?php _e( 'Please update Layers' , 'layerswp' ); ?></span>
						</h5>
					</a>
					<div class="layers-status-notice uptodate">
						<h5 class="layers-status-notice-heading">
							<i class="icon-tick"></i>
							<span><?php _e( 'WordPress is up-to-date' , 'layerswp' ); ?></span>
						</h5>
					</div>
					<a class="layers-status-notice outdated" href="">
						<h5 class="layers-status-notice-heading">
							<i class="icon-cross"></i>
							<span><?php _e( 'Please update WordPress' , 'layerswp' ); ?></span>
						</h5>
					</a>

					<div class="layers-panel layers-push-bottom">
						<div class="layers-panel-title">
							<h4 class="layers-heading">
								<a href="http://docs.layerswp.com/">
									<?php _e( 'Quick Help' , 'layerswp' ); ?>
								</a>
							</h4>
						</div>
						<ul class="layers-list layers-extensions">
							<li>
								<a class="layers-page-list-title" target="_blank" href="http://docs.layerswp.com/setup-guide/#build-your-home-page">Build Your Home Page</a>
							</li>
							<li>
								<a class="layers-page-list-title" target="_blank" href="http://docs.layerswp.com/setup-guide/#site-settings">Site Settings</a>
							</li>
							<li>
								<a class="layers-page-list-title" target="_blank" href="http://docs.layerswp.com/setup-guide/#create-your-menus">Create Your Menus</a>
							</li>
							<li>
								<a class="layers-page-list-title" target="_blank" href="http://docs.layerswp.com/doc/how-to-speed-up-your-website/">How to Speed Up Your Website</a>
							</li>
						</ul>
						<div class="layers-button-well">
							<a class="layers-button" href="http://docs.layerswp.com/" target="_blank">
								<?php _e( 'Get more useful tips' , 'layerswp' ); ?>
							</a>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>

<section class="layers-area-wrapper">
	<div class="layers-row layers-well-alt layers-content-large">

		<div class="layers-section-title layers-small">
			<h3 class="layers-heading"><?php _e( 'Layers News' , 'layerswp' ); ?></h3>
		</div>

		<div class="layers-row">



			<div class="layers-column layers-span-3">
				<div class="layers-panel">
					<div class="layers-featured-image">
						<img src="http://blog.oboxthemes.com/wp-content/uploads/2015/03/march-update-1000x300.png" />
					</div>
					<div class="layers-section-title layers-tiny layers-no-push-bottom layers-content">
						<h4 class="layers-heading">Layers is now with packaged with 5 languages and much more to come</h4>
					</div>
					<div class="layers-copy">
						<p>
							With Layers being our first open-source product we are quickly learning how awesome
							it is to have people outside of Obox make contributions. With just over a month having
							passed since launch we’ve had an overwhelming amount of contributions to the core
							and for that we are incredibly grateful.
						</p>
					</div>
					<div class="layers-button-well">
						<a href="http://blog.oboxthemes.com/layers-is-now-with-packaged-with-5-languages-and-much-more-to-come/" class="layers-button">
							Continue Reading
						</a>
					</div>
				</div>
			</div>

			<div class="layers-column layers-span-3">
				<div class="layers-panel">
					<div class="layers-featured-image">
						<img src="http://blog.oboxthemes.com/wp-content/uploads/2015/03/adii-joins-obox-1000x527.jpg" />
					</div>
					<div class="layers-section-title layers-tiny layers-no-push-bottom layers-content">
						<h4 class="layers-heading">Adii, co-founder of WooThemes and WooCommerce, has joined Obox</h4>
					</div>
					<div class="layers-copy">
						<p>
							This post has been 6 years in the making. I’ll start at the beginning with a brief history of how Marc, David and Adii came to be part of the same company.
						</p>
					</div>
					<div class="layers-button-well">
						<a href="http://blog.oboxthemes.com/adii-co-founder-of-woothemes-and-woocommerce-has-joined-obox/" class="layers-button">
							Continue Reading
						</a>
					</div>
				</div>
			</div>

			<div class="layers-column layers-span-3">
				<div class="layers-panel">
					<div class="layers-featured-image">
						<img src="http://blog.oboxthemes.com/wp-content/uploads/2015/03/calyx-joins-obox-2x-1000x520.jpg" />
					</div>
					<div class="layers-section-title layers-tiny layers-no-push-bottom layers-content">
						<h4 class="layers-heading">Obox acquires Calyx</h4>
					</div>
					<div class="layers-copy">
						<p>
							Last year in September Marc and I took part in the WordCamp do_action charity day in Cape Town with our primary task being to judge the event and help the various charities involved with their websites.
						</p>
					</div>
					<div class="layers-button-well">
						<a href="http://blog.oboxthemes.com/calyx-joins-obox/" class="layers-button">
							Continue Reading
						</a>
					</div>
				</div>
			</div>

			<div class="layers-column layers-span-3">
				<div class="layers-panel">
					<div class="layers-featured-image">
						<img src="http://blog.oboxthemes.com/wp-content/uploads/2015/02/layers-by-obox-1000x520.jpg" />
					</div>
					<div class="layers-section-title layers-tiny layers-no-push-bottom layers-content">
						<h4 class="layers-heading">From today, the way you build WordPress sites will change. Say hello to Layers</h4>
					</div>
					<div class="layers-copy">
						<p>
							We’re extremely excited to introduce Layers to the world, marking the realisation of 9 months of work by Obox. Layers is a revolutionary site builder that allows you to create beautiful websites easily. The best part? It’s free, forever. If you’re the jump-straight-in type, you can download or try it right now for free.   Why?
						</p>
					</div>
					<div class="layers-button-well">
						<a href="http://blog.oboxthemes.com/calyx-joins-obox/" class="layers-button">
							Continue Reading
						</a>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>
<?php $this->footer(); ?>
