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
 * Backup Exporter
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_backup_exporter' ) ) {
  function abu_backup_exporter() {

    if( ! empty( $_GET['options'] ) && ! empty( $_GET['nonce'] ) && wp_verify_nonce( $_GET['nonce'], 'abu_backup_nonce' ) ) {
      
      header('Content-Type: application/json');
      header('Content-disposition: attachment; filename=' . abu_var( 'filename', 'AbuFramework-backup' ) . '-' . gmdate( 'd-m-Y' ) .'.json');
      header('Content-Transfer-Encoding: binary');
      header('Pragma: no-cache');
      header('Expires: 0');

      echo json_encode( get_option( wp_unslash( $_GET['options'] ) ) );

      wp_die();

    }

    return;

  }
  add_action( 'wp_ajax_abu_backup_exporter', 'abu_backup_exporter' );
}


/**
 *
 * Backup Importer
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'abu_backup_importer' ) ) {
  function abu_backup_importer() {

    $p = $_POST;
    $importer = abu_ekey('importer', $p, '');
    $imporder_to = abu_ekey('imporder_to', $p, '');
    $database = abu_ekey( 'database', $p, null );

    if( !empty( $importer ) && !empty( $importer ) && wp_verify_nonce( abu_ekey('secret', $p, ''), 'abu_backup_nonce' ) ) {

      $importer = json_decode( wp_unslash( trim( $importer ) ), true );
      if( is_array( $importer ) ) {
        if( ! is_null($database) ) {
          abu_set_options( [ 'framework_id' => wp_unslash( $imporder_to ), 'database' => $database ], wp_unslash( $importer ) );
        } else {
          if( false === get_option( wp_unslash( $imporder_to ), false ) ) {
            add_option( wp_unslash( $imporder_to ), wp_unslash( $importer ) );
          } else {
            update_option( wp_unslash( $imporder_to ), wp_unslash( $importer ) );
          }
        }
        wp_send_json_success( 'imported', 200 );
      }
    
    }

    if( empty( $importer ) ) {
      wp_send_json_error( array( 'error' => esc_html__( 'Please insert data.', 'AbuFramework' ) ) );
    } elseif ( wp_verify_nonce( abu_ekey('secret', $p, ''), 'abu_backup_nonce' ) ) {
      wp_send_json_error( array( 'error' => esc_html__( 'Secret key does not verified.', 'AbuFramework' ) ) );
    } 

    wp_send_json_error( array( 'error' => esc_html__( 'Something went wrong. Please, Try again.', 'AbuFramework' ) ) );

  }
  add_action( 'wp_ajax_abu_backup_importer', 'abu_backup_importer' );
}
