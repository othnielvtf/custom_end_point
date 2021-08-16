<?php
function get_booths()
{
    $totalItems = wp_count_posts('booths')->publish; 
    $callsToMake = ceil($totalItems/100);

    $ch = array();
    for($i=0;$i<$callsToMake;$i++)
    {             
        $page = $i + 1;
        $ch[$i] = curl_init(get_bloginfo('url').'/wp-json/acf/v3/booths?per_page=100&page='.$page);
        curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch[$i], CURLOPT_SSL_VERIFYPEER,  0);
    }
    
    $mh = curl_multi_init();
 
    for($i=0;$i<$callsToMake;$i++){
        curl_multi_add_handle($mh, $ch[$i]);
    }

    $running = null;
    do {
        curl_multi_exec($mh, $running);
    } while ($running);

    for($i=0;$i<$callsToMake;$i++){        

         if (!curl_errno($ch[$i])) {
             $info = curl_getinfo($ch[$i]);
             //error_log(print_r($info,true));
         }          

        curl_multi_remove_handle($mh, $ch[$i]);
    }

    curl_multi_close($mh);

    $responses = array(); //array 

    for($x=0;$x<$callsToMake;$x++){
        $responses[$x] = json_decode(curl_multi_getcontent($ch[$x]));
    } 
    
    $final = array(); 
 
    for($i=0;$i<count($responses);$i++){ 
        for($x=0;$x<count($responses[$i]);$x++){ 
           array_push($final,$responses[$i][$x] ); 
         } 
    } 
     
    return $final;
}

function get_liked_booths($data)
{
    $user_id = $data['user_id'];
    
    global $wpdb;
    
    $likes = array();

    $table = "player_booth_likes";
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
            $like = new stdClass();
            
            $like->id = (int)$result->id;
            $like->user_id = (int)$result->user_id;
            $like->booth_id = (int)$result->booth_id;

            $likes[] = $like;
        }
    
        return $likes;
    }
}

function get_promocodes($data)
{
    $user_id = $data['user_id'];
    
    global $wpdb;
    
    $promocodes = array();

    $table = "player_promocodes";
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
            $promocode = new stdClass();
            
            $promocode->id = (int)$result->id;
            $promocode->user_id = (int)$result->user_id;
            $promocode->booth_id = (int)$result->booth_id;
            $promocode->vendor_id = (int)$result->vendor_id;
            $promocode->promocode = $result->promocode;
            $promocode->promocode_url = $result->promocode_url;
            $promocode->timestamp = $result->timestamp;

            $promocodes[] = $promocode;
        }
    
        return $promocodes;
    }
}

function get_player_bookmarks($data)
{
    $user_id = $data['user_id'];
    
    global $wpdb;
    
    $bookmarks = array();

    $table = "player_bookmarks";
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
            $bookmark = new stdClass();
            
            $bookmark->id = (int)$result->id;
            $bookmark->user_id = (int)$result->user_id;
            $bookmark->booth_id = (int)$result->booth_id;

            $bookmarks[] = $bookmark;
        }
    
        return $bookmarks;
    }
}