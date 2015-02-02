<?php defined('ABSPATH') or die("No script kiddies please!");
/*
Plugin Name: Direct Admin Reseller Connection
Plugin URI: https://wordpress.org/plugins/direct-admin-reseller-connection/
Description: Direct Admin Reseller Connection let's your users manage their Direct Admin account with their Wordpress website profile and login.
Author: Niels Hoogenhout
Version: 0.2.3
Author URI: http://nielshoogenhout.be
*/

   include(plugin_dir_path( __FILE__ )."darc-socket.php");
   include(plugin_dir_path( __FILE__ )."darc-functions.php");
   include(plugin_dir_path( __FILE__ )."darc-widget.php");
   include(plugin_dir_path( __FILE__ )."darc-dashboard.php");
   include(plugin_dir_path( __FILE__ )."darc-mail.php");
   include(plugin_dir_path( __FILE__ )."darc-domain.php");
   include(plugin_dir_path( __FILE__ )."darc-packages.php");

function darc_nh_version(){
	$plugin_data = get_plugin_data( __FILE__ );
	if(get_option('darc_nh_version') == ""){
		update_option('darc_nh_version',$plugin_data['Version']);
	}elseif(get_option('darc_nh_version') != $plugin_data['Version']){
		update_option('darc_nh_version',$plugin_data['Version']);	}
}

function darc_nh_scripts() {

	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');

}

