<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * AbuFramework Core Options from AbuFramework
 * @since 1.0.0
 * @version 1.0.0
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */


AFW::createWPOption( 'abuFrameworkCore', [

    'page_title'      => __( 'AbuFramework', 'AbuFramework' ),
    'version'         => 'v1.0.3',
    'menu_title'      => 'AbuFramework',
    'menu_slug'       => 'abuframework',

    // menu settings
    'menu_icon'       => 'dashicons-layout',
    // 'ajax'  => false
]);

// Insert Footer and Header Section
AFW::createSection( 'abuFrameworkCore', [
  'id'     => 'footerandheader',
  'title'  => __( 'Insert Header & Footer', 'AbuFramework' ),
  'icon'   => 'fas fa-code',
  'priority'=> 30,
  'fields' => [
    [ 'title' => __( 'Code for Header', 'AbuFramework' ), 'full-width' => true, 'type' => 'code_editor', 'id' => 'headerhtml', 'editor' => [ 'mode' => 'html' ], 'senitize' => false ],
    [ 'title' => __( 'Code for Footer', 'AbuFramework' ), 'full-width' => true, 'type' => 'code_editor', 'id' => 'footerhtml', 'editor' => [ 'mode' => 'html' ], 'sanitize' => false ],
  ]
]);

// Custom CSS & JS Section
AFW::createSection( 'abuFrameworkCore', [
  'id'     => 'cssjs',
  'title'  => __( 'Custom CSS & JS', 'AbuFramework' ),
  'icon'   => 'fas fa-code',
  'priority'=> 30,
  'fields' => [
    [ 'title' => __( 'Custom CSS', 'AbuFramework' ), 'type' => 'code_editor', 'id' => 'css_editor' ],
    [ 'title' => __( 'Custom JS', 'AbuFramework' ), 'full-width' => true, 'type' => 'code_editor', 'id' => 'js_editor', 'editor' => [ 'mode' => 'javascript' ] ],
  ]
]);

// BackUp Section
AFW::createSection( 'abuFrameworkCore', [
  'id'     => 'Backupfields',
  'title'  => __( 'Backup', 'AbuFramework' ),
  'icon'   => 'fas fa-recycle',
  'priority'=> 30,
  'fields' => [
    [ 'title' => 'Backup',  'type' => 'backup', 'id' => 'backup' ],
  ]
]);