<?php // Fetch current user information
$user = wp_get_current_user(); ?>

<?php // Instantiate Inputs
$form_elements = new Layers_Form_Elements(); ?>

<?php // Get builder pages
$find_builder_page = layers_get_builder_pages(); ?>

<section class="l_admin-area-wrapper" id="layers-add-new-page">
	<?php $this->header( __( 'Add New Page' , 'layerswp' ) ); ?>
	<div class="l_admin-well l_admin-content">
		<?php $this->load_partial( 'preset-layouts' ); ?>
	</div>
</section>

<section class="l_admin-modal-container l_admin-hide">
	<div class="l_admin-vertical-center l_admin-modal">
		<div class="l_admin-section-title l_admin-no-push-bottom">

			<h2 class="l_admin-heading l_admin-push-bottom" id="layers-options-header">
				<?php _e( 'Add a page title' , 'layerswp' ); ?>
			</h2>

			<p class="l_admin-form-item">
				<?php
					echo $form_elements->input( array(
						'type' => 'text',
						'name' => 'layers_preset_page_title',
						'id' => 'layers_preset_page_title',
						'placeholder' => __( 'Enter title here' , 'layerswp' ),
						'value' => NULL,
						'class' => 'layers-text l_admin-large'
					) );
				?>
			</p>

			<p id="layers-preset-layout-next-button">
				<a id="layers-preset-proceed" href="" class="button button-primary btn-large disable" disabled="disabled" data-post_id="" data-location="">
					<?php _e( 'Proceed to Customizer' , 'layerswp' ); ?>
				</a>
				<a id="layers-preset-cancel" href="" class="button btn-link btn-large pull-right">
					<?php _e( 'Cancel' , 'layerswp' ); ?>
				</a>

				<div class="l_admin-load-bar l_admin-hide">
					<span class="l_admin-progress zero"></span>
				</div>
			</p>

		</div>
	</div>
</section>

<?php $this->footer(); ?>