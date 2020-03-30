<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * abuMetaBoxes CLASS for Adding MetaBoxes from AbuFramework
 * @since 1.0.0
 * @version 1.0.0
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */
if( class_exists( 'abuMetaBoxes' ) ) return;


class abuMetaBoxes extends abuFramework {
    
    function __construct( array $args, array $sections = [] ) {

        if ( is_admin() ) {

            global $post_id;

            $this->id = $this->_id = $args['id'];

            $this->sections = abu_field_extra($sections, []);
            
            $this->args = $this->settings = abu_field_extra( $args, [
              'title'           => __( 'Abu MetaBox', 'AbuFramework' ),
              'context'         => 'advanced',
              'screen'          => ['post', 'page'],
              'priority'        => 'default',
              
              'form'            => false,
              'head'            => false,
              'footer'          => false,
              'render'          => false,
              'framework_class' => 'abu-meta-box',
              'framework_id'    => $args['id'],
              'reset'           => false,
              'reset_section'   => false,

              'show_multi'      => false
            ]);

            $this->saved_value = [];
            
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        }
        add_action( "wp_ajax_" .$args['id']. "_fields", array( $this, 'meta_ajax_fields' ) );

    }

    final public static function create( $args, $sections ){
        return new SELF( $args, $sections );
    }
 
    /**
     * Meta box initialization.
     */
    public function init_metabox() {

        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes'  ) );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
        add_action( 'admin_head', array( $this, 'admin_head' ) );
        return false;
 
    }

    /**
     * Adds the meta box.
     */
    public function add_meta_boxes() {

        $f = $this->args;
        add_meta_box( $this->id, $f['title'], array( $this, 'render_metabox' ), $f['screen'], $f['context'], $f['priority'] );

    }
 
    /**
     * Renders the meta box.
     */
    public function render_metabox( $post ) {

        // Add nonce for security and authentication.
        wp_nonce_field( "{$this->id}_nonce_action", "{$this->id}_nonce" );
        global $post_id;
        $this->saved_value = get_post_meta( $post_id, $this->id, 1 );
        $instance = new abuWPOptions(); 
        $this->args['reset_change'] = false;
        $instance->abuOptionsRenders( $this->args, $this->sections, $this->saved_value, true );
        unset( $instance );

    }
 
    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_metabox( $post_id, $post ) {

        $args = $this->args;
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST["{$this->id}_nonce"] ) ? $_POST["{$this->id}_nonce"] : '';
        
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, "{$this->id}_nonce_action" ) ) return;

        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post' ) ) return;
        
        // Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) return;
        
        // Check if not a revision.
        if ( wp_is_post_revision( $post_id ) ) return;

        if ( ! current_user_can( 'edit_page', $post_id ) ) return;

        // check permissions
        $screen = $args['screen'];
        if( is_array( $screen ) ) {
            if( ! in_array( $_POST['post_type'], $screen ) ) return;
        } elseif( is_string( $screen ) ) {
            if ( $screen != $_POST['post_type'] ) return;
        }


        $request = isset( $_POST["$this->id"] ) ? $_POST["$this->id"] : '';
        $request = abu_sanitization_validation_escaping( $request, $this->sections );
        $request = $request['request'];
        $request = apply_filters( 'after_abu_meta_save', $request, $this->sections, $post_id );

        if( empty( $request ) ) {
          delete_post_meta( $post_id, $this->id );
        } else {
          update_post_meta( $post_id, $this->id, $request );
        }
        
        return;

    }

    final public function meta_ajax_fields() {

        $_POST = $_POST['data'];
        if( empty($_POST['section_id']) ){
            wp_send_json_error( __( 'Failed', 'AbuFramework' ) );
        }
        foreach( $this->sections as $sec ) {
            if( $_POST['section_id'] ==  $sec['id'] ) {
            $this->saved_value = get_post_meta( $post_id, $this->id, 1 );
            wp_send_json( $post_id );
            ('abuWPOptions')::renderSection( $sec['fields'], $this->id, $this->saved_value, $this->errors, true);
            break;
            wp_die();
        }
        }
        wp_die();
    }

    final public function admin_head() {
        $s = $this->args;
        global $post_id;
        echo '<script>
        var ' . $this->_id . '_var = ' . wp_json_encode([
            'show_multi' => $s['show_multi'] ? true : false
        ]) . ',';
        echo $this->_id . ' = ' . wp_json_encode( get_post_meta( $post_id, $this->id, 1 ) ) . ';';
        echo '</script>';
    }

}
