<?
function processText($text) 
{
    $text = strip_tags($text);
    $text = trim($text);
    $text = htmlspecialchars($text);
    return $text;
}

function upload_to_media($image)
{
    $upload_id = -1;
    
    $wordpress_upload_dir = wp_upload_dir();
    // $wordpress_upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
    // $wordpress_upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
    $i = 1; // number of tries when the file with the same name is already exists
     
    $image_picture = $image;
    $new_file_path = $wordpress_upload_dir['path'] . '/' . $image_picture['name'];
    $new_file_mime = mime_content_type( $image_picture['tmp_name'] );
     
    if( empty( $image_picture ) )
    	die( 'File is not selected.' );
     
    if( $image_picture['error'] )
    	die( $image_picture['error'] );
     
    if( $image_picture['size'] > wp_max_upload_size() )
    	die( 'It is too large than expected.' );
     
    if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
    	die( 'WordPress doesn\'t allow this type of uploads.' );
     
    while( file_exists( $new_file_path ) ) 
    {
    	$i++;
    	$new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $image_picture['name'];
    }
     
    // looks like everything is OK
    if( move_uploaded_file( $image_picture['tmp_name'], $new_file_path ) ) 
    {
    	$upload_id = wp_insert_attachment( array(
    		'guid'           => $new_file_path, 
    		'post_mime_type' => $new_file_mime,
    		'post_title'     => preg_replace( '/\.[^.]+$/', '', $image_picture['name'] ),
    		'post_content'   => '',
    		'post_status'    => 'inherit'
    	), $new_file_path );
      
    	// wp_generate_attachment_metadata() won't work if you do not include this file
    	require_once( ABSPATH . 'wp-admin/includes/image.php' );
    	require_once( ABSPATH . 'wp-admin/includes/media.php' );
     
    	// Generate and save the attachment metas into the database
    	wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
     
    	// Show the uploaded file in browser
    	//wp_redirect( $wordpress_upload_dir['url'] . '/' . basename( $new_file_path ) );
    }
    
    return array("upload_id" => $upload_id, "file_path" => $new_file_path);
}

