<?php
function create_feedback(WP_REST_Request $request)
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
                    'description' => $request_array["description"],
                    'coordinate_x' => $request_array["coordinate_x"],
                    'coordinate_y' => $request_array["coordinate_y"],
                    'coordinate_z' => $request_array["coordinate_z"]
                );
        
            $result = $wpdb->insert("player_feedbacks", $data);
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