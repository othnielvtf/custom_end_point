<?php
function get_npcs_by_hall($data)
{
    $hall_id = $data['hall_id'];
    
    $results = 0;
    
    global $wpdb;
    
    $npcs = array();

    $table = "npcs";
    $results = $wpdb->get_results('SELECT * FROM ' . $table . ' WHERE hall_id =  '.$hall_id );
    
    if (is_wp_error($results))
    {
        $error = $results->get_error_message();

        return ['status' => 'error', 'code' => '401', 'message' => $error ];
    }
    else
    {
        
        foreach ($results as $result)
        {
            $npc = new stdClass();
            
            $npc->id = (int)$result->id;

            $acf = new stdClass();
            $acf->hall_id = $result->hall_id;
            $acf->name = $result->name;
            $acf->scripts = $result->scripts;
            $acf->coordinate_x = $result->coordinate_x;
            $acf->coordinate_y = $result->coordinate_y;
            $acf->coordinate_z = $result->coordinate_z;
            
            $npc->acf = $acf;

            $npcs[] = $npc;
        }
    
        return $npcs;
    }
}