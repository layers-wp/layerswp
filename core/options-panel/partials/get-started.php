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
                                <?php _e( sprintf( 'If you\'re ever stuck or need help with your Layers site please visit our <a href="%s" rel="nofollow">helpful documentation.</a>', 'http://docs.layerswp.com' ) , 'layerswp' ); ?>
                            </li>
                            <li class="pro-tip"><?php _e( 'For the Pros: Layers will automatically assign the tagline to Settings &rarr; General.' , 'layerswp' ); ?></li>
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
                                    <?php _e( 'Getting Started' , 'layerswp' ); ?>
                                </small>
                            </div>
                            <h3 class="layers-heading">
                                <?php _e( 'Building pages' , 'layerswp' ); ?>
                            </h3>
                            <div class="layers-excerpt">
                                <p>
                                    <?php _e( '
                                        Layers splits your page into horizontal rows, and you build up your pages with blocks of content called &lsquo;Widgets&rsquo;, one per row.
                                    ' , 'layerswp' ); ?>
                                </p>
                                <p>
                                    <?php _e( '
                                        Each time you want to add a new content block, simply click &lsquo;Add Widget&rsquo; and select one from the list which has the blue Layers icon.
                                    ' , 'layerswp' ); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="layers-button-well">
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Got it, Next Step &rarr;' , 'layerswp' ); ?></a>
                    </div>
                </div>
                <div class="layers-column layers-span-6 no-gutter layers-demo-video">
                    <?php layers_show_html5_video( 'http://cdn.oboxsites.com/layers/videos/adding-a-widget.mp4', 490 ); ?>
                </div>
            </div>

            <!-- Give your site a Name -->
            <div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
                <div class="layers-column layers-span-8 postbox">
                    <div class="layers-content-large ">
                        <!-- Your content goes here -->
                        <div class="layers-section-title">
                            <h3 class="layers-heading">
                                <?php _e( 'What is the name of your website?' , 'layerswp' ); ?>
                            </h3>
                            <p class="layers-excerpt">
                                <?php _e( 'Enter your website name below. We&apos;ll use this in your site title and in search results.' , 'layerswp' ); ?>
                            </p>
                        </div>
                        <p class="layers-form-item">
                            <label><?php _e( 'Site Name' , 'layerswp' ); ?></label>
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
                                <?php _e( sprintf( 'For tips on how best to name your website, we suggest reading <a href="%s" rel="nofollow">this post</a>', 'http://docs.layerswp.com' ) , 'layerswp' ); ?>
                            </li>
                            <li class="pro-tip">
                                <?php _e( 'For the Pros: Layers will automatically assign this site name to Settings &rarr; General' , 'layerswp' ); ?>
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
                                    <?php _e( 'Getting Started' , 'layerswp' ); ?>
                                </small>
                            </div>
                            <h3 class="layers-heading">
                                <?php _e( 'Editing widget content' , 'layerswp' ); ?>
                            </h3>
                            <div class="layers-excerpt">
                                <p>
                                    <?php _e( '
                                        To edit a widget&apos;s content, just click on it in the widget area on the left hand side. The widget panel will slide
                                        out allowing you to edit its content and customize its settings. You can also shift-click on the widget itself in
                                        the preview area.
                                    ' , 'layerswp' ); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="layers-button-well">
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Next Step &rarr;' , 'layerswp' ); ?></a>
                    </div>
                </div>
                <div class="layers-column layers-span-8 no-gutter layers-demo-video">
                    <?php layers_show_html5_video( 'http://cdn.oboxsites.com/layers/videos/widget-slider.mp4', 660 ); ?>
                </div>
            </div>

            <!-- Give your site a Tagline -->
            <div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
                <div class="layers-column layers-span-8 postbox">
                    <div class="layers-content-large">
                        <!-- Your content goes here -->
                        <div class="layers-section-title">
                            <h3 class="layers-heading">
                                <?php _e( 'How would you best describe your site?' , 'layerswp' ); ?>
                            </h3>
                            <p class="layers-excerpt">
                                <?php _e( 'A tagline describes who and what you are in just a few simple words.
                                For example Layers is a &ldquo;WordPress Site Builder&rdquo; - simple, easy, quick to read. Now you try:' , 'layerswp' ); ?>
                            </p>
                        </div>
                        <p class="layers-form-item">
                            <label><?php _e( 'Site Tagline' , 'layerswp' ); ?></label>
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
                        <span class="layers-save-progress layers-hide layers-button btn-link" data-busy-message="<?php _e( 'Saving your Tagline' , 'layerswp' ); ?>"></span>
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href=""><?php _e( 'Next Step &rarr;' , 'layerswp' ); ?></a>
                    </div>
                </div>
                <div class="layers-column layers-span-4 no-gutter">
                    <div class="layers-content">
                        <!-- Your helpful tips go here -->
                        <ul class="layers-help-list">
                            <li><?php _e( 'Keep it simple' , 'layerswp' ); ?></li>
                            <li><?php _e( 'Avoid buzz words' , 'layerswp' ); ?></li>
                            <li><?php _e( 'Make sure it describes what you offer' , 'layerswp' ); ?></li>
                            <li class="pro-tip"><?php _e( 'For the Pros: Layers will automatically assign the tagline to Settings &rarr; General' , 'layerswp' ); ?></li>
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
                    <?php layers_show_html5_video( 'http://cdn.oboxsites.com/layers/videos/design-bar.mp4', 490 ); ?>
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
                                 <?php _e( '

                                    Layers will add your logo and position it properly. If
                                    you don&apos;t have one yet, no problem, you can add it
                                    later, or skip this step if you&apos;d just prefer to use text.

                                 ' , 'layerswp' ); ?>
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
                                    <?php _e( '
                                        Simply select a preset layout from the list and Layers will automatically create it for you.
                                        You will be able to edit your layout on the next page. Here we go!
                                    ' , 'layerswp' ); ?>
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
