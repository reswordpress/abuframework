<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Content Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_content extends abuFrameworkFields {

  public function __construct( $f, $v = '', $name = '', $place = '' ) {
    parent::__construct( $f, $v, $this->extra_fields, $name, $place );
  }

  public function render_field() {

    return $this->createField( '<div class="abu-content-wrapper">' . abu_ekey( 'content', $this->f, '' ) . '</div>');

  }


}
