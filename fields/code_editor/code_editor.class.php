<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Textarea Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_code_editor extends abuFrameworkFields {

  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, [], $_id );
  }

  public function render_field(){

    $value = $this->value_tattv();
    $field = $this->f = abu_field_extra( $this->f, [
      'editor' => [
        'tabSize' => 2,
        'mode'    => 'css',
        'value'   => $value
      ]
    ]);
    
    $o = '<div class="abu-code-editor-wrapper">';
        $o .= '<textarea ' .  $this->bulk_tattv( [ 'disallowed' => [ 'type', 'value' ]], [ 
          'attr' => [ [ 'data-editor' => esc_attr( wp_json_encode( $field['editor'] ) ) ] ] ]
        ) . ' >' . $value  . '</textarea>';
    $o .= '</div>';

    return $this->createField( $o );

  }

  public function wp_enqueue(){

    wp_enqueue_code_editor([]);

    if( ! wp_script_is('wp-codemirror') ){
      wp_enqueue_script('wp-codemirror');
    }

    if( ! wp_style_is('wp-codemirror') ){
      wp_enqueue_style('wp-codemirror');
    }

  }


}
