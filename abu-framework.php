<?php if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly.

/**
 *
 * AbuFramework
 * 
 * @package   AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 * 
 * 
 * 
 * 
 * Plugin Name: AbuFramework
 * Plugin URI:  https://github.com/yourabusufiyan/abuframework/
 * Author:      Abu Sufiyan
 * Author URI:  http://abusufiyan.com/
 * Version:     1.0.3
 * Description: AbuFramework is Options Framework for WordPress themes and plugins.
 * Text Domain: AbuFramework
 * Domain Path: /languages
 * License:     GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * 
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * Copyright (C) 2020  Abu Sufiyan <abusufiyan@muslim.com>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 * 
 */


// This file very must be required.
require_once ( dirname( __FILE__ ) . '/required-functions.php' );

// Abu Framework Version
defined( 'ABU_MIN' )    or define( 'ABU_MIN', ( WP_DEBUG ? '' : '.min' ) );
defined( 'ABU_VER' )    or define( 'ABU_VER', '1.0.1' );
defined( 'ABU_PREFIX' ) or define( 'ABU_PREFIX', 'abu_options_' );

// Abu Framework dir
defined('ABU_DIR')      or define('ABU_DIR',      abu_get_located_path() );
defined('ABU_URI' )     or define('ABU_URI',      abu_get_located_path('uri'));


// Abu Framework assets
defined('ABU_CSS')      or define('ABU_CSS',     abu_dir( ABU_URI . 'assets/css/'));
defined('ABU_IMG')      or define('ABU_IMG',     abu_dir( ABU_URI . 'assets/img/'));
defined('ABU_JS')       or define('ABU_JS',      abu_dir( ABU_URI . 'assets/js/'));

defined('ABU_JSON')     or define('ABU_JSON',    abu_dir( ABU_DIR . 'assets/json/'));
defined('ABU_FUNC')     or define('ABU_FUNC',    abu_dir( ABU_DIR . 'functions/'));
defined('ABU_CLASSES')  or define('ABU_CLASSES', abu_dir( ABU_DIR . 'classes/'));
defined('ABU_FIELDS')   or define('ABU_FIELDS',  abu_dir( ABU_DIR . 'fields/'));
defined('ABU_CORE')     or define('ABU_CORE',    abu_dir( ABU_DIR . 'core/'));

// Init AbuFramework
abu_load_template('afw.class', ABU_CLASSES);


if( abu_ekey( 'AbuFrameworkDemo', get_option( 'AbuFrameworkOwn', [] ), 'no' ) === 'yes' ) {

    // Load Samples
    abu_load_template( 'sample/sample', ABU_DIR );

}