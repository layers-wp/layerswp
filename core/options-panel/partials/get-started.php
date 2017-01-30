<?php
// Fetch current user information
$user = wp_get_current_user();

// Instantiate Inputs
$form_elements = new Layers_Form_Elements();

// Instantiate the widget migrator
$layers_migrator = new Layers_Widget_Migrator(); ?>
<section class="l_admin-area-wrapper">

	<div class="l_admin-onboard-wrapper">

		<div class="l_admin-onboard-controllers">
			<div class="onboard-nav-dots l_admin-pull-left" id="layers-onboard-anchors"></div>
			<a class="button btn-link l_admin-pull-right" href="" id="layers-onboard-skip"><?php _e( 'Skip' , 'layerswp' ); ?></a>
		</div>

		<div class="l_admin-onboard-slider l_admin-row">

			<!-- Welcome -->
			<div class="l_admin-onboard-slide l_admin-animate l_admin-onboard-slide-current">
				<div class="l_admin-column l_admin-span-8 postbox">
					<div class="l_admin-content-large">
						<!-- Your content goes here -->
						<div class="l_admin-section-title l_admin-no-push-bottom">
							<h3 class="l_admin-heading">
								<?php _e( 'Welcome to Layers!' , 'layerswp' ); ?>
							</h3>
							<div class="l_admin-excerpt">
								<p>
									<?php _e( 'Layers is a revolutionary WordPress Site Builder that makes website building a dream come true.' , 'layerswp' ); ?>
								</p>
								<p>
									<?php _e( 'The following short steps are designed to show you how Layers works so that you can start creating amazing layouts.' , 'layerswp' ); ?>
								</p>
								<p>
									<?php _e( 'Enjoy the ride!' , 'layerswp' ); ?>
								</p>

							</div>
						</div>
					</div>
					<div class="l_admin-button-well">
						<a class="l_admin-button btn-primary l_admin-pull-right onboard-next-step" href=""><?php _e( 'Let\'s get started &rarr;' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="l_admin-column l_admin-span-4 no-gutter">
					<div class="l_admin-content">
						<!-- Your helpful tips go here -->
						<ul class="l_admin-help-list">
							<li>
								<?php _e( sprintf( 'If you\'re ever stuck or need help with your Layers site please visit our <a href="%s" target="_blank" rel="nofollow">helpful documentation.</a>', '//docs.layerswp.com' ) , 'layerswp' ); ?>
							</li>
							<li class="pro-tip"><?php _e( 'For the Pros: Layers will automatically assign the tagline to Settings &rarr; General.' , 'layerswp' ); ?></li>
						</ul>
					</div>
				</div>
			</div>

			<!-- Capture site details (previously 'Give your site a Name') -->
			<div class="l_admin-onboard-slide l_admin-animate l_admin-onboard-slide-inactive">
				<div class="l_admin-column l_admin-span-8 postbox">

					<div class="l_admin-content-large ">

						<!-- Heading -->
						<div class="l_admin-section-title">
							<h3 class="l_admin-heading">
								<?php _e( 'Let&rsquo;s do some quick setup' , 'layerswp' ); ?>
							</h3>
							<p class="l_admin-excerpt">
								<?php _e( 'Tell us a bit about your site so that we can give you the best website building experience possible.' , 'layerswp' ); ?>
							</p>
						</div>

						<div class="l_admin-form-item">
							<label>
								<?php _e( 'What is the name of your website?' , 'layerswp' ); ?>
								<i class="fa fa-question-circle" data-tip="<?php echo esc_attr( __( 'Enter your website name below. We&apos;ll use this in your site title and in search results.' , 'layerswp' ) ); ?>"></i>
							</label>
							<?php
							echo $form_elements->input( array(
								'type' => 'text',
								'name' => 'blogname',
								'id' => 'blogname',
								'placeholder' => get_bloginfo( 'name' ),
								'value' => get_bloginfo( 'name' ),
								'class' => 'layers-text l_admin-large',
							) );
							?>
						</div>

						<div class="l_admin-form-item">
							<label>
								<?php _e( 'How would you describe your site?' , 'layerswp' ); ?>
								<i class="fa fa-question-circle" data-tip="<?php _e( 'A tagline describes who and what you are in just a few simple words. For example Layers is a &ldquo;WordPress Site Builder&rdquo; - simple, easy, quick to read. Now you try:' , 'layerswp' ); ?>"></i>
							</label>
							<?php
							echo $form_elements->input( array(
								'type' => 'text',
								'name' => 'blogdescription',
								'id' => 'blogdescription',
								'placeholder' => get_bloginfo( 'description' ),
								'value' => get_bloginfo( 'description' ),
								'class' => 'layers-text l_admin-large'
							) );
							?>
						</div>

						<div class="l_admin-form-item">
							<label>
								<?php _e( 'What will your site be used for?' , 'layerswp' ); ?>
								<i class="fa fa-question-circle" data-tip="<?php _e( 'This will help us better tailor your experience.' , 'layerswp' ); ?>"></i>
							</label>
							<?php
							echo $form_elements->input( array(
								'type' => 'select',
								'name' => 'info_site_usage',
								'id' => 'info_site_usage',
								'value' => get_option( 'info_site_usage' ),
								'options' => array(
									'' => __( '-- Pick a Category --', 'layerswp' ),
									'activism' => __( 'Activism', 'layerswp' ),
									'art' => __( 'Art', 'layerswp' ),
									'blog-magazine' => __( 'Blog / Magazine', 'layerswp' ),
									'buddypress' => __( 'BuddyPress', 'layerswp' ),
									'business' => __( 'Business', 'layerswp' ),
									'charity' => __( 'Charity', 'layerswp' ),
									'children' => __( 'Children', 'layerswp' ),
									'churches' => __( 'Churches', 'layerswp' ),
									'corporate' => __( 'Corporate', 'layerswp' ),'personal' => __( 'Personal', 'layerswp' ),
									'creative' => __( 'Creative', 'layerswp' ),
									'directory-listings' => __( 'Directory &amp; Listings', 'layerswp' ),
									'education' => __( 'Education', 'layerswp' ),
									'entertainment' => __( 'Entertainment', 'layerswp' ),
									'environmental' => __( 'Environmental', 'layerswp' ),
									'events' => __( 'Events', 'layerswp' ),
									'experimental' => __( 'Experimental', 'layerswp' ),
									'fashion' => __( 'Fashion', 'layerswp' ),
									'film-tv' => __( 'Film &amp; TV', 'layerswp' ),
									'food' => __( 'Food', 'layerswp' ),
									'health-beauty' => __( 'Health &amp; Beauty', 'layerswp' ),
									'hosting' => __( 'Hosting', 'layerswp' ),
									'just-testing' => __( 'Just Testing', 'layerswp' ),
									'news-editorial' => __( 'News / Editorial', 'layerswp' ),
									'nightlife' => __( 'Nightlife', 'layerswp' ),
									'nonprofit' => __( 'Nonprofit', 'layerswp' ),
									'marketing' => __( 'Marketing', 'layerswp' ),
									'miscellaneous' => __( 'Miscellaneous', 'layerswp' ),
									'mobile' => __( 'Mobile', 'layerswp' ),
									'music-and-bands' => __( 'Music and Bands', 'layerswp' ),
									'photography' => __( 'Photography', 'layerswp' ),
									'political' => __( 'Political', 'layerswp' ),
									'portfolio' => __( 'Portfolio', 'layerswp' ),
									'retail' => __( 'Retail', 'layerswp' ),
									'shopping' => __( 'Shopping', 'layerswp' ),
									'software' => __( 'Software', 'layerswp' ),
									'sport' => __( 'Sport', 'layerswp' ),
									'travel' => __( 'Travel', 'layerswp' ),
									'technology' => __( 'Technology', 'layerswp' ),
									'restaurants-cafes' => __( 'Restaurants &amp; Cafes', 'layerswp' ),
									'real-estate' => __( 'Real Estate', 'layerswp' ),
									'wedding' => __( 'Wedding', 'layerswp' ),
								),
								'class' => 'l_admin-large',
							) );
							?>


						</div>

						<div class="l_admin-form-item">
							<label for="layers-info-developer">
								<?php _e( 'What is your skill level?', 'layerswp' ); ?>
							</label>
							<?php
							echo $form_elements->input( array(
								'type' => 'select',
								'name' => 'layers_info_developer',
								'id' => 'layers_info_developer',
								'value' => get_option( 'layers_info_developer' ),
								'options' => array(
									'beginner' => __( 'I\'m not a designer / developer. I just need a website for myself.', 'layerswp' ),
									'learning' => __( 'I am learning to become a designer / developer.', 'layerswp' ),
									'wordpress_developer' => __( 'I am a theme / plugin developer.', 'layerswp' ),
									'freelance' => __( 'I am a freelance designer / developer.', 'layerswp' ),
									'agency' => __( 'I am  a designer / developer at an agency or organization.', 'layerswp' ),
								),
								'class' => 'l_admin-large',
							) );
								?>
						</div>

						<div class="l_admin-form-item">
							<label>
								<?php _e( 'Choose a primary color?' , 'layerswp' ); ?>
								<i class="fa fa-question-circle" data-tip="<?php _e( 'We\'ll use this color in select places around your website.' , 'layerswp' ); ?>"></i>
							</label>
							<?php
							echo $form_elements->input( array(
								'type' => 'color',
								'name' => 'site_color',
								'id' => 'site_color',
								'value' => ( layers_get_theme_mod( 'header-background-color' ) ) ? layers_get_theme_mod( 'header-background-color' ) : '#009eec',
							) );
							?>
						</div>


						<?php echo $form_elements->input( array(
							'type' => 'hidden',
							'name' => 'action',
							'id' => 'action',
							'value' => 'layers_onboarding_update_options'
						) ); ?>

					</div>

					<div class="l_admin-button-well">
						<span class="l_admin-save-progress l_admin-hide l_admin-button btn-link" data-busy-message="<?php _e( 'Saving your Site Name' , 'layerswp' ); ?>"></span>
						<a class="l_admin-button btn-primary l_admin-pull-right onboard-next-step" href="">
							<?php _e( 'Next Step &rarr;' , 'layerswp' ); ?>
						</a>
					</div>
				</div>
				<div class="l_admin-column l_admin-span-4 no-gutter">
					<div class="l_admin-content">
						<!-- Your helpful tips go here -->
						<ul class="l_admin-help-list">
							<li>
								<?php _e( sprintf( 'For tips on how best to name your website, we suggest reading <a href="%s" rel="nofollow">this post</a>', '//docs.layerswp.com' ) , 'layerswp' ); ?>
							</li>
							<li class="pro-tip">
								<?php _e( 'For the Pros: Layers will automatically assign this site name to Settings &rarr; General' , 'layerswp' ); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<!-- Create Default Pages -->
			<div class="l_admin-onboard-slide l_admin-animate l_admin-onboard-slide-inactive">
				<div class="l_admin-column l_admin-span-8 postbox">
					<div class="l_admin-content-large">
						<!-- Your content goes here -->
						<div class="l_admin-section-title">
							<h3 class="l_admin-heading">
								<?php _e( 'Create Starter Page(s)', 'layerswp' ); ?>
							</h3>
							<p class="l_admin-excerpt">
								<?php _e( "There are some standard pages that nearly all websites need. We recommend that you let us create these for you and apply settings to make them work best with Layers. *these can easily be deleted later if you're not sure", 'layerswp' ); ?>
							</p>
						</div>

						<?php echo $form_elements->input( array(
							'type' => 'hidden',
							'name' => 'action',
							'id' => 'action',
							'value' => 'layers_onboarding_create_pages'
						) ); ?>

						<div class="l_admin-checkbox-wrapper l_admin-large l_admin-form-item">
							<input id="layers-create-page-blog" name="create-page-blog" value="Blog" type="checkbox" checked="checked" />
							<label for="layers-create-page-blog">
								<?php _e( 'Blog Page', 'layerswp' ); ?>
								<i class="fa fa-question-circle" data-tip="<?php _e( 'Blog page shows your blog posts.' , 'layerswp' ); ?>"></i>
							</label>
						</div>

					</div>
					<div class="l_admin-button-well">
						<span class="l_admin-save-progress l_admin-hide l_admin-button btn-link" data-busy-message="<?php _e( 'Creating Page(s)', 'layerswp' ); ?>"></span>
						<a class="l_admin-button btn-primary l_admin-pull-right onboard-next-step" href=""><?php _e( 'Next Step &rarr;' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="l_admin-column l_admin-span-4 no-gutter">
					<div class="l_admin-content">

						<!-- Your helpful tips go here -->
						<ul class="l_admin-help-list">
							<li><?php _e( 'Get advice on the right theme for your site.' , 'layerswp' ); ?></li>
							<li><?php _e( 'Help choosing extensions.' , 'layerswp' ); ?></li>
							<li><?php _e( 'Feedback? Let us know as soon as it comes to mind.' , 'layerswp' ); ?></li>
							<li><?php _e( 'Have a problem? We\'ll send you the best link to solve your issues.' , 'layerswp' ); ?></li>
							<li><?php _e( 'Allow Layers to collect non-sensitive diagnostic data and usage information to help us improve our theme and best assist you.' , 'layerswp' ); ?></li>
						</ul>
					</div>
				</div>
			</div>

			<?php if( ! defined( 'LAYERS_DISABLE_INTERCOM' ) ){ ?>
				<!-- Enable / Disable Intercom -->
				<div class="l_admin-onboard-slide l_admin-animate l_admin-onboard-slide-inactive">
					<div class="l_admin-column l_admin-span-8 postbox">
						<div class="l_admin-content-large">
							<!-- Your content goes here -->
							<div class="l_admin-section-title">
								<h3 class="l_admin-heading">
									<?php _e( 'Layers Messenger' , 'layerswp' ); ?>
								</h3>
								<p class="l_admin-excerpt">
									<?php _e( 'Enable Layers Messenger to connect with the Layers team directly from inside Layers. By doing so we can provide you with support for your Layers site directly from your WordPress dashboard.' , 'layerswp' ); ?>
								</p>
							</div>
							<?php echo $form_elements->input( array(
								'type' => 'hidden',
								'name' => 'action',
								'id' => 'action',
								'value' => 'layers_update_intercom'
							) ); ?>
							<div class="l_admin-checkbox-wrapper l_admin-large l_admin-form-item l_admin-push-bottom-medium">
								<input id="layers-enable-intercom" name="layers_intercom" type="checkbox" <?php if( '0' !== get_option( 'layers_enable_intercom' ) ){ echo 'checked="checked"'; }; ?> />
								<label for="layers-enable-intercom"><?php _e( 'Enable Layers Messenger', 'layerswp' ); ?></label>
							</div>
							<p data-show-if-selector="#layers-enable-intercom" data-show-if-value="true" class="l_admin-form-item">
								<a href="//www.layerswp.com/privacy-policy/" target="_blank" id="layers-intercom-data-policy-link"><?php _e( 'Your data is safe with us. View our Privacy Policy', 'layerswp' ); ?></a>
								<label><?php _e( 'Your Name' , 'layerswp' ); ?></label>
								<?php
									global $current_user;
									echo $form_elements->input( array(
										'type' => 'text',
										'name' => 'username',
										'id' => 'username',
										'placeholder' => $current_user->display_name,
										'value' =>  $current_user->display_name,
										'class' => 'layers-text l_admin-large'
								   ) );
								?>
							</p>
						</div>
						<div class="l_admin-button-well">
							<span class="l_admin-save-progress l_admin-hide l_admin-button btn-link" data-busy-message="<?php _e( 'Saving Your Preference' , 'layerswp' ); ?>"></span>
							<a class="l_admin-button btn-primary l_admin-pull-right onboard-next-step" href=""><?php _e( 'Next Step &rarr;' , 'layerswp' ); ?></a>
						</div>
					</div>
					<div class="l_admin-column l_admin-span-4 no-gutter">
						<div class="l_admin-content">

							<!-- Your helpful tips go here -->
							<ul class="l_admin-help-list">
								<li><?php _e( 'Get advice on the right theme for your site.' , 'layerswp' ); ?></li>
								<li><?php _e( 'Help choosing extensions.' , 'layerswp' ); ?></li>
								<li><?php _e( 'Feedback? Let us know as soon as it comes to mind.' , 'layerswp' ); ?></li>
								<li><?php _e( 'Have a problem? We\'ll send you the best link to solve your issues.' , 'layerswp' ); ?></li>
								<li><?php _e( 'Allow Layers to collect non-sensitive diagnostic data and usage information to help us improve our theme and best assist you.' , 'layerswp' ); ?></li>
							</ul>
						</div>
					</div>
				</div>
			<?php } // If !disable intercom ?>

			<!-- Learn the Ropes: Widgets -->
			<div class="l_admin-onboard-slide l_admin-animate l_admin-onboard-slide-inactive">
				<div class="l_admin-column l_admin-span-6 postbox">
					<div class="l_admin-content-large">
						<!-- Your content goes here -->
						<div class="l_admin-section-title l_admin-small l_admin-no-push-bottom">
							<div class="l_admin-push-bottom-small">
								<small class="l_admin-label label-highlight">
									<?php _e( 'Getting Started' , 'layerswp' ); ?>
								</small>
							</div>
							<h3 class="l_admin-heading">
								<?php _e( 'Building pages' , 'layerswp' ); ?>
							</h3>
							<div class="l_admin-excerpt">
								<p>
									<?php _e( 'Layers splits your page into horizontal rows, and you build up your pages with blocks of content called &lsquo;Widgets&rsquo;, one per row.' , 'layerswp' ); ?>
								</p>
								<p>
									<?php _e( 'Each time you want to add a new content block, simply click &lsquo;Add Widget&rsquo; and select one from the list which has the blue Layers icon.' , 'layerswp' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="l_admin-button-well">
						<a class="l_admin-button btn-primary l_admin-pull-right onboard-next-step" href=""><?php _e( 'Got it, Next Step &rarr;' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="l_admin-column l_admin-span-6 no-gutter l_admin-demo-video">
					<?php layers_show_html5_video( '//cdn.oboxsites.com/layers/videos/adding-a-widget.mp4', 490 ); ?>
				</div>
			</div>

			<!-- Learn the Ropes: Design Bar -->
			<div class="l_admin-onboard-slide l_admin-animate l_admin-onboard-slide-inactive">
				<div class="l_admin-column l_admin-span-4 postbox">
					<div class="l_admin-content-large">
						<!-- Your content goes here -->
						<div class="l_admin-section-title l_admin-small l_admin-no-push-bottom">
							<div class="l_admin-push-bottom-small">
								<small class="l_admin-label label-highlight">
									<?php _e( 'Getting Started' , 'layerswp' ); ?>
								</small>
							</div>
							<h3 class="l_admin-heading">
								<?php _e( 'Editing widget content' , 'layerswp' ); ?>
							</h3>
							<div class="l_admin-excerpt">
								<p><?php _e( "To edit a widget's content, just click on it in the widget area on the left hand side. The widget panel will slide out allowing you to edit its content and customize its settings. You can also shift-click on the widget itself in the preview area." , 'layerswp' ); ?></p>
							</div>
						</div>
					</div>
					<div class="l_admin-button-well">
						<a class="l_admin-button btn-primary l_admin-pull-right onboard-next-step" href=""><?php _e( 'Next Step &rarr;' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="l_admin-column l_admin-span-8 no-gutter l_admin-demo-video">
					<?php layers_show_html5_video( '//cdn.oboxsites.com/layers/videos/widget-slider.mp4', 660 ); ?>
				</div>
			</div>

			<!-- Learn the Ropes: Editing Widgets -->
			<div class="l_admin-onboard-slide l_admin-animate l_admin-onboard-slide-inactive">
				<div class="l_admin-column l_admin-span-6 postbox">
					<div class="l_admin-content-large">
						<!-- Your content goes here -->
						<div class="l_admin-section-title l_admin-small l_admin-no-push-bottom">
							<div class="l_admin-push-bottom-small">
								<small class="l_admin-label label-highlight">
									<?php _e( 'Getting Started' , 'layerswp' ); ?>
								</small>
							</div>
							<h3 class="l_admin-heading">
								<?php _e( 'Customizing widgets' , 'layerswp' ); ?>
							</h3>
							<div class="l_admin-excerpt">
								<p>
									<?php _e( 'Unique to each Layers widget is the revolutionary &ldquo;Design Bar&rdquo; which allows you to set its design parameters without touching a line of code.' , 'layerswp' ); ?>
								</p>
								<p>
									<?php _e( 'Depending on the widget you\'ve added, you can change things like background images, font sizes, list styles and more.' , 'layerswp' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="l_admin-button-well">
						<a class="l_admin-button btn-primary l_admin-pull-right onboard-next-step" href=""><?php _e( 'Next Step &rarr;' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="l_admin-column l_admin-span-6 no-gutter l_admin-demo-video">
					<?php layers_show_html5_video( '//cdn.oboxsites.com/layers/videos/design-bar.mp4', 490 ); ?>
				</div>
			</div>

			<!-- Upload a Logo -->
			<div class="l_admin-onboard-slide l_admin-animate l_admin-onboard-slide-inactive">
				<div class="l_admin-column l_admin-span-8 postbox">
					<div class="l_admin-content-large">
						<!-- Your content goes here -->
						<div class="l_admin-section-title">
							<h3 class="l_admin-heading">
								<?php _e( 'Would you like to add your logo?' , 'layerswp' ); ?>
							</h3>
							<p class="l_admin-excerpt">
								 <?php _e( 'Layers will add your logo and position it properly. If you don&apos;t have one yet, no problem, you can add it later, or skip this step if you&apos;d just prefer to use text.' , 'layerswp' ); ?>
							</p>
						</div>
						<?php if( function_exists( 'the_custom_logo' ) ) {
							$site_logo[ 'id' ] =  get_theme_mod( 'custom_logo' );
						} else {
							$site_logo = get_option( 'site_logo' );
						} ?>

						<div class="l_admin-logo-wrapper">
							<div class="l_admin-logo-upload-controller">
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
					<div class="l_admin-button-well">
						<span class="l_admin-save-progress l_admin-hide l_admin-button btn-link" data-busy-message="<?php _e( 'Updating your Logo' , 'layerswp' ); ?>"></span>
						<a class="l_admin-button btn-primary l_admin-pull-right onboard-next-step" href=""><?php _e( 'Next Step &rarr;' , 'layerswp' ); ?></a>
					</div>
				</div>
				<div class="l_admin-column l_admin-span-4 no-gutter">
					<div class="l_admin-content">
						<!-- Your helpful tips go here -->
						<ul class="l_admin-help-list">
							<li><?php _e( 'For best results, use an image between 40px and 200px tall and not more than 1000px wide' , 'layerswp' ); ?></li>
							<li><?php _e( 'PNGs with a transparent background work best but GIFs or JPGs are fine too' , 'layerswp' ); ?></li>
							<li><?php _e( 'Try keep your logo file size below 500kb' , 'layerswp' ); ?></li>
						</ul>
					</div>
				</div>
			</div>

			<!-- Create a page to be your first Layout -->
			<div class="l_admin-onboard-slide l_admin-animate l_admin-onboard-slide-inactive">
				<div class="l_admin-column l_admin-span-8 l_admin-template-selector postbox">
					<div class="l_admin-content">
						 <?php if( layers_get_builder_pages() ) { ?>
							 <p class="l_admin-form-item">
								<label><?php _e( 'Page Title' , 'layerswp' ); ?></label>
								<?php
								   echo $form_elements->input( array(
										'type' => 'text',
										'name' => 'preset_page_title',
										'id' => 'preset_page_title',
										'placeholder' => __( 'Home Page' , 'layerswp' ),
										'value' => __( 'Home Page' , 'layerswp' ),
										'class' => 'layers-text l_admin-large l_admin-push-bottom-medium'
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
				<div class="l_admin-column l_admin-span-4 no-gutter postbox">
					<div class="l_admin-content-large">
						<!-- Your content goes here -->
						<div class="l_admin-section-title l_admin-small">
							<h3 class="l_admin-heading">
								<?php _e( 'Now let&apos;s create your first Layers page!' , 'layerswp' ); ?>
							</h3>
							<div class="l_admin-excerpt">
								<p>
									<?php _e( 'You will be able to edit your layout on the next page. Here we go! ' , 'layerswp' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="l_admin-button-well">
						<span class="l_admin-save-progress l_admin-hide l_admin-button btn-link" data-busy-message="<?php _e( 'Creating your Page' , 'layerswp' ); ?>"></span>
						<a class="l_admin-button btn-primary l_admin-pull-right onboard-next-step l_admin-proceed-to-customizer disable l_admin-tooltip" tooltip="<?php _e( 'First choose a layout' , 'layerswp' ); ?>" href=""><?php _e( 'Start Building' , 'layerswp' ); ?></a>
					</div>
				</div>
			</div>
		</div>

	</div>

</section>
