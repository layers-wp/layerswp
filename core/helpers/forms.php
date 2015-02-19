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
			<h2 class="layers-heading layers-icon layers-icon-<?php $header->icon_class; ?>">
				<!-- <i class="icon-<?php echo $header->icon_class; ?>-small"></i> -->
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

		$defaults = array(
				'type' => 'text',
				'name' => NULL ,
				'id' => NULL ,
				'placeholder' => NULL,
				'data' => NULL,
				'value' => NULL ,
				'class' => NULL,
				'options' => array()
			);

		// Turn $args into their own variables
		$input = (object) wp_parse_args( $args, $defaults );

		// If the value of this element is in fact a collection of inputs, turn it into an object, it's nicer to work with
		if( NULL != $input->value && is_array( $input->value ) ) $input->value = (object) $input->value;

		if( !is_object( $input->value ) ) $input->value = stripslashes( $input->value );

		// Create the input attributes
		$input_props = array();
		$input_props['id'] = ( NULL != $input->id && 'select-icons' != $input->type ) ? 'id="' .  $input->id . '"' : NULL ;
		$input_props['name'] = ( NULL != $input->name ) ? 'name="' .  $input->name . '"' : NULL ;
		$input_props['placeholder'] = ( NULL != $input->placeholder ) ? 'placeholder="' .  esc_attr( $input->placeholder ) . '"' : NULL ;
		$input_props['class'] = ( NULL != $input->class ) ? 'class="' .  $input->class . '"' : NULL ;
		if( NULL != $input->data ) { foreach( $input->data as $data_key => $data_value ){ $input_props[ 'data-' . $data_key ] = 'data-' . $data_key . '="' . esc_attr( $data_value ) . '"'; } }

		// Switch our input type
		switch( $input->type ) {
			case 'text' : ?>
				<input type="text" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo $input->value; ?>" />
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
				<select size="1" <?php echo implode ( ' ' , $input_props ); ?>>
					<?php if( NULL != $input->placeholder ) { ?>
						<option value=''><?php echo esc_html( $input->placeholder ); ?></option>
					<?php } // if NULL != placeholder ?>
					<?php foreach( $input->options as $value => $label ) { ?>
						<option value='<?php echo esc_attr( $value ); ?>' <?php selected( $input->value , $value, true ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php } // foreach options ?>
				</select>
			<?php break;
			/**
			* Select 'icons' such as the column selector
			*/
			case 'select-icons' : ?>
				<?php foreach( $input->options as $value => $label ) { ?>
					<label href="" class="layers-icon-wrapper <?php if( $value == $input->value ) echo 'layers-active'; ?>" for="<?php echo esc_attr( $input->id ) .'-' . esc_attr( $value ); ?>">
						<span class="icon-<?php echo esc_attr( $value ); ?>"></span>
						<span class="layers-icon-description">
							<?php echo esc_html( $label ); ?>
						</span>
					</label>
					<input type="radio" <?php echo implode ( ' ' , $input_props ); ?> id="<?php echo esc_attr( $input->id ) .'-' . esc_attr( $value ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php checked( $input->value , $value , true ); ?> class="layers-hide" />
				<?php } // foreach options ?>
			<?php break;
			/**
			* Text areas
			*/
			case 'textarea' : ?>
				<textarea <?php echo implode ( ' ' , $input_props ); ?> <?php if( isset( $input->rows ) ) echo 'rows="' . $input->rows . '"'; ?>><?php echo esc_textarea( $input->value ); ?></textarea>
			<?php break;
			/**
			* Tiny MCE
			*/
			case 'tinymce' : ?>
				<div class="layers-form-item" id="layers-tinymce-<?php echo esc_attr( $input->id ); ?>">
					<a href="" class="layers-t-right layers-tiny-mce-switch" data-mode="visual"
					data-visual_label="<?php _e( 'Visual Mode' , 'layerswp' ); ?>"
					data-html_label="<?php _e( 'HTML Mode' , 'layerswp' ); ?>">
						<?php _e( 'HTML Mode' , 'layerswp' ); ?>
					</a>
					<div class="editible editible-<?php echo esc_attr( $input->id ); ?>" data-id="<?php echo esc_attr( $input->id ); ?>"><?php echo esc_html( $input->value ); ?></div>
					<textarea class="layers-hide layers-textarea layers-tiny-mce-textarea" <?php echo implode ( ' ' , $input_props ); ?> <?php if( isset( $input->rows ) ) echo 'rows="' . $input->rows . '"'; ?>><?php echo $input->value; ?></textarea>
				</div>
			<?php break;
			/**
			* Image Uploader
			*/
			case 'image' : ?>
				<section class="layers-image-container <?php if( isset( $input->value ) && NULL != $input->value ) echo 'layers-has-image'; ?>">
					<div class="layers-image-display layers-image-upload-button">
						<!-- Image -->
						<?php if( isset( $input->value ) ) echo wp_get_attachment_image( $input->value , 'medium' ); ?>
						<!-- Remove button -->
						<a class="layers-image-remove" href=""><?php _e( 'Remove' , 'layerswp' ); ?></a>
					</div>

					<a href="#" class="layers-image-upload-button  layers-button btn-full <?php if( isset( $input->value ) && '' != $input->value ) echo 'layers-has-image'; ?>"
						data-title="<?php _e( 'Select an Image' , 'layerswp' ); ?>"
						data-button_text="<?php _e( 'Use Image' , 'layerswp' ); ?>">
						<?php echo ( isset( $input->button_label ) ? $input->button_label : __( 'Choose Image' , 'layerswp' ) ); ?>
					</a>

					<?php echo $this->input(
						array(
							'type' => 'hidden',
							'name' => $input->name,
							'id' => $input->id,
							'value' => ( isset( $input->value ) ) ? $input->value : NULL,
							'data' => ( NULL != $input->data ) ? $input->data : NULL,
						)
					); ?>
				</section>
			<?php break;
			/**
			* Regular Uploader
			*/
			case 'upload' : ?>
				<span>
					<!-- Image -->
					<?php if( isset( $input->value ) ) echo wp_basename( wp_get_attachment_url( $input->value ) , true ); ?>
				</span>
				<button  class="layers-regular-uploader layers-button btn-medium" data-title="<?php _e( 'Select a File' , 'layerswp' ); ?>" data-button_text="<?php _e( 'Use File' , 'layerswp' ); ?>">
					<?php _e( 'Choose a File' , LAYERS_THEME_SLUG  ); ?>
				</button>
				<small class="<?php if( !isset( $input->value ) ) echo 'hide'; ?> layers-file-remove">
					<?php _e( 'Remove' , 'layerswp' ); ?>
				</small>
				<input type="hidden" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo $input->value; ?>" />
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
									<a class="layers-image-remove <?php if( !isset( $input->value->image ) ) echo 'layers-hide'; ?>" href=""><?php _e( 'Remove' , 'layerswp' ); ?></a>

									<!-- Instructions -->
									<p <?php if( isset( $input->value->image ) ) echo 'class="layers-hide"'; ?>>
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
									<?php if( isset( $input->value->image ) ) echo wp_get_attachment_image( $input->value->image , 'thumbnail' ); ?>
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
				$tag = ( '' == $input->tag ) ? 'button' : $input->tag ;
				$href = ( '' == $input->href ) ? '' : 'href="' . $input->href . '"' ;
				?>
				<<?php echo $tag; ?>  class="layers-button btn-medium" <?php echo $href ?> <?php echo implode ( ' ' , $input_props ); ?> data-button_text="<?php echo esc_attr( $input->label ); ?>">
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

				<div class="layers-row layers-input">
					<?php foreach ( $fields as $key => $label ) { ?>
						<div class="layers-column-flush layers-span-3">
							<?php echo $this->input(
								array(
									'type' => 'number',
									'name' => $input->name . '[' . $key . ']',
									'id' => $input->id . '-' . $key,
									'value' => ( isset( $input->value->$key ) ) ? $input->value->$key : NULL,
									'class' => 'layers-hide-controls',
								)
							); ?>
							<label for="<?php echo esc_attr( $input->id ) . '-' . $key; ?>"><?php echo esc_html( $label ); ?></label>
						</div>
					<?php } // foreach fields ?>
				</div>

			<?php break;
			/**
			* Default to hidden field
			*/
			default : ?>
				<input type="hidden" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo $input->value; ?>" />
		<?php }

	}

}