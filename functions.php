<?php
require_once(__DIR__ . '/vendor/autoload.php');
$timber = new Timber\Timber();

add_theme_support( 'post-thumbnails' ); 

include 'settings.php';
include 'custom-widgets.php';

function wptest_widgets_init() {
	for ($i=1; $i <= 4; $i++) { 
		register_sidebar(
			array(
				'name' 			=> 'Footer Column '.$i,
				'id' 			=> 'footer_'.$i,
				'description' 	=> 'Widgets in this area will be shown on all posts and pages.',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => "<h2 class='footer-heading mb-4'>",
				'after_title'   => "</h2>\n",
			)
		);	
	}
}
add_action( 'widgets_init', 'wptest_widgets_init' );

/*
 * Retrieve an array response from the HTTP request using the GET method.
 *
 * @param STRING  $url
 * @param boolean $shuffle  Returns and random array
 * @return ARRAY
 */
function remote_get( $url, $shuffle = false )
{
    $request = wp_remote_get( $url );
    if( is_wp_error( $request ) ) {
        return array();
    }
    $body = wp_remote_retrieve_body( $request );
    $body = json_decode( $body, true );
    if ( $shuffle ) shuffle( $body );
    return $body;
}

function aboutus_block() {
    wp_enqueue_script(
        'aboutus-block',
        get_template_directory_uri() . '/aboutus-block.js',
        array('wp-blocks','wp-editor'),
        true
    );
}
// add_action('enqueue_block_editor_assets', 'aboutus_block');

function cptui_register_my_cpts() {

	/**
	 * Post Type: People.
	 */

	$labels = array(
		"name" => __( "People", "custom-post-type-ui" ),
		"singular_name" => __( "Person", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "People", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "people", "with_front" => true ),
		"query_var" => true,
		"menu_icon" => "dashicons-groups",
		"supports" => array( "title", "editor", "thumbnail", "excerpt" ),
	);

	register_post_type( "people", $args );

	/**
	 * Post Type: Services.
	 */

	$labels = array(
		"name" => __( "Services", "custom-post-type-ui" ),
		"singular_name" => __( "Service", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Services", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "services", "with_front" => true ),
		"query_var" => true,
		"menu_icon" => "dashicons-sos",
		"supports" => array( "title", "editor", "thumbnail", "excerpt" ),
	);

	register_post_type( "services", $args );
}
add_action( 'init', 'cptui_register_my_cpts' );
