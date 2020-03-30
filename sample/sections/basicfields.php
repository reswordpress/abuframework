<?php


AFW::createSection( ['abuWPOption', 'tabOn' ], [
    'id'      => 'basicfields',
    'title'   =>  'Basic Fields', 
    'icon'    => 'fas fa-home',
    'priority'=> 1,
    'fields'  => [
      [ 'title'=> 'Text', 'subtitle' => 'subtitle',  'type' => 'text', 'id' => 'text', 'attr' => [ 'placeholder' => 'This is placeholder',  ] ],
      [ 'type' => 'number', 'title' => 'Number',  'id' => 'number'],
      [ 'type' => 'password', 'id' => 'password', 'title' => 'Passwords',  ],
      [ 'title' => 'Checkboxs',  'id' => 'checkbox', 'type' => 'checkbox', 'options' => [ 'one' => 'One',  'two' => 'Two',  'three' => 'Three',  'four' => 'Four',  ] ],
      [ 'title'=> 'Radio',  'subtitle' => 'subtitle',  'type' => 'radio', 'id' => 'radio', 'options' => [ 'Zebra',  'Dogs',  'Cats',  'Monkeys',  ] ],
      [ 'title'=> 'TextArea',  'subtitle' => 'subtitle',  'type' => 'textarea', 'id' => 'textarea', 'default' => 'This is default value of this Textarea.', ],
    ]
]);

 $abu_basic = [ 'abuWPOption', 'metabox' ];

  
  // Text Fields section
  AFW::createSection( $abu_basic, [
    'id'     => 'textfields',
    'parent' => 'basicfields',
    'title'  =>  'Text', 
    'icon'   => 'fas fa-grip-lines',
    'desc'   => 'this is desc',
    'fields' => [

      [ 
        'title' => 'Text',  
        'type' => 'text', 
        'id' => 'simpletext', 
      ],

      [ 
        'title' => 'Text 2', 
        'desc' => 'Textarea Fields valus is "show" in Textarea Fields Sections',  
        'type' => 'text', 
        'id' => 'simpletext2', 
        'depend' => [ 'simpleTextarea', '==', 'show' ]
      ],

      [ 
        'title' => 'Text with placeholder',  
        'type' => 'text', 
        'id' => 'text_with_placeholder', 
        'attr' => ['placeholder' => 'Type something...']
      ],

      [ 
        'title' => 'Text with default',  
        'type' => 'text', 
        'id' => 'text_with_default', 
        'default' =>  'It\'s me default value.',  
      ],

      [ 
        'title' => 'Text with help',  
        'type' => 'text', 
        'id' => 'text_with_help', 
        'help' => 'The field of help text.', 
      ],
  
      [ 
        'title' => 'With some more UI',  
        'type' => 'subheading', 
        'id' => 'subheading_ui' 
      ],

      [ 
        'title' => 'Text Readonly',  
        'type' => 'text', 
        'id' => 'text_with_reaqdonly',
        'default' => 'This field is readonly field.',  
        'attr' => [ 'readonly' => 'readonly' ] 
      ],

      [ 
        'title' => 'Text with maxlength (10)',  
        'type' => 'text', 
        'id' => 'text_with_maxlenth', 
        'default' => '12345678', 
        'attr' => [ 'maxlength' => '8' ] 
      ],

      [ 
        'title' => 'Text with Full Width',  
        'type'  => 'text', 
        'id' => 'text_with_full_width', 
        'full-width' => true 
      ],

      [ 
        'title' => 'Text with Dependencies',  
        'desc' => 'type "show next"', 
        'type' => 'text', 
        'id' => 'text_with_depend'
      ],

      [
        'title' => 'Thanks for showing me up.',  
        'type' => 'text',
        'id' => 'text_with_depends', 
        'depend' => [ 'text_with_depend', '==', 'show next'] 
      ],
  
    ]
  ]);

  
  // Number fields
  AFW::createSection( $abu_basic, [
    'id'     => 'numberfields',
    'parent' => 'basicfields',
    'title'  =>  'Number', 
    'icon'   => 'fas fa-sort-numeric-up',
    'fields' => [

      [ 
        'title' => 'Number', 
        'type' => 'number', 
        'id' => 'simplenumber'
      ],

      [ 
        'title' => 'Number with placeholder', 
        'type' => 'number', 
        'id' => 'number_with_placeholder', 
        'attr' => [ 'placeholder' => 'Enter Number', ] 
      ],

      [ 
        'title' => 'Number with default', 
        'type' => 'number', 
        'id' => 'number_with_default', 
        'default' => 99999
      ],

      [ 
        'title' => 'Number with help',
        'type' => 'number', 
        'subtitle' => 'The field of subtitle text.', 
        'id' => 'number_with_help', 
        'help' => 'The field of help text.', 
      ],

      [ 
        'title' => 'Number with Limitation', 
        'type' => 'number', 
        'id' => 'number_with_Limitation', 
        'min' => 10, 
        'max' => 100, 
        'default' => 50, 
        'desc' => 'Min - 10 and Max - 100',
      ],
    
    ]

  ]);
  
  // // Password fields
  AFW::createSection( $abu_basic, [
    'id'     => 'passwordfields',
    'parent' => 'basicfields',
    'title'  =>  'Password', 
    'icon'   => 'fas fa-star-of-life',
    'fields' => [
      [ 
        'type' => 'password', 
        'title' => 'Password', 
        'id' => 'simplepassword'
      ],
      
      [ 
        'title' => 'Password with placeholder', 
        'type' => 'password', 
        'id' => 'password_with_placeholder', 
        'placeholders' => [
            'username' =>  'Enter Username', 
            'password' =>  'Enter Password', 
        ] 
      ],

      [ 
        'title' => 'Password with default', 
        'type' => 'password', 
        'id' => 'password_with_default', 
        'default' => [ 'password' => 'password', 'username' => 'username' ]
      ],

      [ 
        'title' => 'Password with help', 
        'type' => 'password', 
        'id' => 'password_with_help', 
        'help' =>  'The field of help text.', 
      ],

      [ 
        'title' => 'Password with Limitation', 
        'type' => 'password', 
        'id' => 'password_with_Limitation', 
        'max' => 10, 
        'desc' => ' Max - 10', 
        'username' => false 
      ],


    ]
  ]);
  
  // Checkbox Fields section
  AFW::createSection( $abu_basic, [
    'id'     => 'checkboxfields',
    'parent' => 'basicfields',
    'title'  =>  'Checkboxes', 
    'icon'   => 'far fa-check-square',
    'desc'   => 'There are some features of Select Fields of Abu Framework',
    'fields' => [
  
      // Checkbox
      [ 
        'title' => 'Checkbox',
        'subtitle' => 'subtitle',
        'type' => 'checkbox',
        'id' => 'simplecheckbox',
        'options' => [ 
          'one' => 'One',
          'two' => 'Two',
          'three' => 'Three', 
          'four' => 'Four'
        ]
      ],

      [ 
        'title' => 'Checkbox',
        'subtitle' => 'subtitle',
        'type' => 'checkbox',
        'id' => 'simplecheckbox',
        'label' => 'CheckIn'
      ],

      [
        'title' => 'Vertically Checkbox',
         'subtitle' => 'subtitle',
        'type' => 'checkbox',
        'id' => 'verticalcheckbox',
        'horizontal' => false, 
        'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four']
      ],

      [
        'title' => 'Checkbox with default',
        'type' => 'checkbox',
        'id' => 'checkbox_with_default',
        'default' => 'four',
        'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'], 
      ],

      [ 
        'type' => 'checkbox',
        'title' => 'Checkbox with help', 
        'subtitle' => 'The field of subtitle checkbox.', 
        'id' => 'checkbox_with_help', 
        'help' => 'The field of help checkbox.',
        'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'], 
      ],

      [ 
        'title' => 'Checkbox with default',
        'type' => 'checkbox',
        'id' => 'multicheckbox_with_default', 
        'desc' => 'Check any "one" or "three".', 
        'default' => ['two', 'four'], 
        'multiple' => true,
        'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'], 
      ],

      [ 
        'title' => 'Checkbox Dependency', 
        'type' => 'checkbox',
        'dependency' => [ 'multicheckbox_with_default', 'any', 'one,three' ],
        'id' => 'chosencheckbox_with_depend', 
        'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'], 
        'help' => 'The field of help checkbox.'
      ],
  
      // Checkbox with WP core
      [ 
        'title' => 'Checkbox with WordPress Core Data', 
        'type' => 'subheading', 
        'id' => 'checkboxsubheading_ui' 
      ],

      [ 
        'title' => 'Checkbox Pages',
        'type' => 'checkbox',
        'id' => 'pagescheckbox', 
        'options' => 'pages'
      ],

      [
        'title' => 'Checkbox Posts',
        'type' => 'checkbox',
        'id' => 'postscheckbox', 
        'options' => 'posts'
      ],

      [ 
        'title' => 'Checkbox Categories',
        'type' => 'checkbox',
        'id' => 'categoriescheckbox', 
        'options' => 'categories'
      ],

      [ 
        'title' => 'Checkbox Tags',
        'type' => 'checkbox',
        'id' => 'tagscheckbox', 
        'options' => 'tags',
        'query_args' => [
           'hide_empty' => false
         ]
      ],

      [ 
        'title' => 'Checkbox Menus',
        'type' => 'checkbox',
        'id' => 'menuscheckbox', 
        'options' => 'menus'
      ],

      [ 
        'title' => 'Checkbox Post_types',
        'type' => 'checkbox',
        'id' => 'post_typescheckbox', 
        'options' => 'post_types'
      ],

      [
        'title' => 'Checkbox Roles',
        'type' => 'checkbox',
        'id' => 'menuscheckbox', 
        'options' => 'roles'
      ],

      [
        'title' => 'Checkbox Sidebars',
        'type' => 'checkbox',
        'id' => 'post_typescheckbox', 
        'options' => 'sidebars'
      ],

      
    ]
  ]);
  
  
  // Radio Fields section
  AFW::createSection( $abu_basic, [
    'id'     => 'radiofields',
    'parent' => 'basicfields',
    'title'  =>  'Radios', 
    'icon'   => 'fas fa-dot-circle',
    'desc'   => 'There are some features of Select Fields of Abu Framework',
    'fields' => [
  
      // Radio
      [ 'title' => 'Radio', 'subtitle' => 'subtitle', 'type' => 'radio', 'id' => 'simpleradio', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four']],
      [ 'title' => 'Vertically Radio', 'subtitle' => 'subtitle', 'type' => 'radio', 'id' => 'verticalradio', 'horizontal' => false, 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four']],
      [ 'title' => 'Radio with default', 'type' => 'radio', 'id' => 'radio_with_default', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'], 'default' => 'four' ],
      [ 'title' => 'Radio with help', 'type' => 'radio', 'subtitle' => 'The field of subtitle radio.', 'id' => 'radio_with_help', 'desc' => 'Check any "one" or "two".', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'], 'help' => 'The field of help radio.' ],
      [ 'title' => 'Radio Dependency', 'type' => 'radio', 'dependency' => [ 'radio_with_help', 'any', 'one,two' ], 'id' => 'chosenradio_with_depend', 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four'], 'help' => 'The field of help radio.' ],
  
      // Radio with WP core
      [ 'title' => 'Radio with WordPress Core Data', 'type' => 'subheading', 'id' => 'radiosubheading_ui' ],
      [ 'title' => 'Radio Pages', 'type' => 'radio', 'id' => 'pagesradio', 'options' => 'pages'],
      [ 'title' => 'Radio Posts', 'type' => 'radio', 'id' => 'postsradio', 'options' => 'posts'],
      [ 'title' => 'Radio Categories', 'type' => 'radio', 'id' => 'categoriesradio', 'options' => 'categories'],
      [ 'title' => 'Radio Tags', 'type' => 'radio', 'id' => 'tagsradio', 'options' => 'tags', 'query_args' => [ 'hide_empty' => true ] ],
      [ 'title' => 'Radio Menus', 'type' => 'radio', 'id' => 'menusradio', 'options' => 'menus'],
      [ 'title' => 'Radio Post_types', 'type' => 'radio', 'id' => 'post_typesradio', 'options' => 'post_types'],
      [ 'title' => 'Radio Roles', 'type' => 'radio', 'id' => 'menusradio', 'options' => 'roles'],
      [ 'title' => 'Radio Sidebars', 'type' => 'radio', 'id' => 'post_typesradio', 'options' => 'sidebars'],
      
    ]
  ]);
  
  
  // Textarea Fields section
  AFW::createSection( $abu_basic, [
    'id'     => 'Textareafields',
    'parent' => 'basicfields',
    'title'  =>  'Textarea', 
    'icon'   => 'fas fa-grip-lines',
    'desc'   => 'this is desc',
    'fields' => [

      [ 'title' => 'Textarea', 'subtitle' => 'subtitle', 'type' => 'Textarea', 'id' => 'simpleTextarea', 'placeholder' => 'Simple Textarea Field'],
      [ 'title' => 'Textarea with placeholder', 'type' => 'Textarea', 'id' => 'Textarea_with_placeholder', 'attr' => [ 'placeholder' => 'Typed something...' ] ],
      [ 'title' => 'Textarea with default', 'type' => 'Textarea', 'id' => 'Textarea_with_default', 'default' => 'It\'s me default value.',],
      [ 'title' => 'Textarea with help', 'type' => 'Textarea', 'subtitle' => 'The field of subtitle Textarea.', 'id' => 'Textarea_with_help', 'help' => 'The field of help Textarea.' ],
  
      [ 'title' => 'With some more UI', 'type' => 'subheading', 'id' => 'subheading_ui' ],
      [ 'title' => 'Textarea Readonly', 'type' => 'Textarea', 'id' => 'Textarea_with_reaqdonly', 'default' => 'This field is readonly field.', 'attr' => [ 'readonly' => 'readonly' ] ],
      [ 'title' => 'Textarea with maxlength (8)', 'type' => 'Textarea', 'id' => 'Textarea_with_maxlenth', 'default' => '12345678', 'attr' => [ 'maxlength' => '8' ] ],
      [ 'title' => 'Textarea with custom styles', 'type' => 'Textarea', 'id' => 'Textarea_with_customstyles', 'style' => [ 'width' => '100%', 'height' => '40px', 'border-color' => '#5b9dd9' ] ],
      [ 'title' => 'Textarea with Full Width', 'type'  => 'Textarea', 'id' => 'Textarea_with_full_width', 'full-width' => true, 'style' => [ 'width' => '50%' ]],
      [ 'title' => 'Textarea with Dependencies', 'desc' => 'type "show next"', 'type' => 'Textarea', 'id' => 'Textarea_with_depend' ],
      [ 'title' => 'Thanks for showing me up.', 'type' => 'Textarea','id' => 'Textarea_with_depends', 'depend' => [ 'Textarea_with_depend', '==', 'show next'] ],
  
    ]
  ]);