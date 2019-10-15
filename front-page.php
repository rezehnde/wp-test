<?php
$context = Timber::context();
$context['post'] = new Timber\Post();

$context['is_front'] = is_front_page();
$context['footer_1'] = Timber::get_widgets('footer_1');
$context['footer_2'] = Timber::get_widgets('footer_2');
$context['footer_3'] = Timber::get_widgets('footer_3');
$context['footer_4'] = Timber::get_widgets('footer_4');
Timber::render('views/front-page.twig', $context);
