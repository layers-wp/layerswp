<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Instantiate Inputs
$form_elements = new Layers_Form_Elements(); ?>

<?php // Instantiate the widget migrator
$layers_migrator = new Layers_Widget_Migrator(); ?>

<?php // Get builder pages
$find_builder_page = layers_get_builder_pages(); ?>

<section class="layers-area-wrapper">

   <div class="layers-page-title layers-section-title layers-large layers-content-massive layers-no-push-bottom">
      <div class="layers-container">
         <h2 class="layers-heading" id="layers-options-header">
            <?php _e( 'Select a Layout', LAYERS_THEME_SLUG ); ?>
         </h2>
         <p class="layers-excerpt">
            <?php _e( 'Get started with a blank canvas or choose from a variety of preset layouts to help you fast track your website creation.', LAYERS_THEME_SLUG ); ?>
         </p>
      </div>
   </div>

   <div class="layers-row layers-well layers-content-massive">
      <div class="layers-browser">
         <div class="layers-products">
            <div class="layers-product blank-product" id="layers-generate-preset-layout-blank" data-key="layers-preset-layout-blank">
               <input id="layers-preset-layout-blank-title" type="hidden" value="<?php _e( 'Blank' , LAYERS_THEME_SLUG ); ?>" />
               <input id="layers-preset-layout-blank-widget_data" type="hidden" value="<?php json_encode( array() ); ?>" />
               <div class="layers-product-screenshot">
                  <span></span>
               </div>
               <h3 class="layers-product-name"><?php _e( 'Blank Canvas' , LAYERS_THEME_SLUG ); ?></h3>
            </div>
            <?php foreach( $layers_migrator->get_preset_layouts() as $template_key => $template ) { ?>
               <div class="layers-product active  <?php echo ( isset( $template[ 'container_css' ] ) ?  $template[ 'container_css' ] : '' ); ?>" tabindex="0">

                  <input id="layers-preset-layout-<?php echo $template_key; ?>-title" type="hidden" value="<?php echo $template[ 'title' ]; ?>" />
                  <input id="layers-preset-layout-<?php echo $template_key; ?>-widget_data" type="hidden" value="<?php echo esc_attr( $template[ 'json' ] ); ?>" />


                  <div class="layers-product-screenshot">
                     <?php echo $layers_migrator->generate_preset_layout_screenshot( $template[ 'screenshot' ], $template[ 'screenshot_type' ] ); ?>
                  </div>
                  <h3 class="layers-product-name" id="<?php echo $template_key; ?>"><?php echo $template[ 'title' ]; ?></h3>
                  <div class="layers-product-actions">
                     <a class="layers-button btn-primary customize load-customize" id="layers-generate-preset-layout-<?php echo $template_key; ?>"  data-key="layers-preset-layout-<?php echo $template_key; ?>"><?php _e( 'Select', LAYERS_THEME_SLUG ); ?></a>
                  </div>
               </div>
            <?php } // Get Preset Layouts ?>
         </div>
      </div>
   </div>

</section>

<section class="layers-modal-container layers-hide">
   <div class="layers-vertical-center layers-modal">
      <div class="layers-section-title layers-no-push-bottom">

         <h2 class="layers-heading layers-push-bottom" id="layers-options-header">
            <?php _e( 'Add a page title', LAYERS_THEME_SLUG ); ?>
         </h2>

         <p class="layers-form-item layers-span-12">
            <?php
               echo $form_elements->input( array(
                  'type' => 'text',
                  'name' => 'layers_preset_page_title',
                  'id' => 'layers_preset_page_title',
                  'placeholder' => __( 'Enter title here', LAYERS_THEME_SLUG ),
                  'value' => NULL,
                  'class' => 'layers-text layers-large'
               ) );
            ?>
         </p>

         <p id="layers-preset-layout-next-button">
            <a id="layers-preset-proceed" href="" class="layers-button btn-primary btn-large" data-post_id="" data-location="">
               <?php _e( 'Proceed to Customizer' , LAYERS_THEME_SLUG ); ?>
            </a>
            <a id="layers-preset-cancel" href="" class="layers-button btn-link">
               <?php _e( 'Cancel' , LAYERS_THEME_SLUG ); ?>
            </a>

            <div class="layers-load-bar layers-hide">
               <span class="layers-progress zero"></span>
            </div>


         </p>

      </div>
   </div>
</section>

<?php $this->footer(); ?>