<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Button-Group Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_button_group extends abuFrameworkFields {

  private $extra_fields = [
    'options'     => null,
    'multiple'    => false,
    'size' => 'small', // small, medium , large
    'query_args'  => [
      'order'    => 'title',
      'orderby'  => 'name',
    ],
  ];

  private function abuCheckInput( $title = '', $value = '', $checked = false, $multiple = false ) {

    $o  = '<label class="abu-group-button"><div class="abu-group-button-inner"><input type="'. ( $this->extra['multiple'] ? 'checkbox' : 'radio' ) .'" ';
    $o .=  $this->name_tattv( 1, ( $multiple ? '[]' : '' ) );
    $o .=  ' value="' . $value . '" ' . ( $checked ? 'checked ' : '' ) . $this->bulk_tattv(['allowed' => [ 'depend', 'attr', 'class'] ])  . '>' ;
    $o .=  '<label>' . $title . '</label></div></label>';
    return $o;

  }

  public function __construct( $f, $v = '', $id = '') {
    parent::__construct( $f, $v, $this->extra_fields, $id );
  }

  public function render_field() {

    $f       = $this->f;
    $values  = $this->value_tattv();
    $values  = is_array( $values ) ? $values : [ $values ];
    $options = abu_ekey( 'options', $this->extra, false );
    $multiple= boolval( $f['multiple'] );

    $o = '<div class="abu-buttongroup-wrapper abu-' . esc_attr( $this->extra['size'] ) . '" data-abu-icon="hide" >';
    
      $o .= '<fieldset>';
        if( $options !== false && is_array( $options ) ) {
            foreach ($options as $value => $title) {
              $o .= $this->abuCheckInput( $title, $value, in_array( $value, $values ), true, $multiple);
            }
        } else if( is_string( $options ) ) {

           // Looping throw wp core data
          $core_data = $this->core_data( $options, $f['query_args'] );
          foreach ($core_data as $value => $title) {
            $o .= $this->abuCheckInput( $title, $value, in_array( $value, $values ), $multiple );
          }

        } else {
          $o .= __( 'There is no options', 'AbuFramework' );
        }
      $o .= '</fieldset>';

    $o .= '</div>';
    
    return $this->createField( $o, $multiple );

  }


}
