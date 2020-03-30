<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * 
 * All AbuFramework Short Functions
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
 * Check array, is Associative
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_assoc' ) ) {
   function abu_assoc( $arr ) {
       if( ! is_array($arr) ) return false;
       if (array() === $arr) return false;
       return array_keys($arr) !== range(0, count($arr) - 1);
   }
}

/**
 *
 * Check value exit in array
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_ekey' ) ) {
   function abu_ekey($value = null, $array = null, $false = null) {

      if( is_array( $value ) ) {
         foreach ($value as $values) {
           if( isset($array) && is_array($array) && array_key_exists($values, $array) ) {
             return $array[$values];
           }
         }
      } else {
         if( isset($array) && is_array($array) && array_key_exists($value, $array) ) {
            return $array[$value];
         } 
      }

      return $false;

   }
}

/**
 *
 * Only Check value exit in array
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_iekey' ) ) {
   function abu_iekey($value = null, $array = null) {
       if( isset($array) && is_array($array) && array_key_exists($value, $array) ) {
          return true;
       } else {
          return false;
       }
   }
}

/**
 *
 * nested-Merge array
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_field_extra' ) ) {
  function abu_field_extra( $args, $defaults, $sort = false ){

   $new_args = (array) $defaults;
   
   foreach ( $args as $key => $value ) {
       if ( is_array( $value ) && isset( $new_args[ $key ] ) ) {
           $new_args[ $key ] = abu_field_extra( $value, $new_args[ $key ] );
       }
       else {
           $new_args[ $key ] = $value;
       }
   }

   if( $sort ) ksort($new_args);
   return $new_args;

  }
}

/**
 *
 * Set URI of file
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_load_file' ) ) {
   function abu_load_file($n = null, $p = null, $t = null) {
       if( $n != null && $p != null && $t != null ) {
         $o = abu_dir( $p . $n . ABU_MIN . '.'  . $t );
       } else {
         $o = __( "Can\'t Load File : ", 'AbuFramework' ) . '"' . $p . $n . '.' . $t . '"';
       }
       return $o;
   }
}

/**
 *
 * Return only string
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_only_string' ) ) {
   function abu_only_string($text) {
      return preg_replace("/[^a-zA-Z]+/", "", $text);
   }
}


/**
 *
 * Removing White space
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_wspace' ) ) {
 function abu_wspace($text) {
   return trim( preg_replace( '/[\t\n\r\s]+/', ' ', $text) );
 }
}


/**
 *
 * Attribute Helper
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_input_attribute_helper' ) ) {
   function abu_input_attribute_helper( $helper, $current, $type = 'checked', $echo = false ) {
     if ( (string) $helper === (string) $current ) {
         $result = " $type='$type'";
     } else {
         $result = '';
     }

     if ( $echo ) { echo $result; }

     return $result;
   }
}

 
/**
 *
 * Dependency Helper
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_depend_helper' ) ) {
   function abu_depend_helper( $field = [], $value = null ){
      $o = '';
      if( isset( $field['depend'] ) ) {
         $o  .= ' abu-depend-controller="' . esc_attr( $field['depend'][0] ) . '" ';
         $o  .= 'abu-depend-condition="' . esc_attr( $field['depend'][1] ) . '" ';
         $dependValue      = $field['depend'][2];
         $o  .= 'abu-depend-value="' . esc_attr( strval( is_array( $dependValue ) ? implode( ',', $dependValue ) : $dependValue ) ) . '" ';
      } elseif ( isset( $field['dependency'] ) ) {
         $o  .= ' abu-depend-controller="' . esc_attr( $field['dependency'][0] ) . '" ';
         $o  .= 'abu-depend-condition="' . esc_attr( $field['dependency'][1] ) . '" ';
         $dependValue = $field['dependency'][2];
         $o  .= 'abu-depend-value="' . esc_attr( is_array( $dependValue ) ? implode( ',', $dependValue ) : $dependValue ) . '" ';
      }
      return $o;
   }
}


/**
 *
 * Adding Attribute Helper
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_attr' ) ) {
   function abu_attr( $type, $value ) {
       return ' ' . $type . '=' . '"' . esc_attr( is_array( $value ) ? implode(' ', $value) : strval($value ) ) . '" ';
   }
}


/**
 *
 * Joining Attribute from array
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'abu_array_atr' ) ) {
   function abu_array_atr(  array $args ) {
      
      if( empty( $args ) ) return '';
      $o = '';
      foreach ($args as $key => $value) {
         if( $value == 'key-only' ) {
            $o .= ' ' . esc_attr( $key ) . ' ';
            continue;
         }
         $o .= $key . '="' . esc_attr( $value ) . '" ';
      }

      return $o;

   }
}

/**
 *
 * Array to string
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_array_str' ) ) {
 function abu_array_str( $array = null, $echo = false ) {
    
   $o = ' ' . ( is_array($array) ? implode( ' ', $array ) : $array ) . ' ';
   if( $echo ) echo $o;
   return $o;

 }
}

/**
 *
 * Section id setting helper
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_secid' ) ) {
   function abu_secid($text) {
      return sanitize_key( $text );
   }
}


/**
 *
 * Setting name Helper
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_field_name' ) ) {
   function abu_field_name( string $value = '', string $id = '', $last = null) {
      $o = '';
       if( !( empty( $value ) && empty( $id ) ) ) {
          $o = $id . '[' . $value . ']' . $last ;
       } elseif( empty( $id ) ) {
          $o = $value . $last ;
       }
      return esc_attr( $o );
   }
}


/**
 *
 * HTML Image Tag
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_imgtag' ) ) {
   function abu_imgtag( $url = false , $alt = false, $title = false, $echo = false ) {
      $o = ' <img ';
        $o .= ( $url ? abu_attr( $url, 'src' ) : '' );
        $o .= ( $alt ? abu_attr( $alt, 'alt' ) : '' );
        $o .= ( $title ? abu_attr( $title, 'title' ) : '' );
      $o .= ' /> ';
      return $o;
   }
}

/**
 *
 * Adding class Helper
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_addClass_tattv' ) ) {
 function abu_addClass_tattv( $key = null, $array = null, $class = null, $echo = false ) {
   $o = '';
   $keys = abu_ekey( $key, $array, '' );
   if( is_array($keys) ) {
     $o = implode( ' ', $keys ) . $class;
   } else {
     $o = $keys . $class;
   }

   if( $echo ) {
     echo $o;
   }

   return $o;

 }
}


/**
 *
 * Get $_POST & $_GET variable
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'abu_var' ) ) {
   function abu_var(  string $variable, $default = '' ) {
 
     if( isset( $_POST[$variable] ) ) {
       return $_POST[$variable];
     }
 
     if( isset( $_GET[$variable] ) ) {
       return $_GET[$variable];
     }
 
     return $default;
 
   }
}


/**
 *
 * Getting Options
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'abu_get_options' ) ) {
   function abu_get_options( string $db, string $id, $default = [] ) {

      if( empty($id) || empty($db) ) return $default;

      if( $db === 'theme_mod' ) {
         $o = get_theme_mod( $id, $default );
      } else if( $db === 'transient' ) {
         $o = get_transient( $id );
      } else if( $db === 'network' ) {
         $o = get_site_option( $id, $default );
      } else {
         $o = get_option( $id, $default );
      }

      return ( empty( $o ) ? [] : $o );
 
   }
}


/**
 *
 * Setting Options
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'abu_set_options' ) ) {
   function abu_set_options( $args, $values = [], $all_reset = false, $get = false ) {

      if( ! isset($args['framework_id']) || ! isset($args['database']) || empty( $values ) && ! $get ) return;

      $db = $args['database'];
      $id = $args['framework_id'];


      if( $db === 'theme_mod' ) {

         $all_reset = $all_reset ? [] : get_theme_mod( $id, [] );
         if( $get ) return $all_reset;
         $values = array_merge( $all_reset, $values );
         $o = set_theme_mod( $id, $values );

      } else if( $db === 'transient' ) {

         $all_reset = $all_reset ? [] : get_transient( $id, [] );
         if( $get ) return $all_reset;
         $values = array_merge( $all_reset, $values );
         $o = set_transient( $id, $values, $args['transient_expiration'] );

      } else if( $db === 'network' ) {

         $all_reset = $all_reset ? [] : get_site_option( $id, [] );
         if( $get ) return $all_reset;
         $values = array_merge( $all_reset, $values );
         $o = update_site_option(  $id, $values );

      } else {
         $all_reset = $all_reset ? [] : get_option( $id, [] );
         if( $get ) return $all_reset;
         $values = array_merge( $all_reset, $values );
         $o = update_option( $id, $values );
      }

      return $o;
 
   }
}


/**
 *
 * Preparatin of Nestables Values
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_nestables_value_comb' ) ) {
  function abu_nestables_value_comb( $v, $ss ) {
   
   if( ! is_array($ss) ) return []; 
   $o = [];

   if( ! empty( $v ) ) {
      foreach( $ss as $key => $s ) {
         $o[$s['id']]['values'] = isset( $v[$s['id']] ) ? $v[$s['id']] : [];
         $o[$s['id']]['title']  = isset( $s['title'] ) ? $s['title'] : '';
         $o[$s['id']]['id']  = $s['id'];
         if( isset($s['children']) ) {
            $o[$s['id']]['children'] = abu_nestables_value_comb( $v, $s['children'] );
         }
   
      }
   } else {
      if( !is_array($ss) || empty($ss) ) return $o; 
      foreach( $ss as $key => $s ){
         
         $o[$s['id']]['values'] = '';
         $o[$s['id']]['title']  = isset( $s['title'] ) ? $s['title'] : '';
         $o[$s['id']]['id']  = $s['id'];
         if( isset($s['children']) ) {
            $o[$s['id']]['children'] = abu_nestables_value_comb( '', $s['children'] );
         }
      }
   }
   
   return $o;

  }
}


/**
 *
 * Get Random String
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_rand_str' ) ) {
  function abu_rand_str( $length = 5, $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' ) {

   return substr(str_shuffle(str_repeat($string, ceil($length/strlen($string)) )),1,$length);
 
  }
}


if( ! function_exists( 'abu_file_content' ) ) {
   function abu_file_content( $path ) {
   
      global $wp_filesystem;
      require_once ( ABSPATH . '/wp-admin/includes/file.php' );
      WP_Filesystem();
      
      if ( $wp_filesystem->exists( $path ) ) {
         return $wp_filesystem->get_contents( $path );
      } 
   
      return '';
   
   }
}