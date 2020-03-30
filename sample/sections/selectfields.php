<?php

AFW::createSection( [ 'abuWPOption', 'tabOn' ], [
    'id'     => 'selectfields',
    'title'  =>  'Select Fields', 
    'icon'   => 'fas fa-paint-brush',
    'priority'=> 2.5,
    'fields' => [
      [ 'title'=> 'Select', 'subtitle' => 'subtitle', 'type' => 'select', 'id' => 'select', 'desc' => 'This is Simple Selext', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ], 'placeholder' => 'Select One' ],
      
      [ 'title' => 'Select with Image', 'subtitle' => 'subtitle', 'type' => 'select', 'id' => 'simpleselect_with_image0', 'placeholder' => 'Select People', 
        'options' => [ 
          'one'  => [ 'title' => 'One', 'img' => 'https://placehold.co/30x30?text=Abu' ],
          'two'  => [ 'title' => 'Two', 'img' => 'https://placehold.co/30x30?text=Abu' ],
          'three'=> [ 'title' => 'Three', 'img' => 'https://placehold.co/30x30?text=Abu' ],
          'four' => [ 'title' => 'Four', 'img' => 'https://placehold.co/30x30?text=Abu' ],
        ]
      ],

      [ 'title' => 'Select with icon', 'subtitle' => 'subtitle', 'type' => 'select', 'id' => 'simpleselect_with_icon0', 'placeholder' => 'Select Company', 
        'options' => [ 
          'facebook' => [ 'title' => 'Facebook', 'icon' => 'fab fa-facebook-f' ],
          'google'   => [ 'title' => 'Google',   'icon' => 'fab fa-google' ],
          'apple'    => [ 'title' => 'Apple',    'icon' => 'fab fa-apple' ],
          'yahoo'    => [ 'title' => 'Yahoo',    'icon' => 'fab fa-yahoo' ],
        ]
      ],

      [ 'title' => 'Image Select', 'type' => 'image_select', 'id' => 'simple_image_select', 'desc'    => 'This is Description',
        'options' => [
          'one'   => 'https://placehold.co/150x150?text=AbuFramework 1',
          'two'   => 'https://placehold.co/150x150?text=AbuFramework 2',
          'three' => 'https://placehold.co/150x150?text=AbuFramework 3',
        ]
      ],
     

    ]
]);

