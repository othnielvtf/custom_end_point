<?php
/*function create_order(WP_REST_Request $request)
{
    $request_array = json_decode($request->get_body(), true);

    $result = 0;
    
    if (!empty($request_array["user_id"]))
    {
        $user = get_user_by('id', $request_array["user_id"]);
        
        if($user)
        {
            $has_error = false;
            
            global $woocommerce;

            $address = array(
              'first_name' => '111Joe',
              'last_name'  => 'Conlin',
              'company'    => 'Speed Society',
              'email'      => 'joe@testing.com',
              'phone'      => '760-555-1212',
              'address_1'  => '123 Main st.',
              'address_2'  => '104',
              'city'       => 'San Diego',
              'state'      => 'Ca',
              'postcode'   => '92121',
              'country'    => 'US'
            );
            
            // Now we create the order
            $order = wc_create_order();
            
            // The add_product() function below is located in /plugins/woocommerce/includes/abstracts/abstract_wc_order.php
            $order->add_product( get_product('2676'), 1); // This is an existing SIMPLE product
            $order->set_address( $address, 'billing' );
            //
            $order->calculate_totals();
            $order->update_status("pending", 'Pending for payment', TRUE);
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
}*/

function temp_login()
{
    $request = new WP_REST_Request( 'POST', '/jwt-auth/v1/token/validate');
	$_SERVER['REDIRECT_HTTP_AUTHORIZATION'] = 'Bearer '.$_GET['token'];	
    
    $r = rest_do_request( $request );
    return $r;
}

function temp_redirect()
{
    //$url = "https://virtualtechfrontier.com/virtualexpodemo/checkout/order-pay/2784/?pay_for_order=true&key=wc_order_1q5EkRzEGqKRL";
    //echo $_GET['order_id']."XXX".$_GET['order_key'];
    $url = get_home_url()."/checkout/order-pay/".$_GET['order_id']."/?pay_for_order=true&key=".$_GET['order_key'];
    
    if (is_user_logged_in()) 
    {
        ?>
        <script>window.location.href = '<?php echo $url; ?>';</script>
        <?php
    }
}

add_shortcode('temp_redirect', 'temp_redirect');

function create_order(WP_REST_Request $request)
{
    return create_woocommerce_order($request);
}

function create_woocommerce_order(WP_REST_Request $request)
{
    global $woocommerce;
    
    $a = "a";
    $user_id = -1;
    
    $r = new WP_REST_Request( 'POST', '/jwt-auth/v1/token/validate');
	$_SERVER['REDIRECT_HTTP_AUTHORIZATION'] = 'Bearer '.$_GET['token'];	
	
	$response = rest_do_request($r);
	
	if(isset($_GET['token_id']))
    {
        $user_id = base64_decode($_GET['token_id']);
    }
    
    if($response->data["data"]["status"] == 200)
    {
        $a = "ab";
        if(!is_user_logged_in())
        {
            $a = "abc";
            //wp_set_auth_cookie($user_id, true, is_ssl());	    
            wp_set_current_user($user_id);
        }
    }

    if (is_user_logged_in()) 
    {
        $request_array = json_decode($request->get_body(), true);
        $customer = new WC_Customer(get_current_user_id());
        
        $address = array(
          'first_name' => $customer->get_billing_first_name(),
          'last_name'  => $customer->get_billing_last_name(),
          'company'    => $customer->get_billing_company(),
          'email'      => $customer->get_email(),
          'phone'      => $customer->get_billing_phone(),
          'address_1'  => $customer->get_billing_address_1(),
          'address_2'  => $customer->get_billing_address_2(),
          'city'       => $customer->get_billing_city(),
          'state'      => $customer->get_billing_state(),
          'postcode'   => $customer->get_billing_postcode(),
          'country'    => $customer->get_billing_country()
        );
        
        // Now we create the order
        $order = wc_create_order();
        
        $order->set_customer_id(get_current_user_id());
        
        foreach($request_array["items"] as $value)
        {
            $product_id = $value["product_id"];
            $quantity = $value["quantity"];
            
            $order->add_product( wc_get_product($product_id), $quantity);
        }

        $order->set_address( $address, 'billing' );
    
        $order->calculate_totals();
        $order->update_status("pending", 'Pending for payment', TRUE);
        
        $order->save();
        
        $order_object = new stdClass();
        $order_object->order_id = $order->get_id();
        $order_object->checkout_payment_url = $order->get_checkout_payment_url();
        $order_object->order_key = $order->get_order_key();

        return [$order_object];
    }
    else
    {
        return $a."no login";
    }
}

add_action( 'woocommerce_before_checkout_form', 'create_woocommerce_order' );

add_shortcode('create_woocommerce_order', 'create_woocommerce_order');