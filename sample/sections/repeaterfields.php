<?php

AFW::createSection( 'abuWPOption', [
    'id'     => 'repeaterfields',
    'title'  =>  'Repeaters Fields', 
    'icon'   => 'fas fa-circle-notch',
    'priority'=> 5,
    'fields' => [

      [ 'type' => 'nestables', 'id' => 'nestables', 'title' => 'Nestables', 'nestables' => [
          [ 'title'  =>  'First',  'id' => 'first', 'children' => [ [ 'title'  =>  'Second',  'id' => 'second', ] ] ],
          [ 'title'  =>  'Third',  'id' => 'third' ],
          [ 'title'  =>  'Four',  'id' => 'four' ]
        ],
        'fields' => [
          [ 'type' => 'text', 'id' => 'text', 'title' => 'Text' ],
          [ 'type' => 'textarea', 'id' => 'textarea', 'title' => 'Textarea' ],
        ]
      ],

    ]
]);

  