function edit_booth_details() 
{
    global $wpdb;
    
    $user = wp_get_current_user(); // getting & setting the current user 

    if($user->roles[0] == "contributor" || $user->roles[0] == "administrator")
    {
        if(isset($_POST["submit"])) 
        {
            update_post_meta($_POST['current_post_id'], "company_description", processText($_POST['company_description_field']));
            update_post_meta($_POST['current_post_id'], "company_url", processText($_POST['company_url_field']));
            
            update_post_meta($_POST['current_post_id'], "contact_person", processText($_POST['contact_person_field']));
            update_post_meta($_POST['current_post_id'], "email", processText($_POST['email_field']));
            update_post_meta($_POST['current_post_id'], "contact_number", processText($_POST['contact_number_field']));
            update_post_meta($_POST['current_post_id'], "company_name", processText($_POST['company_name_field']));
            update_post_meta($_POST['current_post_id'], "ecommerce_url", processText($_POST['ecommerce_url_field']));
            update_post_meta($_POST['current_post_id'], "catalogue_url", processText($_POST['catalogue_url_field']));
            
            update_post_meta($_POST['current_post_id'], "scripts", processText($_POST['scripts_field']));
            
            update_post_meta($_POST['current_post_id'], "promocode_text", processText($_POST['promocode_text_field']));
            update_post_meta($_POST['current_post_id'], "promocode_url", processText($_POST['promocode_url_field']));
            update_post_meta($_POST['current_post_id'], "promocode", processText($_POST['promocode_field']));

            update_post_meta($_POST['current_post_id'], "whatsapp_url", processText($_POST['whatsapp_url_field']));
            update_post_meta($_POST['current_post_id'], "facebook_url", processText($_POST['facebook_url_field']));
            update_post_meta($_POST['current_post_id'], "instagram_url", processText($_POST['instagram_url_field']));
            update_post_meta($_POST['current_post_id'], "linkedin_url", processText($_POST['linkedin_url_field']));

            if($_FILES["banner_image_field"]["size"] > 0)
            {
                $banner_img = upload_to_media($_FILES['banner_image_field'])["upload_id"];
                update_post_meta($_POST['current_post_id'], "banner_image", $banner_img);
            }
            
            if($_FILES["image_url_1_field"]["size"] > 0)
            {
                $img_1 = upload_to_media($_FILES['image_url_1_field'])["upload_id"];
                update_post_meta($_POST['current_post_id'], "image_url_1", $img_1);
            }
            
            if($_FILES["image_url_2_field"]["size"] > 0)
            {
                $img_2 = upload_to_media($_FILES['image_url_2_field'])["upload_id"];
                update_post_meta($_POST['current_post_id'], "image_url_2", $img_2);
            }

            if($_FILES["image_url_3_field"]["size"] > 0)
            {
                $img_3 = upload_to_media($_FILES['image_url_3_field'])["upload_id"];
                update_post_meta($_POST['current_post_id'], "image_url_3", $img_3);
            }
            
            if($_FILES["image_url_4_field"]["size"] > 0)
            {
                $img_4 = upload_to_media($_FILES['image_url_4_field'])["upload_id"];
                update_post_meta($_POST['current_post_id'], "image_url_4", $img_4);
            }
            
            if($_FILES["image_url_5_field"]["size"] > 0)
            {
                $img_5 = upload_to_media($_FILES['image_url_5_field'])["upload_id"];
                update_post_meta($_POST['current_post_id'], "image_url_5", $img_5);
            }
            
            if($_FILES["image_url_6_field"]["size"] > 0)
            {
                $img_6 = upload_to_media($_FILES['image_url_6_field'])["upload_id"];
                update_post_meta($_POST['current_post_id'], "image_url_6", $img_6);
            }
            
            if($_FILES["image_url_7_field"]["size"] > 0)
            {
                $img_7 = upload_to_media($_FILES['image_url_7_field'])["upload_id"];
                update_post_meta($_POST['current_post_id'], "image_url_7", $img_7);
            }
            
             if($_FILES["video_url_field"]["size"] > 0)
            {
                $video_1 = upload_to_media($_FILES['video_url_field'])["upload_id"];
                update_post_meta($_POST['current_post_id'], "video_url", $video_1);
                //update_post_meta($_POST['current_post_id'], "video_url", processText($_POST['video_url_field']));

            }
            
            $_POST["submit"] = null;
            
            return "<script type='text/javascript'>
                window.location=document.location.href;
            </script>";
        }
        
        $args = array(
            'author' => $user->ID,
            'post_type' => 'booths',
        );
        
        $post_id = $wpdb->get_var('SELECT ID FROM ' . $wpdb->prefix . 'posts WHERE post_type = "booths" and post_author =  '.$user->ID );
        $company_description = get_post_meta( $post_id, 'company_description', true );
        $company_url = get_post_meta( $post_id, 'company_url', true );
        $contact_person = get_post_meta( $post_id, 'contact_person', true );
        $email = get_post_meta( $post_id, 'email', true );
        $contact_number = get_post_meta( $post_id, 'contact_number', true );
        $company_name = get_post_meta( $post_id, 'company_name', true );
        $ecommerce_url = get_post_meta( $post_id, 'ecommerce_url', true );
        $catalogue_url = get_post_meta( $post_id, 'catalogue_url', true );
        $scripts = get_post_meta( $post_id, 'scripts', true );
        $whatsapp_url = get_post_meta( $post_id, 'whatsapp_url', true );
        $facebook_url = get_post_meta( $post_id, 'facebook_url', true );
        $instagram_url = get_post_meta( $post_id, 'instagram_url', true );
        $linkedin_url = get_post_meta( $post_id, 'linkedin_url', true );
        $promocode_text = get_post_meta( $post_id, 'promocode_text', true );
        $promocode_url = get_post_meta( $post_id, 'promocode_url', true );
        $promocode = get_post_meta( $post_id, 'promocode', true );
        $tier = get_post_meta( $post_id, 'tier', true );
        $booth_type = get_post_meta( $post_id, 'booth_type', true );
        $title_booth = get_the_title($post_id);
        $banner_image = wp_get_attachment_url( get_post_meta( $post_id, 'banner_image', true ));
        $image_url_1 = wp_get_attachment_url( get_post_meta( $post_id, 'image_url_1', true ));
        $image_url_2 = wp_get_attachment_url( get_post_meta( $post_id, 'image_url_2', true ));
        $image_url_3 = wp_get_attachment_url( get_post_meta( $post_id, 'image_url_3', true ));
        $image_url_4 = wp_get_attachment_url( get_post_meta( $post_id, 'image_url_4', true ));
        $image_url_5 = wp_get_attachment_url( get_post_meta( $post_id, 'image_url_5', true ));
        $image_url_6 = wp_get_attachment_url( get_post_meta( $post_id, 'image_url_6', true ));
        $image_url_7 = wp_get_attachment_url( get_post_meta( $post_id, 'image_url_7', true ));
        $video_url = wp_get_attachment_url( get_post_meta( $post_id, 'video_url', true ));
        $banner_image_snippet = "";
        $image_url_1_snippet = "";
        $image_url_2_snippet = "";
        $image_url_3_snippet = "";
        $image_url_4_snippet = "";
        $image_url_5_snippet = "";
        $image_url_6_snippet = "";
        $image_url_7_snippet = "";
        $video_url_1_snippet = "";
        
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
        
         if(!empty($video_url))
        {
            $video_url_1_snippet = '<video width="320" height="240" controls>
  <source src="' .$video_url.'" type="video/mp4">
Your browser does not support the video tag.
</video>';
        }
        else
        {
            $video_url_1_snippet = '<p>No video selected</p>';
        }
        
        
        $booth_type_snippet = "";
        
        if($booth_type == "0")
        {
            $booth_type_snippet = "<div><p>Small</p></div>";
        }
        else if($booth_type == "1")
        {
            $booth_type_snippet = "<div><p>Large</p></div>";
        }
      
    return '
    <form method="post" enctype="multipart/form-data">
   <input type="hidden" name="current_post_id" value="'. $post_id .'">
    <div class="acf-field acf-field-text acf-field-603c8f5f9b155 is-required" data-name="company_name" data-type="text" data-key="field_603c8f5f9b155" data-required="1">
      <div class="acf-label">
         <label for="acf-field_603c8f5f9b155">Company Name <span class="acf-required">*</span></label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_603c8f5f9b155" name="company_name_field" value="'.$company_name.'" required="required"></div>
      </div>
   </div>
   <div class="acf-field acf-field-textarea" " data-name="company_description" data-type="textarea" data-key="field_606d5aec41b36">
      <div class="acf-label">
         <label for="acf-field_606d5aec41b36">Company Description</label>
      </div>
      <div class="acf-input">
         <textarea id="acf-field_606d5aec41b36" name="company_description_field" rows="8">'.$company_description.'</textarea>
      </div>
   </div>
    <div class="acf-field acf-field-image acf-field-7062a2e4880cb" data-name="image_url_7" data-type="image" data-key="field_7062a2e4880cb">
      <div class="acf-label">
         <label for="acf-field_7062a2e4880cb">Logo Image</label>
         <p>Attach your logo. Image size: 4600px width by 2800px height. Max size 10MB. File type: JPG, PNG</p>
      </div>
      <div>
      '.$image_url_7_snippet.'
      </div>
      <input type="file" id="image_url_7_field" name="image_url_7_field" accept="image/*">
   </div>
   <!---
   <div class="acf-field acf-field-text acf-field-600d687180910ss" data-name="booth_type" data-type="text" data-key="field_600d687180910ss">
      <div class="acf-label">
         <label for="acf-field_600d687180910ss">Booth Type</label>
      </div>
      <div>
        '.$booth_type_snippet.'
      </div>
   </div>
   --->
   <style>
    .hidefield {
        display: none;
    }
   </style>
   <div class="acf-field acf-field-url acf-field-600d68618090f" data-name="company_url" data-type="url" data-key="field_600d68618090f">
      <div class="acf-label">
         <label for="acf-field_600d68618090f">Company Website</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap acf-url -valid"><input type="url" id="acf-field_600d68618090f" name="company_url_field" value="'.$company_url.'"></div>
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
         <p>This number will be linked to booth live chat feature. You may create your Whatsapp URL at <a style="font-size: 15px; font-weight: 700;" href="https://create.wa.link">WA.LINK</a></p>
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
  
  <div class="acf-field acf-field-image acf-field-600d68308090e" data-name="banner_image" data-type="image" data-key="field_600d68308090e">
      <div class="acf-label">
         <label for="acf-field_600d68308090e">Promo Visual</label>
         <p class="description">Attached your visual for Giant Poster @ Booth. Image size: 2480px width by 3510px height. Maximum size limit: 10MB. File type: JPG, PNG</p>
         <div>
         '.$banner_image_snippet.'
         </div>
      </div>
	  <input type="file" id="banner_image_field" name="banner_image_field" accept="image/*">
   </div>
   <!---
   <div class="acf-field acf-field-text acf-field-603c905d9b158" data-name="catalogue_url" data-type="text" data-key="field_603c905d9b158">
      <div class="acf-label">
         <label for="acf-field_603c905d9b158">Brochure URL</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_603c905d9b158" name="catalogue_url_field" value ="'.$catalogue_url.'"></div>
      </div>
   </div>
   
   --->
   <div class="acf-field acf-field-url acf-field-603c906f9b159" data-name="video_url" data-type="url" data-key="field_603c906f9b159">
      <div class="acf-label">
         <label for="acf-field_603c906f9b159">Video</label>
         <p class="description">Please make sure video format is in MP4 and <br>size is 1920px width and 1080px height. Max size is 50MB</p>
      </div>
      <div>
      '.$video_url_1_snippet.'
	  </div>
	  <input type="file" id="video_url_field" name="video_url_field" accept="video/*">
   </div>
   <div class="acf-field acf-field-image acf-field-6062a28f880c9" data-name="image_url_1" data-type="image" data-key="field_6062a28f880c9">
      <div class="acf-label">
         <label for="acf-field_6062a28f880c9">Brochure Visual 1</label>
         <p class="description">Please make sure image is 2480px Width and 3510px Height</p>
      </div>
      <div>
      '.$image_url_1_snippet.'
	  </div>
	  <input type="file" id="image_url_1_field" name="image_url_1_field" accept="image/*">
   </div>
   <div class="acf-field acf-field-image acf-field-6062a2dd880ca" data-name="image_url_2" data-type="image" data-key="field_6062a2dd880ca">
      <div class="acf-label">
         <label for="acf-field_6062a2dd880ca">Brochure Visual 2</label>
         <p class="description">Please make sure image is 2480px Width and 3510px Height</p>
      </div>
      <div>
      '.$image_url_2_snippet.'
      </div>
	  <input type="file" id="image_url_2_field" name="image_url_2_field" accept="image/*">
   </div>
   <div class="acf-field acf-field-image acf-field-6062a2e4880cb" data-name="image_url_3" data-type="image" data-key="field_6062a2e4880cb">
      <div class="acf-label">
         <label for="acf-field_6062a2e4880cb">Brochure Visual 3</label>
         <p class="description">Please make sure image is 2480px Width and 3510px Height</p>
      </div>
      <div>
      '.$image_url_3_snippet.'
      </div>
      <input type="file" id="image_url_3_field" name="image_url_3_field" accept="image/*">
   </div>
   <!---
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
   --->
   <div class="acf-field acf-field-text acf-field-604eeb08650e5" data-name="scripts" data-type="text" data-key="field_604eeb08650e5">
      <div class="acf-label">
         <label for="acf-field_604eeb08650e5">NPC scripts</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_604eeb08650e5" name="scripts_field" value="'.$scripts.'"></div>
      </div>
   </div>
   
   <div class="acf-field acf-field-text acf-field-606d5bf9ca9e7" data-name="promocode_text" data-type="text" data-key="field_606d5bf9ca9e7">
      <div class="acf-label">
         <label for="acf-field_606d5bf9ca9e7">Promo code Text</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_606d5bf9ca9e7" name="promocode_text_field" value ="'.$promocode_text.'"></div>
      </div>
   </div>
   <div class="acf-field acf-field-text acf-field-606d5bf9ca9e8" data-name="promocode" data-type="text" data-key="field_606d5bf9ca9e8">
      <div class="acf-label">
         <label for="acf-field_606d5bf9ca9e8">Promo code</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_606d5bf9ca9e8" name="promocode_field" value ="'.$promocode.'"></div>
      </div>
   </div>
   
   <div class="acf-field acf-field-text acf-field-606d5bf9ca9e811" data-name="promocode" data-type="text" data-key="field_606d5bf9ca9e811">
      <div class="acf-label">
         <label for="acf-field_606d5bf9ca9e811">Promo code URL</label>
      </div>
      <div class="acf-input">
         <div class="acf-input-wrap"><input type="text" id="acf-field_606d5bf9ca9e811" name="promocode_url_field" value ="'.$promocode_url.'"></div>
      </div>
   </div>
   
   
   <div style="padding-top:25px;"></div>
   <input class="submitbutton" type="submit" value="Update" name="submit">
</form>';
        

        
    }
}

add_shortcode('booth_details', 'edit_booth_details');