<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Checkboxes field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */


class abuFrameworkField_checkbox extends abuFrameworkFields {

  private $extra_fields = [
    'options'     => null,
    'label'       => '',
    'query_args'  => [
      'order'    => 'title',
      'orderby'  => 'date',
    ],
    'horizontal' => true
  ];

  private function abuCheckInput( $title = '', $value = '', $checked = false, $multiple = false ) {
    return '<li><label><input ' .
      $this->bulk_tattv(
       [ 'disallowed' => [ 'style', 'required', 'attr' ]  ],
       [
         'type' => [ 1 ],
         'value' => [ 1, '', $value ],
         'name' => [ 1, ( $multiple ? '[]' : '' ) ],
         'class' => [ 1 ],
         'id' => [ 1, '_' . $value ],
       ]
     ) .  abu_input_attribute_helper( 1, $checked )  . '>' . $title.'</li></label>';
  }

  private $values = [];

  public function __construct( $f, $v = '', $id = '') {
    parent::__construct( $f, $v, $this->extra_fields, $id );
    $this->values = array_merge_recursive( $this->values , ( is_array( $this->value_tattv() ) ? $this->value_tattv() : [ $this->value_tattv() ] ) );
  }


  public function render_field(){
    
    $o = '<div class="abu-checkbox-wrapper"><ul class="' . ( $this->extra['horizontal'] ? 'horizontal' : 'vertical' ) . '">';

      if( isset($this->extra['options']) && is_array( $this->extra['options'] ) ) {

        // Looping throw every options
        foreach ($this->f['options'] as $value => $title) {
          $o .= $this->abuCheckInput( $title, $value, in_array( $value, $this->values ), true );
        }

      } else if ( isset($this->extra['options']) && is_string( $this->extra['options'] ) ) {

         // Looping throw wp core data
         $core_data = $this->core_data( $this->extra['options'], $this->extra['query_args'] );
         if( is_array( $core_data ) && ! empty( $core_data ) ) {
           foreach ($core_data as $value => $title) {
             $o .= $this->abuCheckInput( $title, $value, in_array( $value, $this->values ), true );
           }
         } else {
           $o .= __( 'There is no options', 'AbuFramework' );
         }

      } else {

        // else single check box
        if( isset( $this->extra['label'] ) && ! empty( $this->extra['label'] ) ) {
          $single_value =  ( ! is_array( $this->value_tattv() ) ) ? abuBoolean( $this->value_tattv() ) : false;
          $o .= $this->abuCheckInput( $this->extra['label'], $single_value, false );
        } else {
          $o .= __( 'There is no options', 'AbuFramework' );
        }

      }

    $o .= '</ul></div>';

    return $this->createField( $o, true );

  }


}
