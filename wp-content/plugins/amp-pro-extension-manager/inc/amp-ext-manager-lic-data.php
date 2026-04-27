<?php

        $settings_url = esc_url(admin_url('admin.php?page=amp-extension-manager'));
        $license_info = get_option( 'ampforwppro_license_info');
        global $all_extensions_data;
        $item_name = "Membership Bundle";
        if (!empty($license_info)) {
        $license_k = $license_info->license_key;
        $download_id = $license_info->download_id;
        $username = $license_info->customer_name;
        }        
        $license_k = $license_info->license_key;
        // $license_info = $license_data;
        global $all_extensions_data;
        $renew = "no";
        $license_exp = "";
        if($license_info){
            $license_exp = date('Y-m-d', strtotime($license_info->expires));
            $license_info_lifetime = $license_info->expires;
            $license_exp_d = date('d-F-Y', strtotime($license_info->expires));
        }
        $license_k = $license_info->license_key;
        $download_id = $license_info->download_id;
        // print_r($download_id);die;
        $today = date('Y-m-d');
        $exp_date =$license_exp;
        $date1 = date_create($today);
            $date2 = date_create($exp_date);
            $diff = date_diff($date1,$date2);
            $days = $diff->format("%a");
            if($license_info_lifetime == 'lifetime' ){
                $days = 'Lifetime';
                if ($days == 'Lifetime') {
                $expire_msg = " Your License is Valid for Lifetime ";
                }
            }
            elseif($today > $exp_date){
                $days = -$days;
            }
            // print_r($days);die;
            $exp_id = '';
            $expire_msg = '';
            $renew_mesg = '';
            $span_class = '';
            $span_class_css = '';
            $ext_settings_url = 'ext_url';
            if ( $days == 'Lifetime' ) {
                $expire_msg_before = '<span class="before_msg_Pro_active">Your License is</span>';
                $expire_msg = " Valid for Lifetime ";
                $span_class = "aeaicon dashicons dashicons-yes pro_icon";
                $color = 'color:green';
            }
            else if( $days>=0 && $days<=30){
                $renew_url = "https://accounts.ampforwp.com/order/?edd_license_key=".$license_k."&download_id=".$download_id."";
                $expire_msg_before = '<span class="before_msg_Pro">Your License is</span> <span class="amppro-alert">expiring in '.$days.' days</span><a target="blank" class="renewal-license" href="'.$renew_url.'"><span class="renew-lic">'.esc_html__('Renew', 'accelerated-mobile-pages').'</span></a>';
                // $span_class = "aeaicon dashicons dashicons-alert pro_icon";
                $color = 'color:green';
            }else if($days<0){
                $ext_settings_url = 'ext_settings_url';
                $renew_url = "https://accounts.ampforwp.com/order/?edd_license_key=".$license_k."&download_id=".$download_id."";
                $expire_msg = " Expired ";
                $expire_msg_before = '<span class="Pro_inactive">Your</span><span class="expired-msg" style="color:red"> License has been</span>';
                $exp_class = 'expired';
                $exp_id = 'exp';
                $exp_class_2 = 'renew_license_key_';
                $span_class = "aeaicon dashicons dashicons-no";
                $renew_mesg = '<a target="blank" class="renewal-license" href="'.$renew_url.'"><span class="renew-lic">'.esc_html__('Renew', 'accelerated-mobile-pages').'</span></a>';
                $color = 'color:red';
            }else{
                $expire_msg = " Active ";
                $expire_msg_before = '<span class="before_msg_Pro_active">Your License is</span>';
                $span_class = "aeaicon dashicons dashicons-yes pro_icon";
                $span_class_css = 'style="font-size:32px"';
                $color = 'color:green';
            }

   // print_r($username);die;
   // customer_name
            if($username!="" && class_exists('AMPExtensionManager')) {
        $license_info = get_option( 'ampforwppro_license_info');
    if ($license_info) {  
    $fname = substr($username, 0, strpos($username, ' '));
    $fname =  ucfirst($fname) ;
    $proDetailsProvide = "<span class='extension-menu-call'>
    <span class='activated-plugins'>Hi <span class='ampfwp_pro_key_user_name'>".esc_html($fname)."</span>".','."
    <span class='activated-plugins'> ".$expire_msg_before." <span class='inner_span' id=".$exp_id.">".$expire_msg."</span></span>
    <span class='".$span_class."' ".$span_class_css."></span>".$renew_mesg ;    
$proDetailsProvide .= "<a class=".$ext_settings_url." href='".$settings_url."'><i class=\"dashicons-before dashicons-admin-generic\"></i></a></span>";
}

}
elseif($username!="" && !class_exists('AMPExtensionManager') ){
    $proDetailsProvide = "<span class='extension-menu-call'><span class='activated-plugins'>Hello, ".esc_html($username)."</span> <a class='' href='".esc_url(admin_url('admin.php?page=amp_options&tabid=opt-go-premium'))."'><i class='dashicons-before dashicons-admin-generic'></i></a></span>";
}
elseif($ampforwp_is_productActivated){
    $proDetailsProvide = "<span class='extension-menu-call'>One more Step <a class='premium_features_btn' href='".esc_url(admin_url('admin.php?tabid=opt-go-premium&page=amp_options'))."'>Enter license here</a></span>";
}