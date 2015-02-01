<?php defined('ABSPATH') or die("No script kiddies please!");

function darc_nh_widget_stats() { 
 if (is_user_logged_in() && get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ) != "") { 
ob_start();

    	$disk_used = darc_list_usage("quota")/(darc_list_config("quota")/100);
	$disk_left = 100-$disk_used;
    	$data_used = darc_list_usage("bandwidth")/(darc_list_config("bandwidth")/100);
	$data_left = 100-$data_used;
	echo '<aside id="darc-widget" class="widget darc-widget" style="font-size: 100%;">
		<h3 class="widget-title">'. __('Account Statics', 'darc-nh').'</h3>';
	if(darc_list_config("quota") != "unlimited"){
		echo '<small>'. __('Disk usage:', 'darc-nh').'</small>
			<table width="100%" border="#FFFFFF">
			<tr style="margin: 0px; padding: 0px;"><td width="'.$disk_used.'%" BGCOLOR="#388e8e" style="color: #FFF;"><center>&nbsp'.round($disk_used).'%&nbsp</center></td>
			<td width="'.$disk_left.'%" BGCOLOR="lightgrey"></td></tr>
	      		</table>';
	} if(darc_list_config("bandwidth") != "unlimited"){
		echo '<small>'. __('Bandwidth usage:', 'darc-nh').'</small>
			<table width="100%" border="#FFFFFF">
			<tr><td width="'.$data_used.'%" BGCOLOR="#388e8e" style="color: #FFF;"><center>&nbsp'.round($data_used).'%&nbsp</center></td>
			<td width="'.$data_left.'%" BGCOLOR="lightgrey"></td></tr>
	      		</table>';
	}
		echo '<br><table width="100%" class="table table-hover" style="font-size: 85%;">
			<tr><td></td><th>'. __('Used', 'darc-nh').'</th><th>'. __('Max.', 'darc-nh').'</th></tr>
			<tr><th>'. __('Disk size', 'darc-nh').'</th><td>'.mb_to_gb(darc_list_usage("quota")).'</td><td>'; if(darc_list_config("quota") != "unlimited"){ echo mb_to_gb(darc_list_config("quota")); }else{ _e('unlimited', 'darc-nh'); } echo '</td></tr>
			<tr><th>'. __('Bandwidth', 'darc-nh').'</th><td>'.mb_to_gb(darc_list_usage("bandwidth")).'</td><td>'; if(darc_list_config("bandwidth") != "unlimited"){ echo mb_to_gb(darc_list_config("bandwidth")); }else{ _e('unlimited', 'darc-nh'); } echo '</td></tr>
			<tr><th>'. __('Domains', 'darc-nh').'</th><td>'.darc_list_usage("vdomains").'</td><td>'; if(darc_list_config("vdomains") != "unlimited"){ echo darc_list_config("vdomains"); }else{ _e('unlimited', 'darc-nh'); } echo '</td></tr>
			<tr><th>'. __('Databases', 'darc-nh').'</th><td>'.darc_list_usage("mysql").'</td><td>'; if(darc_list_config("mysql") != "unlimited"){ echo darc_list_config("mysql"); }else{ _e('unlimited', 'darc-nh'); } echo '</td></tr>
	      		</table>';
		echo '</aside>';

return ob_get_clean();
 }
}
 
function darc_nh_widget_stats_control() {

	echo "<p>You can change the settings for this widget on the plugin settings page.</p>";

}

function init_sidebar_widget() {
  wp_register_sidebar_widget('darc-nh', 'Direct Admin Stats Widget', 'darc_nh_widget_stats', array("description" => "Let your users see their Direct Admin stats."));
  wp_register_widget_control('darc-nh', 'Direct Admin Stats Widget', 'darc_nh_widget_stats_control');
}

?>