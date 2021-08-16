<?php
include 'shortcodes.php';
include 'read.php';

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/flashsales', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_flashsales',
        'args' => array() ,
    ));
});