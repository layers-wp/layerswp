<?php // Get the API up and running for the plugin listing
$api = new Layers_API(); ?>

<?php $style_kits = $api->get_stylekit_list(); ?>

      <?php // Instantiate the widget migrator
      $layers_migrator = new Layers_Widget_Migrator(); ?>

<section class="layers-area-wrapper" id="layers-add-new-page">

   <?php $this->header( __( 'Style Kits' , 'layerswp' ) ); ?>

   <div class="layers-row layers-well layers-content-large">
      <div class="layers-browser">
         <div class="layers-products">
            <?php if( is_wp_error( $style_kits ) ) { ?>
               <p>You. Shall. Not. Pass.</p>
            <?php } else { ?>
               <?php foreach( $style_kits->matches as $key => $details ) { ?>
                  <div class="layers-product active" tabindex="0">
                     <!-- <pre><?php  print_r( $details ); ?></pre> -->
                     <input name="layes-preset-layout" id="layers-preset-layout-<?php echo $details->id; ?>-radio" class="layers-hide" type="radio" value="<?php echo $key; ?>" />
                     <label for="layers-preset-layout-<?php echo esc_attr( $key ); ?>-radio">
                        <div class="layers-product-screenshot">
                           <?php if ( isset( $details->previews->icon_with_landscape_preview->landscape_url ) ) {
                              echo $layers_migrator->generate_preset_layout_screenshot( $details->previews->icon_with_landscape_preview->landscape_url, 'jpg' );
                           } ?>
                        </div>
                        <h3 class="layers-product-name" id="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( substr( $details->name, 0 , 27 )  . ( 27 < strlen( $details->name ) ? '...' : '' ) ); ?></h3>
                        <div class="layers-product-actions">
                           <a class="layers-button btn-primary" href="<?php echo esc_attr( $details->url ); ?>" target="_blank"><?php _e( 'Buy the StyleKit' , 'layerswp' ); ?></a>
                        </div>
                     </label>
                  </div>
               <?php } // Get Preset Layouts ?>
            <?php } ?>
         </div>
      </div>
   </div>

</section>

<?php $this->footer(); ?>