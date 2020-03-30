<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * abuWPOptions CLASS for Creating option page from AbuFramework
 * @since 1.0.0
 * @version 1.0.0
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

if( class_exists('abuWPOptions') ) return;

class abuWPOptions extends abuFramework {

  public $_id      = 0;
  public $errors   = [];
  private $echo    = true;
  public $settings = [];
  public $sections = [];
  public $option_type = 'options';
  public static $instance = 0;


  public function __construct( $settings = [], $sections = [] ) {                                
    

    if( abu_iekey( 'framework_id', $settings ) ) {
      $this->_id = $settings['id'] = $settings['framework_id'];
    } elseif ( abu_iekey( 'id', $settings ) ) {
      $this->_id = $settings['framework_id'] = $settings['id'];
    } else {
      $this->_id = 'abuframework_' . (SELF::$instance + 1);
      SELF::$instance++;
    }


    $this->settings = $settings = apply_filters( 'abu_options_'.$this->_id.'_setting', abu_field_extra( $settings, [

      'page_title'       => '',
      'menu_type'        => '',
      'menu_parent'      => '',
      'menu_title'       => '',
      'menu_slug'        => '',
      'menu_capability'  => 'manage_options',
      'menu_icon'        => 'dashicons-admin-generic',
      'menu_position'    => null,
      
      'display_sub_menu' => true,
      'show_in_rest'     => false,
      
      'database'         => '',
      'transient_expiration' => 0,
      'save_default'     => true,
      'ajax'             => true,
      
      'output_css'       => true,

      'show_multi'      => true,
      
      // Private options
      '__errors'         => [],

    ]));

    $this->sections = apply_filters( 'abu_options_'.$this->_id.'_sections', $sections);
    $this->all_sections = abu_all_sections( $sections );
    $this->fields = abu_get_fields( $this->all_sections );
    $this->saved_value = abu_set_options( $settings, [], false, true );
    
    
    if( !empty( $sections ) ) {
      if( $this->saved_value === false && $settings['save_default'] ) {
        $values = [];
        foreach ($this->fields as $field) {
          if( ! isset($field['id']) ) continue;
          $values[$field['id']] = abu_ekey( ['default', 'value'], $field, '' );
        }
        $this->saved_value = abu_set_options( $settings, $values );
      }
      $this->saving_options();
    }

    add_action( 'admin_menu',  array( $this, 'admin_menu' ), 20 );
    if( abu_ekey( 'show_network_menu', $settings, false ) ) {
      add_action( 'network_admin_menu', array( &$this, 'admin_menu' ) );
    }
    add_action( 'admin_head', array( $this, 'admin_head' ) );
    add_action( "wp_ajax_{$this->_id}", array( $this, 'ajax_save' ) );
    add_action( "wp_ajax_{$this->_id}_reset_section", array( $this, 'ajax_reset_section' ) );
    add_action( "wp_ajax_{$this->_id}_fields", array( $this, 'ajax_fields' ) );
    
  }

