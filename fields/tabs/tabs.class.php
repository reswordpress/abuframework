<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Tabs Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_tabs extends abuFrameworkFields {


  public function __construct( $f, $v = '', $name = '', $place = '' ) {
    parent::__construct( $f, $v, [], $name, $place );
  }

  public function render_field(){

    $f = $this->f;
    $v = $this->value_tattv();
    $n = $this->name_tattv();

    $title   = '';
    $content = '';

    $o = '<div class="abu-tabs-wrapper">';
      if( is_array( abu_ekey( 'tabs', $f, false ) ) ) {
        $o .= '<div class="abu-tabs">';
          foreach ( $f['tabs'] as $key => $tab ) {

            $tab_title = abu_ekey( 'title', $tab, __( 'Tab', 'AbuFramework' ) . ' ' . $key );
            $tab_id    = abu_ekey( 'id', $tab, $tab_title );
            $tab_val   = abu_ekey( $tab_id, $v );
            $tab_name  = abu_field_name( $tab_id, $n );

            $title .= '<a class="abu-tab-title' . ( abu_ekey( 'opened', $tab, false ) ? ' abu-tab-opened' : '' ) . '" abu-tab-target="' . $f['id'] . '_' . esc_attr( $tab_id ) . '" data-icon="' . esc_attr( wp_json_encode( isset( $tab['icon'] ) ) ) . '">' . abu_ekey( 'icon', $tab, '<i class="abu-tab-icon fa fa-angle-right"></i>' ) . esc_html( $tab_title ) . '</a>';

            if( !abu_iekey( 'fields', $tab, false ) && empty( $tab['fields'] ) ) continue;
            $content .= '<div class="abu-tab-content" id="' . $f['id'] . '_' . $tab_id . '">';
              foreach ( $tab['fields'] as $fkey => $field ) {
                $field['id']   = abu_ekey( 'id', $field, abu_ekey( 'title', $tab, __( 'Tab', 'AbuFramework' ) . ' ' . $key ) . '_' . $fkey );
                $content .= add_abu_sub_tattv( $field, abu_ekey( $field['id'], $tab_val, '' ), $tab_name, 'options', $f['id'] . '_' . $tab_id  );
              }
            $content .= '</div>';
            

          }
          $o .= '<div class="abu-tab-titles">' . $title . '</div>';
          $o .= '<div class="abu-tab-contents">' . $content . '</div>';
        $o .= '</div>';
      }
    $o .= '</div>';

    return $this->createField( $o );

  }


}
