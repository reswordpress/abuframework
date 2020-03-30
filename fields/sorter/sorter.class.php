<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Sorter Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_sorter extends abuFrameworkFields {

  private $extra_fields = [
    'sorters' => []
  ];

  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, $this->extra_fields, $_id );
  }

  public function render_field(){

    $values = $this->value_tattv();

    $o = '<div class="abu-sorters-wrapper abu-sorters" abu-sorter-id="' . esc_attr( $this->name_tattv() ) . '">';

      foreach ( $this->extra['sorters'] as $key => $sorter ) {

        $sorterid   = abu_ekey( 'id', $sorter, '' );
        $isdisable = abu_ekey( 'disabled', $sorter, false ) ? ' abu-sorter-disabled' : '';
        $devider   = ( $key % 3 === 0 || $key === 0 );

          $o .= '<div class="abu-sorter">';
            $o .= '<h2>' . esc_html( abu_ekey( 'title', $sorter, '' ) ) . '</h2>';
            $o .= '<ul id="' . esc_attr( 'sorter-list-' . $key ) . '" class="sorter-list abu-sorter-list ' . $isdisable . '" abu-name="' .  esc_attr( $sorterid ) . '">';

              if( $values != '' ) {

                if( abu_iekey( $sorterid, $values ) && is_array( $values[ $sorterid ] ) ) {
                  foreach ( $values[ $sorterid ] as $sortervalue => $sortertitle ) {
                    $o .= '<li id="' . $sortervalue . '">';
                    $o .= '<input type="hidden" name="' . esc_attr( $this->name_tattv() . '[' . $sorterid . '][' . $sortervalue . ']' ) . '" ' . abu_attr( 'value', $sortertitle ) . ' />';
                    $o .= '<label>' . esc_html( $sortertitle ) . '</label>';
                    $o .= '</li>';
                  }
                }

              } else {

                if( abu_iekey( 'list', $sorter ) && is_array( $sorter['list'] ) ) {
                  foreach ( $sorter['list'] as $sortervalue => $sortertitle ) {
                    $o .= '<li id="' . $sortervalue . '">';
                    $o .= '<input type="hidden" name="' . esc_attr( $this->name_tattv() . '[' . $sorterid . '][' . $sortervalue . ']' ) . '" ' . abu_attr( 'value', $sortertitle ) . ' />';
                    $o .= '<label>' . esc_html( $sortertitle ) . '</label>';
                    $o .= '</li>';
                  }
                }

              }

            $o .= '</ul>';
          $o .= '</div>';

      }

    $o .= '</div>';

    return $this->createField( $o );

  }


}
