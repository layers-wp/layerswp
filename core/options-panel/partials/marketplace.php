<?php // Get the API up and running for the plugin listing
$api = new Layers_API();
$layers_migrator = new Layers_Widget_Migrator();

$valid_types = array( 'stylekits' , 'extensions' , 'themes' );

$type = isset( $_GET[ 'type' ] ) ? $_GET[ 'type' ] : 'themes';

if( !in_array( $type, $valid_types ) ) return; ?>

<?php switch( $type ){
   case 'stylekits' :
      $excerpt = __( 'Style Kits' , 'layerswp' );
      $products = $api->get_stylekit_list();
      break;
   case 'extensions' :
      $excerpt = __( 'Extensions' , 'layerswp' );
      $products = $api->get_extension_list();
      break;
   default :
      $excerpt = __( 'Themes' , 'layerswp' );
      $products = $api->get_theme_list();

}; ?>

<section class="layers-area-wrapper" >

   <?php $this->header( 'Marketplace' , $excerpt ); ?>

   <div class="layers-row layers-well layers-content-large">
      <div class="layers-browser">
         <div class="layers-products">
            <?php if( is_wp_error( $products ) ) { ?>
               <p>You. Shall. Not. Pass.</p>
               <?php print_r( $products ); ?>
            <?php } else { ?>
               <?php foreach( $products->matches as $key => $details ) { ?>
                  <div class="layers-product active" tabindex="0">
                     <!-- <pre><?php  print_r( $details ); ?></pre> -->
                     <label for="layers-preset-layout-<?php echo esc_attr( $key ); ?>-radio">
                        <h3 class="layers-product-name" id="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $details->name ); ?></h3>
                        <?php if ( isset( $details->previews->icon_with_landscape_preview->landscape_url ) ) {
                           $image_src = $details->previews->icon_with_landscape_preview->landscape_url ;
                        } else if ( isset( $details->previews->icon_with_video_preview->landscape_url ) ) {
                           $image_src = $details->previews->icon_with_video_preview->landscape_url ;
                        }
                        if( $image_src ) { ?>
                           <div class="layers-product-screenshot" style="height: auto;">
                              <?php echo $layers_migrator->generate_preset_layout_screenshot( $image_src , 'jpg' ); ?>
                           </div>

                        <?php } ?>
                        <div class="layers-product-actions">
                           <a class="layers-button btn-subtle" href="<?php echo esc_attr( $details->url ); ?>" target="_blank">
                           <?php _e( 'Details' , 'layerswp' ); ?>
                           </a>
                           <a class="layers-button btn-primary" href="<?php echo esc_attr( $details->url ); ?>" target="_blank">
                              <?php _e( 'Buy for ' , 'layerswp' ); ?>
                              $<?php echo (float) ($details->price_cents/100); ?>
                           </a>
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