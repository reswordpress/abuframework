<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Rande Slider Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_range_slider extends abuFrameworkFields {

  private $extra_fields = [
    'min' => 1,
    'max' => 100,
    'step' => 1
  ];

  public function __construct( $f, $v = '', $_id = '' ) {

    parent::__construct( $f, $v, $this->extra_fields, $_id );
  }

  public function render_field(){

    $f = $this->f;
    $values = $this->value_tattv();
    $values = is_array( $values ) ? $values : ['min'=>20,'max'=>80,'step'=>1];

    $o = '<div class="abu-range-slider-wrap"><div class="abu-range-slider-input">';
      $o .= '<input type="number" ' . $this->name_tattv( 1, '[min]') . $this->bulk_tattv( [ 'disallowed' => [ 'id', 'name', 'type' ] ], [
          'value'  => [ 1, '', strval( $values['min'] ) ],
          'depend' => [ 1, '', '_min'],
          'class'  => [ 1, ' abu-val-mailer abu-mailer-first' ],
          'attr'  => [[
            'step'  => $f['step'],
            'min'   => $f['min'],
            'max'   => abu_ekey( 'max' , $values, $f['max'] ),
          ]],
      ] ) . '/>';
      $o .= '</div><div class="abu-range-slider">';
      $o .= '<div class="abu-slider" ' . abu_attr( 'data-min', $f['min'] ) . abu_attr( 'data-max', $f['max'] ) . abu_attr( 'data-values', json_encode( $values ) ) . abu_attr( 'data-step', $f['step']  ) . '></div>';
      $o .= '</div><div class="abu-range-slider-input">';
      $o .= '<input type="number" ' .  $this->name_tattv( 1, '[max]') . $this->class_tattv( 1, ' abu-val-mailer abu-mailer-second ') . $this->bulk_tattv([ 'disallowed' => [ 'type', 'name', 'id', 'class' ]],[
          'depend' => [1,'', '_max'],
          'value'  => [ 1, '', strval( $values['max'] ) ],
          'attr'  => [[
            'step'  => $f['step'],
            'min'   => abu_ekey( 'min', $values, $f['min'] ),
            'max'   => $f['max'],
          ]],
        ]) . '/>';
    $o .= '</div></div>';

    return $this->createField( $o );

  }


}
