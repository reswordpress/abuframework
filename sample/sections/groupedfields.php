<?php

// Grouped Fields
AFW::createSection( 'abuWPOption', [
  'id'     => 'groupedfields',
  'title'  =>  'Grouped Fields', 
  'icon'   => 'fas fa-compress',
  'priority'=> 4,
  'fields' => [

    [ 'title' => 'Group Button', 'type' => 'button_group', 'id' => 'button_group', 'options' => [
        'one' => 'One 1',
        'two' => 'Two 2',
        'three' => 'Three 3',
      ], 'desc' => 'click One or Two to show up Range Date Picker',
    ],

    [ 'type' => 'sortable', 'id' => 'sortable', 'title' => 'Sortable', 'fields' => [
        [ 'title' => 'Text', 'id' => 'first_text', 'type' => 'text' ],
        [ 'title' => 'Textarea', 'id' => 'second_textarea', 'type' => 'Textarea' ],
        [ 'title' => 'Color Picker', 'id' => 'second_post', 'type' => 'color_picker' ],
    ] ],

  ]
]);



// Button Group Fields section
AFW::createSection( 'abuWPOption', [
  'id'     => 'buttongroupfields',
  'parent' => 'groupedfields',
  'title'  =>  'Button Groups', 
  'icon'   => 'fas fa-table',
  'fields' => [

    [ 'title' => 'Button Group', 'type' => 'button_group', 'id' => 'simple_button_group', 'options' => [
        'one' => 'One',
        'two' => 'Two',
        'three' => 'Three',
      ]
    ],
    [ 'title' => 'Button Group with Default', 'type' => 'button_group', 'id' => 'button_group_with_deafult', 'options' => [
        'one' => 'One',
        'two' => 'Two',
        'three' => 'Three',
      ], 'default'  =>  'one' 
    ],
    [ 'title' => 'Multi Select Button Group', 'type' => 'button_group', 'id' => 'mutli_select_button_group', 'options' => [
        'one' => 'One',
        'two' => 'Two',
        'three' => 'Three',
      ], 'multiple' => true 
    ],

    [ 'title' => 'Small Button Group', 'type' => 'button_group', 'id' => 'small_button_group', 'options' => [
        'one' => 'One',
        'two' => 'Two',
        'three' => 'Three',
     ], 'size'  => 'medium'
    ],

    [ 'title' => 'large Button Group', 'type' => 'button_group', 'id' => 'large_button_group', 'options' => [
        'one' => 'One',
        'two' => 'Two',
        'three' => 'Three',
     ], 'size'  => 'large'
    ],

    // with WP core
    [ 'title' => 'Button Group with WordPress Core Data', 'type' => 'subheading', 'id' => 'ButtonGroupsubheading_ui' ],
    [ 'title' => 'Button Group with Core', 'type' => 'button_group', 'id' => 'core_button_group', 'options' => 'pages',],
    [ 'title' => 'Checkbox Posts', 'type' => 'button_group', 'id' => 'postsbutton_group', 'options' => 'posts'],
    [ 'title' => 'Checkbox Categories', 'type' => 'button_group', 'id' => 'categoriesbutton_group', 'options' => 'categories'],
    [ 'title' => 'Checkbox Tags', 'type' => 'button_group', 'id' => 'tagsbutton_group', 'options' => 'tags', 'query_args' => [ 'hide_empty' => false ] ],
    [ 'title' => 'Checkbox Menus', 'type' => 'button_group', 'id' => 'menusbutton_group', 'options' => 'menus'],
    [ 'title' => 'Checkbox Post_types', 'type' => 'button_group', 'id' => 'post_typesbutton_group', 'options' => 'post_types'],
    [ 'title' => 'Checkbox Roles', 'type' => 'button_group', 'id' => 'menusbutton_group', 'options' => 'roles'],
    [ 'title' => 'Checkbox Sidebars', 'type' => 'button_group', 'id' => 'post_typesbutton_group', 'options' => 'sidebars'],


  ]
]);

