<?php
AFW::createWidget( 'AFWwidget', [

  'title'    => __('AbuFramework Widget', 'AbuFramework'),
  'function' => '' // Function for echo out widget html

]);

AFW::createWidget( 'AFWwidget2', [

  'title'    => __('AbuFramework Widget 2', 'AbuFramework'),
  'function' => '' // Function for echo out widget html

]);

AFW::createSection( [ 'AFWwidget', 'AFWwidget2' ], [
  'title'  => 'Custom Section from AbuFramework',
  'fields' => [
    [ 'id' => 'title', 'type' => 'text', 'title' => 'Title' ],
    [ 'id' => 'textarea', 'type' => 'textarea', 'title' => 'Textarea' ],
    [ 'id' => 'Radio', 'type' => 'Radio', 'title' => 'Radio', 'options' => 'post' ],
  ]
]);

