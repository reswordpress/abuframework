<?php

// Design Fields
AFW::createSection( 'abuWPOption', [
  'id'     => 'editorfields',
  'title'  => 'Editor Fields', 
  'icon'   => 'fas fa-code',
  'priority'=> 10,
  'fields' => [
    [ 'title'=> 'WP Editor', 'type' => 'wp_editor', 'id' => 'wp_editor' ],
  ]
]);
  
  
  
  
