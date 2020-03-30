<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * 
 * Sanitizing value's function | AbuFramework
 * 
 * !Don't remove this!
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

/**
 * Text sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_text' ) ) {
  function abu_sanitize_text( $value ) {
    return sanitize_text_field( $value ) ;
  }
}

/**
 * Toggle sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_toggle' ) ) {
  function abu_sanitize_toggle( $value ) {
    return ( !empty( $value ) ? true : false );
  }
}

/**
 * Number sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_number' ) ) {
  function abu_sanitize_number( $value ) {
    return ( is_numeric( $value ) ? $value : 0 ) ;
  }
}

/**
 * Textarea sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_textarea' ) ) {
  function abu_sanitize_textarea( $value ) {
    return sanitize_textarea_field( $value );
  }
}

/**
 * Color_picker sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_color_picker' ) ) {
  function abu_sanitize_color_picker( $value ) {

    if ( empty( $value ) || !is_string( $value ) ) return '';

    if ( false !== strpos( $value, '#' ) ) {
      return sanitize_hex_color( $value );
    } elseif ( false !== strpos( $value, 'rgba' ) ) {
      sscanf( str_replace( ' ', '', $value ), 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
      return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
    } elseif ( false !== strpos( $value, 'rgb' ) ){
      sscanf( str_replace( ' ', '', $value ), 'rgb(%d,%d,%d)', $red, $green, $blue );
      return 'rgba('.$red.','.$green.','.$blue.',1)';
    } else {
      return $value;
    }

    
  }
}

/**
 * Link Color sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_link_color' ) ) {
  function abu_sanitize_link_color( $value ) {

    if( is_array( $value ) ) {
      foreach( $value as $key => $val ) {
        $value[$key] = abu_sanitize_color_picker( $val );
      }
      return $value;
    }

    if( is_string( $value ) ) {
      return abu_sanitize_color_picker( $value );
    }

    return '';
    
  }
}

/**
 * gradient sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_gradient' ) ) {
  function abu_sanitize_gradient( $value ) {

    if( is_array( $value ) ) {
      foreach( $value as $key => $val ) {
        $value[$key] = abu_sanitize_color_picker( $val );
      }
      return $value;
    }

    if( is_string( $value ) ) {
      return abu_sanitize_color_picker( $value );
    }

    return '';
    
  }
}

/**
 * Border sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_border' ) ) {
  function abu_sanitize_border( $value ) {

    if( is_array( $value ) ) {

      if( isset($value['color']) ) $value['color'] = abu_sanitize_gradient( $value['color'] );
      if( isset($value['style']) ) $value['style'] = esc_attr( $value['style'] );
      if( isset($value['unit'])  ) $value['unit'] = esc_attr( $value['unit'] );

      if( isset($value['all']) ) {
        $value['all'] = is_numeric( $value ) ? $value : '';
        return $value;
      }
      if( isset($value['top']) ) $value['top'] = is_numeric( $value['top'] ) ? $value['top'] : '';
      if( isset($value['right']) ) $value['right'] = is_numeric( $value['right'] ) ? $value['right'] : '';
      if( isset($value['bottom']) ) $value['bottom'] = is_numeric( $value['bottom'] ) ? $value['bottom'] : '';
      if( isset($value['left']) ) $value['left'] = is_numeric( $value['left'] ) ? $value['left'] : '';
      return $value;

    }

    return [];
    
  }
}


/// This is for edit/remove. If, You do it. Please be carefull during any changes. It may harm to full Framework
if( ! function_exists( 'abu_sanitize_nestables' ) ) {
  function abu_sanitize_nestables( $value, $field ) {
    $s = isset( $value['serialized'] ) ? json_decode( stripslashes_deep( $value['serialized']), true ) : '';
    $values = isset( $value['values'] ) ? $value['values'] : [];
    if( is_array( $s ) && empty( $s ) && empty( $values ) ) return null;
    $o = abu_nestables_value_comb( $values, $s );
    return ($o);
  }
}
