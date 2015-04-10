<?php // Fetch current user information
$user = wp_get_current_user(); ?>
<?php // Get the API up and running for the extension listing
$api = new Layers_API(); ?>

<section class="layers-area-wrapper">

    <?php $this->header( __( 'Plugins' , 'layerswp' ) ); ?>

    <div class="layers-row layers-well layers-content-large">
        <div class="layers-container-large">

            <div class="layers-row">

                <div class="layers-column layers-span-5">

                    <div class="layers-panel">
                        <div class="layers-panel-title">
                            <h4 class="layers-heading"><?php _e( 'Available Extensions' , 'layerswp' ); ?></h4>
                        </div>

                        <ul class="layers-list layers-extensions">
                            <?php foreach( layers_get_plugins() as $extension_key => $extension_details ) { ?>
                                <li>
                                    <h3 class="layers-heading">
                                        <?php echo $extension_details[ 'Name' ]; ?>
                                    </h3>
                                    <?php if( isset( $extension_details[ 'Description' ] ) ){ ?>
                                        <p>
                                            <?php echo $extension_details[ 'Description' ]; ?>
                                        </p>
                                    <?php } ?>
                                </li>
                            <?php } // foreach extensions ?>
                        </ul>

                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
<?php $this->footer(); ?>