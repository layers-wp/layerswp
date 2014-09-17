<?php /**
 * Form Element Class File
 *
 * This file outputs common HTML elements for form items used in the admin area of Hatch, it's useful not to have to re-write ever part of HTML that we use inside the widgets
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Form_Elements {

	/**
	* Load control title HTML
	*
 	* @param  	array    		$args    	Configuration arguments.
 	* @echo 	string 				Title HTML
 	*/

	public function header( $args = array() ){

		$defaults = array(
				'title' => __( 'Widget' , HATCH_THEME_SLUG ),
				'icon_class' => ''
			);

		$header = (object) wp_parse_args( $args, $defaults ); ?>

		<div class="hatch-controls-title">
			<h2 class="hatch-heading hatch-icon hatch-icon-<?php $header->icon_class; ?>">
				<!-- <i class="icon-<?php echo $header->icon_class; ?>-small"></i> -->
				<?php echo $header->title; ?>
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

		<a class="hatch-accordion-title">
			<span><?php echo $accordian_title->title; ?></span>
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
		<div class="hatch-<?php echo $panel_title->type; ?>-title">
			<?php if( isset( $panel_title->tooltip ) ) { ?><span class="tooltip" tooltip=" <?php echo $panel_title->tooltip; ?>"></span><?php } ?>
			<h4 class="heading"><?php echo $panel_title->title; ?></h4>
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

	public function get_default_sort_options( $options = array() ){
		$options[ "date" ] = __( 'Newest First' , HATCH_THEME_SLUG );
		$options[ "rand" ] = __( 'Random' , HATCH_THEME_SLUG );
		$options[ "title" ] = __( 'Titles A-Z' , HATCH_THEME_SLUG );
		$options[ "comment_count" ] = __( 'Comment Count' , HATCH_THEME_SLUG );
		$options[ "menu_order" ] = __( 'Custom Order' , HATCH_THEME_SLUG );
		return $options;
	} // @TODO: Make this smater to work with order_by AND order

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

		// Create the input attributes
		$input_props = array();
		$input_props['id'] = ( NULL != $input->id && 'select-icons' != $input->type ) ? 'id="' .  $input->id . '"' : NULL ;
		$input_props['name'] = ( NULL != $input->name ) ? 'name="' .  $input->name . '"' : NULL ;
		$input_props['placeholder'] = ( NULL != $input->placeholder ) ? 'placeholder="' .  $input->placeholder . '"' : NULL ;
		$input_props['class'] = ( NULL != $input->class ) ? 'class="' .  $input->class . '"' : NULL ;
		if( NULL != $input->data ) { foreach( $input->data as $data_key => $data_value ){ $input_props[ 'data-' . $data_key ] = 'data-' . $data_key . '="' . $data_value . '"'; } }

		// Switch our input type
		switch( $input->type ) {
			/**
			* Text Inputs
			*/
			case 'text' : ?>
				<input type="text" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo $input->value; ?>" />
			<?php break;
			/**
			* Number Inputs
			*/
			case 'number' :
				$input_props['min'] = ( NULL != $input->min ) ? 'min="' .  $input->min . '"' : NULL ;
				$input_props['max'] = ( NULL != $input->max ) ? 'max="' .  $input->max . '"' : NULL ; ?>
				<input type="number" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo $input->value; ?>" />
			<?php break;
			/**
			* Checkboxes - here we look for on/NULL, that's how WP widgets save them
			*/
			case 'checkbox' : ?>
				<input type="checkbox" <?php echo implode ( ' ' , $input_props ); ?> <?php checked( $input->value , 'on' ); ?>/>
				<?php if( isset( $input->label ) ) { ?>
					<label for="<?php echo $input->id; ?>"><?php echo $input->label; ?></label>
				<?php } // if isset label ?>
			<?php break;
			/**
			* Radio Buttons
			*/
			case 'radio' : ?>
				<?php foreach( $input->options as $value => $label ) { ?>
					<input type="radio" <?php echo implode ( ' ' , $input_props ); ?> />
					<label><?php echo $label; ?></label>
				<?php } // foreach options ?>
			<?php break;
			/**
			* Select boxes
			*/
			case 'select' : ?>
				<select size="1" <?php echo implode ( ' ' , $input_props ); ?>>
					<?php if( NULL != $input->placeholder ) { ?>
						<option value=''><?php echo $input->placeholder; ?></option>
					<?php } // if NULL != placeholder ?>
					<?php foreach( $input->options as $value => $label ) { ?>
						<option value="<?php echo $value; ?>" <?php selected( $input->value , $value, true ); ?>>
							<?php echo $label; ?>
						</option>
					<?php } // foreach options ?>
				</select>
			<?php break;
			/**
			* Select 'icons' such as the column selector
			*/
			case 'select-icons' : ?>
				<?php foreach( $input->options as $value => $label ) { ?>
					<label href="" class="hatch-icon-wrapper <?php if( $value == $input->value ) echo 'hatch-active'; ?>" for="<?php echo $input->id .'-' . $value; ?>">
						<span class="icon-<?php echo $value; ?>"></span>
						<span class="hatch-icon-description">
							<?php echo $label; ?>
						</span>
					</label>
					<input type="radio" <?php echo implode ( ' ' , $input_props ); ?> id="<?php echo $input->id .'-' . $value; ?>" value="<?php echo $value; ?>" <?php checked( $input->value , $value , true ); ?> class="hatch-hide" />
				<?php } // foreach options ?>
			<?php break;
			/**
			* Text areas
			*/
			case 'textarea' : ?>
				<textarea <?php echo implode ( ' ' , $input_props ); ?> <?php if( isset( $input->rows ) ) echo 'rows="' . $input->rows . '"'; ?>><?php echo $input->value; ?></textarea>
			<?php break;
			/**
			* Tiny MCE
			*/
			case 'tinymce' : ?>
				<?php wp_editor(
					$input->value ,
					$input->id ,
					array(
						'textarea_name' => $input->name ,
						'textarea_rows' => ( isset( $input->rows ) ) ? $input->rows : 3,
						'teeny' => ( isset( $input->teeny ) ) ? $input->teeny : false
					)
				); ?>
			<?php break;
			/**
			* Image Uploader
			*/
			case 'image' : ?>
				<section class="hatch-image-container">
					<div class="hatch-push-bottom">
						<!-- Remove button -->
						<a class="hatch-image-remove <?php if( !isset( $input->value ) ) echo 'hatch-hide'; ?>" href=""><?php _e( 'Remove' , HATCH_THEME_SLUG ); ?></a>
						<!-- Image -->
						<?php if( isset( $input->value ) ) echo wp_get_attachment_image( $input->value , 'large' ); ?>
					</div>
					<div class="hatch-push-bottom">
						<a href="#" class="hatch-image-upload-button  hatch-button btn-primary btn-full <?php if( isset( $input->value ) && '' != $input->value ) echo 'hatch-has-image'; ?>"
							data-title="<?php _e( 'Select an Image' , HATCH_THEME_SLUG ); ?>"
							data-button_text="<?php _e( 'Use Image' , HATCH_THEME_SLUG ); ?>">
							<?php echo ( isset( $input->label ) ? $input->label : __( 'Upload Image' , HATCH_THEME_SLUG ) ); ?>
						</a>
					</div>
					<?php echo $this->input(
						array(
							'type' => 'hidden',
							'name' => $input->name,
							'id' => $input->id,
							'value' => ( isset( $input->value ) ) ? $input->value : NULL
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
				<button  class="hatch-regular-uploader hatch-button btn-medium" data-title="<?php _e( 'Select a File' , HATCH_THEME_SLUG ); ?>" data-button_text="<?php _e( 'Use File' , HATCH_THEME_SLUG ); ?>"><?php _e( 'Choose a File' , HATCH_THEME_SLUG  ); ?></button>
				<small class="<?php if( !isset( $input->value ) ) echo 'hide'; ?> hatch-file-remove"><?php _e( 'Remove' , HATCH_THEME_SLUG ); ?></small>
				<input type="hidden" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo $input->value; ?>" />
			<?php break;
			/**
			* Background Controller
			*/
			case 'background' :

				// Default to image if we haven't already done so
				if( !isset( $input->value->type ) ) $input_type = 'image'; else $input_type = $input->value->type; ?>

				<div class="hatch-media-controller" id="<?php echo $input->id; ?>-controller">
					<ul class="hatch-section-links hatch-background-selector">
						<li <?php if( 'video' != $input_type ) echo 'class="active"'; ?> data-id="#<?php echo $input->id; ?>" data-type="image"><a href="" class="hatch-icon icon-bgimage-small"><?php _e( 'Background Image' , HATCH_THEME_SLUG ); ?></a></li>
						<li <?php if( 'video' == $input_type ) echo 'class="active"'; ?> data-id="#<?php echo $input->id; ?>" data-type="video"><a href="" class="hatch-icon icon-video-small"><?php _e( 'Background Video' , HATCH_THEME_SLUG ); ?></a></li>
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

					<div class="hatch-controller-elements">

						<!-- Image uploader -->
						<div class="hatch-content <?php if( 'image' == $input_type ) echo 'section-active'; ?>">
							<div class="hatch-form-item">
								<div class="hatch-image-uploader hatch-animate hatch-push-bottom">
									<!-- Remove button -->
									<a class="hatch-image-remove <?php if( !isset( $input->value->image ) ) echo 'hatch-hide'; ?>" href=""><?php _e( 'Remove' , HATCH_THEME_SLUG ); ?></a>

									<!-- Instructions -->
									<p <?php if( isset( $input->value->image ) ) echo 'class="hatch-hide"'; ?>>
										<?php printf( __( 'Drop a file here or %s' , HATCH_THEME_SLUG ) , '<a href="#">select a file.</a>' ); ?>
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
									<?php if( isset( $input->value->image ) ) echo wp_get_attachment_image( $input->value->image , 'large' ); ?>
								</div>
							</div>
							<div class="hatch-row">

								<p class="hatch-form-item">
									<label><?php _e( 'Background Color' , HATCH_THEME_SLUG ); ?></label>
									<?php echo $this->input(
										array(
											'type' => 'color',
											'name' => $input->name . '[image_color]' ,
											'id' => $input->id . 'image-color',
											'value' => ( isset( $input->value->image_color ) ) ? $input->value->image_color : NULL,
										)
									); ?>
								</p>

								<ul class="hatch-checkbox-list">
									<li class="hatch-checkbox">
										<?php echo $this->input(
											array(
												'type' => 'checkbox',
												'name' => $input->name . '[darken]' ,
												'id' => $input->id . '-darken',
												'value' => ( isset( $input->value->darken ) ) ? $input->value->darken : NULL,
												'label' => __( 'Darken to improve readability', HATCH_THEME_SLUG )
											)
										); ?>
									</li>
									<li class="hatch-checkbox">
										<?php echo $this->input(
											array(
												'type' => 'checkbox',
												'name' => $input->name . '[tile_background]' ,
												'id' => $input->id . '-tile_background',
												'value' => ( isset( $input->value->tile_background ) ) ? $input->value->tile_background : NULL,
												'label' => __( 'Tile Background', HATCH_THEME_SLUG )
											)
										); ?>
									</li>
									<li class="hatch-checkbox">
										<?php echo $this->input(
											array(
												'type' => 'checkbox',
												'name' => $input->name . '[fixed_background]' ,
												'id' => $input->id . '-fixed_background',
												'value' => ( isset( $input->value->fixed_background ) ) ? $input->value->fixed_background : NULL,
												'label' => __( 'Fixed Background', HATCH_THEME_SLUG )
											)
										); ?>
									</li>
								</ul>
							</div>
						</div>

						<!-- Video uploader -->
						<div class="hatch-content <?php if( 'video' == $input->value->type ) echo 'section-active'; ?>">
							<p class="hatch-form-item">
								<label><?php _e( 'Enter your .mp4 link' , HATCH_THEME_SLUG ); ?></label>
								<?php echo $this->input(
									array(
										'type' => 'upload',
										'name' => $input->name . '[mp4]' ,
										'id' => $input->id . '-mp4',
										'value' => ( isset( $input->value->mp4 ) ) ? $input->value->mp4 : NULL
									)
								); ?>
							</p>
							<p class="hatch-form-item">
								<label><?php _e( 'Enter your .ogv link' , HATCH_THEME_SLUG ); ?></label>
								<?php echo $this->input(
									array(
										'type' => 'upload',
										'name' => $input->name . '[ogv]' ,
										'id' => $input->id . '-ogv',
										'value' => ( isset( $input->value->ogv ) ) ? $input->value->ogv : NULL
									)
								); ?>
							</p>
							<div class="hatch-row">
								<p class="hatch-form-item hatch-no-push-bottom">
									<label><?php _e( 'Background Color' , HATCH_THEME_SLUG ); ?></label>
									<?php echo $this->input(
										array(
											'type' => 'color',
											'name' => $input->name . '[video_color]' ,
											'id' => $input->id . '-video-color',
											'value' => ( isset( $input->value->video_color ) ) ? $input->value->video_color : NULL,
										)
									); ?>
								</p>

								<ul class="hatch-checkbox-list">
									<li class="hatch-checkbox">
										<?php echo $this->input(
											array(
												'type' => 'checkbox',
												'name' => $input->name . '[video_darken]' ,
												'id' => $input->id . '-video_darken',
												'value' => ( isset( $input->value->video_darken ) ) ? $input->value->video_darken : NULL,
												'label' => __( 'Darken to improve readability', HATCH_THEME_SLUG )
											)
										); ?>
									</li>
									<li class="hatch-checkbox">
										<?php echo $this->input(
											array(
												'type' => 'checkbox',
												'name' => $input->name . '[video_tile_background]' ,
												'id' => $input->id . '-video_tile_background',
												'value' => ( isset( $input->value->video_tile_background ) ) ? $input->value->video_tile_background : NULL,
												'label' => __( 'Tile Background', HATCH_THEME_SLUG )
											)
										); ?>
									</li>
									<li class="hatch-checkbox">
										<?php echo $this->input(
											array(
												'type' => 'checkbox',
												'name' => $input->name . '[video_fixed_background]' ,
												'id' => $input->id . '-video_fixed_background',
												'value' => ( isset( $input->value->video_fixed_background ) ) ? $input->value->video_fixed_background : NULL,
												'label' => __( 'Fixed Background', HATCH_THEME_SLUG )
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
				<input type="hidden" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo $input->value; ?>" class="hatch-color-selector" />
			<?php break;
			/**
			* Default to hidden field
			*/
			default : ?>
				<input type="hidden" <?php echo implode ( ' ' , $input_props ); ?> value="<?php echo $input->value; ?>" />
		<?php }

	}

}