<?php
$context = Timber::context();
$context['post'] = Timber::get_post();
$template = (get_post_type() == 'post') ? 'single' : '-'.get_post_type();
Timber::render('templates/single'.$template.'.twig', $context);