AFW::createSection( 'abuWPOption', [
  'id'     => 'sortablefields',
  'parent' => 'groupedfields',
  'title'  =>  'Sortable', 
  'icon'   => 'fas fa-exchange-alt',
  'fields' => [

    [ 'type' => 'sortable', 'id' => 'simple_sortable', 'title' => 'Sortable', 'fields' => [
        [ 'title' => 'Text', 'id' => 'first_text', 'type' => 'text' ],
        [ 'title' => 'Textarea', 'id' => 'second_textarea', 'type' => 'Textarea' ],
        [ 'title' => 'Color Picker', 'id' => 'third_picker', 'type' => 'color_picker' ],
    ] ],

    [ 'type' => 'sortable', 'id' => 'sortable_with_deafult', 'title' => 'Sortable with Default', 'fields' => [
      [ 'title' => 'Text', 'id' => 'text', 'type' => 'text', ],
      [ 'title' => 'Textarea', 'id' => 'textarea', 'type' => 'Textarea' ],
      [ 'title' => 'Color Picker', 'id' => 'third_picker', 'type' => 'color_picker' ],
    ], 'default' => [ 'text' => 'Default Text', 'textarea' => 'Defalut value in textarea', 'third_picker' => '#dd3333' ] ],

    [ 'type' => 'sortable', 'id' => 'nested_sortable', 'title' => 'Sortable within sortable', 'fields' => [
        [ 'title' => 'Text', 'id' => 'first_text', 'type' => 'text' ],
        [ 'title' => 'Textarea', 'id' => 'second_textarea', 'type' => 'Textarea' ],
        [ 'type' => 'sortable', 'id' => 'simples_sortable', 'title' => 'Sortable', 'fields' => [
            [ 'title' => 'Text', 'id' => 'first_text', 'type' => 'text' ],
            [ 'title' => 'Color Picker', 'id' => 'third_picker', 'type' => 'color_picker' ],
            [ 'title' => 'Textarea', 'id' => 'second_textarea', 'type' => 'Textarea' ],
        ] ],
    ] ],

  ]
]);


