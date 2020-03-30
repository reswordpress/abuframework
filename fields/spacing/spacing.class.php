<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Spacing and Space Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */


class abuFrameworkField_spacing extends abuFrameworkFields {

  private $extra_fields = [];

  private function abu_inputs( $type = '', $value = '', $where = '' ) {
    return '<div class="abu-input abu-pull-left"><span class="abu-label abu-label-icon">' .  wp_kses( $this->extra[ 'icons' ][$type], [ 'i' => ['class' => []], 'span' => ['class' => []] ] ) . '</span>'
        . '<input type="number" value="' . esc_attr( $value ) . '" ' . $this->name_tattv( 1, '[' . $type . ']' ) . $this->class_tattv( 1, 'abu-field-number' )
        . $this->bulk_tattv([ 'allowed' => [ 'attr' ] ])
        . $this->depend_tattv( 1, '', '_' . $type ) . abu_attr( 'placeholder', $this->extra[ 'placeholders' ][$type] ) . '></div>';
  }

  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, $this->extra_fields, $_id );
  }

  final public function render_field() {

    $defaults = [
      'top'   => true,
      'right' => true,
      'bottom'=> true,
      'left'  => true,
      'icons' => [
        'top'     => '<i class="fas fa-long-arrow-alt-up"></i>',
        'right'   => '<i class="fas fa-long-arrow-alt-right"></i>',
        'bottom'  => '<i class="fas fa-long-arrow-alt-down"></i>',
        'left'    => '<i class="fas fa-long-arrow-alt-left"></i>',
        'all'    => '<i class="fa fa-arrows"></i>'
      ],
      'placeholders' => [
        'top'    => __( 'Top', 'AbuFramework' ),
        'right'  => __( 'Right', 'AbuFramework' ),
        'bottom' => __( 'Bottom', 'AbuFramework' ),
        'left'   => __( 'left', 'AbuFramework' ),
        'all'   => __( 'All', 'AbuFramework' ),
      ],
      'all'   => false,
      'all_icon'       => '',
      'all_placeholer' => '',
      'unit'  => true,
      'units' => [ 'px', '%', 'em' ],
    ];

    $this->extra = abu_field_extra( $this->f,  $defaults );

    $values = $this->value_tattv();
    if( ! is_array( $values ) ) { $values = []; }
    $units  =  $this->extra['units'];
    $all  =  $this->extra['all'];
    $width_ph = empty( $this->extra['placeholders']['width'] ) ? __( 'Width', 'AbuFramework' ) : $this->extra['placeholders']['width'];
    $height_ph = empty( $this->extra['placeholders']['height'] ) ? __( 'Height', 'AbuFramework' ) : $this->extra['placeholders']['height'];


    $o = '<div class="abu-spacing-wrapper abu-styler-wrapper">';

      if( $all )
        $o .= $this->abu_inputs( 'all', abu_ekey( 'all', $values, '' ), 'all' );

      if( $this->extra['top'] && ! $all )
        $o .= $this->abu_inputs( 'top', abu_ekey( 'top', $values, '' ), 'top' );

      if( $this->extra['right'] && ! $all )
        $o .= $this->abu_inputs( 'right', abu_ekey( 'right', $values, '' ), 'right' );

      if( $this->extra['bottom'] && ! $all )
        $o .= $this->abu_inputs( 'bottom', abu_ekey( 'bottom', $values, '' ), 'bottom' );

      if( $this->extra['left'] && ! $all )
        $o .= $this->abu_inputs( 'left', abu_ekey( 'left', $values, '' ), 'left' );

      if( $this->extra['unit'] != false ) {
        $o .=  '<select ' . $this->name_tattv( 1, '[unit]' ) . $this->bulk_tattv(['disallowed' => ['name', 'type', 'value']]) . $this->depend_tattv( 1, '', '_units' ) . ( is_string( $units ) ? 'readonly' : '' )  . '>';
        if( is_array( $units ) ) {
            foreach ( $this->extra['units'] as $key => $value) {
              $o .= '<option value="' . esc_attr( $value ) . '" ' . ( abu_ekey( 'unit', $values, '' ) == $value ? 'selected' : '' )  . '>' . esc_html( $value ) . '</option>';
            }
        }
        if( is_string( $units ) ) {
          $o .= '<option value="' . esc_attr( $units ) . '" ' . abu_selected( 1, ( abu_ekey( 'unit', $values, '' ) == $units )  ) . '>' . esc_html(  $units ) . '</option>';
        }
        $o .=  '</select>';
      }


    $o .= '<div class="abu-clear"></div></div>';


    return $this->createField( $o );

  }


}

class abuFrameworkField_space extends abuFrameworkField_spacing {
  
}