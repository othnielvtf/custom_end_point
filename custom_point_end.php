<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              lkythemag@ymail.com
 * @since             1.0.0
 * @package           Custom_point_end
 *
 * @wordpress-plugin
 * Plugin Name:       custom_point_end
 * Plugin URI:        custom_point_end
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            lky
 * Author URI:        lkythemag@ymail.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom_point_end
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC'))
{
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('CUSTOM_POINT_END_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custom_point_end-activator.php
 */
function activate_custom_point_end()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-custom_point_end-activator.php';
    Custom_point_end_Activator::activate();
    
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    global $wpdb;

    $player_feedbacks_sql_create = "CREATE TABLE player_feedbacks 
    ( id INT NOT NULL AUTO_INCREMENT ,  user_id INT NOT NULL ,  
      coordinate_x float NOT NULL,
      coordinate_y float NOT NULL,
      coordinate_z float NOT NULL,
      uploaded_url text COLLATE utf8mb4_unicode_520_ci	 NOT NULL,
      description text COLLATE utf8mb4_unicode_520_ci	 NOT NULL,
    description TEXT NOT NULL ,  timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,    
    PRIMARY KEY  (id)) ENGINE=InnoDB ;";

    maybe_create_table("player_feedbacks", $player_feedbacks_sql_create);
    
    $npcs_sql_create = "CREATE TABLE npcs ( id INT NOT NULL AUTO_INCREMENT ,  
    hall_id int(11) NOT NULL, name TEXT NOT NULL ,  scripts TEXT NOT NULL ,  coordinate_x FLOAT NOT NULL ,  
    coordinate_y FLOAT NOT NULL ,  coordinate_z FLOAT NOT NULL ,    
    PRIMARY KEY  (id)) ENGINE = InnoDB;";
    
    maybe_create_table("npcs", $npcs_sql_create);
    
    $player_booth_likes_sql_create = "CREATE TABLE player_booth_likes ( id INT NOT NULL AUTO_INCREMENT , 
    user_id INT NOT NULL , booth_id INT NOT NULL, vendor_id INT NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB;";
    
    maybe_create_table("player_booth_likes", $player_booth_likes_sql_create);
    
    $hall_priority_sql_create = "CREATE TABLE hall_priority ( id INT NOT NULL AUTO_INCREMENT , 
    hall_name TEXT NOT NULL , sequence INT NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB;";
    
    maybe_create_table("hall_priority", $hall_priority_sql_create);
    
    $schedule_notifications_sql_create = "CREATE TABLE schedule_notifications ( id INT NOT NULL AUTO_INCREMENT ,  
    title TEXT NOT NULL ,  description TEXT NOT NULL ,  target_date DATE NOT NULL ,  target_hour INT NOT NULL ,  
    target_min INT NOT NULL ,buffer_mins int(11) NOT NULL, is_active int(11) NOT NULL DEFAULT '1',  PRIMARY KEY  (id)) ENGINE = InnoDB;";
    
    $player_booth_name_cards_sql_create = "CREATE TABLE player_booth_name_cards ( id int NOT NULL AUTO_INCREMENT, 
    user_id int NOT NULL, booth_id int NOT NULL, vendor_id INT NOT NULL , player_name text NOT NULL, company_name text NOT NULL, 
    job_title text NOT NULL COMMENT 'renamed as ''position'' in game', 
    mobile_number text NOT NULL COMMENT 'renamed as ''phone'' in game', email text NOT NULL, 
    time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id) ) ENGINE=InnoDB";
    
    maybe_create_table("player_booth_name_cards", $player_booth_name_cards_sql_create);
    
    $player_promocodes_sql_create = "CREATE TABLE player_promocodes ( id INT NOT NULL AUTO_INCREMENT ,  
    user_id INT NOT NULL ,  booth_id INT NOT NULL ,  vendor_id INT NOT NULL ,  promocode TEXT NOT NULL ,  promocode_url TEXT NOT NULL ,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY  (id)) ENGINE = InnoDB;";
    
    maybe_create_table("player_promocodes", $player_promocodes_sql_create);
    
    $missions_sql_create = "CREATE TABLE missions ( id INT NOT NULL AUTO_INCREMENT ,  
    mission_type INT NOT NULL ,  action_type INT NOT NULL , target_type TEXT NOT NULL,  target_value TEXT,  description TEXT ,  
    is_active int(11) NOT NULL DEFAULT '1',
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY  (id)) ENGINE = InnoDB;";
    
    maybe_create_table("missions", $missions_sql_create);
    
    $player_missions_sql_create = "CREATE TABLE player_missions ( id INT NOT NULL AUTO_INCREMENT ,
    user_id INT NOT NULL ,  mission_id INT NOT NULL ,  value TEXT,  
    completed INT NOT NULL ,  timestamp TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,    
    PRIMARY KEY  (id)) ENGINE = InnoDB;";
    
    maybe_create_table("player_missions", $player_missions_sql_create);
    
    $mission_report_sql_create = "CREATE TABLE mission_report (
    id int(11) NOT NULL AUTO_INCREMENT, mission_id int(11) NOT NULL, mission_description text NOT NULL,
    hall text NOT NULL, floor text NOT NULL, booth_id text NOT NULL, action text NOT NULL, user_id int(11) NOT NULL,
    player_name text NOT NULL, player_email text NOT NULL, company_name text NOT NULL, completed int(11) NOT NULL,
    completed_date date NOT NULL, completed_time time NOT NULL, time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)) ENGINE=MyISAM;";
    
    maybe_create_table("mission_report", $mission_report_sql_create);
    
    $schedule_events_sql_create = "CREATE TABLE schedule_events (
    id int(11) NOT NULL AUTO_INCREMENT, title text NOT NULL, description text NOT NULL, target_date date NOT NULL,
    target_hour int(11) NOT NULL, target_min int(11) NOT NULL, buffer_mins int(11) NOT NULL,
    is_active int(11) NOT NULL DEFAULT '1', PRIMARY KEY (id)) ENGINE=InnoDB;";
    
    maybe_create_table("schedule_events", $schedule_events_sql_create);
    
    $treasures_sql_create = "CREATE TABLE treasures (
    id int(11) NOT NULL AUTO_INCREMENT, treasure_id int(11) NOT NULL, event_id int(11) NOT NULL, user_id int(11) NOT NULL,
    player_name text NOT NULL, company_name text NOT NULL, job_title text NOT NULL, mobile_number text NOT NULL, email text NOT NULL,
    time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id)) ENGINE=InnoDB;";
    
    maybe_create_table("treasures", $treasures_sql_create);
    
    $event_users_sql_create = "CREATE TABLE event_users (
    id int(11) NOT NULL AUTO_INCREMENT, event_id int(11) NOT NULL,
    email text NOT NULL, user_name text NOT NULL, time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id)) ENGINE=InnoDB;";
    
    maybe_create_table("event_users", $event_users_sql_create);
    
    $event_sql_create = "CREATE TABLE events (
    id int(11) NOT NULL AUTO_INCREMENT, user_id int(11) NOT NULL, name text,
    description text, pun_id text, chat_id text, welcome_message text,
    banner_url text, color text, email text, mobile_number text,
    contact_person text, company_name text, 
    company_url text, ecommerce_url text,
    catalogue_url text, secondary_color text, video_url text,
    live_stream_url text, whatsapp_url text, facebook_url text,
    instagram_url text, linkedin_url text, scripts text,
    image_url_1 text, image_url_2 text, image_url_3 text, image_url_4 text,
    image_url_5 text, image_url_6 text, image_url_7 text,
    active int(11) NOT NULL DEFAULT '1',
    timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id)
    ) ENGINE=InnoDB;";
    
    maybe_create_table("events", $event_users_sql_create);
    
    $marquees_sql_create = "CREATE TABLE marquees (
    id int(11) NOT NULL AUTO_INCREMENT,
    event_id  int(11) NOT NULL,
    display_text text NOT NULL,
    active int(11) NOT NULL DEFAULT '1',
    PRIMARY KEY (id)
    ) ENGINE=InnoDB COMMENT='This is for conference module';";
    
    maybe_create_table("marquees", $marquees_sql_create);
    
    $advertisments_sql_create = "CREATE TABLE advertisments (
    id int(11) NOT NULL AUTO_INCREMENT,
    event_id int(11) NOT NULL,
    name text NOT NULL,
    image_url text NOT NULL,
    external_url text,
    active int(11) NOT NULL DEFAULT '1',
    PRIMARY KEY (id)
    ) ENGINE=InnoDB COMMENT='This is for conference module';";
    
    maybe_create_table("advertisments", $advertisments_sql_create);
    
    $flash_sales_sql_create = "CREATE TABLE flash_sales (
      id int(11) NOT NULL AUTO_INCREMENT,
      name text NOT NULL,
      description text NOT NULL,
      price text NOT NULL,
      product_image text NOT NULL,
      web_url text NOT NULL,
      target_date date NOT NULL,
      target_hour int(11) NOT NULL,
      target_min int(11) NOT NULL,
      buffer_mins int(11) NOT NULL,
      is_active int(11) NOT NULL DEFAULT '1',
      time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (id)
    ) ENGINE=InnoDB;";
    
    maybe_create_table("flash_sales", $flash_sales_sql_create);
    
    $my_settings_sql_create = "CREATE TABLE my_settings (
    id int(11) NOT NULL AUTO_INCREMENT,
    name text,
    value text,
    PRIMARY KEY (id)
    ) ENGINE=InnoDB COMMENT='This is for conference module';";
    
    maybe_create_table("my_settings", $my_settings_sql_create);
    
    $player_bookmarks_sql_create = "CREATE TABLE player_bookmarks ( id INT NOT NULL AUTO_INCREMENT , 
        user_id INT NOT NULL , booth_id INT NOT NULL, 
        timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)) ENGINE = InnoDB;";
    
    maybe_create_table("player_bookmarks", $player_bookmarks_sql_create);
    
    //insert wp_prefix with table
    $count = $wpdb->get_var( "SELECT COUNT(*) FROM my_settings where name = 'table_prefix'" );
    
    $data = array(
                    'name' => "table_prefix",
                    'value' => $wpdb->prefix,
                );
                
    $result = "";
                
    if($count > 0)
    {
        $result = $wpdb->update("my_settings", $data, array('name' => "table_prefix"));
    }
    else
    {
        $result = $wpdb->insert("my_settings", $data);
    }
    
    $count = $wpdb->get_var( "SELECT COUNT(*) FROM my_settings where name = 'link_event_url'" );
    
    $data = array(
                    'name' => "link_event_url",
                    'value' => get_permalink( get_page_by_title( 'Event Detail' ) )
                    //home_url(),
                );
                
    $result = "";
                
    if($count > 0)
    {
        $result = $wpdb->update("my_settings", $data, array('name' => "link_event_url"));
    }
    else
    {
        $result = $wpdb->insert("my_settings", $data);
    }
    
    $event_quizzes_sql_create = "CREATE TABLE event_quizzes (
        id int(11) NOT NULL AUTO_INCREMENT,
        question text NOT NULL,
        correct_answer_id int(11) NOT NULL,
        tries int(11) NOT NULL,
        time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
        ) ENGINE = InnoDB;";
    
    maybe_create_table("event_quizzes", $event_quizzes_sql_create);
    
    $quiz_answers_sql_create = "CREATE TABLE quiz_answers (
        id int(11) NOT NULL AUTO_INCREMENT,
        answer_text text NOT NULL,
        time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
        ) ENGINE = InnoDB;";
    
    maybe_create_table("quiz_answers", $quiz_answers_sql_create);
    
    $player_answers_sql_create = "CREATE TABLE player_answers (
        id int(11) NOT NULL AUTO_INCREMENT,
        quiz_id int(11) NOT NULL,
        answer_id int(11) NOT NULL,
        user_id int(11) NOT NULL,
        time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
        ) ENGINE = InnoDB;";
    
    maybe_create_table("player_answers", $player_answers_sql_create);
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custom_point_end-deactivator.php
 */
function deactivate_custom_point_end()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-custom_point_end-deactivator.php';
    Custom_point_end_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_custom_point_end');
register_deactivation_hook(__FILE__, 'deactivate_custom_point_end');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-custom_point_end.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_custom_point_end()
{
    $plugin = new Custom_point_end();
    $plugin->run();
}
run_custom_point_end();

include_once plugin_dir_path(__FILE__) . 'base/user/main.php';
include_once plugin_dir_path(__FILE__) . 'base/feedback/main.php';
include_once plugin_dir_path(__FILE__) . 'base/npc/main.php';
include_once plugin_dir_path(__FILE__) . 'base/booth/main.php';
include_once plugin_dir_path(__FILE__) . 'base/hall/main.php';
include_once plugin_dir_path(__FILE__) . 'base/setting/main.php';
include_once plugin_dir_path(__FILE__) . 'base/report/main.php';
include_once plugin_dir_path(__FILE__) . 'base/treasure/main.php';
include_once plugin_dir_path(__FILE__) . 'base/orders/main.php';
include_once plugin_dir_path(__FILE__) . 'base/event/main.php';