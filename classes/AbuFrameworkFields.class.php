<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * AbuFrameworkFields CLASS from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

 /**
 *
 * AbuFrameworkFields CLASS
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
abstract class AbuFrameworkFields extends abuFramework {

  private $all_before_content, $all_after_content = '';

  protected $extra = [];

  protected $_id;

  public function __construct( &$f = [], $v = '', $extra = [], $_id = '', $place = '' ) {

      $this->v         = $v;
      $f['field_only'] = false;
      $this->f = $f = $this->extra = ( is_array( $extra ) && count( $extra ) ? abu_field_extra( $f, $extra ) : $f ) ;
      $this->_id  = $_id;

  }

  final protected function createField( string $render_content = '', bool $abu_checks = false, array $classes = [], array $args = [] ) {

    $o = '';
    $field = $this->f;

    $abu_element_type = abu_ekey( 'type', $field, '' );

    $abu_title      =  abu_iekey( 'title', $field ) ? abu_ekey( 'title', $field ) : false;
    $abu_subtitle   =  abu_iekey( 'subtitle', $field) ? '<span class="abu-subtitle">' . $field['subtitle'] . '</span>' : '';
    $abu_field_class  = 'class="abu-field-wrap ' . ( ! $abu_title ? 'abu-field-wrap-removed' : '' ) . abu_array_str( abu_ekey( 'field-class', $field ) ) . abu_array_str( abu_ekey( 'field-class', $classes ) ) . '"';

    // Element Wrapper
    $full_width = $abu_title ? abu_ekey( 'full-width', $field, false ) : true;
    $abu_element_class  =  ' abu-field-' . str_replace('_', '-', strtolower($abu_element_type) ) .' '. abu_addClass_tattv( 'element-class', $field ) . ' ';
    $abu_element_class .=  ( $abu_checks  ? ' abu-checks ' : '' ) . abu_array_str( abu_ekey( 'element-class', $classes ) ) . ( $full_width ? ' abu-full-element-width' : '' );

    $abudepend = abu_depend_helper( $field, $this->value_tattv() );

    $o .= '<div class="abu-element ' . abu_wspace( $abu_element_class ) . '" ' . abu_array_atr( abu_ekey( 'element-attr', $field, [] ) ) . ' abu-field-id="' . esc_attr( $field['id'] ) . '" ' . $abudepend .' >';
      if( $abu_title ) {
        $o .= '<div class="abu-title-wrap ' . abu_array_str( abu_ekey( 'title-class', $field ) ) . abu_array_str( abu_ekey( 'title-class', $classes ) )   . '"><h4>' . $abu_title  . '</h4>' . $abu_subtitle . '</div>';
      }

      $o .= '<div ' . abu_wspace( $abu_field_class ) . '>';

        if( isset( $field['before'] ) ) {
            if( is_string($field['before']) ) {
                $o .= '<span class="input-before">'. $field['before'] .'</span>';
            } elseif( is_array($field['before']) ) {

                $type =  abu_ekey( 'type', $field['before'], 'normal' );
                $display = abu_ekey( 'display', $field['before'], false );
                $display = $display['display'] == 'inline' ? 'abu-inline-block' : 'abu-block';
                $text = abu_ekey( 'text', $field['before'] );

                $o .= '<span class="abu-'. $type .' '. $display .' input-before">'. $text .'</span>';

            } 
        }
        $o .= $this->all_before_content;

          $o .= $render_content;
          $o .= '<div class="abu-description abu-field-description">' . abu_ekey( [ 'desc', 'description' ], $this->f ) . '</div>';
          $o .= '<span class="abu-danger abu-noticed abu-field-error ' . ( isset( $f['__error'] ) && !empty($f['__error']) ? ' error-on"><span class="dashicons dashicons-info"></span>'. esc_html( $f['__error'] ) : '">') .'</span>';
        
        if( isset($field['after']) ) {

            if( is_string( $field['after'] ) ) {
                $o .= '<span class="input-after">'. $field['after'] .'</span>';
            } elseif( is_array($field['after']) ) {

                $type =  abu_ekey( 'type',$field['after'], 'normal' );
                $display = abu_ekey( 'display', $field['after'], false );
                $display = $display['display'] == 'inline' ? 'abu-inline-block' : 'abu-block';
                $text = abu_ekey( 'text', $field['after'] );

                $o .= '<span class="abu-'. esc_attr( $type ) .' '. esc_attr( $display ) .' input-after">'. $text .'</span>';

            }
        }
        $o .= $this->all_after_content;

      $o .= '</div>';
      if( abu_iekey( 'help', $field ) ) {
        $o .= '<span class="abu-tooltip" tooltip="' . strip_tags( abu_ekey( 'help', $field ) ) . '"><i class="far fa-question-circle"></i></span>';
      }

    $o .= '<div class="abu-clearfix"></div></div>';

    return $o;

  }

  protected function type_tattv( $tag = false, $add = '', $type = 'abu12' ) {
    $get  = isset( $this->f['type'] ) ? $this->f['type'] : $type;
    $type = $type == 'abu12'  ? $get : $type;
    if( $tag ) {
      $type = ' type="' . esc_attr( $type ) . '" ';
    }
    return $type;
  }

  protected function id_tattv( $tag = false, $add = '', $ID = 'abu12' ) {

    $ID = $ID == 'abu12' ? abu_ekey('id', $this->f, '') : $ID;
    if( $tag && empty($ID) ) return;
    return $ID;

  }

  protected function name_tattv( $tag = false, $add = '', $name = 'abu12' ) {

    $field      = $this->f;
    $field_id   = abu_ekey( 'id', $field, '' );
    $field_name = !empty( $this->_id ) ? $this->_id . '[' . $field_id . ']'  : $field_id;
    $field_name = !empty( abu_ekey( 'name', $field, '' ) ) ? $field['name'] : $field_name;
    $field_name = $name == 'abu12' ? $field_name : $name;
    $field_name .=  $add;

    if( $tag ) {
      $field_name = ' name="' . esc_attr( $field_name ) . '" ';
    }

    return $field_name;

  }

  protected function depend_tattv( $tag = true, $ID = '', $add = '' ) {
    return ' abu-depend-id="' . esc_attr( ( empty( $ID ) ? abu_ekey( 'depend_id', $this->f, $this->id_tattv() ) : $ID  ) . $add ) . '"';
  }

  protected function class_tattv( $tag = true, $class = [] ) {

    $o = isset($this->f['class']) ? abu_array_str( $this->f['class'] ) : '';

    if( ! empty( $class ) ) $o .=  ' ' . abu_array_str( $class );
    
    if( $tag && !empty( $o ) ) $o .= ' class="' . esc_attr( $o ) . '" ';
    return trim( $o );

  }

  protected function attr_tattv( $attrs = '' ) {

    $o = '';

    $fattr = [];
    foreach ( ['attr', 'attribute', 'attributes'] as $attr ) {
      if( isset( $this->f[$attr] ) ) {
        $fattr = $this->f[$attr];
        break;
      }
      continue;
    }
    
    if( ! empty( $fattr ) ) {
      if( is_array( $fattr ) ) {
          foreach ( $fattr as $key => $value) {
            if( $key == 'class' ){ continue; }
            if( $value == 'key-only' ) {
              $o .= ' ' . esc_attr( $key ) . ' ';
              continue;
            }
            $o .= $key . '="' . esc_attr( $value ) . '" ';
          }
      }
    }

    if( is_array( $attrs ) ) {
        foreach ( $attrs as $key => $value) {
          if( in_array( $key, $fattr ) ) continue;
          if( $key == 'class' ){ continue; }
          if( $value == 'key-only' ) {
            $o .= ' ' . esc_attr( $key ) . ' ';
            continue;
          }
          $o .= $key . '="' . esc_attr( strval($value) ) . '" ';
        }
    }
 

    return $o;

  }

  protected function value_tattv( $tag = false, $add = '', $value = 'abu12' ) {

    $o = $this->v;
    if( is_string( $o ) ) {
      $o .= ! empty( $add ) ? $o . $add : '';
    }

    $o = $value == 'abu12' ? $o : $value;

    if( $tag && !empty($o) ) {
      if( is_array( $o ) || is_object( $o ) ) return;
      $o =  ' value="' . esc_attr( is_array( $o ) ? implode(' ', $o) : strval($o) ) . '"';
    }

    return $o;

  }

  protected function core_data( $type = '', $query_args = [] ) {
      $o = [];
      $query_args = !empty( $this->field['query_args'] ) ? $this->field['query_args'] : [];

      switch( $type ) {

        case 'page':
        case 'pages':
          $type = 'page';
        break;

        case 'post':
        case 'posts':
          $type = 'post';
        break;

        case 'category':
        case 'categories':
          $type = 'category';
        break;

        case 'tag':
        case 'tags':
          $type = 'post_tag';
        break;

      }


      switch( $type ) {

        case 'page':
            $pages = get_pages( $query_args );
            if ( ! (is_wp_error( $pages ) && empty( $pages )) ) {
              foreach ( $pages as $page ) {
                $o[$page->ID] = $page->post_title;
              }
            }
        break;

        case 'post':
            $posts = get_posts( $query_args );
            if ( ! (is_wp_error( $posts ) && empty( $posts )) ) {
              foreach ( $posts as $post ) {
                $o[$post->ID] = $post->post_title;
              }
            }
        break;

        case 'post_tag':
        case 'category':
          
          $term_query = new WP_Term_Query( abu_field_extra( $query_args, [
            'taxonomy'   => $type,
            'hide_empty' => false,
            'fields'     => 'all'
          ]));

          if( !is_wp_error( $term_query ) && ! empty( $term_query->terms) ) {
            foreach( $term_query->terms as $term ) {
              $o[$term->term_id] = $term->name;
            }
          }


        break;


        case 'menus':
        case 'menu':
          $menus = wp_get_nav_menus( $query_args );
          if ( ! (is_wp_error( $menus ) && empty( $menus )) ) {
            foreach ( $menus as $menu ) {
              $o[$menu->term_id] = $menu->name;
            }
          }
        break;
        

        case 'post_types':
        case 'post_type':
          $post_types = get_post_types( abu_field_extra($query_args, [
            'show_in_nav_menus' => true
          ]) );
          if ( ! ( is_wp_error( $post_types ) && empty( $post_types ) ) ) {
            foreach ( $post_types as $post_type ) {
              $o[$post_type] = ucfirst( $post_type );
            }
          }
        break;

        case 'role':
        case 'roles':
          global $wp_roles;
          if( is_object( $wp_roles ) && !empty($wp_roles) ) {
            $roles = $wp_roles->get_names();
            if( is_array( $roles ) ) {
              foreach( $roles as $key => $value ) {
               $o[$key] = $value;
              }
            }
          }
        break;

        case 'sidebar':
        case 'sidebars':
          global $wp_registered_sidebars;
          if( ! empty( $wp_registered_sidebars ) ) {
            foreach( $wp_registered_sidebars as $sidebar ) {
              $o[$sidebar['id']] = $sidebar['name'];
            }
          }
        break;

        default:
          if( function_exists( $type ) ) $o = call_user_func( $type, $this->v, $this->f );

      }

      return $o;

  }

  protected function bulk_tattv( array $bulks = [ 'allowed' => null, 'disallowed' => null ], array $args = [ 'all' => true ], $added = '' ) {

    $o = '';
    $allowing = [ 'type', 'name', 'depend', 'attr', 'class', 'value' ];
    if( ! empty($added) ) {
      if( is_string( $added ) ) {
        $allowing[] =  $added;
      } elseif( is_array( $added ) ) {
        array_merge( $allowing, $added );
      }
    }

    if( isset( $bulks['allowed'] ) ) $allowing = $bulks['allowed'];

    if( isset( $bulks['disallowed'] ) ) {
      $disallowed = is_array( $bulks['disallowed'] ) ? $bulks['disallowed'] : [ $bulks['disallowed'] ];
      $allowing = array_diff( $allowing, $disallowed );
      $allowing = array_values( $allowing );
    }


    foreach( $allowing as $bulk ) {

      $callable = $bulk . '_tattv';

      if( isset( $args[$bulk] ) ) {
        $arg = is_string( $args[$bulk] ) ? [ $args[$bulk] ] : $args[$bulk];
        if( method_exists( $this, $callable ) ) {
          $content = is_array( $arg ) ? call_user_func_array( array( $this, $callable ), $arg ) : ($this)->$callable( $arg );
        }
      } elseif ( isset( $args['all'] ) ) {
        $arg = is_string( $args['all'] ) ? [ $args['all'] ] : $args['all'];
        $arg = $bulk != 'depend' ? $arg : '';
        $arg = is_array( $arg ) ? $arg : [ true ];
        if( method_exists( $this, $callable ) ) {
          $content = call_user_func_array( array( $this, $callable ), $arg );
        }
      } else {
        $content = ($this)->$callable( 1 );
      }

      if( is_string( $content ) ) {
        $o .=  $content . ' ';
      }

    }

    return trim( $o );

  }



}
