<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Instantiate Inputs
$form_elements = new Layers_Form_Elements(); ?>

<?php // Instantiate the widget migrator
$layers_migrator = new Layers_Widget_Migrator(); ?>

<section class="layers-area-wrapper">

    <div class="layers-onboard-wrapper">

        <div class="layers-onboard-controllers">
            <div class="onboard-nav-dots layers-pull-left" id="layers-onboard-anchors"></div>
            <a class="layers-button btn-link layers-pull-right" href="" id="layers-onboard-skip">Skip</a>

        </div>

        <div class="layers-onboard-slider">

            <!-- Welcome -->
            <div class="layers-onboard-slide layers-animate layers-onboard-slide-current">
                <div class="layers-column layers-span-8 postbox">
                    <div class="layers-content-large">
                        <!-- Your content goes here -->
                        <div class="layers-section-title layers-no-push-bottom">
                            <h3 class="layers-heading">
                                <?php _e( 'Thanks for choosing Layers!' , LAYERS_THEME_SLUG ); ?>
                            </h3>
                            <div class="layers-excerpt">
                                <p>
                                    <?php _e( 'Layers is a revolutionary WordPress theme that enables you to build any website you want.' , LAYERS_THEME_SLUG ); ?>
                                </p>
                                <p>
                                    <?php _e( 'The following step by step setup process is designed to help you learn the ropes and get started with minimum fuss. Enjoy the ride!' , LAYERS_THEME_SLUG ); ?>
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="layers-button-well">
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Let\'s get Started &rarr;' , LAYERS_THEME_SLUG ); ?></a>
                    </div>
                </div>
                <div class="layers-column layers-span-4 no-gutter">
                    <div class="layers-content">
                        <!-- Your helpful tips go here -->
                        <ul class="layers-help-list">
                            <li>
                                <?php _e( 'If you\'re ever stuck or need help with your Layers site please visit our <a href="http://help.layerswp.com/" rel="nofollow">helpful documentation.</a>' , LAYERS_THEME_SLUG ); ?>
                            </li>
                            <li class="pro-tip"><?php _e( 'For the Pros: Layers will automatically assign the tagline to Settings &rarr; General.' , LAYERS_THEME_SLUG ); ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Learn the Ropes: Widgets -->
            <div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
                <div class="layers-column layers-span-6 postbox">
                    <div class="layers-content-large">
                        <!-- Your content goes here -->
                        <div class="layers-section-title layers-small layers-no-push-bottom">
                            <div class="layers-push-bottom-small">
                                <small class="layers-label label-secondary">
                                    <?php _e( 'Getting Started' , LAYERS_THEME_SLUG ); ?>
                                </small>
                            </div>
                            <h3 class="layers-heading">
                                <?php _e( 'Building pages' , LAYERS_THEME_SLUG ); ?>
                            </h3>
                            <div class="layers-excerpt">
                                <p>
                                    <?php _e( '
                                        Layers works by placing widgets into a "Page Builder" widget area in the WordPress Visual Customizer.
                                    ' , LAYERS_THEME_SLUG ); ?>
                                </p>
                                <p>
                                    <?php _e( '
                                        Each time you want to add a new Layers building block simply click "Add Widget" and select any item
                                        from the list which has a blue icon.
                                    ' , LAYERS_THEME_SLUG ); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="layers-button-well">
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Got it, Next Step &rarr;' , LAYERS_THEME_SLUG ); ?></a>
                    </div>
                </div>
                <div class="layers-column layers-span-6 no-gutter layers-demo-video">
                    <video width="490" height="490" controls>
                        <source src="http://cdn.oboxsites.com/layers/videos/adding-a-widget.mp4?v=<?php echo LAYERS_VERSION; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                </div>
            </div>

            <!-- Give your site a Name -->
            <div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
                <div class="layers-column layers-span-8 postbox">
                    <div class="layers-content-large ">
                        <!-- Your content goes here -->
                        <div class="layers-section-title">
                            <h3 class="layers-heading">
                                <?php _e( 'What is the name of your website?' , LAYERS_THEME_SLUG ); ?>
                            </h3>
                            <p class="layers-excerpt">
                                <?php _e( 'Probably the easiest part of creating any website is giving it a name. No code skills required here!' , LAYERS_THEME_SLUG ); ?>
                            </p>
                        </div>
                        <p class="layers-form-item">
                            <label><?php _e( 'Site Name' , LAYERS_THEME_SLUG ); ?></label>
                            <?php
                               echo $form_elements->input( array(
                                    'type' => 'text',
                                    'name' => 'blogname',
                                    'id' => 'blogname',
                                    'placeholder' => get_bloginfo( 'name' ),
                                    'value' => get_bloginfo( 'name' ),
                                    'class' => 'layers-text layers-large'
                               ) );
                            ?>
                        </p>
                        <?php echo $form_elements->input( array(
                            'type' => 'hidden',
                            'name' => 'action',
                            'id' => 'action',
                            'value' => 'layers_onboarding_update_options'
                        ) ); ?>
                    </div>
                    <div class="layers-button-well">
                        <span class="layers-save-progress layers-hide layers-button btn-link" data-busy-message="<?php _e( 'Saving your Site Name' , LAYERS_THEME_SLUG ); ?>"></span>
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href="">
                            <?php _e( 'Next Step &rarr;' , LAYERS_THEME_SLUG ); ?>
                        </a>
                    </div>
                </div>
                <div class="layers-column layers-span-4 no-gutter">
                    <div class="layers-content">
                        <!-- Your helpful tips go here -->
                        <ul class="layers-help-list">
                            <li>
                                <?php _e( 'For tips on how best to name your website, we suggest reading <a href="http://help.layerswp.com/" rel="nofollow">this post</a>' , LAYERS_THEME_SLUG ); ?>
                            </li>
                            <li class="pro-tip">
                                <?php _e( 'For the Pros: Layers will automatically assign this site name to Settings &rarr; General' , LAYERS_THEME_SLUG ); ?>
                            </li>
                        </ul>
                    </div>
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
                                    <?php _e( 'Getting Started' , LAYERS_THEME_SLUG ); ?>
                                </small>
                            </div>
                            <h3 class="layers-heading">
                                <?php _e( 'Editing widget content' , LAYERS_THEME_SLUG ); ?>
                            </h3>
                            <div class="layers-excerpt">
                                <p>
                                    <?php _e( 'The two most powerful widgets in Layers are the Slider and Content widgets which allow you to add content without leaving the Visual Customizer.' , LAYERS_THEME_SLUG ); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="layers-button-well">
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Next Step &rarr;' , LAYERS_THEME_SLUG ); ?></a>
                    </div>
                </div>
                <div class="layers-column layers-span-8 no-gutter layers-demo-video">
                    <video width="900" height="490" controls>
                        <source src="http://cdn.oboxsites.com/layers/videos/widget-slider.mp4?v=<?php echo LAYERS_VERSION; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                </div>
            </div>

            <!-- Give your site a Tagline -->
            <div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
                <div class="layers-column layers-span-8 postbox">
                    <div class="layers-content-large">
                        <!-- Your content goes here -->
                        <div class="layers-section-title">
                            <h3 class="layers-heading">
                                <?php _e( 'How would you best describe your site?' , LAYERS_THEME_SLUG ); ?>
                            </h3>
                            <p class="layers-excerpt">
                                <?php _e( 'A tagline describes who and what you are in just a few simple words.
                                For example Layers is a "WordPress Site Builder" - simple, easy, quick to read. Now you try:' , LAYERS_THEME_SLUG ); ?>
                            </p>
                        </div>
                        <p class="layers-form-item">
                            <label><?php _e( 'Site Tagline' , LAYERS_THEME_SLUG ); ?></label>
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
                        </p>
                        <?php echo $form_elements->input( array(
                            'type' => 'hidden',
                            'name' => 'action',
                            'id' => 'action',
                            'value' => 'layers_onboarding_update_options'
                        ) ); ?>
                    </div>
                    <div class="layers-button-well">
                        <span class="layers-save-progress layers-hide layers-button btn-link" data-busy-message="<?php _e( 'Saving your Tagline' , LAYERS_THEME_SLUG ); ?>"></span>
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Next Step &rarr;' , LAYERS_THEME_SLUG ); ?></a>
                    </div>
                </div>
                <div class="layers-column layers-span-4 no-gutter">
                    <div class="layers-content">
                        <!-- Your helpful tips go here -->
                        <ul class="layers-help-list">
                            <li><?php _e( 'Keep it simple' , LAYERS_THEME_SLUG ); ?></li>
                            <li><?php _e( 'Avoid buzz words' , LAYERS_THEME_SLUG ); ?></li>
                            <li><?php _e( 'Make sure it describes what you offer' , LAYERS_THEME_SLUG ); ?></li>
                            <li class="pro-tip"><?php _e( 'For the Pros: Layers will automatically assign the tagline to Settings &rarr; General' , LAYERS_THEME_SLUG ); ?></li>
                        </ul>
                    </div>
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
                                    <?php _e( 'Getting Started' , LAYERS_THEME_SLUG ); ?>
                                </small>
                            </div>
                            <h3 class="layers-heading">
                                <?php _e( 'Customizing widgets' , LAYERS_THEME_SLUG ); ?>
                            </h3>
                            <div class="layers-excerpt">
                                <p>
                                    <?php _e( 'Unique to each Layers widget is the revolutionary "Design Bar" which allows you to set its design parameters without touching a line of code.' , LAYERS_THEME_SLUG ); ?>
                                </p>
                                <p>
                                    <?php _e( 'Depending on the widget you\'ve added, you can change things like background images, font sizes, list styles and more.' , LAYERS_THEME_SLUG ); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="layers-button-well">
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Next Step &rarr;' , LAYERS_THEME_SLUG ); ?></a>
                    </div>
                </div>
                <div class="layers-column layers-span-6 no-gutter layers-demo-video">
                    <video width="490" height="490" controls>
                        <source src="http://cdn.oboxsites.com/layers/videos/design-bar.mp4?v=<?php echo LAYERS_VERSION; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                </div>
            </div>

            <!-- Upload a Logo -->
            <div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
                <div class="layers-column layers-span-8 postbox">
                    <div class="layers-content-large">
                        <!-- Your content goes here -->
                        <div class="layers-section-title">
                            <h3 class="layers-heading">
                                <?php _e( 'Would you like to add a logo?' , LAYERS_THEME_SLUG ); ?>
                            </h3>
                            <p class="layers-excerpt">
                                 <?php _e( 'A website logo is a useful contributor to the general look and feel of your site.
                                 Luckily with Layers, you can add one easily.' , LAYERS_THEME_SLUG ); ?>
                            </p>
                        </div>
                        <?php $site_logo = get_option( 'site_logo' ); ?>
                        <div class="layers-logo-wrapper">
                            <div class="layers-logo-upload-controller">
                                <?php
                                   echo $form_elements->input( array(
                                        'label' => __( 'Choose Logo' , LAYERS_THEME_SLUG ),
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
                        <span class="layers-save-progress layers-hide layers-button btn-link" data-busy-message="<?php _e( 'Updating your Logo' , LAYERS_THEME_SLUG ); ?>"></span>
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Next Step &rarr;' , LAYERS_THEME_SLUG ); ?></a>
                    </div>
                </div>
                <div class="layers-column layers-span-4 no-gutter">
                    <div class="layers-content">
                        <!-- Your helpful tips go here -->
                        <ul class="layers-help-list">
                            <li><?php _e( 'Any dimension is fine, Layers will resize it automatically to fit your site' , LAYERS_THEME_SLUG ); ?></li>
                            <li><?php _e( 'PNGs with a transparent background work best but GIFs or JPGs are fine too' , LAYERS_THEME_SLUG ); ?></li>
                            <li><?php _e( 'Try keep your logo file size below 500kb' , LAYERS_THEME_SLUG ); ?></li>
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
                                <label><?php _e( 'Page Title' , LAYERS_THEME_SLUG ); ?></label>
                                <?php
                                   echo $form_elements->input( array(
                                        'type' => 'text',
                                        'name' => 'preset_page_title',
                                        'id' => 'preset_page_title',
                                        'placeholder' => __( 'Home Page' , LAYERS_THEME_SLUG ),
                                        'value' => __( 'Home Page' , LAYERS_THEME_SLUG ),
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
                                <?php _e( 'Last Step, choose a page layout' , LAYERS_THEME_SLUG ); ?>
                            </h3>
                            <div class="layers-excerpt">
                                <p>
                                    <?php _e( '
                                        This is the final step in creating your first Layers page!
                                        Simply select a preset layout from the list and we will automatically create it for you.
                                    ', LAYERS_THEME_SLUG ); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="layers-button-well">
                        <span class="layers-save-progress layers-hide layers-button btn-link" data-busy-message="<?php _e( 'Creating your Page' , LAYERS_THEME_SLUG ); ?>"></span>
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Proceed to Customizer' , LAYERS_THEME_SLUG ); ?></a>
                    </div>
                </div>
            </div>

        </div>


    </div>

</section>
