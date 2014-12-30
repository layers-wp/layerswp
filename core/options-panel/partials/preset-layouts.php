<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Instantiate the widget migrator
$hatch_migrator = new Hatch_Widget_Migrator(); ?>

<?php // Get builder pages
$find_builder_page = hatch_get_builder_pages(); ?>

<section class="hatch-welcome">

   <div class="hatch-page-title hatch-section-title hatch-large hatch-content-massive invert hatch-no-push-bottom">
      <div class="hatch-container">
         <h2 class="hatch-heading" id="hatch-options-header"><?php _e( 'Select a Layout', HATCH_THEME_SLUG ); ?></h2>
         <p class="hatch-excerpt">
            <?php _e( 'Hatch is a site builder with a lightweight design interface built into the WordPress Visual Customizer.', HATCH_THEME_SLUG ); ?>
         </p>
      </div>
   </div>

   <div class="hatch-row hatch-well hatch-content-massive">
      <div class="theme-browser rendered">
         <div class="themes">
            <?php foreach( $hatch_migrator->get_preset_layouts() as $template_key => $template ) { ?>
               <input id="hatch-preset-layout-<?php echo $template_key; ?>-title" type="hidden" value="<?php echo $template[ 'title' ]; ?>" />
               <input id="hatch-preset-layout-<?php echo $template_key; ?>-widget_data" type="hidden" value="<?php echo esc_attr( $template[ 'json' ] ); ?>" />

               <div class="theme active  <?php echo ( isset( $template[ 'container_css' ] ) ?  $template[ 'container_css' ] : '' ); ?>" tabindex="0">
                  <div class="theme-screenshot">
                     <?php echo $hatch_migrator->generate_preset_layout_screenshot( $template[ 'screenshot' ], $template[ 'screenshot_type' ] ); ?>
                  </div>
                  <h3 class="theme-name" id="<?php echo $template_key; ?>"><?php echo $template[ 'title' ]; ?></h3>
                  <div class="theme-actions">
                     <a class="button button-primary customize load-customize" id="hatch-generate-preset-layout-<?php echo $template_key; ?>"  data-key="hatch-preset-layout-<?php echo $template_key; ?>"><?php _e( 'Import', HATCH_THEME_SLUG ); ?></a>
                  </div>
               </div>
            <?php } // Get Preset Layouts ?>
            <div class="theme add-new-theme">
               <input id="hatch-preset-layout-blank-title" type="hidden" value="<?php _e( 'Blank' , HATCH_THEME_SLUG ); ?>" />
               <input id="hatch-preset-layout-blank-widget_data" type="hidden" value="{}" />
               <div class="theme-screenshot"><span id="hatch-generate-preset-layout-blank" data-key="hatch-preset-layout-blank"></span></div>
               <h3 class="theme-name"><?php _e( 'Blank Canvas' , HATCH_THEME_SLUG ); ?></h3>
         </div>
         <br class="clear">
      </div>
   </div>
</section>

<section class="hatch-modal hatch-hide">
   <div class="hatch-vertical-center">
      <div class="hatch-section-title hatch-text-center hatch-container">

         <h2 class="hatch-heading" id="hatch-options-header">
            <?php _e( 'Creating Your Page', HATCH_THEME_SLUG ); ?>
         </h2>
         <p class="hatch-excerpt hatch-push-bottom">
            <?php _e( 'We\'re busy importing dummy content, placing some widgets and adding some content, promise it won\'t take long. Once we\'re done, you\'ll be redirected to
            the Visual Customizer so that you can start building your page.' , HATCH_THEME_SLUG ); ?>
         </p>
         <div class="hatch-load-bar">
            <span class="hatch-progress zero">0%</span>
         </div>

      </div>
   </div>
</section>

<?php $this->footer(); ?>