<?php
	/**
	*  Post Type 	: Location
	*	Description : 
	*
	*
	*/


	add_action( 'init', 'spice_location_register', 10 );
	function spice_location_register() {
		$labels = array(
			'name' 					=> _x( 'Locations', 'post type general name', 'SPICE' ),
			'singular_name' 		=> _x( 'Location', 'post type singular name', 'SPICE' ),
			'add_new'				=> _x( 'Add New', 'Location ', 'SPICE' ),
			'add_new_item'			=> esc_html__( 'Add Location', 'SPICE' ),
			'edit_item' 			=> esc_html__( 'Edit Location', 'SPICE' ),
			'new_item' 				=> esc_html__( 'New Location', 'SPICE' ),
			'all_items' 			=> esc_html__( 'All Locations', 'SPICE' ),
			'view_item' 			=> esc_html__( 'View Locations', 'SPICE' ),
			'search_items' 			=> esc_html__( 'Search Locations', 'SPICE' ),
			'not_found' 			=> esc_html__( 'No Location found', 'SPICE' ),
			'not_found_in_trash' 	=> esc_html__( 'No Location found in Trash', 'SPICE' ),		
			'parent_item_colon' 	=> ''
		);

		$args = array(
			'labels' 				=> $labels,
			'public' 				=> true,
			'publicly_queryable' 	=> true,
			'show_ui' 				=> true,
			'query_var' 			=> true,
			'rewrite' 				=> apply_filters( 'sp_location_posttype_rewrite_args', array( 'slug' => 'location', 'with_front' => false ) ),
			'capability_type' 		=> 'post',
			'hierarchical' 			=> false,
			'menu_position' 		=> null,
			'exclude_from_search'	=> true,	
			'menu_icon'				=> 'dashicons-location-alt',		
			'supports' 				=> array( 'title',)
		);

		register_post_type( 'location' , $args );
		flush_rewrite_rules();
	}

	/**** TO ADD NEW TYPE LAT LONG **/
	add_action( 'cmb2_render_lat_long', 'spice_lat_long', 10, 5 );
	function spice_lat_long( $field_args, $escaped_value, $object_id, $object_type, $field_type_object ) 
	{		
		global $post;		
		$lat_long=get_post_meta($post->ID,$field_args->args['id']);	
		if(empty($lat_long))
		{
			$lat_long[0]='-34.397, 150.644';
		}
		$latlng_arr=explode(',', $lat_long[0]);
		wp_enqueue_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?key='.GOOGLE_MAP_API_KEY.'&v=3.exp');
	    wp_enqueue_script( 'location-map', PLUGIN_PATH.'/js/location-map.js');
	    wp_localize_script( 'location-map', 'lat', $latlng_arr[0] ); 
	    wp_localize_script( 'location-map', 'long', $latlng_arr[1] ); 

	    echo '<div class="cmb-row cmb-type-text cmb2-id-location-text table-layout">';	
		echo '<div class="cmb-td">';	
		echo '<div id="googleMap" style="width:100%;height:380px;"></div>';
		echo '</div>';
		echo '<p class="cmb2-metabox-description">Drag and Drop the marker to get latitude and longitude</p>';
		echo '</div>';	

		echo '<div class="cmb-row cmb-type-text cmb2-id-location-text table-layout">';
		echo '<div class="cmb-th"><label for="location_text">Latitude and Longititude:</label></div>';
		echo '<div class="cmb-td">';
		echo $field_type_object->input( array( 'type' => 'text','id'=>'latlngbox','readonly'=>'readonly' ) );	
		echo '</div>';
		echo '</div>';

	}
	add_filter( 'cmb2_validate_lat_long', 'spice_cmb2_validate_lat_long' );
	function spice_cmb2_validate_lat_long( $override_value, $value ) 
	{   
	    return $value;
	}

	/****** ADD METABOX ******/
	add_action( 'cmb2_init', 'spice_location_metabox' );
	function spice_location_metabox() {

		// Start with an underscore to hide fields from custom fields list
		$prefix = 'spice_location_';
		$cmb_loc = new_cmb2_box( array(
			'id'            => $prefix . 'metabox',
			'title'         => esc_html__( 'Google Map', 'SPICE' ),
			'object_types'  => array( 'location' ), // Post type		
		) );
		
		$cmb_loc->add_field( array(
			'name' => esc_html__( '', 'SPICE' ),
			'desc' => esc_html__( 'Latitude and Longititude', 'SPICE' ),
			'id'   => $prefix . 'lat_long',
			'type' => 'lat_long',		
		) );
		$cmb_loc->add_field( array(
			'name'    => esc_html__( 'Infowindow Content', 'SPICE' ),
			'desc'    => esc_html__( 'Shows in Infowindow', 'SPICE' ),
			'id'      => $prefix . 'wysiwyg',
			'type'    => 'wysiwyg',
			'options' => array( 'textarea_rows' => 5, 'media_buttons' => false ),
		) );
		
	}

