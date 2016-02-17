<?php /**
 * Form Element Class File
 *
 * This file outputs common HTML elements for form items used in the admin area of Layers, it's useful not to have to re-write ever part of HTML that we use inside the widgets
 *
 * @package Layers
 * @since Layers 1.0.0
 */

class Layers_Form_Elements {

	/**
	* Load control title HTML
	*
 	* @param  	array    		$args    	Configuration arguments.
 	* @echo 	string 				Title HTML
 	*/

	public function header( $args = array() ){

		$defaults = array(
				'title' => __( 'Widget' , 'layerswp' ),
				'icon_class' => ''
			);

		$header = (object) wp_parse_args( $args, $defaults ); ?>

		<div class="layers-controls-title">
			<h2 class="layers-heading">
				<?php echo esc_html( $header->title ); ?>
			</h2>
		</div>

	<?php }

	/**
	* Accordian Title
	*
 	* @param 	array 		$args 		Configuration arguments.
 	* @echo 	string 				HTML for a widget accordian title.
 	*/

	public function accordian_title( $args = array() ){

		$accordian_title = (object) wp_parse_args( $args, array() ); ?>

		<a class="layers-accordion-title">
			<span><?php echo esc_html( $accordian_title->title ); ?></span>
		</a>
	<?php }

	/**
	* Panel/Section Title
	*
 	* @param 	array 		$args 		Configuration arguments.
 	* @echo 	string 				HTML for a widget accordian title.
 	*/

	public function section_panel_title( $args = array() ){

		$defaults = array(
				'type' => 'section'
			);

		$panel_title = (object) wp_parse_args( $args, $defaults ); ?>
		<div class="layers-<?php echo esc_attr( $panel_title->type ); ?>-title">
			<h4 class="heading"><?php echo esc_html( $panel_title->title ); ?></h4>
		</div>
	<?php }

	/**
	* Generate incremental options
	*
	* @param  	array     	$options() 	Existing option array if exists (optional)
	* @param  	int 		$min 		Minimum number to start with
	* @param  	int 		$max 		End point, included in the options with <=
	* @param  	int 		$increment 	How are we counting up?
	* @return 	array 		$options() 	Array of options
	*/

	public function get_incremental_options( $options = array() ,  $min = 1 , $max = 10 , $increment = 1 ){
		$i = $min;
		while ( $i <= $max ){
			$options[ $i ] = $i;
			$i=($i+$increment);
		}
		return $options;
	}

	/**
	* Generate default WP post sort options
	*
	* @param  	array     	$options() 	Existing option array if exists (optional)
	* @return 	array 		$options()	Array of options
	*/

	public function get_sort_options( $options = array() ){
		$options[ json_encode( array( 'orderby' => 'date', 'order' => 'desc' ) ) ] = __( 'Newest First' , 'layerswp' );
		$options[ json_encode( array( 'orderby' => 'date', 'order' => 'asc' ) ) ] = __( 'Oldest First' , 'layerswp' );
		$options[ json_encode( array( 'orderby' => 'rand', 'order' => 'desc' ) ) ] = __( 'Random' , 'layerswp' );
		$options[ json_encode( array( 'orderby' => 'title', 'order' => 'asc' ) ) ] = __( 'Titles A-Z' , 'layerswp' );
		$options[ json_encode( array( 'orderby' => 'title', 'order' => 'desc' ) ) ] = __( 'Titles Z-A' , 'layerswp' );
		$options[ json_encode( array( 'orderby' => 'comment_count', 'order' => 'desc' ) ) ] = __( 'Most Comments' , 'layerswp' );
		$options[ json_encode( array( 'orderby' => 'menu_order', 'order' => 'desc' ) ) ] = __( 'Custom Order' , 'layerswp' );
		return $options;
	}

	/**
	* Load input HTML
	*
	* @param  	array     	$array() 	Existing option array if exists (optional)
	* @return 	array 		$array 		Array of options, all standard DOM input options
	*/

