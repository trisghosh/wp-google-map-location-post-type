<?php
	/*
	* Plugin Name: Location Post Type
	* Plugin URI: http://www.tristupghosh.com
	* Description: Post Type for Longitude and Latitude using Google Map.
	* Version: 1.0
	* Author: Tristup Ghosh
	* Author URI: http://www.tristupghosh.com
	*/

	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) exit;
	
	define('PLUGIN_PATH',plugins_url().'/location-post-type');
	define('GOOGLE_MAP_API_KEY','AIzaSyDhqMCGm_d7wgenIH1QWKzX3yiw0VSci9k');
	require_once( plugin_dir_path( __FILE__ ) . 'post-type/location-post-type.php');
