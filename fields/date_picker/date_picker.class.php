<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Date-Picker Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_date_picker extends abuFrameworkFields {


  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, [], $_id );
  }

  public function render_field() {

    $f = abu_field_extra($this->f, [
     'date-options' => [
      'showWeek' => true,
      'isRTL'    => is_rtl()
     ]
    ]);

    $o = '<div class="abu-datepicker-wrapper"><input ';
      $o .= $this->bulk_tattv([], [
                'type' => [ 1, '', 'text' ],
                'id' => [ 1 ],
                'name' => [ 1 ],
                'attr' => [ ['abu-type' => 'date-picker'] ],
                'class' => [ 1 ],
                'value' => [ 1 ],
            ]);
      $o .= '/><div class="abu-date-options" data-date-options="' . esc_attr( json_encode( $f['date-options'] ) ) . '" hidden></div>';
      $o .= '<div class="abu-show-date"></div>';
    $o .= '</div>';

    return $this->createField( $o );

  }


}
