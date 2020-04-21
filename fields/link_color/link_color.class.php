<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Link-Color field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class AbuFrameworkField_Link_Color extends AbuFrameworkFields {

  private $extra_fields = [
    'wp-picker' => false,
    'color'   => true,
    'hover'   => true,
    'active'  => false,
    'focus'   => false,
    'visited' => false,
    'options' => [
      'showAlpha' => true,
      'showRGB' => false,
      'showHSL' => false,
      'showHEX' => false,
    ]
  ];

  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, $this->extra_fields, $_id );
  }

  public function render_field() {

    $apicker= '';
    $values = $this->value_tattv();
    $values = is_array( $values ) ? $values : [];
    $values = abu_field_extra($values, [
      'color' => '',
      'hover' => '',
      'active' => '',
      'visited' => '',
      'focus' => '',
    ]);

    $e = abu_field_extra( $this->extra, [
      'texts' => [
        'color'   => __( 'Color',  'AbuFramework' ),
        'hover'   => __( 'Hover',  'AbuFramework' ),
        'active'  => __( 'Active', 'AbuFramework' ),
        'visited' => __( 'Visited','AbuFramework' ),
        'focus'   => __( 'Focus',  'AbuFramework' )
      ]
    ]);

    $is_alpha = $e['options']['showAlpha'];
    

    $o = '<div class="abu-link-color-wrapper ' . ( $e['wp-picker'] ? '' : 'abu-a-color-picker' ) . '">';

      foreach ( $values as $key => $value) {
        if( $e[$key] ) {
          $o .= '<div class="abu-pull-left abu-single-color-input">';
            $o .= '<div class="abu-title">' . esc_html( $e['texts'][$key] ) . '</div>';
            $o .= '<div class="abu-fieldwrap">';
              if( $e['wp-picker'] ) {
                $o .= '<input ' . $this->bulk_tattv([], [
                  'type' => [ 1, '', 'text' ],
                  'name' => [ 1, '[' . $key . ']' ],
                  'depend' => [ '', '_' . $key  ],
                  'attr' => [ ['data-alpha' => $is_alpha] ],
                  'class' => [ 1, 'abu-wp-color-picker', ],
                  'value' => [ 1, '', $value ],
                  ]) . '">';
              } else {
                $aoptions = $e['options'];
                $aoptions['color'] = $value;
                $aoptions = json_encode( $aoptions );
                $apicker = ' abu-field-a-color-picker';

                $o .= '<div class="abu-on-color-picker"><div class="abu-apicker-content" abu-add-element-class="abu-field-a-color-picker">';
                  $o .= '<div class="abu-apicker-live-color"><div class="abu-display-color">' . esc_html__( 'Select Color', 'AbuFramework' ) . '</div></div>';
                  $o .= '<div class="abu-transparent button">' . __( 'Transparent', 'AbuFramework' ) . '</div>';
                  $o .= '<div class="abu-apicker-input"><input type="text" ' . $this->bulk_tattv([], [
                          'type' => [ 1, '', 'text' ],
                          'name' => [ 1, '[' . $key . ']' ],
                          'depend' => [ '', '_' . $key  ],
                          'attr' => [ ['data-alpha' => $is_alpha] ],
                          'class' => [ 1 ],
                          'value' => [ 1, '', $value ],
                        ])  . '/></div>';
                  $o .= '<div class="abu-default button button-small button-primary" abu-default-color="' . esc_attr( $value ) . '">' . esc_html__( 'Default', 'AbuFramework' ) . '</div>';
                $o .= '</div><div class="abu-picker" data-abu-color="' . esc_attr( $aoptions ) . '"></div></div>';
              }
            $o .= '</div>';
          $o .= '</div>';
        }
      }

    $o .= '</div>';

    return $this->createField( $o, false, [ 'element-class' => 'abu-field-color-pickers' . $apicker ] );

  }

}
