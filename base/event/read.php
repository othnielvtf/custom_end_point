<?php
function get_flashsales($data)
{
    global $wpdb;
    
    $sales = array();

    $table = "flash_sales";
    $results = $wpdb->get_results('SELECT * FROM ' . $table . ' WHERE is_active =  1');
    
    if (is_wp_error($results))
    {
        $error = $results->get_error_message();

        return ['status' => 'error', 'code' => '401', 'message' => $error ];
    }
    else
    {
        foreach ($results as $result)
        {
            $sale = new stdClass();
            
            $sale->id = (int)$result->id;
            $sale->name = $result->name;
            $sale->description = $result->description;
            $sale->price = $result->price;
            $sale->product_image = $result->product_image;
            $sale->web_url = $result->web_url;
            $sale->target_date = $result->target_date;
            $sale->target_hour = (int)$result->target_hour;
            $sale->target_min = (int)$result->target_min;
            $sale->buffer_mins = (int)$result->buffer_mins;
            $sale->is_active = (int)$result->is_active;
            
            $sales[] = $sale;
        }
    
        return $sales;
    }
}