<?php defined('ABSPATH') or die("No script kiddies please!");

function dashboard_widget_darc_nh() {
 	echo '<table width="100%" class="table table-hover">
		<tr><td></td><td><b>'. __('Used', 'darc-nh').'</b></td><td><b>'. __('Max.', 'darc-nh').'</b></td></tr>
		<tr><td>'. __('Disk size', 'darc-nh').'</td><td>'.mb_to_gb(darc_list_reseller_usage("quota","usage")).'</td><td>'; if(darc_list_reseller_usage("quota","") != "unlimited"){ echo mb_to_gb(darc_list_reseller_usage("quota","")); 
			 echo '<td><table width="50"><tr height="10"><td width="'.total_percentage(darc_list_reseller_usage("quota",""),darc_list_reseller_usage("quota","usage"),"part").'%" BGCOLOR="#388e8e"></td><td BGCOLOR="lightgrey" width="'.total_percentage(darc_list_reseller_usage("quota",""),darc_list_reseller_usage("quota","usage"),"left").'%"></td></tr></table>
			<td>'.round(total_percentage(darc_list_reseller_usage("quota",""),darc_list_reseller_usage("quota","usage"),"part")).'%</td></td>';
		 }else{ _e('unlimited', 'darc-nh'); } echo '</td></tr>
		<tr><td>'. __('Bandwidth', 'darc-nh').'</td><td>'.mb_to_gb(darc_list_reseller_usage("bandwidth","usage")).'</td><td>'; if(darc_list_reseller_usage("bandwidth","") != "unlimited"){ echo mb_to_gb(darc_list_reseller_usage("bandwidth",""));
			 echo '<td><table width="50"><tr height="10"><td width="'.total_percentage(darc_list_reseller_usage("bandwidth",""),darc_list_reseller_usage("bandwidth","usage"),"part").'%" BGCOLOR="#388e8e"></td><td BGCOLOR="lightgrey" width="'.total_percentage(darc_list_reseller_usage("bandwidth",""),darc_list_reseller_usage("bandwidth","usage"),"left").'%"></td></tr></table>
			<td>'.round(total_percentage(darc_list_reseller_usage("bandwidth",""),darc_list_reseller_usage("bandwidth","usage"),"part")).'%</td></td>';
		 }else{ _e('unlimited', 'darc-nh'); } echo '</td></tr>
		<tr><td>'. __('Domains', 'darc-nh').'</td><td>'; if(darc_list_reseller_usage("vdomains","usage") != "unlimited"){ echo darc_list_reseller_usage("vdomains","usage"); }else{ _e('unlimited', 'darc-nh'); } echo '</td><td>'; if(darc_list_reseller_usage("vdomains","") != "unlimited"){ echo darc_list_reseller_usage("vdomains",""); 
			 echo '<td><table width="50"><tr height="10"><td width="'.total_percentage(darc_list_reseller_usage("vdomains",""),darc_list_reseller_usage("vdomains","usage"),"part").'%" BGCOLOR="#388e8e"></td><td BGCOLOR="lightgrey" width="'.total_percentage(darc_list_reseller_usage("vdomains",""),darc_list_reseller_usage("vdomains","usage"),"left").'%"></td></tr></table>
			<td>'.round(total_percentage(darc_list_reseller_usage("vdomains",""),darc_list_reseller_usage("vdomains","usage"),"part")).'%</td></td>';
		 }else{ _e('unlimited', 'darc-nh'); } echo '</td></tr>
		<tr><td>'. __('Databases', 'darc-nh').'</td><td>'; if(darc_list_reseller_usage("mysql","usage") != "unlimited"){ echo darc_list_reseller_usage("mysql","usage"); }else{ _e('unlimited', 'darc-nh'); } echo '</td><td>'; if(darc_list_reseller_usage("mysql","") != "unlimited"){ echo darc_list_reseller_usage("mysql",""); 
			 echo '<td><table width="50"><tr height="10"><td width="'.total_percentage(darc_list_reseller_usage("mysql",""),darc_list_reseller_usage("mysql","usage"),"part").'%" BGCOLOR="#388e8e"></td><td BGCOLOR="lightgrey" width="'.total_percentage(darc_list_reseller_usage("mysql",""),darc_list_reseller_usage("mysql","usage"),"left").'%"></td></tr></table>
			<td>'.round(total_percentage(darc_list_reseller_usage("mysql",""),darc_list_reseller_usage("mysql","usage"),"part")).'%</td></td>';
		 }else{ _e('unlimited', 'darc-nh'); } echo '</td></tr>

	</table>';
}

function dashboard_darc_nh() {
   if(get_option('darc_nh_dashboard') == 1){
	wp_add_dashboard_widget('darc-nh-dashboard','Direct Admin','dashboard_widget_darc_nh');
   }
}

?>