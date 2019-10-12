<?php
$context = Timber::context();
$context['post'] = new Timber\Post();
$context['people'] = Timber::get_posts( 'post_type=people&numberposts=3' );
$context['services'] = Timber::get_posts( 'post_type=services&numberposts=6' );
$context['industries'] = remote_get( 'https://jsonplaceholder.typicode.com/photos', true );
$context['testimonials'] = Timber::get_posts( 'post_type=testimonials&numberposts=3' );
$context['latestposts'] = Timber::get_posts( 'post_type=post&numberposts=3' );
$context['is_front'] = is_front_page();
Timber::render('templates/front-page.twig', $context);
