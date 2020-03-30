<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * abuTaxonomy CLASS for Creating option in Taxonomy from AbuFramework
 * @since 1.0.0
 * @version 1.0.0
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

if( class_exists('abuTaxonomy') ) return;

class abuTaxonomy extends abuFramework {

    public $error = [];

    final protected function init( array $args, array $sections = [] ) {

        if ( is_admin()) {

            $this->args = abu_field_extra( $args, [

            ]);

            if( $args['taxonomy'] != abu_var('taxonomy') ) return;

            $this->id = $args['id'];

            $this->sections = abu_all_sections($sections); 
            $this->fields  = abu_get_fields( $this->sections );

            $this->saved_value = [];

            $screen = $args['taxonomy'];
            if( is_array( $screen ) ) {
                if( ! in_array( abu_var( 'taxonomy' ), $screen ) ) return;
            } elseif( is_string( $screen ) ) {
                if ( $screen != abu_var( 'taxonomy' ) ) return;
            }
            
            add_action( 'admin_init', array( $this, 'init_taxonomy' ) );            
            
        }

    }

    final public static function create( $args, $sections ){
        return ( new SELF )->init( $args, $sections );
    }
 
    /**
     * Taxononmy initialization.
     */
    public function init_taxonomy() {

        add_action( "{$this->args['taxonomy']}_add_form_fields", array( $this, 'render_taxonomy_fields' ) );
        add_action( "{$this->args['taxonomy']}_edit_form",  array( $this, 'render_taxonomy_fields' ) );

        add_action( "create_{$this->args['taxonomy']}", array( $this, 'save_taxonomy' ) );
        add_action( "edited_{$this->args['taxonomy']}", array( $this, 'save_taxonomy' ) );
        add_action( "delete_{$this->args['taxonomy']}", array( $this, 'delete_taxonomy' ) );
        
        return false;
 
    }

 
    /**
     * Renders the meta box.
     */
    public function render_taxonomy_fields( $term ) {
        
        
        $id = $this->id;
        $args = $this->args;
        $is_edit_term = ( is_object( $term ) && isset( $term->taxonomy ) ) ? true : false;
        $term  = ( $is_edit_term ) ? $term->term_taxonomy_id : $term;
        $place = ( $is_edit_term ) ? 'edit' : 'add';
        $save_values = $is_edit_term ? get_term_meta( $term, $id, 1 ) : '';
        $this->saved_value = $save_values = is_array( $save_values ) ? $save_values : [];
        $error = $this->error = abu_sanitization_validation_escaping( $save_values, $this->fields );

        // // Add nonce for security and authentication.
        echo '<!-- ' . __('AbuFramework Field Start.', 'AbuFramework') . ' -->';
        echo '<div class="abu-elements abu-tab abu-taxonomy-' . $place . '" id="' . $id . '">';
            wp_nonce_field( "abu_taxonomy_{$id}_nonce_action", "abu_taxonomy_{$id}_nonce", 1, 1 );
            echo '<h1 class="wp-heading-inline">' . esc_html( abu_ekey( 'title', $args , '') ) . '</h1><hr/>';
            foreach ($this->sections as $section) {

                foreach ($section['fields'] as $field ) {
                    $field['element-class'] = 'form-field';
                    $field['depend_id'] = $field['id'];
                    $field['__error'] = abu_ekey($field['id'], $error, '');
                    $value = isset( $save_values[$field['id']] ) ? $save_values[$field['id']] : abu_ekey( [ 'default', 'value' ], $save_values, '' );
                    echo add_abu_tattv( $field, $value, $id, 'widgets' );
                }

            }
        echo '</div>';

    }
 
    // add/edit taxonomy
    public function save_taxonomy( $term_id ) {
        
        $args = $this->args;
        $id = $this->id;
        $prev_value = get_term_meta( $term_id, $id, true );

        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST["abu_taxonomy_{$id}_nonce"] ) ? $_POST["abu_taxonomy_{$id}_nonce"] : '';
        
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, "abu_taxonomy_{$id}_nonce_action" ) ) return;

        $request = isset( $_POST[$id] ) ? $_POST[$id] : '';
        if( empty( $request ) ) {
            delete_term_meta( $term_id, $id );
            return;
        };
        
        $request = abu_sanitization_validation_escaping( $request, $this->fields );
        $request = apply_filters( 'after_abu_term_save', $request, $this->sections, $term_id );
        $request = $request['request'];

        if( empty( $prev_value ) ) {
            add_term_meta( $term_id, $id, $request );
        } else {
            update_term_meta( $term_id, $id, $request, $prev_value );
        }
        
        return;

    }

    // delete taxonomy
    public function delete_taxonomy( $term_id ) {
        delete_term_meta( $term_id, $this->id );
    }

}



