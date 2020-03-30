<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Color-Palette field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_Color_Palette extends abuFrameworkFields {


  public function __construct( $f, $v = '', $name = '', $place = '' ) {
    parent::__construct( $f, $v, [],  $name, $place );
  }

  public function render_field() {

    $fvalue    = $this->value_tattv();
    $f        = $this->f;
    $palettes = abu_ekey( 'palettes', $f, false );

    $o = '<div class="abu-color-palette-wrapper">';
      if( $palettes ) {
        foreach( $palettes as $key => $palette ) {
          $value = abu_ekey( 'value', $palette, $key );
          $o .= '<label>';
            $o .= '<input type="radio"' . $this->name_tattv(1) . ' value="' . esc_attr( $value ) . '" ' . $this->depend_tattv( 1, '', '_' . $value ) . ' ' . abu_input_attribute_helper( ( $value == $fvalue ), true ) . '>';
            $o .= '<div class="abu-singel-palette">';
              if( abu_iekey( 'color', $palette ) && is_array( $palette['color'] ) ) {
                foreach( $palette['color'] as $color ) {
                  $o .= '<div style="background-color:' . esc_attr( $color ) . ';"><span class="abu-palette-color-name">' . esc_html( $color ) . '</span></div>';
                }
              }
            $o .= '</div>';
          $o .= '</label>';
        }
      }
    $o .= '</div>';

    return $this->createField( $o, false, [
      'element-class' => 'abu-field-wp-color-picker'
    ]);

  }


}
