<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * abuUserProfile CLASS for Adding Field in User Profile from AbuFramework
 * @since 1.0.0
 * @version 1.0.0
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */
if( class_exists( 'abuUserProfile' ) ) return;

class abuUserProfile extends abuFramework {

    public $error = [];

    final protected function init( array $args, array $sections = [] ) {

        if ( is_admin()) {

            $this->args = abu_field_extra( $args, [
                'title' => ''
            ]);

            $this->id = $args['id'];

            $this->sections = abu_all_sections($sections); 
            $this->fields   = abu_get_fields( $this->sections );

            $this->saved_value = [];
                
            add_action( 'load-profile.php', array( $this, 'init_userProfile' ) );
            add_action( 'load-user-new.php', array( $this, 'init_userProfile' ) );
            add_action( 'load-user-edit.php', array( $this, 'init_userProfile' ) );
            add_action( 'delete_user', array( $this, 'delete_init' ));
            
            
        }

    }

    final public static function create( $args, $sections ){
        return ( new SELF )->init( $args, $sections );
    }
 
    /**
     * UserProfile initialization.
     */
    public function init_userProfile() {

        add_action( "show_user_profile", array( $this, 'render_user_profile' ) );
        add_action( "edit_user_profile",  array( $this, 'render_user_profile' ) );
        add_action( "user_new_form", array( $this, 'render_user_profile' ) );

        add_action( 'personal_options_update', array( $this, 'save_init' ) );
        add_action( 'profile_update', array( $this, 'save_init' ));
        add_action( 'edit_user_profile_update', array( $this, 'save_init' ) );
        add_action( 'user_register', array( $this, 'save_init' ));

        return;
 
    }

 
    /**
     * Renders the Fields box.
     */
    public function render_user_profile( $user ) {
        
        $id   = $this->id;
        $args = $this->args;
        $sections = $this->sections;
        $this->saved_value = $save_values = get_the_author_meta( $id, $user->ID );
        $place = (array) get_current_screen();
        $place = $place['base'] . ( empty($place['action']) ? '' : '-' . $place['action'] );
        $error = $this->error = abu_sanitization_validation_escaping( $save_values, $this->fields )['errors'];
        
        // Add nonce for security and authentication.
        echo  '<!-- ' . __('AbuFramework Field Start.', 'AbuFramework') . ' -->';
        echo '<div class="abu-userProfile abu-tab abu-userProfile-' . $place . '" id="' . $id . '">';
            echo '<h1 class="wp-heading-inline">' . esc_html( $args['title'] ) . '</h1><hr/>';
            wp_nonce_field( "abu_user_{$this->id}_nonce_action", "abu_user_{$this->id}_nonce", 1, 1 );
            foreach ($sections as $section) {
                echo '<div class="abu-single-section" id="abu-section-' . ( abu_ekey( 'id', $section, '' ) ) . '">';
                    if( abu_iekey( 'title', $section, false ) ) echo '<h2>' . esc_html( $section['title'] ) . '</h2>';
                    echo '<div class="abu-elements">';
                        foreach ($section['fields'] as $field ) {
                            $field['element-class'] = 'form-field';
                            $field['depend_id'] = $field['id'];
                            $field['__error'] = abu_ekey($field['id'] ,$error, '');
                            $value = isset( $save_values[$field['id']] ) ? $save_values[$field['id']] : abu_ekey( [ 'default', 'value' ], $save_values, '' );
                            echo add_abu_tattv( $field, $value, $id, 'widgets' );
                        }
                    echo '</div>';
                echo '</div>';
            }
        echo '</div>';

    }
 
    // add/edit/save/delete
    public function save_init( $user_id ) {
        
        if ( ! current_user_can( 'edit_user', $user_id ) ) wp_die( __("You don't have permission.", "AbuFramework") );
        $args = $this->args;
        $id = $this->id;
        $prev_value = get_user_meta( $user_id, $id, true );
        
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST["abu_user_{$id}_nonce"] ) ? $_POST["abu_user_{$id}_nonce"] : '';
        
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, "abu_user_{$id}_nonce_action" ) ) return;
        
        
        $request = isset( $_POST[$id] ) ? $_POST[$id] : '';
        if( empty( $request ) ) {
            delete_user_meta( $user_id, $id );
            return;
        };
        
        
        $request = abu_sanitization_validation_escaping( $request, $this->fields );
        $request = apply_filters( "before_abu_user_{$id}_save", $request, $this->sections, $user_id );
        $request = $request['request'];
        $this->error = $request['errors'];
        
        if( empty( $prev_value ) ) {
            add_user_meta( $user_id, $id, $request );
        } else {
            update_user_meta( $user_id, $id, $request, $prev_value );
        }
        
        return true;

    }

    // delete taxonomy
    public function delete_init( $user_id ) {
       return delete_user_meta( $user_id, $this->id );
    }

}



