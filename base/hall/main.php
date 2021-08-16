<?php

include 'read.php';

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/hall_priority', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_hall_priority',
        'args' => array() ,
    ));
});