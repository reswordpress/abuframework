<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Column Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_column extends abuFrameworkFields {

  private $extra_fields = [
    'fields' => []
  ];

  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, $this->extra_fields, $_id );
  }

  public function render_field() {

    $f = $this->f;
    $v = $this->value_tattv();

    $o = '<div class="abu-fieldset-wrapper">';

      foreach ($this->extra['fields'] as $field) {

        if( ! abu_iekey( 'id', $field ) ) continue;
        $o .= add_abu_sub_tattv( $field, abu_ekey( $field['id'], $v ), $this->name_tattv(), 'options', $f['id']  );

      }

    $o .= '</div>';

    return $this->createField( $o );

  }


}
