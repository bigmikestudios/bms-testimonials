<?php
/**
 * @package BMS_Testimonials
 * @author Mike Lathrop
 * @version 0.0.1
 */
/*
Plugin Name: BMS Testimonials
Plugin URI: http://bigmikestudios.com
Depends: bms-smart-meta-box/bms_smart_meta_box.php
Description: Adds a 'Testimonial' post type and widget
Version: 0.0.1
Author URI: http://bigmikestudios.com
*/

$cr = "\r\n";

// =============================================================================

//////////////////////////
//
// INCLUDES
//
//////////////////////////

//wp_register_style('bms_people', plugins_url() .'/bms_people/bms_people.css');
//wp_enqueue_style('bms_people');


// =============================================================================

//////////////////////////
//
// CUSTOM POST TYPES
//
//////////////////////////

add_action( 'init', 'register_cpt_testimonial' );

add_action( 'init', 'register_cpt_testimonial' );

function register_cpt_testimonial() {

    $labels = array( 
        'name' => _x( 'Testimonials', 'testimonial' ),
        'singular_name' => _x( 'testimonial', 'testimonial' ),
        'add_new' => _x( 'Add New', 'testimonial' ),
        'add_new_item' => _x( 'Add New testimonial', 'testimonial' ),
        'edit_item' => _x( 'Edit testimonial', 'testimonial' ),
        'new_item' => _x( 'New testimonial', 'testimonial' ),
        'view_item' => _x( 'View testimonial', 'testimonial' ),
        'search_items' => _x( 'Search testimonials', 'testimonial' ),
        'not_found' => _x( 'No testimonials found', 'testimonial' ),
        'not_found_in_trash' => _x( 'No testimonials found in Trash', 'testimonial' ),
        'parent_item_colon' => _x( 'Parent testimonial:', 'testimonial' ),
        'menu_name' => _x( 'Testimonials', 'testimonial' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title'),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'testimonial', $args );
}

// =============================================================================

//////////////////////////
//
// ADD META BOX
//
//////////////////////////

if (is_admin()) {
	if (!class_exists('SmartMetaBox')) {
		require_once(ABSPATH . "wp-content/plugins/bms-smart-meta-box/SmartMetaBox.php");
	}
			
	new SmartMetaBox('quote', array(
		'title'     => 'Quote',
		'pages'     => array('testimonial'),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
				'name' => 'Quote',
				'id' => 'quote',
				'type' => 'textarea',
			),
			array(
				'name' => 'Credit Name',
				'id' => 'credit_name',
				'type' => 'text',
			),
			array(
				'name' => 'Credit Location',
				'id' => 'credit_loc',
				'type' => 'text',
			),
		)
	));
	
}

	
// =============================================================================

//////////////////////////
//
// ADD IMAGE SIZES
//
//////////////////////////

//add_image_size( '75x75', 75, 75, true );
//add_image_size( '150x9999', 150, 9999 );



// =============================================================================

//////////////////////////
//
// SHORT CODES
//
//////////////////////////

// create shortcode for listing:
function bms_testimonial_listing($atts, $content=null) {
	extract( shortcode_atts( array(
		'foo' => 'something',
		'bar' => 'something else',
	), $atts ) );
	
	$return="<ul class='bms-people-listing'>";
	$i = 0;
	
	// get posts
	$args = array('post_type'=>'person', 'orderby'=>'menu_order', 'order'=>'ASC');
	$my_posts = get_posts($args);
	foreach($my_posts as $my_post) {
		$img = get_post_meta($my_post->ID, '_smartmeta_bms_people_image', true);
		$img = wp_get_attachment_image_src( $img, '75x75');
		$img_src	=$img[0];
		$img_width	=$img[1];
		$img_height	=$img[2];	
		
		$title = get_post_meta($my_post->ID, '_smartmeta_bms_people_title', true);
		
		$return .= "<li class='bms-people person-".$my_post->ID."'>"."\r\n";
		$return .= "<a href='".get_permalink($my_post->ID)."'>"."\r\n";
		$return .= "<img src='$img_src' width='$img_width' height='$img_height' alt='image' />"."\r\n";
		$return .= "<span class='bms-people-name'>".$my_post->post_title."</span> "."\r\n";
		if (!empty($title)) $return .= "<span class='bms-people-title'>".$title."</span>"."\r\n";
		$return .= "</a>"."\r\n";
		$return .= "</li>"."\r\n";
		$i++;
	}
	$return .="</ul>";
	
	return $return;
}

