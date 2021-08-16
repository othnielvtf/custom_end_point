<?php
function edit_event_details() 
{
    global $wpdb;
    
    $user = wp_get_current_user(); // getting & setting the current user 

    if($user->roles[0] == "contributor"||$user->roles[0] == "administrator")
    {
        $event_id = $_GET['event_id'];
        
        $post_id = $event_id;
        
        if(isset($_POST["submit"])) 
        {
            $banner_img = "";
            $img_1 = "";
            $img_2 = "";
            $img_3 = "";
            $img_4 = "";
            $img_5 = "";
            $img_6 = "";
            $img_7 = "";

            if($_FILES["banner_image_field"]["size"] > 0)
            {
                $banner_img = upload_to_media($_FILES['banner_image_field'])["file_path"];
            }
            
            if($_FILES["image_url_1_field"]["size"] > 0)
            {
                $img_1 = upload_to_media($_FILES['image_url_1_field']);
            }
            
            if($_FILES["image_url_2_field"]["size"] > 0)
            {
                $img_2 = upload_to_media($_FILES['image_url_2_field']);
            }

            if($_FILES["image_url_3_field"]["size"] > 0)
            {
                $img_3 = upload_to_media($_FILES['image_url_3_field']);
            }
            
            if($_FILES["image_url_4_field"]["size"] > 0)
            {
                $img_4 = upload_to_media($_FILES['image_url_4_field']);
            }
            
            if($_FILES["image_url_5_field"]["size"] > 0)
            {
                $img_5 = upload_to_media($_FILES['image_url_5_field']);
            }
            
            if($_FILES["image_url_6_field"]["size"] > 0)
            {
                $img_6 = upload_to_media($_FILES['image_url_6_field']);
            }
            
            if($_FILES["image_url_7_field"]["size"] > 0)
            {
                $img_7 = upload_to_media($_FILES['image_url_7_field']);
            }
            
            $data = 
                array(
                    "name" => processText($_POST['event_name_field']),
                    "description" => processText($_POST['event_description_field']),
                    "welcome_message" => processText($_POST['welcome_message_field']),
                    "banner_url" => $banner_img, 
                    "color" => "",
                    "secondary_color" => "", 
                    "email" => $_POST['email_field'], 
                    "mobile_number" => processText($_POST['contact_number_field']),
                    "contact_person" => processText($_POST['contact_person_field']), 
                    "company_name" => processText($_POST['company_name_field']),
                    "company_url" => processText($_POST['company_url_field']), 
                    "ecommerce_url" => processText($_POST['ecommerce_url_field']),
                    "catalogue_url" => processText($_POST['catalogue_url_field']), 
                    "video_url" => processText($_POST['video_url_field']),
                    "live_stream_url" => processText($_POST['live_stream_url_field']), 
                    "whatsapp_url" => processText($_POST['whatsapp_url_field']), 
                    "facebook_url" => processText($_POST['facebook_url_field']),
                    "instagram_url" => processText($_POST['instagram_url_field']), 
                    "linkedin_url" => processText($_POST['linkedin_url_field']), 
                    "scripts" => $_POST['scripts_field'],
                    "image_url_1" => $img_1, 
                    "image_url_2" => $img_2, 
                    "image_url_3" => $img_3, 
                    "image_url_4" => $img_4,
                    "image_url_5" => $img_5, 
                    "image_url_6" => $img_6, 
                    "image_url_7" => $img_7,
                    "active" => $_POST['active_field']
                );
            
            $result = $wpdb->update("events", $data, array('name' => "link_event_url"));
            
            $_POST["submit"] = null;
            
            echo "<script type='text/javascript'>
                window.location=document.location.href;
            </script>";
        }
        
        $table = "events";
        $results = $wpdb->get_results('SELECT * FROM events WHERE id =  '.$event_id );
        
        if(count($results) > 0)
        {
            $user_event = $results[0];

            $event_name = $user_event->name;
            $welcome_message = $user_event->welcome_message;
            $event_description = $user_event->description;
            $company_url = $user_event->company_url;
            $contact_person = $user_event->contact_person;
            $email = $user_event->email;
            $contact_number = $user_event->mobile_number;
            $company_name = $user_event->company_name;
            $ecommerce_url = $user_event->ecommerce_url;
            $catalogue_url = $user_event->catalogue_url;
            $video_url = $user_event->video_url;
            $live_stream_url = $user_event->live_stream_url;
            $whatsapp_url = $user_event->whatsapp_url;
            $facebook_url = $user_event->facebook_url;
            $instagram_url = $user_event->instagram_url;
            $linkedin_url = $user_event->linkedin_url;
            $scripts = $user_event->scripts;
            $active = $user_event->active;
            $color = $user_event->color;
            $secondary_color = $user_event->secondary_color;
    
            $banner_image = $user_event->banner_url;
            $image_url_1 = $user_event->image_url_1;
            $image_url_2 = $user_event->image_url_2;
            $image_url_3 = $user_event->image_url_3;
            $image_url_4 = $user_event->image_url_4;
            $image_url_5 = $user_event->image_url_5;
            $image_url_6 = $user_event->image_url_6;
            $image_url_7 = $user_event->image_url_7;
            
            $banner_image_snippet = "";
            $image_url_1_snippet = "";
            $image_url_2_snippet = "";
            $image_url_3_snippet = "";
            $image_url_4_snippet = "";
            $image_url_5_snippet = "";
            $image_url_6_snippet = "";
            $image_url_7_snippet = "";
            
            $is_active_snippet = "";
            $is_inactive_snippet = "";
            
            if($active == 1)
            {
                $is_active_snippet = "checked";
                $is_inactive_snippet = "";
            }
            else
            {
                $is_active_snippet = "";
                $is_inactive_snippet = "checked";
            }
			
			if(!empty($banner_image))
			{
				$banner_image_snippet = '<img src="'.$banner_image.'" alt="" data-name="image" style="max-height: 300px;">';
			}
			else
			{
				$banner_image_snippet = '<p>No image selected</p>';
			}
	 
			if(!empty($image_url_1))
			{
				$image_url_1_snippet = '<img src="'.$image_url_1.'" alt="" data-name="image" style="max-height: 300px;">';
			}
			else
			{
				$image_url_1_snippet = '<p>No image selected</p>';
			}
	  
			if(!empty($image_url_2))
			{
				$image_url_2_snippet = '<img src="'.$image_url_2.'" alt="" data-name="image" style="max-height: 300px;">';
			}
			else
			{
				$image_url_2_snippet = '<p>No image selected</p>';
			}
		 
			if(!empty($image_url_3))
			{
				$image_url_3_snippet = '<img src="'.$image_url_3.'" alt="" data-name="image" style="max-height: 300px;">';
			}
			else
			{
				$image_url_3_snippet = '<p>No image selected</p>';
			}
			
			if(!empty($image_url_4))
			{
				$image_url_4_snippet = '<img src="'.$image_url_4.'" alt="" data-name="image" style="max-height: 300px;">';
			}
			else
			{
				$image_url_4_snippet = '<p>No image selected</p>';
			}
	  
			if(!empty($image_url_5))
			{
				$image_url_5_snippet = '<img src="'.$image_url_5.'" alt="" data-name="image" style="max-height: 300px;">';
			}
			else
			{
				$image_url_5_snippet = '<p>No image selected</p>';
			}
		 
			if(!empty($image_url_6))
			{
				$image_url_6_snippet = '<img src="'.$image_url_6.'" alt="" data-name="image" style="max-height: 300px;">';
			}
			else
			{
				$image_url_6_snippet = '<p>No image selected</p>';
			}
			
			if(!empty($image_url_7))
			{
				$image_url_7_snippet = '<img src="'.$image_url_7.'" alt="" data-name="image" style="max-height: 300px;">';
			}
			else
			{
				$image_url_7_snippet = '<p>No image selected</p>';
			}
        }

    echo '<div>
    <form method="post" enctype="multipart/form-data">
   <input type="hidden" name="current_post_id" value="'. $event_id .'">	
   <section>
   <div class="acf-field acf-field-url acf-field-600d68618090f">
      <div class="acf-label">
         <label for="acf-field_600d68618090f">Status</label>
      </div>
      <div class="acf-input">
        <input type="radio" name="active_field" id ="active_field" value="1" '.$is_active_snippet.'>Active
        <input type="radio" name="active_field" id = "active_field" value="0" '.$is_inactive_snippet.'>Inactive
      </div>
   </div>
   <div class="acf-field acf-field-url acf-field-600d68618090f" data-name="event_name" data-type="text" data-key="field_600d68618090f">
      <div class="acf-label">
         <label for="acf-field_600d68618090f">Event Name</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap acf-url -valid"><i class="acf-icon -globe -small"></i><input type="text" id="acf-field_600d68618090f" name="event_name_field" value="'.$event_name.'"></div>
      </div>
   </div>
   <div class="acf-field acf-field-textarea" data-name="welcome_message" data-type="textarea" data-key="field_606d5aec41b361">
      <div class="acf-label">
         <label for="acf-field_606d5aec41b361">Welcome Message</label>
      </div>
      <div class="acf-input">
         <textarea id="acf-field_606d5aec41b361" name="welcome_message_field" rows="8">'.$welcome_message.'</textarea>
      </div>
   </div>
   <div class="acf-field acf-field-textarea" data-name="event_description" data-type="textarea" data-key="field_606d5aec41b36">
      <div class="acf-label">
         <label for="acf-field_606d5aec41b36">Event Description</label>
      </div>
      <div class="acf-input">
         <textarea id="acf-field_606d5aec41b36" name="event_description_field" rows="8">'.$event_description.'</textarea>
      </div>
   </div>
   
   <div>
        <label for="primary_color_field">Primary Color:</label>
        <input type="color" id="primary_color_field" name="primary_color_field" value="'.$color.'">
        <label for="secondary_color_field">Secondary Color:</label>
        <input type="color" id="secondary_color_field" name="secondary_color_field" value="'.$secondary_color.'">
   </div>
   
   </section>
   <section>
        <p>
           <div class="acf-field acf-field-image acf-field-600d68308090e" data-name="banner_image" data-type="image" data-key="field_600d68308090e">
              <div class="acf-label">
                 <label for="acf-field_600d68308090e">Banner Image</label>
                 <p class="description">Please make sure image is 4600px Width and 2800px Height</p>
                 <div>
                 '.$banner_image_snippet.'
                 </div>
              </div>
        	  <input type="file" id="banner_image_field" name="banner_image_field" accept="image/*">
           </div>
           <style>
            .hidefield {
                display: none;
            }
           </style>
        </p>
   </section>
   <div class="acf-field acf-field-url acf-field-600d68618090f" data-name="company_url" data-type="url" data-key="field_600d68618090f">
      <div class="acf-label">
         <label for="acf-field_600d68618090f">Company Website</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap acf-url -valid"><i class="acf-icon -globe -small"></i><input type="url" id="acf-field_600d68618090f" name="company_url_field" value="'.$company_url.'"></div>
      </div>
   </div>
    <div class="acf-field acf-field-text acf-field-603c903f9b157" data-name="ecommerce_url" data-type="text" data-key="field_603c903f9b157">
      <div class="acf-label">
         <label for="acf-field_603c903f9b157">E-Commerce Website</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_603c903f9b157" name="ecommerce_url_field" value="'.$ecommerce_url.'"></div>
      </div>
   </div>
   <div class="acf-field acf-field-text acf-field-606d5bc8ca9e3" data-name="whatsapp_url" data-type="text" data-key="field_606d5bc8ca9e3">
      <div class="acf-label">
         <label for="acf-field_606d5bc8ca9e3">Whatsapp URL</label>
         <p>This number will be linked to booth live chat feature.</p>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_606d5bc8ca9e3" name="whatsapp_url_field" value="'.$whatsapp_url.'"></div>
      </div>
   </div>
   <div class="acf-field acf-field-text acf-field-606d5bd5ca9e4" data-name="facebook_url" data-type="text" data-key="field_606d5bd5ca9e4">
      <div class="acf-label">
         <label for="acf-field_606d5bd5ca9e4">Facebook URL</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_606d5bd5ca9e4" name="facebook_url_field" value="'.$facebook_url.'"></div>
      </div>
   </div>
   <div class="acf-field acf-field-text acf-field-606d5bebca9e5" data-name="instagram_url" data-type="text" data-key="field_606d5bebca9e5">
      <div class="acf-label">
         <label for="acf-field_606d5bebca9e5">Instagram URL</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_606d5bebca9e5" name="instagram_url_field" value="'.$instagram_url.'"></div>
      </div>
   </div>
   <div class="acf-field acf-field-text acf-field-606d5bf9ca9e6" data-name="linkedin_url" data-type="text" data-key="field_606d5bf9ca9e6">
      <div class="acf-label">
         <label for="acf-field_606d5bf9ca9e6">LinkedIn URL</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_606d5bf9ca9e6" name="linkedin_url_field" value ="'.$linkedin_url.'"></div>
      </div>
   </div>
   
   <div class="acf-field acf-field-text acf-field-604eeb08650e5" data-name="scripts" data-type="text" data-key="field_604eeb08650e5">
      <div class="acf-label">
         <label for="acf-field_604eeb08650e5">NPC scripts</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_604eeb08650e5" name="scripts_field" value="'.$scripts.'"></div>
      </div>
   </div>
   
   <div class="acf-field acf-field-text acf-field-600d687180910" data-name="contact_person" data-type="text" data-key="field_600d687180910">
      <div class="acf-label">
         <label for="acf-field_600d687180910">Contact Person</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_600d687180910" name="contact_person_field" value="'.$contact_person.'"></div>
      </div>
   </div>
   <div class="acf-field acf-field-text acf-field-600d688780911" data-name="email" data-type="text" data-key="field_600d688780911">
      <div class="acf-label">
         <label for="acf-field_600d688780911">Email</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_600d688780911" name="email_field" value="'.$email.'"></div>
      </div>
   </div>
   <div class="acf-field acf-field-text acf-field-600d689280912" data-name="contact_number" data-type="text" data-key="field_600d689280912">
      <div class="acf-label">
         <label for="acf-field_600d689280912">Contact Number</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_600d689280912" name="contact_number_field" value="'.$contact_number.'"></div>
      </div>
   </div>
   <div class="acf-field acf-field-text acf-field-603c8f5f9b155 is-required" data-name="company_name" data-type="text" data-key="field_603c8f5f9b155" data-required="1">
      <div class="acf-label">
         <label for="acf-field_603c8f5f9b155">Company Name <span class="acf-required">*</span></label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_603c8f5f9b155" name="company_name_field" value="'.$company_name.'" required="required"></div>
      </div>
   </div>
  
   <div class="acf-field acf-field-text acf-field-603c905d9b158" data-name="catalogue_url" data-type="text" data-key="field_603c905d9b158">
      <div class="acf-label">
         <label for="acf-field_603c905d9b158">Brochure URL</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_603c905d9b158" name="catalogue_url_field" value ="'.$catalogue_url.'"></div>
      </div>
   </div>
   <div class="acf-field acf-field-url acf-field-603c906f9b159" data-name="video_url" data-type="url" data-key="field_603c906f9b159">

      <div class="acf-label">
         <label for="acf-field_603c906f9b159">Video URL </label>
         <p class="description">Please make sure video format is in MP4 and <br>size is 1920px width and 1080px height</p>

      </div>
      <div class="acf-input">
         <div class="acf-input-wrap acf-url"><i class="acf-icon -globe -small"></i><input type="url" id="acf-field_603c906f9b159" name="video_url_field" value = "'.$video_url.'"></div>
      </div>
   </div>
   <div class="acf-field acf-field-url acf-field-603c906f9b1591" data-name="live_stream_url" data-type="url" data-key="field_603c906f9b1591">
      <div class="acf-label">
         <label for="acf-field_603c906f9b1591">Live Stream URL </label>
         <p class="description">Please make sure the link is valid</p>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap acf-url"><i class="acf-icon -globe -small"></i><input type="url" id="acf-field_603c906f9b1591" name="live_stream_url_field" value = "'.$live_stream_url.'"></div>
      </div>
   </div>
   <div class="acf-field acf-field-image acf-field-6062a28f880c9" data-name="image_url_1" data-type="image" data-key="field_6062a28f880c9">
      <div class="acf-label">
         <label for="acf-field_6062a28f880c9">Promo Visual 1</label>
         <p class="description">Please make sure image is 2480px Width and 3510px Height</p>
      </div>
      <div>
      '.$image_url_1_snippet.'
	  </div>
	  <input type="file" id="image_url_1_field" name="image_url_1_field" accept="image/*">
   </div>
   <div class="acf-field acf-field-image acf-field-6062a2dd880ca" data-name="image_url_2" data-type="image" data-key="field_6062a2dd880ca">
      <div class="acf-label">
         <label for="acf-field_6062a2dd880ca">Promo Visual 2</label>
         <p class="description">Please make sure image is 2480px Width and 3510px Height</p>
      </div>
      <div>
      '.$image_url_2_snippet.'
      </div>
	  <input type="file" id="image_url_2_field" name="image_url_2_field" accept="image/*">
   </div>
   <div class="acf-field acf-field-image acf-field-6062a2e4880cb" data-name="image_url_3" data-type="image" data-key="field_6062a2e4880cb">
      <div class="acf-label">
         <label for="acf-field_6062a2e4880cb">Promo Visual 3</label>
         <p class="description">Please make sure image is 2480px Width and 3510px Height</p>
      </div>
      <div>
      '.$image_url_3_snippet.'
      </div>
      <input type="file" id="image_url_3_field" name="image_url_3_field" accept="image/*">
   </div>
   
   <div class="'. $conditionaltier2 .' acf-field acf-field-image acf-field-4062a28f880c9" data-name="image_url_4" data-type="image" data-key="field_4062a28f880c9">
      <div class="acf-label">
         <label for="acf-field_4062a28f880c9">Promo Visual 4</label>
         <p class="description">Please make sure image is 2480px Width and 3510px Height</p>
      </div>
      <div>
      '.$image_url_4_snippet.'
	  </div>
	  <input type="file" id="image_url_4_field" name="image_url_4_field" accept="image/*">
   </div>
   
   <div class="'. $conditionaltier2 .' acf-field acf-field-image acf-field-5062a2dd880ca" data-name="image_url_2" data-type="image" data-key="field_5062a2dd880ca">
      <div class="acf-label">
         <label for="acf-field_5062a2dd880ca">Promo Visual 5</label>
         <p class="description">Please make sure image is 2480px Width and 3510px Height</p>
      </div>
      <div>
      '.$image_url_5_snippet.'
      </div>
	  <input type="file" id="image_url_5_field" name="image_url_5_field" accept="image/*">
   </div>
   
   <div class="'. $conditionaltier3 .' acf-field acf-field-image acf-field-66062a2e4880cb" data-name="image_url_6" data-type="image" data-key="field_66062a2e4880cb">
      <div class="acf-label">
         <label for="acf-field_66062a2e4880cb">Promo Visual 6</label>
         <p class="description">Please make sure image is 2480px Width and 3510px Height</p>
      </div>
      <div>
      '.$image_url_6_snippet.'
      </div>
      <input type="file" id="image_url_6_field" name="image_url_6_field" accept="image/*">
   </div>
   
   <div class="'. $conditionaltier3 .' acf-field acf-field-image acf-field-7062a2e4880cb" data-name="image_url_7" data-type="image" data-key="field_7062a2e4880cb">
      <div class="acf-label">
         <label for="acf-field_7062a2e4880cb">Promo Visual 7</label>
         <p class="description">Please make sure image is 2480px Width and 3510px Height</p>
      </div>
      <div>
      '.$image_url_7_snippet.'
      </div>
      <input type="file" id="image_url_7_field" name="image_url_7_field" accept="image/*">
   </div>
   <input type="submit" value="Update" name="submit">
</form></div>';
    }
}

add_shortcode('event_details', 'edit_event_details');