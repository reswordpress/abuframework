<?php

// Additional Fields
AFW::createSection( 'abuWPOption', [
  'id'     => 'additionalfields',
  'title'  => 'Additional Fields',
  'icon'   => 'fab fa-gg',
  'priority'=> 15,
  'fields' => [
    [ 'type' => 'spinner', 'id' => 'spinners', 'title' => 'Spinner' ],
    [ 'type' => 'icon', 'id' => 'icons', 'title' => 'Icon' ],
    [ 'type' => 'toggle', 'id' => 'toggle', 'title' => 'Toggle' ],
    [ 'title' => 'Sorter' , 'type' => 'sorter', 'id' => 'simple_sorter', 'sorters' => [
        [ 'title' => 'Active Color', 'id' => 'active_colors', 'list' => [ 'green' => 'Green', 'blue' => 'Blue', 'yellow' => 'Yellow', 'white' => 'White' ] ],
        [ 'title' => 'Unactive Color', 'id' => 'unactive_colors', 'disabled' => true ],
      ],
    ],
  ]
]);


AFW::createSection( 'abuWPOption', [
  'id'     => 'spinnerfields',
  'title'  => 'Spinner Fields',
  'parent' => 'additionalfields',
  'icon'   => 'fas fa-sort-numeric-up',
  'fields' => [
    [ 'title' => 'Spinner', 'type' => 'spinner', 'id' => 'simple_spinner' ],
    [ 'title' => 'Spinner with Default', 'type' => 'spinner', 'id' => 'spinner_default', 'default' => [ 'value' => 150 ] ],
    [ 'title' => 'Spinner without Unit', 'type' => 'spinner', 'id' => 'spinner_without_unit', 'unit' => false ],
    [ 'title' => 'Spinner with custom Unit', 'type' => 'spinner', 'id' => 'spinner_with_custom_unit', 'units' => 'em' ],
    [ 'title' => 'Spinner with custom Units', 'type' => 'spinner', 'id' => 'spinner_with_custom_units', 'units' => [ 'px', 'em', '%', 'rem' ] ],
    [ 'title' => 'Spinner with MIN, MAX & STEP', 'type' => 'spinner', 'id' => 'spinner_with_minmax', 'min' => 20, 'max' => 80, 'step' => 5 ],
  ]
]);

AFW::createSection( 'abuWPOption', [
  'id'     => 'iconsfields',
  'title'  =>  'Icons Fields',
  'parent' => 'additionalfields',
  'icon'   => 'fas fa-info-circle',
  'fields' => [

    [ 'title' => 'Icons', 'type' => 'icon', 'id' => 'simple_icons' ],
    [ 'title' => 'Icons with Default', 'type' => 'icon', 'id' => 'icons_default', 'default' => [ 'class' => 'fas fa-bomb', 'code' => 'f1e2', 'label' => 'Bomb' ] ],
    [ 'title' => 'Icons Only class', 'type' => 'icon', 'id' => 'icons_only_class', 'save' => 'class' ],
    [ 'title' => 'Icons Only Label', 'type' => 'icon', 'id' => 'icons_only_label', 'save' => 'label' ],
    [ 'title' => 'Icons only Code', 'type' => 'icon', 'id' => 'icons_only_code', 'save' => 'code' ],

    [ 'title' => 'Icons With Code & Label', 'type' => 'icon', 'id' => 'icons_code_label', 'save' => ['code', 'label'] ],
    [ 'title' => 'Icons With Code & Class', 'type' => 'icon', 'id' => 'icons_code_class', 'save' => ['code', 'class'] ],
    [ 'title' => 'Icons With Class & Label', 'type' => 'icon', 'id' => 'icons_class_label','save' => ['class', 'label'] ],

    [ 'title' => 'Icons Selected', 'type' => 'subheading', 'id' => 'icons_depend', 'depend' => [ 'icons_class_label', 'icon', 'added' ] ],
  
  ]
]);

AFW::createSection( 'abuWPOption', [
  'id'     => 'togglefields',
  'title'  =>  'Toggle Fields',
  'parent' => 'additionalfields',
  'icon'   => 'fas fa-toggle-on',
  'fields' => [
    [ 'type' => 'toggle', 'id' => 'normal_toggle', 'title' => 'Toggle' ],
    [ 'type' => 'toggle', 'id' => 'toggle_with_default', 'title' => 'Toggle with default', 'default' => true ],
    [ 'type' => 'toggle', 'id' => 'toggle_with_shape_two', 'title' => 'Toggle with Shape 2', 'subtitle' => "'shape' => 2", 'shape' => 2, ],
    [ 'type' => 'toggle', 'id' => 'toggle_with_custom_text', 'title' => 'Toggle with custom text', 'text-on' => 'On', 'text-off' => 'Off' ],
  ]
]);


AFW::createSection( 'abuWPOption', [
  'id'     => 'sorterfields',
  'title'  =>  'Sorter Fields',
  'parent' => 'additionalfields',
  'icon'   => 'fas fa-sort',
  'fields' => [
    [ 'title' =>  'Sorter', 'type' => 'sorter', 'id' => 'normal_sorter', 'sorters' => [
        [ 'title' =>  'Active Color', 'id' => 'active_colors', 'list' => [ 'green' => 'Green', 'blue' => 'Blue', 'yellow' => 'Yellow', 'white' => 'White' ] ],
        [ 'title' =>  'Unactive Color', 'id' => 'unactive_colors', 'disabled' => true, 'list' => [ 'orange' => 'Orange', 'gray' => 'Gray', 'black' => 'Black', 'brown' => 'Brown' ] ],
      ],
    ],

    [ 'title' =>  'Maximum Sorter', 'type' => 'sorter', 'id' => 'max_sorter', 'subtitle' => 'You can create infinite sorders', 'sorters' => [
        [ 'title' =>  'Header Colors', 'id' => 'header_colors', 'list' => [ 'green' => 'Green', 'blue' => 'Blue' ] ],
        [ 'title' =>  'Body Colors', 'id' => 'body_colors', 'list' => [ 'yellow' => 'Yellow', ] ],
        [ 'title' =>  'Footer Colors', 'id' => 'footer_colors', 'list' => [ 'white' => 'White' ] ],
        [ 'title' =>  'Disabled Colors', 'id' => 'disabled_colors', 'disabled' => true ],
      ],
    ]
    
  ]
]);
