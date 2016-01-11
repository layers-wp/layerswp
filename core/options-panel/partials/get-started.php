<?php
// Fetch current user information
$user = wp_get_current_user();

// Instantiate Inputs
$form_elements = new Layers_Form_Elements();

// Instantiate the widget migrator
$layers_migrator = new Layers_Widget_Migrator();


function render_onboarding_warnings() {
	global $wp_version;
	
	$required_wp_version        = '4.5';
	$required_layers_foldername = 'layerswp-bong';
	
	$theme = wp_get_theme();
	$current_folder_name = $theme->template;
	
	if (
			version_compare( $wp_version, $required_wp_version, '<' ) ||
			'' !== $required_layers_foldername
		) {
		
		echo '<li class="pro-tip">';
		echo '<strong>' . __( 'Notice(s):', 'layerswp' ) . '</strong>';
		
		// Check WP version.
		if ( version_compare( $wp_version, $required_wp_version, '<' ) ) {
			?>
			<div class="onboarding-notice-item">
				<i class="fa fa-exclamation-triangle"></i> 
				<?php echo sprintf( __( "Layers works best with WordPress <code>version %s</code>. Your's is <code>version %s</code>. Please think about doing an <a href='%s'>update</a> soon.", 'layerswp' ), $required_wp_version, $wp_version, network_admin_url( 'update-core.php' ) ); ?>
			</div>
			<?php
		}
		
		// Check Layers folder version.
		if ( $current_folder_name !== $required_layers_foldername ) {
			?>
			<div class="onboarding-notice-item">
				<i class="fa fa-exclamation-triangle"></i> 
				<?php echo sprintf( __( 'Your Layers theme folder needs to be named <code>/%s</code> - yours is named <code>/%s</code>. Please rename it.', 'layerswp' ), $required_layers_foldername, $current_folder_name ); ?>
			</div>
			<?php
		}
		
		echo '</li>';
	}
}
?>
<section class="layers-area-wrapper">

	<div class="layers-onboard-wrapper">

		<div class="layers-onboard-controllers">
			<div class="onboard-nav-dots layers-pull-left" id="layers-onboard-anchors"></div>
			<a class="layers-button btn-link layers-pull-right" href="" id="layers-onboard-skip"><?php _e( 'Skip' , 'layerswp' ); ?></a>
		</div>

		<div class="layers-onboard-slider">
		
			<!-- Give your site a Name -->
			<div class="layers-onboard-slide layers-animate layers-onboard-slide-current">
				<div class="layers-column layers-span-8 postbox">
					
					<div class="layers-content-large ">
						
						<!-- Heading -->
						<div class="layers-section-title">
							<h3 class="layers-heading">
								<?php _e( 'What is the name of your website?' , 'layerswp' ); ?>
							</h3>
							<p class="layers-excerpt">
								<?php _e( 'Enter your website name below. We&apos;ll use this in your site title and in search results.' , 'layerswp' ); ?>
							</p>
						</div>
						
						<!-- Sentence -->
						<span class="onboarding-form-sentence">
							<?php _e( 'What is the name of your website?' , 'layerswp' ); ?>
							<i class="fa fa-question-circle" data-tip="<?php echo esc_attr( __( 'Enter your website name below. We&apos;ll use this in your site title and in search results.' , 'layerswp' ) ); ?>"></i>
						</span>
						<span class="onboarding-form-item">
							<?php
							echo $form_elements->input( array(
								'type' => 'text',
								'name' => 'blogname',
								'id' => 'blogname',
								'placeholder' => get_bloginfo( 'name' ),
								'value' => get_bloginfo( 'name' ),
								'class' => 'layers-text layers-large',
							) );
							?>
						</span>
						
						<br>
						
						<!-- Sentence -->
						<span class="onboarding-form-sentence">
							<?php _e( 'What will your site be used for?' , 'layerswp' ); ?>
							<i class="fa fa-question-circle" data-tip="<?php _e( 'This will help us better tailor your experience.' , 'layerswp' ); ?>"></i>
						</span>
						<span class="onboarding-form-item">
							<?php
							echo $form_elements->input( array(
								'type' => 'select',
								'name' => 'info_site_usage',
								'id' => 'info_site_usage',
								'value' => '#009eec',
								'options' => array(
									'' => '',
									'business' => 'Business',
									'art' => 'Art',
									'education' => 'Education',
									'general' => 'General',
								),
							) );
							?>
						</span>
						
						<!-- Sentence -->
						<span class="onboarding-form-sentence">
							<?php _e( 'How would you describe your site?' , 'layerswp' ); ?>
							<i class="fa fa-question-circle" data-tip="<?php _e( 'A tagline describes who and what you are in just a few simple words. For example Layers is a &ldquo;WordPress Site Builder&rdquo; - simple, easy, quick to read. Now you try:' , 'layerswp' ); ?>"></i>
						</span>
						<span class="onboarding-form-item onboarding-form-item-no-border">
							<?php
							echo $form_elements->input( array(
								'type' => 'text',
								'name' => 'blogdescription',
								'id' => 'blogdescription',
								'placeholder' => get_bloginfo( 'description' ),
								'value' => get_bloginfo( 'description' ),
								'class' => 'layers-text layers-large'
							) );
							?>
						</span>
						
						<br>
						
						<!-- Sentence -->
						<span class="onboarding-form-sentence">
							<?php _e( 'Choose a primary color?' , 'layerswp' ); ?>
							<i class="fa fa-question-circle" data-tip="<?php _e( 'We\'ll use this color in select places around your website.' , 'layerswp' ); ?>"></i>
						</span>
						<span class="onboarding-form-item onboarding-form-item-no-border">
							<?php
							echo $form_elements->input( array(
								'type' => 'color',
								'name' => 'site_color',
								'id' => 'site_color',
								'value' => ( get_theme_mod( 'layers-header-background-color' ) ) ? get_theme_mod( 'layers-header-background-color' ) : '#009eec',
							) );
							?>
						</span>
						
						<br>
						
						<?php echo $form_elements->input( array(
							'type' => 'hidden',
							'name' => 'action',
							'id' => 'action',
							'value' => 'layers_onboarding_update_options'
						) ); ?>
						
					</div>
					
					<div class="layers-button-well">
						<span class="layers-save-progress layers-hide layers-button btn-link" data-busy-message="<?php _e( 'Saving your Site Name' , 'layerswp' ); ?>"></span>
						<a class="layers-button btn-primary layers-pull-right onbard-next-step" href="">
							<?php _e( 'Next Step &rarr;' , 'layerswp' ); ?>
						</a>
					</div>
				</div>
				<div class="layers-column layers-span-4 no-gutter">
					<div class="layers-content">
						<!-- Your helpful tips go here -->
						<ul class="layers-help-list">
							<li>
								<?php _e( sprintf( 'For tips on how best to name your website, we suggest reading <a href="%s" rel="nofollow">this post</a>', '//docs.layerswp.com' ) , 'layerswp' ); ?>
							</li>
							<li class="pro-tip">
								<?php _e( 'For the Pros: Layers will automatically assign this site name to Settings &rarr; General' , 'layerswp' ); ?>
							</li>
							<?php render_onboarding_warnings(); ?>
						</ul>
					</div>
				</div>
			</div>

			<!-- Welcome -->
			<div class="layers-onboard-slide layers-animate">
				<div class="layers-column layers-span-8 postbox">
					<div class="layers-content-large">
						<!-- Your content goes here -->
						<div class="layers-section-title layers-no-push-bottom">
							<h3 class="layers-heading">
								<?php _e( 'Welcome to Layers!' , 'layerswp' ); ?>
							</h3>
							<div class="layers-excerpt">
								<p>
									<?php _e( 'Layers is a revolutionary WordPress Site Builder that makes website building a dream come true!' , 'layerswp' ); ?>
								</p>
								<p>
									<?php _e( 'The following short steps are designed to show you how Layers works and get you to creating amazing layouts quickly!' , 'layerswp' ); ?>
								</p>
								<p>
									<?php _e( 'Enjoy the ride!' , 'layerswp' ); ?>
								</p>

							</div>
						</div>
					</div>
					<div class="layers-button-well">
						<a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Let\'s get started &rarr;' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="layers-column layers-span-4 no-gutter">
					<div class="layers-content">
						<!-- Your helpful tips go here -->
						<ul class="layers-help-list">
							<li>
								<?php _e( sprintf( 'If you\'re ever stuck or need help with your Layers site please visit our <a href="%s" rel="nofollow">helpful documentation.</a>', '//docs.layerswp.com' ) , 'layerswp' ); ?>
							</li>
							<li class="pro-tip"><?php _e( 'For the Pros: Layers will automatically assign the tagline to Settings &rarr; General.' , 'layerswp' ); ?></li>
							<?php render_onboarding_warnings(); ?>
						</ul>
					</div>
				</div>
			</div>
			
			<?php if( !defined( 'LAYERS_DISABLE_INTERCOM' ) ){ ?>
				<!-- Enable / Disable Intercom -->
				<div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
					<div class="layers-column layers-span-8 postbox">
						<div class="layers-content-large">
							<!-- Your content goes here -->
							<div class="layers-section-title">
								<h3 class="layers-heading">
									<?php _e( 'Layers Messenger' , 'layerswp' ); ?>
								</h3>
								<p class="layers-excerpt">
									<?php _e( 'Enable the Layers Messenger to connect with the Layers team directly from inside Layers. We can help you make informed decisions about themes and extensions and point you in the right direction when you need support with your site and Layers.' , 'layerswp' ); ?>
								</p>
							</div>
							<?php echo $form_elements->input( array(
								'type' => 'hidden',
								'name' => 'action',
								'id' => 'action',
								'value' => 'layers_update_intercom'
							) ); ?>
							<div class="layers-checkbox-wrapper layers-form-item layers-push-bottom-medium">
								<input id="layers-enable-intercom" name="layers_intercom" type="checkbox" <?php if( '0' !== get_option( 'layers_enable_intercom' ) ){ echo 'checked="checked"'; }; ?> />
								<label for="layers-enable-intercom"><?php _e( 'Enable Layers Messenger', 'layerswp' ); ?></label>
							</div>
							<p data-show-if-selector="#layers-enable-intercom" data-show-if-value="true" class="layers-form-item">
								<label><?php _e( 'Your Name' , 'layerswp' ); ?></label>
								<?php
									global $current_user;
									echo $form_elements->input( array(
										'type' => 'text',
										'name' => 'username',
										'id' => 'username',
										'placeholder' => $current_user->display_name,
										'value' =>  $current_user->display_name,
										'class' => 'layers-text layers-large'
								   ) );
								?>
							</p>
							<p><a href="//www.layerswp.com/privacy-policy/" target="_blank"><?php _e( 'Your data is safe with us. View our Privacy Policy', 'layerswp' ); ?></a></p>
						</div>
						<div class="layers-button-well">
							<span class="layers-save-progress layers-hide layers-button btn-link" data-busy-message="<?php _e( 'Saving Your Preference' , 'layerswp' ); ?>"></span>
							<a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Next Step &rarr;' , 'layerswp' ); ?></a>
						</div>
					</div>
					<div class="layers-column layers-span-4 no-gutter">
						<div class="layers-content">

							<!-- Your helpful tips go here -->
							<ul class="layers-help-list">
								<li><?php _e( 'Get advice on the right theme for your site.' , 'layerswp' ); ?></li>
								<li><?php _e( 'Help choosing extensions.' , 'layerswp' ); ?></li>
								<li><?php _e( 'Feedback? Let us know as soon as it comes to mind.' , 'layerswp' ); ?></li>
								<li><?php _e( 'Have a problem? We\'ll send you the best link to solve your issues.' , 'layerswp' ); ?></li>
								<li><?php _e( 'Allow Layers to collect non-sensitive diagnostic data and usage information to help us improve our theme and best assist you.' , 'layerswp' ); ?></li>
								<?php render_onboarding_warnings(); ?>
							</ul>
						</div>
					</div>
				</div>
			<?php } // If !disable intercom ?>

			<!-- Learn the Ropes: Widgets -->
			<div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
				<div class="layers-column layers-span-6 postbox">
					<div class="layers-content-large">
						<!-- Your content goes here -->
						<div class="layers-section-title layers-small layers-no-push-bottom">
							<div class="layers-push-bottom-small">
								<small class="layers-label label-secondary">
									<?php _e( 'Getting Started' , 'layerswp' ); ?>
								</small>
							</div>
							<h3 class="layers-heading">
								<?php _e( 'Building pages' , 'layerswp' ); ?>
							</h3>
							<div class="layers-excerpt">
								<p>
									<?php _e( 'Layers splits your page into horizontal rows, and you build up your pages with blocks of content called &lsquo;Widgets&rsquo;, one per row.' , 'layerswp' ); ?>
								</p>
								<p>
									<?php _e( 'Each time you want to add a new content block, simply click &lsquo;Add Widget&rsquo; and select one from the list which has the blue Layers icon.' , 'layerswp' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="layers-button-well">
						<a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Got it, Next Step &rarr;' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="layers-column layers-span-6 no-gutter layers-demo-video">
					<?php layers_show_html5_video( '//cdn.oboxsites.com/layers/videos/adding-a-widget.mp4', 490 ); ?>
				</div>
			</div>

			<!-- Learn the Ropes: Design Bar -->
			<div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
				<div class="layers-column layers-span-4 postbox">
					<div class="layers-content-large">
						<!-- Your content goes here -->
						<div class="layers-section-title layers-small layers-no-push-bottom">
							<div class="layers-push-bottom-small">
								<small class="layers-label label-secondary">
									<?php _e( 'Getting Started' , 'layerswp' ); ?>
								</small>
							</div>
							<h3 class="layers-heading">
								<?php _e( 'Editing widget content' , 'layerswp' ); ?>
							</h3>
							<div class="layers-excerpt">
								<p><?php _e( "To edit a widget's content, just click on it in the widget area on the left hand side. The widget panel will slide out allowing you to edit its content and customize its settings. You can also shift-click on the widget itself in the preview area." , 'layerswp' ); ?></p>
							</div>
						</div>
					</div>
					<div class="layers-button-well">
						<a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Next Step &rarr;' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="layers-column layers-span-8 no-gutter layers-demo-video">
					<?php layers_show_html5_video( '//cdn.oboxsites.com/layers/videos/widget-slider.mp4', 660 ); ?>
				</div>
			</div>

			<!-- Learn the Ropes: Editing Widgets -->
			<div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
				<div class="layers-column layers-span-6 postbox">
					<div class="layers-content-large">
						<!-- Your content goes here -->
						<div class="layers-section-title layers-small layers-no-push-bottom">
							<div class="layers-push-bottom-small">
								<small class="layers-label label-secondary">
									<?php _e( 'Getting Started' , 'layerswp' ); ?>
								</small>
							</div>
							<h3 class="layers-heading">
								<?php _e( 'Customizing widgets' , 'layerswp' ); ?>
							</h3>
							<div class="layers-excerpt">
								<p>
									<?php _e( 'Unique to each Layers widget is the revolutionary &ldquo;Design Bar&rdquo; which allows you to set its design parameters without touching a line of code.' , 'layerswp' ); ?>
								</p>
								<p>
									<?php _e( 'Depending on the widget you\'ve added, you can change things like background images, font sizes, list styles and more.' , 'layerswp' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="layers-button-well">
						<a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Next Step &rarr;' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="layers-column layers-span-6 no-gutter layers-demo-video">
					<?php layers_show_html5_video( '//cdn.oboxsites.com/layers/videos/design-bar.mp4', 490 ); ?>
				</div>
			</div>

			<!-- Upload a Logo -->
			<div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
				<div class="layers-column layers-span-8 postbox">
					<div class="layers-content-large">
						<!-- Your content goes here -->
						<div class="layers-section-title">
							<h3 class="layers-heading">
								<?php _e( 'Would you like to add your logo?' , 'layerswp' ); ?>
							</h3>
							<p class="layers-excerpt">
								 <?php _e( 'Layers will add your logo and position it properly. If you don&apos;t have one yet, no problem, you can add it later, or skip this step if you&apos;d just prefer to use text.' , 'layerswp' ); ?>
							</p>
						</div>
						<?php $site_logo = get_option( 'site_logo' ); ?>
						<div class="layers-logo-wrapper">
							<div class="layers-logo-upload-controller">
								<?php
								   echo $form_elements->input( array(
										'label' => __( 'Choose Logo' , 'layerswp' ),
										'type' => 'image',
										'name' => 'site_logo',
										'id' => 'site_logo',
										'value' => ( '' != $site_logo ? $site_logo[ 'id' ] : 0 )
								   ) );
								?>
							</div>
						</div>
						<?php echo $form_elements->input( array(
							'type' => 'hidden',
							'name' => 'action',
							'id' => 'action',
							'value' => 'layers_onboarding_update_options'
						) ); ?>
					</div>
					<div class="layers-button-well">
						<span class="layers-save-progress layers-hide layers-button btn-link" data-busy-message="<?php _e( 'Updating your Logo' , 'layerswp' ); ?>"></span>
						<a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Next Step &rarr;' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="layers-column layers-span-4 no-gutter">
					<div class="layers-content">
						<!-- Your helpful tips go here -->
						<ul class="layers-help-list">
							<li><?php _e( 'For best results, use an image between 40px and 200px tall and not more than 1000px wide' , 'layerswp' ); ?></li>
							<li><?php _e( 'PNGs with a transparent background work best but GIFs or JPGs are fine too' , 'layerswp' ); ?></li>
							<li><?php _e( 'Try keep your logo file size below 500kb' , 'layerswp' ); ?></li>
							<?php render_onboarding_warnings(); ?>
						</ul>
					</div>
				</div>
			</div>

			<!-- Select a Layout -->
			<div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
				<div class="layers-column layers-span-8 layers-template-selector postbox">
					<div class="layers-content">
						 <?php if( layers_get_builder_pages() ) { ?>
							 <p class="layers-form-item">
								<label><?php _e( 'Page Title' , 'layerswp' ); ?></label>
								<?php
								   echo $form_elements->input( array(
										'type' => 'text',
										'name' => 'preset_page_title',
										'id' => 'preset_page_title',
										'placeholder' => __( 'Home Page' , 'layerswp' ),
										'value' => __( 'Home Page' , 'layerswp' ),
										'class' => 'layers-text layers-large layers-push-bottom-medium'
								   ) );
								?>
							</p>
						<?php } // if layers_get_builder_pages(); ?>

						<?php $this->load_partial( 'preset-layouts' ); ?>

						<?php echo $form_elements->input( array(
							'type' => 'hidden',
							'name' => 'action',
							'id' => 'action',
							'value' => 'layers_select_preset'
						) ); ?>
					</div>
				</div>
				<div class="layers-column layers-span-4 no-gutter postbox">
					<div class="layers-content-large">
						<!-- Your content goes here -->
						<div class="layers-section-title layers-small">
							<h3 class="layers-heading">
								<?php _e( 'Now let&apos;s create your first Layers page!' , 'layerswp' ); ?>
							</h3>
							<div class="layers-excerpt">
								<p>
									<?php _e( 'You will be able to edit your layout on the next page. Here we go! ' , 'layerswp' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="layers-button-well">
						<span class="layers-save-progress layers-hide layers-button btn-link" data-busy-message="<?php _e( 'Creating your Page' , 'layerswp' ); ?>"></span>
						<a class="layers-button btn-primary layers-pull-right onbard-next-step layers-proceed-to-customizer disable layers-tooltip" tooltip="<?php _e( 'First choose a layout' , 'layerswp' ); ?>" href=""><?php _e( 'Start Building' , 'layerswp' ); ?></a>
					</div>
				</div>
			</div>
		</div>

	</div>

</section>
