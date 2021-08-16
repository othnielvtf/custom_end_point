<?php
include 'read.php';

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/schedule_notification', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_schedule_notification',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/get_server_time', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_server_time',
        'args' => array() ,
    ));
});