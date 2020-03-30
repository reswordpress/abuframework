<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Icon-Picker class from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_icon extends abuFrameworkFields {


  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, [], $_id );
  }

  public function render_field() {

    $field = abu_field_extra( $this->f, [
      'save'        => 'all',
      'add-text'    => __( 'Add Icon', 'AbuFramework' ),
      'remove-text' => __( 'Remove Icon', 'AbuFramework' )
    ]);
    $save   = $field['save'];
    $all    = $save == 'all';
    $field['options'] = [
        'mode'  => 'dialog',
        'save'  => $field['save'],
        'meta'    => $field['add-text'],
        'classes' => [
          'launcher' => 'button button-primary abu-ip-add-btn',
          'clear'    => 'remove-times dashicons dashicons-no-alt abu-ip-remove-btn',
          'highlight'=> 'wp-ui-highlight abu-ip-highlight-icon',
          'close'    => 'wp-ui-highlight abu-ip-add-btn'
        ],
        'iconSets' => [
          'abu-icon' => $field['add-text']
        ]
    ];

    $values = $this->value_tattv();
    $values = abu_field_extra( is_array($values) ? $values : [] , [
      'class' => '',
      'code'  => '',
      'label' => ''
    ]);
    $main_value = $values['class'];
    $code       = false;
    $label      = false;

    if( is_string( $save ) ) {
      $main = '';
      $main_value = $this->value_tattv();
      if( $all ) {
        $main = '[class]';
        $main_value = $values['class'];
      }
    } elseif( is_array( $save ) ) {
      $main  = in_array( 'class', $save ) ? '[class]' : '';
      $code  = in_array( 'code',  $save ) ? true : false;
      $label = in_array( 'label', $save ) ? true : false ;
      if( count( $save ) >= 2 && empty( $main ) ) {
        $main = '[label]';
        $main_value = abu_ekey( 'label', $values );
        $label = false;
      }
    }



    $o = '<div class="abu-icon-wrapper">';
      $o .= '<div class="abu-icon-picker" abu-save="' . esc_attr( json_encode( $save ) ) . '" data-pickerid="' . $field['id'] . '" data-iconoptions="' . esc_attr( json_encode( $field['options'] ) ) . '">';
        $o .= '<input type="hidden"'. $this->name_tattv( true, $main ) . $this->class_tattv( 1, 'abu-icon-picker' ) . $this->depend_tattv( 1 ) . abu_attr( 'value', $main_value ) . ' />';
        $o .= '<a class="button button-secondary abu-remove-icon" href="#">' . $field['remove-text'] . '</a>';
      $o .= '</div>';
      if( $all || $code )
        $o .= '<input type="hidden"'. $this->name_tattv( true, '[code]' ) . $this->class_tattv( 1, 'abu-code-input' ) . $this->depend_tattv( 1, '', '_code' ) . abu_attr( 'value', $values['code'] ) . ' />';
      if( $all || $label )
        $o .= '<input type="hidden"'. $this->name_tattv( true, '[label]' ) . $this->class_tattv( 1, 'abu-label-input' ) . $this->depend_tattv( 1, '', '_label' ) . abu_attr( 'value', $values['label'] ) . ' />';
    $o .= '</div>';

    return $this->createField( $o );

  }


}
