<?php if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly.

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
 * Framework enqueues styles and scripts
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */

class ABU_ENQUEUE_FILES {

  public static $styles = [];

  private static $sstyles = false;

  public static function init( string $where = 'admin' ) {

    $called_function = array( __CLASS__ , 'abu_admin_enqueue_scripts' );

    switch ($where) {
      case 'admin':
        add_action( 'admin_enqueue_scripts', $called_function );
        break;
      
      default:
        add_action( $where , $called_function );
        break;
    }
    

  } 

  public static function add( string $type = '', string $handle, string $src = '', array $deps = array(), $ver = false, string $media = 'all' ) {

    if( $type == 'style' || $type == 'styles' ) {
      SELF::$styles[] = [$handle, $src, $deps,  $ver , $media];
    } else if( $type == 'style' ||$type == 'styles' ) {

    }
    return false;

  }

  public static function abu_admin_enqueue_scripts() {

      wp_enqueue_media();
      wp_enqueue_editor();
      
      
      wp_enqueue_style( 'jquery-ui', abu_load_file( 'vector\jquery-ui', ABU_CSS, 'css' ), [] , '1.0.3' );
      wp_enqueue_style( 'abu-fa', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css', [] , '5.8.1' );
      wp_enqueue_style( 'abu-framework-plugins', abu_load_file( 'abu-plugins', ABU_CSS, 'css' ), [] , '1.0.1' );
      wp_enqueue_style( 'abu-framework-css', abu_load_file( 'abu-framework', ABU_CSS, 'css' ), [] , '1.0.3' );
      wp_enqueue_style( 'abu-framework-core', abu_load_file( 'abu-framework-core', ABU_CSS, 'css' ), [] , '1.0.1' );

      
      wp_enqueue_style(  'wp-color-picker');
      wp_enqueue_script( 'wp-color-picker' );
      
      wp_enqueue_script( 'jquery-effects-highlight' );
      wp_enqueue_script( 'jquery-ui-slider' );
      wp_enqueue_script('jquery-ui-core');
      wp_enqueue_script( 'jquery-ui-sortable' );
      wp_enqueue_script( 'jquery-ui-datepicker' );
      wp_enqueue_script( 'jquery-ui-widget' );
      wp_enqueue_script( 'jquery-ui-spinner' );

      wp_enqueue_style( 'wp-jquery-ui-dialog', false, ['jquery-ui'] );
      wp_enqueue_script( 'jquery-ui-dialog' );

      
      wp_enqueue_script( 'abu-framework-plugins', abu_load_file( 'abu-plugins', ABU_JS, 'js' ), [], '1.0.1', false );
      wp_enqueue_script( 'acolorpicker', abu_load_file( '\vectors\acolorpicker', ABU_JS, 'js' ), [], '1.0.1', false );
      wp_enqueue_script( 'wp-color-picker-alpha', abu_load_file( '\vectors\wp-color-picker-alpha', ABU_JS, 'js' ), ['wp-color-picker'], '1.0.1' );
      wp_enqueue_script( 'checkboxradio-ui', abu_load_file( '\vectors\checkboxradio-ui', ABU_JS, 'js' ), [], '1.0.1' );
      
      if( ! empty( AFW::$frameworks['abu_all_sections'] ) ) {
        foreach( AFW::$frameworks['abu_all_sections'] as $section ) {
          if( isset( $section['fields'] ) ) {
            foreach( $section['fields'] as $field ) {
              if( ! empty( $field['type'] ) ) {
                $classname = 'abuFrameworkField_' . str_replace('-', '_', strtolower( $field['type'] ) );
                AFW::might_include( $field['type'] );
                if( class_exists( $classname ) && method_exists( $classname, 'wp_enqueue' ) ) {
                  $instance = new $classname( $field );
                  $instance->wp_enqueue();
                  unset( $instance );
                }
              }
            }
          }
        }
      }

      
      wp_enqueue_script( 'abu-framework', abu_load_file( 'abu-framework', ABU_JS, 'js' ), [], time() );
      wp_localize_script( 'abu-framework', 'AbuFramework', array( 
        'ajaxurl'      => admin_url( 'admin-ajax.php' ),
        'vars' => [
          'rtl' => is_rtl()
        ],
        'i18n' => [
          'typo_title'   => [
            'darken'  => __( 'Convert to Darken', 'AbuFramework' ),
            'lighten' => __( 'Convert to Lighten', 'AbuFramework' ),
          ],
          'saveSettings' => __( 'Settings Saved successfully!', 'AbuFramework' ),
          'errorSettings'=> __( 'Something went wrong!', 'AbuFramework' ),
          'ok'           => __( 'Ok', 'AbuFramework' ),
          'cancel'       => __( 'Cancel', 'AbuFramework' ),
          'error'        => __( 'Something went wrong!', 'AbuFramework' ),
          'error'        => __( 'Successfully done!', 'AbuFramework' )
        ],
      ));


  }


}