<?php  /**
 * Sidebars Widget
 *
 * This file is used to register and display the Layers - Sidebar widget.
 *
 * @package Layers
 * @since Layers 1.0
 */
if( !class_exists( 'Layers_Sidebar_Widget' ) ) {
    class Layers_Sidebar_Widget extends Layers_Widget {

        /**
        *  Widget variables
        */
        private $widget_title = 'Dynamic Sidebar';
        private $widget_id = 'sidebar';
        private $post_type = '';
        private $taxonomy = '';
        public $checkboxes = array();

        /**
        *  Widget construction
        */
        function Layers_Sidebar_Widget(){
            /* Widget settings. */
            $widget_ops = array( 'classname' => 'obox-layers-' . $this->widget_id .'-widget', 'description' => 'This widget is used to display your ' . $this->widget_title . '.' );

            /* Widget control settings. */
            $control_ops = array( 'width' => LAYERS_WIDGET_WIDTH_LARGE, 'height' => NULL, 'id_base' => LAYERS_THEME_SLUG . '-widget-' . $this->widget_id );

            /* Create the widget. */
            $this->WP_Widget( LAYERS_THEME_SLUG . '-widget-' . $this->widget_id , '(' . LAYERS_THEME_TITLE . ') ' . $this->widget_title . ' Widget', $widget_ops, $control_ops );

            /* Setup Widget Defaults */
            $this->defaults = array (
                'design' => array(
                    'layout' => 'layout-boxed',
                    'columns' => '3',
                    'gutter' => 'on',
                    'background' => array(
                        'position' => 'center',
                        'repeat' => 'no-repeat'
                    ),
                )
            );

            $this->sidebar_defaults = array (
                'width' => '6'
            );

        }

        /**
        *  Widget front end display
        */
        function widget( $args, $instance ) {

            // Turn $args array into variables.
            extract( $args );

            // $instance Defaults
            $instance_defaults = $this->defaults;

            // Active Sidebars
            $sidebars = get_option( 'sidebars_widgets');

            // Parse $instance
            $widget = wp_parse_args( $instance, $instance_defaults );

            // Set the background styling
            if( !empty( $widget['design'][ 'background' ] ) ) layers_inline_styles( $widget_id, 'background', array( 'background' => $widget['design'][ 'background' ] ) );
            if( !empty( $widget['design']['fonts'][ 'color' ] ) ) layers_inline_styles( $widget_id, 'color', array( 'selectors' => array( '.section-title h3.heading' , '.section-title p.excerpt' ) , 'color' => $widget['design']['fonts'][ 'color' ] ) );

            // Output custom css if there is any
            if( !empty( $widget['design']['advanced'][ 'customcss' ] ) ){
                wp_add_inline_style( LAYERS_THEME_SLUG . '-custom-widget-styles', $widget['design']['advanced'][ 'customcss' ] );
            } ?>
            <section class="widget row content-vertical-massive <?php echo $this->check_and_return( $widget , 'design', 'advanced', 'customclass' ) ?>" id="<?php echo $widget_id; ?>">
                <?php if( !empty( $widget['sidebars'] ) ) { ?>
                    <div class="row <?php if('layout-boxed' == $this->check_and_return( $widget , 'design' , 'layout' ) ) echo 'container'; ?> <?php echo $this->check_and_return( $widget , 'design', 'liststyle' ); ?>">
                        <?php $col = 1; ?>
                        <?php foreach ( $widget['sidebars'] as $key => $sidebar) {

                            $sidebar = wp_parse_args( $sidebar, $this->sidebar_defaults );

                            // Set the background styling
                            if( !empty( $sidebar['design'][ 'background' ] ) ) layers_inline_styles( $widget_id . '-' . $key , 'background', array( 'background' => $sidebar['design'][ 'background' ] ) );

                            $span_class = 'span-' . $sidebar[ 'width' ]; ?>

                            <div id="<?php echo $widget_id; ?>-<?php echo $key; ?>" class="column<?php if( !isset( $widget['design'][ 'gutter' ] ) ) echo '-flush'; ?> <?php echo $span_class; ?> <?php if( '' != $this->check_and_return( $sidebar, 'design' , 'background', 'image' ) || '' != $this->check_and_return( $sidebar, 'design' , 'background', 'color' ) ) echo 'content'; ?> layers-masonry-column">
                                <?php dynamic_sidebar( $widget_id . '-' . $key ); ?>
                            </div>
                            <?php $col++; ?>
                        <?php } ?>
                    </div>
                <?php } ?>

            </section>

            <script>
                jQuery(function($){
                    layers_isotope_settings[ '<?php echo $widget_id; ?>' ] = [{
                            itemSelector: '.layers-masonry-column',
                            layoutMode: 'masonry',
                            masonry: {
                                gutter: <?php echo ( isset( $widget['design'][ 'gutter' ] ) ? 20 : 0 ); ?>
                            }
                        }];

                    $('#<?php echo $widget_id; ?>').find('.list-masonry').layers_isotope( layers_isotope_settings[ '<?php echo $widget_id; ?>' ][0] );
                });
            </script>
        <?php }

        /**
        *  Widget update
        */

        function update($new_instance, $old_instance) {

            if ( isset( $this->checkboxes ) ) {
                foreach( $this->checkboxes as $cb ) {
                    if( isset( $old_instance[ $cb ] ) ) {
                        $old_instance[ $cb ] = strip_tags( $new_instance[ $cb ] );
                    }
                } // foreach checkboxes
            } // if checkboxes
            return $new_instance;
        }

        /**
        *  Widget form
        *
        * We use regular HTML here, it makes reading the widget much easier than if we used just php to echo all the HTML out.
        *
        */
        function form( $instance ){

            // $instance Defaults
            $instance_defaults = $this->defaults;

            // If we have information in this widget, then ignore the defaults
            if( !empty( $instance ) ) $instance_defaults = array();

            // Parse $instance
            $instance = wp_parse_args( $instance, $instance_defaults );
            extract( $instance, EXTR_SKIP ); ?>

            <!-- Form HTML Here -->
            <?php $this->design_bar()->bar(
                'side', // CSS Class Name
                array(
                    'name' => $this->get_field_name( 'design' ),
                    'id' => $this->get_field_id( 'design' ),
                ), // Widget Object
                $instance, // Widget Values
                array(
                    'layout',
                    'custom',
                    'background',
                    'advanced'
                ), // Standard Components
                array(
                    'liststyle' => array(
                        'icon-css' => 'icon-list-masonry',
                        'label' => 'List Style',
                        'wrapper-css' => 'layers-small to layers-pop-menu-wrapper layers-animate',
                        'elements' => array(
                            'liststyle' => array(
                                'type' => 'select-icons',
                                'name' => $this->get_field_name( 'design' ) . '[liststyle]' ,
                                'id' =>  $this->get_field_name( 'design-liststyle' ),
                                'value' => ( isset( $design[ 'liststyle' ] ) ) ? $design[ 'liststyle' ] : NULL,
                                'options' => array(
                                    'list-grid' => __( 'Grid' , LAYERS_THEME_SLUG ),
                                    'list-masonry' => __( 'Masonry' , LAYERS_THEME_SLUG )
                                )
                            ),
                            'gutter' => array(
                                'type' => 'checkbox',
                                'label' => __( 'Gutter' , LAYERS_THEME_SLUG ),
                                'name' => $this->get_field_name( 'design' ) . '[gutter]' ,
                                'id' =>  $this->get_field_name( 'design-gutter' ),
                                'value' => ( isset( $design['gutter'] ) ) ? $design['gutter'] : NULL
                            )
                        )
                    )
                )
            ); ?>
            <div class="layers-container-large" id="layers-banner-widget-<?php echo $this->number; ?>">

                <?php $this->form_elements()->header( array(
                    'title' =>'Sidebars',
                    'icon_class' =>'text'
                ) ); ?>

                <section class="layers-accordion-section layers-content">

                    <?php echo $this->form_elements()->input(
                        array(
                            'type' => 'hidden',
                            'name' => $this->get_field_name( 'sidebar_ids' ) ,
                            'id' => 'sidebar_ids_input_' . $this->number,
                            'value' => ( isset( $sidebar_ids ) ) ? $sidebar_ids : NULL
                        )
                    ); ?>

                    <?php // If we have some sidebars, let's break out their IDs into an array
                    if( isset( $sidebar_ids ) && !empty( $sidebar_ids ) ) $sidebars = explode( ',' , $sidebar_ids ); ?>

                    <ul id="sidebar_list_<?php echo $this->number; ?>" class="layers-accordions layers-accordions-sortable layers-sortable" data-id_base="<?php echo $this->id_base; ?>" data-number="<?php echo $this->number; ?>">
                        <?php if( isset( $sidebars ) && is_array( $sidebars ) ) { ?>
                            <?php foreach( $sidebars as $sidebar ) {
                                $this->sidebar_item( array(
                                            'id_base' => $this->id_base ,
                                            'number' => $this->number
                                        ) ,
                                        $sidebar ,
                                        ( isset( $instance[ 'sidebars' ][ $sidebar ] ) ) ? $instance[ 'sidebars' ][ $sidebar ] : NULL );
                            } ?>
                        <?php }?>
                        <li class="layers-button btn-primary layers-add-widget-sidebar" data-number="<?php echo $this->number; ?>"><?php _e( '+ Add New Column' , LAYERS_THEME_SLUG ) ; ?></li>
                    </ul>
                </section>
            </div>

        <?php } // Form

        function sidebar_item( $widget_details = array() , $sidebar_guid = NULL , $instance = NULL ){

            // Extract Instance if it's there so that we can use the values in our inputs

            // $instance Defaults
            $instance_defaults = $this->sidebar_defaults;

            // Parse $instance
            $instance = wp_parse_args( $instance, $instance_defaults );
            extract( $instance, EXTR_SKIP );

            // If there is no GUID create one. There should always be one but this is a fallback
            if( ! isset( $sidebar_guid ) ) $sidebar_guid = rand( 1 , 1000 );


            // Turn the widget details into an object, it makes the code cleaner
            $widget_details = (object) $widget_details;

            // Set a count for each row
            if( !isset( $this->sidebar_item_count ) ) {
                $this->sidebar_item_count = 0;
            } else {
                $this->sidebar_item_count++;
            } ?>

                <li class="layers-accordion-item" data-guid="<?php echo $sidebar_guid; ?>">
                    <a class="layers-accordion-title">
                        <span>
                            <?php _e( 'Column' , LAYERS_THEME_SLUG ); ?><span class="layers-detail"><?php echo ( isset( $title ) ? ': ' . $title : NULL ); ?></span>
                        </span>
                    </a>
                    <section class="layers-accordion-section layers-content">
                        <?php $this->design_bar()->bar(
                            'top', // CSS Class Name
                            array(
                                'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][sidebars][' . $sidebar_guid . '][design]',
                                'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $sidebar_guid . '-design',
                                'number' => $widget_details->number,
                                'show_trash' => true
                            ), // Widget Object
                            $instance, // Widget Values
                            array(
                                'background',
                                'custom',
                            ), // Standard Components
                            array(
                                'width' => array(
                                    'icon-css' => 'icon-columns',
                                    'label' => 'Column Width',
                                    'elements' => array(
                                        'layout' => array(
                                            'type' => 'select',
                                            'label' => __( '', LAYERS_THEME_SLUG ),
                                            'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][sidebars][' . $sidebar_guid . '][width]' ,
                                            'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $sidebar_guid . '-width' ,
                                            'value' => ( isset( $width ) ) ? $width : NULL,
                                            'options' => array(
                                                '2' => __( '1/6' , LAYERS_THEME_SLUG ),
                                                '4' => __( '2/6' , LAYERS_THEME_SLUG ),
                                                '6' => __( '3/6' , LAYERS_THEME_SLUG ),
                                                '8' => __( '4/6' , LAYERS_THEME_SLUG ),
                                                '10' => __( '5/6' , LAYERS_THEME_SLUG ),
                                                '12' => __( '6/6' , LAYERS_THEME_SLUG )
                                            )
                                        )
                                    )
                                ),
                            )
                        ); ?>

                        <div class="layers-row">
                            <p class="layers-form-item">
                                <?php echo $this->form_elements()->input(
                                    array(
                                        'type' => 'text',
                                        'name' => 'widget-' . $widget_details->id_base . '[' . $widget_details->number . '][sidebars][' . $sidebar_guid . '][title]' ,
                                        'id' => 'widget-' . $widget_details->id_base . '-' . $widget_details->number . '-' . $sidebar_guid . '-title' ,
                                        'placeholder' => __( 'Sidebar Title', LAYERS_THEME_SLUG ),
                                        'value' => ( isset( $title ) ) ? $title : __( 'My Sidebar' , LAYERS_THEME_SLUG ) ,
                                        'class' => 'layers-text'
                                    )
                                ); ?>
                            </p>
                            <?php if( isset(  $_POST[ 'widget_action'] ) && 'add' ==  $_POST[ 'widget_action']) { ?>
                                <p class="layers-form-item">
                                    <em><?php _e( 'To activate this sidebar, click Save &amp; Publish and refresh your customizer.', LAYERS_THEME_SLUG ); ?></em>
                                </p>
                            <?php } ?>
                        </div>
                    </section>
                </li>
        <?php }

    } // Class

    // Add our function to the widgets_init hook.
     register_widget("Layers_Sidebar_Widget");
}