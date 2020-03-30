<?php

AFW::createSection( 'abuWPOption', [
  'id'     => 'dependfields',
  'title'  =>  'Dependency',
  'icon'   => 'fas fa-magic',
  'priority'=> 16,
  'fields' => [

    [ 'title'=> 'Text', 'desc' => 'type "show"', 'type' => 'text', 'id' => 'dependtext' ],
    [ 'title'=> 'Radio', 'desc' => 'Select One', 'type' => 'radio', 'id' => 'dependradio', 'depend' => [ 'dependtext', '==', 'show' ], 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three' ] ],
    [ 'title'=>'Textarea', 'type' => 'textarea', 'desc' => 'Change "show" to "hide"', 'id' => 'dependtextarea', 'depend' => [ 'dependtext|dependradio', 'any|==', "show,hide|one"  ] ],
    
    [ 'title'=> 'Nested Dependencies', 'type' => 'subheading', 'id' => 'dependsubheading' ],
    [ 'title'=> 'First', 'desc' => 'type "first"', 'type' => 'text', 'id' => 'dependfirst' ],
    [ 'title'=> 'Second', 'desc' => 'Select "One"', 'type' => 'radio', 'id' => 'dependsecond', 'depend' => [ 'dependfirst', '==', "first"  ], 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three' ] ],
    [ 'title'=> 'four', 'desc' => 'Must be "One" & "Three" selected', 'type' => 'checkbox', 'id' => 'dependthird', 'depend' => [ 'dependsecond', '==', "one"  ], 'options' => [ 'one' => 'One', 'two' => 'Two', 'three' => 'Three' ] ],
    [ 'title'=> 'This is Final', 'type' => 'textarea', 'id' => 'dependfinal', 'depend' => [ 'dependthird', 'must', "one,three"  ] ],

    [ 'title'=> 'Another Section', 'type' => 'subheading', 'id' => 'dependsubheadinganother', ],

    [ 'title'=> 'Hide Backup Section', 'type' => 'toggle', 'id' => 'backup_section', 'shape' => 2 ],

    [ 'title'=> 'You can also hide any other section fields.', 'type' => 'subheading', 'id' => 'dependsubheadinganothers', 'depend' => [ 'backup_section', '==', "true"  ] ],

  ]
]);
