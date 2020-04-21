<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Upload Select Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */
class abuFrameworkField_upload extends abuFrameworkFields {


  public function __construct( $f, $v = '', $name = '', $place = '' ) {
    parent::__construct( $f, $v, [], $name, $place );
  }

  public function render_field(){

    $values = $this->value_tattv();

    $f = abu_field_extra( $this->f, [
      'upload_button' => __( 'Upload', 'AbuFramework' ),
      'remove_all'    => __( 'Remove All', 'AbuFramework' ),
      'name'          => $this->name_tattv(),
      'multiple'      => false,
      'url'           => false,
      'library'       => 'image'
    ]);
    if( is_string($f['library']) ) {
      $f['library']  = ['type' => $f['library'] ];
    }

    $o = '<div class="abu-upload-wrapper">';

      $o .= '<div class="abu-upload-inputs' . ( $f['multiple'] ? ' upload-multiple"' : '"' ) . ' data-abu-inputs="' .  ( is_array($values) ? esc_attr(count($values)) : '0' ) . '">';
        if( $f['multiple'] === true ) {
          if( is_array($values) && !empty($values) ) {
            foreach ( $values as $key => $value ) {
              $value_json = $value;
              $value = json_decode($value,1);
              if( ! abu_iekey( 'url', $value, false ) ) continue;
              $o .= '<div class="abu-upload-input">';
                $o .= '<div class="abu-upload-previewer">';
                  $o .= '<a class="abu-previewer-helper abu-upload-remover"><i class="fa fa-times"></i></a><a class="abu-previewer-helper abu-upload-coper"><i class="fas fa-copy"></i></a>';
                  $o .= '<img src="' . esc_url( isset( $value['sizes']['thumbnail']['url'] ) ? $value['sizes']['thumbnail']['url'] : $value['url'] ) . '" class="abu-prev" alt="' . esc_attr( $value['alt'] ) . '" title="' . esc_attr( $value['title'] ) . '">';
                $o .= '</div>';
                $o .= '<div class="abu-all-inputs">';
                  $o .= '<input type="text" ' . $this->name_tattv(1, '[]') . $this->value_tattv( 1, '', $value_json ) . $this->depend_tattv( '', $key ) . $this->id_tattv( 1, $key ) . '>';
                $o .= '</div>';
              $o .= '</div>';
            }
          }
        } else {
          $values = (array) json_decode( $values, true );
          if( abu_iekey('url', $values, false) ) {
            $o .= '<div class="abu-upload-input">';
              $o .= '<div class="abu-upload-previewer">';
                $o .= '<a class="abu-previewer-helper abu-upload-remover"><i class="fa fa-times"></i></a>';
                $o .= '<img src="' . esc_url( isset( $values['sizes']['thumbnail']['url'] ) ? $values['sizes']['thumbnail']['url'] : $values['url'] ) . '" class="abu-prev" alt="' . esc_attr( abu_ekey( 'alt', $values ) ) . '" title="' . esc_attr( abu_ekey( 'title', $values ) ) . '">';
              $o .= '</div>';
              $o .= '<div class="abu-all-inputs">';
                $o .= '<input type="text" ' . $this->name_tattv(1) . $this->value_tattv( 1 ) . $this->depend_tattv( 1 ) . '>';
              $o .= '</div>';
            $o .= '</div>';
          }
        }
      $o .= '</div>';

      $o .= '<div class="abu-upload-buttons">';
        $o .= '<a href="#" class="abu-upload-btn button button-primary" data-uploaderoptions="' . esc_attr( json_encode($f) ) . '">' . __( 'Upload', 'AbuFramework' ) . '</a>';
        $o .= '<a href="#" class="abu-removeall-btn button">' . ( $f['multiple'] ? __( 'Remove All', 'AbuFramework' ) : __( 'Remove', 'AbuFramework' ) ) . '</a>';
        $o .= '</div>';

    $o .= '</div>';

    return $this->createField( $o, false, [ 'element-class' => ( $f['multiple'] === true ? 'abu-multiple-upload' : '' ) ] );

  }


}
