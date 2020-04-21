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
    'inline'  => true,
    'disabled'    => []
  ];

  private function abuCheckInput( $title = '', $value = '', $checked = false, $multiple = false ) {
    $d = ( in_array( $value, $this->disabled ) ? ' disabled="disabled" ' : '' );
    return '<li ' . $d . '><label><input ' .
      $this->bulk_tattv(
       [ 'disallowed' => [ 'style', 'required' ]  ],
       [
         'type' => [ 1 ],
         'value' => [ 1, '', $value ],
         'name' => [ 1, ( $multiple ? '[]' : '' ) ],
         'class' => [ 1 ],
         'id' => [ 1, '_' . $value ],
       ]
     ) .  ( $checked ? ' checked="checked" ' : '' ) . $d . '>' . $title.'</li></label>';
  }

  private $values = [];

  public function __construct( $f, $v = '', $id = '') {
    parent::__construct( $f, $v, $this->extra_fields, $id );
    $this->values = array_merge_recursive( $this->values , ( is_array( $this->value_tattv() ) ? $this->value_tattv() : [ $this->value_tattv() ] ) );
  }


  public function render_field(){
    
    $f = $this->f;
    $this->disabled = $disabled = is_array( $f['disabled'] ) ? $f['disabled'] : []; 
    
    $o = '<div class="abu-checkbox-wrapper"><ul class="' . ( $this->extra['inline'] ? 'horizontal' : 'vertical' ) . '">';

      if( isset($this->extra['options']) && is_array( $this->extra['options'] ) && empty( $f['label'] ) ) {

        // Looping throw every options
        foreach ($this->f['options'] as $value => $title) {
          $o .= $this->abuCheckInput( $title, $value, in_array( $value, $this->values ), true );
        }

      } else if ( isset($this->extra['options']) && is_string( $this->extra['options'] ) && empty( $f['label'] ) ) {

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
          $o .= $this->abuCheckInput( $this->extra['label'], 1, $single_value, false );
        } else {
          $o .= __( 'There is no options', 'AbuFramework' );
        }

      }

    $o .= '</ul></div>';

    return $this->createField( $o, true );

  }


}
