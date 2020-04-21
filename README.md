
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
			'id' => 'number'
			'title' => 'Number', 
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

// Create Metabox
AFW::createMetabox( 'metabox', [
  'title'    => __( 'Metabox from AbuFramework', 'AbuFramework' ),
  'context'  => 'normal',
  'screen'   => ['post', 'page'],
  'priority' => 'default',
]);

// Create TabOn
AFW::createTabOn( 'tabOn', [

  'title'            => 'TabOn from AbuFramework',
  'desc'             => 'This is Description',

  'page_title'       => 'AFW TabOn',
  'menu_type'        => 'menu',
  'menu_title'       => 'TabOn',
  'menu_slug'        => 'tabon',
  'menu_capability'  => 'manage_options',
  'menu_icon'        => 'dashicons-admin-tools',
  
]);

// Create Taxonomy
AFW::createTaxonomy( 'AFWtaxonomy', [
  'taxonomy'  => 'category',
  'title'     => __( 'Taxonomy from AbuFramework', 'AbuFramework' )
]);

// Create UserProfile
AFW::createUserProfile( 'UserProfile', [
  'title'  => __('AbuFramework UserProfile', 'AbuFramework'),
]);


// Create Widget
AFW::createWidget( 'AFWwidget', [

  'title'    => __('AbuFramework Widget', 'AbuFramework'),
  'function' => '' // Function for echo out widget html

]);

```

#####How to get saved value ?
```php
$opts = get_option( 'abuWPOption' ); // unique id

echo $opts['text']; // id of the field
echo $opts['textarea']; // id of the field
```
##  Screenshots ##

[![WPOption - AbuFramework](https://i.ibb.co/LzfXLs2/WPOption-Abu-Framework.png "WPOption - AbuFramework")](https://ibb.co/1fxtD4w "WPOption - AbuFramework")

------------

[![Metabox - AbuFramework](https://i.ibb.co/4NtWRmV/Metabox-Abu-Framework.png "Metabox - AbuFramework")](https://ibb.co/h89sF7m "Metabox - AbuFramework")

------------

[![TabOn - AbuFramework](https://i.ibb.co/b1MfbtY/Tab-On-Abu-Framework.png "TabOn - AbuFramework")](https://ibb.co/TcxCWyJ "TabOn - AbuFramework")

------------

[![Widget - AbuFramework](https://i.ibb.co/z4S3HBd/Widgets-Abu-Framework.png "Widget - AbuFramework")](https://ibb.co/vjJNvT9 "Widget - AbuFramework")

------------

[![UserProfile - AbuFramework](https://i.ibb.co/0JBPHwv/User-Profile-Abu-Framework.png "UserProfile - AbuFramework")](https://ibb.co/MN8qFXQ "UserProfile - AbuFramework")

------------

[![Taxonomy - AbuFramework](https://i.ibb.co/hWYnj1n/Taxonomy-Abu-Framework.png "Taxonomy - AbuFramework")](https://ibb.co/Snf1871 "Taxonomy - AbuFramework")

------------

[![WP Page Setting - AbuFramework](https://i.ibb.co/Z8L1L0R/WP-Page-Abu-Framework.png "WP Page Setting - AbuFramework")](https://ibb.co/C71s1fp "WP Page Setting - AbuFramework")


## Features ##

##### 1.  Admin Option
##### 2.  MetaBoxes
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
| Animate

## Donate to the Framework

Please donate to help support development of AbuFramework. If, You can.

[![Donate to the framework](https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif "Donate to the framework")](https://www.paypal.me/yourabusufiyan)

------------



## Release Notes
= 1.0.2 =
- Added: Option Page under `'Tools'` -> `'AbuFramework'`
- Added: Code Editor Fields
- Added: Add Section into WP Setting

= 1.0.1 =
- Added: readme.txt
- Added
  - Senitize Functions:
    01 Checkbox
    02 Radio
    03 Number
    04 Color Palette
    05 Select
    06 Image Select
    07 Button Group
    08 Dimensions
    09 Spacing
    10 Sortable
    11 Accordion
    12 Fieldset
    13 Tabs
    14 Nestables
    15 Slider
    16 Range Slider
    17 Uplaod
    18 Spinner
    19 Sorter
    20 Icons
- Added: Fields
- Animate
- Added: Disabled Feature in Checkbox and Radio
- Added: Hover effect in WPOption Sub-Nav
- Added: Upload Image Copy Button 
- Added: Remove All Button in Upload
- Fixed: Uplaod Image Duplicating 
- Fixed: Checkbox Label Values   
- Fixed: Nestables Setter Values 
- Fixed: Uplaod Setter Values from JS Fixed:
- Uplaod Setter Values from PHP. It will show only 150x150 image.

###  v1.0.0 
- Release Framework

## Author

* **Abu Sufiyan** - *Initial work* - [link](http://www.abusufiyan.com/?ref=git_afw)


## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
You can use AbuFramework in the premium theme/plugin and sell theme.. This framework is licensed 100% GPL as WordPress uses.

---

[![Donate to the framework](https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif "Donate to the framework")](https://www.paypal.me/yourabusufiyan)
