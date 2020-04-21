<?php


AFW::createTaxonomy( 'AFWtaxonomy', [
  'taxonomy'  => 'category',
  'title'     => __( 'Taxonomy from AbuFramework', 'AbuFramework' )
]);

// Text Fields section
  AFW::createSection( 'AFWtaxonomy', [
    'title'  => __( 'Text', 'AbuFramework' ),
    'icon'   => 'fas fa-grip-lines',
    'desc'   => 'this is desc',
    'fields' => [

      [ 'title'=> __('Text', 'AbuFramework'), 'validate' => 'validate', 'subtitle' => __('subtitle', 'AbuFramework'), 'type' => 'text', 'id' => 'text', 'attr' => [ 'placeholder' => __('This is placeholder', 'AbuFramework') ] ],
      [ 'title'=> __('Radio', 'AbuFramework'), 'subtitle' => __('subtitle', 'AbuFramework'), 'type' => 'radio', 'id' => 'radio', 'options' => [ 'Zebra',  'Dogs',  'Cats',  'Monkeys',  ] ],
      [ 'title'=> __('TextArea', 'AbuFramework'), 'subtitle' => __('subtitle', 'AbuFramework'), 'type' => 'textarea', 'id' => 'textarea', 'default' => __('This is default value of this Textarea.', 'AbuFramework')],
  
    ]
  ]);