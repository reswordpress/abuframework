<?php

// Grouped Fields
AFW::createSection( 'abuWPOption', [
  'id'     => 'uploadfields',
  'title'  =>  'Upload Fields', 
  'icon'   => 'fas fa-upload',
  'priority'=> 9,
  'fields' => [

    [ 
      'title' => 'Upload',
      'type' => 'upload', 
      'id' => 'upload'
    ],

    [ 
      'title' => 'Upload with Multiple', 
      'type' => 'upload', 
      'id' => 'upload_with_default', 
      'multiple' => true, 
      'subtitle' =>  "It's work as Gallery.", 
    ],
  ]
]);


