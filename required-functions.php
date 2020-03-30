<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
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
 * Sanitizing Dir
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */

if( ! function_exists( 'abu_dir' ) ) {
  function abu_dir($dirname = null, $echo = false) {
    $dirname = str_replace('\\\\', '/', $dirname);
    $dirname = str_replace('\\', '/', $dirname);
    $dirname = wp_normalize_path( preg_replace('/([^:])(\/{2,})/', '$1/', $dirname) );
    if ( $echo ) {
      echo $dirname;
    } else {
      return $dirname;
    }
  }
}


/**
 *
 * For Laoding Templates
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_load_template' ) ) {
  function abu_load_template( $template_path = null, $dirConts = ABU_DIR, $exten = 'php', $require_once = true ) {

    
    $output = '';
    global $wp_query;
    
    $output .= abu_dir ( $dirConts . '/' . $template_path . '.' . $exten );

    if ( empty($output) ) return false;

    if( is_object( $wp_query ) && function_exists( 'load_template' ) ) {
      
      load_template( $output, $require_once );
      
    } else {
      
      if( $require_once ) {
        require_once( $output );
      } else {
        include_once( $output );
      }
      
    }
    
    return false;

  }
}



/**
 *
 * Get AbuFramework Located Pad
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_get_located_path' ) ) {
  function abu_get_located_path($type = 'dir') {

    $current        = wp_normalize_path( dirname( __FILE__ ) );
    $wp_plugins     = wp_normalize_path( WP_PLUGIN_DIR );
    $in_plugin      = ( preg_match( '#' . preg_replace("/[^a-zA-Z]+/", "", $wp_plugins) . '#', preg_replace( "/[^a-zA-Z]+/", '', $current ) ) ) ? true : false;
    $path           = wp_normalize_path( ( $in_plugin ) ? $wp_plugins : get_template_directory() );
    $basename       = wp_normalize_path( str_replace( $path, '', $current ) );
    $uri            = ( ( $in_plugin ) ? WP_PLUGIN_URL : get_template_directory_uri() ) . $basename ;
    $path          .= $basename;

    return abu_dir( ( $type == 'uri' ? $uri : $path ) . '/');

  }
}

