<?php
AFW::createUserProfile( 'UserProfile', [
  'title'  => __('AbuFramework UserProfile', 'AbuFramework'),
]);

AFW::createSection( 'UserProfile', [
  'title'  => 'Custom Section from AbuFramework',
  'fields' => [
    [ 'id' => 'text', 'type' => 'text', 'title' => 'Text' ],
    [ 'id' => 'textarea', 'type' => 'textarea', 'title' => 'Textarea' ],
    [ 'id' => 'Radio', 'type' => 'Radio', 'title' => 'Radio', 'options' => [ 'one', 'two', 'three' ], 'desc' => 'Select One' ],
    [ 'id' => 'text2', 'type' => 'text', 'title' => 'Text', 'default' => "You've selected one.", 'depend' => [ 'Radio', '==', '0' ] ],
  ]
]);