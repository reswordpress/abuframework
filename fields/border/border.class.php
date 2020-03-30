<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Border Feild from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_border extends abuFrameworkFields {

  private $extra_fields = [];

  private function abu_inputs( $type = '', $value = '' ) {
    return '<div class="abu-input abu-pull-left"><span class="abu-label abu-label-icon">' .
      $this->extra['icons'][$type] . '</span><input ' . $this->bulk_tattv(
      [ 'disallowed' => [ 'style', 'required' ]  ],
      [
        'type' => [ 1, 0, 'number' ],
        'value' => [ 1, '', strval( $value ) ],
        'name' => [ 1, '[' . $type . ']' ],
        'class' => [ 1, 'abu-field-number' ],
        'depend'  => [ 1, '', '_' . $type ],
        'placeholder' => [ 1, '', $this->extra['placeholders'][$type] ]
      ]
    ) . '></div>';
  }

  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, $this->extra_fields, $_id );
  }

  final public function render_field() {

    $this->extra = abu_field_extra( $this->f, [
      'top'   => true,
      'right' => true,
      'bottom'=> true,
      'left'  => true,
      'icons' => [
        'top'    => '<i class="fas fa-long-arrow-alt-up"></i>',
        'right'  => '<i class="fas fa-long-arrow-alt-right"></i>',
        'bottom' => '<i class="fas fa-long-arrow-alt-down"></i>',
        'left'   => '<i class="fas fa-long-arrow-alt-left"></i>',
        'all'    => '<i class="fas fa-expand-arrows-alt" style="transform: rotateZ( 45deg );"></i>'
      ],
      'placeholders' => [
        'top'    => __( 'Top',    'AbuFramework' ),
        'right'  => __( 'Right',  'AbuFramework' ),
        'bottom' => __( 'Bottom', 'AbuFramework' ),
        'left'   => __( 'Left',   'AbuFramework' ),
        'all'    => __( 'All',    'AbuFramework' )
      ],
      'color'     => true,
      'wp-picker' => true,
      'picker-options' => [
        'showAlpha' => true,
        'showRGB'   => false,
        'showHSL'   => false,
        'showHEX'   => false,
      ],
      'style'  => true,
      'styles' => [ 'Solid', 'Dotted', 'Dashed', 'Double', 'Groove', 'Inset', 'Outset', 'Ridge', 'None' ],
      'all'    => false,
      'unit'   => true,
      'units'  => [ 'px', '%', 'em' ],
    ]);

    $values = $this->value_tattv();
    if( ! is_array( $values ) ) { $values = []; }
    $units  =  $this->extra['units'];
    $all  =  $this->extra['all'];

    $o = '<div class="abu-border-wrapper abu-styler-wrapper">';

      if( $this->extra['top'] && ! $all )
        $o .= $this->abu_inputs( 'top', abu_ekey( 'top', $values, '' ) );

      if( $this->extra['right'] && ! $all )
        $o .= $this->abu_inputs( 'right', abu_ekey( 'right', $values, '' ) );

      if( $this->extra['bottom'] && ! $all )
        $o .= $this->abu_inputs( 'bottom', abu_ekey( 'bottom', $values, '' ) );

      if( $this->extra['left'] && ! $all )
        $o .= $this->abu_inputs( 'left', abu_ekey( 'left', $values, '' ) );

      if( $all ) $o .= $this->abu_inputs( 'all', abu_ekey( 'all', $values, '' ) );

      $style = abu_ekey( 'style', $values, '' );
      if( $this->extra['style'] != false ) {

        $o .=  '<select class="abu-pull-left" ' .
          $this->bulk_tattv( [ 'disallowed' => [ 'placeholder', 'value' ]  ], [
            'type' => [ 1, 0, 'number' ],
            'value' => [ 1, '', strval( $style ) ],
            'name' => [ 1, '[style]' ],
            'class' => [ 1, 'abu-field-number' ],
            'id' => [ 1, '_style' ],
            'depend'  => [ 1, '', '_style' ],
          ] ) . abu_input_attribute_helper( is_string( $units ), true ) . '>';

        if( is_array( $units ) ) {
            foreach ( $this->extra['styles'] as $key => $value) {
              $o .= '<option value="' . esc_attr($value) . '" ' . abu_input_attribute_helper( ( $style == $value ), true, 'selected'  )  . '>' . $value . '</option>';
            }
        }

        if( is_string( $units ) ) {
          $o .= '<option value="' . esc_attr( $units ) . '" ' . abu_input_attribute_helper( ( $style == $units ), true, 'selected'  ) . '>' . $units . '</option>';
        }

        $o .= '</select>';

      }

      if( $this->extra['unit'] != false ) {

        $o .=  '<select class="abu-pull-left" ' . $this->bulk_tattv( [ 'disallowed' => [ 'style', 'required', 'placeholder', 'value' ]  ], [
          'type' => [ 1, 0, 'number' ],
          'name' => [ 1, '[unit]' ],
          'class' => [ 1, 'abu-field-number' ],
          'depend'  => [ 1, '', '_unit' ],
        ] ) . abu_input_attribute_helper( is_string( $units ), true )  . '>';

        if( is_array( $units ) ) {
            foreach ( $this->extra['units'] as $key => $value) {
              $o .= '<option value="' . esc_attr( $value ) . '" ' . abu_input_attribute_helper( ( abu_ekey( 'unit', $values, '' ) == $value ), true, 'selected'  )  . '>' . $value . '</option>';
            }
        }

        if( is_string( $units ) ) {
          $o .= '<option value="' . esc_attr( $units ) . '" ' . ( abu_ekey( 'unit', $values, '' ) == $units ? 'selected' : '' ) . '>' . $units . '</option>';
        }
        $o .= '</select>';

      }

      if( $this->extra['color'] != false ) {
        $o .= '<div class=" abu-pull-left abu-color-picker-wrapper ' . ( $this->extra['wp-picker'] ? '' : 'abu-a-color-picker' ) . '">';

        $color = abu_ekey( 'color', $values, 'rgba(0,0,0,0)' );

        if( ! $this->extra['wp-picker'] ) {

          $this->extra[ 'picker-options' ]['color'] = $color;
          $aoptions = json_encode( $this->extra[ 'picker-options' ]  );

          $o .= '<div class="abu-on-color-picker"><div class="abu-apicker-content" abu-add-element-class="abu-field-a-color-picker">';
            $o .= '<div class="abu-apicker-live-color"><div class="abu-display-color">' . esc_html__( 'Select Color', 'AbuFramework' ) . '</div></div>';
            $o .= '<div class="abu-transparent button" >' . __( 'Transparent', 'AbuFramework' ) . '</div>';
            $o .= '<div class="abu-apicker-input"><input type="text" ' . $this->name_tattv( 1, '[color]' ) . $this->id_tattv( true, '_color' ) . $this->bulk_tattv() .  ' value="' . esc_attr( $color ) . '"/></div>';
            $o .= '<div class="abu-default button button-small button-primary" abu-default-color="' . $color . '">' . esc_html__( 'Default', 'AbuFramework' ) . '</div>';
          $o .= '</div><div class="abu-picker" data-abu-color="' . esc_attr( $aoptions ) . '"></div></div>';

        } else {
          $o .= '<input data-alpha="true" type="text" name="' . esc_attr( $this->name_tattv( 0, '[color]' ) ) .'"' . $this->depend_tattv( 1, '', '_color' ) . $this->bulk_tattv( [ 'allowed' => [ 'attr' ]  ] );
          $o .=  ' value="' . esc_attr( $color )  . '" ' . $this->class_tattv( 1, 'abu-wp-color-picker' ) . ' data-default-color="' .  esc_attr( abu_ekey( 'color', $values, '#fff' ) ) . '" />';
        }

        $o .= '</div>';
      }


    $o .= '</div>';

    $classes = [];
    if( $this->extra['wp-picker'] )
      $classes['element-class'] = 'abu-field-wp-color-picker';

    return $this->createField( $o, false, $classes );

  }


}