	public function input( $args = array() ) {
		global $wp_customize;

		$defaults = array(
			'type' => 'text',
			'name' => NULL ,
			'id' => NULL ,
			'placeholder' => NULL,
			'data' => NULL,
			'value' => NULL ,
			'class' => NULL,
			'options' => array(),
			'sync_setting' => NULL,
			'mimic_setting' => NULL,
		);

		// Convert 'choices' to 'options' - so you can use same naming as the controls which use 'options'.
		if ( isset( $args['choices'] ) && ! empty( $args['choices'] ) && ! isset ( $args['options'] ) ) {
			$args['options'] = $args['choices'];
			unset( $args['choices'] );
		}

		// Turn $args into their own variables
		$input = (object) wp_parse_args( $args, $defaults );

		// If the value of this element is in fact a collection of inputs, turn it into an object, it's nicer to work with
		if( NULL != $input->value && is_array( $input->value ) ) $input->value = (object) $input->value;

		if( !is_object( $input->value ) ) $input->value = stripslashes( $input->value );

		// Create the input attributes
		$input_props = array();
		$input_props['id'] = ( NULL != $input->id && 'select-icons' != $input->type ) ? 'id="' .  $input->id . '"' : NULL ;
		$input_props['name'] = ( NULL != $input->name ) ? 'name="' .  $input->name . '"' : NULL ;
		$input_props['placeholder'] = ( NULL !== $input->placeholder ) ? 'placeholder="' . esc_attr( $input->placeholder ) . '"' : NULL ;
		$input_props['class'] = ( NULL != $input->class ) ? 'class="' .  $input->class . '"' : NULL ;
		$input_props['disabled'] = isset( $input->disabled ) ? 'disabled="disabled"' : NULL ;
		$input_props['sync-setting'] = isset( $input->sync_setting ) ? 'data-sync-setting="' . $input->sync_setting . '"' : NULL ;
		$input_props['mimic-setting'] = isset( $input->mimic_setting ) ? 'data-mimic-setting="' . $input->mimic_setting . '"' : NULL ;

		if( NULL != $input->data ) { foreach( $input->data as $data_key => $data_value ){ $input_props[ 'data-' . $data_key ] = 'data-' . $data_key . '="' . esc_attr( $data_value ) . '"'; } }

		// Switch our input type
		switch( $input->type ) {
			case 'text' : ?>
				<input type="text" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo esc_attr( $input->value ); ?>" />
			<?php break;
			/**
			* Number Inputs
			*/
			case 'number' :
				$input_props['min'] = ( isset( $input->min ) ) ? 'min="' .  $input->min . '"' : NULL ;
				$input_props['max'] = ( isset( $input->max ) ) ? 'max="' .  $input->max . '"' : NULL ;
				$input_props['step'] = ( isset( $input->step ) ) ? 'step="' .  $input->step . '"' : NULL ; ?>
				<input type="number" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo $input->value; ?>" />
			<?php break;
			/**
			* Range Inputs
			*/
			case 'range' :

				$range_input_props = array();
				$number_input_props = array();

				$number_input_props['step'] = ( isset( $input->step ) ) ? 'step="' .  $input->step . '"' : NULL ;

				$range_input_props['min'] = ( NULL !== $input->min ) ? 'min="' .  $input->min . '"' : NULL ;
				$range_input_props['max'] = ( NULL !== $input->max ) ? 'max="' .  $input->max . '"' : NULL ;
				$range_input_props['step'] = ( NULL !== $input->step ) ? 'step="' .  $input->step . '"' : NULL ;
				$range_input_props['placeholder'] = ( NULL !== $input->placeholder ) ? 'placeholder="' .  $input->placeholder . '"' : NULL ;

				if ( isset( $input->value ) && '' !== $input->value )
					$range_input_props['value'] = 'value="' .  $input->value . '"';
				elseif ( isset( $input->placeholder ) )
					$range_input_props['value'] = 'value="' .  $input->placeholder . '"';
				?>
				<div class="layers-row">
					<div class="layers-column layers-span-9">
						<input type="range" <?php echo implode ( ' ' , $range_input_props ); ?> />
					</div>
					<div class="layers-column layers-span-3">
						<input type="number" <?php echo implode ( ' ' , $input_props ); ?> <?php echo implode ( ' ' , $number_input_props ); ?> value="<?php echo $input->value; ?>" />
					</div>
				</div>
			<?php break;
			/**
			* Checkboxes - here we look for on/NULL, that's how WP widgets save them
			*/
			case 'checkbox' : ?>
				<input type="checkbox" <?php echo implode ( ' ' , $input_props ); ?> <?php checked( $input->value , 'on' ); ?>/>
				<?php if( isset( $input->label ) ) { ?>
					<label for="<?php echo esc_attr( $input->id ); ?>"><?php echo esc_html( $input->label ); ?></label>
				<?php } // if isset label ?>
			<?php break;
			/**
			* Radio Buttons
			*/
			case 'radio' : ?>
				<?php foreach( $input->options as $value => $label ) { ?>
					<input type="radio" <?php echo implode ( ' ' , $input_props ); ?> />
					<label><?php echo esc_html( $label ); ?></label>
				<?php } // foreach options ?>
			<?php break;
			/**
			* Select boxes
			*/
			case 'select' : ?>
				<select size="1" <?php echo implode ( ' ' , $input_props ); ?> <?php if( isset( $input->multiple ) ) echo 'multiple="multiple"'; ?>>
					<?php if( NULL != $input->placeholder ) { ?>
						<option value=''><?php echo esc_html( $input->placeholder ); ?></option>
					<?php } // if NULL != placeholder ?>
					<?php foreach( $input->options as $value => $label ) { ?>
						<option value='<?php echo esc_attr( $value ); ?>' <?php if( !is_object( $input->value ) ) selected( $input->value , $value, true ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php } // foreach options ?>
				</select>
			<?php break;
			/**
			* Multi select boxes
			*/
			case 'multi-select' :
				// Force the selection to be an array
				$select_values =  (array) $input->value; ?>
				<select size="1" <?php echo implode ( ' ' , $input_props ); ?> multiple="multiple">
					<?php if( NULL != $input->placeholder ) { ?>
						<option value=''><?php echo esc_html( $input->placeholder ); ?></option>
					<?php } // if NULL != placeholder ?>
					<?php foreach( $input->options as $value => $label ) { ?>
						<option value='<?php echo esc_attr( $value ); ?>' <?php if( is_array( $select_values ) && in_array( $value, $select_values ) ) echo 'selected=selected'; ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php } // foreach options ?>
				</select>
			<?php break;
			/**
			* Select 'icons' such as the column selector
			*/
			case 'select-icons' :
				
				$input_type = ( 1 == count( $input->options ) ) ? 'checkbox' : 'radio';
				?>
				<div class="layers-select-icons">
					<?php foreach( $input->options as $key => $value ) {
						if ( is_array( $value ) ) {
							$name = $value['name'];
							$class = $value['class'];
							$data_string = '';
							if ( ! empty( $value['data'] ) ) {
								foreach ( $value['data'] as $data_key => $data_value) {
									$data_string .= 'data-' . esc_attr( $data_key ) . '="' . $data_value . '" ';
								}
							}
						}
						else {
							$name = $value;
							$class = "icon-{$key}";
							$data_string = '';
						}
						
						$data_string .= 'data-value="' . $input->value . '" ';
						?>
						<label
							href=""
							class="layers-icon-wrapper <?php if ( $key == $input->value ) echo 'layers-active'; ?>"
							for="<?php echo esc_attr( $input->id ) ,'-', esc_attr( $key ); ?>"
							<?php echo $data_string ?>
							>
							<span class="<?php echo esc_attr( $class ); ?>"></span>
							<span class="layers-icon-description">
								<?php echo esc_html( $name ); ?>
							</span>
						</label>
						<input type="<?php echo $input_type ?>" <?php echo implode ( ' ' , $input_props ); ?> id="<?php echo esc_attr( $input->id ), '-', esc_attr( $key ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( $input->value, $key, true ); ?> />
					<?php } ?>
				</div>
			<?php break;
			/**
			* Text areas
			*/
			case 'textarea' : ?>
				<textarea <?php echo implode ( ' ' , $input_props ); ?> <?php if( isset( $input->rows ) ) echo 'rows="' , $input->rows , '"'; ?>><?php echo esc_textarea( $input->value ); ?></textarea>
			<?php break;
			/**
			* Rich Text Editor
			*/
			case 'rte' :
				// Apply allowed tags list
				$allow_tags = ( isset( $input->allow_tags ) && is_array( $input->allow_tags ) ? implode( ',' , $input->allow_tags ) : array() );

				// Add custom button support
				$allow_buttons = ( isset( $input->allow_buttons ) && is_array( $input->allow_buttons ) ? $input->allow_buttons : array( 'sep','bold','italic','underline','strikeThrough','createLink','insertOrderedList','insertUnorderedList','removeFormat','html' ) );

				// Check for disabling of standard buttons
				if( isset( $input->disallow_buttons ) && is_array( $input->disallow_buttons ) ) {
					foreach( $allow_buttons as $button_key => $button_value ){
						if( in_array( $button_value , $input->disallow_buttons ) ){
							unset( $allow_buttons[ $button_key ] );
						}
					}
				} ?>
				<textarea
					class="layers-textarea layers-rte"
					<?php if( !empty( $allow_tags ) ) { ?>data-allowed-tags="<?php echo implode( ',' , $allow_tags ); ?>"<?php } ?>
					<?php if( !empty( $allow_buttons ) ) { ?>data-allowed-buttons="<?php echo implode( ',' , $allow_buttons ) ; ?>"<?php } ?>
					<?php if( isset( $input->rows ) ) { ?>rows="<?php echo $input->rows; ?>"<?php } ?>
					<?php echo implode ( ' ' , $input_props ); ?>
					><?php echo $input->value; ?></textarea>
			<?php break;
			/**
			* Image Uploader
			*/
			case 'image' :
				$has_image = ( bool ) ( isset( $input->value ) && '' !== $input->value && NULL != $input->value ); ?>
				<section class="layers-image-container <?php echo ( $has_image ) ? 'layers-has-image' : '' ; ?>">
					<div class="layers-image-display layers-image-upload-button">
						<!-- Image -->
						<?php if ( $has_image ) { ?>
							<?php $img = wp_get_attachment_image_src( $input->value, 'medium' ); ?>
							<img <?php echo isset( $wp_customize ) ? 'data-src' : 'src' ; ?>="<?php echo $img[0]; ?>" />
						<?php } ?>
						<!-- Remove button -->
						<a href="#removeimage" class="layers-image-remove" href=""><?php _e( 'Remove' , 'layerswp' ); ?></a>
					</div>

					<a href="#uploadimage" class="layers-image-upload-button button layers-button btn-full <?php echo ( $has_image ) ? 'layers-has-image' : '' ; ?>"
						data-title="<?php _e( 'Select an Image' , 'layerswp' ); ?>"
						data-button_text="<?php _e( 'Use Image' , 'layerswp' ); ?>">
						<?php echo ( isset( $input->button_label ) ? $input->button_label : __( 'Choose Image' , 'layerswp' ) ); ?>
					</a>

					<?php echo $this->input(
						array(
							'type' => 'hidden',
							'name' => $input->name,
							'id' => $input->id,
							'value' => ( $has_image ) ? $input->value : NULL,
							'data' => ( NULL != $input->data ) ? $input->data : NULL,
						)
					); ?>
				</section>
			<?php break;
			/**
			* Regular Uploader
			*/
			case 'upload' : ?>
				<section class="layers-file-container <?php if( isset( $input->value ) && NULL != $input->value ) echo 'layers-has-file'; ?>">
					<span class="layers-file-name">
						<!-- Image -->
						<?php if( isset( $input->value ) ) echo wp_basename( wp_get_attachment_url( $input->value ) , true ); ?>
					</span>

					<a href="#choosefile" class="layers-regular-uploader layers-button btn-medium btn-full"
						data-title="<?php echo ( isset( $input->button_label ) ? esc_attr( $input->button_label ) : __( 'Choose File' , 'layerswp' ) ); ?>"
						data-button_text="<?php _e( 'Use File' , 'layerswp' ); ?>">
						<?php echo ( isset( $input->button_label ) ? $input->button_label : __( 'Choose File' , 'layerswp' ) ); ?>
					</a>

					<a href="#removefile" class="<?php if( !isset( $input->value ) ) echo 'hide'; ?> layers-image-remove layers-file-remove">
						<?php _e( 'Remove' , 'layerswp' ); ?>
					</a>
					<input type="hidden" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo $input->value; ?>" />
				</section>
			<?php break;
			/**
			* Background Controller
			*/
			case 'background' :

				// Default to image if we haven't already done so
				if( !isset( $input->value->type ) ) $input_type = 'image'; else $input_type = $input->value->type; ?>

				<div class="layers-media-controller" id="<?php echo esc_attr( $input->id ); ?>-controller">
					<ul class="layers-section-links layers-background-selector">
						<li <?php if( 'video' != $input_type ) echo 'class="active"'; ?> data-id="#<?php echo esc_attr( $input->id ); ?>" data-type="image">
							<a href="" class="icon-photo"></a>
						</li>
						<li <?php if( 'video' == $input_type ) echo 'class="active"'; ?> data-id="#<?php echo esc_attr( $input->id ); ?>" data-type="video">
							<a href="" class="icon-video"></a>
						</li>
					</ul>

					<!-- Background Type Input -->
					<?php echo $this->input(
						array(
							'type' => 'hidden',
							'name' => $input->name . '[type]' ,
							'id' => $input->id . '-type',
							'value' => ( isset( $input->value->type ) ) ? $input->value->type : 'image'
						)
					); ?>

					<div class="layers-controller-elements">

						<!-- Image uploader -->
						<div class="layers-content <?php if( 'image' == $input_type ) echo 'section-active'; ?>">
							<div class="layers-form-item">
								<div class="layers-image-uploader layers-animate layers-push-bottom">
									<!-- Remove button -->
									<a class="layers-image-remove <?php if( !isset( $input->value->image ) ) echo 'l_admin-hide'; ?>" href=""><?php _e( 'Remove' , 'layerswp' ); ?></a>

									<!-- Instructions -->
									<p <?php if( isset( $input->value->image ) ) echo 'class="l_admin-hide"'; ?>>
										<?php printf( __( 'Drop a file here or %s' , 'layerswp' ) , '<a href="#">select a file.</a>' ); ?>
									</p>

									<!-- Input -->
									<?php echo $this->input(
										array(
											'type' => 'hidden',
											'name' => $input->name . '[image]' ,
											'id' => $input->id . '-image',
											'value' => ( isset( $input->value->image ) ) ? $input->value->image : NULL
										)
									); ?>

									<!-- Image -->
									<?php if( isset( $input->value->image ) ) {
										$img = wp_get_attachment_image_src( $input->value->image , 'thumbnail' );?>
										<img data-src="<?php echo $img[0]; ?>" />
									<?php } ?>
								</div>
							</div>
							<div class="layers-row">

								<p class="layers-form-item">
									<label><?php _e( 'Background Color' , 'layerswp' ); ?></label>
									<?php echo $this->input(
										array(
											'type' => 'color',
											'name' => $input->name . '[image_color]' ,
											'id' => $input->id . 'image-color',
											'value' => ( isset( $input->value->image_color ) ) ? $input->value->image_color : NULL,
										)
									); ?>
								</p>

								<ul class="layers-checkbox-list">
									<li class="layers-checkbox">
										<?php echo $this->input(
											array(
												'type' => 'checkbox',
												'name' => $input->name . '[darken]' ,
												'id' => $input->id . '-darken',
												'value' => ( isset( $input->value->darken ) ) ? $input->value->darken : NULL,
												'label' => __( 'Darken to improve readability' , 'layerswp' )
											)
										); ?>
									</li>
									<li class="layers-checkbox">
										<?php echo $this->input(
											array(
												'type' => 'checkbox',
												'name' => $input->name . '[tile_background]' ,
												'id' => $input->id . '-tile_background',
												'value' => ( isset( $input->value->tile_background ) ) ? $input->value->tile_background : NULL,
												'label' => __( 'Tile Background' , 'layerswp' )
											)
										); ?>
									</li>
									<li class="layers-checkbox">
										<?php echo $this->input(
											array(
												'type' => 'checkbox',
												'name' => $input->name . '[fixed_background]' ,
												'id' => $input->id . '-fixed_background',
												'value' => ( isset( $input->value->fixed_background ) ) ? $input->value->fixed_background : NULL,
												'label' => __( 'Fixed Background' , 'layerswp' )
											)
										); ?>
									</li>
								</ul>
							</div>
						</div>

						<!-- Video uploader -->
						<div class="layers-content <?php if( 'video' == $input->value->type ) echo 'section-active'; ?>">
							<p class="layers-form-item">
								<label><?php _e( 'Enter your .mp4 link' , 'layerswp' ); ?></label>
								<?php echo $this->input(
									array(
										'type' => 'upload',
										'name' => $input->name . '[mp4]' ,
										'id' => $input->id . '-mp4',
										'value' => ( isset( $input->value->mp4 ) ) ? $input->value->mp4 : NULL
									)
								); ?>
							</p>
							<p class="layers-form-item">
								<label><?php _e( 'Enter your .ogv link' , 'layerswp' ); ?></label>
								<?php echo $this->input(
									array(
										'type' => 'upload',
										'name' => $input->name . '[ogv]' ,
										'id' => $input->id . '-ogv',
										'value' => ( isset( $input->value->ogv ) ) ? $input->value->ogv : NULL
									)
								); ?>
							</p>
							<div class="layers-row">
								<p class="layers-form-item layers-no-push-bottom">
									<label><?php _e( 'Background Color' , 'layerswp' ); ?></label>
									<?php echo $this->input(
										array(
											'type' => 'color',
											'name' => $input->name . '[video_color]' ,
											'id' => $input->id . '-video-color',
											'value' => ( isset( $input->value->video_color ) ) ? $input->value->video_color : NULL,
										)
									); ?>
								</p>

								<ul class="layers-checkbox-list">
									<li class="layers-checkbox">
										<?php echo $this->input(
											array(
												'type' => 'checkbox',
												'name' => $input->name . '[video_darken]' ,
												'id' => $input->id . '-video_darken',
												'value' => ( isset( $input->value->video_darken ) ) ? $input->value->video_darken : NULL,
												'label' => __( 'Darken to improve readability' , 'layerswp' )
											)
										); ?>
									</li>
									<li class="layers-checkbox">
										<?php echo $this->input(
											array(
												'type' => 'checkbox',
												'name' => $input->name . '[video_tile_background]' ,
												'id' => $input->id . '-video_tile_background',
												'value' => ( isset( $input->value->video_tile_background ) ) ? $input->value->video_tile_background : NULL,
												'label' => __( 'Tile Background' , 'layerswp' )
											)
										); ?>
									</li>
									<li class="layers-checkbox">
										<?php echo $this->input(
											array(
												'type' => 'checkbox',
												'name' => $input->name . '[video_fixed_background]' ,
												'id' => $input->id . '-video_fixed_background',
												'value' => ( isset( $input->value->video_fixed_background ) ) ? $input->value->video_fixed_background : NULL,
												'label' => __( 'Fixed Background' , 'layerswp' )
											)
										); ?>
									</li>
								</ul>
							</div>
						</div>

					</div>
				</div>
			<?php break;
			/**
			* Color Selector
			*/
			case 'color' : ?>
				<input type="text" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo $input->value; ?>" class="layers-color-selector" />
			<?php break;
			/**
			* Button Selector
			*/
			case 'button' :
				$tag = ( isset( $input->tag ) &&'' != $input->tag ) ? $input->tag : 'button';
				$href = ( isset( $input->href ) && '' != $input->href ) ? 'href="' . $input->href . '"' : ''; ?>
				<<?php echo $tag; ?>  <?php if( NULL == $input_props[ 'class' ] ) echo 'class="layers-button btn-medium"'; ?> <?php echo $href ?> <?php echo implode ( ' ' , $input_props ); ?> data-button_text="<?php echo esc_attr( $input->label ); ?>">
					<?php echo esc_attr( $input->label ); ?>
				</<?php echo $tag; ?>>
			<?php break;
			/**
			* Top / Right / Bottom / Left Fields
			*/
			case 'trbl-fields' : ?>

				<?php $fields = array(
					'top' => __( 'Top' , 'layerswp' ),
					'right' => __( 'Right' , 'layerswp' ),
					'bottom' => __( 'Bottom' , 'layerswp' ),
					'left' => __( 'Left' , 'layerswp' ),
				); ?>

				<?php
				// If caller only wants chosen few fields can customise the labels e.g.
				// (1) 'fields' => array( 'top' => 'Top (px)' ) one field 'top' with cusotmized label 'Top (px)'.
				// (2) 'fields' => array( 'top' ) one field 'top' with standard label 'Top'.
				if( ! empty( $input->fields ) ) {
					$new_fields = array();
					foreach ( $input->fields as $key => $value ) {

						if ( is_numeric( $key ) ) {
							// Array element type: [ 'bottom' ]
							if ( isset( $fields[$value] ) ){ // Make sure that what the user spcified is avalid field of TRBL.
								$new_fields[$value] = $fields[$value];
							}
						}
						else {
							// Array element type: [ 'bottom' => 'Bottom (px)' ]
							$new_fields[$key] = $value;
						}
					}
					$fields = $new_fields;

					// If the fields chosen were incorrect then bail.
					if ( empty( $fields ) ) return;
				}

				// Calculate column span based on the number of resulting fields.
				$field_span = ( 12 / count( $fields ) );
				?>
				<div class="layers-row layers-input layers-trbl-row">

					<?php foreach ( $fields as $key => $label ) : ?>
						<div class="layers-column-flush layers-span-<?php echo esc_attr( $field_span ); ?>">
							<?php echo $this->input(
								array(
									'type' => 'number',
									'name' => ( isset( $input->name ) ) ? "{$input->name}[$key]" : '',
									'id' => "{$input->id}-{$key}",
									'value' => ( isset( $input->value->$key ) ) ? $input->value->$key : NULL,
									'class' => 'l_admin-hide-controls',
									'data' => array(
										'customize-setting-link' => "{$input->id}-{$key}",
									),
								)
							); ?>
							<label for="<?php echo esc_attr( $input->id ) . '-' . $key; ?>"><?php echo esc_html( $label ); ?></label>
						</div>
					<?php endforeach; ?>

				</div>

			<?php break;
			/**
			* Free form HTML
			*/
			case 'html' : ?>

				<div class="layers-row">
					<?php echo $input->html; ?>
				</div>
			
			<?php break;
				
			/**
			* Dynamic Linking Interface
			*/
			case 'link-group' : ?>
				<div class="layers-form-collection layers-link-group closed">
					
					<!-- Header -->
					<div class="layers-form-collection-header">
						<?php echo ( isset( $input->value->link_text ) ) ? $input->value->link_text : '&nbsp' ; ?>
					</div>
					<!-- / Header -->
					
					<!-- Content -->
					<div class="layers-form-collection-content">
					
						<div class="layers-row">
							<div class="layers-form-item layers-column layers-span-5">
								<label for="<?php echo "{$input->id}-link_type"; ?>">
									<?php _e( 'Link' , 'layerswp' ); ?>
								</label>
								<?php echo $this->input(
									array(
										'type' => 'select',
										'name' => "{$input->name}[link_type]",
										'id' => "{$input->id}-link_type",
										'options' => array(
											'custom'            => __( 'Custom', 'layerswp' ),
											'post'              => __( 'Existing Content', 'layerswp' ), // Page, Post, Custom Post Type
											// 'post_type_archive' => __( 'Post Archives (incl. Custom Post Types)', 'layerswp' ),
											// 'taxonomy_archive'  => __( 'Taxonomy Archives (incl. Custom Taxonomies)', 'layerswp' ),
										),
										'value' => ( isset( $input->value->link_type ) ) ? $input->value->link_type : NULL,
										'class' => 'layers-text',
										'data' => array(
											'tip' => __( 'Choose Link Type', 'layerswp' ),
										),
									)
								); ?>
							</div>
							<div class="layers-form-item layers-column layers-span-7 layers-link-field-holder">
								<label for="<?php echo "{$input->id}-link_type_custom"; ?>">
									&nbsp;
								</label>
								<div class="layers-form-item layers-link-field layers-link-field-link_type_custom" data-show-if-selector= "#<?php echo "{$input->id}-link_type"; ?>" data-show-if-value="custom" data-tip="<?php _e( 'Choose Your Link', 'layerswp' ) ?>">
									<label>
										<?php _e( 'Custom', 'layerswp' ) ?>
									</label>
									<?php echo $this->input(
										array(
											'type' => 'text',
											'name' => "{$input->name}[link_type_custom]",
											'id' => "{$input->id}-link_type_custom",
											'placeholder' => __( 'http://' , 'layerswp' ),
											'value' => ( isset( $input->value->link_type_custom ) ) ? $input->value->link_type_custom : NULL,
											'class' => 'layers-text',
											'data' => array(
												'tip' => __( 'Link', 'layerswp' ),
											),
										)
									); ?>
								</div>
								<div class="layers-form-item layers-link-field layers-link-field-link_type_post" data-show-if-selector= "#<?php echo "{$input->id}-link_type"; ?>" data-show-if-value="post" data-tip="<?php _e( 'Choose Your Link', 'layerswp' ) ?>">
									<label>
										<?php _e( 'Post/Page', 'layerswp' ) ?>
									</label>
									<?php
									$initial_post_id = isset( $input->value->link_type_post ) ? $input->value->link_type_post : 0 ;
									$initial_display = get_the_title( $initial_post_id ) . ' (' . get_post_type( $initial_post_id ) . ')';
									echo $this->input(
										array(
											'type' => 'hidden',
											'name' => "{$input->name}[link_type_post]",
											'id' => "{$input->id}-link_type_post",
											'placeholder' => __( '-- Choose --' , 'layerswp' ),
											'value' => ( isset( $input->value->link_type_post ) ) ? $input->value->link_type_post : NULL,
											'class' => 'layers-text layers-widget-dynamic-linking-select',
											'data' => array(
												'display-text' => $initial_display,
											),
										)
									);
									?>
								</div>
								<div class="layers-form-item layers-link-field layers-link-field-link_type_post_type_archive" data-show-if-selector= "#<?php echo "{$input->id}-link_type"; ?>" data-show-if-value="post_type_archive" data-tip="<?php _e( 'Choose Your Link', 'layerswp' ) ?>">
									<label>
										<?php _e( 'Post Archives', 'layerswp' ) ?>
									</label>
									<?php echo $this->input(
										array(
											'type' => 'hidden',
											'name' => "{$input->name}[link_type_post_type_archive]",
											'id' => "{$input->id}-link_type_post_type_archive",
											'placeholder' => __( 'http://' , 'layerswp' ),
											'value' => ( isset( $input->value->link_type_post_type_archive ) ) ? $input->value->link_type_post_type_archive : NULL,
											'class' => 'layers-text layers-widget-dynamic-linking-select',
										)
									); ?>
								</div>
								<div class="layers-form-item layers-link-field layers-link-field-link_type_taxonomy_archive" data-show-if-selector= "#<?php echo "{$input->id}-link_type"; ?>" data-show-if-value="taxonomy_archive" data-tip="<?php _e( 'Choose Your Link', 'layerswp' ) ?>">
									<label>
										<?php _e( 'Taxonomy Archives', 'layerswp' ) ?>
									</label>
									<?php echo $this->input(
										array(
											'type' => 'hidden',
											'name' => "{$input->name}[link_type_taxonomy_archive]",
											'id' => "{$input->id}-link_type_taxonomy_archive",
											'placeholder' => __( 'http://' , 'layerswp' ),
											'value' => ( isset( $input->value->link_type_taxonomy_archive ) ) ? $input->value->link_type_taxonomy_archive : NULL,
											'class' => 'layers-text layers-widget-dynamic-linking-select',
										)
									); ?>
								</div>
								<div class="layers-visuals-item layers-icon-group layers-link-field-link_target">
									<?php echo $this->input(
										array(
											'type' => 'select-icons',
											'name' => "{$input->name}[link_target]",
											'id' => "{$input->id}-link_target",
											'placeholder' => __( 'e.g. http://facebook.com/oboxthemes', 'layers-pro' ),
											'value' => ( isset( $input->value->link_target ) ) ? $input->value->link_target : NULL,
											'options' => array(
												'_blank' => array(
													'name'   => 'New Tab',
													'class' => 'fa fa-share-square-o',
													'data' => array(
														'tip' => 'Open in New Tab',
													),
												),
											)
									) ); ?>
								</div>
							</div>
						</div>
						
						<div class="layers-row">
							<div class="layers-form-item layers-column layers-span-12">
								<label for="<?php echo "{$input->id}-link_text"; ?>">
									<?php _e( 'Text' , 'layerswp' ); ?>
								</label>
								<?php echo $this->input(
									array(
										'type' => 'text',
										'name' => "{$input->name}[link_text]",
										'id' => "{$input->id}-link_text",
										'placeholder' => __( 'e.g. "Read More"' , 'layerswp' ),
										'value' => ( isset( $input->value->link_text ) ) ? $input->value->link_text : NULL,
									)
								); ?>
							</div>
						</div>
						
					</div>
					<!-- / Content -->
					
				</div>
				
			<?php break;
			
			/**
			* Default to hidden field
			*/
			default : ?>
				<input type="hidden" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo $input->value; ?>" />
			<?php
		}

	}

}
