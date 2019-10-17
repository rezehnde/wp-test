<?php
require_once(__DIR__ . '/vendor/autoload.php');
$timber = new Timber\Timber();

add_theme_support( 'post-thumbnails' );
add_filter('show_admin_bar', '__return_false');

function wptest_enqueue_scripts() {
	// Loading styles...
	wp_enqueue_style( 'poppins', 'https://fonts.googleapis.com/css?family=Poppins:200,300,400,700,900|Display+Playfair:200,300,400,700' );
	$styles = array(
		'/assets/fonts/icomoon/style.css',
		'/assets/css/bootstrap.min.css',
		'/assets/css/magnific-popup.css',
		'/assets/css/jquery-ui.css',
		'/assets/css/owl.carousel.min.css',
		'/assets/css/owl.theme.default.min.css',
		'/assets/css/bootstrap-datepicker.css',
		'/assets/fonts/flaticon/font/flaticon.css',
		'/assets/css/aos.css',
		'/assets/css/style.css',
		'/style.css',
	);

	foreach ($styles as $style) {
		$style_name = str_replace('css', '', str_replace( "/assets/", '', $style));
		$style_name = sanitize_title($style_name);
		wp_enqueue_style( $style_name, get_template_directory_uri() . $style );
	}

	// Loading scripts...
	wp_enqueue_script( 'jquery-3.3.1', get_template_directory_uri() . '/assets/js/jquery-3.3.1.min.js', array(), false, false );
	$scripts = array(
		'jquery-migrate-3.0.1.min.js',
		'jquery-ui.js',
		'jquery.easing.1.3.js',
		'popper.min.js',
		'bootstrap.min.js',
		'owl.carousel.min.js',
		'jquery.stellar.min.js',
		'jquery.countdown.min.js',
		'jquery.magnific-popup.min.js',
		'bootstrap-datepicker.min.js',
		'aos.js',
		'main.js',
	);
	foreach ($scripts as $script) {
		wp_enqueue_script( str_replace('.min', '', str_replace('.js', '', $script)), get_template_directory_uri() . '/assets/js/'.$script, array('jquery-3.3.1'), false, true );
	}
}
add_action( 'wp_enqueue_scripts', 'wptest_enqueue_scripts' );

/**
 * Registering menu
 *
 * @return void
 */
function wptest_register_menu() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'wptest_register_menu' );

/**
 * Adding menu to Timber context
 *
 * @param $context
 * @return void
 */
function wptest_add_to_context( $context ) {
	$menu = new Timber\Menu( 'header-menu' );
	$context['menu'] = $menu;
	for ($i=1; $i <= 4; $i++) { 
		$context["footer_$i"] = Timber::get_widgets("footer_$i");
	}
    return $context;
}
add_filter( 'timber/context', 'wptest_add_to_context' );

/**
 * Transforming menu urls to support hashtags while browser internal pages
 *
 * @param $twig
 * @return void
 */
function wptest_add_to_twig( $twig ) {
    $twig->addFilter(
		new Timber\Twig_Filter( 'slugify', function( $url ) {
			if (!is_front_page() && $url != get_bloginfo('home').'/') {
				$url = get_bloginfo('home').'/'.$url;
			}
			return $url;
		})
	);
    return $twig;
}
add_filter( 'timber/twig', 'wptest_add_to_twig' );

/**
 * Including Widgets and Gutenberg Blocks
 */
include 'widgets/follow.php';
include 'widgets/newsletter.php';
include 'blocks.php';

/**
 * Subscription handler
 *
 * @return void
 */
function wptest_subscription_handler() {
	$email = $_POST['email_signup'];

	$subscription = get_page_by_title( $email, OBJECT, 'subscription' );
	if (!isset($subscription)) {
		$subscription = array(
			'post_title'	=> $email,
			'post_status'	=> 'publish',
			'post_type'		=> 'subscription'
		);
		wp_insert_post( $subscription );
	}
	wp_die();
}
add_action( 'wp_ajax_nopriv_wptest_subscription',  'wptest_subscription_handler' );
add_action( 'wp_ajax_wptest_subscription','wptest_subscription_handler' );

/**
 * Contact form handler
 *
 * @return void
 */
function wptest_contact_form_handler() {
	$fname 		= $_POST['cf_fname'];
	$lname 		= $_POST['cf_lname'];
	$email 		= $_POST['cf_email'];
	$subject 	= $_POST['cf_subject'];
	$message 	= $_POST['cf_message'];
	$email_to 	= $_POST['cf_email_to'];

	if (empty($email_to)) $email_to = get_option('admin_email');

	$headers = array('Content-Type: text/html; charset=UTF-8');
	$headers[] = 'Reply-To: '.$fname.' '.$lname.' <'.$email.'>';
	wp_mail( 
		$email_to,
		'['.get_bloginfo('name').'] '.$subject,
		$message.'<br/>---<br/>'.$fname.' '.$lname.'<br/>'.$email,
		$headers
	);

	wp_die();
}
add_action( 'wp_ajax_nopriv_wptest_contact_form', 'wptest_contact_form_handler' );
add_action( 'wp_ajax_wptest_contact_form','wptest_contact_form_handler' );

/**
 * Creating four sidebars at footer
 *
 * @return void
 */
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

/**
 * Adding customize options to theme customization inside Appearance menu
 *
 * @param WP_Customize_Manager $wp_customize
 * @return void
 */
function wptest_customize_register( $wp_customize ) {
	/** Copyright notice */
    $wp_customize->add_setting( 'wptest_copyright', array( 'default' => 'Customize your copyright notice.') );
    $wp_customize->add_control(
        'wptest_copyright',
        array(
            'label'     => 'Copyright notice',
            'type'      => 'text',
            'section'   => 'title_tagline',
        )
	);
	/* Logo */
    $wp_customize->add_setting( 'wptest_logo', array( 'default' => '' ) );
    $wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'logo',
			array(
				'label'      => 'Upload a logo',
				'section'    => 'title_tagline',
				'settings'   => 'wptest_logo',
			)
		)
	);
	/* Logo Fixed Header */
    $wp_customize->add_setting( 'wptest_logo_alt', array( 'default' => '' ) );
    $wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'logo_alt',
			array(
				'label'      => 'Upload an alternate logo',
				'section'    => 'title_tagline',
				'settings'   => 'wptest_logo_alt',
			)
		)
	);
}
add_action( 'customize_register', 'wptest_customize_register' );

/**
 * Retrieve an array response from the HTTP request using the GET method.
 *
 * @param string $url
 * @param boolean $shuffle
 * @return void
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

/**
 * Registering custom post types
 *
 * @return void
 */
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
