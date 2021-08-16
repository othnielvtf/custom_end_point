<?php
function update_player_bookmark(WP_REST_Request $request)
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