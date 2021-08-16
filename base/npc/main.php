<?php
//include 'create.php';
include 'read.php';
//include 'update.php';
//include 'delete.php';

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/get_npcs_by_hall', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_npcs_by_hall',
        'args' => array() ,
    ));
});