<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Instantiate Inputs
$form_elements = new Layers_Form_Elements(); ?>

<?php // Instantiate the widget migrator
$layers_migrator = new Layers_Widget_Migrator(); ?>

<section class="layers-area-wrapper">

    <div class="layers-onboard-wrapper">

        <div class="layers-onboard-controllers">
            <div class="onboard-nav-dots layers-pull-left" id="layers-onboard-anchors">
                <a class="layers-dot dot-active" href=""></a>
                <a class="layers-dot" href=""></a>
                <a class="layers-dot" href=""></a>
                <a class="layers-dot" href=""></a>
            </div>
            <a class="layers-button btn-link layers-pull-right" href="" id="layers-onboard-skip">Skip</a>

        </div>

        <div class="layers-onboard-slider">

            <!-- Give your site a Name -->
            <div class="layers-onboard-slide layers-animate layers-onboard-slide-current">
                <div class="layers-column layers-span-12 postbox">
                    <div class="layers-content-large">
                        <!-- Your content goes here -->
                        <div class="layers-section-title layers-no-push-bottom">
                            <h3 class="layers-heading">
                                Welcome to Layers!
                            </h3>
                            <p class="layers-excerpt">

                                Layers is a revolutionary WordPress theme that enables you to build any website you want.
                                This is a step by step setup process to help you get going with
                                minimum fuss. Enjoy the ride!

                            </p>
                        </div>
                    </div>
                    <div class="layers-button-well">
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href="">Let's get Started &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Give your site a Name -->
            <div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
                <div class="layers-column layers-span-8 postbox">
                    <div class="layers-content-large">
                        <!-- Your content goes here -->
                        <div class="layers-section-title">
                            <h3 class="layers-heading">
                                What is the name of your website?
                            </h3>
                            <p class="layers-excerpt">
                                Probably the easiest part of creating any website is giving it a name. No code skills required here!
                            </p>
                        </div>
                        <p class="layers-form-item">
                            <label>Site Name</label>
                            <?php
                               echo $form_elements->input( array(
                                    'type' => 'text',
                                    'name' => 'site-title',
                                    'id' => 'site-title',
                                    'placeholder' => get_bloginfo( 'name' ),
                                    'value' => get_bloginfo( 'name' ),
                                    'class' => 'layers-text'
                               ) );
                            ?>
                        </p>
                    </div>
                    <div class="layers-button-well">
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href="">Next Step &rarr;</a>
                    </div>
                </div>
                <div class="layers-column layers-span-4 no-gutter">
                    <div class="layers-content">
                        <!-- Your helpful tips go here -->
                        <ul class="layers-help-list">
                            <li>
                                For tips on how best to name your website, we suggest visiting <a href="http://help.layerswp.com/" rel="nofollow">this post.</a>
                            </li>
                            <li class="pro-tip">For the Pros: Layers will automatically assign this site name to Settings &rarr; General.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Give your site a Tagline -->
            <div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
                <div class="layers-column layers-span-8 postbox">
                    <div class="layers-content-large">
                        <!-- Your content goes here -->
                        <div class="layers-section-title">
                            <h3 class="layers-heading">
                                How would you best describe your site?
                            </h3>
                            <p class="layers-excerpt">
                                A tagline describes who and what you are in just a few simple words.
                                For example Layers is a 'WordPress Site Builder' - simple, easy, quick to read. Now you try:
                            </p>
                        </div>
                        <p class="layers-form-item">
                            <label>Site Tagline</label>
                            <?php
                               echo $form_elements->input( array(
                                    'type' => 'text',
                                    'name' => 'site-tagline',
                                    'id' => 'site-tagline',
                                    'placeholder' => get_bloginfo( 'description' ),
                                    'value' => get_bloginfo( 'description' ),
                                    'class' => 'layers-text'
                               ) );
                            ?>
                        </p>
                    </div>
                    <div class="layers-button-well">
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href="">Next Step &rarr;</a>
                    </div>
                </div>
                <div class="layers-column layers-span-4 no-gutter">
                    <div class="layers-content">
                        <!-- Your helpful tips go here -->
                        <ul class="layers-help-list">
                            <li>Keep it simple</li>
                            <li>Avoid buzz words</li>
                            <li>Make sure it describes what you offer</li>
                            <li class="pro-tip">For the Pros: Layers will automatically assign the tagline to Settings &rarr; General.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Upload a Logo -->
            <div class="layers-onboard-slide layers-animate layers-onboard-slide-inactive">
                <div class="layers-column layers-span-8 postbox">
                    <div class="layers-content-large">
                        <!-- Your content goes here -->
                        <div class="layers-section-title">
                            <h3 class="layers-heading">
                                Great! Now let's add a logo
                            </h3>
                            <p class="layers-excerpt">
                                 A website logo is a useful contributor to the general look and feel of your site.
                                 Luckily with Layers, you can add one easily.
                            </p>
                        </div>
                        <div class="layers-logo-wrapper">
                            <div class="layers-logo-upload-controller">
                                <?php
                                   echo $form_elements->input( array(
                                        'label' => __( 'Choose Logo' , LAYERS_THEME_SLUG ),
                                        'type' => 'image',
                                        'name' => 'site-logo',
                                        'id' => 'site-logo',
                                        'value' => get_bloginfo( 'description' )
                                   ) );
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="layers-button-well">
                        <a class="layers-button btn-primary layers-pull-right onbard-next-step" href="">Next Step &rarr;</a>
                    </div>
                </div>
                <div class="layers-column layers-span-4 no-gutter">
                    <div class="layers-content">
                        <!-- Your helpful tips go here -->
                        <ul class="layers-help-list">
                            <li>Any size is fine, Layers will resize it automatically to fit your site</li>
                            <li>PNGs with a transparent background work best but GIFs or JPGs are fine too</li>
                            <li>Try keep your logo file size below 500kb</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>


    </div>

</section>
