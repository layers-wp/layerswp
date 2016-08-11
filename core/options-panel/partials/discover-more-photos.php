<?php // Get the API up and running for the plugin listing
$api = new Layers_API(); ?>

<!-- Uderscore Temnplate -->
<?php if( !isset( $_GET[ 'tab' ] ) || ( isset( $_GET[ 'tab' ] ) && 'upsell_media' !== $_GET[ 'tab' ] ) ) { ?>
    <script type="text/html" id="tmpl-layers-discover-more-photos">
<?php } ?>
    <div class="layers-discover-more-photos">

        <div class="layers-section-title layers-large layers-text-center layers-push-bottom-large">
            <div class="layers-heading">
                <?php _e( "Can't find the perfect image?" , "layerswp" ); ?>
            </div>
            <div class="layers-excerpt">
                <?php _e( sprintf( 'Visit <a href="%s" target="_blank">Photodune</a> and find just the right photos for your site at incredibly affordable prices' , 'http://bit.ly/layers-photodune' ) , 'layerswp' ); ?>
            </div>
        </div>

        <div class="layers-row layers-content layers-discover-more-feature layers-push-bottom">
            <?php /**
            * Retrieve Popular photos
            */
            $popular = $api->get_popular( 'photodune' );

            if( !is_wp_error( $popular ) ) {
                if( isset( $popular->popular->items_last_week ) ){
                    shuffle( $popular->popular->items_last_week ) ?>
                    <?php foreach( $popular->popular->items_last_week as $key => $photo ) { ?>
                        <?php if( 8 <= $key ) continue; ?>
                        <div class="layers-column layers-span-3 t-center">
                            <a href="<?php echo $photo->url; ?>?ref=obox" target="_blank">
                                <img alt="<?php echo esc_attr( $photo->item ); ?>" src="<?php echo $photo->live_preview_url; ?>" />
                            </a>
                        </div>
                   <?php } ?>
                <?php }
            } else { ?>
                <img src="<?php echo get_template_directory_uri(); ?>/core/assets/images/more-photos.jpg" />
            <?php } ?>
        </div>

        <p class="layers-clearfix">
            <a class="layers-button btn-primary btn-large" href="http://bit.ly/layers-photodune" target="_blank"><?php _e( 'Find the Perfect Photo' , 'layerswp' ); ?></a>
        </p>
    </div>
<?php if( !isset( $_GET[ 'tab' ] ) || ( isset( $_GET[ 'tab' ] ) && 'upsell_media' !== $_GET[ 'tab' ] ) ) { ?>
    </script>
<?php } ?>
<!-- /Uderscore Temnplate -->
