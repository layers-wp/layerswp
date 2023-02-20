<?php
/**
 * Layers Widget Class
 *
 * This file is used to register the base layers widget Class
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Widget' ) ) {
	class Layers_Widget extends WP_Widget {

		public $layers_widget_classname;

		public $field_attribute_prefixes;

		public $item_count;

		public $inline_css;

        public $animation_class = 'x-fade-in-up';

		public $support_lightbox = false;

		public $custom_fonts = array();

		//  Defaults

		public $defaults = array();

		public $merge_defaults = array();

		public $merge_repeater_defaults = array();

		/**
		* If there is inline CSS back it up while we run this widget
		*
		*/

		function backup_inline_css(){

			global $layers_inline_css;

			$this->old_inline_css = $layers_inline_css;

			$layers_inline_css = '';
			$this->inline_css = '';
		}
		
		
		/**
         * If an animation class is specified in the class then apply the class
         *
		 * @param $instance
		 *
		 * @return string
		 */
		public function get_animation_class($instance) {
			
			global $wp_customize;

		    if (
                TRUE === $this->check_and_return( $instance , 'design', 'advanced', 'animation' ) &&
                strlen($this->animation_class) !== 0 &&
                !$wp_customize
            ) {
		       return 'do-animate delay-200 translucent animated-1s ' . $this->animation_class;
            }
            return '';
        }
		/**
		* If there is inline CSS to print in this widget, do so at the bottom of the widget
		*
		* @return   string   If there is CSS to return, returns the CSS wrapped in a <style> tag
		*/

		function print_inline_css( $widget = array(), $instance = array() ){
			
			global $layers_inline_css, $wp_customize;
			$this->inline_css = apply_filters( 'layers_widget_' . $this->widget_id . '_inline_css', $layers_inline_css, $widget, $instance );

			if( '' !== $this->inline_css ) {
				echo '<style id="layers_widget_' . $this->widget_id . '_inline_css" type="text/css"> /* INLINE WIDGET CSS */
				' . trim( $this->inline_css ) . '
				</style>';
			}

			$layers_inline_css = $this->old_inline_css;

			if( !$wp_customize )
				$this->enqueue_custom_fonts();
		}
		/**
		* Get custom Google font path for use in the inline widget CSS
		*
		* @param $font_family Font family select value from widget
		*
		* @return   string   If there is a font path to return, do so
		*/

		function get_custom_font_uri( $font_family ){

			$all_fonts = layers_get_google_fonts();

			$family = urlencode( $font_family . ':' . join( ',', layers_get_google_font_variants( $font_family, $all_fonts[ $font_family ]['variants'] ) ) );

			$request = '//fonts.googleapis.com/css?family=' . $family;

			return $request;
		}

		function enqueue_custom_fonts(){
			
			if( !isset( $this->custom_fonts ) || ( isset( $this->custom_fonts ) && empty( $this->custom_fonts ) ) ) return;

			// De-dupe the fonts
			$this->custom_fonts = array_unique( $this->custom_fonts );
			$all_fonts = layers_get_google_fonts();
			
			// Validate each font and convert to URL format
			foreach ( $this->custom_fonts as $font ) {
				$font = trim( $font );

				// Verify that the font exists
				if ( array_key_exists( $font, $all_fonts ) ) {
					// Build the family name and variant string (e.g., "Open+Sans:regular,italic,700")
					$family[] = urlencode( $font . ':' . join( ',', layers_get_google_font_variants( $font, $all_fonts[ $font ]['variants'] ) ) );
				}
			}

			// Convert from array to string
			if ( empty( $family ) ) {
				return '';
			} else {
				$request = '//fonts.googleapis.com/css?family=' . implode( '|', $family );
			}

			wp_enqueue_style(
				LAYERS_THEME_SLUG . '-' . $this->widget_id . '-fonts',
				$request,
				array(),
				LAYERS_VERSION
			);
		}

		/**
		* Check option with isset() and echo it out if it exists, if it does not exist, return false
		*
		* @param    array    $instance          Widget Object
		* @param    string   $option          Widget option to check on
		* @param    string   $array_level_1   Array level one to check for (optional)
		* @param    string   $array_level_2   Array level two to check for (optional)
		* @return   string   false if not set, otherwise returns value
		*/
		function check_and_return( $instance = NULL, $option = NULL, $array_level_1 = NULL, $array_level_2 = NULL ){

			// If there is no widget object then bail
			if( NULL == $instance ) return;

			if( ! isset( $instance[$option] ) ){
				return false;
			} else {
				$instance_option = $instance[$option];
			}

			if( NULL != $array_level_1 ){
				if( ! isset( $instance_option[$array_level_1] ) ){
					return false;
				} elseif( '' != $instance_option[$array_level_1] ){
					if( NULL != $array_level_2 ){
						if( ! isset( $instance_option[$array_level_1][$array_level_2] ) ){
							return false;
						} elseif( '' != $instance_option[$array_level_1][$array_level_2] ) {
							return $instance_option[$array_level_1][$array_level_2];
						}
					} elseif( '' != $instance_option[$array_level_1] )  {
						return $instance_option[$array_level_1];
					}
				}
			} elseif( '' != $instance_option ){
				return $instance_option;
			}
		}

		/**
		* This function determines whether or not a widget is boxed or full width
		*
		* @return  	string 	widget layout class
		*/
		function get_widget_layout_class( $instance = NULL ){

			if( NULL == $instance ) return;

			// Setup the layout class for boxed/full width/full screen
			if( 'layout-boxed' == $this->check_and_return( $instance , 'design' , 'layout' ) ) {
				$layout_class = 'container';
			} elseif('layout-full-screen' == $this->check_and_return( $instance , 'design' , 'layout' ) ) {
				$layout_class = 'full-screen';
			} elseif( 'layout-fullwidth' == $this->check_and_return( $instance , 'design' , 'layout' ) ) {
				$layout_class = 'full-width';
			} else {
				$layout_class = '';
			}

			return $layout_class;
		}

		/**
		* Get widget spacing as class names
		*
		* @return   string   Class names.
		*/
		function get_widget_spacing_class( $instance = NULL ){

			if( NULL == $instance ) return;

			// Setup the class for all the kinds of margin and padding
			$classes = array();

			if( $this->check_and_return( $instance , 'design' , 'advanced', 'margin-top' ) ) $classes[] = 'margin-top-' . $this->check_and_return( $instance , 'design' , 'advanced', 'margin-top' );
			if( $this->check_and_return( $instance , 'design' , 'advanced', 'margin-right' ) ) $classes[] = 'margin-right-' . $this->check_and_return( $instance , 'design' , 'advanced', 'margin-right' );
			if( $this->check_and_return( $instance , 'design' , 'advanced', 'margin-bottom' ) ) $classes[] = 'margin-bottom-' . $this->check_and_return( $instance , 'design' , 'advanced', 'margin-bottom' );
			if( $this->check_and_return( $instance , 'design' , 'advanced', 'margin-left' ) ) $classes[] = 'margin-left-' . $this->check_and_return( $instance , 'design' , 'advanced', 'margin-left' );

			if( $this->check_and_return( $instance , 'design' , 'advanced', 'padding-top' ) ) $classes[] = 'padding-top-' . $this->check_and_return( $instance , 'design' , 'advanced', 'padding-top' );
			if( $this->check_and_return( $instance , 'design' , 'advanced', 'padding-right' ) ) $classes[] = 'padding-right-' . $this->check_and_return( $instance , 'design' , 'advanced', 'padding-right' );
			if( $this->check_and_return( $instance , 'design' , 'advanced', 'padding-bottom' ) ) $classes[] = 'padding-bottom-' . $this->check_and_return( $instance , 'design' , 'advanced', 'padding-bottom' );
			if( $this->check_and_return( $instance , 'design' , 'advanced', 'padding-left' ) ) $classes[] = 'padding-left-' . $this->check_and_return( $instance , 'design' , 'advanced', 'padding-left' );

			$classes = implode( ' ', $classes );

			return $classes;
		}

		/**
		* Apply advanced styles to widget instance
		*
		* @param   string   $widget_id   id css selector of widget
		* @param   object   $instance      Widget object to use
		*/

		function apply_widget_advanced_styling( $widget_id, $instance = NULL ){

			// We need a widget to get the settings from
			if( NULL == $instance ) return;

			if( !isset( $this->inline_css ) ) $this->inline_css = '';

			/**
			 * Apply Margin & Padding
			 */
			$types = array( 'margin', 'padding', );
			$fields = array( 'top', 'right', 'bottom', 'left', );

			// Loop the Margin & Padding
			foreach ( $types as $type ) {

				// Get the TopRightBottomLeft TRBL array of values
				$values = $this->check_and_return( $instance , 'design' , 'advanced', $type );

				if( NULL != $values && is_array( $values ) ) {
					foreach ( $fields as $field ) {
						if( isset( $values[ $field ] ) && '' != $values[ $field ] && is_numeric( $values[ $field ] ) ) {

							// If value is set, and is number, then add 'px' to it
							//$values[ $field ] .= 'px';
						}
					}

					// Apply the TRBL styles
					if ( 'padding' == $type && isset( $instance['slides'] ) && 1 <= count( $instance['slides'] ) ){
						$this->inline_css .= layers_inline_styles( "#{$widget_id} .swiper-slide > .content", $type, array( $type => $values ) );
					}
					else{
						$this->inline_css .= layers_inline_styles( "#{$widget_id}", $type, array( $type => $values ) );
					}

				}
			}

			/**
			 * Custom CSS
			 */
			if( $this->check_and_return( $instance, 'design', 'advanced', 'customcss' ) ) $this->inline_css .= layers_inline_styles( NULL, 'css', array( 'css' => $this->check_and_return( $instance, 'design', 'advanced', 'customcss' )  ) );

		}

		/**
		* Design Bar Class Instantiation, we'd rather have it done here than in each widget
		*
		* @return  	html 		Design bar HTML
		*/
		public function design_bar(  $type = 'side' , $widget = NULL, $instance = array(), $components = array( 'columns' , 'background' , 'imagealign' ) , $custom_components = array()  ) {

			// Instantiate design bar
			$design_bar = new Layers_Design_Controller( $type, $widget, $instance, $components, $custom_components );

			// Return design bar
			return $design_bar;

		}

		/**
		* Form Elements Class Instantiation, we'd rather have it done here than in each widget
		*
		* @return  	html 		Design bar HTML
		*/
		public function form_elements() {

			// Instantiate Widget Inputs
			$form_elements = new Layers_Form_Elements();

			// Return design bar
			return $form_elements;

		}

		/**
		* Widget sub-module input name generation, for example see Slider and Content Widgets
		*
		* @param  	object 		$widget_details 	Widget object to use
		* @param  	string 	$level1 	Level 1 name
		* @param  	string 	$level2 	Level 2 name
	 	* @param 	string 		$field_name Field name
	 	* @return 	string 		Name attribute for $field_name
		*/
		function get_custom_field_name( $widget_details = NULL, $level1 = '', $level2 = '', $level3 = '', $level4 = '' ) {

			// If there is no widget object then ignore
			if( NULL == $widget_details ) return;

			$final_field_name = 'widget-' . $widget_details->id_base . '[' . $widget_details->number . ']';

			// Add first level of input string
			if( '' != $level1 ) $final_field_name .= '[' . $level1 . ']';

			// Add second level of input string
			if( '' != $level2 ) $final_field_name .= '[' . $level2 . ']';

			// Add third level of input string
			if( '' != $level3 ) $final_field_name .= '[' . $level3 . ']';

			// Add fourth level of input string
			if( '' != $level4 ) $final_field_name .= '[' . $level4 . ']';

			return $final_field_name;
		}

		/**
		* Widget sub-module input id generation, for example see Slider and Content Widgets
		*
		* @param  	object 		$widget_details 	Widget object to use
		* @param  	string 	$level1 	Level 1 name
		* @param  	string 	$level2 	Level 2 name
	 	* @param 	string 		$field_name Field name
	 	* @return 	string 		Name attribute for $field_name
		*/
		function get_custom_field_id( $widget_details = NULL, $level1 = '', $level2 = '', $level3 = '', $level4 = '' ) {

			// If there is no widget object then ignore
			if( NULL == $widget_details ) return;

			$final_field_id = 'widget-' . $widget_details->id_base . '-' . $widget_details->number;

			// Add first level of input string
			if( '' != $level1 ) $final_field_id .= '-' . $level1;

			// Add second level of input string
			if( '' != $level2 ) $final_field_id .= '-' . $level2;

			// Add third level of input string
			if( '' != $level3 ) $final_field_id .= '-' . $level3;

			// Add fourth level of input string
			if( '' != $level4) $final_field_id .= '-' . $level4;

			return $final_field_id;
		}

		/**
		 * Widget name generation (replaces get_custom_field_id)
		 *
		 * @param    string  $field_name_1   Level 1 name
		 * @param    string  $field_name_2   Level 2 name
	 	 * @param    string  $field_name_3   Level 3 name
	 	 * @param    string  $field_name_4   Level 4 name
	 	 * @return   string  Name attribute
		 */
		function get_layers_field_name( $field_name_1 = '', $field_name_2 = '', $field_name_3 = '', $field_name_4 = '' ) {

			// If we don't have these important widget details then bail.
			if ( ! isset( $this->id_base ) || ! isset( $this->number ) ) return;

			// Compile the first part.
			$string = 'widget-' . $this->id_base . '[' . $this->number . ']';

			// If this is called in e.g. a button_item then by setting $field_attribute_prefixes args array,
			// before it's called the prefixes will be added at this point in the string construction.
			if ( isset( $this->field_attribute_prefixes ) && ! empty( $this->field_attribute_prefixes ) ) {
				$string .= '[' . implode( '][', $this->field_attribute_prefixes ) . ']';
			}

			// Now add any custom strings passed as args.
			if( '' != $field_name_1 ) $string .= '[' . $field_name_1 . ']';
			if( '' != $field_name_2 ) $string .= '[' . $field_name_2 . ']';
			if( '' != $field_name_3 ) $string .= '[' . $field_name_3 . ']';
			if( '' != $field_name_4 ) $string .= '[' . $field_name_4 . ']';

			if ( ( bool ) layers_get_theme_mod( 'dev-switch-widget-field-names' ) ) {
				$debug_replace = 'widget-' . $this->id_base . '[' . $this->number . ']';
				$debug_string = str_replace( $debug_replace, '', $string );
				echo '<span class="layers-widget-defaults-debug">' . $debug_string . '</span><br />';
			}

			return $string;
		}

		/**
		 * Widget id generation (replaces get_custom_field_id)
		 *
		 * @param    string  $field_name_1   Level 1 id
		 * @param    string  $field_name_2   Level 2 id
	 	 * @param    string  $field_name_3   Level 3 id
	 	 * @param    string  $field_name_4   Level 4 id
	 	 * @return   string  Id attribute
		 */
		function get_layers_field_id( $field_name_1 = '', $field_name_2 = '', $field_name_3 = '', $field_name_4 = '' ) {

			// If we don't have these important widget details then bail.
			if ( ! isset( $this->id_base ) || ! isset( $this->number ) ) return;

			// Compile the first part.
			$string = 'widget-' . $this->id_base . '-' . $this->number;

			// If this is called in e.g. a button_item then by setting $field_attribute_prefixes args array,
			// before it's called the prefixes will be added at this point in the string construction.
			if ( isset( $this->field_attribute_prefixes ) && ! empty( $this->field_attribute_prefixes ) ) {
				$string .= '-' . implode( '-', $this->field_attribute_prefixes );
			}

			// Now add any custom strings passed as args.
			if( '' != $field_name_1 ) $string .= '-' . $field_name_1;
			if( '' != $field_name_2 ) $string .= '-' . $field_name_2;
			if( '' != $field_name_3 ) $string .= '-' . $field_name_3;
			if( '' != $field_name_4 ) $string .= '-' . $field_name_4;

			return $string;
		}

		/**
		* Enqueue Masonry When Need Be
		*/
		function enqueue_masonry(){
			wp_enqueue_script( LAYERS_THEME_SLUG . '-layers-masonry-js' );
		}

		/**
		 * Used to initialise repeater defaults
		 *
		 * @param  string   $type            Unique singular slug for the type of repeater. Must just be unique to this widget e.g. button (not buttons)
		 * @param  integer  $count           How many pre-populated elements do you want to start with.
		 * @param  array    $defaults_array  A custom associative array that will become the defaults for each element.
		 * @param  array    $defaults_array  ... (can use any number of consecutive defaults arrays)
		 */
		function register_repeater_defaults( $type, $count = 3, $defaults_array = array() ) {

			// This allows to pass any number of default sets to the repeater, and they will be used in a loop to populate the required number of defaults.
			$count_defaults = func_num_args();
			$i = 2; // Collect all the defaults arrays after the 3rd,including the 3rd.
			$defaults_collection = array();
			while ( $i < $count_defaults ) {
				$defaults_collection[] = func_get_arg( $i );
				$i++;
			}


			// Store the defaults so they can be merged in each time the widget is called.
			// It must be done now before the repeater defaults are merged into the main defaults.

			// Main Defaults.
			if ( empty( $this->merge_defaults ) && isset( $this->defaults ) ) {
				$this->merge_defaults = $this->defaults;
			}

			// Repeater Defaults.
			if ( ! isset( $this->merge_repeater_defaults[$type] ) ) {
				$this->merge_repeater_defaults[$type] = end( $defaults_collection );
			}


			// Create array of random guid's to the specified size.
			$repeat_ids_array = array();
			$i = 0;
			while ( $i < $count ) {
				$repeat_ids_array[] = rand( 1 , 1000 );
				$i++;
			}

			// Store the guid's in a string for the default of the field e.g. button_ids
			$this->defaults["{$type}_ids"] = implode( ',', $repeat_ids_array );

			// Start an empty nested array that will hold the new repeated defaults.
			$this->defaults["{$type}s"] = array();

			// Add a default to each guid element, these will all be the same but are still needed when our defaulting methodology looks for them.
			$i = 0;
			foreach( $repeat_ids_array as $item_id ) {
				$this->defaults["{$type}s"][ $item_id ] = $defaults_collection[$i]; // Save them to our defaults property.
				$i++;
				if ( ! isset( $defaults_collection[$i] ) ) $i = 0; // Set back to 0 so we loop back around.
			}
		}

		/**
		 * Get repeater items defaults
		 *
		 * @param  string   $type           Unique singular slug for the type of repeater. Must just be unique to this widget e.g. button (not buttons)
		 * @param  integer  $guid           The uique ID of the default element.
		 */
		function get_repeater_defaults( $type, $guid = NULL ) {

			// Set blank instance defaults as backup to be safe.
			$instance_defaults = array();

			if ( isset( $this->defaults["{$type}s"][$guid] ) ) {

				// Look for defaults created correctly by the register_repeater_defaults() method, with specific guid's.
				$instance_defaults = $this->defaults["{$type}s"][$guid];
			}
			else if ( isset( $this->defaults["{$type}s"] ) && ! empty( $this->defaults["{$type}s"] ) ) {

				// Look for defaults created correctly by the register_repeater_defaults() method, without specific guid's so just get the first one.
				$instance_defaults = current( $this->defaults["{$type}s"] );
			}

			return $instance_defaults;
		}

		/**
		 * The main function that outputs the repeater form item.
		 *
		 * @param  string  $type      Unique singular slug for the type of repeater. Must just be unique to this widget e.g. button (not buttons).
		 * @param  array   $widget    The widget object.
		 * @param  array   $options   Optional. Options args Array.
		 */
		function repeater( $type, $instance = array(), $options = array() ) {

			// Apply defaults to options.
			$options = wp_parse_args( $options, array(
				'show_add_button' => TRUE,
			) );

			// If we have some items, let's break out their IDs into an array
			if ( isset( $instance["{$type}_ids"] ) && '' !== $instance["{$type}_ids"] ) {
				$items = explode( ',' , $instance["{$type}_ids"] );
			}
			else {
				$items = array();
			}

			// Compile the name of the new item function e.g. column_item.
			$function_name = "{$type}_item";

			// Bail if the new_item method has not been defined in the custom widget class yet.
			if ( ! method_exists( $this, $function_name ) ) return false;

			// Prepare the counter index so we can write the item index to the new_item's.
			$this->item_count = -1;

			// Predefine the $repeater_id that will be used in the id="" attribute in the HTML
			$repeater_id = "{$type}_list_{$this->number}";
			?>
			<div
				id="<?php echo esc_attr( $repeater_id ); ?>"
				class="layers-widget-repeater"
				data-repeater-number="<?php echo esc_attr( $this->number ); ?>"
				data-repeater-type="<?php echo esc_attr( $type ) ?>"
				data-repeater-class="<?php echo esc_attr( get_class( $this ) ); ?>"
				data-repeater-id-base="<?php echo esc_attr( $this->id_base ); ?>"
				>
				<?php
				// This for element is hidden, and will be updated by javascript with the comma separated list of the guid's of the repeater items ordering.
				echo $this->form_elements()->input( array(
					'type'  => 'hidden',
					'name'  => $this->get_layers_field_name( "{$type}_ids" ),
					'id'    => $this->get_layers_field_id( "{$type}_ids" ),
					'value' => ( isset( $instance["{$type}_ids"] ) ) ? $instance["{$type}_ids"] : NULL,
					'class' => 'layers-repeater-input',
				) );
				?>

				<ul id="<?php echo $repeater_id ?>_accordion" class="layers-accordions layers-accordions-sortable layers-sortable" >
					<?php
					// Loop the repeater items.
					if( isset( $items ) && is_array( $items ) ) {

						// This fixes the first-test widgets that had items with singular naming like 'slide' instead of 'slides'.
						if ( isset( $instance["$type"] ) ) { $instance["{$type}s"] = $instance["$type"]; unset( $instance["$type"] ); }

						foreach( $items as $item_guid ) {

							// Last check that this item definitely exists so no error while trying to render it.
							if ( ! isset( $instance["{$type}s"][$item_guid] ) ) continue;

							// Get just the required item part from the widget instance array.
							$item_instance = $instance["{$type}s"][$item_guid];

							// Settings this will add these prefixes to both the get_layers_field_id(),
							// and get_layers_field_name() string construction.
							$this->field_attribute_prefixes = array( "{$type}s", $item_guid );

							// Increment the item count - for use inside the item if needed.
							$this->item_count++;

							// Call the item function.
							$this->$function_name( $item_guid, $item_instance );

							// Remove the extra attributes.
							unset( $this->field_attribute_prefixes );
						}
					}
					?>
				</ul>

				<?php
				// Settings this will add these prefixes to both the get_layers_field_id(),
				// and get_layers_field_name() string construction.
				$this->field_attribute_prefixes = array( "{$type}s", '{{{{guid}}}}' );
				?>
				<script type="text/html" id="tmpl-my-template" class="layers-widget-repeater-template">
					<?php $this->$function_name( '{{{{guid}}}}', array() ); ?>
				</script>
				<?php unset( $this->field_attribute_prefixes ); ?>

				<?php if ( $options['show_add_button'] ) { ?>
					<button class="layers-button btn-full layers-widget-repeater-add-item add-new-widget">
						<?php _e( 'Add New' , 'layerswp' ) ; ?> <?php echo ucfirst( $type ); ?>
					</button>
				<?php } ?>

			</div>
		<?php }

		/**
		 * Helper function to display the repeater title when the Widget first loads.
		 * There's also JS that will update this title as the title input is typed into.
		 *
		 * @param  string $text The existing value of the widget title.
		 * @return string       Formetted title eg ` : Pretty Title...`.
		 */
		public function format_repeater_title( $text ) {

			$text = substr( stripslashes( strip_tags( $text ) ), 0 , 50 ); // Shorten the text to a max character width.
			if ( strlen( $text ) > 50 ) $text .= '...'; // Add `...` if the text is over a certain length.
			if ( $text ) $text = ': ' . $text; // Add ` : ` to the beginning.

			return $text;
		}

		/**
		 * The main function that outputs the repeater form item.
		 *
		 * @param  array   $instance  The widget object. We'll deal with the rest
		 */

		public function custom_anchor( $instance = NULL ){

			if( NULL == $instance ) return;

			if( $this->check_and_return( $instance,  'design', 'advanced', 'anchor' ) ) { ?>
				<a name="<?php echo esc_attr( $this->check_and_return( $instance,  'design', 'advanced', 'anchor' ) ); ?>"></a>
			<?php }
		}

		public function check_and_return_link( $instance, $button_key ) {

			// Fix widget's that were created before dynamic linking structure.
			$instance = $this->convert_legacy_widget_links( $instance, $button_key );

			// Collection.
			$link_array = array();

			// Get the link based on the link type.
			$link_array['type'] = isset( $instance[$button_key]['link_type'] ) ? $instance[$button_key]['link_type'] : '';

			switch ( $link_array['type'] ) {
				case 'post':
						if ( isset( $instance[$button_key]['link_type_post'] ) && is_numeric( $instance[$button_key]['link_type_post'] ) )
							$link_array['link'] = get_permalink( $instance[$button_key]['link_type_post'] );
						else
							$link_array['link'] = '';
					break;

				case 'post_type_archive':
					break;

				case 'taxonomy_archive':
					break;

				case 'custom':
				default:
					$link_array['link'] = isset( $instance[$button_key]['link_type_custom'] ) ? $instance[$button_key]['link_type_custom'] : '';
					break;
			}

			// Get the link_text.
			$link_array['text'] = isset( $instance[$button_key]['link_text'] ) ? $instance[$button_key]['link_text'] : '';

			// Get the link_target.
			$link_array['target'] = isset( $instance[$button_key]['link_target'] ) ? '_blank' : '';

			return $link_array;
		}

		public function convert_legacy_widget_links( $instance, $button_key ) {

			// Convert the Old Widget Format.
			if ( isset( $instance['link'] ) ) {
				$instance[$button_key]['link_type'] = 'custom';
				$instance[$button_key]['link_type_custom'] = $instance['link'];
				unset( $instance['link'] );
			}
			if ( isset( $instance['link_text'] ) ) {
				$instance[$button_key]['link_text'] = $instance['link_text'];
				unset( $instance['link_text'] );
			}

			// Remove New-Old Widget Format.
			if ( isset( $instance['link_type'] ) ) unset( $instance['link_type'] );
			if ( isset( $instance['link_post'] ) ) unset( $instance['link_post'] );
			if ( isset( $instance['link_target'] ) ) unset( $instance['link_target'] );

			return $instance;
		}

		/**
		 * This helper will merge in additional defaults into the defaults of either
		 * the main widget instance, or it's repeater-items (like columns, slides).
		 *
		 * @param    array    $instance Widget instance supplied by WP
		 * @param    string   $item_key Optional - If this is specified it means it must be applied only to the repeater-items (like columns, slides)
		 * @return   array    $instance with the merged in new defaults
		 */
		function apply_defaults( $instance, $item_key = NULL ) {

			// Store the defaults so they can be merged in each time the widget is called.
			// It must be done now before the repeater defaults are merged into the main defaults.
			// This is also done in register_repeater_defaults, but must be done again here,
			// in case this is not a widget with repeater(s).

			// Main Defaults.
			if ( empty( $this->merge_defaults ) && isset( $this->defaults ) ) {
				$this->merge_defaults = $this->defaults;
			}

			if ( $item_key ) {

				// Repeater instance.
				if ( isset( $this->merge_repeater_defaults[$item_key] ) ) {

					return $this->get_defaults( $instance, $this->merge_repeater_defaults[$item_key] );
				}
				if ( isset( $this->merge_repeater_defaults[rtrim( $item_key, 's' )] ) ) {

					return $this->get_defaults( $instance, $this->merge_repeater_defaults[rtrim( $item_key, 's' )] );
				}
			}
			else {

				// Main widget instance.
				return $this->get_defaults( $instance, $this->merge_defaults );
			}
		}

		/**
		 * Helper - Recurring function for checkling and applying additional defaults.
		 */
		function get_defaults( $instance, $defaults ) {

			// Loop through the supplied defaults.
			foreach ( $defaults as $default_key => $default_value ) {

				if ( is_array( $default_value ) ) {

					if ( ! isset( $instance[$default_key] ) ) {
						// This element doesnt even exist in the intance yet so apply the whole branch.
						$instance[$default_key] = $default_value;

					}
					else{
						// Check this branch recurrsively.
						$instance[$default_key] = $this->get_defaults( $instance[$default_key], $default_value );
					}
				}
				else {

					if (
							! isset( $instance[$default_key] ) && // If set means the input has had defaults applied already - hence don't apply.
							! isset( $instance["{$default_key}-CHECKBOX"] ) && // look for sibling '-CHECKBOX' - If exists means the checkbox has had defaults applied already - hence don't apply.
							NULL !== $default_value
						) {

						// Apply the default.
						$instance[$default_key] = $default_value;

					}
				}
			}

			return $instance;
		}

		/**
		 * Helper - takes widget $args['before_widget'], strips out the needed data-attributes,
		 * and returns it as an isolated string. This is enables Partial Widget refresh by
		 * JavascScript in the Customizer preview (Thanks to Weston).
		 */
		function selective_refresh_atts( $args ) {

			$before_widget = isset( $args['before_widget'] ) ? $args['before_widget'] : '' ;

			preg_match_all(
				'/(data-customize-partial-id|data-customize-partial-type|data-customize-partial-placement-context|data-customize-widget-id)=("[^"]*")/i',
				$before_widget,
				$result
			);

			$atts = ( isset( $result[0] ) && is_array( $result[0] ) ) ? implode( ' ', $result[0] ) : '' ;

			echo $atts;
		}

		/**
		 * Display widget featured image
		 *
		 * @param    string   $css_class Optional - Specify the CSS class to apply to the wrapping <div />
		 * @param    array    $instance Widget instance supplied by WP
		 * @return   html 	  Output of the featured media
		 */

		function featured_media( $css_class = '', $instance = array(), $show_link = true ){
		
			if( empty( $instance ) ) return;

			// Set Featured Media
			$featureimage = $this->check_and_return( $instance , 'design' , 'featuredimage' );
			$featurevideo = $this->check_and_return( $instance , 'design' , 'featuredvideo' );

			// Fallback for the column width
			if( !isset( $instance[ 'width' ] ) ) $instance[ 'width' ] = 6;

			// Calculate which cut based on ratio.
			if( $this->check_and_return( $instance, 'design', 'imageratios' ) ){


				// Translate Image Ratio into something usable
				$image_ratio = layers_translate_image_ratios( $this->check_and_return( $instance, 'design', 'imageratios' ) );

				if( 4 >= $instance['width'] && 'layout-fullwidth' != $this->check_and_return( $instance, 'design', 'layout' ) ) $use_image_ratio = $image_ratio . '-medium';

				else $use_image_ratio = $image_ratio . '-large';

			} else {
				if( 4 > $instance['width'] ) $use_image_ratio = 'medium';
				else $use_image_ratio = 'full';
			}

			$media = layers_get_feature_media( $featureimage , $use_image_ratio , $featurevideo );

			// Open in lightbox, this is a Layers Pro feature
			if( $this->check_and_return( $instance, 'design', 'open-lightbox' ) ){

				// Get direct link to image
				$image_link = wp_get_attachment_url( $featureimage );

				// Create link
				$href   = 'href="' . $image_link . '" ';
				$target = '';
			} else {

				// Create link
				$link_array = $this->check_and_return_link( $instance, 'button' );
				$href   = ( $link_array['link'] ) ? 'href="' . esc_url( $link_array['link'] ) . '"' : '';
				$target = ( '_blank' == $link_array['target'] ) ? 'target="_blank"' : '';
			}

			$image_container_class = array();
			$image_container_class[] = $css_class;
			$image_container_class[] = ( 'image-round' == $this->check_and_return( $instance , 'design',  'imageratios' ) ? 'image-rounded' : '' );
			$image_container_class = implode( ' ', $image_container_class );

			if( NULL != $media ) { ?>

				<div class="<?php echo $image_container_class; ?>">
					<?php if (  TRUE == $show_link && '' != $href ) { ?>
						<a <?php echo $href; ?> <?php echo $target; ?>>
							<?php // Output image or video
							echo $media; ?>
						</a>
					<?php } else {
						// Output image or video
						echo $media;
					} ?>
				</div>

			<?php }			
		}

	}
}