function load_plugin_textdomain_darc_nh() {
  load_plugin_textdomain( 'darc-nh', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

function menu_darc_nh() {
	add_options_page( 'Direct Admin Reseller Connection', 'Direct Admin Settings', 'manage_options', 'darc-nh', 'plugin_options_darc_nh' );
}

function plugin_options_darc_nh() {
	if ( is_admin() ) {
	?>

	<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $('a[darc-settings-page^=#darc-option]').click(function() { event.preventDefault();
	  	var div = $(this).attr('darc-settings-page');
 		$(".wp-darc-set").hide(); 
       		$(div).show();
	    });
	});
	</script>

<div style="position: fixed; right; top: 60px; right: 30px;">
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="ENVJCYHTHYDVJ">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/nl_NL/i/scr/pixel.gif" width="1" height="1">
        </form>
</div>

    <form method="post" action="options.php"> 
      <?php @settings_fields('options_group_darc_nh'); ?>
        <?php @do_settings_fields('options_group_darc_nh'); ?>
 	<?php echo '<div class="wrap"><h2>'. __('Direct Admin Reseller Settings', 'darc-nh').'</h2>'; ?>

<a darc-settings-page="#darc-option-1" class="button button-primary"><?php _e('Connection DA', 'darc-nh'); ?></a> <a darc-settings-page="#darc-option-2" class="button button-primary"><?php _e('Extra settings', 'darc-nh'); ?></a> <a darc-settings-page="#darc-option-3" class="button button-primary"><?php _e('Shortcode examples', 'darc-nh'); ?></a> <a href="https://wordpress.org/support/plugin/direct-admin-reseller-connection" target="_blank" class="button button-primary"><?php _e('Support', 'darc-nh'); ?></a> <a href="http://nielshoogenhout.be/support/contact/" target="_blank" class="button button-primary"><?php _e('Contact', 'darc-nh'); ?></a>

<div id="darc-option-1" class="wp-darc-set">
         <table class="form-table">  
            <tr valign="top">
                <th scope="row"><label for="darc_nh_adresse"><?php _e('Direct Admin location', 'darc-nh'); ?></label></th>
                <td><input type="text" name="darc_nh_adresse" id="darc_nh_adresse" value="<?php echo get_option('darc_nh_adresse','localhost'); ?>" /><span class="description"><?php _e('Domain or IPadresse examples:', 'darc-nh'); ?></span></td>
		<td><span class="description"><?php _e('Running on the same server? You can use "localhost". Incase of a <b>secure connection:</b><br> ssl://12.34.56.78 or ssl://localhost', 'darc-nh'); ?></span></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="darc_nh_port"><?php _e('Direct Admin port', 'darc-nh'); ?></label></th>
                <td><input type="text" name="darc_nh_port" id="darc_nh_port" value="<?php echo get_option('darc_nh_port','2222'); ?>" />
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

</div><div id="darc-option-2" class="wp-darc-set" style="display: none;">

         <table class="form-table">  
            <tr valign="top">
                <th scope="row"><label for="darc_nh_currency"><?php _e('Currency', 'darc-nh'); ?></label></th>
                <td><input type="text" name="darc_nh_currency" id="darc_nh_currency" value="<?php echo get_option('darc_nh_currency','&euro;'); ?>" /></td>
		<td></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="darc_nh_priceperiode"><?php _e('Price periode', 'darc-nh'); ?></label></th>
                <td><input type="text" name="darc_nh_priceperiode" id="darc_nh_priceperiode" value="<?php echo get_option('darc_nh_priceperiode','p/m'); ?>" />
		<td></td>
            </tr>
        </table>
        <?php @submit_button(); ?>

</div>
    </form>

  <div id="darc-option-3" class="wp-darc-set" style="display: none;">
 	<?php echo '<h3>'. __('Email account management:', 'darc-nh').'</h3>'; ?>
 	<?php echo '<input type="text" size="25" value="[darc-nh-page-mail]" onclick="this.select()">'.__('No settings needed', 'darc-nh'); ?>
 	<?php echo '<h3>'. __('Domainpointer settings:', 'darc-nh').'</h3>'; ?>
 	<?php echo '<input type="text" size="25" value="[darc-nh-page-domain]" onclick="this.select()">'.__('No settings needed', 'darc-nh'); ?>
 	<?php echo '<h3>'. __('Webhosting packages:', 'darc-nh').'</h3>'; ?>
 	<?php echo __('For the webhosting package shortcode there are different extra settings you can added to the shortcode. You can combine several option together to change the display to your prefference.', 'darc-nh').'<br>'; ?>
 	<?php echo '<input type="text" size="25" value="[darc-nh-page-packages]" onclick="this.select()">'.__('To use all default settings', 'darc-nh').'<br>'; ?>
 	<?php echo '<input type="text" size="60" value="[darc-nh-page-packages pack=Small-Medium price=1,00-2,50]" onclick="this.select()">'.__('Show only the Small and Medium pack and added the price.', 'darc-nh').'<br>'; ?>
 	<?php echo '<input type="text" size="60" value="[darc-nh-page-packages pack=Small price=1,75 bandwidth=no]" onclick="this.select()">'.__('Show only the Small pack with default values, but hide the bandwidth, and added the price.', 'darc-nh').'<br>'; ?>
<table bordercolor="#fff" border="1">
	<?php echo '<tr><td><b>'.__('Setting', 'darc-nh').'<b></td><td><b>'.__('Values', 'darc-nh').'<b></td><td><b>'.__('Default', 'darc-nh').'</b></td><td><b>'.__('Info', 'darc-nh').'</b></td></tr>'; ?>
	<?php echo '<tr><td>pack</td><td></td><td>'.__('all', 'darc-nh').'</td><td>'.__('Enter the name(s) of the packages you would like to show, use a - to seperate the packages', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>price</td><td>number</td><td>'.__('no', 'darc-nh').'</td><td>'.__('Price of the pack seperated by a - with multiple packages. No price will hide the price field', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>quota</td><td>yes|no</td><td>'.__('yes', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('disksize', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>bandwidth</td><td>yes|no</td><td>'.__('yes', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('amount of bandwidth', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>mysql</td><td>yes|no</td><td>'.__('yes', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('number of mysql databases', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>vdomains</td><td>yes|no</td><td>'.__('yes', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('number of domains possible', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>nsubdomains</td><td>yes|no</td><td>'.__('no', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('number of subdomains possible', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>nemails</td><td>yes|no</td><td>'.__('yes', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('number of Email accounts possible', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>nemailf</td><td>yes|no</td><td>'.__('no', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('number of Email forwarders possible', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>domainptr</td><td>yes|no</td><td>'.__('no', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('number of domainpointers possible', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>ftp</td><td>yes|no</td><td>'.__('no', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('number of ftp accounts possible', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>aftp</td><td>yes|no</td><td>'.__('no', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('anonymous ftp setting', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>ssl</td><td>yes|no</td><td>'.__('no', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('SSL setting', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>cron</td><td>yes|no</td><td>'.__('no', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('cron setting', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>dnscontrol</td><td>yes|no</td><td>'.__('yes', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('DNS control setting', 'darc-nh').'</td></tr>'; ?>
	<?php echo '<tr><td>suspend</td><td>yes|no</td><td>'.__('yes', 'darc-nh').'</td><td>'.__('Show/hide the', 'darc-nh').' '.__('suspend on limit setting', 'darc-nh').'</td></tr>'; ?>
</table>
  </div>

</div>
<?php
	echo '</div>';
	}
}

function plugin_options_darc_nh2() {
	if ( is_admin() ) {
	echo '<div class="wrap"><h2>'. __('Direct Admin Reseller Settings', 'darc-nh').'</h2>';
	?>
tzee
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
	register_setting('options_group_darc_nh', 'darc_nh_currency');
	register_setting('options_group_darc_nh', 'darc_nh_priceperiode');
} 

function user_profile_field_darc_nh() {
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


function register_shortcodes_darc_nh(){
   add_shortcode('darc-nh-page-mail', 'darc_nh_page_mail');
   add_shortcode('darc-nh-page-domain', 'darc_nh_page_domain');
   add_shortcode('darc-nh-page-packages', 'darc_nh_page_packages');
}

add_action( 'admin_init', 'register_setting_darc_nh' );
add_action( 'admin_menu', 'menu_darc_nh' );
add_action( 'admin_menu', 'darc_nh_version' );

add_action( 'wp_dashboard_setup', 'dashboard_darc_nh');

add_action( 'show_user_profile', 'user_profile_field_darc_nh' );
add_action( 'edit_user_profile', 'user_profile_field_darc_nh' );
add_action( 'personal_options_update', 'save_user_profile_field_darc_nh' );
add_action( 'edit_user_profile_update', 'save_user_profile_field_darc_nh' );

add_action('plugins_loaded', 'init_sidebar_widget');
add_action('plugins_loaded', 'load_plugin_textdomain_darc_nh');

add_action( 'wp_enqueue_scripts', 'darc_nh_scripts' );

add_action( 'init', 'register_shortcodes_darc_nh');

?>