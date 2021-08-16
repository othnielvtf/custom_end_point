<?php

function generate_mission_report_data()
{
    global $wpdb;
    
    $mission_array = array();

    $table = "missions";
    $missions = $wpdb->get_results('SELECT * FROM ' . $table);
    
    foreach ($missions as $main_mission)
    {
        $mission = new stdClass();
        
        $mission->id = (int)$main_mission->id;
        $mission->sequence = (int)$main_mission->sequence;
        $mission->mission_type = (int)$main_mission->mission_type;
        $mission->action_type = (int)$main_mission->action_type;
        $mission->target_type = $main_mission->target_type;
        $mission->target_value = $main_mission->target_value;
        $mission->description = $main_mission->description;
        $mission->timestamp = $main_mission->timestamp;
        
        //$player_missions = $wpdb->get_results('SELECT * FROM player_missions WHERE mission_id =  '.$mission->id . " LIMIT 10;");
        //$player_missions = $wpdb->get_results('SELECT * FROM player_missions WHERE mission_id =  '.$mission->id);
        $player_missions = $wpdb->get_results('SELECT * FROM player_missions WHERE mission_id =  '.$mission->id . " and user_id = 32");
        
        $player_mission_array = array();
        
        foreach($player_missions as $p_mission)
        {
            $row_count = $wpdb->get_var("SELECT COUNT(*) FROM player_missions WHERE mission_id = " .$mission->id . " and user_id = ".$p_mission->user_id." and completed = 1");
            
            $is_mission_completed = 0;
            
            if($row_count > 0)
            {
                $is_mission_completed = 1;
            }
            
            $player_mission = new stdClass();
            
            $player_mission->id = (int)$p_mission->id;
            $player_mission->user_id = (int)$p_mission->user_id;
            $player_mission->mission_id = (int)$p_mission->mission_id;
            $player_mission->value = $p_mission->value;
            //$player_mission->completed = $p_mission->completed;
            $player_mission->completed = $is_mission_completed;
            $player_mission->timestamp = strtotime($p_mission->timestamp);
            
            $temp_str = str_replace("<", "", $player_mission->value);
            $temp_str = str_replace(">", "", $temp_str);
            $temp_str = str_replace("*", ",", $temp_str);
            
            $user_info = get_userdata($player_mission->user_id);
            
            $player_mission->email = $user_info->user_email;
            $player_mission->display_name = $user_info->display_name;
            
            $values = explode(",",$temp_str, 5);

            $hall = "-";
            $floor = "-";
            $booth = "-";
            $action = "-";
            
            foreach($values as $value)
            {
                if(strpos($value, "hall=") !== false)
                {
                    $hall = str_replace("hall=", "", $value);
                } 
                else if(strpos($value, "floor=") !== false)
                {
                    $floor = str_replace("floor=", "", $value);
                } 
                else if(strpos($value, "booth=") !== false)
                {
                    $booth = str_replace("booth=", "", $value);
                } 
                else
                {
                    if($value <>"")
                    {
                        $action = $value;
                    }
                }
            }
            
            $player_mission->hall = $hall;
            $player_mission->floor = $floor;
            $player_mission->booth = $booth;
            $player_mission->action = $action;
            $player_mission->completed_date = date("Y-m-d", $player_mission->timestamp);
            $player_mission->completed_time = date("H:i:s", $player_mission->timestamp);
            
            $player_mission_array[] = $player_mission;
            
            /*$data = array(
                    'mission_id' => $player_mission->mission_id,
                    'user_id' => $player_mission->user_id,
                    'hall' => $player_mission->hall,
                    'floor' => $player_mission->floor,
                    'booth_id' => $player_mission->booth,
                    'action' => $player_mission->action,
                    'mission_description' => $mission->description,
                    'player_name' => $player_mission->display_name,
                    'player_email' => $player_mission->email,
                    'completed' => $player_mission->completed,
                    'completed_date' => $player_mission->completed_date ,
                    'completed_time' => $player_mission->completed_time,
                    'time_stamp' => $p_mission->timestamp
                );
            
            $result = $wpdb->insert("mission_report", $data);*/
        }
        
        $mission->player_mission = $player_mission_array;

        $mission_array[] = $mission;
    }
  
    return $mission_array;
}

