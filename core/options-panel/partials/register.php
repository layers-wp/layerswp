<?php global $hatch_regsiter_message; ?>
<?php $form_elements = new Hatch_Form_Elements(); ?>
<section class="hatch-container hatch-content-large">

    <div class="hatch-row hatch-well hatch-content-large hatch-push-bottom">
        <div class="hatch-section-title">
            <h4 class="hatch-heading"><?php _e(' Hatch Registration' , HATCH_THEME_SLUG ); ?></h4>
            <p class="hatch-excerpt">
                <?php _e( 'This page will help you manage your Hatch API credentials allowing you to receive updates from Obox.' , HATCH_THEME_SLUG ); ?>
            </p>
        </div>
        <form action="" method="POST">
            <div class="hatch-row">
                <div class="hatch-column hatch-span-12">
                    <div class="hatch-section-title hatch-tiny">
                        <?php if( isset( $hatch_regsiter_message ) ) echo $hatch_regsiter_message; ?>
                        <p class="hatch-form-item">
                            <label class="hatch-heading"><?php _e( 'Obox API key:', HATCH_THEME_SLUG ); ?></label>
                            <?php echo $form_elements->input(array(
                                'label' => __( 'Obox Username:', HATCH_THEME_SLUG ),
                                'type' => 'text',
                                'name' => 'hatch_obox_api_key',
                                'id' =>  'hatch_obox_api_key',
                                'value' => get_option( 'hatch_api_key' )
                            )); ?>
                        </p>
                        <p class="hatch-form-item">
                            <button class="hatch-button btn-primary btn-large"><?php _e( 'Verify' , HATCH_THEME_SLUG ); ?></button>
                        </p>
                        <p><em><?php _e( 'Follow this link to get your API credentials <a href="http://oboxthemes.com/api">Obox Themes API</a>', HATCH_THEME_SLUG ); ?></em></p>
                    </div>
                </div>
            </div>
            <?php wp_nonce_field( 'hatch_save_api_key', '_wpnonce_hatch_api_key' ); ?>
        </form>
    </div>

    <?php $this->footer(); ?>

</section>