// Accordion section
AFW::createSection( 'abuWPOption', [
  'id'     => 'accordionfields',
  'parent' => 'groupedfields',
  'title'  =>  'Accordion', 
  'icon'   => 'fas fa-align-justify',
  'fields' => [
    
    [ 'title' => 'Accordion', 'subtitle' => 'subtitle', 'type' => 'accordion', 'id' => 'accordions', 'accordions' => [
      [ 'title'  => 'First',
        'fields' => [
        [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder'],
        [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ] ],
        [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false ],
      ]],
      [ 'title' => 'Second',
        'fields' => [
        [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder'],
        [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ] ],
        [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false ],
      ]],
    ]],
    
    [ 'title' => 'Accordion with default', 'subtitle' => 'subtitle', 'type' => 'accordion', 'id' => 'accordions-with-default', 'accordions' => [
      [ 'title'  => 'First',
        'icon'   => '<i class="fab fa-napster"></i>',
        'fields' => [
        [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder', 'default' => 'This is default value.'],
        [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one','four'] ],
        [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false, 'default' => ['color'=>'blue','hover'=>'yellow'] ],
      ]],
      [ 'title'  => 'Second',
        'icon'   => '<i class="fab fa-pagelines"></i>',
        'fields' => [
        [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder', 'default' => 'This is default value.'],
        [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one','four'] ],
        [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false, 'default' => ['color'=>'red','hover'=>'orange'] ],
      ]],
    ]],

    [ 'title' => 'Accordion within accordion', 'subtitle' => 'It has bug in inside accordion', 'type' => 'accordion', 'id' => 'accordions-within-accordion', 'accordions' => [
      [ 'title'  => 'First',
        'id'     => 'first',
        'fields' => [
          [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder', 'default' => 'This is default value.'],
          [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one','four'] ],
          [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false, 'default' => ['color'=>'blue','hover'=>'yellow'] ],
          [ 'title' => 'Accordion within accordion', 'subtitle' => 'subtitle', 'type' => 'accordion', 'id' => 'inside-accordion', 'accordions' => [
          [ 'title'  => 'Inside Accordion',
            'id'     => 'first',
            'fields' => [
            [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder', 'default' => 'This is default value.'],
            [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one','four'] ],
            [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false, 'default' => ['color'=>'blue','hover'=>'yellow'] ],
          ]],
          [ 'title'  => 'Second',
            'id'     => 'second',
            'fields' => [
            [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder', 'default' => 'This is default value.'],
            [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one','four'] ],
            [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false, 'default' => ['color'=>'red','hover'=>'orange'] ],
          ]],
        ]],
      ]],
      [ 'title'  => 'Second',
        'id'     => 'second',
        'fields' => [
        [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder', 'default' => 'This is default value.'],
        [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one','four'] ],
        [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false, 'default' => ['color'=>'red','hover'=>'orange'] ],
      ]],
    ]],

  ]
]);


// Fieldset Fields section
AFW::createSection( 'abuWPOption', [
  'id'     => 'fieldset',
  'parent' => 'groupedfields',
  'title'  =>  'Fieldset', 
  'icon'   => 'fas fa-cogs',
  'fields' => [

    [ 'title' => 'Fieldset', 'subtitle' => 'subtitle', 'type' => 'fieldset', 'id' => 'fieldset-1', 'fields' => [
        [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder'],
        [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ] ],
        [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false ],
    ]],
    [ 'title' => 'Fieldset with Default', 'subtitle' => 'subtitle', 'type' => 'fieldset', 'id' => 'fieldset-with-default', 'fields' => [
        [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'default' => 'This is default value.'],
        [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one', 'three'] ],
        [ 'title' => 'Link Color with AF color Picker', 'type' => 'link_color', 'id' => 'color_with_afp', 'wp-picker' => false, 'default' => [ 'color' => 'red', 'hover' => 'green' ] ],
    ]],
    [ 'title' => 'Fieldset withing Fieldset', 'subtitle' => 'subtitle', 'type' => 'fieldset', 'id' => 'fieldset-within-fieldset', 'fields' => [
        [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'default' => 'This is default value.'],
        [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one', 'three'] ],
        [ 'title' => 'Fieldset withing Fieldset', 'subtitle' => 'subtitle', 'type' => 'fieldset', 'id' => 'fieldset-within-fieldset', 'fields' => [
            [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'default' => 'This is default value.'],
            [ 'title' => 'Color', 'type' => 'color_picker', 'id' => 'color_with_afp', 'wp-picker' => true ],
            [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one', 'three'] ],
        ]]
    ]]

  ],
]);


// Tabs Fields section
AFW::createSection( 'abuWPOption', [
  'id'     => 'tabsfields',
  'parent' => 'groupedfields',
  'title'  =>  'Tabs', 
  'icon'   => 'fas fa-table',
  'fields' => [

    [ 'title' => 'Tabs', 'subtitle' => 'subtitle', 'type' => 'tabs', 'id' => 'tab', 'tabs' => [
      [ 'title'  => 'First',
        'fields' => [
          [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder'],
          [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false ],
          [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ] ],
        ]
      ],
      [ 'title' => 'Second',
        'fields' => [
          [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder'],
          [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ] ],
          [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false ],
        ]
      ],
    ]],
    
    [ 'title' => 'Tabs with default', 'subtitle' => 'subtitle', 'type' => 'tabs', 'id' => 'tab-with-default', 'tabs' => [
      [ 'title'  => 'First',
        'icon'   => '<i class="fas fa-adjust"></i>',
        'fields' => [
          [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one','four'] ],
          [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder', 'default' => 'This is default value.'],
          [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false, 'default' => ['color'=>'blue','hover'=>'yellow'] ],
        ]
      ],
      [ 'title'  => 'Second',
        'icon'   => '<i class="fab fa-adn"></i>',
        'fields' => [
          [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder', 'default' => 'This is default value.'],
          [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one','four'] ],
          [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false, 'default' => ['color'=>'blue','hover'=>'yellow'] ],
        ]
      ],
    ]],

    [ 'title' => 'Tabs within Tabs', 'subtitle' => 'subtitle', 'type' => 'tabs', 'id' => 'tab-within-tabs', 'tabs' => [
      [ 'title'  => 'First',
        'fields' => [
        [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder', 'default' => 'This is default value.'],
        [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one','four'] ],

        [ 'title' => 'Tabs', 'subtitle' => 'subtitle', 'type' => 'tabs', 'id' => 'tabs', 'tabs' => [
          [ 'title'  => 'First',
            'fields' => [
              [ 'title' => 'Color Picker', 'type' => 'color_picker', 'id' => 'aflink_color_with_afp', 'wp-picker' => true ],
              [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one','four'] ],
              [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder', 'default' => 'This is default value.'],
          ]],
          [ 'title'  => 'Second',
            'fields' => [
              [ 'title' => 'Color Picker', 'type' => 'color_picker', 'id' => 'aflink_color_with_afp', 'wp-picker' => true ],
              [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one','four'] ],
              [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder', 'default' => 'This is default value.'],
          ]],
        ]],

      ]],
      [ 'title'  => 'Second',
        'fields' => [
        [ 'title'=> 'Text', 'subtitle' => 'subtitle', 'type' => 'text', 'id' => 'text', 'placeholder' => 'This is placeholder', 'default' => 'This is default value.'],
        [ 'title' => 'Checkboxs', 'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'default' => ['one','four'] ],
        [ 'title' => 'Link Color  with AF color Picker', 'type' => 'link_color', 'id' => 'aflink_color_with_afp', 'wp-picker' => false, 'default' => ['color'=>'blue','hover'=>'yellow'] ],
      ]],
    ]],

  ]
]);


