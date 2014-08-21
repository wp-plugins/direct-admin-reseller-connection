<?php defined('ABSPATH') or die("No script kiddies please!");

function easymail_opslag($waarde){
	if($waarde == 0){ return "ULTD."; }else{
	   $waarde = $waarde/1024;
	     if($waarde < 1024){
		return number_format($waarde,0,',','.')."KB";
	     }elseif($waarde > 1023 AND $waarde < 1048576){
		$waarde = $waarde/1024; return number_format($waarde,0,',','.')."MB";
	     }else{
		$waarde = $waarde/1024/1024; return number_format($waarde,0,',','.')."GB";
	     }
	}
}

function easymail_opslag_ratio($totaal,$gebruikt){
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
    			$mail .= "aliasid".$key."".$value."<br>"; 
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

function da_update_quota($user,$domein,$quota){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_POP', array('action' => 'modify','domain' => $domein,'user' => $user,'passwd' => "",'passwd2' => "",'quota' => $quota));
	$result = $sock->fetch_parsed_body(); 

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

function da_delete_mail($user,$domein){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_POP', array('action' => 'delete','domain' => $domein,'user' => $user));
	$result = $sock->fetch_parsed_body(); 
}

function da_delete_forward($user,$domein){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_EMAIL_FORWARDERS', array('action' => 'delete','domain' => $domein,'select0' => $user));
	$result = $sock->fetch_parsed_body(); 
}

function da_passcheck($pass1,$pass2){
		$alert_text = "";
		$count = 0;
  	if($pass1 != $pass2){
		$alert_text .= "<br>- Je wachtwoorden komen niet overeen.";
		$count++;
  	}if(strlen($pass1) < 6){
  	  	$alert_text .= "<br>- Je wachtwoord moet minimaal 6 tekens lang zijn.";
		$count++;
  	}if(!preg_match("#[A-Z]+#", $pass1)){
   	  	$alert_text .= "<br>- Je wachtwoord dienst minimaal 1 grote letter bevatten.";
		$count++;
  	}if(!preg_match("#[a-z]+#", $pass1)){
   	  	$alert_text .= "<br>- Je wachtwoord dienst minimaal 1 kleine letter bevatten.";
		$count++;
  	}if(!preg_match("#[0-9]+#", $pass1)){
   	  	$alert_text .= "<br>- Je wachtwoord moet minimaal 1 cijfer bevatten.";
		$count++;
  	}if(preg_match("#\W+#", $pass1)){
   	  	$alert_text .= "<br>- Je wachtwoord mag geen vreemde tekens bevatten.";
		$count++;
  	}
  	if($count == 0){ return "true"; }else{ set_alert_note("red",$alert_text,"/easymailcms"); }
}

function da_create_mail($user,$domein,$pass1,$pass2,$size){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_POP', array('action' => 'create','domain' => $domein,'user' => $user,'passwd' => $pass2,'passwd2' => $pass2,'quota' => $size));
	$result = $sock->fetch_parsed_body(); 
}

function da_create_forward($user,$domein,$email){
		$sock = new HTTPSocket; 
		$sock->connect(get_option('darc_nh_adresse'), get_option('darc_nh_port','2222')); 
		$sock->set_login(get_option('darc_nh_account')."|".get_user_meta(get_current_user_id(), "darc_nh_daid", "true" ), get_option('darc_nh_key')); 
		$sock->set_method('GET'); 
	$sock->query('/CMD_API_EMAIL_FORWARDERS', array('action' => 'create','domain' => $domein,'user' => $user,'email' => $email));
	$result = $sock->fetch_parsed_body(); 
}

?>