<?php
AFW::createWPOption( 'abuWPOption', [

  'framework_title' => 'Abu Framrework <small> by Abu sufiyan</small>',
  'framework_class' => 'custom-class', // Custom class for root elemenet
  'reset_all'       => true,

  'version'         => 'v1.0.0',
  'copyright'       => 'Abu Framework by <a href="http://abusufiyan.com/?ref=abuframework" target="_blank"><small>Abu Sufiyan</small></a>',

  'menu_title'      => 'AFW Demo',
  'menu_slug'       => 'abuframeworkdemo',
  'menu_type'       => 'menu',
  'menu_capability' => 'manage_options',

  'reset_all'       => [ // boolean/array
    'text'      => 'Reset All',
    'class'     => ''
  ],
  'save'            => [ // boolean/array
    'text'      => 'Save',
    'class'     => ''
  ],

  'ajax'            => true,  // Ajax save, reset Section, reset changes
  'show_multi'      => false,

  'before'          => '<p style="text-align:center"><code>This is text "before" Framework. HTML are allowed.</code></p>',
  'after'           => '<p style="text-align:center"><code>This is text "after" Framework. HTML are allowed.</code></p>',

  // menu settings
  'menu_icon'       => null,
  'menu_position'   => null,
  'menu_hidden'     => false,
  'menu_parent'     => '',

]);