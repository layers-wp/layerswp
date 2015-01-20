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
    * @param    varchar     $type       Sidebar type, side/top
    * @param    array       $this->widget     Widget object (for name, id, etc)
    * @param    array       $instance   Widget $instance
    * @param    array       $components Array of standard components to support
    * @param    array       $custom_components Array of custom components and elements
    */

    public function __construct( $type = 'side' , $widget = NULL, $instance = array(), $components = array( 'columns' , 'background' , 'imagealign' ) , $custom_components = array() ) {

        // Initiate Widget Inputs
        $this->form_elements = new Layers_Form_Elements();

        // If there is no widget information provided, can the operation
        if( NULL == $widget ) return;
        $this->widget = $widget;

        // Set type side | top
        $this->type = $type;

        // Set widget values as an object ( we like working with objects )
        if( empty( $instance ) ) {
            $this->values = array( 'design' => NULL );
        } elseif( isset( $instance[ 'design' ] ) ) {
            $this->values = $instance[ 'design' ];
        } else {
            $this->values = NULL;
        }

        // Setup the components for use
        $this->components = $components;
        $this->custom_components = $custom_components;

        // Setup the controls
        $this->setup_controls();

        // Fire off the design bar
        $this->render_design_bar();

    }

    function render_design_bar() {

        $container_class = ( 'side' == $this->type ? 'layers-pull-right' : 'layers-visuals-horizontal' ); ?>

        <div class="layers-visuals <?php echo $container_class; ?>">
            <h6 class="layers-visuals-title">
                <span class="icon-settings layers-small"></span>
            </h6>
            <ul class="layers-visuals-wrapper layers-clearfix">

                <?php // Render Design Controls
                $this->render_controls(); ?>

                <?php // Show trash icon (for use when in an accordian)
                $this->render_trash_control(); ?>
            </ul>
        </div>
    <?php }

    private function setup_controls() {

        $this->controls = array();

        if( NULL !== $this->components ) {
            foreach( $this->components as $c ) {
                if( 'custom' == $c && !empty( $this->custom_components ) ) {
                    foreach ( $this->custom_components as $key => $custom_component_args ) {
                        ob_start();

                        $this->custom_component(
                            $key, // Give the component a key (will be used as class name too)
                            $custom_component_args // Send through the inputs that will be used
                        );

                        $this->controls[] = trim( ob_get_contents() );
                        ob_end_clean();

                    }
                } elseif ( is_array( $c ) ) {
                    foreach( $c as $key => $args ) {
                        ob_start();

                        $this->$component( $args );

                        $this->controls[] = trim( ob_get_contents() );
                        ob_end_clean();
                    }
                } elseif ( 'custom' != $c ) {
                    ob_start();

                    $this->$c();

                    $this->controls[] = trim( ob_get_contents() );
                    ob_end_clean();
                }
            }
        } // if $components is not NULL

    }

    private function render_controls(){

        // If there are no controls to render, do nothing
        if( empty( $this->controls ) ) return;

        echo implode( '', $this->controls );
    }

    /**
    * Custom Compontent
    *
    * @param    varchar     $key        Simply the key and classname for the icon,
    * @param    array       $args       Component arguments, including the form items
    */

    function render_control( $key = NULL, $args = array() ){

        if( empty( $args ) ) return;

        // Setup variables from $args
        $icon_css = $args[ 'icon-css' ];
        $label = $args[ 'label' ];
        $menu_wrapper_class = ( isset( $args[ 'wrapper-class' ] ) ? $args[ 'wrapper-class' ] : 'layers-pop-menu-wrapper layers-content-small' );

        // Return filtered element array
        $elements = apply_filters( 'layers_design_bar_' . $key . '_elements', $args[ 'elements' ] ); ?>

        <li class="layers-visuals-item">
            <a href="" class="layers-icon-wrapper">
                <span class="<?php echo $icon_css; ?>"></span>
                <span class="layers-icon-description">
                    <?php echo $label; ?>
                </span>
            </a>
            <?php if( isset( $args['elements'] ) ) { ?>
                <div class="<?php echo $menu_wrapper_class; ?>">
                    <div class="layers-pop-menu-setting">
                        <?php foreach( $args['elements'] as $key => $form_args ) { ?>
                           <?php echo $this->render_input( $form_args ); ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } // if we have elements ?>
        </li>
    <?php }

    private function render_trash_control(){
        if( isset( $this->widget['show_trash'] ) ) { ?>
        <li class="layers-visuals-item layers-pull-right">
            <a href="" class="layers-icon-wrapper layers-icon-error">
                <span class="icon-trash" data-number="<?php echo $this->widget['number']; ?>"></span>
            </a>
        </li>
    <?php }
    }


    /**
    * Load input HTML
    *
    * @param    array       $array()    Existing option array if exists (optional)
    * @return   array       $array      Array of options, all standard DOM input options
    */

    public function render_input( $form_args = array() ) { ?>
		<div class="layers-<?php echo $form_args[ 'type' ]; ?>-wrapper layers-form-item">
	        <?php if( 'checkbox' != $form_args[ 'type' ] && isset( $form_args[ 'label' ] ) && '' != $form_args[ 'label' ] ) { ?>
	            <label><?php echo $form_args[ 'label' ]; ?></label>
	        <?php } ?>

			<?php if( isset( $form_args[ 'wrapper' ] ) ) { ?>
				<<?php echo $form_args[ 'wrapper' ]; ?> <?php if( $form_args[ 'wrapper-class' ] ) echo 'class="' . $form_args[ 'wrapper-class' ] . '"'; ?>>
			<?php } ?>

	        <?php echo $this->form_elements->input( $form_args ); ?>

			<?php if( isset( $form_args[ 'wrapper' ] ) ) { ?>
				</<?php echo $form_args[ 'wrapper' ]; ?>>
			<?php } ?>
	    </div>
    <?php }

    /**
    * Layout Options
    *
    * @param    array       $args       Additional arguments to pass to this function
    */

    function layout( $args = NULL ){

        // If there is no widget information provided, can the operation
        if( NULL == $this->widget ) return;

        // Set a key for this input
        $key = 'layout';

        // Setup icon CSS
        $args[ 'icon-css' ] = ( isset( $this->values['layout'] ) && NULL != $this->values ? 'icon-' . $this->values['layout'] : 'icon-layout-fullwidth' ) ;

        // Add a Label
        $args[ 'label' ] = __( 'Layout' , LAYERS_THEME_SLUG );

        // Add a Wrapper Class
        $args[ 'wrapper-class' ] = 'layers-pop-menu-wrapper layers-animate layers-small';

        // Add elements
        $args[ 'elements' ] = array(
                            'layout' => array(
                                'type' => 'select-icons',
                                'name' => $this->widget['name'] . '[layout]' ,
                                'id' =>  $this->widget['id'] . '-layout' ,
                                'value' => ( isset( $this->values['layout'] ) ) ? $this->values['layout'] : NULL,
                                'options' => array(
                                    'layout-boxed' => __( 'Boxed' , LAYERS_THEME_SLUG ),
                                    'layout-fullwidth' => __( 'Full Width' , LAYERS_THEME_SLUG )
                                )
                            )
                        );

        $this->render_control( $key , $args );
    }

    /**
    * List Style - Static Option
    *
    * @param    array       $args       Additional arguments to pass to this function
    */

    function liststyle( $args = NULL ){

        // If there is no widget information provided, can the operation
        if( NULL == $this->widget ) return;

        // Set a key for this input
        $key = 'liststyle';

        // Setup icon CSS
        $args[ 'icon-css' ] = ( isset( $this->values['liststyle'] ) && NULL != $this->values ? 'icon-' . $this->values['liststyle'] : 'icon-list-masonry' );

        // Add a Label
        $args[ 'label' ] = __( 'List Style' , LAYERS_THEME_SLUG );

        // Add a Wrapper Class
        $args[ 'wrapper-class' ] = 'layers-pop-menu-wrapper layers-animate layers-small';

        // Add elements
        $args[ 'elements' ] = array(
                            'liststyle' => array(
                                'type' => 'select-icons',
                                'name' => $this->widget['name'] . '[liststyle]' ,
                                'id' =>  $this->widget['id'] . '-liststyle' ,
                                'value' => ( isset( $this->values[ 'liststyle' ] ) ) ? $this->values[ 'liststyle' ] : NULL,
                                'options' => array(
                                    'list-grid' => __( 'Grid' , LAYERS_THEME_SLUG ),
                                    'list-list' => __( 'List' , LAYERS_THEME_SLUG ),
                                    'list-masonry' => __( 'Masonry' , LAYERS_THEME_SLUG )
                                )
                            )
                        );

        $this->render_control( $key , $args );
    }

    /**
    * Columns - Static Option
    *
    * @param    array       $args       Additional arguments to pass to this function
    */

    function columns( $args = NULL ){

        // If there is no widget information provided, can the operation
        if( NULL == $this->widget ) return;

        // Set a key for this input
        $key = 'columns';

        // Setup icon CSS
        $args[ 'icon-css' ] = ( isset( $this->values['columns'] ) && NULL != $this->values ? 'icon-' . $this->values['columns'] : 'icon-columns' );

        // Add a Label
        $args[ 'label' ] = __( 'Columns' , LAYERS_THEME_SLUG );

        // Add a Wrapper Class
        $args[ 'wrapper-class' ] = 'layers-pop-menu-wrapper layers-animate layers-small';

        // Add elements
        $args[ 'elements' ] = array(
                            'columns' => array(
                                'type' => 'select',
                                'label' => __( 'Columns' , LAYERS_THEME_SLUG ),
                                'name' => $this->widget['name'] . '[columns]' ,
                                'id' =>  $this->widget['id'] . '-columns' ,
                                'value' => ( isset( $this->values['columns'] ) ) ? $this->values['columns'] : NULL,
                                'options' => array(
                                    '1' => __( '1 Column' , LAYERS_THEME_SLUG ),
                                    '2' => __( '2 Columns' , LAYERS_THEME_SLUG ),
                                    '3' => __( '3 Columns' , LAYERS_THEME_SLUG ),
                                    '4' => __( '4 Columns' , LAYERS_THEME_SLUG ),
                                    '6' => __( '6 Columns' , LAYERS_THEME_SLUG )
                                )
                            ),
                            'gutter' => array(
                                'type' => 'checkbox',
                                'label' => __( 'Gutter' , LAYERS_THEME_SLUG ),
                                'name' => $this->widget['name'] . '[gutter]' ,
                                'id' =>  $this->widget['id'] . '-gutter' ,
                                'value' => ( isset( $this->values['gutter'] ) ) ? $this->values['gutter'] : NULL
                            )
                        );

        $this->render_control( $key , $args );
    }

    /**
    * Text Align - Static Option
    *
    * @param    array       $args       Additional arguments to pass to this function
    */

    function textalign( $args = NULL ){

        // If there is no widget information provided, can the operation
        if( NULL == $this->widget ) return;

        // Set a key for this input
        $key = 'textalign';

        // Setup icon CSS
        $args[ 'icon-css' ] = ( isset( $this->values['textalign'] ) && NULL != $this->values ? 'icon-' . $this->values['textalign'] : 'icon-text-center' );

        // Add a Label
        $args[ 'label' ] = __( 'Text Align' , LAYERS_THEME_SLUG );

        // Add a Wrapper Class
        $args[ 'wrapper-class' ] = 'layers-pop-menu-wrapper layers-animate layers-content-small';

        // Add elements
        $args[ 'elements' ] = array(
                            'textalign' => array(
                                'type' => 'select-icons',
                                'name' => $this->widget['name'] . '[textalign]' ,
                                'id' =>  $this->widget['id'] . '-textalign' ,
                                'value' => ( isset( $this->values['textalign'] ) ) ? $this->values['textalign'] : NULL,
                                'options' => array(
                                    'text-left' => __( 'Left' , LAYERS_THEME_SLUG ),
                                    'text-center' => __( 'Center' , LAYERS_THEME_SLUG ),
                                    'text-right' => __( 'Right' , LAYERS_THEME_SLUG ),
                                    'text-justify' => __( 'Justify' , LAYERS_THEME_SLUG )
                                )
                            )
                        );

        $this->render_control( $key , $args );
    }

    /**
    * Image Align - Static Option
    *
    * @param    array       $args       Additional arguments to pass to this function
    */

    function imagealign( $args = NULL ){

        // If there is no widget information provided, can the operation
        if( NULL == $this->widget ) return;

        // Set a key for this input
        $key = 'imagealign';

        // Setup icon CSS
        $args[ 'icon-css' ] = ( isset( $this->values['imagealign'] ) && NULL != $this->values ? 'icon-' . $this->values['imagealign'] : 'icon-image-left' );

        // Add a Label
        $args[ 'label' ] = __( 'Image Align' , LAYERS_THEME_SLUG );

        // Add a Wrapper Class
        $args[ 'wrapper-class' ] = 'layers-pop-menu-wrapper layers-animate layers-small';

        // Add elements
        $args[ 'elements' ] = array(
                            'imagealign' => array(
                                'type' => 'select-icons',
                                'name' => $this->widget['name'] . '[imagealign]' ,
                                'id' =>  $this->widget['id'] . '-imagealign' ,
                                'value' => ( isset( $this->values['imagealign'] ) ) ? $this->values['imagealign'] : NULL,
                                'options' => array(
                                    'image-left' => __( 'Left' , LAYERS_THEME_SLUG ),
                                    'image-right' => __( 'Right' , LAYERS_THEME_SLUG ),
                                    'image-top' => __( 'Top' , LAYERS_THEME_SLUG )
                                )
                            ),
                        );

        $this->render_control( $key , $args );
    }

    /**
    * Featured Image - Static Option
    *
    * @param    array       $args       Additional arguments to pass to this function
    */

    function featuredimage( $args = NULL ){

        // If there is no widget information provided, can the operation
        if( NULL == $this->widget ) return;

        // Set a key for this input
        $key = 'featuredimage';

        // Setup icon CSS
        $args[ 'icon-css' ] = 'icon-featured-image';

        // Add a Label
        $args[ 'label' ] = __( 'Featured Image' , LAYERS_THEME_SLUG );

        // Add a Wrapper Class
        $args[ 'wrapper-class' ] = 'layers-pop-menu-wrapper layers-animate layers-content-small';

        // Add elements
        $args[ 'elements' ] = array(
                            'featuredimage' => array(
                                'type' => 'image',
                                'label' => __( 'Featured Image' , LAYERS_THEME_SLUG ),
                                'name' => $this->widget['name'] . '[featuredimage]' ,
                                'id' =>  $this->widget['id'] . '-featuredimage' ,
                                'value' => ( isset( $this->values['featuredimage'] ) ) ? $this->values['featuredimage'] : NULL
                            ),
                            'featuredvideo' => array(
                                'type' => 'text',
                                'label' => __( 'Video Embed Code' , LAYERS_THEME_SLUG ),
                                'name' => $this->widget['name'] . '[featuredvideo]' ,
                                'id' =>  $this->widget['id'] . '-featuredvideo' ,
                                'value' => ( isset( $this->values['featuredvideo'] ) ) ? $this->values['featuredvideo'] : NULL
                            ),
                            'imageratios' => array(
                                'type' => 'select-icons',
                                'name' => $this->widget['name'] . '[imageratios]' ,
                                'id' =>  $this->widget['id'] . '-imageratios' ,
                                'value' => ( isset( $this->values['imageratios'] ) ) ? $this->values['imageratios'] : NULL,
                                'options' => array(
                                    'image-portrait' => __( 'Portrait' , LAYERS_THEME_SLUG ),
                                    'image-landscape' => __( 'Landscape' , LAYERS_THEME_SLUG ),
                                    'image-square' => __( 'Square' , LAYERS_THEME_SLUG ),
                                    'image-no-crop' => __( 'None' , LAYERS_THEME_SLUG ),
                                    'image-round' => __( 'Round' , LAYERS_THEME_SLUG ),
                                ),
                                'wrapper' => 'div',
                                'wrapper-class' => 'layers-icon-group'
                            ),
                        );

        $this->render_control( $key , $args );
    }

    /**
    * Image Size - Static Option
    *
    * @param    array       $args       Additional arguments to pass to this function
    */

    function imageratios( $args = NULL ){

        // If there is no widget information provided, can the operation
        if( NULL == $this->widget ) return;

        // Set a key for this input
        $key = 'imageratios';

        // Setup icon CSS
        $args[ 'icon-css' ] = ( isset( $this->values['imageratios'] ) && NULL != $this->values ? 'icon-' . $this->values['imageratios'] : 'icon-image-size' );

        // Add a Label
        $args[ 'label' ] = __( 'Image Ratio' , LAYERS_THEME_SLUG );

        // Add a Wrapper Class
        $args[ 'wrapper-class' ] = 'layers-pop-menu-wrapper layers-animate layers-small';

        // Add elements
        $args[ 'elements' ] = array(
                            'imageratio' => array(
                                'type' => 'select-icons',
                                'name' => $this->widget['name'] . '[imageratios]' ,
                                'id' =>  $this->widget['id'] . '-imageratios' ,
                                'value' => ( isset( $this->values['imageratios'] ) ) ? $this->values['imageratios'] : NULL,
                                'options' => array(
                                    'image-portrait' => __( 'Portrait' , LAYERS_THEME_SLUG ),
                                    'image-landscape' => __( 'Landscape' , LAYERS_THEME_SLUG ),
                                    'image-square' => __( 'Square' , LAYERS_THEME_SLUG ),
                                    'image-no-crop' => __( 'None' , LAYERS_THEME_SLUG )
                                )
                            ),
                        );

        $this->render_control( $key , $args );
    }

    /**
    * Fonts - Static Option
    *
    * @param    array       $args       Additional arguments to pass to this function
    */

    function fonts( $args = NULL ){

        // If there is no widget information provided, can the operation
        if( NULL == $this->widget ) return;

        // Set a key for this input
        $key = 'fonts';

        // Setup icon CSS
        $args[ 'icon-css' ] = 'icon-font-size';

        // Add a Label
        $args[ 'label' ] = __( 'Text' , LAYERS_THEME_SLUG );

        // Add a Wrapper Class
        $args[ 'wrapper-class' ] = 'layers-pop-menu-wrapper layers-animate layers-content-small';

        // Add elements
        $args[ 'elements' ] = array(
                            'fonts-align' => array(
                                'type' => 'select-icons',
                                'label' => __( 'Text Align' , LAYERS_THEME_SLUG ),
                                'name' => $this->widget['name'] . '[fonts][align]',
                                'id' =>  $this->widget['id'] . '-fonts-align',
                                'value' => ( isset( $this->values['fonts']['align'] ) ) ? $this->values['fonts']['align'] : NULL,
                                'options' => array(
                                    'text-left' => __( 'Left' , LAYERS_THEME_SLUG ),
                                    'text-center' => __( 'Center' , LAYERS_THEME_SLUG ),
                                    'text-right' => __( 'Right' , LAYERS_THEME_SLUG ),
                                    'text-justify' => __( 'Justify' , LAYERS_THEME_SLUG )
                                ),
                                'wrapper' => 'div',
                                'wrapper-class' => 'layers-icon-group'
                            ),
                           'fonts-size' => array(
                                'type' => 'select',
                                'label' => __( 'Text Size' , LAYERS_THEME_SLUG ),
                                'name' => $this->widget['name'] . '[fonts][size]' ,
                                'id' =>  $this->widget['id'] . '-fonts-size' ,
                                'value' => ( isset( $this->values['fonts']['size'] ) ) ? $this->values['fonts']['size'] : NULL,
                                'options' => array(
                                        'small' => __( 'Small' , LAYERS_THEME_SLUG ),
                                        'medium' => __( 'Medium' , LAYERS_THEME_SLUG ),
                                        'large' => __( 'Large' , LAYERS_THEME_SLUG )
                                )
                            ),
                            'fonts-color' => array(
                                'type' => 'color',
                                'name' => $this->widget['name'] . '[fonts][color]' ,
                                'id' =>  $this->widget['id'] . '-fonts-color' ,
                                'value' => ( isset( $this->values['fonts']['color'] ) ) ? $this->values['fonts']['color'] : NULL
                            )
                        );

        $this->render_control( $key , $args );
    }

    /**
    * Background - Static Option
    *
    * @param    array       $args       Additional arguments to pass to this function
    */

    function background( $args = NULL ){

        // If there is no widget information provided, can the operation
        if( NULL == $this->widget ) return;

        // Set a key for this input
        $key = 'background';

        // Setup icon CSS
        $args[ 'icon-css' ] = 'icon-photo';

        // Add a Label
        $args[ 'label' ] = __( 'Background' , LAYERS_THEME_SLUG );

        // Add elements
        $args[ 'elements' ] = array(
                            'background-image' => array(
                                'type' => 'image',
                                'label' => __( 'Image' , LAYERS_THEME_SLUG ),
                                'button_label' => __( 'Choose Image' , LAYERS_THEME_SLUG ),
                                'name' => $this->widget['name'] . '[background][image]' ,
                                'id' =>  $this->widget['id'] . '-background-image' ,
                                'value' => ( isset( $this->values['background']['image'] ) ) ? $this->values['background']['image'] : NULL
                            ),
                            'background-color' => array(
                                'type' => 'color',
                                'label' => __( 'Color' , LAYERS_THEME_SLUG ),
                                'name' => $this->widget['name'] . '[background][color]' ,
                                'id' =>  $this->widget['id'] . '-background-color' ,
                                'value' => ( isset( $this->values['background']['color'] ) ) ? $this->values['background']['color'] : NULL
                            ),
                            'background-repeat' => array(
                                'type' => 'select',
                                'label' => __( 'Repeat' , LAYERS_THEME_SLUG ),
                                'name' => $this->widget['name'] . '[background][repeat]' ,
                                'id' =>  $this->widget['id'] . '-background-repeat' ,
                                'value' => ( isset( $this->values['background']['repeat'] ) ) ? $this->values['background']['repeat'] : NULL,
                                'options' => array(
                                        'no-repeat' => __( 'No Repeat' , LAYERS_THEME_SLUG ),
                                        'repeat' => __( 'Repeat' , LAYERS_THEME_SLUG ),
                                        'repeat-x' => __( 'Repeat Horizontal' , LAYERS_THEME_SLUG ),
                                        'repeat-y' => __( 'Repeat Vertical' , LAYERS_THEME_SLUG )
                                    )
                            ),
                            'background-position' => array(
                                'type' => 'select',
                                'label' => __( 'Position' , LAYERS_THEME_SLUG ),
                                'name' => $this->widget['name'] . '[background][position]' ,
                                'id' =>  $this->widget['id'] . '-background-position' ,
                                'value' => ( isset( $this->values['background']['position'] ) ) ? $this->values['background']['position'] : NULL,
                                'options' => array(
                                        'center' => __( 'Center' , LAYERS_THEME_SLUG ),
                                        'top' => __( 'Top' , LAYERS_THEME_SLUG ),
                                        'bottom' => __( 'Bottom' , LAYERS_THEME_SLUG ),
                                        'left' => __( 'Left' , LAYERS_THEME_SLUG ),
                                        'right' => __( 'Right' , LAYERS_THEME_SLUG )
                                    )
                            ),
                            'background-stretch' => array(
                                'type' => 'checkbox',
                                'label' => __( 'Stretch' , LAYERS_THEME_SLUG ),
                                'name' => $this->widget['name'] . '[background][stretch]' ,
                                'id' =>  $this->widget['id'] . '-background-stretch' ,
                                'value' => ( isset( $this->values['background']['stretch'] ) ) ? $this->values['background']['stretch'] : NULL
                            ),
                            'background-darken' => array(
                                'type' => 'checkbox',
                                'label' => __( 'Darken' , LAYERS_THEME_SLUG ),
                                'name' => $this->widget['name'] . '[background][darken]' ,
                                'id' =>  $this->widget['id'] . '-background-darken' ,
                                'value' => ( isset( $this->values['background']['darken'] ) ) ? $this->values['background']['darken'] : NULL
                            )
                        );

        $this->render_control( $key , $args );
    }

    /**
    * Advanced - Static Option
    *
    * @param    array       $args       Additional arguments to pass to this function
    */

    function advanced( $args = NULL ){

        // If there is no widget information provided, can the operation
        if( NULL == $this->widget ) return;

        // Set a key for this input
        $key = 'advanced';

        // Setup icon CSS
        $args[ 'icon-css' ] = 'icon-settings';

        // Add a Label
        $args[ 'label' ] = __( 'Advanced' , LAYERS_THEME_SLUG );

        // Add elements
        $args[ 'elements' ] = array(
                            'customclass' => array(
                                'type' => 'text',
                                'name' => $this->widget['name'] . '[advanced][customclass]' ,
                                'id' =>  $this->widget['id'] . '-advanced-customclass' ,
                                'value' => ( isset( $this->values['advanced']['customclass'] ) ) ? $this->values['advanced']['customclass'] : NULL,
                                'placeholder' => 'example-class'
                            ),
                            'customcss' => array(
                                'type' => 'textarea',
                                'name' => $this->widget['name'] . '[advanced][customcss]' ,
                                'id' =>  $this->widget['id'] . '-advanced-customcss' ,
                                'value' => ( isset( $this->values['advanced']['customcss'] ) ) ? $this->values['advanced']['customcss'] : NULL,
                                'placeholder' => ".classname {\n\tbackground: #333;\n}"
                            )
                        );

        $this->render_control( $key , $args );
    }

    /**
    * Custom Compontent
    *
	* @param    varchar     $key        Simply the key and classname for the icon,
    * @param    array       $args       Component arguments, including the form items
    */

    function custom_component( $key = NULL, $args = array() ){

        if( empty( $args ) ) return;

        // If there is no widget information provided, can the operation
        if( NULL == $this->widget ) return;

        // Render Control
        $this->render_control( $key , $args );
    }
} //class Layers_Design_Controller