<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="afwpp-cont">
	<div class="error notice hide" id="error_div">
	    <p id="error_msg">Please make sure AMPforWP has been installed and activated on your site, so you can make best use of our Pro version :)</p>
	</div>
	<?php
		wp_nonce_field( 'ampforwppro_nonce', 'ampforwppro_nonce' );
		$license_info = get_option( 'ampforwppro_license_info');
		global $all_extensions_data;
		$renew = "no";
		$license_exp = "";
		if($license_info){
			$license_exp = date('Y-m-d', strtotime($license_info->expires));
		}
		$today = date('Y-m-d');
		$exp_date =$license_exp;
		if(!$license_info){
	?>
	<h3 class="ext-a-title">AMP Pro Extension Manager Activation</h3>
	<div class="afwpp-act-b">
		<div class="lkact">
			<p>Enter Your License Key</p>
			<input type="text" value="" class="regular-text" id="bundle_license_key">
			<button type="button" class="button button-primary activate-l-but" id="active_licence">Activate License</button>
			<div id="refresh_license" style="margin-top: 15px;"></div>
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
	<h3 class="ext-a-title">AMP Pro Extension Manager</h3>
	<div class="afwpp-act-b">
		<div class="asblk bor-right">
			<p class="ftitle">License Key</p>
			<input type="text" value="<?php echo $show_key;?>" class="regular-text deact-text">
			<button type="button" class="button button-normal" id="revoke_license">Deactivate</button>
			<p class="act-msg"><span class="aeaicon dashicons 
dashicons-yes"></span>License is active. You are receiving updates & support.</p>
		</div>
		<?php 
			$date1 = date_create($today);
			$date2 = date_create($exp_date);
			$diff = date_diff($date1,$date2);
			$days = $diff->format("%a");
			$renew = "yes";
			$lisense_k = $license_info->license_key;
			$download_id = $license_info->download_id;
			$payment_id = $license_info->payment_id;
			$download_id = $license_info->download_id;
			$expire_msg = " Expires in ".intval($days)." days";
			$exp_class = '';
			if($days<0){
				$expire_msg = " Subscription Expired";
				$exp_class = 'expired';
			}
		?>
		<div class="asblk bor-right">
			<p class="ftitle">License Information</p>
			<div class="<?php esc_attr($exp_class);?>">
				<span class="lmsg"><i class="dashicons dashicons-calendar-alt"></i><?php echo esc_attr($expire_msg);?></span><a href="https://accounts.ampforwp.com/order/?edd_license_key=<?php echo esc_attr($lisense_k);?>&download_id=<?php echo intval($download_id);?>" target="_blank"><button class="button a-ext-renew-btn" type="button">Renew</button></a>
			</div>
			<div class="linfo-rmsg" id="refresh_license">
				<input type="hidden" value="<?php echo $payment_id;?>" id="payment_id">
				<input type="hidden" value="<?php echo $download_id;?>" id="download_id">
				<input type="hidden" value="<?php echo $renew ;?>" id="renew_status">
				<span class="lmsg refresh-lib"><i class="dashicons dashicons-update-alt" id="refresh_license_icon"></i> Refresh Extensions Library</span>
			</div>
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
					    if($title == 'AMP Pagebuilder Compatibility'){
                           $menu_link = '?page=amp_pbc';
					    }
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
						$amp_supported_plugins = $afwpp_obj->ampforwppro_amp_by_google_supported_plugin_list($title);
						if($amp_supported_plugins == false){
							continue;
						}
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
					</div>
				</li>
				<?php }?>
			</ul>
		</div>
	</div>
	<?php }?>
</div>