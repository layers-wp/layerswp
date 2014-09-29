<?php /**
 * Widget Design Controller Class
 *
 * This file is the source of the Widget Design Pop out  in Hatch.
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Design_Controller {

	/**
	* Generate Design Options
	*
	* @param  	array     	$options() 	Widget $instance
	* @param  	array     	$options() 	Element Support
	* @param  	array     	$options() 	Array of custom elements which are not common
	*/

	function bar( $type = 'side' , $widget = NULL, $instance = array(), $components = array( 'columns' , 'background' , 'imagealign' ) , $custom_components = array() ) {

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) { return; } else { $widget = (object) $widget; }

		// Set widget values as an object ( we like working with objects)
		if( empty( $instance ) ) {
			$values = (object) array( 'design' => NULL );
		} elseif( isset( $instance[ 'design' ] ) ) {
			$values = (object) $instance[ 'design' ];
		} else {
			$values = NULL;
		} ?>

		<div class="hatch-visuals <?php if( 'side' == $type ) { echo 'hatch-pull-right'; } else { echo 'hatch-visuals-horizontal'; } ?> ">
			<?php if( 'side' == $type ) { ?>
			<?php } // if side == type ?>
			<h6 class="hatch-visuals-title">
				<span class="icon-settings hatch-small"></span>
			</h6>
			<ul class="hatch-visuals-wrapper hatch-clearfix">
				<?php if( NULL !== $components ) {
					foreach( $components as $component ) {
						if( 'custom' == $component && !empty( $custom_components ) ) {
							foreach ( $custom_components as $key => $component_args ) {
								$this->custom_component(
									$widget, // Send through the widget name & id
									$values, // Send through the widsget values
									$key, // Give the component a key (will be used as class name too)
									$component_args // Send through the inputs that will be used
								);
							}
						} elseif ( 'custom' != $component ) {
							$this->$component(
								$widget, // Send through the widget name & id
								$values // Send through the widget values
							);
						}
					}
				} // if $components is not NULL ?>
				<?php if( isset( $widget->show_trash ) ) { ?>
					<li class="hatch-visuals-item hatch-pull-right">
						<a href="" class="hatch-icon-wrapper hatch-icon-error">
							<span class="icon-trash" data-number="<?php echo $widget->number; ?>"></span>
						</a>
					</li>
				<?php } // if side != $type ?>
			</ul>
		</div>
	<?php }

	/**
	* Load input HTML
	*
	* @param  	array     	$array() 	Existing option array if exists (optional)
	* @return 	array 		$array 		Array of options, all standard DOM input options
	*/

	public function input( $args = array() ) {

		// Initiate Widget Inputs
		$form_elements = new Hatch_Form_Elements();

		// Return form element
		return $form_elements->input( $args );
	}

	/**
	* Custom Compontent
	*
	* @param  	array     	$widget 	Widget Element
	* @param  	array     	$values 	Accepts the value for this element,
	* @param  	varchar     	$key 		Simply the key and classname for the icon,
	* @param  	array     	$args 		Component arguments, including the form items
	*/

	function custom_component( $widget = NULL, $values = NULL, $key = NULL, $args = array() ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="hatch-visuals-item">
			<a href="" class="hatch-icon-wrapper">
				<span class="<?php echo $args[ 'icon-css' ]; ?>"></span>
				<span class="hatch-icon-description">
					<?php echo $args[ 'label' ]; ?>
				</span>
			</a>
			<?php if( isset( $args['elements'] ) ) { ?>
			<div class="hatch-visuals-settings-wrapper hatch-content-small">
				<div class="hatch-visuals-settings">
					<?php foreach( $args['elements'] as $key => $form_args ) { ?>
						<div class="hatch-<?php echo $form_args[ 'type' ]; ?>-wrapper hatch-form-item">
							<?php if( 'checkbox' != $form_args[ 'type' ] ) { ?>
								<label><?php echo $form_args[ 'label' ]; ?></label>
							<?php } ?>
							<?php echo $this->input( $form_args ); ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php } // if we have elements ?>
		</li>
	<?php }

	/**
	* Layout Options
	*
	* @param  	array     	$widget 	Widget Element
	* @param  	array     	$values 	Accepts the value for this element
	*/

	function layout( $widget = NULL, $values = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="hatch-visuals-item ">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-layout-fullwidth"></span>
				<span class="hatch-icon-description">
					<?php _e( 'Layout' , HATCH_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-small">
				<div class="hatch-visuals-settings">
					<?php echo $this->input(
						array(
							'type' => 'select-icons',
							'name' => $widget->name . '[layout]' ,
							'id' =>  $widget->id . '-layout' ,
							'value' => ( isset( $values->layout ) ) ? $values->layout : NULL,
							'options' => array(
								'layout-boxed' => __( 'Boxed' , HATCH_THEME_SLUG ),
								'layout-fullwidth' => __( 'Full Width' , HATCH_THEME_SLUG )
							)
						)
					); ?>
				</div>
			</div>
		</li>
	<?php }

	/**
	* List Style - Static Option
	*
	* @param  	array     	$widget 	Widget Element
	* @param  	array     	$values 	Accepts the value for this element
	*/

	function liststyle( $widget = NULL, $values = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="hatch-visuals-item">

			<a href="" class="hatch-icon-wrapper">
				<span class="icon-list-masonry"></span>
				<span class="hatch-icon-description">
					<?php _e( 'List Style' , HATCH_THEME_SLUG ); ?>
				</span>
			</a>

			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-small">
				<div class="hatch-visuals-settings">
					<?php echo $this->input(
						array(
							'type' => 'select-icons',
							'name' => $widget->name . '[liststyle]' ,
							'id' =>  $widget->id . '-liststyle' ,
							'value' => ( isset( $values->liststyle ) ) ? $values->liststyle : NULL,
							'options' => array(
								'list-grid' => __( 'Grid' , HATCH_THEME_SLUG ),
								'list-list' => __( 'List' , HATCH_THEME_SLUG ),
								'list-masonry' => __( 'Masonry' , HATCH_THEME_SLUG )
							)
						)
					); ?>
				</div>
			</div>
		</li>
	<?php }

	/**
	* Columns - Static Option
	*
	* @param  	array     	$widget 	Widget Element
	* @param  	array     	$values 	Accepts the value for this element
	*/

	function columns( $widget = NULL, $values = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="hatch-visuals-item">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-columns"></span>
				<span class="hatch-icon-description">
					<?php _e( 'Columns' , HATCH_THEME_SLUG ); ?>
				</span>
			</a>

			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-content-small">
				<div class="hatch-visuals-settings">
					<div class="hatch-form-item">
						<label for="<?php echo  $widget->name . '-columns'; ?>"><?php _e( 'Columns' , HATCH_THEME_SLUG ); ?></label>
						<?php echo $this->input(
							array(
								'type' => 'select',
								'name' => $widget->name . '[columns]' ,
								'id' =>  $widget->id . '-columns' ,
								'value' => ( isset( $values->columns ) ) ? $values->columns : NULL,
								'options' => array(
									'1' => __( '1 Column' , HATCH_THEME_SLUG ),
									'2' => __( '2 Columns' , HATCH_THEME_SLUG ),
									'3' => __( '3 Columns' , HATCH_THEME_SLUG ),
									'4' => __( '4 Columns' , HATCH_THEME_SLUG ),
									'6' => __( '6 Columns' , HATCH_THEME_SLUG )
								)
							)
						); ?>
					</div>
					<div class="hatch-checkbox-wrapper hatch-form-item">
						<?php echo $this->input(
							array(
								'type' => 'checkbox',
								'label' => __( 'Remove Spacing' , HATCH_THEME_SLUG ),
								'name' => $widget->name . '[columnflush]' ,
								'id' =>  $widget->id . '-column-flush' ,
								'value' => ( isset( $values->columnflush ) ) ? $values->columnflush : NULL
							)
						); ?>
					</div>
				</div>
			</div>
		</li>
	<?php }

	/**
	* Text Align - Static Option
	*
	* @param  	array     	$widget 	Widget Element
	* @param  	array     	$values 	Accepts the value for this element
	*/

	function textalign( $widget = NULL, $values = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="hatch-visuals-item">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-text-center"></span>
				<span class="hatch-icon-description">
					<?php _e( 'Text Align' , HATCH_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-small">
				<div class="hatch-visuals-settings">
					<?php echo $this->input(
						array(
							'type' => 'select-icons',
							'name' => $widget->name . '[textalign]' ,
							'id' =>  $widget->id . '-textalign' ,
							'value' => ( isset( $values->textalign ) ) ? $values->textalign : NULL,
							'options' => array(
								'text-left' => __( 'Left' , HATCH_THEME_SLUG ),
								'text-right' => __( 'Right' , HATCH_THEME_SLUG ),
								'text-center' => __( 'Center' , HATCH_THEME_SLUG ),
								'text-justify' => __( 'Justify' , HATCH_THEME_SLUG )
							)
						)
					); ?>
				</div>
			</div>
		</li>
	<?php  }

	/**
	* Image Align - Static Option
	*
	* @param  	array     	$widget 	Widget Element
	* @param  	array     	$values 	Accepts the value for this element
	*/

	function imagealign( $widget = NULL, $values = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="hatch-visuals-item hatch-last">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-image-left"></span>
				<span class="hatch-icon-description">
					<?php _e( 'Image Align' , HATCH_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-small">
				<div class="hatch-visual-settings">
					<?php echo $this->input(
						array(
							'type' => 'select-icons',
							'name' => $widget->name . '[imagealign]' ,
							'id' =>  $widget->id . '-imagealign' ,
							'value' => ( isset( $values->imagealign ) ) ? $values->imagealign : NULL,
							'options' => array(
								'image-left' => __( 'Left' , HATCH_THEME_SLUG ),
								'image-right' => __( 'Right' , HATCH_THEME_SLUG ),
								'image-top' => __( 'Top' , HATCH_THEME_SLUG )
							)
						)
					); ?>
				</div>
			</div>
		</li>
	<?php }

	/**
	* Image Size - Static Option
	*
	* @param  	array     	$widget 	Widget Element
	* @param  	array     	$values 	Accepts the value for this element
	*/

	function imageratios( $widget = NULL, $values = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="hatch-visuals-item">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-image-size"></span>
				<span class="hatch-icon-description">
					<?php _e( 'Image Ratio' , HATCH_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-content-small">
				<div class="hatch-visual-settings">
					<div class="hatch-select-wrapper hatch-form-item">
						<label><?php _e( 'Image Ratio' , HATCH_THEME_SLUG ); ?></label>
						<?php echo $this->input(
							array(
								'type' => 'select',
								'name' => $widget->name . '[imageratios]' ,
								'id' =>  $widget->id . '-imageratios' ,
								'value' => ( isset( $values->imageratios ) ) ? $values->imageratios : NULL,
								'options' => array(
									'' => __( 'No Cropping' , HATCH_THEME_SLUG ),
									'portrait' => __( 'Portrait' , HATCH_THEME_SLUG ),
									'landscape' => __( 'Landscape' , HATCH_THEME_SLUG ),
									'square' => __( 'Square' , HATCH_THEME_SLUG )
								)
							)
						); ?>
					</div>
				</div>
			</div>
		</li>
	<?php }

	/**
	* Fonts - Static Option
	*
	* @param  	array     	$widget 	Widget Element
	* @param  	array     	$values 	Accepts the value for this element
	*/

	function fonts( $widget = NULL, $values = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="hatch-visuals-item">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-font-size"></span>
				<span class="hatch-icon-description">
					<?php _e( 'Text' , HATCH_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-content-small">
				<div class="hatch-visuals-settings">
					<section>
						<div class="hatch-form-item">
							<label><?php _e( 'Text Align' , HATCH_THEME_SLUG ); ?></label>
							<div class="hatch-icon-group">
								<?php echo $this->input(
									array(
										'type' => 'select-icons',
										'name' => $widget->name . '[fonts][align]' ,
										'id' =>  $widget->id . '-fonts-align' ,
										'value' => ( isset( $values->fonts['align'] ) ) ? $values->fonts['align'] : NULL,
										'options' => array(
											'text-left' => __( 'Left' , HATCH_THEME_SLUG ),
											'text-right' => __( 'Right' , HATCH_THEME_SLUG ),
											'text-center' => __( 'Center' , HATCH_THEME_SLUG ),
											'text-justify' => __( 'Justify' , HATCH_THEME_SLUG )
										)
									)
								); ?>
							</div>
						</div>
						<div class="hatch-form-item">
							<label><?php _e( 'Text Size' , HATCH_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'select',
									'name' => $widget->name . '[fonts][size]' ,
									'id' =>  $widget->id . '-fonts-size' ,
									'value' => ( isset( $values->fonts['size'] ) ) ? $values->fonts['size'] : NULL,
									'options' => array(
											'small' => __( 'Small' , HATCH_THEME_SLUG ),
											'' => __( 'Medium' , HATCH_THEME_SLUG ),
											'large' => __( 'Large' , HATCH_THEME_SLUG )
									)
								)
							); ?>
						</div>
						<div class="hatch-form-item">
							<label><?php _e( 'Text Color' , HATCH_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'color',
									'name' => $widget->name . '[fonts][color]' ,
									'id' =>  $widget->id . '-fonts-color' ,
									'value' => ( isset( $values->fonts['color'] ) ) ? $values->fonts['color'] : NULL
								)
							); ?>
						</div>
						<div class="hatch-form-item">
							<label><?php _e( 'Text Shadow' , HATCH_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'color',
									'name' => $widget->name . '[fonts][shadow]' ,
									'id' =>  $widget->id . '-fonts-shadow' ,
									'value' => ( isset( $values->fonts['shadow'] ) ) ? $values->fonts['shadow'] : NULL
								)
							); ?>
						</div>
					</section>
				</div>
			</div>
		</li>


	<?php }

	/**
	* Background - Static Option
	*
	* @param  	array     	$widget 	Widget Element
	* @param  	array     	$values 	Accepts the value for this element
	*/

	function background( $widget = NULL, $values = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="hatch-visuals-item">
			<a href="" class="hatch-icon-wrapper">
				<span class="icon-photo"></span>
				<span class="hatch-icon-description">
					<?php _e( 'Background' , HATCH_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="hatch-visuals-settings-wrapper hatch-animate hatch-content-small">
				<div class="hatch-visuals-settings">
					<div class="background-image">
						<?php echo $this->input(
							array(
								'type' => 'image',
								'label' => __( 'Choose Image' , HATCH_THEME_SLUG ),
								'name' => $widget->name . '[background][image]' ,
								'id' =>  $widget->id . '-background-image' ,
								'value' => ( isset( $values->background['image'] ) ) ? $values->background['image'] : NULL
							)
						); ?>
					</div>
					<section>
						<div class="hatch-form-item">
							<label><?php _e( 'Color' , HATCH_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'color',
									'label' => __( 'Background Color' , HATCH_THEME_SLUG ),
									'name' => $widget->name . '[background][color]' ,
									'id' =>  $widget->id . '-background-color' ,
									'value' => ( isset( $values->background['color'] ) ) ? $values->background['color'] : NULL
								)
							); ?>
						</div>
						<div class="hatch-select-wrapper hatch-form-item">
							<label><?php _e( 'Repeat' , HATCH_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'select',
									'name' => $widget->name . '[background][repeat]' ,
									'id' =>  $widget->id . '-background-repeat' ,
									'value' => ( isset( $values->background['repeat'] ) ) ? $values->background['repeat'] : NULL,
									'options' => array(
											'no-repeat' => __( 'No Repeat' , HATCH_THEME_SLUG ),
											'repeat' => __( 'Repeat' , HATCH_THEME_SLUG ),
											'repeat-x' => __( 'Repeat Horizontal' , HATCH_THEME_SLUG ),
											'repeat-y' => __( 'Repeat Vertical' , HATCH_THEME_SLUG )
										)
								)
							); ?>
						</div>
						<div class="hatch-select-wrapper hatch-form-item">
							<label><?php _e( 'Position' , HATCH_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'select',
									'name' => $widget->name . '[background][position]' ,
									'id' =>  $widget->id . '-background-position' ,
									'value' => ( isset( $values->background['position'] ) ) ? $values->background['position'] : NULL,
									'options' => array(
											'center' => __( 'Center' , HATCH_THEME_SLUG ),
											'top' => __( 'Top' , HATCH_THEME_SLUG ),
											'bottom' => __( 'Bottom' , HATCH_THEME_SLUG ),
											'left' => __( 'Left' , HATCH_THEME_SLUG ),
											'right' => __( 'Right' , HATCH_THEME_SLUG )
										)
								)
							); ?>
						</div>
						<div class="hatch-checkbox-wrapper hatch-form-item">
							<?php echo $this->input(
								array(
									'type' => 'checkbox',
									'label' => __( 'Fixed' , HATCH_THEME_SLUG ),
									'name' => $widget->name . '[background][fixed]' ,
									'id' =>  $widget->id . '-background-fixed' ,
									'value' => ( isset( $values->background['fixed'] ) ) ? $values->background['fixed'] : NULL
								)
							); ?>
						</div>
						<div class="hatch-checkbox-wrapper hatch-form-item">
							<?php echo $this->input(
								array(
									'type' => 'checkbox',
									'label' => __( 'Stretch' , HATCH_THEME_SLUG ),
									'name' => $widget->name . '[background][stretch]' ,
									'id' =>  $widget->id . '-background-stretch' ,
									'value' => ( isset( $values->background['stretch'] ) ) ? $values->background['stretch'] : NULL
								)
							); ?>
						</div>
						<div class="hatch-checkbox-wrapper hatch-form-item">
							<?php echo $this->input(
								array(
									'type' => 'checkbox',
									'label' => __( 'Darken' , HATCH_THEME_SLUG ),
									'name' => $widget->name . '[background][darken]' ,
									'id' =>  $widget->id . '-background-darken' ,
									'value' => ( isset( $values->background['darken'] ) ) ? $values->background['darken'] : NULL
								)
							); ?>
						</div>
					</section>
				</div>
			</div>
		</li>
	<?php }

} //class Hatch_Design_Controller