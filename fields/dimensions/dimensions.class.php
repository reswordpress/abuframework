<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Dimensions Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_dimensions extends abuFrameworkFields {

  private $extra_fields = [
    'width'   => true,
    'height'  => true,
    'placeholders' => [
      'width'  => '',
      'height'  => '',
    ],
    'width_icon'  => '<i class="fas fa-arrows-alt-h"></i>',
    'height_icon' => '<i class="fas fa-arrows-alt-v"></i>',
    'unit'  => true,
    'units'  => [ 'px', '%', 'em' ]
  ];

  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, $this->extra_fields, $_id );
  }

  final public function render_field(){

    $values = $this->value_tattv();
    $values = is_array( $values ) ? $values : [];
    $values = abu_field_extra( $values, [
      'height' => '',
      'width'  => '',
      'unit'   => ''
    ]);

    $units     =  $this->extra['units'];
    $width_ph  = empty( $this->extra['placeholders']['width'] ) ? __( 'Width', 'AbuFramework' ) : $this->extra['placeholders']['width'];
    $height_ph = empty( $this->extra['placeholders']['height'] ) ? __( 'Height', 'AbuFramework' ) : $this->extra['placeholders']['height'];

    $o = '<div class="abu-dimensions-wrapper abu-styler-wrapper">';

      if( $this->extra['width'] ) {
        $o .=
        '<div class="abu-input abu-pull-left"><span class="abu-label abu-label-icon">' .  $this->extra['width_icon'] . '</span>'
         . '<input type="number" value="' . $values['width'] . '" ' . $this->name_tattv( 1, '[width]' ) . $this->class_tattv( 1, 'abu-field-number' )
         . $this->bulk_tattv([ 'allowed' => [ 'attr']]) . $this->depend_tattv( 1, '', '_width' ) . abu_attr( 'placeholder', $width_ph ) . '></div>';
      }

      if( $this->extra['height'] ) {
        $o .=
        '<div class="abu-input abu-pull-left"><span class="abu-label abu-label-icon">' .  $this->extra['height_icon'] . '</span>'
          . '<input type="number" value="' . $values['height'] . '" ' . $this->name_tattv( 1, '[height]' ) . $this->class_tattv( 1, 'abu-field-number' )
        . $this->bulk_tattv([ 'allowed' => [ 'attr']]) . $this->depend_tattv( 1, '', '_height' ) . abu_attr( 'placeholder', $height_ph ) . '></div>';
      }

      if( $this->extra['unit'] != false ) {
        $o .=  '<select ' . $this->bulk_tattv([ 'disallowed' => [ 'type', 'value']], [ 'name' => [ 1, '[unit]' ], 'depend' => [ 1, '', '_units' ] ])  . ( is_string( $units ) ? 'readonly="readonly"' : '' )  . '>';
        if( is_array( $units ) ) {
            foreach ( $this->extra['units'] as $key => $value) {
              $o .= '<option value="' . $value . '" ' . ( abu_ekey( 'unit', $values, '' ) == $value ? 'selected' : '' )  . '>' . $value . '</option>';
            }
        }
        if( is_string( $units ) ) {
          $o .= '<option value="' . $units . '" ' . ( abu_ekey( 'unit', $values, '' ) == $units ? 'selected' : '' ) . '>' . $units . '</option>';
        }
        $o .=  '</select>';
      }


    $o .= '</div>';


    return $this->createField( $o );

  }


}
