<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Image Select Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_image_select extends abuFrameworkFields {

  private $values = [];

  public function __construct( $f, $v = '', $id = '') {
    parent::__construct( $f, $v, [], $id );
    $this->values = array_merge( $this->values , ( is_array( $this->value_tattv() ) ? $this->value_tattv() : [ $this->value_tattv() ] ) );
  }

  public function render_field(){

    $f = abu_field_extra( $this->f, [
      'rounded'    => true,
      'multiple'  => false,
      'width'     => null,
      'height'    => null,
      'limit'     => 'infinity',
      'options'   => null,
      'select_type'  => 'first'
    ]);
    $shadow   = $f['rounded'] ? '' : 'unrounded';
    $multiple = $f['multiple'] ? 'yes' : 'no';
    $custom_width = $f['width'] ? ' abu-custom-width="' . $f['width'] . '" ' : ' ';
    $custom_height = $f['height'] ? ' abu-custom-height="' . $f['height'] . '" ' : ' ';
    $limit = ( $f['limit'] || (int) $f['infinity'] == 0 ) ? ' abu-limit="' . $f['limit'] . '" ' : ' ';
    if( $f['select_type'] == 'second' ) {
      $stype = 'second';
    } else {
      $stype = 'first';
    };


    $o = '<div class="abu-image-selects-wrapper"><ul class="image-selects-images select-type-' . $stype . '  ' . $shadow . '" abu-multiple="' . $multiple . '"' . $custom_width . $custom_height . $limit . '>';

      if( is_array( $f['options'] ) ) {
        $multiple = ( count( $f['options'] ) >= 1 ) ? '[]' : '';
        foreach ( $f['options'] as $value => $url ) {

          $o .=  '<li><label><input type="checkbox" '  . $this->name_tattv( 1, $multiple ) . $this->value_tattv( 1, '', $value ) . $this->bulk_tattv([ 'disallowed' => [ 'id', 'name', 'type', 'value' ] ]) . ( in_array( $value, $this->values ) ? ' checked ' : ''  ) .  ' />';
            $o .=  '<div class="abu-select-image"><img src="' . esc_url( $url ) . '"/>' . ( $stype == 'first' ? '<i class="fa fa-check abu-checked-icon"></i>' : '' ) . '</div>';
          $o .=  '</label></li>';

        }
      } else {
        $o .= __( 'There is no Options', 'AbuFramework' );
      }

    $o .= '</ul></div>';

    return $this->createField( $o, true );

  }


}
