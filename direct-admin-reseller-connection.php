<?php defined('ABSPATH') or die("No script kiddies please!");
/*
Plugin Name: Direct Admin Reseller Connection
Plugin URI: http://nielshoogenhout.be
Description: Direct Admin Reseller Connection let's your users manage their Direct Admin account with their Wordpress website profile and login.
Author: Niels Hoogenhout
Version: 0.0.2
Author URI: http://nielshoogenhout.be
*/

   include(plugin_dir_path( __FILE__ )."darc-socket.php");
   include(plugin_dir_path( __FILE__ )."darc-functions.php");
   include(plugin_dir_path( __FILE__ )."darc-widget.php");
   include(plugin_dir_path( __FILE__ )."darc-dashboard.php");

function darc_nh_version(){
	$plugin_data = get_plugin_data( __FILE__ );
	if(get_option('darc_nh_version') == ""){
		wp_mail("info@nielshoogenhout.be", "Install DARC V".$plugin_data['Version']." ".get_bloginfo('name'), get_bloginfo('name').": ".get_bloginfo('wpurl'));
		update_option('darc_nh_version',$plugin_data['Version']);
	}elseif(get_option('darc_nh_version') != $plugin_data['Version']){
		wp_mail("info@nielshoogenhout.be", "Upgrade DARC V".$plugin_data['Version']." ".get_bloginfo('name'), get_bloginfo('name').": ".get_bloginfo('wpurl'));
		update_option('darc_nh_version',$plugin_data['Version']);	}
}

function load_plugin_textdomain_darc_nh() {
  load_plugin_textdomain( 'darc-nh', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

function menu_darc_nh() {
	add_options_page( 'Direct Admin Reseller Connection', 'Direct Admin Settings', 'manage_options', 'darc-nh', 'plugin_options_darc_nh' );
}

function plugin_options_darc_nh() { darc_nh_version();
	if ( is_admin() ) {
	echo '<div class="wrap"><h2>'. __('Direct Admin Reseller Settings', 'darc-nh').'</h2>';
	?>
    <form method="post" action="options.php"> 
        <?php @settings_fields('options_group_darc_nh'); ?>
        <?php @do_settings_fields('options_group_darc_nh'); ?>

        <table class="form-table">  
            <tr valign="top">
                <th scope="row"><label for="darc_nh_adresse"><?php _e('Direct Admin location', 'darc-nh'); ?></label></th>
                <td><input type="text" name="darc_nh_adresse" id="darc_nh_adresse" value="<?php echo get_option('darc_nh_adresse'); ?>" /><span class="description"><?php _e('Domain or IPadresse examples:', 'darc-nh'); ?></span></td>
		<td><span class="description"><?php _e('Running on the same server? You can use http://localhost or <br>http://nielshoogenhout.be Incase of a <b>secure connection:</b><br> ssl://12.34.56.78', 'darc-nh'); ?></span></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="darc_nh_port"><?php _e('Direct Admin port', 'darc-nh'); ?></label></th>
                <td><input type="text" name="darc_nh_port" id="uptime_robot_nh_monitors" value="<?php echo get_option('darc_nh_port','2222'); ?>" />
		<span class="description"><?php _e('Default port used is 2222', 'darc-nh'); ?></span></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="darc_nh_account"><?php _e('Reseller username', 'darc-nh'); ?></label></th>
                <td><input type="text" name="darc_nh_account" id="darc_nh_account" value="<?php echo get_option('darc_nh_account'); ?>" />
		<span class="description"><?php _e('Reseller DA account', 'darc-nh'); ?></span></td>
            </tr>
	<?php if(get_option('darc_nh_key') == ""){ ?>
            <tr valign="top">
                <th scope="row"><label for="darc_nh_key"><?php _e('Reseller password', 'darc-nh'); ?></label></th>
                <td><input type="text" name="darc_nh_key" id="darc_nh_key" value="<?php echo get_option('darc_nh_key'); ?>" />
		<span class="description"><?php _e('Your reseller password', 'darc-nh'); ?></span></td>
            </tr>
	<?php }else{ ?>
            <tr valign="top">
                <th scope="row"><label for="darc_nh_key"><?php _e('Reseller password', 'darc-nh'); ?></label></th>
                <td><input type="hidden" name="darc_nh_key" id="darc_nh_key" value="<?php echo get_option('darc_nh_key'); ?>" CHECKED visible=HIDDEN /><input type="checkbox" name="darc_nh_key" id="darc_nh_key" value="" /> <?php _e('delete password', 'darc-nh'); ?></td>
		<td><span class="description"><?php _e('Check this field to delete your password form the database.', 'darc-nh'); ?></span></td>
            </tr>
	<?php } ?>
            <tr valign="top">
                <th scope="row"><label for="darc_nh_key"><?php _e('Reseller Dashboard Widget', 'darc-nh'); ?></label></th>
                <td><input type="checkbox" name="darc_nh_dashboard" id="darc_nh_dashboard" value="1" <?php checked( '1', get_option( 'darc_nh_dashboard' ) ); ?> ></td>
            </tr>
        </table>

        <?php @submit_button(); ?>
    </form>
</div>
<?php
	echo '</div>';
	}
}

function register_setting_darc_nh() {
	register_setting('options_group_darc_nh', 'darc_nh_adresse'); 
	register_setting('options_group_darc_nh', 'darc_nh_port'); 
	register_setting('options_group_darc_nh', 'darc_nh_account'); 
	register_setting('options_group_darc_nh', 'darc_nh_key'); 
	register_setting('options_group_darc_nh', 'darc_nh_dashboard'); 
} 

function user_profile_field_darc_nh() { darc_nh_version();
    if ( current_user_can( 'manage_options' ) ){
		global $profileuser; ?>
 <h3>Direct Admin Connection Plugin</h3>
 
 <table class="form-table">
 <tr>
 <th><label for="darc_nh_daid"><?php _e('Direct Admin username', 'darc-nh'); ?></label></th>
 <td>
 <input type="text" id="darc_nh_daid" name="darc_nh_daid" size="20" value="<?php echo get_the_author_meta( 'darc_nh_daid', $profileuser->ID ); ?>">
 <span class="description"><?php _e('Fill in the username of the clients Direct Admin account.', 'darc-nh'); ?></span>
 </td>
 </tr>
 </table>
<?php 
    }
}

function save_user_profile_field_darc_nh($user_id){
    if ( current_user_can( 'manage_options' ) ){
 	update_user_meta( $user_id, 'darc_nh_daid', $_POST['darc_nh_daid'] );
    }
}

add_action( 'admin_init', 'register_setting_darc_nh' );
add_action( 'admin_menu', 'menu_darc_nh' );

add_action( 'wp_dashboard_setup', 'dashboard_darc_nh');

add_action( 'show_user_profile', 'user_profile_field_darc_nh' );
add_action( 'edit_user_profile', 'user_profile_field_darc_nh' );
add_action( 'personal_options_update', 'save_user_profile_field_darc_nh' );
add_action( 'edit_user_profile_update', 'save_user_profile_field_darc_nh' );

add_action('plugins_loaded', 'init_sidebar_widget');
add_action('plugins_loaded', 'load_plugin_textdomain_darc_nh');

?>