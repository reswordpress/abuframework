<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Radio Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */
class abuFrameworkField_radio extends abuFrameworkFields {

  private $extra_fields = [
    'options'     => null,
    'query_args'  => [
      'order'    => 'title',
      'orderby'  => 'name',
    ],
    'inline'      => true,
    'disabled'    => []
  ];


  private function abuRadioInput( $title = '', $value = '', $checked = false, $multiple = false ) {
    $d = ( in_array( $value, $this->disabled ) ? ' disabled="disabled" ' : '' );
    return  '<li' . $d .'>' . '<label><input type="radio" ' .  ' value="' . esc_attr( $value ) . '" ' . $this->bulk_tattv([ 'disallowed' => ['type', 'value'] ], [ 'id' => [ 1, "_$value" ] ]) . ( $checked ? ' checked="checked" ' : '' ) . $d . '>'  . $title . '</label></li>';

  }


  public function __construct( $f, $v = '', $id = '') {
    parent::__construct( $f, $v, $this->extra_fields, $id );

  }

  public function render_field(){

    $values = $this->value_tattv();
    $values = $values ? $values : false;
    $this->disabled = $disabled = is_array( $this->f['disabled'] ) ? $this->f['disabled'] : []; 
    $o = '<div class="abu-checkbox-wrapper">';
      $o .= '<ul class="' . ( $this->extra['inline'] ? 'horizontal' : 'vertical' ) . '">';

        if( is_array( $this->extra['options'] ) ) {

          // Looping throw every options
          if( count( $this->f['options'] ) && ! empty( $this->f['options'] ) ) {
            foreach ($this->f['options'] as $value => $title) {
              $o .= $this->abuRadioInput( $title, $value, ( $value == $values ) , true );
            }
          } else {
            $o .= __( 'There is no options', 'AbuFramework' );
          }

        } else if ( is_string($this->extra['options']) ) {

          // Looping throw wp core data
          $core_data = $this->core_data( $this->extra['options'], $this->extra['query_args'] );
          if( count( $core_data ) && ! empty( $core_data ) ) { 
            foreach ($core_data as $value => $title) {
              $o .= $this->abuRadioInput( $title, $value, ( $value == $values ) , true );
            }
          } else {
            $o .= __( 'There is no options', 'AbuFramework' );
          }

        } else {
          $o .= __( 'There is no options', 'AbuFramework' );
        }

      $o .= '</ul>';
    $o .= '</div>';

    return $this->createField( $o );

  }


}
