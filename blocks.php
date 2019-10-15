<?php
function wptest_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'wptest',
				'title' => 'WP-Test',
			),
		)
	);
}
add_filter( 'block_categories', 'wptest_block_category', 10, 2);

function wptest_block_editor_style() {
    wp_enqueue_style( 'icomoon_style_block_css', get_template_directory_uri() . '/assets/fonts/icomoon/style.css' );
	wp_enqueue_style( 'bootstrap_style_block_css', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'jquery_style_block_css', get_template_directory_uri() . '/assets/css/jquery-ui.css' );
	wp_enqueue_style( 'flaticon_style_block_css', get_template_directory_uri() . '/assets/fonts/flaticon/font/flaticon.css' );
	wp_enqueue_style( 'css_style_block_css', get_template_directory_uri() . '/assets/css/style.css' );
	wp_enqueue_style( 'style_block_css', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'style_editor_block_css', get_template_directory_uri() . '/style-editor.css' );
}
add_action( 'enqueue_block_assets', 'wptest_block_editor_style' );

function wptest_block_render_callback( $block, $content = '', $is_preview = false ) {
	$slug = str_replace('acf/', '', $block['name']);
	$context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
	$context['is_preview'] = $is_preview;
	
	switch ( $slug ) {
		case 'team':
			$context['people'] = Timber::get_posts( 'post_type=people&numberposts=3' );
			break;
		case 'services':
			$context['services'] = Timber::get_posts( 'post_type=services&numberposts=6' );
			break;
		case 'industries':
			$context['industries'] = wptest_remote_get( 'https://jsonplaceholder.typicode.com/photos', true );
			break;
		case 'testimonial':
			$context['testimonials'] = Timber::get_posts( 'post_type=testimonials&numberposts=3' );
			break;
		case 'blog':
			$context['blog'] = Timber::get_posts( 'post_type=post&numberposts=3' );
			break;
	}

    Timber::render( 'views/blocks/'.$slug.'.twig', $context );	
}

function wptest_register_block() {
	if( function_exists('acf_register_block') ) {
		$blocks = array(
			array( 'name' => 'hero', 'icon' => 'slides' ),
			array( 'name' => 'about', 'icon' => 'admin-comments' ),
			array( 'name' => 'steps', 'icon' => 'editor-ol-rtl' ),
			array( 'name' => 'team', 'icon' => 'groups' ),
			array( 'name' => 'services', 'icon' => 'star-empty' ),
			array( 'name' => 'industries', 'icon' => 'chart-bar' ),
			array( 'name' => 'vimeo', 'icon' => 'format-video' ),
			array( 'name' => 'testimonial', 'icon' => 'editor-quote' ),
			array( 'name' => 'blog', 'icon' => 'edit' ),
			array( 'name' => 'contact', 'icon' => 'email-alt' ),
		);

		foreach ($blocks as $block) {
			acf_register_block(array(
				'name'				=> $block['name'],
				'title'				=> ucfirst($block['name']),
				'description'		=> 'A custom '.$block['name'].' block.',
				'render_callback'	=> 'wptest_block_render_callback',
				'category'			=> 'wptest',
				'icon'				=> $block['icon'],
				'keywords'			=> array( $block['name'] ),
			));
		}
	}
}
add_action('acf/init', 'wptest_register_block');
