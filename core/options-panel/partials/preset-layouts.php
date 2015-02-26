<div class="layers-browser">
   <div class="layers-products">

      <?php // Instantiate the widget migrator
      $layers_migrator = new Layers_Widget_Migrator(); ?>

      <?php
      foreach( $layers_migrator->get_preset_layouts() as $template_key => $template ) :
         $post_id = !empty($template['post_id']) ? intval($template['post_id']) : 0; ?>

         <div <?php if ( $post_id ) printf('data-post-id="%d"', $post_id); ?> class="layers-product active  <?php echo ( isset( $template[ 'container-css' ] ) ?  esc_attr( $template[ 'container-css' ] ) : '' ); ?>" tabindex="0">
            <input name="layes-preset-layout" id="layers-preset-layout-<?php echo $template_key; ?>-radio" class="layers-hide" type="radio" value="<?php echo $template_key; ?>" />
            <label for="layers-preset-layout-<?php echo esc_attr( $template_key ); ?>-radio">
               <input id="layers-preset-layout-<?php echo esc_attr( $template_key ); ?>-title" type="hidden" value="<?php echo $template[ 'title' ]; ?>" />
               <input id="layers-preset-layout-<?php echo esc_attr( $template_key ); ?>-widget_data" type="hidden" value="<?php echo esc_attr( $template[ 'json' ] ); ?>" />
               <div class="layers-product-screenshot">
               <?php if ( isset( $template[ 'screenshot' ] ) && NULL != $template[ 'screenshot' ] ) : ?>
                  <?php echo $layers_migrator->generate_preset_layout_screenshot( $template[ 'screenshot' ], $template[ 'screenshot_type' ] ); ?>
               <?php endif; ?>
                  </div>
               <h3 class="layers-product-name" id="<?php echo esc_attr( $template_key ); ?>"><?php echo esc_html( $template[ 'title' ] ); ?></h3>
               <div class="layers-product-actions">
                  <a class="layers-button btn-primary customize load-customize" id="layers-generate-preset-layout-<?php echo esc_attr( $template_key ); ?>"  data-key="layers-preset-layout-<?php echo esc_attr( $template_key ); ?>"><?php _e( 'Select' , 'layerswp' ); ?></a>
                  <?php if ( !empty($template['custom']) ) : ?>
                     <a class="menu-icon dashicons dashicons-admin-generic" href="#"></a>
                     <ul class="edit-preset-menu layers-hide" style="background:#fff; z-index:99; display:block; position:absolute;">
                        <?php $edit_url = get_edit_post_link( $post_id ); ?>
                        <li><a class="edit-preset" href="<?php echo esc_url($edit_url); ?>">Edit</a></li>
                        <li><a class="delete-preset" href="#">Delete</a></li>
                     </ul>
                  <?php endif; ?>
               </div>
            </label>
         </div>
      <?php endforeach; // Get Preset Layouts ?>
   </div>
</div>