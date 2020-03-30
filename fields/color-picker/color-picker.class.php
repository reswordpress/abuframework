<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Color-Picker field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */
class abuFrameworkField_Color_picker extends abuFrameworkFields {

  private $extra_fields = [
    'wp-picker' => true,
    'options' => [
      'showAlpha' => true,
      'showRGB' => false,
      'showHSL' => false,
      'showHEX' => false,
    ]
  ];

  public function __construct( $f, $v = '', $name = '', $place = '' ) {
    parent::__construct( $f, $v,  $this->extra_fields,  $name, $place );
  }

  public function render_field(){

    $o = '<div class="abu-color-picker-wrapper ' . ( $this->extra['wp-picker'] ? '' : 'abu-a-color-picker' ) . '">';
    $aoptions = $this->f['options'];
    $apicker  = '';
    
    if( ! $this->extra['wp-picker'] ) {
      
      $aoptions['color'] = $this->value_tattv();
      $aoptions = json_encode( $aoptions );
      $apicker = ' abu-field-a-color-picker';

      $o .= '<div class="abu-on-color-picker"><div class="abu-apicker-content">';
        $o .= '<div class="abu-apicker-live-color"><div class="abu-display-color">' . esc_html__( 'Select Color', 'AbuFramework' ) . '</div></div>';
        $o .= '<div class="abu-transparent button">' . __( 'Transparent', 'AbuFramework' ) . '</div>';
        $o .= '<div class="abu-apicker-input"><input ' . $this->bulk_tattv([], [
                'type' => [ 1, '', 'text' ],
                'name' => [ 1 ],
                'class' => [ 1 ],
                'value' => [ 1 ],
              ]) . '/></div>';
        $o .= '<div class="abu-default button button-primary" abu-default-color="' . esc_attr( $this->value_tattv() ) . '">' . esc_html__( 'Default', 'AbuFramework' ) . '</div>';
      $o .= '</div><div class="abu-picker" data-abu-color="' . esc_attr( $aoptions ) . '"></div></div>';

    } else {
      $o .= '<input data-alpha="' . esc_attr( $aoptions['showAlpha'] ) .  '" type="text" ' . $this->name_tattv(1) ;
      $o .= $this->value_tattv(1) . $this->depend_tattv() . $this->class_tattv(1, 'abu-wp-color-picker') . ' data-default-color="' .  esc_attr( $this->value_tattv() ) . '" />';
    }

    $o .= '</div>';

    return $this->createField( $o, false, [
      'element-class' => 'abu-field-wp-color-picker' . $apicker
    ]);

  }


}
