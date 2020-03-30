<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Range-Date-Picker Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_range_date_picker extends abuFrameworkFields {


  public function __construct( $f, $v = '', $_id = '' ) {
    parent::__construct( $f, $v, [], $_id );
  }

  public function render_field() {

    $f = abu_field_extra( $this->f, [
      'min_text' => '',
      'max_text' => '',
      'min_placeholder' => '',
      'max_placeholder' => '',
      'placeholder'  => '',
      'date-options' => [
        'showWeek' => true,
        'isRTL'    => is_rtl()
      ]
    ]);

    $min_text = empty( $this->extra['min_text'] ) ? __( 'From', 'AbuFramework' ) : $this->extra['min_text'];
    $max_text = empty( $this->extra['max_text'] ) ? __( 'To', 'AbuFramework' ) : $this->extra['max_text'];

    $values = $this->value_tattv();
    $values =  ! is_array( $values ) ? [] : $values ;
    $values = abu_field_extra( $values, [
      'min' => '',
      'max' => ''
    ]);

    $e = $this->f;

    $max_attr = abu_ekey( 'max', $values, false ) ? 'maxDate="' . esc_attr( $values['max'] ) . '"' : '';
    $min_attr = abu_ekey( 'min', $values, false ) ? 'minDate="' . esc_attr( $values['min'] ) . '"' : '';

    $o = '<div class="abu-datepicker-wrapper">';
      $o .= '<label><span class="abu-date-from">' . esc_html( $min_text ) . '</span><input ';
      $o .= $this->bulk_tattv([], [
          'type' => [ 1, '', 'text' ],
          'name' => [ 1, '[min]' ],
          'attr' => [ [
            'abu-type' => 'date-picker',
            'abu-date' => 'from',
            $max_attr  => 'key-only'
          ] ],
          'depend' => [ $this->id_tattv() . '_min' ],
          'class'  => [ 1 ],
          'value'  => [ 1, '', $values['min'] ],
          'placeholder' => [ 1, '', abu_ekey( 'min_placeholder', $e, abu_ekey( 'placeholder', $e, '') ) ]
      ]);
      $o .= '></label><label><span class="abu-date-to">' . esc_html( $max_text ) . '</span><input type="text" ' . $this->name_tattv( true, '[max]' )
         . $this->id_tattv( true, '[max]' ) . $this->bulk_tattv([
           'disallowed' => [ 'id', 'name', 'type' ]
         ],[
           'value' => [ 1, '', $values['max']],
           'placeholder' => [ 1, '', abu_ekey( 'max_placeholder', $e, abu_ekey( 'placeholder', $e, '') ) ]
         ]) . $min_attr .  ' abu-type="date-picker" abu-date="to"></label>';
      $o .= '<div class="abu-date-options" data-date-options="' . esc_attr( json_encode( $f['date-options'] ) ) . '" hidden></div>';
      $o .= '<div class="abu-show-date"></div>';
    $o .= '</div>';

    return $this->createField( $o );

  }


}
