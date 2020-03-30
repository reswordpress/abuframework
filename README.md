
# AbuFramework

AbuFramework is modern & advanced Options Framework for WordPress themes and plugins. Created in OOP ( Object Oriented Programming ). It allows to create custom options, mataboxes,  widgets, userprofile fields, widgets and taxonomies.

## Installation
* Download installable AbuFramework zip.
* Upload and active plugin from 
	`WordPress` → `Plugins` → `Add New` → `Upload Plugin`

## Quick Start
```php
<?php

// Create options
AFW::createWPOption( 'abuWPOption', [

  'framework_title' => 'Abu Framrework <small> by Abu sufiyan</small>',

  'version'         => 'v1.0.0',
  'copyright'       => 'Abu Framework by Abu Sufiyan',
  
 // menu settings
  'menu_title'      => 'Abu Framework',
  'menu_slug'       => 'abu-framework',
  'menu_type'       => 'menu',
  'menu_capability' => 'manage_options',

]);

AFW::createSection( 'abuWPOption', [
    'title'   =>  'Basic Fields', 
    'fields'  => [
	
          [ 
	  	'title' => 'Text',
		'type' => 'text',
		'id' => 'text',
	  ],
      
	  [ 
	  	'type' => 'number',
		   'title' => 'Number', 
		   'id' => 'number'
	  ],
      
	  [ 
	  	'type' => 'password',
		   'id' => 'password', 
		   'title' => 'Passwords',
    	  ],
      
	  [ 
	  	'title'=> 'TextArea',
		   'type' => 'textarea', 
		   'id' => 'textarea',
	  ],
    ]
]);
```

#####  How to get saved value ?

```php
$opts = get_option( 'abuWPOption' ); // unique id

echo $opts['text']; // id of the field
echo $opts['textarea']; // id of the field
```


## Features ##

##### 1. Admin Option
##### 2. MetaBoxes
##### 3. TabOn
##### 4. Taxonomy
##### 5. userProfile
##### 6. Widget

## Available Fields
| Accordion | Backup | Border | Button Group | Checkbox |
| :------------: | :------------: | :------------: | :------------: | :------------: |
| Color Palette | Color Picker | Gradient | Link Color | Date Picker |
| Range Date Picker | Dimensions | Fieldset | Heading | Icon Picker |
| Icon | Imageselect | Nestables | Number | Password |
| Radio | Select | Range Slider | Slider | Sortable |
| Sorter | Spacing | Spinner | Subheading | Tabs |
| Text | Textarea | Toggle | Upload | Wp Editor |

## Donate to the Framework

Please donate to help support development of AbuFramework. If, You can.

[![Donate to the framework](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif "Donate to the framework")](https://www.paypal.me/yourabusufiyan)

------------



## Release Notes

###  v1.0.0 
- Release Framework

## Authors

* **Abu Sufiyan** - *Initial work* - [link](http://www.abusufiyan.com/?ref=git_afw)


## License

You can use AbuFramework in the premium theme/plugin and sell theme.. This framework is licensed 100% GPL as WordPress uses.
