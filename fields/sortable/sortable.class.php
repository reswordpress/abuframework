<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Sortable Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_sortable extends abuFrameworkFields {

  private $extra_fields = [
    'fields' => []
  ];

  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, $this->extra_fields, $_id );
  }

  private function add_sortable_item( $field, $values, $name, $id ) {
    $o = '<div class="abu-sortable-item"><div class="abu-sortable-content">';
        $o .= add_abu_sub_tattv( $field, $values, $name, 'options', $id );
        $o .= '<div class="abu-clearfix"></div></div>';
    $o .= '<div class="abu-sortable-helper"><i class="fa fa-arrows"></i></div></div>';
    return $o;
  }

  public function render_field(){

    $f         = $this->f;
    $values    = $this->value_tattv();
    $name      = $this->name_tattv();
    $fields    = $f['fields'];
    $sortables = !empty($values) ? $this->sort_arrays( $fields, $values ) : $fields;

    $o = '<div class="abu-sortables-wrapper">';

      foreach ( $sortables as $field ) {
        $o .= $this->add_sortable_item( $field, abu_ekey( $field['id'], $values, '' ), $name, $f['id'] );
      }

    $o .= '</div>';

    return $this->createField( $o );

  }

  public function sort_arrays( $fields, $values ){

    $o = [];
    $values = array_keys($values);

    foreach( $fields as $field ) {
      $i = array_search( $field['id'], $values );
      if( $i === false ) {
        continue;
      }
      $o[$i] = $field;
    }
    ksort($o);

    return $o;

  }


}
