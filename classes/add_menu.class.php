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

class abuAddMenu extends abuFramework {

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

    ]));
  

    add_action( 'admin_menu',  array( $this, 'admin_menu' ), 20 );
    if( abu_ekey( 'show_network_menu', $settings, false ) ) {
      add_action( 'network_admin_menu', array( &$this, 'admin_menu' ) );
    }

    
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

  public function admin_footer_text() {
    echo abu_ekey( 'footer_credit', $this->settings, sprintf( 
      __('Thank you for creating with %s Abu Framework %s', 'AbuFramework'),
      '<a href="http://abusufiyan.com/?ref=abuframework" target="_blank">',
      '</a>'
    )); 
  }

}


?>
