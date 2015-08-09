<?php defined('ABSPATH') or die("No script kiddies please!");

function darc_nh_page_domain() {
 if (darc_login_check() == "true") { 
ob_start();

if(isset($_POST['darc_nh_domein'])){
  if(isset($_POST['darc_nh_website'])){
	darc_update_pointer($_POST['darc_nh_domein'],$_POST['darc_nh_website']);
  }else{
	darc_delete_pointer($_POST['darc_nh_domein']);
  }
}

	_e('If you don\'t have a website you can use these settings to send the people visiting your domainname to a webpage of your choise. If you have your own website you should leave the field blank!', 'darc-nh');

	echo '<h2>'. __('Domain forwarders', 'darc-nh').'</h2>';

 		  $domeinen = explode(" ", darc_list_domain()); 
			foreach($domeinen as $domein){ if($domein != ""){ 
		echo '<form name="input" action='.get_permalink().' method="post">';
		echo '<b>'.$domein.':</b><br> <input type="text" name="darc_nh_domein" value='.$domein.' hidden> <input type="text" name="darc_nh_website" value="'.darc_list_pointer($domein).'" style="width: 350px;">';
		echo ' <input name="darc_nh_update" type="submit" value='. __('save', 'darc-nh').'></form>';
			} } echo '<br>';

return ob_get_clean();
 }
}

?>