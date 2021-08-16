<?php
include 'report.php';

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/mission_report', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'generate_mission_report_data',
        'args' => array() ,
    ));
});