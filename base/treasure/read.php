<?php
function get_treasures($data)
{
    $user_id = $data['user_id'];
    
    global $wpdb;
    
    $treasures = array();

    $table = "treasures";
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
            $treasure = new stdClass();
            
            $treasure->id = (int)$result->id;
            $treasure->event_id = (int)$result->event_id;
            $treasure->treasure_id = (int)$result->treasure_id;
            $treasure->user_id = (int)$result->user_id;
            $treasure->player_name = $result->player_name;
            $treasure->company_name = $result->company_name;
            $treasure->job_title = $result->job_title;
            $treasure->mobile_number = $result->mobile_number;
            $treasure->email = $result->email;
            $treasure->time_stamp = $result->time_stamp;

            $treasures[] = $treasure;
        }
    
        return $treasures;
    }
}

function get_schedule_event($data)
{
    $results = 0;
    
    global $wpdb;
    
    $events = array();

    $table = "schedule_events";
    $results = $wpdb->get_results('SELECT * FROM ' . $table .' where is_active = 1 ORDER BY id DESC');
    
    if (is_wp_error($results))
    {
        $error = $results->get_error_message();

        return ['status' => 'error', 'code' => '401', 'message' => $error ];
    }
    else
    {
        foreach ($results as $result)
        {
            $event = new stdClass();
            
            $event->id = (int)$result->id;

            $event->title = $result->title;
            $event->description = $result->description;
            $event->target_date = $result->target_date;
            $event->target_hour = $result->target_hour;
            $event->target_min = $result->target_min;
            $event->buffer_mins = $result->buffer_mins;

            $events[] = $event;
        }
    
        return $events;
    }
}