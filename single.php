<?php
$context = Timber::context();
$context['post'] = Timber::get_post();
$template = (get_post_type() == 'post') ? 'single' : 'single-'.get_post_type();
$context['footer_1'] = Timber::get_widgets('footer_1');
$context['footer_2'] = Timber::get_widgets('footer_2');
$context['footer_3'] = Timber::get_widgets('footer_3');
Timber::render('templates/'.$template.'.twig', $context);

