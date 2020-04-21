<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Spinner Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_spinner extends abuFrameworkFields {


  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, null, $_id );
  }

  public function render_field() {

    $field = abu_field_extra( $this->f, [
      'placeholder' => '',
      'min' => 0,
      'max' => 100,
      'step' => 1,
      'unit' => true,
      'units' => 'px',
      'typetag' => 'text'
    ]);

    $values = $this->value_tattv();
    $value = $unit = '';
    if( is_array( $values ) ) {
      $value = $values['value'];
      $unit = isset( $values['unit'] ) ?? '';
    }
    $max = ! empty( $field['max'] ) ? ' data-max="' .  esc_attr( $field['max'] ) . '" ' : '';
    $min = ! empty( $field['min'] ) ? ' data-min="' .  esc_attr( $field['min'] ) . '" ' : '';

    $o = '<div class="abu-spinner-wrapper abu-pull-left">';
        $o .= '<input type="' . esc_attr( $field['typetag'] ) . '" value="' .  esc_attr( $value ) . '"' . $this->name_tattv( 1, '[value]' ) . $this->bulk_tattv( [ 'disallowed' => [ 'id', 'name', 'type', 'value', 'class'] ] ) .  $this->class_tattv( 1, ' abu-field-number abu-spinner-input') . abu_array_atr( [ 'data-step' => $field['step'], 'data-min' => $field['min'], 'data-max' => $field['max'] ] )  . ' role="spinbutton">';
        if( $field['unit'] ) {
          $o .= is_string( $field['units'] ) != false ? '<div class="abu-spinner-unit">' . esc_html(  $field['units'] ) . '</div><input type="hidden" ' . $this->name_tattv( true, '[unit]' ) . ' value="' . esc_attr( $field['units'] ) . '"/>' : '';
          if( is_array( $field['units'] ) ) {
            $o .= '<select ' . $this->name_tattv( true, '[unit]' ) . $this->depend_tattv( 1, '', '_unit' ) . ' class="abu-spinner-unit" >';
              foreach ( $field['units'] as $sunit ) { 
                $o .= '<option value="' . esc_attr( $sunit ) . '" ' . (  $sunit == $unit ? 'selected' : '' ) . '>' . esc_html( $sunit ) . '</option>'; 
              }
            $o .= '</select>';
          }
        }
    $o .= '</div><div class="abu-clearfix"></div>';

    return $this->createField( $o );

  }


}
