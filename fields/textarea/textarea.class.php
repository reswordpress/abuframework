<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Textarea Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_textarea extends abuFrameworkFields {

  private $extra_fields = [
    'rows'  => '5' ,
    'cols'  => '20',
    'placeholder' => ''
  ];


  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, $this->extra_fields, $_id );
  }

  public function render_field(){

    $o = '<div class="abu-textarea-wrapper">';
        $o .= '<textarea ' .  $this->bulk_tattv( [ 'disallowed' => [ 'type', 'value' ]], ['attr'=>[[ 'cols' => $this->extra['cols'], 'rows' => $this->extra['rows'] ]]] ) . ' >' . $this->value_tattv() . '</textarea>';
    $o .= '</div>';

    return $this->createField( $o );

  }


}
