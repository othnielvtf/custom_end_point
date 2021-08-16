<?php
function get_user_info_by_email($data)
{
    $user = get_user_by('email', $data['email']);

    if ($user)
    {
        $user_data = new stdClass();
        $user_data->id = $user->ID;

        $acf = new stdClass();

        $acf->full_name = $user->first_name . ' ' . $user->last_name;
        $acf->email = get_user_meta($user->ID, 'business_card_email', true);
        $acf->mobile_number = get_user_meta($user->ID, 'mobile_number', true);
        $acf->username = $user->user_login;
        $acf->nick_name = $user->display_name;
        $acf->display_name = $user->display_name;
        $acf->player_name = get_user_meta($user->ID, 'player_name', true);
        $acf->industry_category = get_user_meta($user->ID, 'industry_category', true);
        $acf->job_title = get_user_meta($user->ID, 'job_title', true);
        $acf->company_name = get_user_meta($user->ID, 'company_name', true);
        $acf->country = get_user_meta($user->ID, 'country', true);
        $acf->avatar_id = get_user_meta($user->ID, 'avatar_id', true);
        $acf->looking_for_text = get_user_meta($user->ID, 'looking_for_text', true);
        $acf->business_card_name = get_user_meta($user->ID, 'business_card_name', true);
        $acf->business_card_status = get_user_meta($user->ID, 'business_card_status', true);
        $acf->display_other_name = get_user_meta($user->ID, 'display_other_name', true);
        $acf->music_volume = get_user_meta($user->ID, 'music_volume', true);

        $user_data->acf = $acf;

        return [$user_data];
    }

    return ['status' => 'error', 'code' => '401', 'message' => 'Unable to retrieve user.', ];
}

function generate_auth()
{
    $emailuser = $_GET['email'];
    $password = 'vtfisawesome';
    $method = 'aes-256-cbc';
    $key = substr(hash('sha256', $password, true), 0, 32);
    $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    $encrypted = base64_encode(openssl_encrypt($emailuser, $method, $key, OPENSSL_RAW_DATA, $iv));
    $decrypted = openssl_decrypt(base64_decode($encrypted), $method, $key, OPENSSL_RAW_DATA, $iv);

    
    return $encrypted. "  x  ".$decrypted;
}

function get_user_info_by_token($data)
{
    $token = $data['token'];
    
    $password = 'vtfisawesome';
    
    $method = 'aes-256-cbc';
    
    $key = substr(hash('sha256', $password, true), 0, 32);
    
    $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    
    //$encrypted = base64_encode(openssl_encrypt("jimmy.lee@virtualtechfrontier.com", $method, $key, OPENSSL_RAW_DATA, $iv));
    $decrypted = openssl_decrypt(base64_decode($token), $method, $key, OPENSSL_RAW_DATA, $iv);

    $user = get_user_by('email', $decrypted);

    if ($user)
    {
        $user_data = new stdClass();
        $user_data->id = $user->ID;

        $acf = new stdClass();

        $acf->full_name = $user->first_name . ' ' . $user->last_name;
        $acf->email = get_user_meta($user->ID, 'business_card_email', true);
        $acf->mobile_number = get_user_meta($user->ID, 'mobile_number', true);
        $acf->username = $user->user_login;
        $acf->nick_name = $user->display_name;
        $acf->display_name = $user->display_name;
        $acf->player_name = get_user_meta($user->ID, 'player_name', true);
        $acf->industry_category = get_user_meta($user->ID, 'industry_category', true);
        $acf->job_title = get_user_meta($user->ID, 'job_title', true);
        $acf->company_name = get_user_meta($user->ID, 'company_name', true);
        $acf->country = get_user_meta($user->ID, 'country', true);
        $acf->avatar_id = get_user_meta($user->ID, 'avatar_id', true);
        $acf->looking_for_text = get_user_meta($user->ID, 'looking_for_text', true);
        $acf->business_card_name = get_user_meta($user->ID, 'business_card_name', true);
        $acf->business_card_status = get_user_meta($user->ID, 'business_card_status', true);
        $acf->display_other_name = get_user_meta($user->ID, 'display_other_name', true);
        $acf->music_volume = get_user_meta($user->ID, 'music_volume', true);

        $user_data->acf = $acf;

        return [$user_data];
    }

    return ['status' => 'error', 'code' => '401', 'message' => 'Unable to retrieve user.', ];
}

