<?php

require_once ABU_DIR . 'sample/wpoption.php';
require_once ABU_DIR . 'sample/metaboxes.php';
require_once ABU_DIR . 'sample/widget.php';
require_once ABU_DIR . 'sample/userprofile.php';
require_once ABU_DIR . 'sample/taxonomy.php';
require_once ABU_DIR . 'sample/tabon.php';

AFW::createSection( 'customsection', [
  'title' => 'Section from AbuFramework',
  'id'    => 'forRead',
  'page'  => 'reading',
  'fields' => [
    [ 'type' => 'number', 'title' => 'Number',  'id' => 'number'],
    [ 'type' => 'text', 'title' => 'Text',  'id' => 'text'],
    [ 'type' => 'textarea', 'title' => 'Textarea',  'id' => 'textarea'],
  ] 
]);

$abu_sections = glob( ABU_DIR . 'sample/sections/*.php' );
ksort($abu_sections);
foreach( $abu_sections as $path ) {
  require_once( $path );
}