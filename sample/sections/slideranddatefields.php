<?php

// Design Fields
AFW::createSection( 'abuWPOption', [
  'id'     => 'slideranddatefields',
  'title'  =>  'Slider & Date Fields', 
  'icon'   => 'fas fa-sliders-h',
  'priority'=> 8,
  'fields' => [
    [ 'title' => 'Slider', 'type' => 'slider', 'id' => 'simple_slider' ],
    [ 'title' => 'Range Slider', 'type' => 'range-slider', 'id' => 'simplerange_slider' ],
    [ 'title' => 'Date Picker', 'type' => 'date-picker', 'id' => 'simple_date' ],
    [ 'title' => 'Range Date Picker', 'type' => 'range-date-picker', 'id' => 'simple-_rang_date' ],
  ]
]);
  


// Sliders Fields section
AFW::createSection( 'abuWPOption', [
  'id'     => 'sliderfields',
  'parent' => 'slideranddatefields',
  'title'  =>  'Sliders', 
  'icon'   => 'fab fa-slack-hash',
  'fields' => [
    [ 'title' => 'Slider', 'type' => 'slider', 'id' => 'simple_slider1' ],
    [ 'title' => 'Slider with default', 'type' => 'slider', 'id' => 'slider_with_default', 'default' => 50 ],
    [ 'title' => 'Slider with step(10)', 'type' => 'slider', 'id' => 'slider_with_step', 'step' => 10 ],
    [ 'title' => 'Slider MIN,MAX', 'type' => 'slider', 'id' => 'slider_minmax', 'min' => 40, 'max' => 80 ],
    [ 'title' => 'Slider MIN,MAX with default', 'min' => 40, 'max' => 80,  'type' => 'slider', 'id' => 'slider_minmax_with_default', 'default' => 50 ],
    [ 'title' => 'Slider', 'type' => 'slider', 'id' => 'slider_with_depen', 'desc' => 'Slide upto 50' ],
    [ 'title' => 'Slider', 'type' => 'slider', 'id' => 'slider_with_depen_show', 'depend' => [ 'slider_with_depen', '>=', 50 ] ],
  ]
]);


// Range-Sliders Fields section
AFW::createSection( 'abuWPOption', [
  'id'     => 'range-sliderfields',
  'parent' => 'slideranddatefields',
  'title'  =>  'Range Sliders', 
  'icon'   => 'fab fa-slack',
  'fields' => [
    [ 'title' => 'Range Slider', 'type' => 'range_slider', 'id' => 'simplerangeslider1' ],
    [ 'title' => 'Range Slider with default', 'type' => 'range_slider', 'id' => 'rangeslider_with_default', 'default' => [ 'min' => 30, 'max' => 70  ] ],
    [ 'title' => 'Range Slider with step(10)', 'type' => 'range_slider', 'id' => 'rangeslider_with_step', 'step' => 10 ],
    [ 'title' => 'Range Slider MIN,MAX', 'type' => 'range_slider', 'id' => 'rangeslider_minmax', 'min' => 40, 'max' => 80 ],
    [ 'title' => 'Range Slider MIN,MAX with default', 'min' => 40, 'max' => 80,  'type' => 'range_slider', 'id' => 'rangeslider_minmax_with_default', 'default' => [ 'min' => 60, 'max' => 70  ] ],
  ]
]);

// return;
// Range-Sliders Fields section
AFW::createSection( 'abuWPOption', [
  'id'     => 'datefields',
  'parent' => 'slideranddatefields',
  'title'  =>  'Dates', 
  'icon'   => 'far fa-calendar-alt',
  'fields' => [
    [ 'title' => 'Date Picker', 'type' => 'date-picker', 'id' => 'simple_date1' ],
    [ 'title' => 'Date Picker with Default', 'type' => 'date-picker', 'id' => 'date_with_default', 'default' => 'January 22, 2018', 'desc' => 'Default Date Format is: "mm/dd/yy".' ],
    [ 'title' => 'Range Date Picker', 'type' => 'range-date-picker', 'id' => 'simple_rang_date' ],
    [ 'title' => 'Range Date Picker', 'type' => 'range-date-picker', 'id' => 'simple_rang_date_with_default', 'default' => [
      'min' => 'January 22, 2016',
      'max' => 'January 22, 2019'
    ] ],
    [ 'title' => 'Range Date Picker', 'type' => 'range-date-picker', 'id' => 'simple_rang_date_custom_text', 'min_text' => 'Start', 'max_text' => 'End' ],
  ]
]);
