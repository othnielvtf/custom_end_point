<?php
include 'create.php';
include 'read.php';
include 'update_data.php';
//include 'delete.php';

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/authenticate_user', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_user_info_by_email',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/authenticate', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_user_info_by_token',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/test_auth', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'generate_auth',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/authenticate_user_by_username', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_user_info_by_username',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/register_user', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'register_user',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/update_user_fields', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'update_user_fields',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/get_missions', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_missions',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/get_user_mission', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_user_mission',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/create_player_mission', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'create_player_mission',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/update_player_mission', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'update_player_mission',
        'args' => array() ,
    ));
});