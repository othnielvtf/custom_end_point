<?php
include 'shortcodes.php';
include 'read.php';
include 'create.php';
include 'delete.php';
include 'update_data.php';

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/booths', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_booths',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/get_liked_booths', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_liked_booths',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/create_liked_booth', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'create_liked_booth',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/delete_liked_booth', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'delete_liked_booth',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/create_drop_name_card', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'create_drop_name_card',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/get_promocodes', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_promocodes',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/create_promocode', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'create_promocode',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/get_bookmarks', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_player_bookmarks',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/create_bookmark', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'create_player_bookmark',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/update_bookmark', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'update_player_bookmark',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/delete_bookmark', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'delete_bookmark',
        'args' => array() ,
    ));
});