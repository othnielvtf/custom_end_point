<?php
function register_user(WP_REST_Request $request)
{
    $arr_request = json_decode($request->get_body());

    $result = 0;

    $user_field_parent_id = - 1;

    $query = new WP_Query(array(
        'post_type' => 'acf-field-group',
        'title' => 'User Avatar Info'
    ));

    if ($query->have_posts())
    {
        while ($query->have_posts())
        {
            $query->the_post();

            $user_field_parent_id = get_the_ID();
        }
    }

    wp_reset_postdata();

    $acf_fields = array();

    $query = new WP_Query(array(
        'post_type' => 'acf-field',
        'post_parent' => $user_field_parent_id
    ));

    if ($query->have_posts())
    {
        while ($query->have_posts())
        {
            $query->next_post();

            $post_data = array();
            $post_data[] = $query
                ->post->post_excerpt;
            $post_data[] = $query
                ->post->post_name;

            $acf_fields[] = $post_data;
        }
    }

    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    global $wpdb;

    $tablename = "custom_end_fields_setting";

    $main_sql_create = "CREATE TABLE custom_end_fields_setting (
	Id int(11) NOT NULL auto_increment,Group_type text ,Parent_id text ,
  Post_excerpt text ,Post_name text,PRIMARY KEY  (Id));";

    maybe_create_table($tablename, $main_sql_create);

    $table = 'custom_end_fields_setting';

    $rowcount = $wpdb->get_var('SELECT COUNT(*) FROM ' . $table . ' WHERE Group_type = "User Avatar Info" ');

    if (count($acf_fields) <> $rowcount)
    {
        $wpdb->delete($table, array(
            'Group_type' => 'User Avatar Info'
        ));

        foreach ($acf_fields as $acf_field)
        {
            $data = array(
                'Group_type' => 'User Avatar Info',
                'Parent_id' => $user_field_parent_id,
                'Post_excerpt' => $acf_field[0],
                'Post_name' => $acf_field[1]
            );

            $wpdb->insert($table, $data, $format);
        }
    }

    $avatar_infos = $wpdb->get_results('SELECT * FROM ' . $table . ' WHERE Group_type = "User Avatar Info" ');

    //return $avatar_infos[0]->Group_type;
    if (!empty($arr_request->email) && !empty($arr_request->password))
    {
        $result = wp_insert_user(array(
            'user_login' => $arr_request->username,
            'user_pass' => $arr_request->password,
            'user_email' => $arr_request->email,
            'first_name' => $arr_request->first_name,
            'last_name' => $arr_request->last_name,
            'display_name' => $arr_request->display_name,
            'nickname' => $arr_request->display_name,
            'role' => 'subscriber'
        ));

        if (!is_wp_error($result))
        {
            $meta = array();

            foreach ($avatar_infos as $avatar_info)
            {
                $meta["_" . $avatar_info
                    ->Post_excerpt] = $avatar_info->Post_name;
            }

            $meta = array(
                "mobile_number" => $arr_request->mobile_number,
                "industry_category" => $arr_request->industry_category,
                "job_title" => $arr_request->job_title,
                "company_name" => $arr_request->company_name,
                "country" => $arr_request->country,
                "avatar_id" => $arr_request->avatar_id,
                "looking_for_text" => $arr_request->looking_for_text,
                "business_card_name" => $arr_request->business_card_name,
                "business_card_status" => $arr_request->business_card_status
            );

            foreach ($meta as $key => $val)
            {
                update_user_meta($result, $key, $val);
            }
        }
    }

    if (is_wp_error($result))
    {
        $error = $result->get_error_message();

        return ['status' => 'error', 'code' => '401', 'message' => $error, ];
        //handle error here
        
    }
    else
    {
        $user = get_user_by('id', $result);

        return [$user];
        //handle successful creation here
        
    }
}

function create_player_mission(WP_REST_Request $request)
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
            
            $mission_count = $wpdb->get_var('select count(*) from player_missions where user_id = '. $request_array["user_id"] .' and mission_id = '.$request_array["mission_id"].' and value = "'. $request_array["value"]. '"');
            
            if($mission_count == 0)
            {
                $data = array(
                    'user_id' => $request_array["user_id"],
                    'mission_id' => $request_array["mission_id"],
                    'value' => $request_array["value"],
                    'completed' => $request_array["completed"],
                );
        
                $result = $wpdb->insert("player_missions", $data);
            }
            
            /*$data = array(
                    'user_id' => $request_array["user_id"],
                    'mission_id' => $request_array["mission_id"],
                    'value' => $request_array["value"],
                    'completed' => $request_array["completed"],
                );
        
            $result = $wpdb->insert("player_missions", $data);*/
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