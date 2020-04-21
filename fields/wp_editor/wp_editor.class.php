<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * WP-Editor Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_Wp_Editor extends abuFrameworkFields {


  public function __construct( $f, $v = '', $name = '', $place = '' ) {
    parent::__construct( $f, $v, [], $name, $place );
  }

  public function render_field() {
    
    $f = $this->f = abu_field_extra($this->f,[
      'options' => []
    ]);
    $v    = $this->value_tattv();
    $name = $this->name_tattv();
    $id   = $this->id_tattv();
    $f['options']['textarea_name'] = $name;

    $o = '<div class="abu-wp-editor-wrapper">';
      ob_start();
      require_once ABSPATH . WPINC . '/class-wp-editor.php';
      if( class_exists('_WP_Editors') ) {
        _WP_Editors::editor( $v, $f['id'], $f['options'] );
      }
      $o .= ob_get_clean();
    $o .= '</div>';

    return $this->createField( $o );

  }

  function wp_enqueue() {
    if( function_exists('wp_enqueue_editor') ) {
      wp_enqueue_editor();
    }
  }


}
