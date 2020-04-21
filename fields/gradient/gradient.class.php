<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Gradient field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_gradient extends abuFrameworkFields {

  private $extra_fields = [
    'add_botton'=> true,
    'wp-picker' => true,
    'add_links' => []
  ];

  public function __construct( $f, $v = '', $name = '', $place = '' ) {
    parent::__construct( $f, $v,  $this->extra_fields,  $name, $place );
  }

  public function render_field() {

    $values = $this->value_tattv();
    $f     = $this->f;
    $adding_grafients = [ ['title' => 'From'], [ 'title' => 'To' ] ];

    $o = '<div class="abu-gradient-wrapper ' . ( $this->extra['wp-picker'] ? '' : 'abu-a-color-picker' ) . '">';
        foreach( $adding_grafients as $adding_grafient ) {
            $gra_id = abu_secid($adding_grafient['title']);
            $adding_grafient['name'] = abu_field_name( $gra_id , $this->name_tattv() );
            $adding_grafient['id']   = $f['id'] . '_' . $gra_id;
            $adding_grafient['type'] = 'color-picker';
            $o .= add_abu_tattv( $adding_grafient, abu_ekey( $gra_id, $values, '#5b5b5b' ) );
        }
    $o .= '</div>';

    return $this->createField( $o, false, [
      'element-class' => 'abu-field-wp-color-picker'
    ]);

  }


}
