<?php defined('ABSPATH') or die("No script kiddies please!");

function darc_nh_page_mail() {
 if (darc_login_check() == "true") { 
ob_start();

	?><script type="text/javascript">
	jQuery(document).ready(function($) {
	    $('a[dialog-id^=#darc-dialog]').click(function() { event.preventDefault();
	  	var div = $(this).attr('dialog-id');
 		$(".wp-dialog").hide(); 
       		$(div).show();
	    });
	});
	</script><?php

if(isset($_POST['darc_nh_mailbox']) && is_numeric($_POST['darc_nh_mailbox_size'])){
	$value = explode("@", $_POST['darc_nh_mailbox']); 
	darc_nh_update_mailbox($value[0],$value[1],$_POST['darc_nh_mailbox_size']);
}
if(isset($_POST['darc_nh_mailbox']) && isset($_POST['darc_nh_mailbox_delete'])){
	$value = explode("@", $_POST['darc_nh_mailbox']); 
 	darc_nh_delete_mailbox($value[0],$value[1]);
}
if(isset($_POST['darc_nh_forwarder']) && isset($_POST['darc_nh_forwarder_delete'])){
	$value = explode("@", $_POST['darc_nh_forwarder']); 
 	darc_nh_delete_forwarder($value[0],$value[1]);
}
if(isset($_POST['darc_nh_new_mailbox_alias']) AND isset($_POST['darc_nh_new_mailbox_domein']) AND isset($_POST['darc_nh_new_mailbox_pass1']) AND isset($_POST['darc_nh_new_mailbox_pass2']) AND is_numeric($_POST['darc_nh_new_mailbox_size'])){
  if(darc_nh_passcheck($_POST['darc_nh_new_mailbox_pass1'],$_POST['darc_nh_new_mailbox_pass2']) == "true"){
	darc_nh_create_mail($_POST['darc_nh_new_mailbox_alias'],$_POST['darc_nh_new_mailbox_domein'],$_POST['darc_nh_new_mailbox_pass1'],$_POST['darc_nh_new_mailbox_pass2'],$_POST['darc_nh_new_mailbox_size']);
  }
}
if(isset($_POST['darc_nh_new_forwarder_alias']) AND isset($_POST['darc_nh_new_forwarder_domein']) AND filter_var($_POST['darc_nh_new_forwarder_email'], FILTER_VALIDATE_EMAIL)){
	darc_nh_create_forwarder($_POST['darc_nh_new_forwarder_alias'],$_POST['darc_nh_new_forwarder_domein'],$_POST['darc_nh_new_forwarder_email']);
}

	echo '<h2>'. __('Mailboxes', 'darc-nh').'</h2>';

            echo '<table class="table table-hover" style="width:100%;"><tr><th></th><th>'. __('alias', 'darc-nh').'</th><th></th><th>'. __('domain', 'darc-nh').'</th><th>'. __('size', 'darc-nh').'</th><th>'. __('used', 'darc-nh').'</th><th></th></tr>';

		if(darc_list_usage("nemails") == 1){ echo '<td colspan="6">'.__('There are no existing mailboxes.', 'darc-nh').'</td>'; }

	 $domeinen = explode(" ", darc_list_domain()); 
	 	$i = 1;
	 foreach($domeinen as $domein){ 
	   $mails = explode("aliasid", darc_list_mail($domein)); 
	    foreach($mails as $mail){ if($mail != ""){
		$quota = explode("quota=", $mail);	
		$usage = explode("&usage=", $quota[1]);
	      if($quota[0] != "") {
		echo "<tr><td>".$i.".</td>";
		echo "<td>".$quota[0]."</td>";
		echo "<td> &#64; </td>";
		echo "<td>".$domein."</td>";
		echo "<td>";
			echo '<div id="darc-dialog-fix-'.$i.'" title="'.$quota[0].'@'.$domein.'" class="wp-dialog">';
			if($usage[0] == 0){ _e('unlimited', 'darc-nh'); }else{ echo darc_mail_opslag($usage[0]); }
			echo '</div>';
			echo '<div id="darc-dialog-edit-'.$i.'" title="'.$quota[0].'@'.$domein.'" class="wp-dialog" style="display: none;">';
			echo '<form action="'.get_permalink().'" method="post">
			<input type="text" name="darc_nh_mailbox" value="'.$quota[0].'@'.$domein.'" hidden> <input type="number" min="0" step="5" style="width: 50px;" name="darc_nh_mailbox_size" value="'.($usage[0]/1024/1024).'"> MB
			<input name="darc_nh_update_size" type="submit" value="'. __('update', 'darc-nh').'"></form> <span class="description"><i>'. __('Enter "0" for unlimited mailbox size.', 'darc-nh').'</i> <a dialog-id="#darc-dialog-fix-'.$i.'">'. __('cancel', 'darc-nh').'</a>';
			echo '</div>';
		echo "</td>";
		echo "<td>".darc_mail_opslag($usage[1]); if($usage[0] != 0){ echo " <small>(".darc_mail_opslag_ratio($usage[0],$usage[1])."%)</small>"; } echo "</td>";
		echo "<td><a dialog-id='#darc-dialog-edit-".$i."'>". __('edit', 'darc-nh')."</a> / <a dialog-id='#darc-dialog-delete-".$i."'>". __('delete', 'darc-nh')."</a></td></tr>";

echo '<div id="darc-dialog-delete-'.$i.'" title="'. __('Confirm action', 'darc-nh').'" class="wp-dialog" style="display: none;"><form action='.get_permalink().' method="post">
  <p><label>'. __('Are you sure you want to delete', 'darc-nh').'</label><br></p><p align="center">'.$quota[0].'@'.$domein.'<br><br>
  <input type="text" name="darc_nh_mailbox" value="'.$quota[0].'@'.$domein.'" hidden> <input type="submit" dialog-id="#darc-dialog-delete-'.$i.'" value="'. __('no', 'darc-nh').'"> <input name="darc_nh_mailbox_delete" type="submit" value="'. __('yes', 'darc-nh').'"></form></p>
<span class="description"><i>'. __('All your <b><u>not</u></b> downloaded emails will also be deleted!', 'darc-nh').'</i></span></div>';

		$i++;

     } }
    }
  }

	  echo "</table>";

	if(darc_list_config("nemails") != darc_list_usage("nemails")){ 

echo '<div id="darc-dialog-new-mailbox" title="'. __('Added a new mailbox', 'darc-nh').'" class="wp-dialog" style="display: none;">
  <p>
	<table><form name="input" action='.get_permalink().' method="post">
		<tr><td colspan="2" style="padding:5px;"><label>'. __('Email address', 'darc-nh').':</label></td></tr>
		<tr><td style="padding:5px;"><input type="text" name="darc_nh_new_mailbox_alias"> </td><td style="padding:5px;"><select name="darc_nh_new_mailbox_domein" style="font-size: 16px;">';
 		  $domeinen = explode(" ", darc_list_domain()); 
			foreach($domeinen as $domein){ if($domein != ""){ 
		echo '<option value="'.$domein.'">@'.$domein.'</option>';
			} }
		echo '</select></td></tr>
		<tr><td style="padding:5px;"><label>'. __('Password', 'darc-nh').':</label> </td><td style="padding:5px;"><input type="password" name="darc_nh_new_mailbox_pass1"></td></tr>
		<tr><td style="padding:5px;"><label>'. __('Password', 'darc-nh').':</label> </td><td style="padding:5px;"><input type="password" name="darc_nh_new_mailbox_pass2"> <small>(herhalen)</small></td></tr>
		<tr><td style="padding:5px;"><label>'. __('Mailbox size', 'darc-nh').':</label> </td><td style="padding:5px;"><input type="number" min="0" step="5" style="width: 50px;" value="0" name="darc_nh_new_mailbox_size"> MB <span class="description"><i>'. __('Enter "0" for unlimited mailbox size.', 'darc-nh').'</i></span></td></tr>
		<tr><td colspan="2" align="right"><label>&nbsp;</label><input name="darc_nh_new_mailbox" type="submit" value="'. __('added', 'darc-nh').'"></td></tr></form></table>

  </p>
</div>';

echo '<p align="right"><a dialog-id="#darc-dialog-new-mailbox">'. __('Added a new mailbox', 'darc-nh').'</a></p>'; }

?>

<?php
	echo '<h2>'. __('Forwarders', 'darc-nh').'</h2>';

	  echo '<table class="table table-hover" style="width:100%;"><tr><th></th><th>'. __('address', 'darc-nh').'</th><th></th><th>'. __('receiver', 'darc-nh').'</th><th></th></tr>';

		if(darc_list_usage("nemailf") == 0){ echo '<td colspan="6">'.__('There are no existing mailforwarders.', 'darc-nh').'</td>'; }

 $domeinen = explode(" ", darc_list_domain()); 
 foreach($domeinen as $domein){ 
   $mails = explode(" ", darc_list_forward($domein)); 
    foreach($mails as $mail){
   	$forward = explode("-", $mail); 
      if($forward[0] != ""){
	echo "<tr><td>".$i.".</td>";
	echo "<td>".$forward[0]."@".$domein."</td>";
	echo "<td> &#10152; </td>";
	echo "<td>".$forward[1]."</td>";
	echo '<td><a dialog-id="#darc-dialog-delete-'.$i.'">'. __('delete', 'darc-nh').'</a></td></tr>';

echo '</div>
<div id="darc-dialog-delete-'.$i.'" title="'. __('Confirm action', 'darc-nh').'" class="wp-dialog" style="display: none;"><form action='.get_permalink().' method="post">
  <p><label>'. __('Are you sure you want to delete', 'darc-nh').'</label><br></p><p align="center">'.$forward[0].'@'.$domein.'<br><br>
  <input type="text" name="darc_nh_forwarder" value="'.$forward[0].'@'.$domein.'" hidden> <input type="submit" dialog-id="#darc-dialog-delete-'.$i.'" value="'. __('no', 'darc-nh').'"> <input name="darc_nh_forwarder_delete" type="submit" value="'. __('yes', 'darc-nh').'"></form></p>
</div>';

	$i++;
     }
    }
  }

      echo "</table>";

	if(darc_list_config("nemailf") != darc_list_usage("nemailf")){ 
echo '<div id="darc-dialog-new-forwarder" title="'. __('Added a new forwarder', 'darc-nh').'" class="wp-dialog" style="display: none;">
  <p>
	<table><form name="input" action='.get_permalink().' method="post">
		<tr><td colspan="2" style="padding:5px;"><label>'. __('Email address', 'darc-nh').':</label></td></tr>
		<tr><td style="padding:5px;"><input type="text" name="darc_nh_new_forwarder_alias"> </td><td style="padding:5px;"><select name="darc_nh_new_forwarder_domein" style="font-size: 16px;">';
 		  $domeinen = explode(" ", darc_list_domain()); 
			foreach($domeinen as $domein){ if($domein != ""){ 
		echo '<option value="'.$domein.'">@'.$domein.'</option>';
			} }
		echo '</select></td></tr>
		<tr><td colspan="2" style="padding:5px;"><label>'. __('Send to', 'darc-nh').':</label> </td></tr>
		<tr><td colspan="2" style="padding:5px;"><input type="email" name="darc_nh_new_forwarder_email" size="30"></td></tr>
		<tr><td colspan="2" align="right"><label>&nbsp;</label><input name="darc_nh_new_forwarder" type="submit" value="'. __('added', 'darc-nh').'"></td></tr></form></table>

  </p>
</div>';

echo '<p align="right"><a dialog-id="#darc-dialog-new-forwarder">'. __('Added a new forwarder', 'darc-nh').'</a></p>';
	}

return ob_get_clean();
 }
}

?>