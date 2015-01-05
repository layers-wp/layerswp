<?php /**
 * Widget Design Controller Class
 *
 * This file is the source of the Widget Design Pop out  in Layers.
 *
 * @package Layers
 * @since Layers 1.0
 */

class Layers_Design_Controller {

	/**
	* Generate Design Options
	*
	* @param  	varchar     $type 		Sidebar type, side/top
	* @param  	array     	$widget 	Widget object (for name, id, etc)
	* @param  	array     	$instance 	Widget $instance
	* @param  	array     	$components Array of standard components to support
	* @param  	array     	$custom_components Array of custom components and elements
	*/

	function bar( $type = 'side' , $widget = NULL, $instance = array(), $components = array( 'columns' , 'background' , 'imagealign' ) , $custom_components = array() ) {

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) { return; } else { $widget = $widget; }

		// Set widget values as an object ( we like working with objects)
		if( empty( $instance ) ) {
			$values = array( 'design' => NULL );
		} elseif( isset( $instance[ 'design' ] ) ) {
			$values = $instance[ 'design' ];
		} else {
			$values = NULL;
		} ?>

		<div class="layers-visuals <?php if( 'side' == $type ) { echo 'layers-pull-right'; } else { echo 'layers-visuals-horizontal'; } ?> ">
			<?php if( 'side' == $type ) { ?>
			<?php } // if side == type ?>
			<h6 class="layers-visuals-title">
				<span class="icon-settings layers-small"></span>
			</h6>
			<ul class="layers-visuals-wrapper layers-clearfix">
				<?php if( NULL !== $components ) {
					foreach( $components as $component ) {
						if( 'custom' == $component && !empty( $custom_components ) ) {
							foreach ( $custom_components as $key => $custom_component_args ) {
								$this->custom_component(
									$widget, // Send through the widget name & id
									$values, // Send through the widget values
									$key, // Give the component a key (will be used as class name too)
									$custom_component_args // Send through the inputs that will be used
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
				<?php if( isset( $widget['show_trash'] ) ) { ?>
					<li class="layers-visuals-item layers-pull-right">
						<a href="" class="layers-icon-wrapper layers-icon-error">
							<span class="icon-trash" data-number="<?php echo $widget['number']; ?>"></span>
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
		$form_elements = new Layers_Form_Elements();

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

		if( empty( $args ) ) return;

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="layers-visuals-item">
			<a href="" class="layers-icon-wrapper">
				<span class="<?php echo $args[ 'icon-css' ]; ?>"></span>
				<span class="layers-icon-description">
					<?php echo $args[ 'label' ]; ?>
				</span>
			</a>
			<?php if( isset( $args['elements'] ) ) { ?>
				<?php if( isset( $args[ 'wrapper-css' ] ) ) {
					$wrapper_class = $args[ 'wrapper-css' ];
				} else {
					$wrapper_class = 'layers-pop-menu-wrapper layers-content-small';
				} ?>
				<div class="<?php echo $wrapper_class; ?>">
					<div class="layers-pop-menu-setting">
						<?php foreach( $args['elements'] as $key => $form_args ) { ?>
							<div class="layers-<?php echo $form_args[ 'type' ]; ?>-wrapper layers-form-item">
								<?php if( 'checkbox' != $form_args[ 'type' ] && isset( $form_args[ 'label' ] ) ) { ?>
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
	* @param  	array     	$args 		Additional arguments to pass to this function
	*/

	function layout( $widget = NULL, $values = NULL, $args = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="layers-visuals-item">
			<a href="" class="layers-icon-wrapper">
				<span class="icon-layout-fullwidth"></span>
				<span class="layers-icon-description">
					<?php _e( 'Layout' , LAYERS_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="layers-pop-menu-wrapper layers-animate layers-small">
				<div class="layers-pop-menu-setting">
					<?php echo $this->input(
						array(
							'type' => 'select-icons',
							'name' => $widget['name'] . '[layout]' ,
							'id' =>  $widget['id'] . '-layout' ,
							'value' => ( isset( $values['layout'] ) ) ? $values['layout'] : NULL,
							'options' => array(
								'layout-boxed' => __( 'Boxed' , LAYERS_THEME_SLUG ),
								'layout-fullwidth' => __( 'Full Width' , LAYERS_THEME_SLUG )
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
	* @param  	array     	$args 		Additional arguments to pass to this function
	*/

	function liststyle( $widget = NULL, $values = NULL, $args = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="layers-visuals-item">

			<a href="" class="layers-icon-wrapper">
				<span class="icon-list-masonry"></span>
				<span class="layers-icon-description">
					<?php _e( 'List Style' , LAYERS_THEME_SLUG ); ?>
				</span>
			</a>

			<div class="layers-pop-menu-wrapper layers-animate layers-small">
				<div class="layers-pop-menu-setting">
					<?php echo $this->input(
						array(
							'type' => 'select-icons',
							'name' => $widget['name'] . '[liststyle]' ,
							'id' =>  $widget['id'] . '-liststyle' ,
							'value' => ( isset( $values[ 'liststyle' ] ) ) ? $values[ 'liststyle' ] : NULL,
							'options' => array(
								'list-grid' => __( 'Grid' , LAYERS_THEME_SLUG ),
								'list-list' => __( 'List' , LAYERS_THEME_SLUG ),
								'list-masonry' => __( 'Masonry' , LAYERS_THEME_SLUG )
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
	* @param  	array     	$args 		Additional arguments to pass to this function
	*/

	function columns( $widget = NULL, $values = NULL, $args = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="layers-visuals-item">
			<a href="" class="layers-icon-wrapper">
				<span class="icon-columns"></span>
				<span class="layers-icon-description">
					<?php _e( 'Columns' , LAYERS_THEME_SLUG ); ?>
				</span>
			</a>

			<div class="layers-pop-menu-wrapper layers-animate layers-content-small">
				<div class="layers-pop-menu-setting">
					<div class="layers-form-item">
						<label for="<?php echo  $widget['name'] . '-columns'; ?>"><?php _e( 'Columns' , LAYERS_THEME_SLUG ); ?></label>
						<?php echo $this->input(
							array(
								'type' => 'select',
								'name' => $widget['name'] . '[columns]' ,
								'id' =>  $widget['id'] . '-columns' ,
								'value' => ( isset( $values['columns'] ) ) ? $values['columns'] : NULL,
								'options' => array(
									'1' => __( '1 Column' , LAYERS_THEME_SLUG ),
									'2' => __( '2 Columns' , LAYERS_THEME_SLUG ),
									'3' => __( '3 Columns' , LAYERS_THEME_SLUG ),
									'4' => __( '4 Columns' , LAYERS_THEME_SLUG ),
									'6' => __( '6 Columns' , LAYERS_THEME_SLUG )
								)
							)
						); ?>
					</div>
					<div class="layers-checkbox-wrapper layers-form-item">
						<?php echo $this->input(
							array(
								'type' => 'checkbox',
								'label' => __( 'Gutter' , LAYERS_THEME_SLUG ),
								'name' => $widget['name'] . '[gutter]' ,
								'id' =>  $widget['id'] . '-gutter' ,
								'value' => ( isset( $values['gutter'] ) ) ? $values['gutter'] : NULL
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
	* @param  	array     	$args 		Additional arguments to pass to this function
	*/

	function textalign( $widget = NULL, $values = NULL, $args = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="layers-visuals-item">
			<a href="" class="layers-icon-wrapper">
				<span class="icon-text-center"></span>
				<span class="layers-icon-description">
					<?php _e( 'Text Align' , LAYERS_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="layers-pop-menu-wrapper layers-animate layers-small">
				<div class="layers-pop-menu-setting">
					<?php echo $this->input(
						array(
							'type' => 'select-icons',
							'name' => $widget['name'] . '[textalign]' ,
							'id' =>  $widget['id'] . '-textalign' ,
							'value' => ( isset( $values['textalign'] ) ) ? $values['textalign'] : NULL,
							'options' => array(
								'text-left' => __( 'Left' , LAYERS_THEME_SLUG ),
								'text-center' => __( 'Center' , LAYERS_THEME_SLUG ),
								'text-right' => __( 'Right' , LAYERS_THEME_SLUG ),
								'text-justify' => __( 'Justify' , LAYERS_THEME_SLUG )
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
	* @param  	array     	$args 		Additional arguments to pass to this function
	*/

	function imagealign( $widget = NULL, $values = NULL, $args = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="layers-visuals-item layers-last">
			<a href="" class="layers-icon-wrapper">
				<span class="icon-image-left"></span>
				<span class="layers-icon-description">
					<?php _e( 'Image Align' , LAYERS_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="layers-pop-menu-wrapper layers-animate layers-small">
				<div class="layers-pop-menu-setting">
					<?php echo $this->input(
						array(
							'type' => 'select-icons',
							'name' => $widget['name'] . '[imagealign]' ,
							'id' =>  $widget['id'] . '-imagealign' ,
							'value' => ( isset( $values['imagealign'] ) ) ? $values['imagealign'] : NULL,
							'options' => array(
								'image-left' => __( 'Left' , LAYERS_THEME_SLUG ),
								'image-right' => __( 'Right' , LAYERS_THEME_SLUG ),
								'image-top' => __( 'Top' , LAYERS_THEME_SLUG )
							)
						)
					); ?>
				</div>
			</div>
		</li>
	<?php }

	/**
	* Featured Image - Static Option
	*
	* @param  	array     	$widget 	Widget Element
	* @param  	array     	$values 	Accepts the value for this element
	*/

	function featuredimage( $widget = NULL, $values = NULL, $args = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="layers-visuals-item">
			<a href="" class="layers-icon-wrapper">
				<span class="icon-featured-image"></span>
				<span class="layers-icon-description">
					<?php _e( 'Featured Image' , LAYERS_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="layers-pop-menu-wrapper layers-animate layers-content-small">
				<div class="layers-pop-menu-setting">
					<section>
						<div class="layers-form-item">
							<label><?php _e( 'Featured Image' , LAYERS_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'image',
									'name' => $widget['name'] . '[featuredimage]' ,
									'id' =>  $widget['id'] . '-featuredimage' ,
									'value' => ( isset( $values['featuredimage'] ) ) ? $values['featuredimage'] : NULL
								)
							); ?>
						</div>
						<div class="layers-form-item">
							<label><?php _e( 'Image Ratio' , LAYERS_THEME_SLUG ); ?></label>
							<div class="layers-icon-group">
								<?php echo $this->input(
									array(
										'type' => 'select-icons',
										'name' => $widget['name'] . '[imageratios]' ,
										'id' =>  $widget['id'] . '-imageratios' ,
										'value' => ( isset( $values['imageratios'] ) ) ? $values['imageratios'] : NULL,
										'options' => array(
											'image-portrait' => __( 'Portrait' , LAYERS_THEME_SLUG ),
											'image-landscape' => __( 'Landscape' , LAYERS_THEME_SLUG ),
											'image-square' => __( 'Square' , LAYERS_THEME_SLUG ),
											'image-no-crop' => __( 'None' , LAYERS_THEME_SLUG ),
											'image-round' => __( 'Round' , LAYERS_THEME_SLUG ),
										)
									)
								); ?>
							</div>
						</div>
					</section>
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

	function imageratios( $widget = NULL, $values = NULL, $args = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="layers-visuals-item">
			<a href="" class="layers-icon-wrapper">
				<span class="icon-image-size"></span>
				<span class="layers-icon-description">
					<?php _e( 'Image Ratio' , LAYERS_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="layers-pop-menu-wrapper layers-animate layers-small">
				<div class="layers-pop-menu-setting">
					<div class="layers-select-wrapper layers-form-item">
						<?php echo $this->input(
							array(
								'type' => 'select-icons',
								'name' => $widget['name'] . '[imageratios]' ,
								'id' =>  $widget['id'] . '-imageratios' ,
								'value' => ( isset( $values['imageratios'] ) ) ? $values['imageratios'] : NULL,
								'options' => array(
									'image-portrait' => __( 'Portrait' , LAYERS_THEME_SLUG ),
									'image-landscape' => __( 'Landscape' , LAYERS_THEME_SLUG ),
									'image-square' => __( 'Square' , LAYERS_THEME_SLUG ),
									'image-no-crop' => __( 'None' , LAYERS_THEME_SLUG )
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
	* @param  	array     	$args 		Additional arguments to pass to this function
	*/

	function fonts( $widget = NULL, $values = NULL, $args = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="layers-visuals-item">
			<a href="" class="layers-icon-wrapper">
				<span class="icon-font-size"></span>
				<span class="layers-icon-description">
					<?php _e( 'Text' , LAYERS_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="layers-pop-menu-wrapper layers-animate layers-content-small">
				<div class="layers-pop-menu-setting">
					<section>
						<div class="layers-form-item">
							<label><?php _e( 'Text Align' , LAYERS_THEME_SLUG ); ?></label>
							<div class="layers-icon-group">
								<?php echo $this->input(
									array(
										'type' => 'select-icons',
										'name' => $widget['name'] . '[fonts][align]' ,
										'id' =>  $widget['id'] . '-fonts-align' ,
										'value' => ( isset( $values['fonts']['align'] ) ) ? $values['fonts']['align'] : NULL,
										'options' => array(
											'text-left' => __( 'Left' , LAYERS_THEME_SLUG ),
											'text-center' => __( 'Center' , LAYERS_THEME_SLUG ),
											'text-right' => __( 'Right' , LAYERS_THEME_SLUG ),
											'text-justify' => __( 'Justify' , LAYERS_THEME_SLUG )
										)
									)
								); ?>
							</div>
						</div>
						<div class="layers-form-item">
							<label><?php _e( 'Text Size' , LAYERS_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'select',
									'name' => $widget['name'] . '[fonts][size]' ,
									'id' =>  $widget['id'] . '-fonts-size' ,
									'value' => ( isset( $values['fonts']['size'] ) ) ? $values['fonts']['size'] : NULL,
									'options' => array(
											'small' => __( 'Small' , LAYERS_THEME_SLUG ),
											'medium' => __( 'Medium' , LAYERS_THEME_SLUG ),
											'large' => __( 'Large' , LAYERS_THEME_SLUG )
									)
								)
							); ?>
						</div>
						<div class="layers-form-item">
							<label><?php _e( 'Text Color' , LAYERS_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'color',
									'name' => $widget['name'] . '[fonts][color]' ,
									'id' =>  $widget['id'] . '-fonts-color' ,
									'value' => ( isset( $values['fonts']['color'] ) ) ? $values['fonts']['color'] : NULL
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
	* @param  	array     	$args 		Additional arguments to pass to this function
	*/

	function background( $widget = NULL, $values = NULL, $args = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="layers-visuals-item">
			<a href="" class="layers-icon-wrapper">
				<span class="icon-photo"></span>
				<span class="layers-icon-description">
					<?php _e( 'Background' , LAYERS_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="layers-pop-menu-wrapper layers-animate layers-content-small">
				<div class="layers-pop-menu-setting">
					<section>
						<div class="layers-form-item">
							<label><?php _e( 'Background Image' , LAYERS_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'image',
									'label' => __( 'Choose Background' , LAYERS_THEME_SLUG ),
									'name' => $widget['name'] . '[background][image]' ,
									'id' =>  $widget['id'] . '-background-image' ,
									'value' => ( isset( $values['background']['image'] ) ) ? $values['background']['image'] : NULL
								)
							); ?>
						</div>
						<div class="layers-form-item">
							<label><?php _e( 'Background Color' , LAYERS_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'color',
									'name' => $widget['name'] . '[background][color]' ,
									'id' =>  $widget['id'] . '-background-color' ,
									'value' => ( isset( $values['background']['color'] ) ) ? $values['background']['color'] : NULL
								)
							); ?>
						</div>
						<div class="layers-select-wrapper layers-form-item">
							<label><?php _e( 'Repeat' , LAYERS_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'select',
									'name' => $widget['name'] . '[background][repeat]' ,
									'id' =>  $widget['id'] . '-background-repeat' ,
									'value' => ( isset( $values['background']['repeat'] ) ) ? $values['background']['repeat'] : NULL,
									'options' => array(
											'no-repeat' => __( 'No Repeat' , LAYERS_THEME_SLUG ),
											'repeat' => __( 'Repeat' , LAYERS_THEME_SLUG ),
											'repeat-x' => __( 'Repeat Horizontal' , LAYERS_THEME_SLUG ),
											'repeat-y' => __( 'Repeat Vertical' , LAYERS_THEME_SLUG )
										)
								)
							); ?>
						</div>
						<div class="layers-select-wrapper layers-form-item">
							<label><?php _e( 'Position' , LAYERS_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'select',
									'name' => $widget['name'] . '[background][position]' ,
									'id' =>  $widget['id'] . '-background-position' ,
									'value' => ( isset( $values['background']['position'] ) ) ? $values['background']['position'] : NULL,
									'options' => array(
											'center' => __( 'Center' , LAYERS_THEME_SLUG ),
											'top' => __( 'Top' , LAYERS_THEME_SLUG ),
											'bottom' => __( 'Bottom' , LAYERS_THEME_SLUG ),
											'left' => __( 'Left' , LAYERS_THEME_SLUG ),
											'right' => __( 'Right' , LAYERS_THEME_SLUG )
										)
								)
							); ?>
						</div>
						<div class="layers-checkbox-wrapper layers-form-item">
							<?php echo $this->input(
								array(
									'type' => 'checkbox',
									'label' => __( 'Stretch' , LAYERS_THEME_SLUG ),
									'name' => $widget['name'] . '[background][stretch]' ,
									'id' =>  $widget['id'] . '-background-stretch' ,
									'value' => ( isset( $values['background']['stretch'] ) ) ? $values['background']['stretch'] : NULL
								)
							); ?>
						</div>
						<div class="layers-checkbox-wrapper layers-form-item">
							<?php echo $this->input(
								array(
									'type' => 'checkbox',
									'label' => __( 'Darken' , LAYERS_THEME_SLUG ),
									'name' => $widget['name'] . '[background][darken]' ,
									'id' =>  $widget['id'] . '-background-darken' ,
									'value' => ( isset( $values['background']['darken'] ) ) ? $values['background']['darken'] : NULL
								)
							); ?>
						</div>
					</section>
				</div>
			</div>
		</li>
	<?php }

	/**
	* Advanced - Static Option
	*
	* @param  	array     	$widget 	Widget Element
	* @param  	array     	$values 	Accepts the value for this element
	* @param  	array     	$args 		Additional arguments to pass to this function
	*/

	function advanced( $widget = NULL, $values = NULL, $args = NULL ){

		// If there is no widget information provided, can the operation
		if( NULL == $widget ) return; ?>

		<li class="layers-visuals-item">
			<a href="" class="layers-icon-wrapper">
				<span class="icon-settings"></span>
				<span class="layers-icon-description">
					<?php _e( 'Advanced' , LAYERS_THEME_SLUG ); ?>
				</span>
			</a>
			<div class="layers-pop-menu-wrapper layers-animate layers-content-small">
				<div class="layers-pop-menu-setting">
					<section>
						<div class="layers-text-wrapper layers-form-item">
							<label><?php _e( 'Custom Class' , LAYERS_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'text',
									'name' => $widget['name'] . '[advanced][customclass]' ,
									'id' =>  $widget['id'] . '-advanced-customclass' ,
									'value' => ( isset( $values['advanced']['customclass'] ) ) ? $values['advanced']['customclass'] : NULL,
									'placeholder' => 'example-class'
								)
							); ?>
						</div>
						<div class="layers-textarea-wrapper layers-form-item">
							<label><?php _e( 'Custom CSS' , LAYERS_THEME_SLUG ); ?></label>
							<?php echo $this->input(
								array(
									'type' => 'textarea',
									'name' => $widget['name'] . '[advanced][customcss]' ,
									'id' =>  $widget['id'] . '-advanced-customcss' ,
									'value' => ( isset( $values['advanced']['customcss'] ) ) ? $values['advanced']['customcss'] : NULL,
									'placeholder' => ".classname {\n\tbackground: #333;\n}"
								)
							); ?>
						</div>
					</section>
				</div>
			</div>
		</li>
	<?php  }

} //class Layers_Design_Controller