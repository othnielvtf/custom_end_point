<?php
function create_treasure(WP_REST_Request $request)
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
                    'treasure_id' => $request_array["treasure_id"],
                    'event_id' => $request_array["event_id"],
                    'user_id' => $request_array["user_id"],
                    'player_name' => $request_array["player_name"],
                    'company_name' => $request_array["company_name"],
                    'job_title' => $request_array["job_title"],
                    'mobile_number' => $request_array["mobile_number"],
                    'email' => $request_array["email"]
                );
        
            $result = $wpdb->insert("treasures", $data);
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