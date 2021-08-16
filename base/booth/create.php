<?php
function create_liked_booth(WP_REST_Request $request)
{
    global $wpdb;
    
    $has_error = true;
    $error_text = "User not exist!";
    
    $request_array = json_decode($request->get_body(), true);

    $result = 0;
    
    if (!empty($request_array["user_id"]))
    {
        $user = get_user_by('id', $request_array["user_id"]);
        
        if($user)
        {
            $has_error = false;
            
            $data = array(
                    'user_id' => $request_array["user_id"],
                    'booth_id' => $request_array["booth_id"],
                    'vendor_id' => $request_array["vendor_id"],
                );
        
            $result = $wpdb->insert("player_booth_likes", $data);
        }
    }

    if (is_wp_error($result))
    {
        $error = $result->get_error_message();

        return ['status' => 'error', 'code' => '401', 'message' => $error ];
    }
    else if($has_error)
    {
        return ['status' => 'error', 'code' => '401', 'message' => $error_text ];
    }
    else
    {
        $user = get_user_by('id', $result);

        return [$user];
    }
}

function create_drop_name_card(WP_REST_Request $request)
{
    global $wpdb;
    
    $has_error = true;
    $error_text = "User not exist!";
    
    $request_array = json_decode($request->get_body(), true);

    $result = 0;
    
    if (!empty($request_array["user_id"]))
    {
        $user = get_user_by('id', $request_array["user_id"]);
        
        if($user)
        {
            $has_error = false;
            
            $data = array(
                    'user_id' => $request_array["user_id"],
                    'booth_id' => $request_array["booth_id"],
                    'vendor_id' => $request_array["vendor_id"],
                    'player_name' => $request_array["player_name"],
                    'company_name' => $request_array["company_name"],
                    'job_title' => $request_array["job_title"],
                    'mobile_number' => $request_array["mobile_number"],
                    'email' => $request_array["email"],
                );
        
            $result = $wpdb->insert("player_booth_name_cards", $data);
        }
    }

    if (is_wp_error($result))
    {
        $error = $result->get_error_message();

        return ['status' => 'error', 'code' => '401', 'message' => $error ];
    }
    else if($has_error)
    {
        return ['status' => 'error', 'code' => '401', 'message' => $error_text ];
    }
    else
    {
        $user = get_user_by('id', $result);

        return [$user];
    }
}

function create_promocode(WP_REST_Request $request)
{
    global $wpdb;
    
    $has_error = true;
    $error_text = "User not exist!";
    
    $request_array = json_decode($request->get_body(), true);

    $result = 0;
    
    if (!empty($request_array["user_id"]))
    {
        $user = get_user_by('id', $request_array["user_id"]);
        
        if($user)
        {
            $has_error = false;
            
            $data = array(
                    'user_id' => $request_array["user_id"],
                    'booth_id' => $request_array["booth_id"],
                    'vendor_id' => $request_array["vendor_id"],
                    'promocode' => $request_array["promocode"],
                    'promocode_url' => $request_array["promocode_url"],
                );
        
            $result = $wpdb->insert("player_promocodes", $data);
        }
    }

    if (is_wp_error($result))
    {
        $error = $result->get_error_message();

        return ['status' => 'error', 'code' => '401', 'message' => $error ];
    }
    else if($has_error)
    {
        return ['status' => 'error', 'code' => '401', 'message' => $error_text ];
    }
    else
    {
        $user = get_user_by('id', $result);

        return [$user];
    }
}

function create_player_bookmark(WP_REST_Request $request)
{
    global $wpdb;
    
    $has_error = true;
    $error_text = "User not exist!";
    
    $request_array = json_decode($request->get_body(), true);

    $result = 0;
    
    if (!empty($request_array["user_id"]))
    {
        $user = get_user_by('id', $request_array["user_id"]);
        
        if($user)
        {
            $has_error = false;
            
            $data = array(
                    'user_id' => $request_array["user_id"],
                    'booth_id' => $request_array["booth_id"]
                );
        
            $result = $wpdb->insert("player_bookmarks", $data);
        }
    }

    if (is_wp_error($result))
    {
        $error = $result->get_error_message();

        return ['status' => 'error', 'code' => '401', 'message' => $error ];
    }
    else if($has_error)
    {
        return ['status' => 'error', 'code' => '401', 'message' => $error_text ];
    }
    else
    {
        $user = get_user_by('id', $result);

        return [$user];
    }
}