<?php
$context = Timber::context();
$context['posts'] = Timber::get_posts();
$context['footer_1'] = Timber::get_widgets('footer_1');
$context['footer_2'] = Timber::get_widgets('footer_2');
$context['footer_3'] = Timber::get_widgets('footer_3');
Timber::render('templates/index.twig', $context);

