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
    return ( !empty( $value ) && boolval( $value ) ? true : false );
  }
}

/**
 * Checkbox sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_checkbox' ) ) {
  function abu_sanitize_checkbox( $value ) {

    if( is_array( $value ) ) {
      foreach( $value as $key => $val ) {
        $value[$key] = esc_attr( $val );
      }
      return $value;
    }
    return is_string( $value ) ? ( !empty( $value ) ? true : false ) : '';

  }
}

/**
 * Button Group sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_button_group' ) ) {
  function abu_sanitize_button_group( $value ) {

    if( is_array( $value ) ) {
      foreach( $value as $key => $val ) {
        $value[$key] = esc_attr( $val );
      }
      return $value;
    }
    return is_string( $value ) ? ( !empty( $value ) ? true : false ) : '';

  }
}

/**
 * Upload sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_upload' ) ) {
  function abu_sanitize_upload( $value, $field ) {
    
    if( is_array( $value ) ) {
      
      foreach( $value as $k => $v ){
        $v = json_decode( stripcslashes($v), true );        
        $value[$k] =wp_json_encode( empty( $v ) && ! isset( $v['id'] ) ? [] : $v );
      }
      return $value; 

    }
    
    if( is_string( $value )  ) {
      $value = json_decode( stripcslashes($value), true );
      return wp_json_encode( empty( $value ) && ! isset( $value['id'] ) ? [] : $value );
    }

    return ( is_numeric( $value ) ? abu_sanitize_number( $value ) : esc_attr( $value ) );
    
  }
}

/**
 * Radio sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_radio' ) ) {
  function abu_sanitize_radio( $value ) {
    if ( is_string( $value ) ) {
      return esc_attr( $value );
    }
    return '';
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
    return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
  }
}

/**
 * Spinner sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_spinner' ) ) {
  function abu_sanitize_spinner( $value ) {
    if( ! is_array( $value ) ) return [ 'value' => 0 ];
    $value['unit']  = esc_attr( abu_ekey( 'unit', $value, '' ) );
    $value['value'] = filter_var(abu_ekey( 'value', $value, 0 ), FILTER_SANITIZE_NUMBER_INT);
    return $value;
  }
}

/**
 * Range Slider sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_range_slider' ) ) {
  function abu_sanitize_range_slider( $value ) {
    
    if( is_array($value) ) {
      foreach ($value as $key => $v) {
        $value[$key] = filter_var($v, FILTER_SANITIZE_NUMBER_INT);
      }
      return $value;
    }

    return is_string( strval( $value ) ) ? filter_var( $value, FILTER_SANITIZE_NUMBER_INT) : 0;

  }
}

/**
 * Slider sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_slider' ) ) {
  function abu_sanitize_slider( $value ) {
    return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
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
 * Code Editor sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_code_editor' ) ) {
  function abu_sanitize_code_editor( $value, $field ) {
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
 * Color Palette sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_color_palette' ) ) {
  function abu_sanitize_color_palette( $value ) {

    if( is_string( $value ) ) {
      return esc_attr( $value );
    }

    return '';
    
  }
}

/**
 * Select sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_select' ) ) {
  function abu_sanitize_select( $value ) {

    if( is_array( $value ) ) {
      foreach( $value as $key => $val ) {
        $value[$key] = esc_attr( $val );
      }
      return $value;
    }

    if ( is_string( $value ) ) {
      return esc_attr( $value );
    }
    return '';
  }
}

/**
 * Image Select
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_image_select' ) ) {
  function abu_sanitize_image_select( $value ) {

    if( is_array( $value ) ) {
      foreach( $value as $key => $val ) {
        $value[$key] = esc_attr( $val );
      }
      return $value;
    }

    if ( is_string( $value ) ) {
      return esc_attr( $value );
    }
    return '';
  }
}


/**
 * Sorter sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_sorter' ) ) {
  function abu_sanitize_sorter( $value, $field ) {

    if( is_array( $value ) ) {
      foreach( $value as $key => $val ) {
        if( is_array( $val ) ) {
          foreach( $val as $kk => $vv ) {
            $value[esc_attr( $key )][esc_attr( $kk )] = esc_attr( $vv );
          }
          continue;
        }
        $value[esc_attr( $key )] = [];
      }
      return $value;
    }
    $value = [];
    foreach( $field['sorters'] as $s ) {
      $value[$s['id']] = $s['list'];
    }
    return $value;

  }
}

/**
 * Sorter sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_icon' ) ) {
  function abu_sanitize_icon( $value ) {

    if( is_array( $value ) ) {
      foreach( $value as $key => $val ) {
        
        $value[esc_attr( $key )] = esc_attr( $val );
      }
      return $value;
    }
    return is_string( $value ) ? esc_attr( $value ) : [];

  }
}

/**
 * Animate sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_animate' ) ) {
  function abu_sanitize_animate( $value ) {

    if( is_array( $value ) ) {
      foreach( $value as $key => $val ) {
        
        $value[esc_attr( $key )] = esc_attr( $val );
      }
      return $value;
    }

    return is_string( $value ) ? esc_attr( $value ) : [];

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
        $value['all'] =  filter_var($value['all'], FILTER_SANITIZE_NUMBER_INT);
        return $value;
      }
      if( isset($value['top']) ) $value['top']      = filter_var($value['top'], FILTER_SANITIZE_NUMBER_INT);
      if( isset($value['right']) ) $value['right']  = filter_var($value['right'], FILTER_SANITIZE_NUMBER_INT);
      if( isset($value['bottom']) ) $value['bottom']= filter_var($value['bottom'], FILTER_SANITIZE_NUMBER_INT);
      if( isset($value['left']) ) $value['left']    = filter_var($value['left'], FILTER_SANITIZE_NUMBER_INT);
      return $value;

    }

    return [];
    
  }
}

/**
 * dimensions sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_dimensions' ) ) {
  function abu_sanitize_dimensions( $value ) {

    if( is_array( $value ) ) {

      if( isset($value['unit'])  ) $value['unit'] = esc_attr( $value['unit'] );
      if( isset($value['width']) ) $value['width']      = filter_var($value['width'], FILTER_SANITIZE_NUMBER_INT);
      if( isset($value['right']) ) $value['height']  = filter_var($value['height'], FILTER_SANITIZE_NUMBER_INT);
      return $value;

    }

    return is_string( $value ) ? esc_attr( $value ) : '';
    
  }
}

/**
 * Border sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_spacing' ) ) {
  function abu_sanitize_spacing( $value ) {

    if( is_array( $value ) ) {

      if( isset($value['unit'])  ) $value['unit'] = esc_attr( $value['unit'] );
      if( isset($value['all']) ) {
        $value['all'] =  filter_var($value['all'], FILTER_SANITIZE_NUMBER_INT);
        return $value;
      }

      if( isset($value['top']) ) $value['top']      = filter_var($value['top'], FILTER_SANITIZE_NUMBER_INT);
      if( isset($value['right']) ) $value['right']  = filter_var($value['right'], FILTER_SANITIZE_NUMBER_INT);
      if( isset($value['bottom']) ) $value['bottom']= filter_var($value['bottom'], FILTER_SANITIZE_NUMBER_INT);
      if( isset($value['left']) ) $value['left']    = filter_var($value['left'], FILTER_SANITIZE_NUMBER_INT);
      return $value;

    }

    return is_string( $value ) ? esc_attr( $value ) : '';
    
  }
}

/**
 * Border sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_sortable' ) ) {
  function abu_sanitize_sortable( $value, $field ) {

    if( is_array( $value ) ) {

      return abu_sanitization_validation_escaping( $value, $field['fields'] )['request'];

    }

    return is_string( $value ) ? esc_attr( $value ) : '';
    
  }
}

/**
 * Accordion sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_accordion' ) ) {
  function abu_sanitize_accordion( $value, $field ) {

    if( is_array( $value ) ) {

      $accordions = $field['accordions'];
      if( ! isset( $field['accordions'] ) ) return $value;
      foreach ($value as $k => $v) {
        foreach ( $accordions as $key => $accordion) {
          $accordion_title = abu_ekey( 'title', $accordion, __('Accordion ', 'AbuFramework') . $key );
          $accordion_id    = abu_ekey( 'id', $accordion, $accordion_title );
          if( $accordion_id == $k ){
            unset( $accordions[$key] );
            if( ! isset( $accordion['fields'] ) ) continue;
            $value[$k] = abu_sanitization_validation_escaping( $v, $accordion['fields'] )['request'];
          }
        }
      }
      
      return $value; 

    }

    return is_string( $value ) ? esc_attr( $value ) : '';
    
  }
}

/**
 * Fieldset sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_fieldset' ) ) {
  function abu_sanitize_fieldset( $value, $field ) {

    if( is_array( $value ) ) {
      
      return abu_sanitization_validation_escaping( $value, $field['fields'] )['request']; 
      
    }

    return is_string( $value ) ? esc_attr( $value ) : '';
    
  }
}

/**
 * Tabs sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_tabs' ) ) {
  function abu_sanitize_tabs( $value, $field ) {

    if( is_array( $value ) ) {

      $tabs = $field['tabs'];
      if( ! isset( $field['tabs'] ) ) return $value;
      foreach ($value as $k => $v) {
        foreach ( $tabs as $key => $tab) {
          $tab_title = abu_ekey( 'title', $tab, __( 'Tab', 'AbuFramework' ) . ' ' . $key );
          $tab_id    = abu_ekey( 'id', $tab, $tab_title );
          if( $tab_id == $k ){
            unset( $tabs[$key] );
            if( ! isset( $tab['fields'] ) ) continue;
            $value[$k] = abu_sanitization_validation_escaping( $v, $tab['fields'] )['request'];
          }
        }
      }
      
      return $value; 

    }

    return is_string( $value ) ? esc_attr( $value ) : '';
    
  }
}


/// This is for edit/remove. If, You do it. Please be carefull during any changes. It may harm to full Framework
if( ! function_exists( 'abu_sanitize_before_nestables' ) ) {
  function abu_sanitize_before_nestables( $value ) {
    $s = isset( $value['serialized'] ) ? json_decode( stripslashes_deep( $value['serialized']), true ) : '';
    $values = isset( $value['values'] ) ? $value['values'] : [];
    if( is_array( $s ) && empty( $s ) && empty( $values ) ) return null;
    $o = abu_nestables_value_comb( $values, $s );
    return ($o);
  }
}

/**
 * Nestables sanitize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitize_nestables' ) ) {
  function abu_sanitize_nestables( $value, $field ) {

    if( is_array( $value ) ) {
      
      if( ! isset( $field['fields'] ) && ! is_array( $field['fields'] ) ) return $value;
      $f = $field['fields'];

      foreach ($value as $k => $v) {
        $value[$k]['values'] = abu_sanitization_validation_escaping( $value[$k]['values'], $f )['request'];
        if( isset( $v['children'] ) ) {
          $value[$k]['children'] = abu_sanitize_nestables( $v['children'], $field );
        }
      }
      return $value; 

    }

    return is_string( $value ) ? esc_attr( $value ) : '';
    
  }
}
