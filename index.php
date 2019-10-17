<?php
$context = Timber::context();

if (is_singular())
    $context['post'] = new Timber\Post();
else 
    $context['posts'] = Timber::get_posts();

Timber::render('views/index.twig', $context);

