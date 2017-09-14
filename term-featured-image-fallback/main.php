<?php
/*
 * Plugin Name: Term Featured Image Fallback
 * Description: Add a featured image to categories, tags and other taxonomies and use it as a fallback featured image for posts of any post type.
 * Text Domain: term-featured-image-fallback
 * Domain Path: /languages 
 * Version: 1.0.4.1
 * Author: Eduardo Lazaro
 * Author URI: https://www.kenodo.com/
 * Support URI: https://www.kenodo.com/contact
 * Plugin URI: https://www.kenodo.com/projects

 * Copyright 2017 Eduardo Lazaro [Kenodo]
 *
 * This Plugin is open source and free software:
 * You can redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option)
 * any later version. 
 *    
 * This Plugin is distributed in the hope that
 * it will be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 * PURPOSE. See the GNU General Public License for more details. 
 *
 * You should have received a copy of the GNU General Public License
 * along with WordPress. If not, see <http://www.gnu.org/licenses/>. 
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

/* 
 * N: Plugin activation
 * D: Check WP and PHP version
 * @since 1.0.0
 */ 
function cs__tfi_activation() {
	$wp = '4.3.0'; $php = '5.4.0';
    global $wp_version;
    if ( version_compare( PHP_VERSION, $php, '<' ) ) {
		$flag = 'PHP';
		deactivate_plugins( dirname(__FILE__) );
	}
	else if (version_compare($wp_version,  $wp, '<' )) { 
		$flag = 'WordPress';
	}
	else {  return; }
    $version = 'PHP' == $flag ? $php : $wp;
	deactivate_plugins( plugin_basename( __FILE__ ) ) ;
    wp_die('<p>The <strong>Term Featured Image Fallback</strong> plugin requires '.$flag.'  version '.$version.' or greater.</p>','Plugin Activation Error',  array( 'response'=>200, 'back_link'=>TRUE ) );
}
register_activation_hook( __FILE__, 'cs__tfi_activation' );	
 
require_once( plugin_dir_path( __FILE__ ) . 'core/metatraits.php'); // Include general plugin framework metatraits
require_once( plugin_dir_path( __FILE__ ) . 'core/helpers.php'); // Include general plugin framework helper functions

/**
 * N: cs__tfi
 * D: Main Plugin class
 * @class       cs__tfi
 * @version     1.1.0
 * @author      Eduardo Lazaro
 */
class cs__tfi {

	use cs__metatrait;
	

	
	private static $_instance;
	private $name = 'term-featured-image-fallback';
	private $version = '1.0.0';
	private $dir;
	private $url;

	/* 
	 * N: Construct
	 * D: This function also loads main class methods placed in other files
	 * @since 1.0.0
	 */				
	function __construct() {
		$this->dir = plugin_dir_path( __FILE__ );
		$this->url = plugins_url( __FILE__ );
		$this->load_plugin_textdomain();
		$scan = preg_grep('/^([^.])/', scandir($this->dir . 'methods'));
		foreach($scan as $file){
			require_once($this->dir . 'methods/'.$file);	
		}
	}

	/* 
	 * N: Clone
	 * D: Redefines clone method [singleton]
	 * @since 1.0.0
	 */				
	private function __clone(){} 

	/* 
	 * N: Get Instance
	 * D: A global instance of the class. Used to retrieve the instance [singleton]
	 * @since 1.0.0
	 * @return Object self::$_instance Instance of the class.
	 */				
	public static function getInstance(){
		if (!(self::$_instance instanceof self)){ 
			self::$_instance=new self(); 
		}
		return self::$_instance; 
	} 	

	/* 
	 * N: Get Plugin Textdomain
	 * D: Returns the plugin text domain which name is the main class name
	 * @since 1.0.0
	 * @return String $this->name Text domain
	 */				
	public function get_plugin_text_domain() {
		return $this->name;
	}

	/* 
	 * N: Load Plugin Textdomain
	 * D: Loads the text domain which name is the main class name
	 * @since 1.0.0
	 */			
	public function load_plugin_textdomain() {		
		$languages_path = plugin_basename( dirname(__FILE__).'/languages' );
		load_plugin_textdomain( $this->name, false, $languages_path );
	}

	/* 
	 * N: Get Option
	 * D: Returns an option in the array of options stored as a single WP option
	 * @since 1.0.0
	 */		
	public function get_option( $name, $default = false ) {
		$option = get_option( __class__ );
		if ( false === $option ) { return $default; }
		if ( isset( $option[$name] ) ) { return $option[$name];	} else { return $default; }
	}

	/* 
	 * N: Update Option
	 * D: Updates an element in the array of options used for this plugin and stored as a WP unique option
	 * D: The option name is the same as the class name.
	 * @since 1.0.0
	 */		
	public function update_option( $name, $value ) {
		$option = get_option( __class__ );
		$option = ( false === $option ) ? array() : (array) $option;
		$option = array_merge( $option, array( $name => $value ) );
		update_option( __class__, $option );
	}
	
	/* 
	 * N: Plugin deactivation
	 * D: Deletes options and post meta data
	 * @since 1.0.0
	 */	
	public function deactivation() {
		if ( ! current_user_can( 'activate_plugins' ) ) { return; }
		$delete_data = $this->get_option('delete_data');
		if($delete_data){
			$taxonomies = get_taxonomies();
			if(count($taxonomies)){
				foreach($taxonomies as $taxonomy){
					$terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);
						
					if(count($terms)){				
						foreach($terms as $term){		
							delete_term_meta($term->term_id, 'cs__featured_image_id') ;
							delete_term_meta($term->term_id, 'cs__featured_image_priority');
						}
					}
				}
			}
			delete_option(__class__);
			delete_site_option(__class__);
		}
	}		
}

cs__requireFilesOnce(plugin_dir_path( __FILE__ ) . 'modules'); // Extra code and libraries
cs__requireFilesOnce(plugin_dir_path( __FILE__ ) . 'functions'); // Load other functions
	
$cs__tfi = cs__tfi::getInstance();
register_deactivation_hook( __FILE__, array( $cs__tfi, 'deactivation' ) );