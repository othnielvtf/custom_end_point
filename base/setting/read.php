<?php
function get_schedule_notification()
{
    $results = 0;
    
    global $wpdb;
    
    $notifications = array();

    $table = "schedule_notifications";
    $results = $wpdb->get_results('SELECT * FROM ' . $table .' where is_active = 1  ORDER BY id DESC');
    
    if (is_wp_error($results))
    {
        $error = $results->get_error_message();

        return ['status' => 'error', 'code' => '401', 'message' => $error ];
    }
    else
    {
        foreach ($results as $result)
        {
            $notification = new stdClass();
            
            $notification->id = (int)$result->id;

            $notification->title = $result->title;
            $notification->description = $result->description;
            $notification->target_date = $result->target_date;
            $notification->target_hour = $result->target_hour;
            $notification->target_min = $result->target_min;
            $notification->buffer_mins = $result->buffer_mins;

            $notifications[] = $notification;
        }
    
        return $notifications;
    }
}

function get_server_time()
{
    date_default_timezone_set('Asia/Kuala_Lumpur'); 

    $current_date = date('m/d/Y H:i:s');
    
    return $current_date;
}