  public function saving_options() {
    
    $id      = $this->_id;
    $setting = $this->settings;
    $sections=$this->all_sections;
    $request = abu_var( $id, [] );
    $action  = abu_var( 'abuActions' );
    $isset   = isset( $_POST['abu_ajax_sections'] ) ? true : false;
    $done_data = [];

    // verifying nonce
    if( ! wp_verify_nonce( abu_var( 'abu_nonce_' . $id, 'nada'  ), 'abu_nonce' ) && empty($request) ) return false;
    
    $fields  = $this->fields;
    if( $isset ) {
      $fields = [];
      $setSections = json_decode( stripslashes( $_POST['abu_ajax_sections'] ), true );
      $totalcount = count( $setSections );
      $count = 0;
      foreach ($sections as $key => $section) {
        if( in_array( $section['id'], $setSections ) ) {
          $count++;
          $fields = array_merge( $fields, $section['fields'] );
          if( $count == $totalcount ) break;
        }
      }
    }
    
    if( ! empty( $_POST['abu_reset_section'] ) ){
      $action['reset_section'] = $_POST['abu_reset_section'];
    }
    
    // getting data to action
    if ( !empty( $action['reset_all'] ) ) {

      $values = [];
      foreach ($this->fields as $field) {
        if( ! isset($field['id']) ) continue;
        $values[$field['id']] = abu_ekey( ['default', 'value'], $field, '' );
      }
      abu_set_options( $this->settings, $values, true );

    } elseif( !empty( $action['reset_section'] ) ) {
      
      foreach ($sections as $key => $section) {
        if( $section['id'] === $action['reset_section'] ) {
          $request_keys = array_keys( $request );
          foreach( $section['fields'] as $field ) {
            if( in_array( $field['id'], $request_keys ) ) {
              unset( $request[$field['id']], $this->saved_value[ $field['id'] ] );
              $request[$field['id']] = abu_ekey( [ 'default', 'value' ], $field, '' );
            }
          }
        }
      }
      $done_data = abu_sanitization_validation_escaping( $request, $fields );
      
    } else {

      $done_data = abu_sanitization_validation_escaping( $request, $fields );

    }
    
    
    $this->errors = $this->settings['__errors'] = $done_data['errors'];
    $request = apply_filters( "abu_{$id}_before_save", wp_unslash( $done_data['request'] ), $this );
    do_action( "abu_{$id}_before_save", $request, $this );
    $request = abu_set_options( $setting, $request );
    do_action( "abu_{$id}_after_save", $request, $this );
    
    return $request;
    
  }
  
  public static function create( $se, $sec ) {
    SELF::$instance++;
    return new self( $se, $sec );
  }
  
  final public function admin_menu() {
    
    extract($this->settings);

    if( empty( $page_title ) ) {
      $page_title = $framework_title;
    }

    if( $menu_type === 'submenu' ) {

      $menu_page = add_submenu_page( $menu_parent, $page_title, $menu_title, $menu_capability, $menu_slug, array( &$this, 'abuWPOptionsPage' ) );

    } else {

      $page_title = empty( $page_title ) ? $menu_title : $page_title;
      $menu_page = add_menu_page( $page_title, $menu_title, $menu_capability, $menu_slug, array( &$this, 'abuWPOptionsPage' ), $menu_icon, $menu_position );
      
      if( $display_sub_menu ) {
        $section_submenus = [];
        if( empty($this->sections) ) return;
        foreach ($this->sections as $key => $sec) {
          $key++;
          if( abu_iekey( 'title', $sec ) ) {
            call_user_func( 'add_submenu_page', $menu_slug, $sec['title'], ucwords( $sec['title'] ), $menu_capability, $menu_slug.'#section=' . esc_attr( $sec['id'] ) , array( &$this, 'abuWPOptionsPage' ) );
          }
        }
      }
      remove_submenu_page( $menu_slug, $menu_slug );

    }

    add_action( "load-{$menu_page}", array( &$this, 'pageLoad' ) );

  }

  public function pageLoad() {
    add_filter( 'admin_footer_text', array( &$this, 'admin_footer_text' ) );
  }

  public function abuWPOptionsPage() {

     $settings = $this->settings;
     $values   = abu_set_options( $settings, [], false, true );

     if ( isset( $_GET['settings-updated'] ) ) {
       add_settings_error( $settings['framework_id'], $settings['framework_id'], __( 'Settings Saved', 'AbuFramework' ), 'updated' );
     }

     echo '<div class="wrap"><h1></h1>';
       echo ( get_called_class() )::abuOptionsRenders( $settings, $this->sections, $values );
     echo '</div>';

  }

