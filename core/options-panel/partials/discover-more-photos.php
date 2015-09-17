<!-- Uderscore Temnplate -->
<?php if( !isset( $_GET[ 'tab' ] ) ) { ?>
    <script type="text/html" id="tmpl-layers-discover-more-photos">
<?php } ?>
    <div class="layers-discover-more-photos">

        <div class="layers-section-title layers-large layers-text-center layers-push-bottom-large">
            <div class="layers-heading">
                <?php _e( 'Can’t find the perfect image?' , 'layerswp' ); ?>
            </div>
            <div class="layers-excerpt">
                <?php _e( sprintf( 'Visit <a href="%s" target="_blank">Photodune</a> and find just the right photos for your site at incredibly affordable prices' , 'http://bit.ly/layers-photodune' ) , 'layerswp' ); ?>
            </div>
        </div>

        <div class="layers-discover-more-feature layers-push-bottom-large"></div>

        <div class="layers-row">
            <a class="layers-button btn-primary btn-large" href="http://bit.ly/layers-photodune" target="_blank"><?php _e( 'Find the Perfect Photo' , 'layerswp' ); ?></a>
        </div>

    </div>
<?php if( !isset( $_GET[ 'tab' ] ) ) { ?>
    </script>
<?php } ?>
<!-- /Uderscore Temnplate -->
