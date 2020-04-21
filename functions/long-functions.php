<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * 
 * All AbuFramework Long Function
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
 *
 * Get Fields types
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_fields_types' ) ) {
  function abu_fields_types($array = [], $key = '') {
    $results = array();
    foreach ($array as $k1 => $v1 ) {
      if( is_array( $v1 ) ) {
        foreach ($v1 as $k2 => $v2 ) {
          if( $k2 == $key ) {
            $results[] = $v2;
          }
          if( is_array( $v2 ) ) {
            $results[] = abu_fields_types($v2, $key);
          }
        }
      }
    }
    return $results;
  }
}

/**
 *
 * Get Boolean Value
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */

if( ! function_exists( 'abuBoolean' ) ) {
  function abuBoolean( $value ) {
    $o;
    if( $value != '' && strlen( $value ) <= 7 && gettype( $value ) != 'boolaen'){
      switch( strtolower( $value ) ) {
        case true:
        case 'true':
        case 1:
        case '1':
        case 'on':
        case 'yes':
        case 'enable':
        case 'enabled':
          $o = true;
        break;
        case false:
        case 'false':
        case 0:
        case '0':
        case 'off':
        case 'no':
        case 'disable':
        case 'disabled':
          $o = false;
        break;
      }
    }
    $o = $value;
    return boolval( $o );
  }
}


