<?php  if ( !defined( 'ABSPATH' ) ) { die(); } // Can't access pages directly
/**
 * AbuFramework Main CLASS from AbuFramework
 * @since 1.0.0
 * @version 1.0.0
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

abstract class AbuFramework {

  protected $output_css = 'AbuFramework';

  public function __construct() {
    
    // Check for embed custom css styles
    if( isset($this->settings['output_css']) && $this->settings['output_css'] ) {
      add_action( 'wp_head', array( &$this, 'wp_head' ), 100 );
    }

  }

  public function wp_head() {
    echo '<style type="text/css" id="' . $this->settings['framework_id'] . '">'.  $this->settings['output_css'] . ' cssworkings </style>';
  }


}
