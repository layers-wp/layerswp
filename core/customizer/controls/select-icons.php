<?php  /**
 * Radio Control
 *
 * This file is used to register and display the custom Layers Radio Checkbox
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

			$name = '_customize-radio-' . $this->id; ?>

			<div id="layers-customize-control-<?php echo esc_attr( $this->id ); ?>" class="l_option-customize-control l_option-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?> <?php echo esc_attr( $this->class ); ?>" <?php echo $this->get_linked_data(); ?> >

				<?php $this->render_history_actions(); ?>

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
					<?php foreach ( $this->choices as $key => $value ) :
						
						if ( is_array( $value ) ) {
							$label = $value['name'];
							$class = $value['class'];
						}
						else {
							$label = $value;
							$class = "icon-{$key}";
						}
						?>
						<li class="layers-visuals-item <?php if( $key == $this->value() ) echo 'layers-active'; ?>">
							<label class="layers-icon-wrapper layers-select-images">
								<span class="<?php echo $class; ?>"></span>
								<span class="layers-icon-description">
									<?php echo $label; ?>
								</span>
								<input class="l_admin-hide" type="radio" value="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $key ); ?> />
							</label>
						</li>
					<?php endforeach; ?>
				</ul>

			</div>
			<?php
		}
	}
}