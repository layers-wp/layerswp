<?php global $layers_regsiter_message; ?>
<?php $form_elements = new Layers_Form_Elements(); ?>
<section class="layers-welcome">

    <div class="layers-page-title layers-section-title layers-large layers-content-massive layers-no-push-bottom">
        <div class="layers-container">
            <h2 class="layers-heading" id="layers-options-header">
                <?php _e(' Layers Registration' , LAYERS_THEME_SLUG ); ?>
            </h2>
            <p class="layers-excerpt">
                <?php _e( 'Enter your Layers API key to automatically receive features and updates.' , LAYERS_THEME_SLUG ); ?>
            </p>
        </div>
    </div>

    <div class="layers-row layers-well layers-content-massive">
        <div class="layers-container">
            <form action="" method="POST">
                <div class="layers-row">
                    <div class="layers-column layers-span-12">
                        <div class="layers-section-title layers-tiny">
                            <?php if( isset( $layers_regsiter_message ) ) echo $layers_regsiter_message; ?>
                            <p class="layers-form-item">
                                <label><?php _e( 'Obox API key:', LAYERS_THEME_SLUG ); ?></label>
                                <?php echo $form_elements->input(array(
                                    'label' => __( 'Obox Username:', LAYERS_THEME_SLUG ),
                                    'type' => 'text',
                                    'name' => 'layers_obox_api_key',
                                    'id' =>  'layers_obox_api_key',
                                    'value' => get_option( 'layers_api_key' )
                                )); ?>
                            </p>
                            <p class="layers-form-item">
                                <button class="layers-button btn-primary btn-large"><?php _e( 'Verify API Key' , LAYERS_THEME_SLUG ); ?></button>
                            </p>
                            <p><em><?php _e( 'Follow this link to get your API credentials <a href="http://oboxthemes.com/api">Obox Themes API</a>', LAYERS_THEME_SLUG ); ?></em></p>
                        </div>
                    </div>
                </div>
                <?php wp_nonce_field( 'layers_save_api_key', '_wpnonce_layers_api_key' ); ?>
            </form>
        </div>
    </div>

</section>

    <?php $this->footer(); ?>
