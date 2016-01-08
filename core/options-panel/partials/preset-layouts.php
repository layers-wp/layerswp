<div class="l_admin-browser">
	<div class="l_admin-products l_admin-row">

		<?php // Instantiate the widget migrator
		$layers_migrator = new Layers_Widget_Migrator(); ?>

		<?php foreach( $layers_migrator->get_preset_layouts() as $template_key => $template ) { ?>
			<div class="l_admin-product l_admin-column l_admin-span-3 active  <?php echo ( isset( $template[ 'container-css' ] ) ?  esc_attr( $template[ 'container-css' ] ) : '' ); ?>" tabindex="0">
				<input name="layes-preset-layout" id="layers-preset-layout-<?php echo $template_key; ?>-radio" class="l_admin-hide" type="radio" value="<?php echo $template_key; ?>" />
				<label for="layers-preset-layout-<?php echo esc_attr( $template_key ); ?>-radio">
					<input id="layers-preset-layout-<?php echo esc_attr( $template_key ); ?>-title" type="hidden" value="<?php echo $template[ 'title' ]; ?>" />
					<input id="layers-preset-layout-<?php echo esc_attr( $template_key ); ?>-widget_data" type="hidden" value="<?php echo esc_attr( $template[ 'json' ] ); ?>" />
					<div class="l_admin-product-screenshot">
						<?php if ( isset( $template[ 'screenshot' ] ) && NULL != $template[ 'screenshot' ] ) {
							echo $layers_migrator->generate_preset_layout_screenshot( $template[ 'screenshot' ], $template[ 'screenshot_type' ] );
						} ?>
					</div>
					<h3 class="l_admin-product-name" id="<?php echo esc_attr( $template_key ); ?>"><?php echo esc_html( $template[ 'title' ] ); ?></h3>
					<div class="l_admin-product-actions">
						<a class="button button-primary customize load-customize" id="layers-generate-preset-layout-<?php echo esc_attr( $template_key ); ?>"  data-key="layers-preset-layout-<?php echo esc_attr( $template_key ); ?>">
							<?php _e( 'Select' , 'layerswp' ); ?>
						</a>
					</div>
				</label>
			</div>
		<?php } // Get Preset Layouts ?>
	</div>
</div>