function generate_mission_report()
{
    global $wpdb;
    
    echo "<form method = 'post'>";
    
    if(isset($_POST["submit"])) 
    {
        //$wpdb->query($wpdb->prepare("TRUNCATE TABLE mission_report"));
        
        $mission_array = array();
        
        $missions = $wpdb->get_results('SELECT * FROM missions where id > 0');
        
        foreach ($missions as $main_mission)
        {
            $mission = new stdClass();
            
            $mission->id = (int)$main_mission->id;
            $mission->sequence = (int)$main_mission->sequence;
            $mission->mission_type = (int)$main_mission->mission_type;
            $mission->action_type = (int)$main_mission->action_type;
            $mission->target_type = $main_mission->target_type;
            $mission->target_value = $main_mission->target_value;
            $mission->description = $main_mission->description;
            $mission->timestamp = $main_mission->timestamp;
            
            //$condition = " and id > 25000 and id <= 30000";
            //$condition = " and date(timestamp) = '2021-05-24'";
            $condition = "";
            
            //$player_missions = $wpdb->get_results('SELECT * FROM player_missions WHERE mission_id =  '.$mission->id . " LIMIT 10;");
            //$player_missions = $wpdb->get_results('SELECT * FROM player_missions WHERE mission_id =  '.$mission->id);
            $player_missions = $wpdb->get_results('SELECT * FROM player_missions WHERE mission_id =  '.$mission->id . $condition);
            //$player_missions = $wpdb->get_results('SELECT * FROM player_missions WHERE mission_id =  '.$mission->id . " and user_id = 32");
            
            $player_mission_array = array();
            
            foreach($player_missions as $p_mission)
            {
                $row_count = $wpdb->get_var("SELECT COUNT(*) FROM player_missions WHERE mission_id = " .$mission->id . " and user_id = ".$p_mission->user_id." and completed = 1");
                
                $is_mission_completed = 0;
                
                if($row_count > 0)
                {
                    $is_mission_completed = 1;
                }
                
                $player_mission = new stdClass();
                
                $player_mission->id = (int)$p_mission->id;
                $player_mission->user_id = (int)$p_mission->user_id;
                $player_mission->mission_id = (int)$p_mission->mission_id;
                $player_mission->value = $p_mission->value;
                //$player_mission->completed = $p_mission->completed;
                $player_mission->completed = $is_mission_completed;
                $player_mission->timestamp = strtotime($p_mission->timestamp);
                
                $temp_str = str_replace("<", "", $player_mission->value);
                $temp_str = str_replace(">", "", $temp_str);
                $temp_str = str_replace("*", ",", $temp_str);
                
                $user_info = get_userdata($player_mission->user_id);
                
                $player_mission->email = $user_info->user_email;
                $player_mission->display_name = $user_info->display_name;
                
                $values = explode(",",$temp_str, 5);
        
                $hall = "-";
                $floor = "-";
                $booth = "-";
                $action = "-";
                
                foreach($values as $value)
                {
                    if(strpos($value, "hall=") !== false)
                    {
                        $hall = str_replace("hall=", "", $value);
                    } 
                    else if(strpos($value, "floor=") !== false)
                    {
                        $floor = str_replace("floor=", "", $value);
                    } 
                    else if(strpos($value, "booth=") !== false)
                    {
                        $booth = str_replace("booth=", "", $value);
                    } 
                    else
                    {
                        if($value <>"")
                        {
                            $action = $value;
                        }
                    }
                }
                
                $player_mission->hall = $hall;
                $player_mission->floor = $floor;
                $player_mission->booth = $booth;
                $player_mission->action = $action;
                $player_mission->completed_date = date("Y-m-d", $player_mission->timestamp);
                $player_mission->completed_time = date("H:i:s", $player_mission->timestamp);
                
                $player_mission_array[] = $player_mission;
                
                $data = array(
                        'mission_id' => $player_mission->mission_id,
                        'user_id' => $player_mission->user_id,
                        'hall' => $player_mission->hall,
                        'floor' => $player_mission->floor,
                        'booth_id' => $player_mission->booth,
                        'action' => $player_mission->action,
                        'mission_description' => $mission->description,
                        'player_name' => $player_mission->display_name,
                        'player_email' => $player_mission->email,
                        'company_name' => get_user_meta($p_mission->user_id, "company_name", true),
                        'completed' => $player_mission->completed,
                        'completed_date' => $player_mission->completed_date ,
                        'completed_time' => $player_mission->completed_time,
                        'time_stamp' => $p_mission->timestamp
                    );
                
                $result = $wpdb->insert("mission_report", $data);
            }
            
            $mission->player_mission = $player_mission_array;
        
            //$mission_array[] = $mission;
        }
    }
    
    echo '<input type="submit" value="Update" name="submit"></form>';
}

add_shortcode('generate_mission_report', 'generate_mission_report');