<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly.
/**
 *
 * Abu Framework Main Class File
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */

if( ! class_exists('AFW') ) {
  class AFW {

    // Abu Framework Properties
    public static $abuFramework = '1.0.0';
    public static $theme_version = null;
    public static $fields  = [];
    public static $field_classes = [];
    public static $inited = [];
    public static $init_counts = [
      'options' => [],
      'wpPage'  => [],
      'TabOns'   => []
    ];
    public static $core = '';
    public static $frameworks = [];

    public static function init() {

      // init action
      do_action( 'afw_init' );
      
      // Including essential files
      self::include_files();

      global $AbuFrameworkCore;
      SELF::$core =  $AbuFrameworkCore;

      if( in_array( 'activated', array_values( SELF::$core->opts['AbuFrameworkCoreActivate'] ) ) ) {
        add_action( 'after_setup_theme', array( 'AFW', 'afw_init' ) );
        add_action( 'init', array( 'AFW', 'afw_init' ) );
        add_action( 'switch_theme', array( 'AFW', 'afw_init' ) );
      }

      add_action( 'wp_ajax_ajax_field', array( 'AFW', 'ajax_field' ) );
      add_action( 'admin_footer', array( 'AFW', 'abu_icon_picker' ) );
      add_action( 'customize_controls_print_footer_scripts', array( 'AFW', 'abu_icon_picker' ) );

      // after init action
      do_action( 'afw_after_init' );

    }

    final public static function createWPOption( $unique = '', $args = [] ) {
      if( ! empty( $unique ) ) {
        SELF::$frameworks['options'][$unique] = $args;
      }
    }

    final public static function createMetabox( $unique = '', $args = [] ) {
      if( ! empty( $unique ) ) {
        SELF::$frameworks['metaboxes'][$unique] = $args;
      }
    } 

    final public static function createTaxonomy( $unique = '', $args = [] ) {
      if( ! empty( $unique ) ) {
        SELF::$frameworks['taxonomies'][$unique] = $args;
      }
    }

    final public static function createUserProfile( $unique = '', $args = [] ) {
      if( ! empty( $unique ) ) {
        SELF::$frameworks['userProfile'][$unique] = $args;
      }
    }

    final public static function createWidget( $unique = '', $args = [] ) {
      if( ! empty( $unique ) ) {
        SELF::$frameworks['Widgets'][$unique] = $args;
      }
    }

    final public static function createTabOn( $unique = '', $args = [] ) {
      if( ! empty( $unique ) ) {
        $args['id'] = $unique;
        SELF::$frameworks['TabOn'][$unique] = $args;
      }
    }

    final public static function createAbout( $unique = '', $args = [] ) {
      if( ! empty( $unique ) ) {
        $args['id'] = $unique;
        SELF::$frameworks['about'][$unique] = $args;
      }
    }

    final public static function createSection( $unique = '', $section = [] ) {
      if( ! empty( $unique ) ) {

        if( ! isset( $section['id'] ) ) {
          $section['id'] = str_shuffle('abuframework');
        }

        $section['assign'] = $unique;
        SELF::$frameworks['abu_all_sections'][] = $section;
        if( is_string( $unique ) ) {
          self::$frameworks['sections'][$unique][] = $section;
        } elseif ( is_array($unique) ) {
          foreach ( $unique as $uniqu ) {
            self::$frameworks['sections'][$uniqu][] = $section;
          }
        }

      }
      return;

    }

    final public static function setVersion( $version = null ) {
      if( is_null( $version ) ) {
        self::$theme_version = self::$abuFramework;
        return;
      }
      self::$theme_version = $version;
    }

    final public static function createField( $id = '', array $field, $value = 'jijanab@AFW' ) {

      if( empty( $id ) || empty( $field ) ) return;

      // if( abu_iekey( 'section', $field, false ) ) {
      //   self::$frameworks['abu_allji_fields'][] = $field;
      //   return;
      // }

      if( abu_ekey( 'option_page', $field, false ) ) {
        self::$frameworks['sections']['option_page'][] = $field;
        return;
      }

      $o = '';
      $abu_element_type = isset( $field['type'] ) ? $field['type'] : '';      
      $abufield = 'abuFrameworkField_' . str_replace('-', '_', strtolower($abu_element_type) );
      // $abufield = class_exists($abu_element_type) ? $abu_element_type : $abufield;
      $name = $id;
      $field['id'] = $id;

      $tattvvalue = $value != 'jijanab@AFW' ? $value : abu_ekey( [ 'default', 'value' ], $field, '' );

      if( abu_iekey( 'id', $field ) ) {
        
        if( class_exists( $abufield ) ) {
          ob_start();
          $o .= ( new $abufield( $field, $tattvvalue, $name, $place ) )->render_field();
          $o .= ob_get_contents();
          ob_end_clean();
        } else {
          $o .= '<p class="abu-noticed abu-danger">'. esc_html__( "This field class ('{$abufield}') is not available!", 'AbuFramework' ) .'</p>';
        }
      } else {
        if( abu_iekey( 'type', $field ) ) {
          $o .= '<p class="abu-noticed abu-danger">'. esc_html__( 'Field "type" doesn\'t exits!', 'AbuFramework' ) .'</p>';
        } 
        if( abu_iekey( 'id', $field ) ){
          $o .= '<p class="abu-noticed abu-danger">'. esc_html__( 'Field "id" doesn\'t exits!', 'AbuFramework' ) .'</p>';
        }
      }

      return $o;

    }

    final public static function afw_init() {

      // Setting up admin options
      $args        = array();
      $activated   = SELF::$core->opts['AbuFrameworkCoreActivate'];
      $framework   = SELF::$frameworks;
      $sections    = abu_ekey( 'sections',    $framework, [] );
      $all_sections= abu_ekey( 'abu_all_sections', $framework, [] );
      $fields      = abu_ekey( 'abu_allji_fields', $framework, [] );
      $options     = abu_ekey( 'options',     $framework, [] ); 
      $metaboxes   = abu_ekey( 'metaboxes',   $framework, [] ); 
      $taxonomies  = abu_ekey( 'taxonomies',  $framework, [] ); 
      $TabOns      = abu_ekey( 'TabOn',       $framework, [] ); 
      $userProfile = abu_ekey( 'userProfile', $framework, [] ); 
      $widgets     = abu_ekey( 'Widgets',     $framework, [] ); 
      $abouts      = abu_ekey( 'about',     $framework, [] );
      $wpPage      = array_filter( $all_sections, function($var){ return ( isset( $var['page'] ) ? true : false ); } );
      $init_counts = SELF::$init_counts;
      
      if( ! empty( AFW::$frameworks['abu_all_sections'] ) ) {
        foreach( AFW::$frameworks['abu_all_sections'] as $section ) {
          if( isset( $section['fields'] ) && is_array( $section['fields'] ) ) {
            foreach( $section['fields'] as $field ) {
              if( empty( $field['type'] ) ) continue;
              $classname = 'abuFrameworkField_' . str_replace('-', '_', strtolower( $field['type'] ) );
              if( ! class_exists( $classname ) ) AFW::might_include( $field['type'] );
            }
          }
        }
      }

      // Craeating/Adding/Editing/Updating fields
      if ( ! empty( $fields ) && count( $fields ) ) {
        foreach( $fields as $key => $field ) {
          $section_key    = array_search( $field['section'], array_column( $all_sections, 'id') );
          $section_assign = $all_sections[$section_key]['assign'];
          $field_key      = array_search( $field['section'], array_column( $sections[$section_assign], 'id' ) );
          unset( $field['section'] );
          self::$frameworks['sections'][$section_assign][$field_key]['fields'][] = $field;
        }
      }

      // Creating WPPage section
      if ( ! empty( $options ) && count( $options ) && count( $init_counts['wpPage'] ) != count( $wpPage )  ) {
        foreach( $wpPage as $key => $value ) {
          $value['id'] = isset( $value['id'] ) ? $value['id'] : $value['assign'];
          if( in_array( $value['id'], $init_counts['wpPage'] ) ) continue; 
          WPSetting::create( $value, $value );
          SELF::$init_counts['wpPage'][] = $value['id'];
        }
      }

      if( $activated['WPOption'] === 'activated') {
        // Creating WP/options
        if ( ! empty( $options ) && count( $options ) && count( $init_counts['options'] ) != count( $options ) ) {
          foreach( $options as $key => $value ) {
            if( in_array( $key, $init_counts['options'] ) ) continue;
            $value['framework_id'] = $key;
            $framework_section = abu_sections_sort( abu_ekey( $key, self::$frameworks['sections'], [] ) );
            abuWPOptions::create( $value, $framework_section );
            SELF::$init_counts['options'][] = $key;
          }
        }
      }

      if( $activated['Metabox'] === 'activated') {
        // Creating WP/Metaboxes
        if ( ! empty( $metaboxes ) && count( $metaboxes ) && ! abu_ekey( 'metabox', self::$inited, false ) ) {
          foreach( $metaboxes as $key => $value ) {
            $value['id'] = $key;
            $meta_section = array_values( wp_list_sort(
              abu_sections_sort( abu_ekey( $key, self::$frameworks['sections'], [] ) ),
              array( 'priority' => 'ASC' ),
              'ASC',
              true
            ) );
            abuMetaBoxes::create( $value,  $meta_section );
          }
          self::$inited['metabox'] = true;
        }
      }

      if( $activated['Taxonomy'] === 'activated') {
        // Creating WP/Taxonomies
        if ( ! empty( $taxonomies ) && count( $taxonomies ) && ! abu_ekey( 'taxonomies', self::$inited, false ) ) {
          foreach( $taxonomies as $key => $value ) {
            $value['id'] = $key;
            $meta_section = array_values( wp_list_sort(
              abu_sections_sort( abu_ekey( $key, self::$frameworks['sections'], [] ), 120 ),
              array( 'priority' => 'ASC' ), 'ASC', true
            ) );
            abuTaxonomy::create( $value, $meta_section );
          }
          self::$inited['taxonomies'] = true;
        }
      }

      if( $activated['UserProfile'] === 'activated') {
        // Creating WP/UserProfile
        if ( ! empty( $userProfile ) && count( $userProfile ) && ! abu_ekey( 'userProfile', self::$inited, false ) ) {
          foreach( $userProfile as $key => $value ) {
            $value['id'] = $key;
            $meta_section = array_values( wp_list_sort(
              abu_sections_sort( abu_ekey( $key, self::$frameworks['sections'], [] ), 120 ),
              array( 'priority' => 'ASC' ), 'ASC', true
            ) );
            abuUserProfile::create( $value, $meta_section );
          }
          self::$inited['userProfile'] = true;
        }
      }

      if( $activated['Widget'] === 'activated') {
        // Creating WP Widgets
        if ( ! empty( $widgets ) && count( $widgets ) && ! abu_ekey( 'widgets', self::$inited, false ) ) {
          $wp_widget_factory = new WP_Widget_Factory();
          foreach( $widgets as $key => $value ) {
            $value['id'] = $key;
            $meta_section = array_values( wp_list_sort(
            abu_sections_sort( abu_ekey( $key, self::$frameworks['sections'], [] ), 120 ),
            array( 'priority' => 'ASC' ), 'ASC', true
            ) );      
            $wp_widget_factory->register( AbuWidget::create( $value, $meta_section ) );
          }
          self::$inited['widgets'] = true;
        }
      }

      if( $activated['TabOn'] === 'activated') {
        // Creating WP TabOns Fields
        if ( ! empty( $TabOns ) && count( $TabOns ) && count( $init_counts['TabOns'] ) != count( $TabOns ) ) {
          foreach( $TabOns as $key => $TabOn ) {
            if( in_array( $key, $init_counts['TabOns'] ) ) continue;
            $TabOn['id'] = $key;
            $meta_section = array_values( wp_list_sort(
              abu_sections_sort( abu_ekey( $key, self::$frameworks['sections'], [] ), 120 ),
              array( 'priority' => 'ASC' ), 'ASC', true
            ) );
            abuTabOn::create( $TabOn, $meta_section );
            SELF::$init_counts['TabOns'][] = $key;
          }
        }
      }

      // Creating About Fields
      if ( ! empty( $abouts ) && ! abu_ekey( 'abouts', self::$inited, false ) ) {
        foreach( $abouts as $key => $about ) {
          if( ! class_exists('abuAbout') ) continue;
          $about['id'] = $key;
          abuAbout::create( $about, [] );
        }
        self::$inited['abouts'] = true;
      }
      
      ABU_ENQUEUE_FILES::init( 'admin' );


    }

    final static public function ajax_field() {

      $data = isset( $_POST['data'] ) ? $_POST['data'] : false;
      if( ! empty( $data ) ) {
        if( isset( $data['section'] ) || isset( $data['section_id'] ) ) {
          $section = abu_ekey( [ 'section_id', 'section' ], $data );
          $sections = array_column( array_values( SELF::$frameworks['abu_all_sections'] ), 'id' );
          $pos     = array_search( $section, $sections );
          if( in_array( $section, $sections ) ) {
            foreach (SELF::$frameworks['abu_all_sections'][$pos]['fields'] as $key => $value) {
              echo SELF::createField( $value['id'], $value, '' );
            }
            wp_die();
          } else {
            wp_send_json( array_keys(SELF::$frameworks['sections']) );
          }
        }
      } else {
        echo '';
      }
      wp_send_json(  $data  );
      wp_die();

    }

    final public static function include_files() {

        // Including all functions files
        abu_load_template( 'short-functions', ABU_FUNC);
        abu_load_template( 'long-functions', ABU_FUNC);
        abu_load_template( 'senitizations', ABU_FUNC);
        abu_load_template( 'enqueues-files', ABU_FUNC);
        abu_load_template( 'actions', ABU_FUNC);

        abu_load_template( 'AbuFramework.class', ABU_CLASSES);
        abu_load_template( 'AbuFrameworkFields.class', ABU_CLASSES);
        abu_load_template( 'WPOptions.class', ABU_CLASSES);
        abu_load_template( 'metaboxes.class', ABU_CLASSES);
        abu_load_template( 'taxonomy.class', ABU_CLASSES);
        abu_load_template( 'userProfile.class', ABU_CLASSES);
        abu_load_template( 'tabOn.class', ABU_CLASSES);
        abu_load_template( 'widget.class', ABU_CLASSES);
        abu_load_template( 'WPSettings.class', ABU_CLASSES);

        abu_load_template( 'init.class', ABU_CORE);

    }

    final public static function abu_icon_picker() {

      if( abu_ekey( 'icon_picker', SELF::$inited , false) ) return;
      $classes = get_declared_classes();
      
      if( in_array( 'abuFrameworkField_icon', $classes ) ) {
        echo (new abuFrameworkIconPicker)->render_picker();
      }
      SELF::$inited['icon_picket'] = true;

    }

    final public static function might_include( $files ) {
      if( ! empty( $files ) ) {
        if( is_array( $files ) ) {
          foreach( $files as $inc_type ) {
            $inc_type = str_replace( ['-'], '_', $inc_type );
            abu_load_template( apply_filters( "field_include_{$inc_type}" , $inc_type . '/' . $inc_type . '.class' ), ABU_FIELDS );
          }
          return true;
        }
        $file = str_replace( ['-'], '_', $files );
        abu_load_template( apply_filters( "field_include_{$file}", $file . '/' . $file . '.class' ), ABU_FIELDS );
        return true;
      }
      return false;
    }

  }
  AFW::init();
}
return;


