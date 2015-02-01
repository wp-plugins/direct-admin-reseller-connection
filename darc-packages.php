<?php defined('ABSPATH') or die("No script kiddies please!");

function darc_nh_page_packages( $atts ) {
ob_start();

	$atts = shortcode_atts( array('pack' => 'all','price' => '0'), $atts);

   if($atts['pack'] == 'all'){ $packs = darc_list_packages(); }else{ $packs = $atts['pack']; }
	$prices = explode("-", $atts['price']); $pid = 0;
	$packs = explode("-", $packs);
			echo '<table width="100%" class="table table-hover"><tbody><tr><th></th>';
		foreach($packs as $pack){
			echo '<th>'.$pack.'</th>';
		}
			echo '</tr><tr><th>Webruimte</th>';
		foreach($packs as $pack){
			echo '<td>'.mb_to_gb(darc_list_package($pack,'quota')).'</td>';
		}
			echo '</tr><tr><th>Dataverkeer</th>';
		foreach($packs as $pack){
			echo '<td>'.mb_to_gb(darc_list_package($pack,'bandwidth')).'</td>';
		}
			echo '</tr><tr><th>MySQL databases</th>';
		foreach($packs as $pack){
			echo '<td>'.darc_list_package($pack,'mysql').'</td>';
		}
			echo '</tr><tr><th>Domeinen</th>';
		foreach($packs as $pack){
			echo '<td>'.darc_list_package($pack,'vdomains').'</td>';
		}
		   if($prices[0] != 0){
			echo '</tr><tr><th>Prijs</th>';
		foreach($packs as $pack){ 
			echo '<td>&euro;'.$prices[$pid].' p/m</td>'; $pid = $pid+1;
		   }
		}

			echo '</tr></table>';
return ob_get_clean();
}

?>