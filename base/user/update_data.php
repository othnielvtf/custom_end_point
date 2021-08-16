<?php
function update_user_fields(WP_REST_Request $request)
{
    global $wpdb;
    
    $has_error = false;
    $error_text = "";
    
    $request_array = json_decode($request->get_body(), true);
    
    if (!empty($request_array["id"]))
    {
        foreach ($request_array as $key => $val)
        {
            if($val["meta"])
            {
                if($val["update"])
                {
                    $result = update_user_meta($request_array["id"], $key, $val["value"]);
                    
                    if(is_wp_error($result))
                    {
                        $has_error = true;
                        $error_text = $result->get_error_message();//"Error in ".$key;
                    }
                }
            }
        }
    }

    if ($has_error)
    {
        return ['status' => 'error', 'code' => '401', 'message' => $error_text];
    }
    else
    {
        $user = get_user_by('id', $request_array["id"]);
        
        return ['status' => 'success', 'code' => '200', 'message' => " Successful!",
        'callback' => $user];
    }
}

function update_player_mission(WP_REST_Request $request)
{
    global $wpdb;
    
    $has_error = true;
    $error_text = "User not exist!";
    
    $request_array = json_decode($request->get_body(), true);

    $result = 0;
    
    if (!empty($request_array["user_id"]))
    {
        $id = $request_array["id"];
        $user = get_user_by('id', $request_array["user_id"]);
        
        if($user)
        {
            $has_error = false;
            
            $data = array(
                    'value' => $request_array["value"],
                    'completed' => $request_array["completed"],
                );
        
            $result = $wpdb->update("player_missions", $data, array('id'=>$id));
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