// Select Fields section
AFW::createSection( 'abuWPOption', [
  'id'     => 'normalselectfields',
  'parent' => 'selectfields',
  'title'  =>  'Select', 
  'icon'   => 'fa fa-list',
  'desc'   => 'There are some features of Select Fields of Abu Framework',
  'fields' => [

    // Select
    [ 'title' => 'Select', 'subtitle' => 'subtitle', 'type' => 'select', 'id' => 'simpleselect', 'placeholder' => 'Select Number', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four']],
    [ 'title' => 'Select with default', 'type' => 'select', 'id' => 'select_with_default', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'], 'default' => 'four' ],
    [ 'title' => 'Select with optgroup', 'type' => 'select', 'subtitle' => 'The field of subtitle select.', 'id' => 'select_with_optgroup', 'options' => [ 
      'Group One' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ],
      'Group Two' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ],
      'Group Three' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four' ],
    ], 'help' => 'The field of help select.' ],
    [ 'title' => 'Multi Select with default', 'type' => 'select', 'id' => 'multiselect_with_default', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'], 'default' => ['two', 'three'], 'multiple' => true ],
    
    // Select with chosen
    [ 'title' => 'Chosen Select', 'desc' => '"chosen"  =>  true', 'chosen' => true, 'type' => 'select', 'id' => 'chosensimpleselect', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four']],
    [ 'title' => 'Chosen Select with default', 'type' => 'select', 'chosen' => true, 'value' => 'one', 'id' => 'chosenselect_with_default', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'], 'default' => 'four' ],
    [ 'title' => 'Chosen Multiple Select with help', 'multiple' => true, 'type' => 'select', 'chosen' => true, 'help' => 'This is help value.', 'id' => 'multiplechosenselect_with_help', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'], 'help' => 'The field of help select.' ],
    [ 'title' => 'Chosen Multiple Select with Dependency', 'desc' => 'Select "One" and "Two" only.', 'multiple' => true, 'default' => [ 'one', 'three' ], 'type' => 'select', 'chosen' => true, 'id' => 'multiplechosenselect_with_default', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'] ],
    [ 'title' => 'Select Dependency', 'type' => 'select', 'dependency' => [ 'multiplechosenselect_with_default', '==', ['one','two'] ], 'id' => 'chosenselect_with_depend', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'], 'help' => 'The field of help select.' ],

    // Select with WP core
    [ 'title' => 'Select with WordPress Core Data', 'type' => 'subheading', 'id' => 'selectsubheading_ui' ],
    [ 'title' => 'Select Pages', 'type' => 'select', 'id' => 'pagesselect', 'options' => 'pages'],
    [ 'title' => 'Select Posts', 'type' => 'select', 'id' => 'postsselect', 'options' => 'posts'],
    [ 'title' => 'Select Categories', 'type' => 'select', 'id' => 'categoriesselect', 'options' => 'categories'],
    [ 'title' => 'Select Tags', 'type' => 'select', 'id' => 'tagsselect', 'options' => 'tags', 'query_args' => [ 'hide_empty' => false ] ],
    [ 'title' => 'Select Menus', 'type' => 'select', 'id' => 'menusselect', 'options' => 'menus'],
    [ 'title' => 'Select Post_types', 'type' => 'select', 'id' => 'post_typesselect', 'options' => 'post_types'],
    [ 'title' => 'Select Roles', 'type' => 'select', 'id' => 'rolesselect', 'options' => 'roles'],
    [ 'title' => 'Select Sidebars', 'type' => 'select', 'id' => 'sidebarsselect', 'options' => 'sidebars'],
    
  ]
]);

// Select Fields section
AFW::createSection( 'abuWPOption', [
  'id'     => 'selectwithimagefields',
  'parent' => 'selectfields',
  'title'  =>  'Select with Image & Icon', 
  'icon'   => 'far fa-image',
  'desc'   => 'There are some features of Select Fields of Abu Framework',
  'fields' => [

    [ 'title' => 'Select with Image', 'subtitle' => 'subtitle', 'type' => 'select', 'id' => 'simpleselect_with_image', 'placeholder' => 'Select People', 
      'options' => [ 
        'one'  => [ 'title' => 'One', 'img' => 'https://placehold.co/30x30?text=Abu' ],
        'two'  => [ 'title' => 'Two', 'img' => 'https://placehold.co/30x30?text=Abu' ],
        'three'=> [ 'title' => 'Three', 'img' => 'https://placehold.co/30x30?text=Abu' ],
        'four' => [ 'title' => 'Four', 'img' => 'https://placehold.co/30x30?text=Abu' ],
      ]
    ],

    [ 'title' => 'Select with icon', 'subtitle' => 'subtitle', 'type' => 'select', 'id' => 'simpleselect_with_icon', 'placeholder' => 'Select Company', 
      'options' => [ 
        'facebook' => [ 'title' => 'Facebook', 'icon' => 'fab fa-facebook-f' ],
        'google'   => [ 'title' => 'Google',   'icon' => 'fab fa-google' ],
        'apple'    => [ 'title' => 'Apple',    'icon' => 'fab fa-apple' ],
        'yahoo'    => [ 'title' => 'Yahoo',    'icon' => 'fab fa-yahoo' ],
      ]
    ],


    
  ]
]);

// Image Select Fields section
AFW::createSection( 'abuWPOption', [
  'id'     => 'imageselectfields',
  'parent' => 'selectfields',
  'title'  =>  'Image Select', 
  'icon'   => 'far fa-check-square',
  'desc'   => 'There are some features of Select Fields of Abu Framework',
  'fields' => [

    [ 'title' => 'Image Select', 'type' => 'image_select', 'id' => 'normal_image_select', 'desc'    => 'This is Description',
      'options' => [
        'one'   => 'https://placehold.co/150x150?text=One',
        'two'   => 'https://placehold.co/150x150?text=Two',
        'three' => 'https://placehold.co/150x150?text=Three',
      ],
    ],

    [ 'title' => 'Image Select with default', 'type' => 'image_select', 'id' => 'image_select_with_default', 'desc'    => 'This is Description',
      'options' => [
        'one'   => 'https://placehold.co/150x150?text=One',
        'two'   => 'https://placehold.co/150x150?text=Two',
        'three' => 'https://placehold.co/150x150?text=Three',
      ],
      'default' => 'one'
    ],

    [ 'title' => 'Round Image', 'type' => 'image_select', 'id' => 'image_select_with_secondtype', 'desc' => '"select_type" => "second"',
      'options' => [
        'one'   => 'https://placehold.co/150x150?text=One',
        'two'   => 'https://placehold.co/150x150?text=Two',
        'three' => 'https://placehold.co/150x150?text=Three',
      ],
      'select_type' => true,
    ],

    [ 'title' => 'Select Multiple Images', 'type' => 'image_select', 'id' => 'image_select_with_multiple', 'desc' => '"multiple" => true',
      'options' => [
        'one'   => 'https://placehold.co/150x150?text=One',
        'two'   => 'https://placehold.co/150x150?text=Two',
        'three' => 'https://placehold.co/150x150?text=Three',
        'Four' => 'https://placehold.co/150x150?text=Four',
      ],
      'multiple' => true,
    ],

    [ 'title' => 'Image With Custom Width & Height', 'type' => 'image_select', 'id' => 'image_select_with_custom_wh',
      'subtitle' => "'width'  => '25%' </br> 'height' => '150px'",
      'options' => [
        'one'   => 'https://placehold.co/150x150?text=One',
        'two'   => 'https://placehold.co/150x150?text=Two',
        'three' => 'https://placehold.co/150x150?text=Three',
        'Four' => 'https://placehold.co/150x150?text=Four',
      ],
      'width'  => '25%',
      'height' => '150px',
      'desc'   =>  'Select First Image', 
    ],

    [ 'title' => 'Image With Display Dependency', 'type' => 'image_select', 'id' => 'image_select_with_display_depend',
      'options' => [
        'one'   => 'https://placehold.co/150x150?text=One',
        'two'   => 'https://placehold.co/150x150?text=Two',
        'three' => 'https://placehold.co/150x150?text=Three',
        'Four' => 'https://placehold.co/150x150?text=Four',
      ],
      'depend'  => [ 'image_select_with_custom_wh', '==', 'one' ]
    ],

    [ 'title' => 'Image With Custom Width & Height', 'type' => 'image_select', 'id' => 'image_select_with_cuc_with',
      'subtitle' => "'width'  => '100%' </br> 'height' => '150px'",
      'options' => [
        'one'   => 'https://placehold.co/700x100?text=Header%20One',
        'two'   => 'https://placehold.co/700x100?text=Header%20Two',
        'three' => 'https://placehold.co/700x100?text=Header%20Three',
        'Four' => 'https://placehold.co/700x100?text=Header%20Four',
      ],
      'width'  => '100%',
      'height' => '100px',
    ],


    
  ]
]);

  

?>