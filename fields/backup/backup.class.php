<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Backup field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */


class abuFrameworkField_backup extends abuFrameworkFields {


  public function __construct( $f, $v = '', $name = '', $place = '' ) {
    parent::__construct( $f, $v, [], $name, $place );
  }

  public function render_field() {

    $id = $this->_id;
    $f = $this->f = abu_field_extra( $this->f, [
      'full-width' => true, 
      'confirm-title' => __( 'Confirmation', 'AbuFramework' ),
      'confirm-text' => __( 'Are you sure? Importing might lose/changed all current values.', 'AbuFramework' ),
    ]);
    $nonce  = wp_create_nonce( 'abu_backup_nonce' );
    $download_link = add_query_arg( array( 'action' => 'abu_backup_exporter', 'nonce' => $nonce, 'options' => $id, 'filename' => abu_ekey( 'filaname', $f, $id ) ), admin_url( 'admin-ajax.php' ) );

    $o = '<div class="abu-backup-wrapper">';
    
      // Import
      $o .= '<div class="abu-backup-import">';
        $o .= '<textarea name="abu_abuframework[abu_importer]" class="abu-backup-importer"></textarea>';
        $o .= '<button class="button button-primary abu-button abu-conformation abu-backup-importer" data-secret="' . esc_attr($nonce) . '" data-abu-options="' . esc_attr($id) . '"' 
           . abu_attr( 'data-confirm-title', $f['confirm-title'] ) . abu_attr( 'data-confirm-text', $f['confirm-text'] ) . '>' . __( 'Import', 'AbuFramework' ) . '</button>';
        $o .= '<small>' . __( 'WARNING! This will overwrite all existing option values, We recommed to make a backup first of all existing optins', 'AbuFramework' ) . '</small>';
      $o .= '</div>';

      // Export
      $o .= '<div class="abu-backup-export">';
        $o .= '<textarea readonly>' . json_encode( wp_unslash( get_option( $id, [] ) ) ) . '</textarea>';
        $o .= '<a href="' . $download_link . '" class="button button-primary abu-button" target="_blank">' . __( 'Download Backup File', 'AbuFramework' ) . '</a>';
      $o .= '</div>';

    $o .= '</div>';

    return $this->createField( $o );

  }


}
