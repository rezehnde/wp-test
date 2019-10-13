<?php
require_once(__DIR__ . '/vendor/autoload.php');
$timber = new Timber\Timber();

add_theme_support( 'post-thumbnails' ); 

include 'widgets/follow.php';

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

function wptest_customize_register( $wp_customize ) {
    $wp_customize->add_section(
        'wptest_customize_options',
        array(
            'title'      => 'WP-Test Customization',
            'priority'   => 30,
        )
    );
    $wp_customize->add_setting(
        'wptest_copyright',
        array(
            'default'   => 'Teste',
        )
    );
    $wp_customize->add_control(
        'wptest_copyright',
        array(
            'label'     => __( 'Copyright notice', 'wp-test' ),
            'type'      => 'text',
            'section'   => 'title_tagline',
        )
    );
}
add_action( 'customize_register', 'wptest_customize_register' );

/*
 * Retrieve an array response from the HTTP request using the GET method.
 *
 * @param STRING  $url
 * @param boolean $shuffle  Returns and random array
 * @return ARRAY
 */
function wptest_remote_get( $url, $shuffle = false )
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

function wptest_register_my_cpts() {

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

	/**
	 * Post Type: Testimonials.
	 */

	$labels = array(
		"name" => __( "Testimonials", "custom-post-type-ui" ),
		"singular_name" => __( "Testimonial", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Testimonials", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => false,
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
		"rewrite" => array( "slug" => "testimonials", "with_front" => true ),
		"query_var" => true,
		"menu_icon" => "dashicons-awards",
		"supports" => array( "title", "thumbnail" ),
	);

	register_post_type( "testimonials", $args );

	/**
	 * Post Type: Subscriptions.
	 */

	$labels = array(
		"name" => __( "Subscriptions", "custom-post-type-ui" ),
		"singular_name" => __( "Subscription", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Subscriptions", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => false,
		"publicly_queryable" => false,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => false,
		"query_var" => true,
		"menu_icon" => "dashicons-buddicons-pm",
		"supports" => array( "title" ),
	);

	register_post_type( "subscription", $args );
}
add_action( 'init', 'wptest_register_my_cpts' );