  public function abuOptionsRenders( $setting = null, $secs = null, $save_values = [] , Bool $echo = false ) {

    if( is_null( $setting ) && is_null( $secs ) ) return;

    $setting = abu_field_extra( $setting, [

      'framework_title' => __( 'Abu Framrework <small> by Abu sufiyan</small>', 'AbuFramework' ),
      'framework_class' => '',
      'framework_id' => '',

      'version'         => 'v1.0.0',
      
      'copyright'       => sprintf( 
        __('Abu Framework by %sAbu Sufiyan', 'AbuFramework'),
        '<a href="http://abusufiyan.com/?ref=abuframework" target="_blank"><small>',
        '</small></a>'
      ),

      'reset_all'       => [ // boolean/array
        'display'   => true,
        'text'      => __( 'Reset All', 'AbuFramework' ),
        'name'      => 'abuActions[reset_all]',
        'class'     => ''
      ],

      'reset_change'    => [ // boolean:false/array
        'display'   => true,
        'text'      => __( 'Reset Changes', 'AbuFramework' ),
        'name'      => 'abuActions[reset_change]',
        'class'     => ''
      ],

      'reset_section'    => [ // boolean:fasle/array
        'display'   => true,
        'text'      => __( 'Reset Section', 'AbuFramework' ),
        'name'      => 'abuActions[reset_section]',
        'class'     => ''
      ],

      'save'             => [ // boolean:false/array
        'display'   => true,
        'text'      => __( 'Save', 'AbuFramework' ),
        'name'      => 'abuActions[submit]',
        'class'     => ''
      ],

      'form'       => [
        'method'    => 'POST',
        'action'    => '',
        'enctype'   => 'multipart/form-data'
      ],

      'head'    => true,
      'body'    => true,
      'footer'  => true,

      'ajax'    => false,

      'before'  => '',
      'after'  => ''

    ]);
    $secs    = abu_sections_sort( $secs );
    $errors  = abu_ekey( '__errors', $setting, [] );

    extract( $setting );
    $keys = 1;
    $options = &$save_values;

    
    $o = '';
    
    $o .= $setting['before'];
    $o .= '<div class="abu-options-framework ' . esc_attr( $framework_class ) . '" id="' . esc_attr( $framework_id ) 
       . '" data-abu-ajax="' . esc_attr( json_encode($ajax) ) . '"' . '>';

      if( $form !== false ) {
          $o .= '<form ';
          foreach ($form as $key => $value) {
              $o .= $key . '="' . esc_attr( $value ) . '"'; 
          }
          $o .= ' >';
      }
        
      $o .= wp_nonce_field( 'abu_nonce', "abu_nonce_{$framework_id}" , true, false );
      if( $ajax ) {
        $o .= '<input type="hidden" class="abu-ajax-sections" name="abu_ajax_sections" value="[]" />';
      }
      $o .= '<input type="hidden" class="abu-reset-section" name="abu_reset_section" value="" />';

      $o .= apply_filters( 'after_formtag_'.$framework_id, '' );

      if( $head ) {
        $o .= '<div class="abu-options-head">'; // Start Head
          $o .= '<div class="abu-main-title"><h1>' . $framework_title . '</h1></div>'; //End Title
          $o .= '<div class="abu-option-buttons">';
            if( $save || is_array( $save ) ) {
              if( $save['display'] == true ) {

                  $o .= '<span class="abu-spinner spinner"></span>';
                  $o .= '<input type="submit" data-load-text="' . __( 'Saving...', 'AbuFramework' ) . '" name="' . esc_attr( $save['name'] ) . '" value="' . esc_attr( $save['text'] ) . '"';
                  $o .= 'id="submit" class="button abu-botton abu-save-botton ' . esc_attr( $save['class'] ) . '">';

              }
            }
            if( $reset_all || abu_check( $reset_all, 'array' ) ) {
              if( $reset_all['display'] == true || $reset_all ) {
                $o .= '<input type="submit" name="' . esc_attr( abu_ekey( 'name', $reset_all ) ) . '" value="';
                  if( abu_ekey( 'text', $reset_all ) != null && $reset_all['text'] != '' ) {
                    $o .= esc_attr( $reset_all['text'] );
                  } else {
                    $o .= esc_attr__('Reset All', 'AbuFramework');
                  }
                $o .= '" class="button abu-botton abu-reset-botton ' . abu_ekey( 'class', $reset_all ) . '">';
              }
            }
            
          $o .= '</div>';
        $o .= '</div>'; // End Head
      }

      
      $abu_all_sections = abu_all_sections( $secs );
      $is_single = count( $abu_all_sections ) <= 1;
      
      $o .= '<div class="abu-options-body ' . ( $is_single ? 'single-section' : '' ) . '">'; // Start Body

        if( ! $is_single ) {
          $o .= '<div class="abu-section-nav-wrap"><div class="abu-section-nav"><ul>'; // Start Navs
            if( ! is_null( $secs ) ) {
              foreach ($secs as $sec) {
              
              $o .= '<li class="abu-tablinks parent-section ' . ( isset($sec['active']) ? 'opened' : '' ) . ( isset( $sec['sub-section'] ) ? ' has-sub' : '' ) . ( $sec['empty'] ? ' empty-section' : '' ) . '" abu-section="' . esc_attr( $keys ) . '"';

              $o .= 'data-is-empty="' . ( $sec['empty'] ? 'true' : 'false' ) . '" data-fields="' . esc_attr( count( abu_ekey('fields', $sec, []) ) )  .  '" abu-section-id="' . esc_attr( $sec['id'] ) . '"' . abu_depend_helper( $sec ) . '>';
                  $o .= '<a href="#section=' . esc_attr( $sec['id'] ) . '">';
                  if( abu_iekey( 'icon',  $sec ) && !empty($sec['icon']) ) {
                    $o .= '<span class="abu-section-nav-icon"><i class="' . esc_attr( $sec['icon'] ) . '"></i></span>';
                  }
                  $o .= '<span class="abu-section-nav-text">'. esc_html( $sec['title'] ) . '</span>';

                  // Displaying Error counts
                  $o .= '<span class="abu-section-nav-error ';
                     if( isset( $sec['fields'] ) ) {
                        $error_count = 0; 
                        foreach( $sec['fields'] as $field ) {
                          if( array_key_exists( $field['id'], $errors ) ) $error_count++; 
                        }
                        $o .= ( $error_count > 0 ? 'error-display">' : '">' ) . $error_count ;
                     }
                  $o .= '</span>';

                  if( abu_iekey( 'sub-section', $sec) && is_array( $sec['sub-section'] ) && count( $sec['sub-section'] )  ) {
                    $o .= '<span class="abu-section-nav-toggle">';
                      $o .= '<i class="fas fa-plus"></i> <i class="fas fa-minus"></i>';
                    $o .= '</span>';
                  }
                  $o .= '</a>';
                  if( abu_iekey( 'sub-section', $sec ) && is_array( $sec['sub-section'] ) && count( $sec['sub-section'] ) ) {
                    $o .= '<ul class="sub-menus">';
                      foreach ($sec['sub-section'] as $ssec) {
                        $keys++;
                        $o .=  '<li abu-section="' . esc_attr( $keys ) . '" data-is-empty="' . ( $sec['empty'] ? 'true' : 'false' ) . '" data-fields="' . count( abu_ekey('fields', $ssec, []) )  
                           .  '" class="child-section" abu-section-id="' . esc_attr( $ssec['id'] ) . '"' . abu_depend_helper( $ssec ) . '>';
                        $o .=  '<a href="#section=' . esc_attr( $ssec['id'] ) . '">';
                          if( abu_iekey( 'icon',  $ssec) ) {
                            $o .= '<span class="abu-section-nav-icon"><i class="' . abu_ekey( 'icon', $ssec ) . '"></i></span>';
                          }
                        $o .=  '<span class="abu-section-nav-text">'. $ssec['title'] .'</span>';
                      }
                      $o .= '</a></li>';
                    $o .= '</ul>';
                  }
              $o .= '</li>';
              $keys++;
            }
            }
          $o .= '</ul></div></div>'; // End Navs
        }

        $o .= '<div class="abu-section-wrap">';
          $o .= '<div class="abu-all-sections">'; // start sections
          foreach ($abu_all_sections as $key => $sec) {

            $key += 1;

            $o .= '<div class="abu-single-section" id="abu-section-' . esc_attr( $sec['id'] ) . '">'; // start single sections

              
              $o .= '<div class="abu-section-top">';

                $o .= '<div class="abu-section-search">';
                  $o .= '<input type="search" placeholder="'. __('Search in section...', 'AbuFramework') .'" class="abu-section-search-field" value=""/>';
                $o .= '</div>';


                $o .= '<div class="abu-section-button">';

                  if( $reset_change || is_array($reset_change) && $ajax ) {
                    if( $reset_change['display'] == true ) {
                    
                        $o .= '<button type="submit" name="' . esc_attr( $reset_change['name'] ) . '" value="' . esc_attr( $sec['id'] )  . '"';
                        $o .= ' data-section-id="' . esc_attr( $sec['id'] ) . '" class="button button-small abu-section-botton abu-section-reset-chngs' . esc_attr( $reset_change['class'] ) . '">' . esc_html( $reset_change['text'] ) . '</button>';

                    }
                  }

                  if( $reset_section || is_array($reset_section) ) {
                    if( $reset_section['display'] == true ) {
                    
                        $o .= '<button type="submit" name="' . esc_attr( $reset_section['name'] ) . '" value="' . esc_attr( $sec['id'] )  . '"';
                        $o .= ' data-section-id="' . esc_attr( $sec['id'] ) . '" class="button button-primary button-small abu-section-botton abu-section-reset-btn' . esc_attr( $reset_section['class'] ) . '">' . esc_html( $reset_section['text'] ) . '</button>';

                    }
                  }

                $o .= '</div>';

                // $o .= '<div class="abu-clearfix"></div>';
              $o .= '</div>';

              $o .= '<div class="abu-element abu-single-section-title">';
                $o .= '<h2>' . abu_ekey( 'title', $sec ) . '</h2>';
                $o .= '<div class="abu-section-desc">' . esc_html( abu_ekey( ['desc', 'description'], $sec, '' ) ) . '</div>';
              $o .= '</div>';

              $o .= '<div class="abu-elements' . ( empty( $sec['fields'] ) ? ' no-elements' : '' ) . '">';
                if( abu_iekey( 'fields', $sec ) && is_array($sec['fields']) && ! empty( $sec['fields'] ) ) {
                   if( ! $ajax ) {
                     $o .= ( get_called_class() )::renderSection( $sec['fields'], $framework_id, $options, $errors, false );
                   } else {
                     $o .= '<div class="abu-section-load-wapper"><div class="abu-section-loading"><div></div><div></div></div></div>';
                   }
                } else {
                  $o .= '<div class="abu-element">' . __( 'This section is Empty.', 'AbuFramework' ) . '</div>';
                }
            $o .=  '</div></div>'; // End single sections

          }
          $o .= '</div>';
        $o .= '</div>';// End sections

      $o .= '<div class="abu-section-nav-wrap-background"></div><div class="abu-clearfix"></div></div>'; // End Body

      if( $footer ) {
        if( $copyright && $version ) {  // Start Footer
          $o .= '<div class="abu-options-footer">';
            $o .= '<div class="abu-footer-copyright abu-pull-left"><p>' . wp_kses( $copyright, allowed_tags() ) . '</p></div>';
            $o .= '<div class="abu-footer-version abu-pull-right"><p><code>' . wp_kses( $version, allowed_tags() )  . '</code></p></div>';
            $o .= '<div class="abu-clearfix"></div>';
          $o .= '</div>';
        } else {
          $o .= '<div class="border-bottom"></div>';
        } // End Footer
      }

      $o .= ( $form != false ? '</form>' : '' );
    $o .= '</div>';
    $o .= $setting['after'];
    
    if( $echo ) echo $o;
    return $o;

  }