function get_user_info_by_username($data)
{
    $user = get_user_by('login', $data['username']);

    if ($user)
    {
        $user_data = new stdClass();
        $user_data->id = $user->ID;

        $acf = new stdClass();

        $acf->full_name = $user->first_name . ' ' . $user->last_name;
        $acf->email = get_user_meta($user->ID, 'business_card_email', true);
        $acf->mobile_number = get_user_meta($user->ID, 'mobile_number', true);
        $acf->username = $user->user_login;
        $acf->nick_name = $user->display_name;
        $acf->display_name = $user->display_name;
        $acf->player_name = get_user_meta($user->ID, 'player_name', true);
        $acf->industry_category = get_user_meta($user->ID, 'industry_category', true);
        $acf->job_title = get_user_meta($user->ID, 'job_title', true);
        $acf->company_name = get_user_meta($user->ID, 'company_name', true);
        $acf->country = get_user_meta($user->ID, 'country', true);
        $acf->avatar_id = get_user_meta($user->ID, 'avatar_id', true);
        $acf->looking_for_text = get_user_meta($user->ID, 'looking_for_text', true);
        $acf->business_card_name = get_user_meta($user->ID, 'business_card_name', true);
        $acf->business_card_status = get_user_meta($user->ID, 'business_card_status', true);
        $acf->display_other_name = get_user_meta($user->ID, 'display_other_name', true);
        $acf->music_volume = get_user_meta($user->ID, 'music_volume', true);

        $user_data->acf = $acf;

        return [$user_data];
    }

    return ['status' => 'error', 'code' => '401', 'message' => 'Unable to retrieve user.', ];
}

function get_missions($data)
{
    $user_id = $data['user_id'];
    
    global $wpdb;
    
    $missions = array();

    $table = "missions";
    $results = $wpdb->get_results('SELECT * FROM ' . $table . ' where is_active = 1');
    
    if (is_wp_error($results))
    {
        $error = $results->get_error_message();

        return ['status' => 'error', 'code' => '401', 'message' => $error ];
    }
    else
    {
        foreach ($results as $result)
        {
            $mission = new stdClass();
            
            $mission->id = (int)$result->id;
            $mission->sequence = (int)$result->sequence;
            $mission->mission_type = (int)$result->mission_type;
            $mission->action_type = (int)$result->action_type;
            $mission->target_type = $result->target_type;
            $mission->target_value = $result->target_value;
            $mission->description = $result->description;
            $mission->timestamp = $result->timestamp;
            $mission->is_active = $result->is_active;

            $missions[] = $mission;
        }
    
        return $missions;
    }
}

function get_user_mission($data)
{
    $user_id = $data['user_id'];
    
    global $wpdb;
    
    $player_missions = array();

    $table = "player_missions";
    $results = $wpdb->get_results('SELECT * FROM ' . $table . ' WHERE user_id =  '.$user_id );
    
    if (is_wp_error($results))
    {
        $error = $results->get_error_message();

        return ['status' => 'error', 'code' => '401', 'message' => $error ];
    }
    else
    {
        foreach ($results as $result)
        {
            $player_mission = new stdClass();
            
            $player_mission->id = (int)$result->id;
            $player_mission->user_id = (int)$result->user_id;
            $player_mission->mission_id = (int)$result->mission_id;
            $player_mission->value = $result->value;
            $player_mission->completed = $result->completed;
            $player_mission->timestamp = $result->timestamp;

            $player_missions[] = $player_mission;
        }
    
        return $player_missions;
    }
}