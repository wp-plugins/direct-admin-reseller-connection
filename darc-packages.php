<?php defined('ABSPATH') or die("No script kiddies please!");

function darc_nh_page_packages( $atts ) {

ob_start();

	$atts = shortcode_atts( array(	'pack' => 'all',
					'price' => '0',
					'quota' => 'yes',
					'bandwidth' => 'yes',
					'mysql' => 'yes',
					'vdomains' => 'yes',
					'nsubdomains' => 'no',
					'nemails' => 'yes',
					'nemailf' => 'no',
					'domainptr' => 'no',
					'ftp' => 'no',
					'aftp' => 'no',
					'ssl' => 'no',
					'cron' => 'no',
					'dnscontrol' => 'yes',
					'suspend' => 'yes'), $atts);

   if($atts['pack'] == 'all'){ $packs = darc_list_packages(); }else{ $packs = $atts['pack']; }
	$prices = explode("-", $atts['price']); $pid = 0;
	$packs = explode("-", $packs);
			echo '<table width="100%" class="table table-hover"><tbody><tr><th></th>';
		foreach($packs as $pack){
			echo '<th>'.$pack.'</th>';
		}
	if($atts['quota'] == "yes"){
			echo '</tr><tr><th>'. __('Disk space', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'quota') == "unlimited"){ echo '<td>'.__('unlimited', 'darc-nh').'</td>'; }else{
			echo '<td>'.darc_list_package($pack,'quota').'</td>';
		   }
		}
	}
	if($atts['bandwidth'] == "yes"){
			echo '</tr><tr><th>'. __('Bandwidth', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'bandwidth') == "unlimited"){ echo '<td>'.__('unlimited', 'darc-nh').'</td>'; }else{
			echo '<td>'.darc_list_package($pack,'bandwidth').'</td>';
		   }
		}
	}
	if($atts['mysql'] == "yes"){
			echo '</tr><tr><th>'. __('MySQL databases', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'mysql') == "unlimited"){ echo '<td>'.__('unlimited', 'darc-nh').'</td>'; }else{
			echo '<td>'.darc_list_package($pack,'mysql').'</td>';
		   }
		}
	}
	if($atts['vdomains'] == "yes"){
			echo '</tr><tr><th>'. __('Domains', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'vdomains') == "unlimited"){ echo '<td>'.__('unlimited', 'darc-nh').'</td>'; }else{
			echo '<td>'.darc_list_package($pack,'vdomains').'</td>';
		   }
		}
	}
	if($atts['nsubdomains'] == "yes"){
			echo '</tr><tr><th>'. __('Subdomains', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'nsubdomains') == "unlimited"){ echo '<td>'.__('unlimited', 'darc-nh').'</td>'; }else{
			echo '<td>'.darc_list_package($pack,'nsubdomains').'</td>';
		   }
		}
	}
	if($atts['nemails'] == "yes"){
			echo '</tr><tr><th>'. __('Email accounts', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'nemails') == "unlimited"){ echo '<td>'.__('unlimited', 'darc-nh').'</td>'; }else{
			echo '<td>'.darc_list_package($pack,'nemails').'</td>';
		   }
		}
	}
	if($atts['nemailf'] == "yes"){
			echo '</tr><tr><th>'. __('Email forwarders', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'nemailf') == "unlimited"){ echo '<td>'.__('unlimited', 'darc-nh').'</td>'; }else{
			echo '<td>'.darc_list_package($pack,'nemailf').'</td>';
		   }
		}
	}
	if($atts['domainptr'] == "yes"){
			echo '</tr><tr><th>'. __('Domainpointers', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'domainptr') == "unlimited"){ echo '<td>'.__('unlimited', 'darc-nh').'</td>'; }else{
			echo '<td>'.darc_list_package($pack,'domainptr').'</td>';
		   }
		}
	}
	if($atts['ftp'] == "yes"){
			echo '</tr><tr><th>'. __('FTP accounts', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'ftp') == "unlimited"){ echo '<td>'.__('unlimited', 'darc-nh').'</td>'; }else{
			echo '<td>'.darc_list_package($pack,'ftp').'</td>';
		   }
		}
	}
	if($atts['aftp'] == "yes"){
			echo '</tr><tr><th>'. __('Anonymous FTP', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'aftp') == "ON"){ echo '<td style="color: #006600;">&#10004;</td>'; }else{
			echo '<td style="color: #FF0000;">&#10008;</td>';
		   }
		}
	}
	if($atts['ssl'] == "yes"){
			echo '</tr><tr><th>'. __('SSL', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'ssl') == "ON"){ echo '<td style="color: #006600;">&#10004;</td>'; }else{
			echo '<td style="color: #FF0000;">&#10008;</td>';
		   }
		}
	}
	if($atts['cron'] == "yes"){
			echo '</tr><tr><th>'. __('Cronjobs', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'cron') == "ON"){ echo '<td style="color: #006600;">&#10004;</td>'; }else{
			echo '<td style="color: #FF0000;">&#10008;</td>';
		   }
		}
	}
	if($atts['dnscontrol'] == "yes"){
			echo '</tr><tr><th>'. __('DNS control', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'dnscontrol') == "ON"){ echo '<td style="color: #006600;">&#10004;</td>'; }else{
			echo '<td style="color: #FF0000;">&#10008;</td>';
		   }
		}
	}
	if($atts['suspend'] == "yes"){
			echo '</tr><tr><th>'. __('Flexible bandwidth limit', 'darc-nh').'</th>';
		foreach($packs as $pack){
		   if(darc_list_package($pack,'suspend_at_limit') == "ON"){ echo '<td style="color: #FF0000;">&#10008;</td>'; }else{
			echo '<td style="color: #006600;">&#10004;</td>';
		   }
		}
	}
	if($prices[0] != 0){
			echo '</tr><tr><th>'. __('Price', 'darc-nh').'</th>';
		foreach($packs as $pack){ 
			echo '<td>'.get_option('darc_nh_currency','&euro;').''.$prices[$pid].' '.get_option('darc_nh_priceperiode','p/m').'</td>'; $pid = $pid+1;
		   }
	}

			echo '</tr></table>';
return ob_get_clean();
}

?>