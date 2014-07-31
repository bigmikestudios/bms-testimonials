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

function bms_testimonial_check_required_plugin() {
    if ( class_exists( 'acf' ) || !is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        return;
    }

    require_once ABSPATH . '/wp-admin/includes/plugin.php';
    deactivate_plugins( __FILE__ );

    $msg =  __( 'BMS Testimonials has been deactivated as it requires the <a href="http://www.advancedcustomfields.com/">Advanced Custom Fields</a> plugin.', 'bms_testimonials' ) . '<br /><br />';
    
    if ( file_exists( WP_PLUGIN_DIR . '/advanced-custom-fields/acf.php' ) ) {
        $activate_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=advanced-custom-fields/acf.php', 'activate-plugin_advanced-custom-fields/acf.php' );
        $msg .= sprintf( __( 'It appears to already be installed. <a href="%s">Click here to activate it.</a>', 'bms_testimonials' ), $activate_url );
    }
    else {
        $download_url = 'http://downloads.wordpress.org/plugin/advanced-custom-fields.zip';
        $msg .= sprintf( __( '<a href="%s">Click here to download a zip of the latest version.</a> Then install and activate it. ', 'bms_testimonials' ), $download_url );
    }

    $msg .= '<br /><br />' . __( 'Once it has been activated, you can activate BMS Testimonials.', 'bms_testimonials' );

    wp_die( $msg );
}

add_action( 'plugins_loaded', 'bms_testimonial_check_required_plugin' );

// =============================================================================

//////////////////////////
//
// CUSTOM POST TYPES
//
//////////////////////////


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
        
        'supports' => array( 'title', 'editor'),
        
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

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_testimonial-field-group',
		'title' => 'Testimonial Field Group',
		'fields' => array (
			array (
				'key' => 'field_53b45c35a796f',
				'label' => 'Who said it?',
				'name' => 'who',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_53b45e57a7971',
				'label' => 'What\'s their title?',
				'name' => 'title',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_53b45e47a7970',
				'label' => 'Who do they work with?',
				'name' => 'organization',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_53b45e7da7972',
				'label' => 'Do they have a website?',
				'name' => 'company_url',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'testimonial',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
