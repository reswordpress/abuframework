<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Heading Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_heading extends abuFrameworkFields {

  private $extra_fields = [
    'content'   => '',
    'label'     => ''
  ];

  public function __construct( $f, $v = '') {
    parent::__construct( $f, $v, $this->extra_fields );
  }

  public function render_field(){

    $title = ! empty( $this->value_tattv() ) ? $this->value_tattv() : '';
    $title =  abu_ekey('title', $this->f, '' );
    $title =  empty( $title ) ? $this->extra['label'] : $title;
    $title =  empty( $title ) ? $this->extra['content'] : $title;
    $this->f['title'] = '';

    $o = '<h1 '.$this->class_tattv( 1 ) . $this->attr_tattv().'>' . esc_html( $title ) . '</h1>';

    return $this->createField( $o, false, [], [] );

  }


}