  public static function renderSection( $fields = [], $framework_id = '', $options = '', array $errors = null, $echo = true ) {

    if( empty($fields) ) return '';
    $o = '';
    
    $framework_id = empty( $framework_id ) ? $this->_id : $framework_id;
    $options = empty( $options ) && is_string( $options ) ? $this->saved_value : $options;

    foreach ( $fields as $key => $field ) {

      if( ! isset( $field['id'] ) ) continue;

      $name  = $framework_id . '[' . $field[ 'id' ] . ']';
      $value = abu_ekey( $field[ 'id' ], $options, abu_ekey( [ 'default', 'value' ], $field, '' ) );
      if( array_key_exists( $field['id'], $errors ) ) $field['__error'] = $errors[$field['id']];

      $MadeF = add_abu_tattv( $field, $value, $framework_id, 'options' ); // Adding Elemet
      if( $echo ) {
        echo $MadeF;
        continue;
      }
      $o .= $MadeF;

    }

    if( $echo ) return;
    return $o;

  }

  final public function admin_head() {
    $s = $this->settings;
    echo '<script>
      var ' . $this->_id . '_var = ' . wp_json_encode([
        'show_multi' => $s['show_multi'] ? true : false
      ]) . ',';
      echo $this->_id . ' = ' . wp_json_encode( $this->saved_value ) . ';';
    echo '</script>';
  }

  public function admin_footer_text() {
    echo abu_ekey( 'footer_credit', $this->settings, sprintf( 
      __('Thank you for creating with %s Abu Framework %s', 'AbuFramework'),
      '<a href="http://abusufiyan.com/?ref=abuframework" target="_blank">',
      '</a>'
    )); 
  }

  final public function ajax_save() {

    if( ! empty( $_POST['data'] ) ) {

      $_POST = $_POST['data'];
      if( is_string( $_POST ) ) {
        $_POST = json_decode( stripslashes( $_POST['data'] ), true );
      }

      if( wp_verify_nonce( $_POST[ 'abu_nonce_' . $this->_id ] , 'abu_nonce' ) ) {

        $saving = $this->saving_options();
        wp_send_json_success( [ 'success' => true, 'errors' => $this->errors ] );

      }

    }

    wp_send_json_error( [ 'success' => false, 'text' => __( 'Something went wrong!', 'AbuFramework' ) ] );

  }

  final public function ajax_fields() {

    $_POST = $_POST['data'];

    if( empty($_POST['section_id']) ){
      wp_send_json_error( __( 'Failed', 'AbuFramework' ) );
    }

    foreach( $this->all_sections as $sec ) {
      if( $_POST['section_id'] ==  $sec['id'] ) {

        $this->renderSection( $sec['fields'], $this->_id, $this->saved_value, $this->errors, true);
        break;
        wp_die();

      }
    }

    wp_die();

  }

  final public function ajax_reset_section() {

    if( ! empty( $_POST['data'] ) ) {

      $_POST = $_POST['data'];
      if( is_string( $_POST ) ) {
        $_POST = json_decode( stripslashes( $_POST['data'] ), true );
      }
      
      if( wp_verify_nonce( $_POST[ 'abu_nonce_' . $this->_id ] , 'abu_nonce' ) ) {

        if( !empty( $_POST['abu_reset_section'] ) ) {

          $_POST['abuActions']['reset_section'] =  $_POST['abu_reset_section'];
          $saving = $this->saving_options();
          wp_send_json_success( [ 'success' => true, 'errors' => $this->errors ] );

        }

      }

    }

    wp_send_json_error( [ 'success' => false, 'text' => __( 'Something went wrong!', 'AbuFramework' ) ] );

  }

}


?>
