<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * 
 * WPSetting Class from AbuFramework 
 * 
 * !Don't remove this!
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

if( ! class_exists( 'WPSetting' ) ) {
  class WPSetting extends AbuFramework {
  
    public $_id      = 0;
    public $errors   = [];
    public $settings = [];
    public $sections = [];
    public static $instance = 0;
  
    public function __construct( $settings = [], $sections = [] ) {
      
  
      if( abu_iekey( 'framework_id', $settings ) ) {
        $this->_id = $settings['id'] = $settings['framework_id'];
      } elseif ( abu_iekey( 'id', $settings ) ) {
        $this->_id = $settings['framework_id'] = $settings['id'];
      } else {
        $this->_id = 'abuframework_' . (SELF::$instance + 1);
        SELF::$instance++;
      }
  
  
      $this->settings = $settings = apply_filters( 'abu_options_'.$this->_id.'_setting', abu_field_extra( $settings, [
  
        'menu_capability'  => 'manage_options',
        'show_in_rest'     => '',
        'database'         => '',
        'transient_expiration' => 0,
        'save_default'     => true,
        
        'output_css'       => true,
        
        // Private options
        '__errors'         => [],
  
      ]));
  
      $this->fields      = abu_ekey( 'fields', $settings, [] );
      $this->saved_value = abu_set_options( $settings, [], false, true );
      
      if( $this->saved_value === false && $settings['save_default'] ) {
        $values = [];
        foreach ($this->fields as $field) {
          if( ! isset($field['id']) ) continue;
          $values[$field['id']] = abu_ekey( ['default', 'value'], $field, '' );
        }
        $this->saved_value = abu_set_options( $settings, $values );
      }
  
      add_action( 'admin_init', array( $this, 'admin_init' ) );
  
      
    }
  
    public static function create( $se, $sec ) {
      SELF::$instance++;
      return new self( $se, $sec );
    }
  
    public function admin_init(){
  
      $id      = $this->_id;
      $setting = $this->settings;
  
      // register a new setting
      $register = in_array( $setting['page'], [ 'general', 'discussion', 'media', 'reading', 'writing', 'misc', 'options', 'privacy' ] ) ? $setting['page'] : $id;
      register_setting( $register, $id, array( $this, 'sanitization_validation' ));
      
      // register a new section 
      add_settings_section( $id, abu_ekey( 'title', $setting, ''), array( $this, 'section' ) , $setting['page'] );
      
    
    }
  
    /**
     * Section callback functions
     */
    public function section() {
  
      $id      = $this->_id;
      $fields  = $this->fields;
      $values  = $this->saved_value;
      $errors  = $this->errors;
  
      foreach ( $fields as $key => $field ) {
  
        if( ! isset( $field['id'] ) ) continue;
  
        $name  = $id . '[' . $field[ 'id' ] . ']';
        $value = abu_ekey( $field[ 'id' ], $values, abu_ekey( [ 'default', 'value' ], $field, '' ) );
        if( array_key_exists( $field['id'], $errors ) ) $field['__error'] = $errors[$field['id']];
        $field['element-class'] = [ 'abu-wp-page' ];
        echo add_abu_tattv( $field, $value, $id, 'options' ); // Adding Elemet
  
  
      }
  
    }
  
    public function sanitization_validation( $value ){
  
      $id      = $this->_id;
      $fields  = $this->fields;
      $setting = $this->settings;
      $options = abu_var( $id, $value );
      
      $done_data = abu_sanitization_validation_escaping( $options, $fields );
  
      $this->errors = $this->settings['__errors'] = $done_data['errors'];
      $request = apply_filters( "abu_{$id}_before_save", wp_unslash( $done_data['request'] ), $this );
      do_action( "abu_{$id}_before_save", $request, $this );
      
      return $request;
  
    }
  
  }
}
return;


