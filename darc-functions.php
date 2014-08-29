<?php defined('ABSPATH') or die("No script kiddies please!");

function darc_mail_opslag($waarde){
	   $waarde = $waarde/1024;
	     if($waarde < 1024){
		return number_format($waarde,0,',','.')."KB";
	     }elseif($waarde > 1023 AND $waarde < 1048576){
		$waarde = $waarde/1024; return number_format($waarde,0,',','.')."MB";
	     }else{
		$waarde = $waarde/1024/1024; return number_format($waarde,0,',','.')."GB";
	     }
}

function darc_mail_opslag_ratio($totaal,$gebruikt){
	$percentage = $totaal/100;
	$percentage = $gebruikt/$percentage;
		return number_format($percentage,0,'.',',');
}

function mb_to_gb($waarde){
	     if($waarde < 1024){
		return round($waarde,0)."MB";
	     }elseif($waarde > 1023){
		$waarde = $waarde/1024; return number_format($waarde,2,',','.')."GB";
	     }
}

function total_percentage($hundred,$part,$return){
		$hundred = $hundred;
		$one = $hundred/100;
		$part = $part/$one;
		$left = 100-$part;
	if($return == 100){
		return $hundred;
	}elseif($return == "part"){
		return $part;
	}elseif($return == "one"){
		return $one;
	}elseif($return == "left"){
		return $left;
	}
}

function darc_list_domain(){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_SHOW_DOMAINS', 1); 
	$result = $sock->fetch_parsed_body();
	$domeinen = "";
		foreach ($result['list'] as $key => $value) { 
		  if($value != "" AND $value != ""){
    			$domeinen .= $value." "; 
		  }
		} 
	return $domeinen;
}

function darc_list_mail($domein){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_POP', array('action' => 'list','domain' => $domein,'type' => "quota"));
	$result = $sock->fetch_parsed_body();
	$mail = "";
		foreach ($result as $key => $value) { 
		 if($key != "error" AND $key != "details" AND $key != "text" AND $value != ""){
    			$mail .= "aliasid".$key."".$value; 
		 }
		} 
	return $mail;
}

function darc_list_forward($domein){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_EMAIL_FORWARDERS', array('action' => 'list','domain' => $domein));
	$result = $sock->fetch_parsed_body();
	$mail = "";
		foreach ($result as $key => $value) { 
		 if($key != "error" AND $key != "details" AND $key != "text" AND $key != "" AND $value != ""){
    			$mail .= $key."-".$value." "; 
		 }
		} 
	return $mail;
}

function da_list_website($domein){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_REDIRECT', array('action' => 'list','domain' => $domein));
	$result = $sock->fetch_parsed_body();

		foreach ($result as $key => $value) { 
		 if($key == "/"){
    			return $value;
		 }
		} 
}

function darc_list_usage($ReqValue){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_SHOW_USER_USAGE', array('user' => get_user_meta(get_current_user_id(), "darc_nh_daid", "true" )));
	$result = $sock->fetch_parsed_body();
		foreach ($result as $key => $value) {
		 if($key == $ReqValue){
    			return $value;
		 }
		} 
}

function darc_list_reseller_usage($ReqValue,$ReqType){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account'), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_RESELLER_STATS', array('type' => $ReqType));
	$result = $sock->fetch_parsed_body();
		foreach ($result as $key => $value) {
		 if($key == $ReqValue){
    			return $value;
		 }
		} 
}

function darc_list_config($ReqValue){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_SHOW_USER_CONFIG', array('user' => get_user_meta(get_current_user_id(), "darc_nh_daid", "true" )));
	$result = $sock->fetch_parsed_body();
		foreach ($result as $key => $value) { 
		 if($key == $ReqValue){
    			return $value;
		 }
		} 
}

