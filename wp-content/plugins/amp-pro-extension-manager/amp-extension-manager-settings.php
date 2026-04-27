<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="afwpp-cont">
	<?php
	if ( !defined('AMPFORWP_PLUGIN_DIR') || function_exists('amp_activate') ) { ?>
		<div class="error notice" id="error_div">
		<p id="error_msg">Please make sure <a href="https://wordpress.org/plugins/accelerated-mobile-pages/">AMPforWP</a> has been installed and activated on your site, so you can make best use of our Pro version :)</p>
	</div>
	 <?php } ?>
	<?php
		wp_nonce_field( 'ampforwppro_nonce', 'ampforwppro_nonce' );
		$license_info = get_option( 'ampforwppro_license_info');
		global $all_extensions_data;
		$renew = "no";
		$license_exp = "";
		$lmsg_top_id = '';
		$lil_id = '';
		if($license_info){
			$license_exp = date('Y-m-d', strtotime($license_info->expires));
			$license_info_lifetime = $license_info->expires;
			$license_exp_d = date('d-F-Y', strtotime($license_info->expires));
		}
		$today = date('Y-m-d');
		$exp_date =$license_exp;
		if(!$license_info){
	?>
	<h3 class="ext-a-title">AMP Pro Extension Manager</h3>
	<div class="afwpp-act-b">
		<div class="lkact">
			<p>Enter Your License Key</p>
			<input type="text" value="" class="regular-text" id="bundle_license_key">
			<button type="button" class="button button-primary activate-l-but" id="active_licence">Activate License</button>
			<div id="refresh_license" style="margin-top: 15px;"></div>
			<div id="err_message" style="margin-top: 15px;"></div>
		</div>
	</div>
	<?php 
	}else{
		$b_license = $license_info ->license_key;
		$strlen = strlen($b_license);
		$show_key = "";
		for($i=1;$i<$strlen;$i++){
			if($i<$strlen-4){
				$show_key .= "*";
			}else{
				$show_key .= $b_license[$i];
			}
		}
	?>
	<?php
			$date1 = date_create($today);
			$date2 = date_create($exp_date);
			$diff = date_diff($date1,$date2);
			$days = $diff->format("%a");
			if( $license_info_lifetime == 'lifetime' ){
				$days = 'Lifetime';
				if ($days == 'Lifetime') {
				$expire_msg = " Your License is Valid for Lifetime ";
				}
			}
			elseif($today > $exp_date){
				$days = -$days;
			}
			if ($days<0) {
				$lmsg_top_id = 'id="lmsg_top_id"';
			}
	?>
	<h3 class="ext-a-title">AMP Pro Extension Manager</h3>
	<div class="afwpp-act-b">
		<div class="asblk bor-right" id="asblk_main">
			<p class="ftitle">License Key<span class="linfo-rmsg_top" id="refresh_license_top">
				<input type="hidden" value="172576" id="payment_id">
				<input type="hidden" value="24570" id="download_id">
				<input type="hidden" value="yes" id="renew_status">
				<span class="lmsg_top refresh-lib" <?php echo $lmsg_top_id ?>><i class="dashicons dashicons-update-alt" id="refresh_license_icon_top"></i></span>
			</span></p>
			<input type="text" name="main_key" value="<?php echo $show_key;?>" class="regular-text deact-text">
			<button type="button" class="button button-normal" id="revoke_license">Deactivate</button>			
			<?php if($days<0){
				$span_class = "aeaicon dashicons dashicons-no";
				$color = 'color:red';
			}
			else{
				$span_class = "aeaicon dashicons dashicons-yes";
				$color = 'color:green';
			} 
			?>
			<p class="act-msg"><span style="<?php echo $color;?>" class="<?php echo $span_class;?>"></span><?php
			$lisense_k = $license_info->license_key;
			$download_id = $license_info->download_id;
		 if($days<0){ ?> <span id="ex_text" style="color:red">Expired.</span> <a id="extend"href="https://accounts.ampforwp.com/order/?edd_license_key=<?php echo esc_attr($lisense_k);?>&download_id=<?php echo intval($download_id);?>" target="_blank" >Extend</a> <span id="ex_text">License to receive further updates & support.</span>
		 <?php }
		 	else { ?> License is active. You are receiving updates & support.<?php }?></p>
		</div>
		<?php
		$exp_class_2 = 'renew_license_key';
		?>
		<?php 
			$date1 = date_create($today);
			$date2 = date_create($exp_date);
			$diff = date_diff($date1,$date2);
			$days = $diff->format("%a");
			if($days>=0){
			$expire_msg = " Expires in ".intval($days)." days";
			}

			if( $license_info_lifetime == 'lifetime' ){
				$days = 'Lifetime';
				if ($days == 'Lifetime') {
				$expire_msg = " Your License is valid for Lifetime ";
				}
			}
			elseif($today > $exp_date){
				$days = -$days;
			}
			$renew = "yes";
			$lisense_k = $license_info->license_key;
			$download_id = $license_info->download_id;
			$payment_id = $license_info->payment_id;
			$download_id = $license_info->download_id;

			$exp_class = 'lmsg2';
			$exp_id = '';
			if($days<0){
				$expire_msg = " Expired ";
				$exp_class = 'expired';
				$exp_id = 'exp';
				$exp_class_2 = 'renew_license_key_';
			}
			?>
		<?php
		if ($license_info_lifetime == 'lifetime' ) {
				$lil_id = 'lil_id';
				$exp_text = 'Your License is Valid for ';
				$license_exp_d = $license_info_lifetime;
		}
		else	{
			$exp_text = 'Expire on '; 
		}
		?>

		<div class="asblk bor-right" id="asblkborright_sec">
			<p class="ftitle">License Information</p>
			<div class="<?php esc_attr($exp_class);?>">
				<a href="https://accounts.ampforwp.com/order/?edd_license_key=<?php echo esc_attr($lisense_k);?>&download_id=<?php echo intval($download_id);?>" target="_blank" class="<?php echo $exp_class_2; ?>" id="<?php echo $exp_id; ?>">Renew</a>					
				<i class="dashicons dashicons-calendar-alt"></i>				
				<span class="<?php echo $exp_class; ?>"><span id="attnl">__</span>  <?php echo esc_attr($expire_msg);?></span>
				<span class="hider" id="<?php echo $lil_id; ?>"><?php echo $exp_text.$license_exp_d; ?></span>				
				<input class="l_key" type="hidden" value="<?php echo $lisense_k;?>" name="l_key">
				<input class="show_key" type="hidden" value="<?php echo $show_key?>" name="show_key">
			</div>
			<div class="linfo-rmsg" id="refresh_license">
				<input type="hidden" value="<?php echo $payment_id;?>" id="payment_id">
				<input type="hidden" value="<?php echo $download_id;?>" id="download_id">
				<input type="hidden" value="<?php echo $renew ;?>" id="renew_status">
				<span class="lmsg refresh-lib"><i class="dashicons dashicons-update-alt" id="refresh_license_icon"></i> Refresh Extensions Library</span>
			</div>

			<?php
			$trans_check = get_transient( 'ampforwppro_load' );			
			if ( $days<=7 && $trans_check !== 'ampforwppro_load_v' ) {
			  	?>
				<div class="linfo2-rmsg" id="auto_fresh">
				<input type="hidden" value="<?php echo $payment_id;?>" id="payment_id">
				<input type="hidden" value="<?php echo $download_id;?>" id="download_id">
				<input type="hidden" value="<?php echo $renew ;?>" id="renew_status">
				<input type="hidden" value="<?php echo $days ;?>" id="remaining_days">
			</div>
			<?php }?>
			<?php
			$ver_num = AMPFORWPPRO_VERSION;
			$trans_check = get_transient( 'ampforwppro_t' );
			if ( $trans_check !== 'ampforwppro_t_v' && $ver_num == '1.10.11' ) {
			 ?>
				<div class="linfo2-rmsg" id="auto_fresh2">
				<input type="hidden" value="<?php echo $ver_num;?>" id="ver_num">
				<input type="hidden" value="<?php echo $payment_id;?>" id="payment_id">
				<input type="hidden" value="<?php echo $download_id;?>" id="download_id">
				<input type="hidden" value="<?php echo $renew ;?>" id="renew_status">
				<input type="hidden" value="<?php echo $days ;?>" id="remaining_days">
			</div>
			<?php }?>			
		</div>
		<div class="asblk">
			<p class="ftitle">At Your Service</p>
			<div>
				<a href="https://ampforwp.com/tutorials/" target="_blank"><span class="lmsg"><i class="dashicons dashicons-media-text"></i> View Documentation</span></a>
			</div>
			<div class="linfo-rmsg">
				<a href="https://ampforwp.com/support/" target="_blank"><span class="lmsg"><i class="dashicons dashicons-businessman"></i> Ask Technical Question</span></a>
			</div>
		</div>
	</div>
	<?php if(is_admin()){?>
	<script>
function ampforwp_pro_managaer_search_result(search_str) {
  if (search_str.length==0) {
    document.getElementById("plugin-search-input").innerHTML="";
    document.getElementById("plugin-search-input").style.border="0px";
    return;
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
    	window.location = "plugins.php?s="+search_str+"&plugin_status=amp-ext-manage";      
    }
  }
  xmlhttp.open("GET","plugins.php?s="+search_str+"&plugin_status=amp-ext-manage",true);
  xmlhttp.send();
}
</script>
<?php } ?>
<?php 
if(is_admin()){?>


 <form class="search-form search-plugins" method="GET">
		<p class="search-box-amp_pm">
			<label class="screen-reader-text" for="plugin-search-input">Search Installed Plugins:</label>
			<input type="search" id="plugin-search-input" onkeyup="ampforwp_pro_managaer_search_result(this.value)" class="wp-filter-search" name="s" value="" placeholder="Search plugins" aria-describedby="live-search-desc">
			<input type="submit" id="search-submit" class="button hide-if-js" value="Search Installed Plugins">
		</p>
	</form>
<?php } ?>
	<h3 class="ext-a-title">AMPforWP Pro Extensions</h3>
	<div class="afwpp-ext-block">
		<?php 
			$current_tab = '';
			if(isset($_GET['tab'])){
				$current_tab = $_GET['tab'];
			}
		?>
		<div class="ext-menu">
			<ul>
				<li class="extension-tab active" id="all">All</li>
				<li class="extension-tab" id="active">Active</li>
				<li class="extension-tab" id="popular">Popular</li>
				<li class="extension-tab" id="recommended">Recommended</li>
			</ul>
		</div>
		<div class="ext-list-block">
			<ul>
				<?php
					global $afwpp_obj; 
					$response = $license_info->afwpp_response;
					$selectedOption = get_option('redux_builder_amp',true);
					$count = 0;
					foreach ($response as $key => $value) {
						$status = ucfirst($response[$key]->status);
						$title = $response[$key]->post_title;
						$id = $key;
						$menu_link = $afwpp_obj->ampforwppro_get_menu_link($title);
						$tit = $title;
						$ind = trim(strtolower(str_replace(' ', '-', $tit)));
						$plugin_path = '';
						$is_active = '';
						$update = '';
						$ext_info = $afwpp_obj->ampforwp_get_extension_info($title);
						$description = '';
						if(isset($ext_info['desc'])){
							$description = $ext_info['desc'];
						}
						$version = $response[$key]->sl_version;
						$has_license = 'yes';
						$plugin_name = $title;
						if(isset($afwpp_obj->all_plugin_list[$ind])){
							$plugin_name = $afwpp_obj->all_plugin_list[$ind]['name'];
							$plugin_path = $afwpp_obj->all_plugin_list[$ind]['plugin_path'];
							$is_active = $afwpp_obj->all_plugin_list[$ind]['is_active'];
							$all_data = $afwpp_obj->all_plugin_list[$ind]['all_data'];
							$description = $afwpp_obj->all_plugin_list[$ind]['description'];
							$version = $afwpp_obj->all_plugin_list[$ind]['version'];
							$update = $afwpp_obj->ampforwppro_get_plugin_update($plugin_path,$all_data);
							$prefix_r = explode("/", $plugin_path);
							$prefix = $prefix_r[0];
							if(isset($selectedOption['amp-license'][$prefix]['status']) && $selectedOption['amp-license'][$prefix]['status']=="" || !isset($selectedOption['amp-license'][$prefix]['status'])){
								$has_license = 'no';
							}
						}
						if($status=="Inactive"){
							$status="Activate";
						}else{
							$status="Deactivate";
						}
						$docs = $afwpp_obj->ampforwppro_get_documentation($title);
						$button_name = '';
						$button= '';
						$has_plugin = $is_active;
						$changelog_url = '';
						if($is_active=='1' && $has_license == 'yes'){
							$button_name = 'Deactivate';
							$plugin_path = $afwpp_obj->all_plugin_list[$ind]['plugin_path'];
							$explode_path = explode('/', $plugin_path);
							$plugin_slug = str_replace(".php", "", $explode_path[1]);
							$changelog_url = self_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_slug . '&section=changelog&TB_iframe=true&width=600&height=800' );
						
							$button= 'deactivate';
						}else if($is_active=='1' && $has_license == 'no'){
							$button_name = 'Activate License';
							$is_active='';
						}else if($is_active=='0' && $has_license == 'yes'){
							$button_name = 'Activate Plugin';
						}else if($is_active=='0' && $has_license == 'no'){
							$button_name = 'Activate License';
							$is_active='';
						}else if($status=="Activate"){
							$button_name = "Activate";
						}else if($status=="Deactivate"){
							$button_name = "Activate";
							$button= 'deactivate';
						}
						
						$popular_class = '';
						$popular = $afwpp_obj->ampforwppro_popular_plugin_list($title);
						if($popular){
							$popular_class = 'popular ';
						}
						$recommended_class = '';
						$recommended = $afwpp_obj->ampforwppro_recommended_plugin_list($title);
						if($recommended){
							$recommended_class = 'recommended';
						}
						$active = '';
						if($is_active==1){
							$active = 'active ';
						}
				?>
				<li class="<?php echo $active.$popular_class.$recommended_class;?>">
					<div class="ext-info">
						<input type="hidden" value="<?php echo $plugin_path?>" id="plugin_path-<?php echo $id?>">
						<input type="hidden" value="<?php echo $is_active?>" id="is_active-<?php echo $id?>">
						<strong class="ext-ver-title">
							<?php
							echo esc_attr($plugin_name);?>
						</strong>
						<?php if(!empty($changelog_url)){ ?>
						<a href="<?php echo esc_url( $changelog_url );?>" title="Update Plugin" class="afwpp-link" target="_blank"><span class="ext-var"><?php echo esc_attr($version);?></span></a>
						<?php }else{?>
						<span class="ext-var"><?php echo esc_attr($version);?></span>
					    <?php } ?>
						<?php echo $update;?>
						<p><?php echo esc_attr($description);?></p>
						<div class="ext-act-but">
							<?php if($button_name=="Activate" || $button_name=="Activate License" || $button_name=="Activate Plugin"){?>
								<button type="button" class="button button-normal afwpp_activate_ext"  id="<?php echo $id?>"><?php echo esc_attr($button_name);?></button>
							<?php }?>
							<?php if($button_name=="Deactivate"){?>
							<button type="button" class="button button-primary afwpp_activate_ext"  id="<?php echo $id?>">Deactivate</button>
							<?php }?>
							<?php if($is_active=='1' && $menu_link!=""){?>
								<a href="<?php echo $menu_link;?>" title="Settings" class="afwpp-link" target="_blank"><button class="button btn-setting"><i class="dashicons dashicons-admin-generic"></i> Settings</button></a>
							<?php }?>
							<?php echo $docs;?>
						</div>
						<div class="hide" id="proextns-errors-div">
						<p style="color:red"></p>
						</div>
					</div>
				</li>
				<?php }?>
			</ul>
		</div>
	</div>
	<?php }?>
</div>