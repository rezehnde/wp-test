<?php
$context = Timber::context();
$context['post'] = new Timber\Post();
$context['people'] = Timber::get_posts( 'post_type=people&numberposts=3' );
$context['services'] = Timber::get_posts( 'post_type=services&numberposts=6' );
$context['industries'] = wptest_remote_get( 'https://jsonplaceholder.typicode.com/photos', true );
$context['testimonials'] = Timber::get_posts( 'post_type=testimonials&numberposts=3' );
$context['latestposts'] = Timber::get_posts( 'post_type=post&numberposts=3' );
$context['is_front'] = is_front_page();
$context['footer_1'] = Timber::get_widgets('footer_1');
$context['footer_2'] = Timber::get_widgets('footer_2');
$context['footer_3'] = Timber::get_widgets('footer_3');
$context['footer_4'] = Timber::get_widgets('footer_4');
Timber::render('views/front-page.twig', $context);