function darc_nh_update_mailbox($user,$domein,$quota){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_POP', array('action' => 'modify','domain' => $domein,'user' => $user,'passwd' => "",'passwd2' => "",'quota' => $quota));
	$result = $sock->fetch_parsed_body(); 

		 if($result['error'] == "1"){
    			echo '<li>'.__('Could not update the mailbox size.', 'darc-nh');
		 }elseif($result['error'] == "0"){
    			echo '<li>'.__('Updated the mailbox size.', 'darc-nh');
		 } 

}

function da_delete_website($domein){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_REDIRECT', array('action' => 'delete','domain' => $domein,'select0' => "/"));
	$result = $sock->fetch_parsed_body(); 
}

function da_update_website($domein,$url){
		if (stripos($url, 'http://') !== 0) {
		   $url = 'http://' . $url;
		}
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_REDIRECT', array('action' => 'add','domain' => $domein,'from' => "/",'to' => $url));
	$result = $sock->fetch_parsed_body(); 
}

function darc_nh_delete_mailbox($user,$domein){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_POP', array('action' => 'delete','domain' => $domein,'user' => $user));
	$result = $sock->fetch_parsed_body(); 

		 if($result['error'] == "1"){
    			echo '<li>'.__('Could not delete the mailbox.', 'darc-nh');
		 }elseif($result['error'] == "0"){
    			echo '<li>'.__('Deleted the mailbox.', 'darc-nh');
		 } 

}

function darc_nh_delete_forwarder($user,$domein){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_EMAIL_FORWARDERS', array('action' => 'delete','domain' => $domein,'select0' => $user));
	$result = $sock->fetch_parsed_body(); 

		 if($result['error'] == "1"){
    			echo '<li>'.__('Could not delete the forwarder.', 'darc-nh');
		 }elseif($result['error'] == "0"){
    			echo '<li>'.__('Deleted the forwarder.', 'darc-nh');
		 } 

}

function darc_nh_passcheck($pass1,$pass2){
		$alert_text = '';
		$count = 0;
  	if($pass1 != $pass2){
		$alert_text .= '<li>'.__('Your passwords are not the same.', 'darc-nh');
		$count++;
  	}if(strlen($pass1) < 6){
  	  	$alert_text .= '<li>'.__('Your password has to be atleast 6 characters.', 'darc-nh');
		$count++;
  	}if(!preg_match("#[A-Z]+#", $pass1)){
   	  	$alert_text .= '<li>'.__('Your password needs at least 1 uppercase character.', 'darc-nh');
		$count++;
  	}if(!preg_match("#[a-z]+#", $pass1)){
   	  	$alert_text .= '<li>'.__('Your password needs at least 1 lowercase character.', 'darc-nh');
		$count++;
  	}if(!preg_match("#[0-9]+#", $pass1)){
   	  	$alert_text .= '<li>'.__('Your password needs at least 1 number.', 'darc-nh');
		$count++;
  	}if(preg_match("#\W+#", $pass1)){
   	  	$alert_text .= '<li>'.__('Your password may not contain special characters.', 'darc-nh');
		$count++;
  	}
  	if($count == 0){ return "true"; }else{ echo $alert_text; }
}

function darc_nh_create_mail($user,$domein,$pass1,$pass2,$size){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_POP', array('action' => 'create','domain' => $domein,'user' => $user,'passwd' => $pass2,'passwd2' => $pass2,'quota' => $size));
	$result = $sock->fetch_parsed_body();

		 if($result['error'] == "1"){
    			echo '<li>'.__('Could not create the requested mailbox.', 'darc-nh');
		 }elseif($result['error'] == "0"){
    			echo '<li>'.__('Created the requested mailbox.', 'darc-nh');
		 } 

}

function darc_nh_create_forwarder($user,$domein,$email){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_EMAIL_FORWARDERS', array('action' => 'create','domain' => $domein,'user' => $user,'email' => $email));
	$result = $sock->fetch_parsed_body(); 

		 if($result['error'] == "1"){
    			echo '<li>'.__('Could not create the requested forwarder.', 'darc-nh');
		 }elseif($result['error'] == "0"){
    			echo '<li>'.__('Created the requested forwarder.', 'darc-nh');
		 } 

}

?>