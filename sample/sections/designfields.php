<?php

// Design Fields
AFW::createSection( 'abuWPOption', [
  'id'     => 'designfields',
  'title'  =>  'Design Fields', 
  'icon'   => 'far fa-object-group',
  'priority'=> 3,
  'fields' => [
    [ 'title' => 'Animate', 'type' => 'animate', 'id' => 'animate', ],
    [ 'title'=> 'Border', 'subtitle' => 'subtitle', 'type' => 'border', 'id' => 'border' ],
    [ 'title' => 'Dimensions', 'type' => 'dimensions', 'id' => 'dimensions'  ],
    [ 'title' => 'Spacing', 'type' => 'spacing', 'id' => 'spacing', ],
  ]
]);

  // Text Fields section
  AFW::createSection( 'abuWPOption', [
    'id'     => 'animatefields',
    'parent' => 'designfields',
    'title'  =>  'Animate', 
    'fields' => [
      [ 'title' => 'Animate', 'type' => 'animate', 'id' => 'animate' ],
      [ 'title' => 'Animate with Default', 'type' => 'animate', 'id' => 'animate_with_deafult', 'default' => [ 'effect' => 'shake', 'speed' => 'delay-1s' ] ],
      [ 'title' => 'Animate without Speed', 'type' => 'animate', 'id' => 'animate_without_speed', 'speed' => false  ],
    ]
  ]);
  
  // Text Fields section
  AFW::createSection( 'abuWPOption', [
    'id'     => 'borderfields',
    'parent' => 'designfields',
    'title'  =>  'Borders', 
    'fields' => [
      [ 'title' => 'Border', 'subtitle' => 'subtitle', 'type' => 'border', 'id' => 'simpleborder' ],
      [ 'title' => 'Border with default', 'type' => 'border', 'id' => 'border_with_default', 'default' => [ 'top' => 1, 'left' => 2, 'bottom' => 3, 'right' => 4, 'style' => 'Dotted', 'unit' => '%', 'color' => '#1e73be' ],],
      [ 'title' => 'Border with placeholder', 'type' => 'border', 'id' => 'border_with_placeholder', 'placeholders' => [ 'top' => 'pot', 'left' => 'tfel' ] ],
      [ 'title' => 'Border with help', 'type' => 'border', 'subtitle' => 'The field of subtitle text.', 'id' => 'border_with_help', 'help' => 'The field of help text.' ],
      [ 'title' => 'Border with top and bottom only', 'type' => 'border', 'id' => 'topbottomborder', 'left' => false, 'right' => false ],
      [ 'title' => 'Border with left and right only ', 'type' => 'border', 'id' => 'leftrightborder', 'top' => false, 'bottom' => false ],
      [ 'title' => 'Border with all directions ', 'type' => 'border', 'id' => 'alldirectionsborder', 'all' => true ],
      [ 'title' => 'Border without WP-Color Picker', 'type' => 'border', 'id' => 'wpcolordirectionsborder', 'wp-picker' => false ],
      [ 'title' => 'Border without Styles', 'type' => 'border', 'id' => 'styleborder', 'style' => false ],
      [ 'title' => 'Border without Units', 'type' => 'border', 'id' => 'unitborder', 'unit' => false ],
    ]
  ]);
  
  // Text Fields section
  AFW::createSection( 'abuWPOption', [
    'id'     => 'dimensionsfields',
    'parent' => 'designfields',
    'title'  =>  'Dimensions', 
    'fields' => [
      [ 'title' => 'Dimensions', 'subtitle' => 'subtitle', 'type' => 'dimensions', 'id' => 'simpledimensions' ],
      [ 'title' => 'Dimensions with default', 'type' => 'dimensions', 'id' => 'dimensions_with_default', 'default' => [ 'height' => 356, 'width' => 123, 'unit' => '%' ] ],
      [ 'title' => 'Dimensions with placeholder', 'type' => 'dimensions', 'id' => 'dimensions_with_placeholder', 'placeholders' => [ 'height' => 'hahah', 'width' => 'wawa' ] ],
      [ 'title' => 'Dimensions with help', 'type' => 'dimensions', 'subtitle' => 'The field of subtitle text.', 'id' => 'dimensions_with_help', 'help' => 'The field of help text.' ],
      
      [ 
        'id'    => 'unitdimensions',
        'unit'  => false,
        'type'  => 'dimensions',
        'title' => 'Dimensions without Units',
        'width_icon' => 'Width',
        'height_icon'=> 'Height',
      ],
      
      [ 'title' => 'Dimensions Height Only', 'type' => 'dimensions', 'id' => 'dimensions_height_only', 'unit' => false, 'width' => false ],
      [ 'title' => 'Dimensions width Only', 'type' => 'dimensions', 'id' => 'leftrightborder', 'unit' => false, 'height' => false ],
      [ 'type' => 'dimensions', 'id' => 'dimensionsunitonly', 'width' => false, 'height' => false, 'title' => 'Dimensions Unit Only', 'units' => '%' ],
      [ 'type' => 'dimensions', 'id' => 'dimensionscustomunit', 'title' => 'Dimensions Custom Unit', 'units' => ['Rem', 'bla', 'blas' ] ],
    ]
  ]);
  
  
  // Borders Fields section
  AFW::createSection( 'abuWPOption', [
    'id'     => 'spacingfields',
    'parent' => 'designfields',
    'title'  =>  'Spacing', 
    'fields' => [
      [ 'title' => 'Spacing', 'subtitle' => 'subtitle', 'type' => 'spacing', 'id' => 'simplespacing' ],
      [ 'title' => 'Spacing with default', 'type' => 'spacing', 'id' => 'spacing_with_default', 'default' => [ 'top' => 1, 'left' => 2, 'bottom' => 3, 'right' => 4, 'style' => 'Dotted', 'unit' => '%', 'color' => '#1e73be' ],],
      [ 'title' => 'Spacing with placeholder', 'type' => 'spacing', 'id' => 'spacing_with_placeholder', 'placeholders' => [ 'top' => 'pot', 'right' => 'thgir', 'bottom' => 'mottob', 'left' => 'tfel' ] ],
      [ 'title' => 'Spacing with help', 'type' => 'spacing', 'subtitle' => 'The field of subtitle text.', 'id' => 'spacing_with_help', 'help' => 'The field of help text.' ],
      [ 'title' => 'Spacing with top and bottom only', 'type' => 'spacing', 'id' => 'topbottomspacing', 'left' => false, 'right' => false ],
      [ 'title' => 'Spacing with left and right only ', 'type' => 'spacing', 'id' => 'leftrightspacing', 'top' => false, 'bottom' => false ],
      [ 'title' => 'Spacing with all directions ', 'type' => 'spacing', 'id' => 'alldirectionsspacing', 'all' => true ],
      [ 'title' => 'Spacing without Units', 'type' => 'spacing', 'id' => 'unitspacing', 'unit' => false ],
    ]
  ]);
  