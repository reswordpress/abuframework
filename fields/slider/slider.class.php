<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Slider Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_slider extends abuFrameworkFields {

  private $extra_fields = [
    'min' => 0,
    'max' => 100,
    'step' => 1
  ];

  public function __construct( $f, $v = '', $_id = '' ) {

    parent::__construct( $f, $v, $this->extra_fields, $_id );
  }

  public function render_field(){
    
    $f = $this->f;
    $v = $this->value_tattv();
    $v = empty($v) ? $f['step'] : $v;

    $o = '<div class="abu-single-slider-wrap">';
    $o .= '<div class="abu-single-slider"><div class="abu-slider" ' . abu_attr( 'data-min', $f['min'] ) . abu_attr( 'data-max', $f['max'] ) . abu_attr( 'data-value', $v ) . abu_attr( 'data-step', $f['step']  ) . '></div></div>';
      $o .= '<div class="abu-single-slider-input">';
      $o .= '<input type="number" ' . $this->bulk_tattv([ 'disallowed' => ['type']], [
            'class' => [ 1, ' abu_val_mailer'],
            'attr'  => [[
              'step'  => $f['step'],
              'min'   => strval($f['min']),
              'max'   => $f['max'],
            ]]
          ]) . ' />';
    $o .=  '</div></div>';

    return $this->createField( $o );

  }


}
