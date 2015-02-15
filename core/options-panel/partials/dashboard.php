<?php // Fetch current user information
$user = wp_get_current_user(); ?>
<?php // Get the API up and running for the extension listing
$api = new Layers_API(); ?>

<section class="layers-area-wrapper">

	<?php $this->header( __( 'Dashboard', LAYERS_THEME_SLUG ) ); ?>

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
									<span class="layers-pull-right layers-hide">
										<a href="<?php echo admin_url( 'customize.php?url=' . esc_url( get_the_permalink() ) . '&layers-builder=1' ); ?>"><?php _e( 'Edit Layout' , LAYERS_THEME_SLUG ); ?></a> |
										<a href="<?php echo admin_url( 'post.php?post=' . $page->ID . '&action=edit' ); ?>"><?php _e( 'Edit' , LAYERS_THEME_SLUG ); ?></a> |
										<a href="<?php echo get_the_permalink( $page->ID ); ?>"><?php _e( 'View' , LAYERS_THEME_SLUG ); ?></a>
									</span>
								</li>
							<?php }?>
						</ul>
						<div class="layers-button-well">
							<a href="<?php echo admin_url( 'admin.php?page=layers-add-new-page' ); ?>" class="layers-button btn-primary">
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
								<?php foreach( $api->get_extension_list() as $extension_key => $extension_details ) { ?>
									<li>
										<h3 class="layers-heading">
											<?php echo $extension_details[ 'title' ]; ?>
										</h3>
										<?php if( isset( $extension_details[ 'description' ] ) ){ ?>
											<p>
												<?php echo $extension_details[ 'description' ]; ?>
											</p>
										<?php } ?>
										<?php if( isset( $extension_details[ 'available' ] ) && false == $extension_details[ 'available' ] ) { ?>
											<div class="layers-btn-group">
												<p><?php _e( 'Coming soon' , LAYERS_THEME_SLUG ); ?></p>
											</div>
										<?php } else { ?>
											<?php if( isset( $extension_details[ 'links' ] ) && ( isset( $extension_details[ 'links' ][ 'purchase' ] ) || isset( $extension_details[ 'links' ][ 'details' ] ) ) ){ ?>
												<div class="layers-btn-group">
													<div class="layers-btn-group">
														<?php if( NULL != $extension_details[ 'links' ][ 'purchase' ] ) { ?>
															<a class="layers-button" href="<?php echo $extension_details[ 'links' ][ 'purchase' ]; ?>" target="_blank">
																<?php _e( 'Purchase' , LAYERS_THEME_SLUG ) ;?>
															</a>
														<?php } ?>
														<?php if( NULL != $extension_details[ 'links' ][ 'details' ] ) { ?>
															<a class="layers-button btn-link" href="<?php echo $extension_details[ 'links' ][ 'details' ]; ?>" target="_blank">
																<?php _e( 'More Details' , LAYERS_THEME_SLUG ) ;?>
															</a>
														<?php } ?>
													</div>
												</div>
											<?php } ?>
										<?php } ?>
									</li>
								<?php } // foreach extensions ?>
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
							<?php layers_show_html5_video( 'http://cdn.oboxsites.com/layers/videos/adding-a-widget.mp4', 490 ); ?>
		                </div>
					</div>
				</div>

			</div>

		</div>
	</div>
</section>
<?php $this->footer(); ?>