<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Number Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_number extends abuFrameworkFields {

  private $extra_fields = [
    'placeholder' => '',
    'min' => '',
    'max' => ''
  ];

  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, $this->extra_fields, $_id );
  }

  public function render_field(){

    $min = ! empty( $this->extra['min'] ) ? ' min="' . esc_attr( $this->extra['min'] ) . '" ' : '';
    $max = ! empty( $this->extra['max'] ) ? ' max="' . esc_attr( $this->extra['max'] ) . '" ' : '';

    $o = '<div class="abu-input-wrapper">';
      $o .= '<input ' . $this->bulk_tattv( [], [ 'all' => [1] ] ) . $min . $max . ' />';
    $o .= '</div>';

    return $this->createField( $o );

  }


}
