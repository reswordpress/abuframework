<?php

AFW::createSection( [ 'abuWPOption', 'tabOn' ], [
    'id'     => 'colorfields',
    'title'  =>  'Color Fields', 
    'icon'   => 'fas fa-tint',
    'priority'=> 2,
    'fields' => [
      [ 'title' => 'WP Color', 'type' => 'color_picker', 'id' => 'afwpcolor_picker' ],
      [ 'title' => 'AF Color', 'type' => 'color_picker', 'id' => 'afafcolor_picker', 'wp-picker' => false ],
      [ 'title' => 'Link Color with WP color Picker', 'type' => 'link_color', 'id' => 'aflink_color', 'wp-picker' => true ],
      [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false ],
      [ 'title' => 'Gradient', 'type' => 'gradient', 'id' => 'afgradient' ],
      [ 'title' => 'Color Palette', 'type' => 'color-palette', 'id' => 'color_palette', 'palettes' => [ 
        [ 'color' => ['#BCABAE', '#0F0F0F', '#2D2E2E', '#FBFBFB', '#716969'], 'value' => 'first' ],
        [ 'color' => ['#7DA3D9', '#8DB1E3', '#D4F0B6', '#BDF2B9', '#BDF3D2'], 'value' => 'second' ],
        [ 'color' => ['#D2EEA8', '#76A6D7', '#B0F0C3', '#B6EFAC', '#86B3E1'], 'value' => 'third' ]
      ] ],

    ]
]);

//////////////////////
AFW::createSection( 'abuWPOption', [
  'id'     => 'wpcolorfields',
  'parent' => 'colorfields',
  'title'  =>  'WP Color Picker', 
  'icon'   => 'fas fa-crosshairs',
  'fields' => [
    [ 'title' => 'WP Color', 'type' => 'color_picker', 'id' => 'wpcolor_picker' ],
    [ 'title' => 'WP Color without Opacity', 'type' => 'color_picker', 'id' => 'wpcolor_picker_without_opacity', 'options' => [ 'showAlpha' => false ] ],
    [ 'title' => 'WP Color with RGB', 'type' => 'color_picker', 'id' => 'wpcolor_picker_with_rgb', 'value' => 'rgba(19,103,114,0.72)' ],
  ]
]);

//////////////////////
AFW::createSection( 'abuWPOption', [
  'id'     => 'afcolorfields',
  'parent' => 'colorfields',
  'title'  =>  'AF Color Picker', 
  'icon'   => 'fas fa-crosshairs',
  'fields' => [
    [ 'title' => 'AF Color', 'type' => 'color_picker', 'id' => 'afcolor_picker', 'wp-picker' => false ],
    [ 'title' => 'AF Color without Opacity', 'type' => 'color_picker', 'id' => 'cafolor_picker', 'options' => [ 'showAlpha' => false ], 'wp-picker' => false ],
    [ 'title' => 'AF Color with default', 'type' => 'color_picker', 'id' => 'afcolor_picker_with_rgb', 'value' => 'rgba(19,103,114,0.72)', 'wp-picker' => false ],
    [ 'title' => 'AF Color with showRGB', 'type' => 'color_picker', 'id' => 'afcolor_picker_with_showRGB', 'options' => [ 'showRGB' => true ], 'wp-picker' => false ],
    [ 'title' => 'AF Color with showHSL', 'type' => 'color_picker', 'id' => 'afcolor_picker_with_showHSL', 'options' => [ 'showHSL' => true ], 'wp-picker' => false ],
    [ 'title' => 'AF Color with showHEX', 'type' => 'color_picker', 'id' => 'afcolor_picker_with_showHEX', 'options' => [ 'showHEX' => true ], 'wp-picker' => false ],
    [ 'title' => 'AF Color with All', 'type' => 'color_picker', 'id' => 'afcolor_picker_with_all', 'options' => [ 'showRGB' => true, 'showHSL' => true, 'showHEX' => true ], 'wp-picker' => false ],
  ]
]);

//////////////////////
AFW::createSection( 'abuWPOption', [
  'id'     => 'lickcolorfields',
  'parent' => 'colorfields',
  'title'  =>  'Link Color', 
  'icon'   => 'fas fa-link',
  'fields' => [
    [ 'title' => 'Link Color', 'type' => 'link_color', 'id' => 'link_color', 'wp-picker' => false ],
    [ 'title' => 'Link Color with default', 'type' => 'link_color', 'id' => 'link_color_with_default', 'value' => [ 'color' => 'rgba(19,103,114,0.72)', 'hover' => 'rgba(17, 39, 136, 0.71)' ], 'wp-picker' => false ],
    [ 'title' => 'Link Color with Some Fields', 'type' => 'link_color', 'id' => 'link_color_somefields', 'color' => true, 'hover' => true, 'visited' => true, ],
    [ 'title' => 'Link Color All', 'type' => 'link_color', 'id' => 'link_color_all', 'wp-picker' => false, 'color' => true, 'hover' => true, 'active'  => true, 'focus' => true, 'visited' => true, ],
    [ 'title' => 'Link Color All with WP Picker', 'type' => 'link_color', 'id' => 'link_color_all_with_wp', 'wp-picker' => true, 'color' => true, 'hover' => true, 'active'  => true, 'focus' => true, 'visited' => true, ],

  ]
]);

//////////////////////
AFW::createSection( 'abuWPOption', [
  'id'     => 'gradientfields',
  'parent' => 'colorfields',
  'title'  =>  'Gradient', 
  'icon'   => 'fas fa-adjust',
  'fields' => [
    [ 'title' => 'Gradient', 'type' => 'gradient', 'id' => 'gradient' ],
    [ 'title' => 'Gradient with default', 'type' => 'gradient', 'id' => 'gradient_with_default', 'default' => [ 'from' => '#dd3333', 'to' => '#eeee22' ] ],
  ]
]);

//////////////////////
AFW::createSection( 'abuWPOption', [
  'id'     => 'colorpalettefields',
  'parent' => 'colorfields',
  'title'  =>  'Color Palette', 
  'icon'   => 'fas fa-barcode',
  'fields' => [

    [ 'title' => 'Color Palette', 'type' => 'color-palette', 'id' => 'color_palette', 'palettes' => [ 
      [ 'color' => ['#BCABAE', '#0F0F0F', '#2D2E2E', '#FBFBFB', '#716969'], 'value' => 'first' ],
      [ 'color' => ['#7DA3D9', '#8DB1E3', '#D4F0B6', '#BDF2B9', '#BDF3D2'], 'value' => 'second' ],
      [ 'color' => ['#D2EEA8', '#76A6D7', '#B0F0C3', '#B6EFAC', '#86B3E1'], 'value' => 'third' ],
    ] ],
    [ 'title' => 'Color Palette with default', 'value' => 'second', 'type' => 'color-palette', 'id' => 'color_palette_with_default', 'palettes' => [ 
      [ 'color' => ['#BCABAE', '#0F0F0F', '#2D2E2E', '#FBFBFB', '#716969'], 'value' => 'first' ],
      [ 'color' => ['#7DA3D9', '#8DB1E3', '#D4F0B6', '#BDF2B9', '#BDF3D2'], 'value' => 'second' ],
      [ 'color' => ['#D2EEA8', '#76A6D7', '#B0F0C3','#B6EFAC', '#86B3E1'], 'value' => 'third' ]
    ] ],

  ]
]);


?>