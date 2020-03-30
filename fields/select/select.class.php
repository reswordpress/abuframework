<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Select Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class AbuFrameworkField_select extends AbuFrameworkFields {

  private $extra_fields = [
    'query_args'  => [
      'order'      => 'title',
      'orderby'    => 'name',
    ],
    'multiple'    => false,
    'chosen'      => false,
    'chosen_args' => null,
    'sortable'    => false,
    'options'     => null,
  ];


  private $values = [];

  public function __construct( $f, $v = '', $id = '') {
    parent::__construct( $f, $v, $this->extra_fields, $id );
    $this->values = $v;
  }

  private function abu_selected( $dbvalue, $current, $title, $img = '', $icon = ''){
    $o = '<option value="' . $current . '" ';
      if( is_array( $dbvalue  )  )  { $o .= abu_input_attribute_helper( true, in_array( $current, $dbvalue ), 'selected' ); }
      if( is_string( $dbvalue ) ) { $o .= abu_input_attribute_helper( $dbvalue, $current, 'selected' ); }
      if( ! empty( $img )  ) $o .= 'data-abu-img="' . $img . '" '; 
      if( ! empty( $icon ) ) $o .= 'data-abu-icon="' . str_replace( array('<', '>', "'", '"', '/'), '',  $icon  ) . '" ';
      
    $o .= '>' . $title . '</option>';
    return $o;
  }

  public function render_field(){

    $multiple = $this->extra['multiple'];
    $chosen   = $this->extra['chosen'] ? 'abu-select-chosen' : '';
    $dbv      = $this->value_tattv();
    $options  = '';
    $media_select = '';

    if( empty( $dbv ) && !empty( $chosen ) ) $options = '<option></option>';

     if ( is_string( $this->extra['options'] ) ) {

      // Looping throw wp core data
      $core_data = $this->core_data( $this->extra['options'], $this->extra['query_args'] );
      foreach ($core_data as $value => $title) {
        $options .= $this->abu_selected( $dbv, $value, $title );
      }

    } elseif( is_array( $this->extra['options'] )  ) {

      foreach ( $this->extra['options'] as $value => $title ) {
        if( is_array( $title ) ) {

          $is_grp = isset( $title['title'] ) || isset( $title['icon'] ) || isset( $title['img'] ) || isset( $title['image'] );
          if( ! $is_grp ) {
            $options  .= '<optgroup label="' . esc_attr( $value ) . '">';
              foreach( $title as $i => $ttl ) {
                $mediatitle = abu_ekey( 'title', $ttl, $ttl );
                $mediaicon  = abu_ekey( 'icon', $ttl, '' );
                $mediaimg   = abu_ekey( 'img', $ttl, '' );
                $mediaimg   = abu_ekey( 'image', $ttl, $mediaimg );
                $options   .= $this->abu_selected( $dbv, $i, $mediatitle, $mediaimg, $mediaicon );
              }
            $options .= '</optgroup>';
          } else {
            $chosen     = 'abu-select-chosen';
            $mediatitle = abu_ekey( 'title', $title, '' );
            $mediaicon  = abu_ekey( 'icon', $title, '' );
            $mediaimg   = abu_ekey( 'img', $title, '' );
            $mediaimg   = abu_ekey( 'image', $title, $mediaimg );
            $options   .= $this->abu_selected( $dbv, $value, $mediatitle, $mediaimg, $mediaicon );
          }

        } else {
          $options   .= $this->abu_selected( $dbv, $value, $title );
        }

      }

    } 


    $o = '<div class="abu-select-wrapper">';
    if( ! empty( $options ) ) {
      $o .= '<select ' . $this->name_tattv( 1, ( $multiple ? '[]' : '' ) )  . $this->bulk_tattv([ 'disallowed' => [ 'value', 'name', 'type', 'id', 'class' ]]) . ( $multiple ? ' multiple ' : '' ) . $this->class_tattv( 1, [ $chosen ] ) . '>';
        $o .= $options;
      $o .= '</' . $this->type_tattv() . '> ';
    } else {
      $o .= __( 'There is no options', 'AbuFramework' );
    }
    $o .= '</div>';

    if( $this->f['field_only'] ) {
      return $o;
    }

    return $this->createField( $o, false );

  }


}
