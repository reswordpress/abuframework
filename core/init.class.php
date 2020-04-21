<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * AbuFramework Core CLASS from AbuFramework
 * @since 1.0.0
 * @version 1.0.0
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

if( ! class_exists('AbuFrameworkCore') ) {
    class AbuFrameworkCore {
        
      public $extensions = [];

      function __construct(){
          
        $this->database = ( is_multisite() && is_network_admin() ? 'network' : 'options' );
        $this->opts     = abu_get_options( $this->database, 'AbuFrameworkOwn', apply_filters( 'AbuFrameworkCoreActivateDefault', [
          'AbuFrameworkDemo'  => 'no',
          'AbuFrameworkCoreActivate' => [
            'WPOption'    => 'activated',
            'Widget'      => 'activated',
            'TabOn'       => 'activated',
            'Metabox'     => 'activated',
            'Taxonomy'    => 'activated',
            'UserProfile' => 'activated',
          ]
        ] ) );
        $this->core     = get_option( 'abuFrameworkCore', [] );
        $this->saving();

        register_activation_hook(   ABU_DIR . 'abu-framework.php', array( $this , 'register_activation_hook' ) );
        register_deactivation_hook( ABU_DIR . 'abu-framework.php', array( $this , 'register_deactivation_hook' ) );

        add_action( 'init', array( $this, 'coreInit' ) );
        add_action( 'admin_menu',  array( $this, 'admin_menu' ), 20 );
        add_action( 'wp_head',  array( $this, 'wp_head' ) );
        add_action( 'wp_footer',  array( $this, 'wp_footer' ) );


        // including options
        abu_load_template('inc/options', ABU_CORE);

        // Edit plugin metalinks
        add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), null, 4 );
        
  
      }
      
      public function register_activation_hook() {

          if( empty( $this->opts ) ) {
              $this->opts = abu_set_options( [ 'framework_id' => 'AbuFrameworkOwn', 'database' => $this->database ], $this->opts );
          }

      }
  
      public function register_deactivation_hook() {}

      final public function coreInit() {
          
        // Setting up  
        global $pagenow;
        if ( ! empty( abu_var( 'AbuFrameworkDemo', '' ) ) && is_admin() && ( $pagenow == 'plugins.php' || $pagenow == 'tools.php' ) ) {
            
          abu_set_options( [ 'framework_id' => 'AbuFrameworkOwn', 'database' => $this->database ], [ 'AbuFrameworkDemo' => $_GET['AbuFrameworkDemo'] ] );
          if( function_exists('wp_safe_redirect') ) {
            $pagenow = './' . $pagenow . ( $pagenow == 'tools.php' ? '?page=abuframework-about' : '' );
            wp_safe_redirect( $pagenow );
            exit;
          }
  
        }

        $this->extensions = apply_filters( 'abuframework_extensions', $this->extensions );


      }

      final public function admin_menu() {
        
        $menu_page = add_submenu_page( 'tools.php', 'AbuFramework', 'AbuFramework', 'manage_options', 'abuframework-about', array( $this, 'abuRenderPage' ) );

        add_action( "load-{$menu_page}", array( &$this, 'pageLoad' ) );

      }

      final public function abuRenderPage() {

        echo '<div class="wrap about-wrap  abu-about-wrap"><h1></h1>';

          echo '<div class="abu-about">';
            echo '<h1>' . __( 'AbuFramework' ) . '</h1>';
          echo '</div>';

          echo '<div class="about-text">AbuFramework is modern & advanced Framework.</div>';

          echo '<div class="about-text">';
              if ( abu_ekey( 'AbuFrameworkDemo', $this->opts, 'no' ) == 'no' ) {
                echo '<a class="button button-primary" href="./tools.php?page=abuframework-about&AbuFrameworkDemo=yes">' . __( 'Activate Demo', 'AbuFramework' ) . '</a>';
              } else {
                echo '<a class="button button-primary" href="./tools.php?page=abuframework-about&AbuFrameworkDemo=no">' . __( 'Deactivate Demo', 'AbuFramework' ) . '</a>';
              }
          echo '</div>';
          
          $tabs = [
            [ 'title' => 'About' ],
            [ 'title' => 'Extensions' ],
            [ 'title' => 'Support' ],
            [ 'title' => 'Changelog' ],
          ];
          $active = isset( $_GET['tab'] ) ? strtolower( $_GET['tab'] ) : 'about';

          echo '<h4 class="nav-tab-wrapper">';
            foreach( $tabs as $k => $t ) {
              echo '<a href="' . add_query_arg( array( 'page' => 'abuframework-about', 'tab' => esc_attr( strtolower( $t['title'] ) ) ), admin_url( 'tools.php' ) ) . '" class="nav-tab' . ( strtolower( $t['title'] ) == strtolower( $active ) ? ' nav-tab-active' : '' ) . '">' . esc_html( $t['title'] ) . '</a>';
            }  
          echo '</h4>';

          echo '<div class="tab-wrapper">'; 
            echo ( $active == 'extensions' ? $this->extensions() : abu_load_template( $active , ABU_CORE . 'tabs/') );
          echo '</div>';

        echo '<div>';
      }

      final private function saving() {

        // verifying nonce
        if( function_exists( 'wp_verify_nonce' ) ) {
          if( ! wp_verify_nonce( abu_var( 'abu_nonce_core', 'faridbdabad'  ), 'abu_nonce' ) && empty($request) ) return false;
        }
        
        if( ! isset( $_POST['AbuFrameworkCoreActivate'] ) ) return false;
        $options = is_array( abu_ekey( 'AbuFrameworkCoreActivate', $this->opts, '' ) ) ? $this->opts['AbuFrameworkCoreActivate'] : [];
        $options = array_merge( $options, $_POST['AbuFrameworkCoreActivate'] );
        $this->opts = abu_set_options( 
          [ 'framework_id' => 'AbuFrameworkOwn', 'database' => $this->database ], 
          [ 'AbuFrameworkCoreActivate' => $options ] 
        );
        return true;

      }

      final private function extensions(){
        echo '<form action="" method="post">';
        wp_nonce_field( 'abu_nonce', "abu_nonce_core", false );
          echo '<div class="abu-extension">';
              $extensions = $this->extensions;
              $options    = is_array( abu_ekey( 'AbuFrameworkCoreActivate', $this->opts, '' ) ) ? $this->opts['AbuFrameworkCoreActivate'] : [];
              if( is_array( $extensions ) ) {
                foreach ($extensions as $key => $ext) {
                  echo '<div class="abu-single-extension">';
                    echo '<div class="extension-inner">';
                      echo '<div class="extension-image">';
                        echo '<img src="' . abu_ekey( 'image', $ext, ABU_IMG . 'ext-' . strtolower( $ext['id'] ) . '.jpg' ) . '" width="100%" height="auto">';
                      echo '</div>';
                      echo '<div class="extension-content">';
                        echo '<div class="activation-buttons">';
                            $val = abu_ekey( 'id', $ext, abu_ekey( 'title', $ext, 'Activate' . $key) );
                            echo '<button class="button" type="submit" name="AbuFrameworkCoreActivate['.$val.']" value="' . ( abu_ekey( $val, $options, 'deactivated' ) == 'activated' ? 'deactivated' : 'activated' ) . '">';
                              echo abu_ekey( $val, $options, 'deactivated' ) == 'activated' ? 'Deactivate' : 'Activate';
                            echo '</button>';
                        echo '</div>';
                        echo '<h4 class="extension-title">' . abu_ekey( 'title', $ext, NULL ) . '</h4>';
                        echo '<div class="extension-desc">' . abu_ekey( 'desc', $ext, 'Activate' . $key) . '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                }
              }
            echo '<div class="abu-clearfix"></div>';
          echo '</div>';
        echo '<form>';
      }

      public function pageLoad() {
        add_filter( 'admin_footer_text', array( &$this, 'admin_footer_text' ) );
      }

      public function admin_footer_text() {
        echo sprintf( 
          __('Thank you for creating with %s Abu Framework %s', 'AbuFramework'),
          '<a href="http://abusufiyan.com/?ref=abuframework" target="_blank">',
          '</a>'
        ); 
      }
  
      final public function plugin_row_meta( $links = [], $file = 'file', $plugin = [] ) {
        
        if ( isset( $plugin['Name'] ) && $plugin['Name'] === 'AbuFramework' ) {
          if ( ! is_network_admin() || ! is_multisite() ) {
              if ( abu_ekey( 'AbuFrameworkDemo', $this->opts, 'no' ) == 'no' ) {
                $links[] = '<span style="display: block; padding-top: 6px;"><a href="./plugins.php?AbuFrameworkDemo=yes" style="color: #a20202;">' . __( 'Activate Demo', 'AbuFramework' ) . '</a></span>';
              } else {
                $links[] = '<span style="display: block; padding-top: 6px;"><a href="./plugins.php?AbuFrameworkDemo=no" style="color: #a20202;">' . __( 'Deactivate Demo', 'AbuFramework' ) . '</a></span>';
              }
          }
        }
  
        return $links;

      }

      final public function wp_head() {
        echo '<!-- AbuFramework Starts -->';
        echo abu_ekey( 'headerhtml', $this->core, '' );
        echo '<style id="AbuFramework_css">' . esc_attr( abu_ekey( 'css_editor', $this->core, '' ) ) . '</style>';
        echo '<!-- AbuFramework End -->';
      }

      final public function wp_footer() {
        echo '<!-- AbuFramework Starts -->';
        echo abu_ekey( 'footerhtml', $this->core, '' );
        echo '<script id="AbuFramework_js">' . abu_ekey( 'js_editor', $this->core, '' ) . '</script>';
        echo '<!-- AbuFramework End -->';
      }
    
    }
    global $AbuFrameworkCore;
    $AbuFrameworkCore = new AbuFrameworkCore();
}


