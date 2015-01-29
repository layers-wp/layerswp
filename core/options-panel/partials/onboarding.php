<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Instantiate Inputs
$form_elements = new Layers_Form_Elements(); ?>

<?php // Instantiate the widget migrator
$layers_migrator = new Layers_Widget_Migrator(); ?>

<section class="layers-welcome">

   <div class="layers-page-title layers-section-title layers-large layers-content-massive layers-no-push-bottom">
      <div class="layers-container">
         <h2 class="layers-heading" id="layers-options-header">
            <?php _e( 'Let\'s Get Started', LAYERS_THEME_SLUG ); ?>
         </h2>
         <p class="layers-excerpt">
            <?php _e( 'Intro copy', LAYERS_THEME_SLUG ); ?>
         </p>
      </div>
   </div>

</section>

<?php $this->footer(); ?>