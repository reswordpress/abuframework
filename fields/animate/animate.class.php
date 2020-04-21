<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * Animate Field from AbuFramework
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

class abuFrameworkField_animate extends abuFrameworkFields {

  public function __construct( $f, $v = '', $name = '', $place = '' ) {
    parent::__construct( $f, $v, [], $name, $place );
  }

  public function render_field() {

    $f = $this->f = abu_field_extra( $this->f, [
      'animate' => _x( 'Animate', 'Title for Demo Animation of CSS', 'AbuFramework' ),
      'speed' => [
        'faster'   => __( '500ms Faster', 'AbuFramework' ),
        'fast'     => __( '800ms Fast', 'AbuFramework' ),
        'delay-1s' => __( '1s', 'AbuFramework' ),
        'delay-2s' => __( '2s Slow', 'AbuFramework' ),
        'delay-3s' => __( '3s Slower', 'AbuFramework' ),
        'delay-4s' => __( '4s', 'AbuFramework' ),
        'delay-5s' => __( '5s',   'AbuFramework' )
      ]
    ]);
    $options = apply_filters( 'abu_animate', [
    'Attention Seekers' => [ 
      'bounce' => 'Bounce',
      'flash' => 'Flash',
      'pulse' => 'Pulse',
      'rubberBand' => 'RubberBand',
      'shake' => 'Shake',
      'swing' => 'Swing',
      'tada' => 'Tada',
      'wobble' => 'Wobble',
      'jello' => 'Jello',
      'heartBeat' => 'HeartBeat',
    ],
      'Bouncing Entrances' => [ 
      'bounceIn' => 'BounceIn',
      'bounceInDown' => 'BounceInDown',
      'bounceInLeft' => 'BounceInLeft',
      'bounceInRight' => 'BounceInRight',
      'bounceInUp' => 'BounceInUp',
    ],
      'Bouncing Exits' => [ 
      'bounceOut' => 'BounceOut',
      'bounceOutDown' => 'BounceOutDown',
      'bounceOutLeft' => 'BounceOutLeft',
      'bounceOutRight' => 'BounceOutRight',
      'bounceOutUp' => 'BounceOutUp',
    ],
    'Fading Entrances' => [
      'fadeIn' => 'FadeIn',
      'fadeInDown' => 'FadeInDown',
      'fadeInDownBig' => 'FadeInDownBig',
      'fadeInLeft' => 'FadeInLeft',
      'fadeInLeftBig' => 'FadeInLeftBig',
      'fadeInRight' => 'FadeInRight',
      'fadeInRightBig' => 'FadeInRightBig',
      'fadeInUp' => 'FadeInUp',
      'fadeInUpBig' => 'FadeInUpBig',
    ],
      'Fading Exits' => [ 'fadeOut' => 'FadeOut',
      'fadeOutDown' => 'FadeOutDown',
      'fadeOutDownBig' => 'FadeOutDownBig',
      'fadeOutLeft' => 'FadeOutLeft',
      'fadeOutLeftBig' => 'FadeOutLeftBig',
      'fadeOutRight' => 'FadeOutRight',
      'fadeOutRightBig' => 'FadeOutRightBig',
      'fadeOutUp' => 'FadeOutUp',
      'fadeOutUpBig' => 'FadeOutUpBig',
    ],
    'Flippers' => [ 
      'flip' => 'Flip',
      'flipInX' => 'FlipInX',
      'flipInY' => 'FlipInY',
      'flipOutX' => 'FlipOutX',
      'flipOutY' => 'FlipOutY',
    ],
    'Lightspeed' => [ 
      'lightSpeedIn' => 'LightSpeedIn', 
      'lightSpeedOut' => 'LightSpeedOut', 
    ],
    'Rotating Entrances' => [ 
      'rotateIn' => 'RotateIn',
      'rotateInDownLeft' => 'RotateInDownLeft',
      'rotateInDownRight' => 'RotateInDownRight',
      'rotateInUpLeft' => 'RotateInUpLeft',
      'rotateInUpRight' => 'RotateInUpRight',
    ],
      'Rotating Exits' => [ 'rotateOut' => 'RotateOut',
      'rotateOutDownLeft' => 'RotateOutDownLeft',
      'rotateOutDownRight' => 'RotateOutDownRight',
      'rotateOutUpLeft' => 'RotateOutUpLeft',
      'rotateOutUpRight' => 'RotateOutUpRight',
    ],
    'Sliding Entrances' => [ 
      'slideInUp' => 'SlideInUp',
      'slideInDown' => 'SlideInDown',
      'slideInLeft' => 'SlideInLeft',
      'slideInRight' => 'SlideInRight',
    ],
    'Sliding Exits' => [ 
      'slideOutUp' => 'SlideOutUp',
      'slideOutDown' => 'SlideOutDown',
      'slideOutLeft' => 'SlideOutLeft',
      'slideOutRight' => 'SlideOutRight',
    ],
    'Zoom Entrances' => [ 
      'zoomIn' => 'ZoomIn',
      'zoomInDown' => 'ZoomInDown',
      'zoomInLeft' => 'ZoomInLeft',
      'zoomInRight' => 'ZoomInRight',
      'zoomInUp' => 'ZoomInUp',
    ],
    'Zoom Exits' => [ 
      'zoomOut' => 'ZoomOut',
      'zoomOutDown' => 'ZoomOutDown',
      'zoomOutLeft' => 'ZoomOutLeft',
      'zoomOutRight' => 'ZoomOutRight',
      'zoomOutUp' => 'ZoomOutUp',
    ],
    'Specials' => [ 
      'hinge' => 'Hinge',
      'jackInTheBox' => 'JackInTheBox',
      'rollIn' => 'RollIn',
      'rollOut' => 'RollOut',
    ],
    ]);
    $values = $this->value_tattv();
    $effect = isset( $values['effect'] ) ? $values['effect'] : '';
    $speed = isset( $values['speed'] ) ? $values['speed'] : '';
    $name = $this->name_tattv();

    $o = '<div class="abu-animate-wrapper">';
      
      if( $f['animate'] ) $o .= '<div class="abu-animate-title bounce animated"><h2>' . esc_attr( $f['animate'] ) . '</h2></div>';

      $o .= '<div class="abu-animate-controls">';

        $o .= add_abu_sub_tattv([ 
          'id'      => 'effect',
          'title'   => __( 'Effect', 'AbuFramework' ),
          'type'    => 'select',
          'options' => $options,
          'class'   => 'abu-animate-helper',
          'chosen'  => true,
          'name'    => $name . ( $f['speed'] ? '[effect]' : '' )
        ], ( $f['speed'] ? $effect : $values ) , '', 'NaO', $f['id'] );

        if( $f['speed'] == true ) {
          $o .= add_abu_sub_tattv([ 
            'id'      => 'speed',
            'title'   => __( 'Speed', 'AbuFramework' ),
            'type'    => 'select',
            'options' =>$f['speed'],
            'class' => 'abu-animate-speed',
            'chosen'  => true,
          ], $speed, $name, 'NaO', $f['id'] );
        }

      $o.= '</div>';
      
    $o.= '</div>';
    return $this->createField( $o );

  }


}
