<?php
include 'create.php';

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/create_order', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'create_order',
        'args' => array() ,
    ));
});

add_action('rest_api_init', function ()
{
    register_rest_route('api', '/temp_login', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'temp_login',
        'args' => array() ,
    ));
});

add_action('init',function() 
{ 
	if(isset($_GET['token']))
	{
	    $is_api = -1;

	    if(isset($_GET['api']))
	    {
	        $is_api = $_GET['api'];
	    }
	    
	    if($is_api != -1)
	    {
	        $r = new WP_REST_Request( 'POST', '/jwt-auth/v1/token/validate');
    		$_SERVER['REDIRECT_HTTP_AUTHORIZATION'] = 'Bearer '.$_GET['token'];	
    		
    		$response = rest_do_request($r); //if token is valid, the user will be loggedin after that	
    
    		if($is_api == 1)
    		{
    		    add_filter('jwt_auth_valid_token_response',function($response, $user, $token, $payload)
        		{
        			if($response['success'] === true)
        			{
        				wp_set_auth_cookie($payload->data->user->id, true, is_ssl());						
        				wp_redirect(remove_query_arg('token',false));
        				die();
        			}
        			
        			return $response;
        		},10,4);
    		}
    		else if($is_api ==0)
    		{
    		    $user_id = -1;
    		    
    		    if(isset($_GET['token_id']))
    		    {
    		        $user_id = base64_decode($_GET['token_id']);
    		    }
    
    		    if($response->data["data"]["status"] == 200)
                {
                    wp_set_auth_cookie($user_id, true, is_ssl());	
                    wp_redirect(remove_query_arg('token',false));
    				die();
                }
    		}
	    }
	}
});