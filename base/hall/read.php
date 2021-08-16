<?php
function get_hall_priority()
{
    $results = 0;
    
    global $wpdb;
    
    $hall_priority = array();

    $table = "hall_priority";
    $results = $wpdb->get_results('SELECT * FROM ' . $table);
    
    if (is_wp_error($results))
    {
        $error = $results->get_error_message();

        return ['status' => 'error', 'code' => '401', 'message' => $error ];
    }
    else
    {
        
        foreach ($results as $result)
        {
            $priority = new stdClass();
            
            $priority->id = (int)$result->id;

            $priority->hall_name = $result->hall_name;
            $priority->sequence = $result->sequence;

            $hall_priority[] = $priority;
        }
    
        return $hall_priority;
    }
}