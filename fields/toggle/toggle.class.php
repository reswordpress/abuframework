<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Toggle Select Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_toggle extends abuFrameworkFields {

  public function __construct( $f, $v = '', $id = '') {
    parent::__construct( $f, $v, [
    'shape'    => 1,
    'text-on'  => __( 'Enabled', 'AbuFramework' ),
    'text-off' => __( 'Disabled', 'AbuFramework' )
  ], $id );
  }

  public function render_field(){

    switch ( $this->extra['shape'] ) {
      case 1:
      case 'rec':
        $shape = 'abu-toggle-rec';
        break;
      case 2:
        $shape = 'abu-toggle-circle-without-text';
        break;
      default:
        $shape = 'abu-toggle-rec';
        break;
    }
    $value = boolval( $this->value_tattv() );

    $o = '<div class="abu-toggle-wrapper">';
      $o .= '<div class="abu-toggles ' . $shape . ' ">';
        $o .= '<input type="checkbox"  value="1" id="' . esc_attr( $this->id_tattv() . '_abu_checkbox' ) . '" abu-type="toggle" ' . $this->bulk_tattv(['disallowed' => ['value', 'required' ]]) . abu_input_attribute_helper( 1, $value  ) . '>';
        $o .= '<label for="' . esc_attr( $this->id_tattv() ) . '_abu_checkbox' . '" date-on="' . esc_attr( $this->extra['text-on'] ) . '" date-off="' . esc_attr( $this->extra['text-off'] ) . '"></label>';
      $o .=  '</div>';
    $o .= '</div>';

    return $this->createField( $o, 1 );

  }


}
