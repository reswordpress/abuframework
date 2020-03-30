<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Icon-Picker Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkIconPicker {

  public static $icon_set = [];

  public function __construct() {

  }

  public static function render_picker() {

    $abu_icons = apply_filters( 'abu_icons', json_decode( abu_file_content( ABU_JSON . '\icons.json' ), true ) );

    $o = '<div class="abu-icon-set icon-set abu-ip-wrapper"><div class="abu-icons-dialog-content">';

      $o .= '<div class="abu-ip-top"><div class="abu-ip-search-wrap abu-pull-left"><input type="text" id="abu-icons-search" placeholder="' . __('Search icons...', 'AbuFramework') . '"/></div>';
      $o .= '<div class="abu-ip-select-wrap abu-pull-right"><select id="abu-icon-display">';
            $o .= '<option value="abu-all">' . __('All', 'AbuFramework') . '</option>';
            foreach ($abu_icons as $icon ) {
              if( ! isset($icon['id']) ) continue;
              $o .= '<option value="abu-' . esc_attr( $icon['id'] ) . '">' . abu_ekey( 'title', $icon, ucwords($icon['id'] ) ) . '</option>';
            }
      $o .= '</select></div><div class="abu-clearfix"></div></div>';

      
      

      $o .= '<div class="abu-icons-wrap">';
      foreach ( $abu_icons as $icon ) {

        $id = isset($icon['id']) ? $icon['id'] : false;
        if( $id === false ) continue;
        $icons_set = isset($icon['icons']) ? $icon['icons'] : [];
        $category  = abu_ekey( 'category', $icon, false );

        $o .= '<div class="abu-fontawesome-wrap abu-icon-wrap" id="abu-' . esc_attr( $id ) . '">';

        $o .= '<div class="abu-subicon-display"><h2>' . esc_html( abu_ekey( 'title', $icon, ucwords( $id ) ) ) . '</h2>';

          if( $category !== false ) {
            $o .= '<select id="abu-subicon-display">';
              $o .= '<option value="abu-subicon-all">' . __( 'All', 'AbuFramework' ) . '</option>';
              foreach ( $icons_set as $subicon => $value) {
                $o .= '<option value="abu-subicon-' . $id . '-' . $subicon . '">' . ucwords( $subicon ) . '</option>';
              }
            $o .= '</select>';
          }

        $o .= '</div>';

        if( $category !== false && ! empty($icons_set) ) {
        
          foreach ( $icons_set as $subicon => $icons ) {
            $o .= '<ul class="abu-subicon-' . $id . '-' . $subicon . '" >';
            foreach ( $icons as $key => $i ) {
              $code = isset( $i['abu-code'] )   ? $i['abu-code'] : '';
              $label = isset( $i['abu-label'] ) ? $i['abu-label'] : '';
              $class = isset( $i['abu-class'] ) ? $i['abu-class'] : '';
              $o .= '<li abu-type="abu-icon" data-code="' . esc_attr( $code ) . '" data-class="' . esc_attr( $class ) . '" data-label="' . esc_attr( $label ) . '" class=""><i class="' . esc_attr( $class ) . '"></i></li>';
            }
            $o .= '</ul>';
          }

        }


        $o .= '</div>';
      }
      $o .= '</div>';

    $o .= '</div></div>';

    return $o;

  }


}
