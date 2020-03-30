<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Password Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_password extends abuFrameworkFields {


  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, [
      'username' => true,
      'password' => true,
      'attr'     => [
        'username' => [
          'placeholder' =>  __( 'Username', 'AbuFramework' ),
        ],
        'password' => [
          'placeholder'  => __( 'Password', 'AbuFramework' ),
        ]   
      ],
      'max' => 15
    ], $_id );
  }

  public function render_field() {

    $field = $this->f;
    $field['debug'] = true;
    $values = (array) $this->value_tattv();
    $values = array_merge([
      'username' => '',
      'password' => ''
    ], $values );
    // $placeholder = $field['placeholders'];

    $o = '<div class="abu-password-wrapper">';
      if( $field['username'] ) {
        $o .= '<input type="text" ' . $this->name_tattv( 1, '[username]' ) . $this->bulk_tattv([ 'disallowed' => [ 'type', 'name', 'attr', 'value'] ], [ 'depend' => [ $this->id_tattv( 0, '_username') ], 'id' => [ 1, '_username' ] ]) . $this->value_tattv( 1, '', $values['username'] ) . abu_attr( 'autocomplete', 'username' ) .  ' />';
      }
      if( $field['password'] ) {
        $o .= '<input ' . $this->name_tattv( 1, '[password]' ) . $this->bulk_tattv([ 'disallowed' => [ 'name', 'attr', 'value'] ],[ 'depend' => [ $this->id_tattv( 0, '_password' ) ], 'id' => [ 1, '_password' ] ] ) . 'maxlength="' . esc_attr( $field['max'] ) . '"' . $this->value_tattv( 1, '', $values['password'] ) . abu_attr( 'autocomplete', 'current-password' ) . ' />';
      }
    $o .= '</div>';

    return $this->createField( $o );

  }


}
