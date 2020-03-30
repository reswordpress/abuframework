<?php


AFW::createMetabox( 'metabox', [
  'title'    => __( 'Metabox from AbuFramework', 'AbuFramework' ),
  'context'  => 'normal',
  'screen'   => ['post', 'page'],
  'priority' => 'default',
]);
