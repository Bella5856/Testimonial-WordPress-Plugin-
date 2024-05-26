<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$posts = get_posts(array('post_type' => 'testimonials', 'number_posts' => -1));

foreach ($posts as $post) {
    wp_delete_post($book->ID, true);
}