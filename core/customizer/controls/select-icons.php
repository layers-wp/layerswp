<?php
/**
 * Select Icons Control
 *
 * This file is used to register and display the custom Layers Select Icons.
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Customize_Select_Icon_Control' ) ) {

	class Layers_Customize_Select_Icon_Control extends Layers_Customize_Control {

		public $type = 'layers-select-icons';

		public function render_content() {

			// Exit if there are no choises
			if ( empty( $this->choices ) ) return;
			
			$form_elements = new Layers_Form_Elements();

			$name = '_customize-radio-' . $this->id; ?>

			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="l_option-customize-control l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?> <?php echo esc_attr( $this->class ); ?>" <?php echo $this->get_linked_data(); ?> >
				
				<?php do_action( 'layers-control-inside', $this ); ?>

				<?php if ( '' != $this->heading_divider ) { ?>
					<?php $this->render_heading_divider( $this->heading_divider ); ?>
				<?php } ?>

				<?php if ( '' != $this->label ) { ?>
					<span class="customize-control-title"><?php echo $this->label; ?></span>
				<?php } ?>

				<?php if ( '' != $this->description ) : ?>
					<div class="description customize-control-description">
						<?php echo $this->description; ?>
					</div>
				<?php endif; ?>

				<?php if ( '' != $this->subtitle ) : ?>
					<div class="layers-form-row"><?php echo $this->subtitle; ?></div>
				<?php endif; ?>

				<ul class="layers-visuals-wrapper layers-visuals-inline layers-clearfix">
					<?php foreach ( $this->choices as $key => $choice ) :
						
						// Allow for setting custom Name & Class-Name by passing array.
						if ( is_array( $choice ) ) {
							$label = $choice['name'];
							$class = $choice['class'];
						}
						else {
							$label = $choice;
							$class = "icon-{$key}";
						}
						
						// Get the checked state.
						$checked = FALSE;
						if ( $this->multi_select ) {
							
							// Multi-Select.
							if ( get_theme_mod( "{$this->id}-{$key}" ) === $key ) $checked = TRUE; // Radio (Testing).
							if ( get_theme_mod( "{$this->id}-{$key}" ) === '1' ) $checked = TRUE; // Checkbox
						}
						else {
							
							// Single.
							if ( $this->value() == $key ) $checked = TRUE;
						}
						?>
						<li class="layers-visuals-item <?php if ( $checked ) echo 'layers-active'; ?>">
							<label class="layers-icon-wrapper layers-select-images" for="<?php echo esc_attr( "{$this->id}-{$key}" ); ?>">
								
								<span class="<?php echo $class; ?>"></span>
								
								<span class="layers-icon-description">
									<?php echo $label; ?>
								</span>
								
								<input
									value="<?php echo esc_attr( $key ); ?>"
									id="<?php echo esc_attr( "{$this->id}-{$key}" ); ?>"
									<?php if ( $this->multi_select ) { ?>
										type="checkbox"
										name="<?php echo esc_attr( "{$this->id}-{$key}" ); ?>"
										data-customize-setting-link="<?php echo esc_attr( "{$this->id}-{$key}" ); ?>"
									<?php } else { ?>
										type="radio"
										name="<?php echo esc_attr( "{$this->id}" ); ?>"
										<?php $this->link(); ?>
									<?php } ?>
									<?php checked( $checked, true, true ); ?>
									class="l_admin-hide"
								/>
									
							</label>
						</li>
					<?php endforeach; ?>
				</ul>
				
				<?php echo $form_elements->input(
					array(
						'type' => 'hidden',
						'label' => '',
						'name' => '' ,
						'id' =>  $this->id,
						'data' => $this->get_customize_data(),
					)
				); ?>

			</div>
			<?php
		}
	}
}