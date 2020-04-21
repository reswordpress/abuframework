<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * abuTabOn CLASS for Creating Tabs/Options from AbuFramework
 * @since 1.0.0
 * @version 1.0.0
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

if( class_exists( 'abuTabOn' ) ) return;

class abuTabOn extends abuWPOptions {
    
    public $_id = '';
    
    final public static function create( $args, $tabs ) {
        return new SELF( $args, $tabs );
    }

    public function abuOptionsRenders( $setting = NULL, $tabs = NULL, $save_values = [], bool $echo = false ) {

        $id = $setting['id'];

        $setting = abu_field_extra( $setting, [
            'place'    => 'abuTabs',
            'form'     => true,
            'tabs'     => true,
            'submit'   => true
        ]);
        
        if( $setting['tabs'] ) {
            $section_active = abu_var('tab');
            $actived_tab    = 'abuNoting@#%';
            if( ! empty( $section_active ) ) {
              $actived_tab  = array_search( $section_active, array_column( $tabs, 'id' ));
            }      
        }
                
        // Add nonce for security and authentication.
        echo '<!-- ' . __('AbuFramework Field Start.', 'AbuFramework') . ' -->';
        echo '<div class="abu-abuTabOn abu-options-framework ' . $setting['place'] . '" id="' . $id . '">';

            echo abu_iekey( 'title', $setting ) ? ( '<h1>' . $setting['title'] . '</h1>' ) : '';
            echo abu_iekey( 'desc', $setting ) ? ( '<div class="about-text">' . $setting['desc'] . '</div>' ) : '';
            

            if( $setting['form'] ) echo '<form method="POST" action="" enctype="multipart/form-data" >';

                wp_nonce_field( 'abu_nonce', "abu_nonce_{$id}" , true, true );
                if( $setting['tabs'] ) {
                    echo  '<div class="abu-section-nav">';
                        echo  '<h2 class="nav-tab-wrapper">';
                            if( ! empty($tabs) ) {
                                foreach ($tabs as $key => $value ) {
                                    $section_title = abu_ekey( 'title', $value, abu_ekey( 'id', $value, '' ) );
                                    echo   '<a class="nav-tab' . ( $actived_tab == $key ? ' nav-tab-active' : '' )  . '" href="' . menu_page_url( $setting['menu_slug'], 0 ) . '&tab=' . $value['id'] . '" abu-tab="'  . $value['id'] . '"' . abu_depend_helper( $tabs ) . '>' . $section_title . '</a>';
                                }
                            }
                        echo '</h2>';
                    echo '</div>';
                }
            
                echo '<div class="tab-wrapper">';
                    if( ! empty($tabs) ) {
                        foreach ($tabs as $key => $section) {

                            echo '<div class="abu-tab-content" id="' . abu_ekey( 'id', $section, '' ) . '">';
                                echo self::section( $section, $save_values, $id );
                                if( isset($section['sub-section']) && ! empty( $section['sub-section'] ) ) {
                                    foreach ( $section['sub-section'] as $sub_key => $sub_section) {
                                        echo self::section( $sub_section, $save_values, $id );
                                    }
                                }
                            echo '</div>';
            
                        }
                        if( abu_ekey( 'submit', $setting, false ) ) {
                            submit_button( 'Save Changes' , 'abu-botton button-primary abu-save-botton', 'submit', false );
                        }
                    }
                echo '</div>';

            if( $setting['form'] ) echo '</form>';

        echo '</div>';
        
        return;

    }

    public static function section( $section, $save_values, $id ) {

        echo '<div class="abu-single-section" id="abu-section-' . ( abu_ekey( 'id', $section, '' ) ) . '">';
            if( isset($section['title']) ) {
                echo '<h1>' . esc_html( $section['title'] ) . '</h1><hr/>';
            }
            echo '<div class="abu-elements abu-tab">';
                foreach ($section['fields'] as $field ) {
                    $field['depend_id'] = $field['id'];
                    $value = isset( $save_values[$field['id']] ) ? $save_values[$field['id']] : abu_ekey( [ 'default', 'value' ], $save_values, '' );
                    echo add_abu_tattv( $field, $value, $id, 'widgets' );
                }
            echo '</div>';
        echo '</div>';
        
    }
 
}