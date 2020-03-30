<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Accordion Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */


class abuFrameworkField_accordion extends abuFrameworkFields {


  public function __construct( $f, $v = '', $name = '', $place = '' ) {
    parent::__construct( $f, $v, [], $name, $place );
  }

  public function render_field() {

    $f = $this->f;
    $id= $this->id_tattv(); 
    $v = $this->value_tattv();
    $vk= is_array( $v ) ? array_keys($v) : false;
    $n = $this->name_tattv();
    $accords = $f['accordions'];
    $sortable = abu_ekey( 'sortable', $f, false );
    $sortable_class = $sortable ? ' accordions-sortable' : '';


    if( $sortable && !empty($v) ) {
      $accordions = [];
      foreach ( $accords as $key => $accord ) {
        $title = abu_ekey( 'title', $accord, 'Accordion ' . $key );
        $id    = abu_ekey( 'id', $accord, $title );
        if( abu_iekey( $id, $v ) ) {
          $ak = array_search( $id, $vk );
          $accordions[$ak] = $accord;
        }
      }
      ksort($accordions);
    } else {
      $accordions = $f['accordions'];
    }

    $o = '<div class="abu-accordion-wrapper">' ;
      if( is_array( abu_ekey( 'accordions', $f, false ) ) ) {
        $o .= '<div class="abu-accordions' . $sortable_class . '">';
          foreach ( $accordions as $key => $accordion ) {
            if(  $sortable && empty( abu_ekey( 'id', $accordion, '' ) ) ) {
              $o .= '<div class="abu-accordion">' . esc_html__( "You're using sortable. You've have to set single accordion id.", 'AbuFramework' ) . '</div>';
              continue;
            } 
            $accordion_title = abu_ekey( 'title', $accordion, __('Accordion ', 'AbuFramework') . $key );
            $accordion_id    = abu_ekey( 'id', $accordion, $accordion_title );
            $accordion_val   = abu_ekey( $accordion_id, $v );
            $accordion_name  = abu_field_name( $accordion_id, $n );
            $o .= '<div class="abu-accordion ' . ( abu_ekey( 'opened', $accordion, false ) ? 'accordion-opened' : '' ) . '" id="' . $accordion_id . '">';
              $icon = isset( $accordion['icon'] );
              $o .= '<h4 class="abu-accordion-title" data-icon="' . esc_attr( wp_json_encode( $icon ) ) . '">' . abu_ekey( 'icon', $accordion, '<i class="abu-accordion-icon fa fa-angle-right"></i>' ) . $accordion_title . '</h4>';
              $o .= '<div class="abu-accordion-content">';
                if( !abu_iekey( 'fields', $accordion, false ) && empty( $accordion['fields'] ) ) continue;
                foreach ( $accordion['fields'] as $fkey => $field ) {

                  $field['id'] = $field_id = abu_ekey( 'id', $field, abu_ekey( 'title', $accordion, __('Accordion ', 'AbuFramework') . $key ) . '_' . $fkey );
                  $o .= add_abu_sub_tattv( $field, abu_ekey( $field_id, $accordion_val, '' ),  $accordion_name , 'options', $id . '_' . $accordion_id  );


                }
              $o .= '</div>';
            $o .= '</div>';
          }
        $o .= '</div>';
      }
    $o .= '</div>';

    return $this->createField( $o );

  }


}
