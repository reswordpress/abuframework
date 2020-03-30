<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * AbuWidget CLASS for Creating WP_Widgets from AbuFramework
 * @since 1.0.0
 * @version 1.0.0
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

if( class_exists( 'AbuWidget' ) ) return;

class AbuWidget extends WP_Widget {

 public static $abu_args = [];

 public $args = array(
    'before_title'  => '<h4 class="widgettitle">',
    'after_title'   => '</h4>',
    'before_widget' => '<div class="widget-wrap">',
    'after_widget'  => '</div>'
 );

 function __construct() {

    $args = SELF::$abu_args;

    $this->args['abu_sections'] = $args['abu_sections'];

    parent::__construct( $args['id'], abu_ekey( 'title', $args, $args['id'] ), array(
        'classname'    => 'abu_widget_' . $args['id'] ,
        'description'  => (isset( $args['desc'] ) ? $args['desc'] : ''),
        'abu_sections' => abu_ekey( 'abu_sections', $args, [] ),
    ));

    add_action( 'widgets_init', function() {
         register_widget( 'AbuWidget' );
    });

 }

 static function create( $args, $section ) {
    self::$abu_args = $args;
    self::$abu_args['abu_sections'] = $section;
    return new SELF();
 }



 public function widget( $args, $instance ) {

    if( is_callable(self::$abu_args['function']) ) {
        echo call_user_func( self::$abu_args['function'], $args, $instance );
        return;
    }

    echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        echo '<div class="textwidget">';

            echo '<pre>' . var_export( $instance, true ) . '</pre>';

        echo '</div>';

    echo $args['after_widget'];

 }

 private function sections_ids( &$sections ){
    foreach ( $sections as $key => &$section) {
        foreach ( $section['fields'] as $key => &$field ) {
            $field_id      = $field['id'];
            $field['depend_id']   = $field['id'];
            $field['class']       =  'widefat';
            $field['name'] = 'widget-' . $this->id_base . '[' . $this->number . '][' . $field_id . ']';
        }
    }
    return $sections;
 }

 public function form( $instance ) {

     $this->sections_ids( $this->widget_options['abu_sections'] );

    $instanse = new abuTabOn();
    $instanse->abuOptionsRenders([
        'form'  => false, 
        'submit'=> false,
        'place' => 'abu-widgets', 
        'tabs'  => false,
        'id'    => self::$abu_args['id']
    ], $this->widget_options['abu_sections'], $instance, true );
     
 }

 public function update( $new_instance, $old_instance ) {

    return abu_ekey( 'request', abu_sanitization_validation_escaping( $new_instance, $this->widget_options['abu_sections'] ), [] );

 }

}

