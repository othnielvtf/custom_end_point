<?php
include 'read.php';
include 'create.php';

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/get_treasures', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_treasures',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/create_treasure', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'create_treasure',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/schedule_event', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_schedule_event',
        'args' => array() ,
    ));
});