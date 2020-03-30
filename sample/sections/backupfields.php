<?php

// Grouped Fields
AFW::createSection( 'abuWPOption', [
  'id'     => 'Backupfields',
  'title'  => 'Backup',
  'icon'   => 'fas fa-recycle',
  'depend' => [ 'backup_section', '==', "off"],
  'priority'=> 30,
  'fields' => [
    [ 'title' => 'Backup',  'type' => 'backup', 'id' => 'backup' ],
  ]
]);

