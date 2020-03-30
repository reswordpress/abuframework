<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Nestables Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_nestables extends abuFrameworkFields {

  public $keys = 0;
  
  public function __construct( $f, $v = '', $name = '', $place = '' ) {
    parent::__construct( $f, $v, [ 'before_senitize' => 'abu_sanitize_nestables' ], $name, $place );
  }

  public function render_field() {

    $f     = abu_field_extra($this->f,[
      'add_button'   => __( 'Add New', 'AbuFramework' ),
      'remove_all'   => __( 'Remove All', 'AbuFramework' ),
      'list_adding'  => true,
      'dialog_title' => __( 'Add Nestable', 'AbuFramework' ),
    ]);
    $id = $this->id_tattv();
    $value = $this->value_tattv();
    if( ! is_null( $value ) ) $value = is_array( $value ) ? $value : [];
    $name  = $this->name_tattv();
    $serialized = [];
    $all_nestables = is_array( $f['nestables'] ) ? $this->get_nestables($f['nestables']) : [];
    $list_nestables = [];
    if( ! empty($value) ) {
      // if( isset( $value['serialized'] ) ) {
      //   $value = abu_sanitize_nestables( $value );
      // } 
      $list_nestables = $this->set_nestables( $value, $all_nestables );
    } elseif( is_null( $value ) ) {
      $list_nestables = [];
    } else {
      $list_nestables = $f['nestables'];
    }

    $lists = $this->render_lists( $list_nestables, $f, $name . '[values]' );
    
    $o = '<div class="abu-nestables-wrapper" abu-nestable-name="' . esc_attr( $name ) . '" nestable-id="' . esc_attr( $id ) . '" total-list="' . esc_attr( $this->keys ) . '">';
      $o .= '<div class="dd">';
        $o .= $lists;
        $o .= '<div class="dd-empty"></div>';
      $o .= '</div>';

      if( $f['list_adding'] ) {

        $o .= '<!-- The Modal -->';
        $o .= '<div id="abu-nesable-box-' . esc_attr( $id ) . '" class="abu-model" title="' . esc_attr( $f['dialog_title'] ) . '">';
          $o .= add_abu_sub_tattv( [ 'type' => 'text', 'id' => 'nesable_title_' . $id, 'class' => 'abu_nesable_title', 'title' => __( 'Title', 'AbuFramework' ) ], '', '' );
          $o .= add_abu_sub_tattv( [ 'type' => 'text', 'id' => 'nesable_id_' . $id, 'class' => 'abu_nesable_id', 'title' => __( 'ID', 'AbuFramework' ), 'subtitle' => __( 'Must be Uniuqe', 'AbuFramework'), 'after' => [
            'type' => 'error'
            ] 
          ]);
        $o .= '</div>';

        $o .= '<div class="abu-adable-item" hidden>';
          $o .= '<li class="dd-item dd3-item" data-id="' . esc_attr( $id ) . '" nestable-name="' . esc_attr( $name ) . '">';
              $o .= '<div class="dd-handle dd3-handle">Drag</div>';
              $o .= '<div class="dd3-content">' . esc_html( $f['title'] ) ;
                $o .= isset( $f['fields'] ) ? '<span class="dashicons dashicons-arrow-down abu-edit-contents "></span>' : '';
              $o .= '</div>';
              $o .= '<div class="dd-contents ">';
                $o .= add_abu_sub_tattv( [ 'title' => __( 'Nestable Title', 'AbuFramework' ), 'type' => 'text', 'id' => $id . '_title', 'class' => 'abu-nestable-title' ], 'title', 'empty' , 'NaO' );
                if( isset( $f['fields'] ) ) {
                  foreach( $f['fields'] as $field ) {
                    $field['attr'] = [
                      'data-temid' => $field['id']
                    ];
                    $o .= add_abu_sub_tattv( $field, '', 'abu_nestable_quene' , '' );
                  }
                }
              $o .= '</div>';
          $o .= '</li>';
        $o .= '</div>';

        $o .= '<a class="button button-primary abu-add-nesables" data-model-id="' . esc_attr( $id )  . '" href="#">' . ( wp_kses( $f['add_button'] , [ 'span' => ['class' => []], 'i' => ['class' => []] ] ) ) . '</a>';
      
      }
      $o .= '<a class="button abu-button abu-removeall-nesables"  href="#">' . esc_html( $f['remove_all'] ) . '</a>';
      $o .= '<input name="' . esc_attr( $name ) . '[serialized]" style="width:100%;height:100px" class="abu-nestable-serialized" type="text" value="' . esc_html( wp_json_encode( $serialized ) ) . '">';
    $o .= '</div>';

    return $this->createField( $o );

  }

  private function render_lists( $lest, $f, $parent = '' ) {

    $this->keys = 0;
    $o = '<ol class="dd-list" abu-list-name="' . esc_attr( $parent ). '">';
    
      if( ! empty($lest) ) {
        foreach ($lest as $key => $nestable) {
  
          $title = abu_ekey( 'title', $nestable, __( 'Nestable' , 'AbuFramework' ) . ' ' . $this->keys );
          $nestable_id = abu_ekey( 'id', $nestable, $title );
          $nestable_name = $parent . '[' . $nestable_id . ']';
          
          $o .= '<li class="dd-item dd3-item" data-id="' . esc_attr( $nestable_id ) . '" data-title="' . esc_attr( $title ) . '" nestable-name="' . esc_attr( $nestable_name ) . '">';
              $o .= '<div class="dd-handle dd3-handle">Drag</div>';
              $o .= '<div class="dd3-content"><span class="dd-nestabel-title">' . esc_html( $title ) . '</span>' ;
                $o .= '<div class="dd3-control">';
                  $o .= '<span class="dashicons dashicons-trash abu-remove-nestable"></span>';
                  $o .= '<span class="abu-content-divider">|</span>';
                  $o .= isset( $f['fields'] ) ? '<span class="dashicons dashicons-arrow-down abu-edit-contents "></span>' : '';
                $o .= '</div>';
              $o .= '</div>';
              $o .= '<div class="dd-contents ">';
                $o .= add_abu_sub_tattv( [ 'title' => __( 'Nestable Title', 'AbuFramework' ), 'type' => 'text', 'id' => $nestable_id . '_title', 'class' => 'abu-nestable-title' ], $title, 'empty' , 'NaO' );
                if( isset( $f['fields'] ) ) {
                  foreach( $f['fields'] as $field ) {
                    $field_name  =  $nestable_name;
                    $nestable['values'] = isset($nestable['values']) ? $nestable['values'] : [];
                    $field_value = abu_ekey( $field['id'], $nestable, '' );
                    $o .= add_abu_sub_tattv( $field, $field_value, $field_name , 'NaO' );
                  }
                }
              $o .= '</div>';
              if( isset( $nestable['children'] ) ) { 
                $o .= $this->render_lists( $nestable['children'], $f, $parent  );
              }
          $o .= '</li>';
          $this->keys++;
  
        }
      }

    $o .= '</ol>';
    
    return $o;

  }

  private function get_nestables( $n ) {

    $o = [];
    foreach( $n as $key => $nes ) {

      $title = abu_ekey( 'title', $nes, __('Nestable', 'AbuFramework') . ' ' . $this->keys );
      $nestable_id = abu_ekey( 'id', $nes, $title );
      if( isset( $nes['children'] ) ) {
        $o = array_merge( $o, $this->get_nestables( $nes['children'] ) );
      }
      unset( $nes['children'] );
      $o[ $nestable_id ] = $nes;

    }
    
    $this->keys = 0;
    return $o;

  }

  private function set_nestables( $v, $a ) {
  
    $o = [];
    $key = 0;
    foreach( $v as $name => $value ) {

      $o[$key]['id']     = $name;
      $o[$key]['title']  = $value['title'];
      $o[$key]['values'] = abu_ekey( 'values', $value, [] );
      if( isset( $value['children'] ) ) {
        $o[$key]['children'] = $this->set_nestables( $value['children'], $a );
      }
      $key++;

    }

    return $o;

  }

  public function wp_enqueue() {
    if( ! wp_script_is('jquery-ui-dialog') ) {
      wp_enqueue_script( 'jquery-ui-dialog' );
    }
    wp_localize_script( 'jquery-ui-dialog', 'abu_nestables_' . $this->id_tattv(),
        array( 
          'diolog_close' => __( 'Close', 'AbuFramework' )
        )
    );
  }

}