/**
 *
 * Adding a Field
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'add_abu_tattv' ) ) {
 function add_abu_tattv( $field = [], $value = '', $name = '', $place = '' ) {

   $o = '';
   $abu_element_type = abu_ekey( 'type', $field, ''  );
   $abufield       = 'abuFrameworkField_' . str_replace('-', '_', strtolower($abu_element_type) );

   if( $value == '' ) {
     $value = isset( $field['default'] ) ? $field['default'] : $value;
     $value = isset( $field['value'] ) ? $field['value'] : $value;
   }
   
   if( abu_iekey( 'type', $field ) && abu_iekey( 'id', $field ) ) {

     if( ! class_exists( $abufield ) ) AFW::might_include( $field['type'] );
     
     if( class_exists( $abufield ) ) {
       ob_start();
       $o .= ( new $abufield( $field, $value, $name, $place ) )->render_field();
       $o .= ob_get_contents();
       ob_end_clean();
     } else {
       $o .= '<div class="abu-element"><p class="abu-noticed abu-danger">'. esc_html__( 'This field class is not available!', 'AbuFramework' ) . $abufield .'</p></div>';
     }
   } else {
      if( ! abu_iekey( 'type', $field ) ) {
        $o .= '<div class="abu-element"><p class="abu-noticed abu-danger">'. esc_html__( '"type" doesn\'t exits!', 'AbuFramework' ) .'</p></div>';
      } elseif( ! abu_iekey( 'id', $field ) ) {
        $o .= '<div class="abu-element"><p class="abu-noticed abu-danger">'. esc_html__( '"id" doesn\'t exits!', 'AbuFramework' ) .'</p></div>';
      }
   }
   return $o;

 }
}


/**
 *
 * Adding a Sub-Field
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'add_abu_sub_tattv' ) ) {
 function add_abu_sub_tattv( $field = array(), $value = '', $name = '', $place = '', $parent = '' ) {
   
   if( ! abu_iekey( 'type', $field ) ) {
     return '<p class="abu-noticed abu-danger">'. esc_html__( '"type" doesn\'t exits!', 'AbuFramework' ) .'</p>';
   } elseif( ! abu_iekey( 'id', $field ) ) {
     return '<p class="abu-noticed abu-danger">'. esc_html__( '"id" doesn\'t exits!', 'AbuFramework' ) .'</p>';
   }
   $field['depend_id']     = $parent . '_' . $field['id'];
  //  $field['id']            = $parent . '_' . $field['id'];
   $field['element-class'] = abu_addClass_tattv( 'element-class', $field, ' abu-sub-element ' );
   $field['title-class']   = abu_addClass_tattv( 'title-class', $field, ' abu-sub-title-wrap ' );
   $field['field-class']   = abu_addClass_tattv( 'field-class', $field, ' abu-sub-field-wrap ' );


   return add_abu_tattv( $field, $value, $name, $place );

 }
}


/**
 *
 * Get all Sections in one array
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_all_sections' ) ) {
 function abu_all_sections($array) {
   $o = [];
   foreach ($array as $key => $value) {
    //  unset( $value['fields'] );
     $value['empty'] = count( abu_ekey( 'fields', $value, [] ) ) > 0 ? true : false;
    //  ad( $value );
     $o[] = $value;
     if( abu_iekey( 'sub-section', $value ) && is_array( $value['sub-section'] )  ) {
       foreach ( $value['sub-section'] as $skey => $svalue) {
         $o[$key]['empty'] = count( abu_ekey( 'fields', $value, [] ) ) ? true : false;
         $o[] = $svalue;
       }
     }
   }
   return $o;
 }
}


/**
 *
 * Get all Sections in one array
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sections_sort' ) ) {
  function abu_sections_sort( array $sections, int $priorities = 120 ) {

    $bachhe = [];
    $parent_priority = $priorities + 0;
    $child_priority = $priorities + 0;

    foreach( $sections as $key => $section ) {
      $sections[$key]['empty'] = count( abu_ekey( 'fields', $section, [] ) ) ? false : true ;
      $sections[$key]['priority'] = ( isset( $section['priority'] ) ) ? $section['priority'] : $parent_priority;
      if( isset( $section['parent'] ) && ! empty( $section['parent'] ) ) {
        $bachhe[] = $sections[$key];
        unset( $sections[$key] );
      }
      $parent_priority++;
    }

    
    foreach( $sections as $key => $section ) {
      $sections[$key]['empty'] = count( abu_ekey( 'fields', $section, [] ) ) ? false : true ;
      if( ! empty( $section['id'] ) ) {
        foreach ( $bachhe as $skey => $bachhA ) {
          if( $section['id'] == $bachhA['parent'] ) {
            $bachhA['priority'] = ( isset( $bachhA['priority'] ) ) ? $bachhA['priority'] : $priorities;
            if( ! empty($bachhA) ) $sections[$key]['sub-section'][] = $bachhA;
            unset( $bachhe[$skey] );
          }
          $priorities++;
        }
        if( ! empty( $sections[$key]['sub-section'] ) )
           $sections[$key]['sub-section'] = wp_list_sort( $sections[$key]['sub-section'], array( 'priority' => 'ASC' ), 'ASC', true );
        else 
           $sections[$key]['sub-section'] = false;
      }
    }

    foreach ( $bachhe as $skey => $bachhA ) {
      $sections[] = $bachhA;
      unset( $bachhe[$skey] );
    }

    return array_values( wp_list_sort( $sections, array( 'priority' => 'ASC' ), 'ASC', true ) );

  }
}

/**
 *
 * Get all Fields in one array
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_get_fields' ) ) {
 function abu_get_fields($sections) {
   $o = [];
   foreach ($sections as $section) {
    if( abu_iekey('sub-section') ) $o = array_merge( $o, abu_get_fields($section) );
    if( ! abu_iekey('fields', $section ) ) continue;
    $o = array_merge( $o, $section['fields'] );
   }
   return $o;
 }
}


/**
 *
 * Getting Sanitizated Validated values
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sanitization_validation_escaping' ) ) {
  function abu_sanitization_validation_escaping( $r, $f, $e = [] ) {
    
    if( ! empty($r) ) {
      foreach ($f as $field ) {
  
        // Skipping undefined ids
        if( ! abu_iekey( 'id', $field, false ) ) continue;
  
        $value = isset( $r[$field['id']] ) ? $r[$field['id']] : '';
        $type  = isset( $field['type'] ) ? $field['type'] : '';
        $id    = $field['id'];

        if( isset( $field['before_senitize'] ) ) {
          if( function_exists( $field['before_senitize'] ) ) {
            $value =  call_user_func( $field['before_senitize'], $value, $field );
          }
        } else {
          // Default AbuFramework's Sanitize values
          $senitize = 'abu_sanitize_before_' . str_replace( '-', '_', strtolower( $type ));
          if( function_exists( $senitize ) ) {
            $value = call_user_func( $senitize, $value, $field  );
          }
        }
        
        // Sanitizing Value
        if( isset( $field['senitize'] ) ) {
          
          if( function_exists( $field['senitize'] ) ) {
            $value =  call_user_func( $field['senitize'], $value, $field );
          }
          
  
        } else {
          

          // Default AbuFramework's Sanitize values
          $senitize = 'abu_sanitize_' . str_replace( '-', '_', strtolower( $type ));
          if( function_exists( $senitize ) ) {
            $value = call_user_func( $senitize, $value, $field  );
          }
  
        }
  
        // Validating Value
        if( isset( $field['validate'] ) && function_exists( $field['validate'] ) ) {
          $validation =  call_user_func( $field['validate'], $value, $field, $e );
          if( ! empty( $validation ) ) {
            $r[$id] = $value; // Setting Up last Value.
            $e[$id] = $validation; // Setting up error text.
            continue;
          }
          
        }
        
        $r[ $id ] = $value;
        continue;
        
      }
    }

    if( empty( $e ) ) $e = [ 'success' ];

    return [ 'request' => $r, 'errors' => $e ];

  }
}


/**
 *
 * Seting fields name under section id
 * option_id[section_id][field_name]
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_sections_names' ) ) {
  function abu_sections_names( array $sections, string $id = '' ){
    $o = $sections;
    foreach ( $o as $key => $section ) {
      $o[$key]['name'] = abu_field_name( $section['id'] , $id );
      if( abu_iekey( 'fields', $section, false ) && ! empty( $section['fields'] ) ) {
        foreach ( $section['fields'] as $fkey => $field ) {
          $o[$key]['fields'][$fkey]['name'] = abu_field_name( strval( $field['id'] ) , strval( $o[$key]['name'] ) );
        }
      }
    }
    return $o;
  }
}