if( ! function_exists('abuframework_extensions') ) {
  add_filter( 'abuframework_extensions', 'abuframework_extensions' );
  function abuframework_extensions( $exts ) {
    
    $exts[] = [
      'title' => _x( 'WPOption Framework', 'Title name of Framework', 'AbuFramework' ),
      'id'    => 'WPOption',
      'desc'  => __( 'It allows you to create highly modern and advanced Admin Option Page with highlevel setting and fields. It work with ajax. Fetch needed section only to reduce load time and make you user great experience', 'AbuFramework' ),
    ];

    $exts[] = [
      'title' => _x( 'Metabox Framework', 'Title name of Framework', 'AbuFramework' ),
      'desc'  => __( 'You can create custom highly Metaboxes for your pages and posts', 'AbuFramework' ),
      'id'    => 'Metabox',
    ];

    $exts[] = [
      'title' => _x( 'TabOn Framework', 'Title name of Framework', 'AbuFramework' ),
      'desc'  => __( 'It allows you to create highly modern and advanced Admin TabOn Page with highlevel setting and fields.', 'AbuFramework' ),
      'id'    => 'TabOn',
    ];

    $exts[] = [
      'title' => _x( 'Widget Framework', 'Title name of Framework', 'AbuFramework' ),
      'desc'  => __( 'It allows you to create widgets with highlevel setting and fields.', 'AbuFramework' ),
      'id'    => 'Widget',
    ];

    $exts[] = [
      'title' => _x( 'Taxonomy Framework', 'Title name of Framework', 'AbuFramework' ),
      'desc'  => __( 'It allows you to create custom taxonomies to all of your tags, categories or any CPT with highlevel setting and fields.', 'AbuFramework' ),
      'id'    => 'Taxonomy',
    ];

    $exts[] = [
      'title' => _x( 'UserProfile Framework', 'Title name of Framework', 'AbuFramework' ),
      'id'    => 'UserProfile',
      'desc'  => __( 'It allows you to create custom highlevel setting and fields in user profile edit/save/add page.', 'AbuFramework' ),
    ];
    
    return $exts;
  }
}



