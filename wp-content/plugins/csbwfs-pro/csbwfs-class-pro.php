<?php
/*
 * Custom Share Buttons With Floating Sidebar Pro(C)
 * @get_csbwf_pro_sidebar_options()
 * @get_csbwf_pro_sidebar_content()
 * */
?>
<?php 
// get all options value for "Custom Share Buttons with Floating Sidebar"
	function get_csbwf_pro_sidebar_options() {
		global $wpdb;
		$ctOptions = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'csbwfs_%'");
		foreach ($ctOptions as $option) {
			$ctOptions[$option->option_name] =  $option->option_value;
		}
		return $ctOptions;	
	}
/** Get the current url*/
if(!function_exists('csbwfs_pro_current_path_protocol')):
function csbwfs_pro_current_path_protocol($s, $use_forwarded_host=false)
{
    $pwahttp = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $pwasprotocal = strtolower($s['SERVER_PROTOCOL']);
    $pwa_protocol = substr($pwasprotocal, 0, strpos($pwasprotocal, '/')) . (($pwahttp) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$pwahttp && $port=='80') || ($pwahttp && $port=='443')) ? '' : ':'.$port;
    $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    return $pwa_protocol . '://' . $host;
}
endif;
if(!function_exists('csbwfs_pro_get_current_page_url')):
function csbwfs_pro_get_current_page_url($s, $use_forwarded_host=false)
{
    return csbwfs_pro_current_path_protocol($s, $use_forwarded_host) . $s['REQUEST_URI'];
}
endif;
/* 
 * Site is browsing in mobile or not
 * @IsMobile()
 * */
function isMobilePro() {
// Check the server headers to see if they're mobile friendly
if(isset($_SERVER["HTTP_X_WAP_PROFILE"])) {
    return true;
}
// Let's NOT return "mobile" if it's an iPhone, because the iPhone can render normal pages quite well.
if(strstr($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
    return false;
}
// If the http_accept header supports wap then it's a mobile too
if(preg_match("/wap\.|\.wap/i",$_SERVER["HTTP_ACCEPT"])) {
    return true;
}
// Still no luck? Let's have a look at the user agent on the browser. If it contains
// any of the following, it's probably a mobile device. Kappow!
if(isset($_SERVER["HTTP_USER_AGENT"])){
    $user_agents = array("midp", "j2me", "avantg", "docomo", "novarra", "palmos", "palmsource", "240x320", "opwv", "chtml", "pda", "windows\ ce", "mmp\/", "blackberry", "mib\/", "symbian", "wireless", "nokia", "hand", "mobi", "phone", "cdm", "up\.b", "audio", "SIE\-", "SEC\-", "samsung", "HTC", "mot\-", "mitsu", "sagem", "sony", "alcatel", "lg", "erics", "vx", "NEC", "philips", "mmm", "xx", "panasonic", "sharp", "wap", "sch", "rover", "pocket", "benq", "java", "pt", "pg", "vox", "amoi", "bird", "compal", "kg", "voda", "sany", "kdd", "dbt", "sendo", "sgh", "gradi", "jb", "\d\d\di", "moto");
    foreach($user_agents as $user_string){
        if(preg_match("/".$user_string."/i",$_SERVER["HTTP_USER_AGENT"])) {
            return true;
        }
    }
}
// None of the above? Then it's probably not a mobile device.
return false;
}
// Get plugin options
global $pluginOptionsVal;
$pluginOptionsVal=get_csbwf_pro_sidebar_options();
//check plugin in enable or not
if(isset($pluginOptionsVal['csbwfs_pro_active']) && $pluginOptionsVal['csbwfs_pro_active']==1){
	
if((isMobilePro()) && 
isset($pluginOptionsVal['csbwfs_deactive_for_mob']) && $pluginOptionsVal['csbwfs_deactive_for_mob']!='')
{
// silent is Gold;
}else
{
add_action('wp_footer','get_csbwf_pro_sidebar_content');
add_action( 'wp_enqueue_scripts', 'csbwf_pro_sidebar_scripts');
add_action('wp_footer','csbwf_pro_sidebar_load_inline_js',100);
add_action('wp_footer','csbwfs_pro_cookie',100);
}

}

function csbwfs_pro_cookie()
{
	echo $cookieVal='<script>csbwfsCheckCookie();function csbwfsSetCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname+"="+cvalue+"; "+expires;
}

function csbwfsGetCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(\';\');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==\' \') c = c.substring(1);
        if (c.indexOf(name) != -1) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function csbwfsCheckCookie() {
    var button_status=csbwfsGetCookie("csbwfs_show_hide_status");
    if (button_status != "") {
        
    } else {
      // user = prompt("Please enter your name:","");
     //  if (user != "" && user != null) {
        csbwfsSetCookie("csbwfs_show_hide_status", "active",1);
      // }
    }
}

</script>';


}

if(isset($pluginOptionsVal['csbwfs_pro_buttons_active']) && $pluginOptionsVal['csbwfs_pro_buttons_active']==1){
add_action( 'wp_enqueue_scripts', 'csbwf_pro_sidebar_scripts' );
add_filter( 'the_content', 'csbfs_pro_the_content_filter', 20);
}

//register style and scrip files
function csbwf_pro_sidebar_scripts() {
$pluginOptionsVal=get_csbwf_pro_sidebar_options();
wp_enqueue_script( 'jquery' ); // wordpress jQuery
wp_register_style( 'csbwf_pro_sidebar_style', plugins_url( 'css/csbwfs-pro.css',__FILE__ ) );
wp_enqueue_style( 'csbwf_pro_sidebar_style' );
/** default lightbox form css*/
if(isset($pluginOptionsVal['csbwfs_mail_css']) && $pluginOptionsVal['csbwfs_mail_css']==''):
//wp_register_style( 'csbwf_pro_sidebar_form_style', plugins_url( 'css/csbwfs-form.css',__FILE__ ) );
//wp_enqueue_style( 'csbwf_pro_sidebar_form_style' );
endif;
}

/*
-----------------------------------------------------------------------------------------------
                              "Add the jQuery code in head section using hooks"
-----------------------------------------------------------------------------------------------
*/


function csbwf_pro_sidebar_load_inline_js()
{
   $pluginOptionsVal=get_csbwf_pro_sidebar_options();
	$jscnt='
	
	<script type="text/javascript">
	  var windWidth=jQuery( window ).width();
	  //alert(windWidth);
	  var animateWidth;
	  var defaultAnimateWidth;
	  animateHeight="49";
	 defaultAnimateHeight= animateHeight-2;';
  $jscnt.='
	jQuery(document).ready(function()
  { if(windWidth < "500" )
   {
	   animateWidth="45";
	   defaultAnimateWidth= animateWidth-10;
	   }else
			   {
				   animateWidth="55";
				   defaultAnimateWidth= animateWidth-10;
				   }';
if($pluginOptionsVal['csbwfs_position']=='right' || $pluginOptionsVal['csbwfs_position']=='left'): 
	if($pluginOptionsVal['csbwfs_delayTimeBtn']!='0'):
	$jscnt.='jQuery("#csbwfs-delaydiv").hide();
	setTimeout(function(){
	jQuery("#csbwfs-delaydiv").fadeIn();}, '.$pluginOptionsVal['csbwfs_delayTimeBtn'].');';
	endif;  

	if($pluginOptionsVal['csbwfs_tpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-tw a").hover(function(){
	jQuery("div#csbwfs-tw a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-tw a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;

	if($pluginOptionsVal['csbwfs_fpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-fb a").hover(function(){
	jQuery("div#csbwfs-fb a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-fb a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;

	if($pluginOptionsVal['csbwfs_mpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-ml a").hover(function(){
	jQuery("div#csbwfs-ml a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-ml a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;

	if($pluginOptionsVal['csbwfs_gpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-gp a").hover(function(){
	jQuery("div#csbwfs-gp a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-gp a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;

	if($pluginOptionsVal['csbwfs_lpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-li a").hover(function(){
	jQuery("div#csbwfs-li a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-li a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;

	if($pluginOptionsVal['csbwfs_ppublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-pin a").hover(function(){
	jQuery("div#csbwfs-pin a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-pin a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;

	if(isset($pluginOptionsVal['csbwfs_ytpublishBtn']) && $pluginOptionsVal['csbwfs_ytpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-yt a").hover(function(){
	jQuery("div#csbwfs-yt a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-yt a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	if(isset($pluginOptionsVal['csbwfs_republishBtn']) && $pluginOptionsVal['csbwfs_republishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-re a").hover(function(){
	jQuery("div#csbwfs-re a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-re a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;

	if(isset($pluginOptionsVal['csbwfs_stpublishBtn']) && $pluginOptionsVal['csbwfs_stpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-st a").hover(function(){
	jQuery("div#csbwfs-st a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-st a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;

	if(isset($pluginOptionsVal['csbwfs_gtpublishBtn']) && $pluginOptionsVal['csbwfs_gtpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-gt a").hover(function(){
	jQuery("div#csbwfs-gt a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-gt a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	if(isset($pluginOptionsVal['csbwfs_instpublishBtn']) && $pluginOptionsVal['csbwfs_instpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-inst a").hover(function(){
	jQuery("div#csbwfs-inst a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-inst a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	
	if(isset($pluginOptionsVal['csbwfs_diggpublishBtn']) && $pluginOptionsVal['csbwfs_diggpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-digg a").hover(function(){
	jQuery("div#csbwfs-digg a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-digg a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	
	if(isset($pluginOptionsVal['csbwfs_yumpublishBtn']) && $pluginOptionsVal['csbwfs_yumpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-yum a").hover(function(){
	jQuery("div#csbwfs-yum a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-yum a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	
	if(isset($pluginOptionsVal['csbwfs_vkpublishBtn']) && $pluginOptionsVal['csbwfs_vkpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-vk a").hover(function(){
	jQuery("div#csbwfs-vk a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-vk a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	
	if(isset($pluginOptionsVal['csbwfs_bufpublishBtn']) && $pluginOptionsVal['csbwfs_bufpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-buf a").hover(function(){
	jQuery("div#csbwfs-buf a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-buf a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;

	if(isset($pluginOptionsVal['csbwfs_whatsapppublishBtn']) && $pluginOptionsVal['csbwfs_whatsapppublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-whats a").hover(function(){
	jQuery("div#csbwfs-whats a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-whats a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	if(isset($pluginOptionsVal['csbwfs_linepublishBtn']) && $pluginOptionsVal['csbwfs_linepublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-line a").hover(function(){
	jQuery("div#csbwfs-line a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-line a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	if(isset($pluginOptionsVal['csbwfs_skypublishBtn']) && $pluginOptionsVal['csbwfs_skypublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-skype a").hover(function(){
	jQuery("div#csbwfs-skype a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-skype a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	if(isset($pluginOptionsVal['csbwfs_rsspublishBtn']) && $pluginOptionsVal['csbwfs_rsspublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-rss a").hover(function(){
	jQuery("div#csbwfs-rss a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-rss a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	if(isset($pluginOptionsVal['csbwfs_gmpublishBtn']) && $pluginOptionsVal['csbwfs_gmpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-gm a").hover(function(){
	jQuery("div#csbwfs-gm a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-gm a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	if(isset($pluginOptionsVal['csbwfs_tupublishBtn']) && $pluginOptionsVal['csbwfs_tupublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-tu a").hover(function(){
	jQuery("div#csbwfs-tu a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-tu a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	if(isset($pluginOptionsVal['csbwfs_blpublishBtn']) && $pluginOptionsVal['csbwfs_blpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-bl a").hover(function(){
	jQuery("div#csbwfs-bl a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-bl a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	if(isset($pluginOptionsVal['csbwfs_depublishBtn']) && $pluginOptionsVal['csbwfs_depublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-de a").hover(function(){
	jQuery("div#csbwfs-de a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-de a").stop( true, true ).animate({width:defaultAnimateWidth});
	});';
	endif;
	
	if(isset($pluginOptionsVal['csbwfs_printpublishBtn']) && $pluginOptionsVal['csbwfs_printpublishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-print a").hover(function(){
	jQuery("div#csbwfs-print a").animate({width:animateWidth});
	},function(){
	jQuery("div#csbwfs-print a").stop( true, true ).animate({width:defaultAnimateWidth});
	});
   jQuery("div.csbwfs-print a").click(function(){
     var csbwfsdivElements1 = jQuery("body").html();
     jQuery("#csbwfs-delaydiv").html("");
	 var csbwfsdivElements = jQuery("body").html();
	 document.body.innerHTML = 
          "<html><head><title></title></head><body>" + 
          csbwfsdivElements + "</body>";
           window.print();
           window.close();
          jQuery("body").html(csbwfsdivElements1);
	});
	';
	endif;
	
	$csbwfsCustomWidth=$csbwfsCustomWidth2=$csbwfsCustomWidth3=$csbwfsCustomWidth4='150';
	if(isset($pluginOptionsVal['csbwfs_custom_width']) && $pluginOptionsVal['csbwfs_custom_width']!=''):
	$csbwfsCustomWidth=$pluginOptionsVal['csbwfs_custom_width'];
	endif;
	if(isset($pluginOptionsVal['csbwfs_custom2_width']) && $pluginOptionsVal['csbwfs_custom2_width']!=''):
	$csbwfsCustomWidth2=$pluginOptionsVal['csbwfs_custom2_width'];
	endif;
	if(isset($pluginOptionsVal['csbwfs_custom3_width']) && $pluginOptionsVal['csbwfs_custom3_width']!=''):
	$csbwfsCustomWidth3=$pluginOptionsVal['csbwfs_custom3_width'];
	endif;
	if(isset($pluginOptionsVal['csbwfs_custom4_width']) && $pluginOptionsVal['csbwfs_custom4_width']!=''):
	$csbwfsCustomWidth4=$pluginOptionsVal['csbwfs_custom4_width'];
	endif;
	if(isset($pluginOptionsVal['csbwfs_c1publishBtn']) && $pluginOptionsVal['csbwfs_c1publishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-c1 a").hover(function(){
	jQuery("div.custom1 .title").show();
	jQuery("div#csbwfs-c1 a").animate({width:'.$csbwfsCustomWidth.'});
	},function(){
 
	jQuery("div#csbwfs-c1 a").stop( true, true ).animate({width:defaultAnimateWidth});
	   jQuery("div.custom1 .title").hide();
	});';
	endif;
	
	if(isset($pluginOptionsVal['csbwfs_c2publishBtn']) && $pluginOptionsVal['csbwfs_c2publishBtn']!=''):
	$jscnt.='jQuery("div#csbwfs-c2 a").hover(function(){
	jQuery("div.custom2 .title").show();
	jQuery("div#csbwfs-c2 a").animate({width:'.$csbwfsCustomWidth2.'});
	},function(){
	jQuery("div#csbwfs-c2 a").stop( true, true ).animate({width:defaultAnimateWidth});
	jQuery("div.custom2 .title").hide();
	});';
	endif;
	if(isset($pluginOptionsVal['csbwfs_c3publishBtn']) && $pluginOptionsVal['csbwfs_c3publishBtn']!=''):
	if($pluginOptionsVal['csbwfs_custom3_defltwidth']){$wth3=$pluginOptionsVal['csbwfs_custom3_defltwidth'];}else {$wth3='45';}
	$jscnt.='jQuery("div#csbwfs-c3 a").hover(function(){
	jQuery("div.custom3 .title").show();
	jQuery("div#csbwfs-c3 a").animate({width:'.$csbwfsCustomWidth3.'});
	},function(){
	jQuery("div#csbwfs-c3 a").stop( true, true ).animate({width:'.$wth3.'});
	   jQuery("div.custom3 .title").hide();
	});';
	endif;
	
	if(isset($pluginOptionsVal['csbwfs_c4publishBtn']) && $pluginOptionsVal['csbwfs_c4publishBtn']!=''):
	if($pluginOptionsVal['csbwfs_custom4_defltwidth']){$wth4=$pluginOptionsVal['csbwfs_custom4_defltwidth'];}else {$wth4='45';}
	$jscnt.='jQuery("div#csbwfs-c4 a").hover(function(){
	jQuery("div.custom4 .title").show();
	jQuery("div#csbwfs-c4 a").animate({width:'.$csbwfsCustomWidth4.'});
	},function(){
	jQuery("div#csbwfs-c4 a").stop( true, true ).animate({width:'.$wth4.'});
	jQuery("div.custom4 .title").hide();
	});';
	endif;

else: //bottom position
 
  
 endif;
 
if(isset($pluginOptionsVal['csbwfs_auto_hide']) && $pluginOptionsVal['csbwfs_auto_hide']!=''):
$jscnt.='csbwfsSetCookie("csbwfs_show_hide_status","in_active","1");';
endif;

  $jscnt.='jQuery("div.csbwfs-show").hide();
  jQuery("div.csbwfs-show a").click(function(){
    jQuery("div#csbwfs-social-inner").show();
     jQuery("div.csbwfs-show").hide();
    jQuery("div.csbwfs-hide").show();
    csbwfsSetCookie("csbwfs_show_hide_status","active","1");
  });
  
  jQuery("div.csbwfs-hide a").click(function(){
     jQuery("div.csbwfs-show").show();
      jQuery("div.csbwfs-hide").hide();
     jQuery("div#csbwfs-social-inner").hide();
     csbwfsSetCookie("csbwfs_show_hide_status","in_active","1");
  });';
   $jscnt.='var button_status=csbwfsGetCookie("csbwfs_show_hide_status");
    if (button_status =="in_active") {
      jQuery("div.csbwfs-show").show();
      jQuery("div.csbwfs-hide").hide();
     jQuery("div#csbwfs-social-inner").hide();
    } else {
      jQuery("div#csbwfs-social-inner").show();
     jQuery("div.csbwfs-show").hide();
    jQuery("div.csbwfs-hide").show();
    }';

  
$jscnt.='});';

if($pluginOptionsVal['csbwfs_mpublishBtn']!=''){
$formdivstyle='';
$csbwfs_form_width=get_option('csbwfs_form_width');
if($csbwfs_form_width!=''){$formdivstyle.=' width:'.$csbwfs_form_width.';';}
$csbwfs_form_bg = get_option('csbwfs_form_bg');
if($csbwfs_form_bg!=''){$formdivstyle.=' background:'.$csbwfs_form_bg.';';}

$jscnt.='jQuery(".csbwfs-mail a").click(function(e) {
	e.preventDefault();
	var content =jQuery("#csbwfs_contact").html();
			var csbwfs_lightbox_content = 
			"<div id=\"csbwfs_lightbox\">" +
				"<div id=\"csbwfs_content\" style=\"'.$formdivstyle.'\">" +
				"<div class=\"csbwfs-close\"><span ></span></div>"  + content  +
				"</div>" +	
			"</div>";
			//insert lightbox HTML into page
			jQuery("#maillightbox").append(csbwfs_lightbox_content).hide().fadeIn(1000);

			 
});	

jQuery(document).submit(function(e){
    var form = jQuery(e.target);
    if(form.is("#csbwfs_form"))
    {
	var cptha1=parseInt(document.getElementById("cswbfs_hdn_cpthaval1").value);
	var cptha2=parseInt(document.getElementById("cswbfs_hdn_cpthaval2").value);
	var cptha3=document.getElementById("cswbfs_hdn_cpthaaction").value;
	var cptha4=parseInt(document.getElementById("csbwfs_code").value);
	if(cptha3=="x"){
	var finalVl = cptha1 * cptha2;
    }else
    {
   var finalVl = cptha1 + cptha2;		
	} 
			
	if( (document.getElementById("csbwfs_name").value=="") || (document.getElementById("csbwfs_email").value=="") )
	{
	//alert("Please fill all required fields 1");
	jQuery("#csbwfs_form .csbwfs-req-fields").css("border","1px solid red");
	return false;
	}
	
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("csbwfs_email").value))
	  { 
		  } 
		  else
		  {
			  jQuery("#csbwfs_form .csbwfs-req-fields").css("border","1px solid #ccc");
			  jQuery("#csbwfs_form .csbwfs-req-email").css("border","1px solid red");
			 // alert("Please enter valid email 1"); 
			  return false;
			  }
	
    if(cptha4!=finalVl)
	{
	 jQuery("#csbwfs_form .csbwfs-req-fields").css("border","1px solid #ccc");
	 jQuery("#csbwfs_form .csbwfs-req-cptcha").css("border","1px solid red");
	 jQuery("#csbwfs_form .csbwfs-req-cptcha")
	 jQuery("#csbwfs_form #cptchaErr").html("Please fill correct captcha code");
	 return false;
	}
	
	e.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: form.attr("action"), 
            data: form.serialize(), 
            success: function(data) {
			jQuery("#csbwfs_form")[0].reset();
			jQuery("#maillightbox form").hide();
            jQuery("#maillightbox .csbwfsmsg").show();
            jQuery("#maillightbox .csbwfsmsg").html(data);
           // console.log(data);

            }
        });
    }
	});';
}
	
$jscnt.='</script>';	
echo $jscnt;
}	

 
/*
-----------------------------------------------------------------------------------------------
                              "Custom Share Buttons with Floating Sidebar Pro" HTML
-----------------------------------------------------------------------------------------------
*/

function get_csbwf_pro_sidebar_content() {
global $post;
$pluginOptionsVal=get_csbwf_pro_sidebar_options();
/** Share button Title */
$csbwfs_fb_title ='Share on facebook';
if(isset($pluginOptionsVal['csbwfs_fb_title']) && $pluginOptionsVal['csbwfs_fb_title']!='')
$csbwfs_fb_title=$pluginOptionsVal['csbwfs_fb_title'];

$csbwfs_tw_title ='Share on twitter';
if(isset($pluginOptionsVal['csbwfs_tw_title']) && $pluginOptionsVal['csbwfs_tw_title']!='')
$csbwfs_tw_title=$pluginOptionsVal['csbwfs_tw_title'];

$csbwfs_li_title='Share on linkdin';
if(isset($pluginOptionsVal['csbwfs_li_title']) && $pluginOptionsVal['csbwfs_li_title']!='')
$csbwfs_li_title=$pluginOptionsVal['csbwfs_li_title'];

$csbwfs_pin_title='Share on pintrest';
if(isset($pluginOptionsVal['csbwfs_pin_title']) && $pluginOptionsVal['csbwfs_pin_title']!='')
$csbwfs_pin_title=$pluginOptionsVal['csbwfs_pin_title'];

$csbwfs_gp_title='Share on google';
if(isset($pluginOptionsVal['csbwfs_gp_title']) && $pluginOptionsVal['csbwfs_gp_title']!='')
$csbwfs_gp_title=$pluginOptionsVal['csbwfs_gp_title'];

$csbwfs_mail_title='Send contact request';
if(isset($pluginOptionsVal['csbwfs_mail_title']) && $pluginOptionsVal['csbwfs_mail_title']!='')
$csbwfs_mail_title=$pluginOptionsVal['csbwfs_mail_title'];

$csbwfs_gmail_title='Send contact request';
if(isset($pluginOptionsVal['csbwfs_gmail_title']) && $pluginOptionsVal['csbwfs_gmail_title']!='')
$csbwfs_gmail_title=$pluginOptionsVal['csbwfs_gmail_title'];

$csbwfs_yt_title='Share on youtube';
if(isset($pluginOptionsVal['csbwfs_yt_title']) && $pluginOptionsVal['csbwfs_yt_title']!='')
$csbwfs_yt_title=$pluginOptionsVal['csbwfs_yt_title'];

$csbwfs_re_title='Share on reddit';
if(isset($pluginOptionsVal['csbwfs_re_title']) && $pluginOptionsVal['csbwfs_re_title']!='')
$csbwfs_re_title=$pluginOptionsVal['csbwfs_re_title'];

$csbwfs_st_title='Share on stumbleupon';
if(isset($pluginOptionsVal['csbwfs_st_title']) && $pluginOptionsVal['csbwfs_st_title']!='')
$csbwfs_st_title=$pluginOptionsVal['csbwfs_st_title'];

$csbwfs_gt_title='Translate page';
if(isset($pluginOptionsVal['csbwfs_gt_title']) && $pluginOptionsVal['csbwfs_gt_title']!='')
$csbwfs_gt_title=$pluginOptionsVal['csbwfs_gt_title'];

$csbwfs_inst_title='Share on instagram';
if(isset($pluginOptionsVal['csbwfs_inst_title']) && $pluginOptionsVal['csbwfs_inst_title']!='')
$csbwfs_inst_title=$pluginOptionsVal['csbwfs_inst_title'];

$csbwfs_digg_title='Share on Diggit';
if(isset($pluginOptionsVal['csbwfs_digg_title']) && $pluginOptionsVal['csbwfs_digg_title']!='')
$csbwfs_digg_title=$pluginOptionsVal['csbwfs_digg_title'];

$csbwfs_yum_title='Share on Yummly';
if(isset($pluginOptionsVal['csbwfs_yum_title']) && $pluginOptionsVal['csbwfs_yum_title']!='')
$csbwfs_yum_title=$pluginOptionsVal['csbwfs_yum_title'];

$csbwfs_vk_title='Share on VK';
if(isset($pluginOptionsVal['csbwfs_vk_title']) && $pluginOptionsVal['csbwfs_vk_title']!='')
$csbwfs_vk_title=$pluginOptionsVal['csbwfs_vk_title'];

$csbwfs_print_title='Print';
if(isset($pluginOptionsVal['csbwfs_print_title']) && $pluginOptionsVal['csbwfs_print_title']!='')
$csbwfs_print_title=$pluginOptionsVal['csbwfs_print_title'];

$csbwfs_buf_title='Share on Buffer';
if(isset($pluginOptionsVal['csbwfs_buf_title']) && $pluginOptionsVal['csbwfs_buf_title']!='')
$csbwfs_buf_title=$pluginOptionsVal['csbwfs_buf_title'];

$csbwfs_gm_title='Share on Gmail';
if(isset($pluginOptionsVal['csbwfs_gm_title']) && $pluginOptionsVal['csbwfs_gm_title']!='')
$csbwfs_gm_title=$pluginOptionsVal['csbwfs_gm_title'];
$csbwfs_de_title='Share on Delicious';
if(isset($pluginOptionsVal['csbwfs_de_title']) && $pluginOptionsVal['csbwfs_de_title']!='')
$csbwfs_de_title=$pluginOptionsVal['csbwfs_de_title'];
$csbwfs_tu_title='Share on Tumblr';
if(isset($pluginOptionsVal['csbwfs_tu_title']) && $pluginOptionsVal['csbwfs_tu_title']!='')
$csbwfs_tu_title=$pluginOptionsVal['csbwfs_tu_title'];
$csbwfs_bl_title='Share on Blogger';
if(isset($pluginOptionsVal['csbwfs_bl_title']) && $pluginOptionsVal['csbwfs_bl_title']!='')
$csbwfs_bl_title=$pluginOptionsVal['csbwfs_bl_title'];
/*Default Pinit Share image */
if(isset($pluginOptionsVal['csbwfs_defaultfeaturedshrimg']) && $pluginOptionsVal['csbwfs_defaultfeaturedshrimg']!=''){
	$pinShareImg=$pluginOptionsVal['csbwfs_defaultfeaturedshrimg'];
}else{
	$pinShareImg=plugins_url('images/mrweb-logo.jpg',__FILE__);
	}

if(is_category())
	{
	   $category_id = get_query_var('cat');
	   //$shareurl =get_category_link( $category_id );   
	   $cats = get_the_category();
	   $ShareTitle=$cats[0]->name;
	}elseif(is_singular())
	{
		if ( has_post_thumbnail() ) 
		{
			$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );

			$pinShareImg= $large_image_url[0] ;
		}
			
	  // $shareurl=get_permalink($post->ID);
	  if(isset($pluginOptionsVal['csbwfs_short_url']) && $pluginOptionsVal['csbwfs_short_url']=='yes')
	  {
	   //$shareurl=wp_get_shortlink($post->ID);
	    }
	   $ShareTitle=$post->post_title;
	}
	elseif(is_archive())
	{
	   global $wp;
      // $current_url = get_home_url(null, $wp->request, null);
       
       if ( is_day() ) :
		 $ShareTitle='Daily Archives: '. get_the_date(); 
		elseif ( is_month() ) : 
		 $ShareTitle='Monthly Archives: '. get_the_date('F Y'); 
		elseif ( is_year() ) : 
		 $ShareTitle='Yearly Archives: '. get_the_date('Y'); 
		elseif ( is_author() ) : 
		 $ShareTitle='Author Archives: '. get_the_author(); 
		else :
		 $ShareTitle ='Blog Archives';
		endif;			
	   //$shareurl=$current_url;
	   
	   //$ShareTitle=$post->post_title;
	}
	else
	{
       // $shareurl =home_url('/');
        $ShareTitle=get_bloginfo('name');
		}
$shareurl = csbwfs_pro_get_current_page_url($_SERVER);
$csbwfsImgAlt= $ShareTitle;
$ShareDesc=$ShareOgDesc='';		
if(isset($pluginOptionsVal['csbwfs_og_tags_enable']) && $pluginOptionsVal['csbwfs_og_tags_enable']=='yes'){
/* og title */
$ogtile=get_post_meta($post->ID,"csbwfs_og_title",true);
$csbwfs_dft_og_title=get_option('csbwfs_dft_og_title');
if($ogtile=='' && $csbwfs_dft_og_title!=''){$ogtile=$csbwfs_dft_og_title;}
if($ogtile!=''){$ShareTitle=$ogtile;}
/* og description */
$ShareOgDesc=get_post_meta($post->ID,"csbwfs_og_description",true);
$csbwfs_dft_og_desc=get_option('csbwfs_dft_og_desc');
if($ShareOgDesc=='' && $csbwfs_dft_og_desc!=''){$ShareOgDesc=$csbwfs_dft_og_desc;}
if($ShareOgDesc!=''){$ShareDesc=$ShareOgDesc;}
$ShareOgImg=get_post_meta($post->ID,"csbwfs_og_image_path",true);
$csbwfs_dft_og_img=get_option('csbwfs_dft_og_img');
if($ShareOgImg=='' && $csbwfs_dft_og_img!=''){$ShareOgImg=$csbwfs_dft_og_img;}
if($ShareOgImg!=''){$csbwfsOgimg=$ShareOgImg;}
}
$ShareTitle= htmlspecialchars(urlencode($ShareTitle));
$ShareDesc= htmlspecialchars(urlencode($ShareDesc));
/* Get All buttons Image */
//get facebook button image
if($pluginOptionsVal['csbwfs_fb_image']!=''){ $fImg=$pluginOptionsVal['csbwfs_fb_image'];} 
   else{$fImg=plugins_url('images/fb.png',__FILE__);}   
//get twitter button image  
if($pluginOptionsVal['csbwfs_tw_image']!=''){ $tImg=$pluginOptionsVal['csbwfs_tw_image'];} 
   else{$tImg=plugins_url('images/tw.png',__FILE__);}   
//get linkdin button image
if($pluginOptionsVal['csbwfs_li_image']!=''){ $lImg=$pluginOptionsVal['csbwfs_li_image'];} 
   else{$lImg=plugins_url('images/in.png',__FILE__);}   
//get mail button image  
if($pluginOptionsVal['csbwfs_mail_image']!=''){ $mImg=$pluginOptionsVal['csbwfs_mail_image'];} 
   else{$mImg=plugins_url('images/ml.png',__FILE__);}   
//get google plus button image 
if($pluginOptionsVal['csbwfs_gp_image']!=''){ $gImg=$pluginOptionsVal['csbwfs_gp_image'];} 
   else{$gImg=plugins_url('images/gp.png',__FILE__);}  
//get pinterest button image   
if($pluginOptionsVal['csbwfs_pin_image']!=''){ $pImg=$pluginOptionsVal['csbwfs_pin_image'];} 
   else{$pImg=plugins_url('images/pinit.png',__FILE__);}    
//get youtube button image
if(isset($pluginOptionsVal['csbwfs_yt_image']) && $pluginOptionsVal['csbwfs_yt_image']!=''){ $ytImg=$pluginOptionsVal['csbwfs_yt_image'];} 
   else{$ytImg=plugins_url('images/yt.png',__FILE__);}     
//get reddit plus button image 
if(isset($pluginOptionsVal['csbwfs_re_image']) && $pluginOptionsVal['csbwfs_re_image']!=''){ $reImg=$pluginOptionsVal['csbwfs_re_image'];} 
   else{$reImg=plugins_url('images/reddit.png',__FILE__);}   
//get stumbleupon button image   
if(isset($pluginOptionsVal['csbwfs_st_image']) && $pluginOptionsVal['csbwfs_st_image']!=''){ $stImg=$pluginOptionsVal['csbwfs_st_image'];} 
   else{$stImg=plugins_url('images/st.png',__FILE__);}  
//get google translate button image   
if(isset($pluginOptionsVal['csbwfs_gt_image']) && $pluginOptionsVal['csbwfs_gt_image']!=''){ $gtImg=$pluginOptionsVal['csbwfs_gt_image'];} 
else{$gtImg=plugins_url('images/GTB.png',__FILE__);}   
//get instgrame button image   
if(isset($pluginOptionsVal['csbwfs_inst_image']) && $pluginOptionsVal['csbwfs_inst_image']!=''){ $instImg=$pluginOptionsVal['csbwfs_inst_image'];} 
   else{$instImg=plugins_url('images/inst.png',__FILE__);}   
//get diggit button image   
if(isset($pluginOptionsVal['csbwfs_digg_image']) && $pluginOptionsVal['csbwfs_digg_image']!=''){ $diggImg=$pluginOptionsVal['csbwfs_digg_image'];} 
   else{$diggImg=plugins_url('images/diggit.png',__FILE__);}   
//get yummly button image   
if(isset($pluginOptionsVal['csbwfs_yum_image']) && $pluginOptionsVal['csbwfs_yum_image']!=''){ $yumImg=$pluginOptionsVal['csbwfs_yum_image'];} 
   else{$yumImg=plugins_url('images/yum.png',__FILE__);}
//get VK button image   
if(isset($pluginOptionsVal['csbwfs_vk_image']) && $pluginOptionsVal['csbwfs_vk_image']!=''){ $vkImg=$pluginOptionsVal['csbwfs_vk_image'];} 
   else{$vkImg=plugins_url('images/vk.png',__FILE__);}
//get Buffer button image   
if(isset($pluginOptionsVal['csbwfs_buf_image']) && $pluginOptionsVal['csbwfs_buf_image']!=''){ $bufImg=$pluginOptionsVal['csbwfs_buf_image'];} 
   else{$bufImg=plugins_url('images/buf.png',__FILE__);}  
//get print button image   
if(isset($pluginOptionsVal['csbwfs_print_image']) && $pluginOptionsVal['csbwfs_print_image']!=''){ $printImg=$pluginOptionsVal['csbwfs_print_image'];} 
   else{$printImg=plugins_url('images/print.png',__FILE__);}              
//get gmail button image   
if(isset($pluginOptionsVal['csbwfs_gm_image']) && $pluginOptionsVal['csbwfs_gm_image']!=''){ $gmImg=$pluginOptionsVal['csbwfs_gm_image'];} 
   else{$gmImg=plugins_url('images/gm.png',__FILE__);}              
//get delicious button image   
if(isset($pluginOptionsVal['csbwfs_de_image']) && $pluginOptionsVal['csbwfs_de_image']!=''){ $deImg=$pluginOptionsVal['csbwfs_de_image'];} 
   else{$deImg=plugins_url('images/de.png',__FILE__);}              
//get blogger button image   
if(isset($pluginOptionsVal['csbwfs_bl_image']) && $pluginOptionsVal['csbwfs_bl_image']!=''){ $blImg=$pluginOptionsVal['csbwfs_bl_image'];} 
   else{$blImg=plugins_url('images/bl.png',__FILE__);}              
//get tumbler button image   
if(isset($pluginOptionsVal['csbwfs_tu_image']) && $pluginOptionsVal['csbwfs_tu_image']!=''){ $tuImg=$pluginOptionsVal['csbwfs_tu_image'];} 
   else{$tuImg=plugins_url('images/tu.png',__FILE__);}              
//get email message
if(is_page() || is_single() || is_category() || is_archive()){
	
if($pluginOptionsVal['csbwfs_mailMessage']!=''){ $mailMsg=$pluginOptionsVal['csbwfs_mailMessage'];} else{
$mailMsg='?subject='.$ShareTitle.'&body='.$shareurl;}
 }else
 {
	 $mailMsg='?subject='.get_bloginfo('name').'&body='.home_url('/');
	 }
 

// Top Margin
if($pluginOptionsVal['csbwfs_top_margin']!=''){
	$margin=$pluginOptionsVal['csbwfs_top_margin'];
}else
{
	$margin='25%';
	}
// Define distance from left/right/bottom
$csbwfsDistance='0';
$csbwfsShareimage='';
if(isset($pluginOptionsVal['csbwfs_sbi_image']) && $pluginOptionsVal['csbwfs_sbi_image']!='')
{
	$csbwfsShareimage=$pluginOptionsVal['csbwfs_sbi_image'];
	}
if(isset($pluginOptionsVal['csbwfs_position_from_lr']) && $pluginOptionsVal['csbwfs_position_from_lr']!='' && !isMobilePro())
$csbwfsDistance=$pluginOptionsVal['csbwfs_position_from_lr'];

$bottomPosition='';
if($pluginOptionsVal['csbwfs_position']=='right'){
	$style=' style="top:'.$margin.';right:'.$csbwfsDistance.';"';
	$idName=' id="csbwfs-right"';
	if($csbwfsShareimage!==''){$showImg=$csbwfsShareimage;}else{$showImg=plugins_url('images/hide-r.png',__FILE__);}
	$hideImg='show.png';
	
}elseif($pluginOptionsVal['csbwfs_position']=='bottom'){
	$style=' style="right:0;bottom:'.$csbwfsDistance.';top:auto;"';
	$idName=' id="csbwfs-bottom"';
	if($csbwfsShareimage!==''){$showImg=$csbwfsShareimage;}else{$showImg=plugins_url('images/hide-b.png',__FILE__);}
	$hideImg='hideb.png';
        $bottomPosition='bottom';
}else
{
	$idName=' id="csbwfs-left"';
	$style=' style="top:'.$margin.';left:'.$csbwfsDistance.';"';
    if($csbwfsShareimage!==''){$showImg=$csbwfsShareimage;}else{$showImg=plugins_url('images/hide-l.png',__FILE__);}
	$hideImg='hide.png';
	}

//Set horizontal Sidebar Position for mobile 
if(isset($pluginOptionsVal['csbwfs_pro_horizontal_for_mobile']) && $pluginOptionsVal['csbwfs_pro_horizontal_for_mobile']=='yes'){
if(isMobilePro()):
	$style=' style="right:0;bottom:0;top:auto;"';
	$idName=' id="csbwfs-bottom"';
	if($csbwfsShareimage!==''){$showImg=$csbwfsShareimage;}else{$showImg=plugins_url('images/hide-b.png',__FILE__);}
	$hideImg='show.png';
	$bottomPosition='bottom';
	endif;
}
   
/* Get All buttons background color */

//get facebook button image background color 
if($pluginOptionsVal['csbwfs_fb_bg']!=''){ $fImgbg=' style="background:'.$pluginOptionsVal['csbwfs_fb_bg'].';"';} 
   else{$fImgbg='';}   
//get twitter button image  background color 
if($pluginOptionsVal['csbwfs_tw_bg']!=''){ $tImgbg=' style="background:'.$pluginOptionsVal['csbwfs_tw_bg'].';"';} 
   else{$tImgbg='';}   
//get linkdin button image background color 
if($pluginOptionsVal['csbwfs_li_bg']!=''){ $lImgbg=' style="background:'.$pluginOptionsVal['csbwfs_li_bg'].';"';} 
   else{$lImgbg='';}   
//get mail button image  background color 
if($pluginOptionsVal['csbwfs_mail_bg']!=''){ $mImgbg=' style="background:'.$pluginOptionsVal['csbwfs_mail_bg'].';"';} 
   else{$mImgbg='';}   
//get google plus button image  background color 
if($pluginOptionsVal['csbwfs_gp_bg']!=''){ $gImgbg=' style="background:'.$pluginOptionsVal['csbwfs_gp_bg'].';"';} 
   else{$gImgbg='';}  
//get pinterest button image   background color 
if($pluginOptionsVal['csbwfs_pin_bg']!=''){ $pImgbg=' style="background:'.$pluginOptionsVal['csbwfs_pin_bg'].';"';} 
   else{$pImgbg='';}  
    
//get youtube button image   background color 
if(isset($pluginOptionsVal['csbwfs_yt_bg']) && $pluginOptionsVal['csbwfs_yt_bg']!=''){ $ytImgbg=' style="background:'.$pluginOptionsVal['csbwfs_yt_bg'].';"';} 
   else{$ytImgbg='';}   
//get reddit button image   background color 
if(isset($pluginOptionsVal['csbwfs_re_bg']) && $pluginOptionsVal['csbwfs_re_bg']!=''){ $reImgbg=' style="background:'.$pluginOptionsVal['csbwfs_re_bg'].';"';} 
   else{$reImgbg='';}  
//get stumbleupon button image   background color 
if(isset($pluginOptionsVal['csbwfs_st_bg']) && $pluginOptionsVal['csbwfs_st_bg']!=''){ $stImgbg=' style="background:'.$pluginOptionsVal['csbwfs_st_bg'].';"';} 
   else{$stImgbg='';}  
//get gmail button image   background color 
if(isset($pluginOptionsVal['csbwfs_gm_bg']) && $pluginOptionsVal['csbwfs_gm_bg']!=''){ $gmImgbg=' style="background:'.$pluginOptionsVal['csbwfs_gm_bg'].';"';} 
   else{$gmImgbg='';}  
   
//get google translate button image   background color 
if(isset($pluginOptionsVal['csbwfs_gt_bg']) && $pluginOptionsVal['csbwfs_gt_bg']!=''){ $gtImgbg=' style="background:'.$pluginOptionsVal['csbwfs_gt_bg'].';"';} 
   else{$gtImgbg='';}  
//get instgrame button image   background color 
if(isset($pluginOptionsVal['csbwfs_inst_bg']) && $pluginOptionsVal['csbwfs_inst_bg']!=''){ $instImgbg=' style="background:'.$pluginOptionsVal['csbwfs_inst_bg'].';"';} 
   else{$instImgbg='';}     
//get diggit button image   background color 
if(isset($pluginOptionsVal['csbwfs_digg_bg']) && $pluginOptionsVal['csbwfs_digg_bg']!=''){ $diggImgbg=' style="background:'.$pluginOptionsVal['csbwfs_digg_bg'].';"';} 
   else{$diggImgbg='';}     
//get yummly button image   background color 
if(isset($pluginOptionsVal['csbwfs_yum_bg']) && $pluginOptionsVal['csbwfs_yum_bg']!=''){ $yumImgbg=' style="background:'.$pluginOptionsVal['csbwfs_yum_bg'].';"';} 
   else{$yumImgbg='';}
//get VK button image   background color 
if(isset($pluginOptionsVal['csbwfs_vk_bg']) && $pluginOptionsVal['csbwfs_vk_bg']!=''){ $vkImgbg=' style="background:'.$pluginOptionsVal['csbwfs_vk_bg'].';"';} 
   else{$vkImgbg='';}
//get buffer button image   background color 
if(isset($pluginOptionsVal['csbwfs_buf_bg']) && $pluginOptionsVal['csbwfs_buf_bg']!=''){ $bufImgbg=' style="background:'.$pluginOptionsVal['csbwfs_buf_bg'].';"';} 
   else{$bufImgbg='';}
//get print button image   background color 
if(isset($pluginOptionsVal['csbwfs_print_bg']) && $pluginOptionsVal['csbwfs_print_bg']!=''){ $printImgbg=' style="background:'.$pluginOptionsVal['csbwfs_print_bg'].';"';} 
   else{$printImgbg='';}
//get gmail button image   background color 
if(isset($pluginOptionsVal['csbwfs_gm_bg']) && $pluginOptionsVal['csbwfs_gm_bg']!=''){ $gmImgbg=' style="background:'.$pluginOptionsVal['csbwfs_gm_bg'].';"';} 
   else{$gmImgbg='';}
//get delicious image   background color 
if(isset($pluginOptionsVal['csbwfs_de_bg']) && $pluginOptionsVal['csbwfs_de_bg']!=''){ $deImgbg=' style="background:'.$pluginOptionsVal['csbwfs_de_bg'].';"';} 
   else{$deImgbg='';}
//get blogger button image   background color 
if(isset($pluginOptionsVal['csbwfs_bl_bg']) && $pluginOptionsVal['csbwfs_bl_bg']!=''){ $blImgbg=' style="background:'.$pluginOptionsVal['csbwfs_bl_bg'].';"';} 
   else{$blImgbg='';}
//get tumbler button image   background color 
if(isset($pluginOptionsVal['csbwfs_tu_bg']) && $pluginOptionsVal['csbwfs_tu_bg']!=''){ $tuImgbg=' style="background:'.$pluginOptionsVal['csbwfs_tu_bg'].';"';} 
   else{$tuImgbg='';}
/** Message */ 
if($pluginOptionsVal['csbwfs_show_btn']!=''){ $showbtn=$pluginOptionsVal['csbwfs_show_btn'];} 
   else{$showbtn='Show';}   
//get show/hide button message 
if($pluginOptionsVal['csbwfs_hide_btn']!=''){ $hidebtn=$pluginOptionsVal['csbwfs_hide_btn'];} 
   else{$hidebtn='Hide';}   
//get mail button message 
if($pluginOptionsVal['csbwfs_share_msg']!=''){ $sharemsg=$pluginOptionsVal['csbwfs_share_msg'];} 
   else{$sharemsg='Share This With Your Friends';}   
/** Custom Button */
$csbwfsCustomBtn1 =$csbwfsCustomBtn2 =$csbwfsCustomBtn3 =$csbwfsCustomBtn4 =''; 
 
/** Button-1*/
if($pluginOptionsVal['csbwfs_c1publishBtn']!=''):
$csbwfsCustomBtn1 .='<div class="csbwfs-sbutton custom1 extraImgBtns" id="csbwfs-sbutton1"><div id="csbwfs-c1"><a href="'.$pluginOptionsVal['csbwfs_custom_url'].'"  style="background:'.$pluginOptionsVal['csbwfs_custom_bg'].';" target="'.$pluginOptionsVal['csbwfs_custom_target'].'" title="'.$pluginOptionsVal['csbwfs_custom_title'].'"> <div class="title" style="float:'.$pluginOptionsVal['csbwfs_position'].'">'.$pluginOptionsVal['csbwfs_custom_title'].'</div> <img src="'.$pluginOptionsVal['csbwfs_custom_image'].'" alt="'.$pluginOptionsVal['csbwfs_custom_title'].'"  width="30" height="30"></a></div></div>';
endif;
/** Button-2*/
if($pluginOptionsVal['csbwfs_c2publishBtn']!=''):
$csbwfsCustomBtn2 .='<div class="csbwfs-sbutton custom2 extraImgBtns" id="csbwfs-sbutton2"><div id="csbwfs-c2"><a href="'.$pluginOptionsVal['csbwfs_custom2_url'].'"  style="background:'.$pluginOptionsVal['csbwfs_custom2_bg'].';" target="'.$pluginOptionsVal['csbwfs_custom2_target'].'" title="'.$pluginOptionsVal['csbwfs_custom2_title'].'"> <div class="title" style="float:'.$pluginOptionsVal['csbwfs_position'].'">'.$pluginOptionsVal['csbwfs_custom2_title'].'</div> <img width="30" height="30" src="'.$pluginOptionsVal['csbwfs_custom2_image'].'" alt="'.$pluginOptionsVal['csbwfs_custom2_title'].'"></a></div></div>';
endif;
/** Button-3*/
if($pluginOptionsVal['csbwfs_c3publishBtn']!=''):
if($pluginOptionsVal['csbwfs_custom3_defltwidth']){$wth3=$pluginOptionsVal['csbwfs_custom3_defltwidth'];}else {$wth3='';}

if($pluginOptionsVal['csbwfs_custom3_txt_color']){$clr3='color:'.$pluginOptionsVal['csbwfs_custom3_txt_color'].';';}else {$clr3='color:#ffffff;';}

if($pluginOptionsVal['csbwfs_custom3_hght']){$hght3='height:'.$pluginOptionsVal['csbwfs_custom3_hght'].'px;';}else {$hght3='';}

$csbwfsCustomBtn3 .='<div class="csbwfs-sbutton custom3 extraTxtBtns" id="csbwfs-sbutton3" style="'.$hght3.'"><div id="csbwfs-c3"><a href="'.$pluginOptionsVal['csbwfs_custom3_url'].'"  style="background:'.$pluginOptionsVal['csbwfs_custom3_bg'].';'.$clr3.'width:'.$wth3.'px;'.$hght3.'" target="'.$pluginOptionsVal['csbwfs_custom3_target'].'" title="'.$pluginOptionsVal['csbwfs_custom3_title'].'"><div class="customtitle" style="float:'.$pluginOptionsVal['csbwfs_position'].'">'.$pluginOptionsVal['csbwfs_custom3_title'].'</div></a></div></div>';
endif;
/** Button-4 */
if($pluginOptionsVal['csbwfs_c4publishBtn']!=''):
if($pluginOptionsVal['csbwfs_custom4_defltwidth']){$wth4=$pluginOptionsVal['csbwfs_custom4_defltwidth'];}else {$wth4='#ffffff;';}
if($pluginOptionsVal['csbwfs_custom4_txt_color']){$clr4='color:'.$pluginOptionsVal['csbwfs_custom4_txt_color'].';';}else {$clr4='color:#ffffff;';}
if($pluginOptionsVal['csbwfs_custom3_hght']){$hght4='height:'.$pluginOptionsVal['csbwfs_custom4_hght'].'px;';}else {$hght4='';}
$csbwfsCustomBtn4 .='<div class="csbwfs-sbutton custom4 extraTxtBtns" id="csbwfs-sbutton4" style="'.$hght4.'"><div id="csbwfs-c4"><a href="'.$pluginOptionsVal['csbwfs_custom4_url'].'"  style="background:'.$pluginOptionsVal['csbwfs_custom4_bg'].';'.$clr4.'width:'.$wth4.'px;'.$hght4.'" target="'.$pluginOptionsVal['csbwfs_custom4_target'].'" title="'.$pluginOptionsVal['csbwfs_custom4_title'].'"> <div class="customtitle" style="float:'.$pluginOptionsVal['csbwfs_position'].'">'.$pluginOptionsVal['csbwfs_custom4_title'].'</div></a></div></div>';
endif;

if(isset($pluginOptionsVal['csbwfs_pro_buttons_active']) && $pluginOptionsVal['csbwfs_pro_buttons_active']!=1){
/** Include sharecount*/
require dirname(__FILE__).'/lib/csbwfs-share-count.php';
}
/** Check display Show/Hide button or not*/
if(isset($pluginOptionsVal['csbwfs_rmSHBtn']) && $pluginOptionsVal['csbwfs_rmSHBtn']!=''):
$isActiveHideShowBtn='yes';
else:
$isActiveHideShowBtn='no';
endif;
$floatingSidebarContent='<div id="csbwfs-delaydiv" ><div class="csbwfs-social-widget" '.$idName.' title="'.$sharemsg.'" '.$style.'><div class="csbwfs-responive-div csbwfs-count-'.CSBWFS_YES_CNT.'">';

if($isActiveHideShowBtn!='yes') :
$floatingSidebarContent .= '<div class="csbwfs-show"><a href="javascript:" title="'.$showbtn.'" id="csbwfs-show"><img src="'.$showImg.'" alt="'.$showbtn.'" width="30" height="80"></a></div>';
endif;


$floatingSidebarContent .= '<div id="csbwfs-social-inner">';
if($bottomPosition=='bottom'):
/** Total Sum of Share */
/*
if(isset($pluginOptionsVal['csbwfs_count_sum']) && $pluginOptionsVal['csbwfs_count_sum']!=''):
$floatingSidebarContent .='<div class="csbwfs-sbutton" id="countsum"><div id="csbwfs-sum"><a href="javascript:"><div class="countsec">'.CSBWFS_TOTAL_CNT.'</div>'.$pluginOptionsVal['csbwfs_count_sum'].'</a></div></div>';
endif;*/
else:
/** Total Sum of Share */
if(isset($pluginOptionsVal['csbwfs_count_sum']) && $pluginOptionsVal['csbwfs_count_sum']!=''):
$floatingSidebarContent .='<div id="csbwfs-cntsum"><div class="csbwfs-count-bubble xxx"><div class="iQa IY">'.CSBWFS_TOTAL_CNT.'</div></div>';
$floatingSidebarContent .='<div id="csbwfs-sum"><button id="csbwfs-cntsum-txt">'.$pluginOptionsVal['csbwfs_count_sum'].'</button></div></div>';
endif;
endif;

$btnsordaryy=get_option('csbwfs_btns_order');
asort($btnsordaryy);
foreach($btnsordaryy as $csbwfskey=>$csbwfskeyval)
{
/* Custom 1 */
if($csbwfskey=='cs1'){
if($csbwfsCustomBtn1!='')
$floatingSidebarContent .=$csbwfsCustomBtn1;
}
/* Custom 2 */
if($csbwfskey=='cs2'){
if($csbwfsCustomBtn2!='')
$floatingSidebarContent .=$csbwfsCustomBtn2;
}
/* Custom 3 */
if($csbwfskey=='cs3'){
if($csbwfsCustomBtn3!='')
$floatingSidebarContent .=$csbwfsCustomBtn3;
}
/* Custom 4 */
if($csbwfskey=='cs4'){
if($csbwfsCustomBtn4!='')
$floatingSidebarContent .=$csbwfsCustomBtn4;
}
/** FB */
if($csbwfskey=='fa'){
if($pluginOptionsVal['csbwfs_fpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_fb_page_url']) && $pluginOptionsVal['csbwfs_fb_page_url']!=''):
$fbshareurl=$pluginOptionsVal['csbwfs_fb_page_url'];
else:
$fbshareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton '.CSBWFS_FB_DIV.'"><div id="csbwfs-fb"><a href="javascript:" onclick="window.open(\'//www.facebook.com/sharer/sharer.php?u='.$fbshareurl.'\',\'Facebook\',\'width=800,height=300\')" title="'.$csbwfs_fb_title.'" '.$fImgbg.' class="csbwfssharecount"><div class="countsec">'.CSBWFS_FB_CNT.'</div></a></div></div>';
endif;
}
/** TW */
if($csbwfskey=='tw'){
if($pluginOptionsVal['csbwfs_tpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_tw_page_url']) && $pluginOptionsVal['csbwfs_tw_page_url']!=''):
$twshareurl=$pluginOptionsVal['csbwfs_tw_page_url'];
else:
$twshareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton"><div id="csbwfs-tw"><a href="javascript:" onclick="window.open(\'//twitter.com/share?url='.$twshareurl.'&text='.$ShareTitle.' - '.$ShareOgDesc.'\',\'_blank\',\'width=800,height=300\')" title="'.$csbwfs_tw_title.'" '.$tImgbg.' class="csbwfssharecount"><div class="countsec"></div></a></div></div>';
endif;
}
/** GP */
if($csbwfskey=='gp'){
if($pluginOptionsVal['csbwfs_gpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_gp_page_url']) && $pluginOptionsVal['csbwfs_gp_page_url']!=''):
$gpshareurl=$pluginOptionsVal['csbwfs_gp_page_url'];
else:
$gpshareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton '.CSBWFS_GP_DIV.'"><div id="csbwfs-gp"><a href="javascript:"  onclick="javascript:window.open(\'//plus.google.com/share?url='.$gpshareurl.'\',\'\',\'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=800\');return false;" title="'.$csbwfs_gp_title.'"  '.$gImgbg.' class="csbwfssharecount"><div class="countsec">'.CSBWFS_GP_CNT.'</div></a></div></div>';
endif;
}
/**  LI */
if($csbwfskey=='li'){
if($pluginOptionsVal['csbwfs_lpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_li_page_url']) && $pluginOptionsVal['csbwfs_li_page_url']!=''):
$lishareurl=$pluginOptionsVal['csbwfs_li_page_url'];
else:
$lishareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton '.CSBWFS_LI_DIV.'"><div id="csbwfs-li"><a href="javascript:" onclick="javascript:window.open(\'//www.linkedin.com/shareArticle?mini=true&url='. $lishareurl.'&title='.$ShareTitle.'&summary='.$ShareOgDesc.'\',\'\',\'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=800\');return false;" title="'.$csbwfs_li_title.'" '.$lImgbg.' class="csbwfssharecount"><div class="countsec">'.CSBWFS_LI_CNT.'</div></a></div></div>';
endif;
}
/** PIN */
if($csbwfskey=='pi'){
if($pluginOptionsVal['csbwfs_ppublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_pin_page_url']) && $pluginOptionsVal['csbwfs_pin_page_url']!=''):
$floatingSidebarContent .='<div class="csbwfs-sbutton '.CSBWFS_PI_DIV.'"><div id="csbwfs-pin"><a href="'.$pluginOptionsVal['csbwfs_pin_page_url'].'" target="_blank" '.$pImgbg.' title="'.$csbwfs_pin_title.'" class="csbwfssharecount"><div class="countsec">'.CSBWFS_PI_CNT.'</div></a></div></div>';
else:
$floatingSidebarContent .='<div class="csbwfs-sbutton '.CSBWFS_PI_DIV.'"><div id="csbwfs-pin"><a onclick="javascript:void((function(){var e=document.createElement(\'script\');e.setAttribute(\'type\',\'text/javascript\');e.setAttribute(\'charset\',\'UTF-8\');e.setAttribute(\'src\',\'//assets.pinterest.com/js/pinmarklet.js?r=\'+Math.random()*99999999);document.body.appendChild(e)})());" href="javascript:" '.$pImgbg.' title="'.$csbwfs_pin_title.'" class="csbwfssharecount"><div class="countsec">'.CSBWFS_PI_CNT.'</div></a></div></div>';
endif;
endif;
}
/** Stumbleupon */
if($csbwfskey=='st'){
if(isset($pluginOptionsVal['csbwfs_stpublishBtn']) && $pluginOptionsVal['csbwfs_stpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_st_page_url']) && $pluginOptionsVal['csbwfs_st_page_url']!=''):
$stshareurl=$pluginOptionsVal['csbwfs_st_page_url'];
else:
$stshareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton '.CSBWFS_ST_DIV.'"><div id="csbwfs-st"><a onclick="window.open(\'//www.stumbleupon.com/submit?url='.$stshareurl.'&amp;title='.$ShareTitle.'\',\'Stumbleupon\',\'toolbar=0,status=0,width=1000,height=800\');"  href="javascript:void(0);" '.$stImgbg.' title="'.$csbwfs_st_title.'" class="csbwfssharecount"><div class="countsec">'.CSBWFS_ST_CNT.'</div></a></div></div>';
endif;
}
/** Reddit */
if($csbwfskey=='re'){
if(isset($pluginOptionsVal['csbwfs_republishBtn']) && $pluginOptionsVal['csbwfs_republishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_re_page_url']) && $pluginOptionsVal['csbwfs_re_page_url']!=''):
$reshareurl=$pluginOptionsVal['csbwfs_re_page_url'];
else:
$reshareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton '.CSBWFS_RE_DIV.'"><div id="csbwfs-re"><a onclick="window.open(\'//reddit.com/submit?url='.$reshareurl.'&amp;title='.$ShareTitle.'\',\'Reddit\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);" '.$reImgbg.' title="'.$csbwfs_re_title.'" class="csbwfssharecount"><div class="countsec">'.CSBWFS_RE_CNT.'</div></a></div></div>';
endif;
}
/** Diggit */
if($csbwfskey=='di'){
if(isset($pluginOptionsVal['csbwfs_diggpublishBtn']) && $pluginOptionsVal['csbwfs_diggpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_digg_page_url']) && $pluginOptionsVal['csbwfs_digg_page_url']!=''):
$dishareurl=$pluginOptionsVal['csbwfs_digg_page_url'];
else:
$dishareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton"><div id="csbwfs-digg"><a onclick="window.open(\'//digg.com/submit?url='.$dishareurl.'\',\'Diggit\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);" '.$diggImgbg.' title="'.$csbwfs_digg_title.'"><img src="'.$diggImg.'" alt="'.$csbwfs_digg_title.'" width="30" height="30"></a></div></div>';
endif;
}
/** Yummly */
if($csbwfskey=='yu'){
if(isset($pluginOptionsVal['csbwfs_yumpublishBtn']) && $pluginOptionsVal['csbwfs_yumpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_yum_page_url']) && $pluginOptionsVal['csbwfs_yum_page_url']!=''):
$yushareurl=$pluginOptionsVal['csbwfs_yum_page_url'];
else:
$yushareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton"><div id="csbwfs-yum"><a onclick="window.open(\'//www.yummly.com/urb/verify?url='.$yushareurl.'&amp;title='.$ShareTitle.'\',\'Yummly\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);" '.$yumImgbg.' title="'.$csbwfs_yum_title.'"><img src="'.$yumImg.'" alt="'.$csbwfs_yum_title.'" width="30" height="30"></a></div></div>';
endif;
}
/** VK */
if($csbwfskey=='vk'){
if(isset($pluginOptionsVal['csbwfs_vkpublishBtn']) && $pluginOptionsVal['csbwfs_vkpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_vk_page_url']) && $pluginOptionsVal['csbwfs_vk_page_url']!=''):
$vkshareurl=$pluginOptionsVal['csbwfs_vk_page_url'];
else:
$vkshareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton"><div id="csbwfs-vk"><a onclick="window.open(\'//vk.com/share.php?url='.$vkshareurl.'&amp;title='.$ShareTitle.'\',\'Vk\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);" '.$vkImgbg.' title="'.$csbwfs_vk_title.'"><img src="'.$vkImg.'" alt="'.$csbwfs_vk_title.'" width="30" height="30"></a></div></div>';
endif;
}
/** Buffer */
if($csbwfskey=='bu'){
if(isset($pluginOptionsVal['csbwfs_bufpublishBtn']) && $pluginOptionsVal['csbwfs_bufpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_buf_page_url']) && $pluginOptionsVal['csbwfs_buf_page_url']!=''):
$bushareurl=$pluginOptionsVal['csbwfs_buf_page_url'];
else:
$bushareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton"><div id="csbwfs-buf"><a onclick="window.open(\'//bufferapp.com/add?url='.$bushareurl.'&amp;title='.$ShareTitle.'\',\'Buffer\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);" '.$bufImgbg.' title="'.$csbwfs_buf_title.'"><img src="'.$bufImg.'" alt="'.$csbwfs_buf_title.'" width="30" height="30"></a></div></div>';
endif;
}
/** WhatsApp */
if($csbwfskey=='wh'){
if(isMobilePro()):
if(isset($pluginOptionsVal['csbwfs_whatsapppublishBtn']) && $pluginOptionsVal['csbwfs_whatsapppublishBtn']!=''):
$floatingSidebarContent .='<div class="csbwfs-sbutton whatsapp"><div id="csbwfs-whats"><a href="whatsapp://send?text='.$ShareTitle.'&nbsp;'.$ShareDesc.'&nbsp;'.$shareurl.'"  title="Share on WhatsApp" > <img src="'.plugins_url('images/whatsapp.png',__FILE__).'" alt="Share With Whatsapp" width="30" height="30"></a></div></div>';
endif;
endif;
}
/** RSS Feed */
if($csbwfskey=='rss'){
if(isset($pluginOptionsVal['csbwfs_rsspublishBtn']) && $pluginOptionsVal['csbwfs_rsspublishBtn']!=''):
$floatingSidebarContent .='<div class="csbwfs-sbutton rss"><div id="csbwfs-rss"><a onclick="window.open(\''.$pluginOptionsVal['csbwfs_rssPath'].'\');" href="javascript:void(0);"  title="Browse RSS Feed" > <img src="'.plugins_url('images/rss.png',__FILE__).'" alt="Browse RSS Feed" width="30" height="30"></a></div></div>';
endif;
}
/** Line */
if($csbwfskey=='line'){
if(isMobilePro()):
if(isset($pluginOptionsVal['csbwfs_linepublishBtn']) && $pluginOptionsVal['csbwfs_linepublishBtn']!=''):
$floatingSidebarContent .='<div class="csbwfs-sbutton line"><div id="csbwfs-line"><a href="//line.me/R/msg/text/?'.$ShareTitle.'%0D%0A'.$shareurl.'"  title="LINE it!" > <img src="'.plugins_url('images/line.png',__FILE__).'" alt="LINE it!" width="30" height="30"></a></div></div>';
endif;
endif;
}
/** YT */	
if($csbwfskey=='yt'){ 	 
if(isset($pluginOptionsVal['csbwfs_ytpublishBtn']) && $pluginOptionsVal['csbwfs_ytpublishBtn']!=''):
$floatingSidebarContent .='<div class="csbwfs-sbutton yt"><div id="csbwfs-yt"><a onclick="window.open(\''.$pluginOptionsVal['csbwfs_ytPath'].'\');" href="javascript:void(0);" '.$ytImgbg.' title="'.$csbwfs_yt_title.'" class="csbwfssharecount"><div class="countsec"></div></a></div></div>';
endif;
}
/** G-Mail */	
if($csbwfskey=='gm'){ 	 
if(isset($pluginOptionsVal['csbwfs_gmtpublishBtn']) && $pluginOptionsVal['csbwfs_gmtpublishBtn']!=''):
$floatingSidebarContent .='<div class="csbwfs-sbutton gm"><div id="csbwfs-gm"><a onclick="window.open(\''.$pluginOptionsVal['csbwfs_ytPath'].'\');" href="javascript:void(0);" '.$gmImgbg.' title="'.$csbwfs_gmail_title.'"><img src="'.plugins_url('images/gmail.png',__FILE__).'" alt="'.$csbwfs_gmail_title.'" width="30" height="30"></a></div></div>';
endif;
}
/** Instagram */
if($csbwfskey=='in'){
if(isset($pluginOptionsVal['csbwfs_instpublishBtn']) && $pluginOptionsVal['csbwfs_instpublishBtn']!=''):
$floatingSidebarContent .='<div class="csbwfs-sbutton inst"><div id="csbwfs-inst"><a onclick="window.open(\''.$pluginOptionsVal['csbwfs_inst_page_url'].'\');" href="javascript:void(0);" '.$instImgbg.' title="'.$csbwfs_inst_title.'"><img src="'.$instImg.'" alt="'.$csbwfs_inst_title.'" width="30" height="30"></a></div></div>';
endif;
} 
/** Google Translate */
if($csbwfskey=='gt'){
if($pluginOptionsVal['csbwfs_gtpublishBtn']!=''):
$floatingSidebarContent .='<div class="csbwfs-sbutton gt" id="csbwfs-sbutton"><div id="csbwfs-gt"><a href="//translate.google.com/translate?u='.$shareurl.'"  '.$gtImgbg.' target="_blank" title="'.$csbwfs_gt_title.'"> <img src="'.$gtImg.'" alt="'.$csbwfs_gt_title.'" width="30" height="30"></a></div></div>';
endif;
}
/** Mail*/
if($csbwfskey=='ma'){
if($pluginOptionsVal['csbwfs_mpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_mail_page_url']) && $pluginOptionsVal['csbwfs_mail_page_url']!=''):
$floatingSidebarContent .='<div class="csbwfs-sbutton mail"><div id="csbwfs-ml"><a href="'.$pluginOptionsVal['csbwfs_mail_page_url'].'" title="'.$csbwfs_mail_title.'" '.$mImgbg.' class="csbwfssharecount"><div class="countsec"></div></a></div></div>';
else:
$floatingSidebarContent .='<div class="csbwfs-sbutton mail"><div id="csbwfs-ml" class="csbwfs-mail"><a href="javascript:"  '.$mImgbg.' title="'.$csbwfs_mail_title.'" class="csbwfssharecount"><div class="countsec"></div></a></div></div>';
endif;
endif;
}
/** Print */
if($csbwfskey=='pr'){
if($pluginOptionsVal['csbwfs_printpublishBtn']!=''):
$floatingSidebarContent .='<div class="csbwfs-sbutton print"><div id="csbwfs-print" class="csbwfs-print"><a href="javascript:"  '.$printImgbg.' title="'.$csbwfs_print_title.'" ><img src="'.$printImg.'" alt="'.$csbwfs_print_title.'"  width="30" height="30"></a></div></div>';
endif;
}
/** Skype */
if($csbwfskey=='sk'){
if(isset($pluginOptionsVal['csbwfs_skypublishBtn']) && $pluginOptionsVal['csbwfs_skyUnpublishBtn']!=''):
$csbwfsSkypeName=$pluginOptionsVal['csbwfs_skyUnpublishBtn'];
$floatingSidebarContent .='<div class="csbwfs-sbutton skype"><div id="csbwfs-skype"><script type="text/javascript" src="//www.skypeassets.com/i/scom/js/skype-uri.js" data-cfasync="false"></script>
<div id="SkypeButton_Call_'.$csbwfsSkypeName.'_1">
  <script type="text/javascript" data-cfasync="false">
    Skype.ui({
      "name": "chat",
      "element": "SkypeButton_Call_'.$csbwfsSkypeName.'_1",
      "participants": ["'.$csbwfsSkypeName.'"],
      "imageSize": 14
    });
  </script>
</div></div></div>';
endif;
}

/** Tumbler */
if($csbwfskey=='tu'){
if(isset($pluginOptionsVal['csbwfs_tupublishBtn']) && $pluginOptionsVal['csbwfs_tupublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_tu_page_url']) && $pluginOptionsVal['csbwfs_tu_page_url']!=''):
$tushareurl=$pluginOptionsVal['csbwfs_tu_page_url'];
else:
$tushareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton '.CSBWFS_TU_DIV.'"><div id="csbwfs-tu"><a onclick="window.open(\'//tumblr.com/widgets/share/tool?canonicalUrl='.$tushareurl.'&amp;title='.$ShareTitle.'\',\'Tumbler\',\'toolbar=0,status=0,width=540,height=600\');" href="javascript:void(0);" '.$tuImgbg.' title="'.$csbwfs_tu_title.'"><img src="'.$tuImg.'" alt="'.$csbwfs_tu_title.'" width="30" height="30">'.CSBWFS_TU_CNT.'</a></div></div>';
endif;
}
/** Blogger */
if($csbwfskey=='bl'){
if(isset($pluginOptionsVal['csbwfs_blpublishBtn']) && $pluginOptionsVal['csbwfs_blpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_bl_page_url']) && $pluginOptionsVal['csbwfs_bl_page_url']!=''):
$blshareurl=$pluginOptionsVal['csbwfs_bl_page_url'];
else:
$blshareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton"><div id="csbwfs-bl"><a onclick="window.open(\'//www.blogger.com/blog-this.g?u='.$blshareurl.'&amp;t='.$ShareTitle.'\',\'Blogger\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);" '.$blImgbg.' title="'.$csbwfs_bl_title.'"><img src="'.$blImg.'" alt="'.$csbwfs_bl_title.'" width="30" height="30"></a></div></div>';
endif;
}
/** Gmail */
if($csbwfskey=='gm'){
if(isset($pluginOptionsVal['csbwfs_gmpublishBtn']) && $pluginOptionsVal['csbwfs_gmpublishBtn']!=''):
$floatingSidebarContent .='<div class="csbwfs-sbutton"><div id="csbwfs-gm"><a onclick="window.open(\'//mail.google.com/mail/u/0/?view=cm&amp;fs=1&amp;to='.get_option('admin_email').'&amp;su=\'+encodeURIComponent(document.title)+\'&amp;body='.$shareurl.'&amp;ui=2&amp;tf=1\',\'Gmail\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);" '.$gmImgbg.' title="'.$csbwfs_gm_title.'"><img src="'.$gmImg.'" alt="'.$csbwfs_gm_title.'" width="30" height="30"></a></div></div>';
endif;
}
/** Delicious */
if($csbwfskey=='de'){
if(isset($pluginOptionsVal['csbwfs_depublishBtn']) && $pluginOptionsVal['csbwfs_depublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_de_page_url']) && $pluginOptionsVal['csbwfs_de_page_url']!=''):
$deshareurl=$pluginOptionsVal['csbwfs_de_page_url'];
else:
$deshareurl=$shareurl;
endif;
$floatingSidebarContent .='<div class="csbwfs-sbutton"><div id="csbwfs-de"><a onclick="window.open(\'//delicious.com/save?v=5&provider=MRWEBSOLUTION&noui&jump=close&url=\'+encodeURIComponent(location.href)+\'&title=\'+encodeURIComponent(document.title), \'delicious\',\'toolbar=no,width=550,height=550\'); return false;" href="javascript:void(0);" '.$deImgbg.' title="'.$csbwfs_de_title.'"><img src="'.$deImg.'" alt="'.$csbwfs_de_title.'" width="30" height="30"></a></div></div>';
endif;
}

}
$floatingSidebarContent .='</div>'; //End social-share-inner

if($isActiveHideShowBtn!='yes') :
$floatingSidebarContent .='<div class="csbwfs-hide"><a href="javascript:" title="'.$hidebtn.'" id="csbwfs-hide"><img src="'.plugins_url('images/'.$hideImg,__FILE__).'" alt="'.$hidebtn.'" width="20" height="20"></a></div>';
endif;

$floatingSidebarContent .='</div>'; //End social-inner
if($pluginOptionsVal['csbwfs_mpublishBtn']!=''):
$floatingSidebarContent .='<div id="maillightbox"></div>';
$floatingSidebarContent .='<div id="csbwfsBox" style="display:none">';
if(isset($pluginOptionsVal['csbwfs_mail_form_shortcode']) && $pluginOptionsVal['csbwfs_mail_form_shortcode']==''):
$operationAry=array('+','x','+','x');
$random_action=array_rand($operationAry,2);
$random_actionVal=$operationAry[$random_action[0]];
$actnVal1=rand(1,9);
$actnVal2=rand(1,9);

$formtitle='Contact us';
$formtitleval=get_option('csbwfs_form_heading');
if($formtitleval!=''){ $formtitle=$formtitleval;}
$formsubheading='';
$formsubheadingval=get_option('csbwfs_form_subheading');
if($formsubheadingval!=''){ $formsubheading='<div class="subheading">'.$formsubheadingval.'</div>';}

$floatingSidebarContent .='<div id="csbwfs_contact"><script>jQuery("#csbwfs_lightbox .csbwfs-close span").click(function() {	    jQuery("#maillightbox").html("");
		jQuery("#csbwfs_lightbox").hide().fadeOut(1000);});</script>
       <div class="heading">'.$formtitle.'</div>'.$formsubheading.' 
      <div class="csbwfsmsg"></div>
      <form action="'.home_url('/').'" method="post" id="csbwfs_form">'.wp_nonce_field('csbwfs_contact_form', 'csbwfs_contact_nonce', true, false).'
        <div class="fields"><label>Name<span class="req">*</span>: </label><input name="csbwfs_name" id="csbwfs_name" type="text"  class="csbwfs-req-fields" /></div>
       <div class="fields"><label>Email<span class="req">*</span>: </label><input name="csbwfs_email" id="csbwfs_email" type="text" class="csbwfs-req-fields csbwfs-req-email"/></div>
        <div class="fields"><label>Message: </label><textarea name="csbwfs_message" id="csbwfs_message" rows="3" cols="46"></textarea></div>
        <div class="csbwfsCptcha"><label>Captcha<span class="req">*</span>: </label> &nbsp;&nbsp;<div id="firstAct">'.$actnVal1.'</div> <div id="Acttion">'.$random_actionVal.'</div> <div id="secondAct">'.$actnVal2.'</div> <div>=</div><div class="input"><input type="text" name="csbwfs_code" id="csbwfs_code"  size="10" class="csbwfs-req-fields csbwfs-req-cptcha"/></div><div id="cptchaErr"></div></div>
        <div class="fields"><strong>Request URL: </strong> '.$shareurl.'</div>
        <div class="fields"><input name="cswbfs_submit_btn" type="submit" value="Submit" class="cswbfs_submit_btn" id="cswbfs_submit_btn"/><input name="cswbfs_submit_form" type="hidden" value="submit-csbwfs-form" /><input name="cswbfs_hdn_cptha" type="hidden" value="" /><input name="cswbfs_hdn_cpthaval1" id="cswbfs_hdn_cpthaval1" type="hidden" value="'.$actnVal1.'" /><input name="cswbfs_hdn_cpthaval2" id="cswbfs_hdn_cpthaval2" type="hidden" value="'.$actnVal2.'" /><input name="cswbfs_hdn_cpthaaction" id="cswbfs_hdn_cpthaaction" type="hidden" value="'.$random_actionVal.'" /><input type="hidden" name="csbwfs_request_url" value="'.$shareurl.'"></div>
        <div class="fields">Please refill all with <span class="req">*</span> marked fields. Thank You!</div></form></div>'; 
        //End social-inner
else:
$js='<script type="text/javascript">
if(jQuery("#csbwfs_contact .wpcf7 form").hasClass("invalid")){
	csbwfs_form_lightbox();
	}
	
	
function csbwfs_form_lightbox(){
	var content =jQuery("#csbwfs_contact").html();
			var csbwfs_lightbox_content = 
			"<div id=\"csbwfs_lightbox\">" +
				"<div id=\"csbwfs_content\">" +
				"<div class=\"close\"><span >Click to close</span></div>"  + content  +
				"</div>" +	
			"</div>";
			//insert lightbox HTML into page
			jQuery("#maillightbox").append(csbwfs_lightbox_content).hide().fadeIn(1000);
	}
</script>';


$floatingSidebarContent .='<div id="csbwfs_contact"><script>jQuery("#csbwfs_lightbox .close span").click(function() {	    jQuery("#maillightbox").html("");
		jQuery("#csbwfs_lightbox").hide().fadeOut(1000);});</script>
      <div class="heading">'.$formtitle.'</div>'.$formsubheading.'
      <div class="csbwfsmsg"></div>
      '.do_shortcode($pluginOptionsVal['csbwfs_mail_form_shortcode']).'</div>'.$js; //End social-inner
endif;
endif;
$floatingSidebarContent .='</div></div>';
/** Check conditions */
     // Returns the content.
    global $post;
    $csbwfsPageIds=explode(',',$pluginOptionsVal['csbwfs_custom_page_ids']);
    
   if((is_home() || is_front_page()) && $pluginOptionsVal['csbwfs_hide_home']=='yes'):
    $floatingSidebarContent='';
    endif;
    /* post */
     if(is_single() && $pluginOptionsVal['csbwfs_hide_post']=='yes'):
	 if(in_array($post->ID,$csbwfsPageIds) && $pluginOptionsVal['csbwfs_hide_on']=='show'):
     // return true;
	 else:
	 $floatingSidebarContent='';
    endif;
	
    endif;
    /* page */
     if(is_page() && $pluginOptionsVal['csbwfs_hide_page']=='yes'):
       if(in_array($post->ID,$csbwfsPageIds) && $pluginOptionsVal['csbwfs_hide_on']=='show'):
       // return true;
	   else:
	   $floatingSidebarContent='';
       endif;
    endif;
   /* product */
     if(is_singular( 'product' ) && $pluginOptionsVal['csbwfs_hide_product']=='yes'):
       if(in_array($post->ID,$csbwfsPageIds) && $pluginOptionsVal['csbwfs_hide_on']=='show'):
       // return true;
	   else:
	   $floatingSidebarContent='';
       endif;
    endif;
    /* custom post type */
    $postypeval=get_option('cswbfs_exclude_post_type');
     if($postypeval!=''):
      if(is_singular()){
      $customPostAry=explode(',',$postypeval);
      if(is_singular( $customPostAry )):
        $floatingSidebarContent='';
	   else:
	   // silent
       endif;
      }
    endif;
    
    if(is_archive() && $pluginOptionsVal['csbwfs_hide_archive']=='yes'):
     $floatingSidebarContent='';
    endif;
	if(in_array($post->ID,$csbwfsPageIds) && $pluginOptionsVal['csbwfs_hide_on']=='hide'):
     $floatingSidebarContent='';
    endif;
    
    if(is_404()):
     $floatingSidebarContent='';
    endif;
    
    print $floatingSidebarContent;
}

/** CSBWFS Contact Form */
if(isset($_POST['cswbfs_submit_form']) && isset($_POST['cswbfs_hdn_cptha']) && $_POST['cswbfs_hdn_cptha']=='')
{
if ( ! isset( $_POST['csbwfs_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['csbwfs_contact_nonce'] ) ), 'csbwfs_contact_form' ) ) {
	echo esc_html__( 'Invalid form submission.', 'csbwfs-pro' ); exit;
}

$cptha1 = isset( $_POST['cswbfs_hdn_cpthaval1'] ) ? absint( $_POST['cswbfs_hdn_cpthaval1'] ) : 0;
$cptha2 = isset( $_POST['cswbfs_hdn_cpthaval2'] ) ? absint( $_POST['cswbfs_hdn_cpthaval2'] ) : 0;
$cptha3 = isset( $_POST['cswbfs_hdn_cpthaaction'] ) ? sanitize_text_field( wp_unslash( $_POST['cswbfs_hdn_cpthaaction'] ) ) : '';
$cptha4 = isset( $_POST['csbwfs_code'] ) ? absint( $_POST['csbwfs_code'] ) : 0;
if($cptha3=='x'){ 
$finalCechking=($cptha1*$cptha2);
}else {
$finalCechking=($cptha1+$cptha2);
}

if($cptha4==$finalCechking){

$pluginOptionsVal=get_csbwf_pro_sidebar_options();

include(ABSPATH . "wp-includes/pluggable.php"); 
$cswbfsSiteEmail = get_option( 'admin_email' );
$cswbfsSiteTitle = get_option( 'blogname' );
$cswbfsSiteUrl = get_option( 'siteurl' );

$csbwfs_msg_body='';	
$csbwfs_thank_msg=$pluginOptionsVal['csbwfs_mail_thank_msg'];

$csbwfsUserMsg="Thank you!\r\nYou are very important to us, all information received will always remain confidential. We will contact you as soon as we review your message.\r\n\r\n Thanks\r\n".$cswbfsSiteTitle." Team";
$csbwfsUserSubject="Thank you for contacting us";

$csbwfs_mail_cc='';

$csbwfsMail = isset( $_POST['csbwfs_email'] ) ? sanitize_email( wp_unslash( $_POST['csbwfs_email'] ) ) : '';
$csbwfsMsg = isset( $_POST['csbwfs_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['csbwfs_message'] ) ) : '';
$csbwfsName = isset( $_POST['csbwfs_name'] ) ? sanitize_text_field( wp_unslash( $_POST['csbwfs_name'] ) ) : '';
$csbwfsReqUrl = isset( $_POST['csbwfs_request_url'] ) ? esc_url_raw( wp_unslash( $_POST['csbwfs_request_url'] ) ) : '';

if ( empty( $csbwfsMail ) || ! is_email( $csbwfsMail ) ) {
	echo esc_html__( 'Please provide a valid email address.', 'csbwfs-pro' ); exit;
}

$csbwfs_mail_to= $pluginOptionsVal['csbwfs_mail_to'];
$csbwfs_mail_from= $pluginOptionsVal['csbwfs_mail_from'];
$csbwfs_mail_subject= $pluginOptionsVal['csbwfs_mail_subject'];
$csbwfs_mail_welcome_msg= $pluginOptionsVal['csbwfs_mail_welcome_msg'];

if(isset($csbwfs_mail_to) && $csbwfs_mail_to!='')
$cswbfsSiteEmail = sanitize_email( $csbwfs_mail_to );	

if(isset($csbwfs_mail_subject) && $csbwfs_mail_subject!='')
$csbwfsSubject=strip_tags($csbwfs_mail_subject);

if(isset($csbwfs_mail_from) && $csbwfs_mail_from!='')
$cswbfsSiteEmail = sanitize_email( $csbwfs_mail_from );

if(isset($csbwfs_mail_welcome_msg) && $csbwfs_mail_welcome_msg!='')
$csbwfsUserMsg=strip_tags($csbwfs_mail_welcome_msg);

/** Admin Mail */
$csbwfs_msg_body .= "Dear Admin,\n Please find new request details given below"."\n";
$csbwfs_msg_body .= "Name: ".$csbwfsName."\r\n";
$csbwfs_msg_body .= "Email: ".$csbwfsMail."\r\n";
$csbwfs_msg_body .= "Message: ".$csbwfsMsg."\r\n";
$csbwfs_msg_body .= "Contact Request URL: ".esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) )."\r\n\r\n";

$csbwfs_msg_body .= "Thanks \r\n".$cswbfsSiteTitle."\r\n--\r\n\r\n
This e-mail was sent from a contact form on ".$cswbfsSiteTitle." (".$cswbfsSiteUrl.")\n IP Address: ".sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );

$csbwfsSubject="New Contact Request on ".$cswbfsSiteTitle." (Social Flating Sidebar)";

$csbwfsheaders = "MIME-Version: 1.0" . "\r\n";
$csbwfsheaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$safe_from_name = str_replace( array( "\r", "\n" ), '', $csbwfsName );
$safe_from_mail = sanitize_email( str_replace( array( "\r", "\n" ), '', $csbwfsMail ) );
$csbwfsheaders .= 'From: '.$safe_from_name.' <'.$safe_from_mail.'>';

if(isset($csbwfs_mail_cc) && $csbwfs_mail_cc!='')
$csbwfs_mail_cc=$csbwfs_mail_cc;
	
$csbwfsheaders .= 'Cc: '.$csbwfs_mail_cc; // note you can just use a simple email address

//send mail to admin
wp_mail( $cswbfsSiteEmail, $csbwfsSubject, $csbwfs_msg_body, $csbwfsheaders );

/** User Email */
$csbwfsUsrheaders = "MIME-Version: 1.0" . "\r\n";
$csbwfsUsrheaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$csbwfsUsrheaders.= 'From: '.$cswbfsSiteTitle.' <'.$cswbfsSiteEmail.'>';
$csbwfsUsrSubject=$csbwfsUserSubject;
$csbwfs_usrmsg_body=nl2br($csbwfsUserMsg);
//send mail to user
if(isset($pluginOptionsVal['csbwfs_mail_thank_msg']) && $csbwfs_thank_msg!=''):
$csbwfsthanksMsg=strip_tags(nl2br($csbwfs_thank_msg));
else:
$csbwfsthanksMsg='Your message has been successfully sent. We will contact you very soon!';
endif;
wp_mail( $csbwfsMail, $csbwfsUsrSubject, $csbwfs_usrmsg_body, $csbwfsUsrheaders );
if(wp_mail( $cswbfsSiteEmail, $csbwfsSubject, $csbwfs_msg_body, $csbwfsheaders ))
{
	echo $csbwfsthanksMsg; exit;
	}else{
		echo "Mail failed,Please contact to site administrator!"; exit;
		}
}
else
{
	echo "The Captcha code you entered was incorrect.Try again!!"; exit;
	}
}
/**
 * Add social share bottons to the end of every post/page.
 *
 * @uses is_home()
 * @uses is_page()
 * @uses is_single()
 */
function csbfs_pro_the_content_filter( $content ) {

global $post;
$pluginOptionsVal=get_csbwf_pro_sidebar_options();
/** Share button Title */
$csbwfs_fb_title ='Share on facebook';
if(isset($pluginOptionsVal['csbwfs_page_fb_title']) && $pluginOptionsVal['csbwfs_page_fb_title']!='')
$csbwfs_fb_title=$pluginOptionsVal['csbwfs_page_fb_title'];
$csbwfs_tw_title ='Share on twitter';
if(isset($pluginOptionsVal['csbwfs_page_tw_title']) && $pluginOptionsVal['csbwfs_page_tw_title']!='')
$csbwfs_tw_title=$pluginOptionsVal['csbwfs_page_tw_title'];
$csbwfs_li_title='Share on linkdin';
if(isset($pluginOptionsVal['csbwfs_page_li_title']) && $pluginOptionsVal['csbwfs_page_li_title']!='')
$csbwfs_li_title=$pluginOptionsVal['csbwfs_page_li_title'];
$csbwfs_pin_title='Share on pintrest';
if(isset($pluginOptionsVal['csbwfs_page_pin_title']) && $pluginOptionsVal['csbwfs_page_pin_title']!='')
$csbwfs_pin_title=$pluginOptionsVal['csbwfs_page_pin_title'];
$csbwfs_gp_title='Share on google';
if(isset($pluginOptionsVal['csbwfs_page_gp_title']) && $pluginOptionsVal['csbwfs_page_gp_title']!='')
$csbwfs_gp_title=$pluginOptionsVal['csbwfs_page_gp_title'];
$csbwfs_mail_title='Send contact request';
if(isset($pluginOptionsVal['csbwfs_page_mail_title']) && $pluginOptionsVal['csbwfs_page_mail_title']!='')
$csbwfs_mail_title=$pluginOptionsVal['csbwfs_page_mail_title'];
$csbwfs_yt_title='Share on youtube';
if(isset($pluginOptionsVal['csbwfs_page_yt_title']) && $pluginOptionsVal['csbwfs_page_yt_title']!='')
$csbwfs_yt_title=$pluginOptionsVal['csbwfs_page_yt_title'];
$csbwfs_re_title='Share on reddit';
if(isset($pluginOptionsVal['csbwfs_page_re_title']) && $pluginOptionsVal['csbwfs_page_re_title']!='')
$csbwfs_re_title=$pluginOptionsVal['csbwfs_page_re_title'];
$csbwfs_st_title='Share on stumbleupon';
if(isset($pluginOptionsVal['csbwfs_page_st_title']) && $pluginOptionsVal['csbwfs_page_st_title']!='')
$csbwfs_st_title=$pluginOptionsVal['csbwfs_page_st_title'];
$csbwfs_gt_title='Translate page';
if(isset($pluginOptionsVal['csbwfs_page_gt_title']) && $pluginOptionsVal['csbwfs_page_gt_title']!='')
$csbwfs_gt_title=$pluginOptionsVal['csbwfs_page_gt_title'];
$csbwfs_inst_title='Share on instagram';
if(isset($pluginOptionsVal['csbwfs_page_inst_title']) && $pluginOptionsVal['csbwfs_page_inst_title']!='')
$csbwfs_inst_title=$pluginOptionsVal['csbwfs_page_inst_title'];
$csbwfs_digg_title='Share on Diggit';
if(isset($pluginOptionsVal['csbwfs_page_digg_title']) && $pluginOptionsVal['csbwfs_page_digg_title']!='')
$csbwfs_digg_title=$pluginOptionsVal['csbwfs_page_digg_title'];
$csbwfs_yum_title='Share on Yummly';
if(isset($pluginOptionsVal['csbwfs_page_yum_title']) && $pluginOptionsVal['csbwfs_page_yum_title']!='')
$csbwfs_yum_title=$pluginOptionsVal['csbwfs_page_yum_title'];
$csbwfs_vk_title='Share on VK';
if(isset($pluginOptionsVal['csbwfs_page_vk_title']) && $pluginOptionsVal['csbwfs_page_vk_title']!='')
$csbwfs_vk_title=$pluginOptionsVal['csbwfs_page_vk_title'];
$csbwfs_buf_title='Share on Buffer';
if(isset($pluginOptionsVal['csbwfs_page_buf_title']) && $pluginOptionsVal['csbwfs_page_buf_title']!='')
$csbwfs_buf_title=$pluginOptionsVal['csbwfs_page_buf_title'];
$csbwfs_print_title='Print';
if(isset($pluginOptionsVal['csbwfs_page_print_title']) && $pluginOptionsVal['csbwfs_page_print_title']!='')
$csbwfs_print_title=$pluginOptionsVal['csbwfs_page_print_title'];
$csbwfs_gmail_title='New Contact Request';
if(isset($pluginOptionsVal['csbwfs_page_gm_title']) && $pluginOptionsVal['csbwfs_page_gm_title']!='')
$csbwfs_gmail_title=$pluginOptionsVal['csbwfs_page_gm_title'];

if(is_category())
	{
	   $category_id = get_query_var('cat');
	   $shareurl =get_category_link( $category_id );   
	   $cats = get_the_category();
	   $ShareTitle=$cats[0]->name;
	}elseif(is_page() || is_single())
	{
	   $shareurl=get_permalink($post->ID);
	   $ShareTitle=$post->post_title;
	}
	else
	{
        $shareurl =home_url('/');
        $ShareTitle=get_bloginfo('name');
		}
$shareurl = csbwfs_pro_get_current_page_url($_SERVER);
$ShareDesc=$ShareOgDesc='';		
$ShareDesc=$ShareOgDesc=$csbwfsOgimg='';			
if(isset($pluginOptionsVal['csbwfs_og_tags_enable']) && $pluginOptionsVal['csbwfs_og_tags_enable']=='yes'){
/* og title */
$ogtile=get_post_meta($post->ID,"csbwfs_og_title",true);
$csbwfs_dft_og_title=get_option('csbwfs_dft_og_title');
if($ogtile=='' && $csbwfs_dft_og_title!=''){$ogtile=$csbwfs_dft_og_title;}
if($ogtile!=''){$ShareTitle=$ogtile;}
/* og description */
$ShareOgDesc=get_post_meta($post->ID,"csbwfs_og_description",true);
$csbwfs_dft_og_desc=get_option('csbwfs_dft_og_desc');
if($ShareOgDesc=='' && $csbwfs_dft_og_desc!=''){$ShareOgDesc=$csbwfs_dft_og_desc;}
if($ShareOgDesc!=''){$ShareDesc=$ShareOgDesc;}
/* og image */
$ShareOgImg=get_post_meta($post->ID,"csbwfs_og_image_path",true);
$csbwfs_dft_og_img=get_option('csbwfs_dft_og_img');
if($ShareOgImg=='' && $csbwfs_dft_og_img!=''){$ShareOgImg=$csbwfs_dft_og_img;}
if($ShareOgImg!=''){$csbwfsOgimg=$ShareOgImg;}
}
$ShareTitle= htmlspecialchars(urlencode($ShareTitle));
$ShareDesc= htmlspecialchars(urlencode($ShareDesc));
/* Get All buttons Image */
//get facebook button image
if($pluginOptionsVal['csbwfs_page_fb_image']!=''){ $fImg=$pluginOptionsVal['csbwfs_page_fb_image'];} 
   else{$fImg=plugins_url('images/fb.png',__FILE__);}   
//get twitter button image  
if($pluginOptionsVal['csbwfs_page_tw_image']!=''){ $tImg=$pluginOptionsVal['csbwfs_page_tw_image'];} 
   else{$tImg=plugins_url('images/tw.png',__FILE__);}   
//get linkdin button image
if($pluginOptionsVal['csbwfs_page_li_image']!=''){ $lImg=$pluginOptionsVal['csbwfs_page_li_image'];} 
   else{$lImg=plugins_url('images/in.png',__FILE__);}   
//get mail button image  
if($pluginOptionsVal['csbwfs_page_mail_image']!=''){ $mImg=$pluginOptionsVal['csbwfs_page_mail_image'];} 
   else{$mImg=plugins_url('images/ml.png',__FILE__);}   
//get google plus button image 
if($pluginOptionsVal['csbwfs_page_gp_image']!=''){ $gImg=$pluginOptionsVal['csbwfs_page_gp_image'];} 
   else{$gImg=plugins_url('images/gp.png',__FILE__);}  
//get pinterest button image   
if($pluginOptionsVal['csbwfs_page_pin_image']!=''){ $pImg=$pluginOptionsVal['csbwfs_page_pin_image'];} 
   else{$pImg=plugins_url('images/pinit.png',__FILE__);}      
//get youtube button image   
if(isset($pluginOptionsVal['csbwfs_page_yt_image']) && $pluginOptionsVal['csbwfs_page_yt_image']!=''){ $ytImg=$pluginOptionsVal['csbwfs_page_yt_image'];} 
   else{$ytImg=plugins_url('images/yt.png',__FILE__);}   
//get Reddit button image   
if(isset($pluginOptionsVal['csbwfs_page_re_image']) && $pluginOptionsVal['csbwfs_page_re_image']!=''){ $reImg=$pluginOptionsVal['csbwfs_page_re_image'];} 
   else{$reImg=plugins_url('images/reddit.png',__FILE__);}   
//get Stumbleupon button image   
if(isset($pluginOptionsVal['csbwfs_page_st_image']) && $pluginOptionsVal['csbwfs_page_st_image']!=''){ $stImg=$pluginOptionsVal['csbwfs_page_st_image'];} 
   else{$stImg=plugins_url('images/st.png',__FILE__);}   
//get Google Translate button image   
if(isset($pluginOptionsVal['csbwfs_page_gt_image']) && $pluginOptionsVal['csbwfs_page_gt_image']!=''){ $gtImg=$pluginOptionsVal['csbwfs_page_gt_image'];} 
   else{$gtImg=plugins_url('images/GTB.png',__FILE__);}   
//get Instagram button image   
if(isset($pluginOptionsVal['csbwfs_page_inst_image']) && $pluginOptionsVal['csbwfs_page_inst_image']!=''){ $instImg=$pluginOptionsVal['csbwfs_page_inst_image'];} 
   else{$instImg=plugins_url('images/inst.png',__FILE__);} 
//get diggit button image   
if($pluginOptionsVal['csbwfs_page_digg_image']!=''){ $diggImg=$pluginOptionsVal['csbwfs_page_digg_image'];} 
   else{$diggImg=plugins_url('images/diggit.png',__FILE__);}   
//get Yummly button image   
if($pluginOptionsVal['csbwfs_page_yum_image']!=''){ $yumImg=$pluginOptionsVal['csbwfs_page_yum_image'];} 
   else{$yumImg=plugins_url('images/yum.png',__FILE__);}   
//get VK button image   
if($pluginOptionsVal['csbwfs_page_vk_image']!=''){ $vkImg=$pluginOptionsVal['csbwfs_page_vk_image'];} 
   else{$vkImg=plugins_url('images/vk.png',__FILE__);}   
//get Buffer button image   
if($pluginOptionsVal['csbwfs_page_buf_image']!=''){ $bufImg=$pluginOptionsVal['csbwfs_page_buf_image'];} 
   else{$bufImg=plugins_url('images/buf.png',__FILE__);}   
//get print button image   
if($pluginOptionsVal['csbwfs_page_print_image']!=''){ $printImg=$pluginOptionsVal['csbwfs_page_print_image'];} 
   else{$printImg=plugins_url('images/print.png',__FILE__);}
/* 
 * New buttons 
 **/
//get gmail button image   
if(isset($pluginOptionsVal['csbwfs_page_gm_image']) && $pluginOptionsVal['csbwfs_page_gm_image']!=''){ $gmImg=$pluginOptionsVal['csbwfs_page_gm_image'];} 
   else{$gmImg=plugins_url('images/gm.png',__FILE__);}              
//get delicious button image   
if(isset($pluginOptionsVal['csbwfs_page_de_image']) && $pluginOptionsVal['csbwfs_page_de_image']!=''){ $deImg=$pluginOptionsVal['csbwfs_page_de_image'];} 
   else{$deImg=plugins_url('images/de.png',__FILE__);}              
//get blogger button image   
if(isset($pluginOptionsVal['csbwfs_page_bl_image']) && $pluginOptionsVal['csbwfs_page_bl_image']!=''){ $blImg=$pluginOptionsVal['csbwfs_page_bl_image'];} 
   else{$blImg=plugins_url('images/bl.png',__FILE__);}              
//get tumbler button image   
if(isset($pluginOptionsVal['csbwfs_page_tu_image']) && $pluginOptionsVal['csbwfs_page_tu_image']!=''){ $tuImg=$pluginOptionsVal['csbwfs_page_tu_image'];} 
   else{$tuImg=plugins_url('images/tu.png',__FILE__);} 
   $csbwfs_gm_title='Share on Gmail';
if(isset($pluginOptionsVal['csbwfs_page_gm_title']) && $pluginOptionsVal['csbwfs_page_gm_title']!='')
$csbwfs_gm_title=$pluginOptionsVal['csbwfs_page_gm_title'];
$csbwfs_de_title='Share on Delicious';
if(isset($pluginOptionsVal['csbwfs_page_de_title']) && $pluginOptionsVal['csbwfs_page_de_title']!='')
$csbwfs_de_title=$pluginOptionsVal['csbwfs_page_de_title'];
$csbwfs_tu_title='Share on Tumblr';
if(isset($pluginOptionsVal['csbwfs_page_tu_title']) && $pluginOptionsVal['csbwfs_page_tu_title']!='')
$csbwfs_tu_title=$pluginOptionsVal['csbwfs_page_tu_title'];
$csbwfs_bl_title='Share on Blogger';
if(isset($pluginOptionsVal['csbwfs_page_bl_title']) && $pluginOptionsVal['csbwfs_page_bl_title']!='')
$csbwfs_bl_title=$pluginOptionsVal['csbwfs_page_bl_title'];
/* End new buttons */  
//get email message 
if(is_page() || is_single() || is_category() || is_archive()){
		if($pluginOptionsVal['csbwfs_mailMessage']!=''){ $mailMsg=$pluginOptionsVal['csbwfs_mailMessage'];} else{
		 $mailMsg='?subject='.get_the_title().'&body='.$shareurl;}
 }else
 {
	 $mailMsg='?subject='.get_bloginfo('name').'&body='.home_url('/');
	 }
if(isset($pluginOptionsVal['csbwfs_btn_position']) && $pluginOptionsVal['csbwfs_btn_position']!=''):
$btnPosition=$pluginOptionsVal['csbwfs_btn_position'];
else:
$btnPosition='left';
endif;

if(isset($pluginOptionsVal['csbwfs_btn_text']) && $pluginOptionsVal['csbwfs_btn_text']!=''):
$btnText=$pluginOptionsVal['csbwfs_btn_text'];
else:
$btnText='';
endif;

//if(isset($pluginOptionsVal['csbwfs_pro_active']) && $pluginOptionsVal['csbwfs_pro_active']!=1){
/** Include sharecount*/
require dirname(__FILE__).'/lib/csbwfs-share-count.php';
//}
$shareButtonContent='<div id="socialButtonOnPage" class="'.$btnPosition.'SocialButtonOnPage">';
if($btnText!=''):
$shareButtonContent.='<div class="csbwfs-sharethis-arrow"><span>'.$btnText.'</span></div>';
endif;
/** Total Sum of Share */
/*
if(isset($pluginOptionsVal['csbwfs_count_sum_page']) && $pluginOptionsVal['csbwfs_count_sum_page']!=''):
$shareButtonContent .='<div class="csbwfs-sbutton-post" id="countsum"><div id="csbwfs-sum"><a href="javascript:"><span>'.CSBWFS_TOTAL_CNT.'</span>'.$pluginOptionsVal['csbwfs_count_sum'].'</a></div></div>';
endif;
* /
/** check buttons order */
$btnsordaryy=get_option('csbwfs_btns_order');
asort($btnsordaryy);
foreach($btnsordaryy as $csbwfskey=>$csbwfskeyval)
{
/** FB */
if($csbwfskey=='fa'){
if($pluginOptionsVal['csbwfs_fpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_fb_page_url']) && $pluginOptionsVal['csbwfs_fb_page_url']!=''):
$fbshareurl=$pluginOptionsVal['csbwfs_fb_page_url'];
else:
$fbshareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-fb-p">';
if(CSBWFS_FB_CNT != ''):
$shareButtonContent .='<div class="csbwfs-count-post">'.CSBWFS_FB_CNT.'</div>';
endif;
$shareButtonContent .='<a href="javascript:" onclick="window.open(\'//www.facebook.com/sharer/sharer.php?u='.$fbshareurl.'\',\'_blank\',\'width=800,height=300\')" title="'.$csbwfs_fb_title.'" > <img src="'.$fImg.'" width="30" height="30"  alt="'.$csbwfs_fb_title.'"></a></div></div>';
endif;
}
/** TW */
if($csbwfskey=='tw'){
if($pluginOptionsVal['csbwfs_tpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_tw_page_url']) && $pluginOptionsVal['csbwfs_tw_page_url']!=''):
$twshareurl=$pluginOptionsVal['csbwfs_tw_page_url'];
else:
$twshareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-tw-p"><a href="javascript:" onclick="window.open(\'//twitter.com/share?url='.$twshareurl.'&text='.$ShareTitle.' - '.$ShareOgDesc.'\',\'_blank\',\'width=800,height=300\')" title="'.$csbwfs_tw_title.'"><img width="30" height="30" src="'.$tImg.'" alt="'.$csbwfs_tw_title.'"></a></div></div>';
endif;
}
/** GP */
if($csbwfskey=='gp'){
if($pluginOptionsVal['csbwfs_gpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_gp_page_url']) && $pluginOptionsVal['csbwfs_gp_page_url']!=''):
$gpshareurl =$pluginOptionsVal['csbwfs_gp_page_url'];
else:
$gpshareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-gp-p">';
if(CSBWFS_GP_CNT != ''):
$shareButtonContent .='<div class="csbwfs-count-post">'.CSBWFS_GP_CNT.'</div>';
endif;
$shareButtonContent .='<a href="javascript:"  onclick="javascript:window.open(\'//plus.google.com/share?url='.$gpshareurl.'\',\'\',\'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=800\');return false;" title="'.$csbwfs_gp_title.'"><img width="30" height="30" src="'.$gImg.'" alt="'.$csbwfs_gp_title.'" ></a></div></div>';
endif;
}
/**  LI */
if($csbwfskey=='li'){
if($pluginOptionsVal['csbwfs_lpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_li_page_url']) && $pluginOptionsVal['csbwfs_li_page_url']!=''):
$lishareurl=$pluginOptionsVal['csbwfs_li_page_url'];
else:
$lishareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-li-p">';
if(CSBWFS_LI_CNT != ''):
$shareButtonContent .='<div class="csbwfs-count-post">'.CSBWFS_LI_CNT.'</div>';
endif;
$shareButtonContent .='<a href="javascript:" onclick="javascript:window.open(\'//www.linkedin.com/shareArticle?mini=true&url='. $lishareurl.'&title='.$ShareTitle.'&summary='.$ShareOgDesc.'\',\'\',\'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=800\');return false;" title="'.$csbwfs_li_title.'"><img width="30" height="30" src="'.$lImg.'" alt="'.$csbwfs_li_title.'" ></a></div></div>';
endif;
}
/** PIN */
if($csbwfskey=='pi'){
if($pluginOptionsVal['csbwfs_ppublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_pin_page_url']) && $pluginOptionsVal['csbwfs_pin_page_url']!=''):
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-pin-p">';
if(CSBWFS_PI_CNT != ''):
$shareButtonContent .='<div class="csbwfs-count-post">'.CSBWFS_PI_CNT.'</div>';
endif;
$shareButtonContent .='<a href="'.$pluginOptionsVal['csbwfs_pin_page_url'].'" target="_blank" title="'.$csbwfs_pin_title.'"><img width="30" height="30" src="'.$pImg.'" alt="'.$csbwfs_pin_title.'" ></a></div></div>';
else:
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-pin-p"><a onclick="javascript:void((function(){var e=document.createElement(\'script\');e.setAttribute(\'type\',\'text/javascript\');e.setAttribute(\'charset\',\'UTF-8\');e.setAttribute(\'src\',\'//assets.pinterest.com/js/pinmarklet.js?r=\'+Math.random()*99999999);document.body.appendChild(e)})());" href="javascript:" title="'.$csbwfs_pin_title.'"><img width="30" height="30" src="'.$pImg.'" alt="'.$csbwfs_pin_title.'"></a></div></div>';
endif;
endif;
}
/** Stumbleupon */
if($csbwfskey=='st'){
if(isset($pluginOptionsVal['csbwfs_stpublishBtn']) && $pluginOptionsVal['csbwfs_stpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_st_page_url']) && $pluginOptionsVal['csbwfs_st_page_url']!=''):
$stshareurl=$pluginOptionsVal['csbwfs_st_page_url'];
else:
$stshareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-st-p">';
if(CSBWFS_ST_CNT != ''):
$shareButtonContent .='<div class="csbwfs-count-post">'.CSBWFS_ST_CNT.'</div>';
endif;
$shareButtonContent .='<a onclick="window.open(\'//www.stumbleupon.com/submit?url='.$stshareurl.'&amp;title='.$ShareTitle.'\',\'Stumbleupon\',\'toolbar=0,status=0,width=1000,height=800\');"  href="javascript:void(0);" title="'.$csbwfs_st_title.'"><img width="30" height="30" src="'. $stImg.'" alt="'.$csbwfs_st_title.'" ></a></div></div>';
endif;
} 
/** Reddit */
if($csbwfskey=='re'){
if(isset($pluginOptionsVal['csbwfs_republishBtn']) && $pluginOptionsVal['csbwfs_republishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_re_page_url']) && $pluginOptionsVal['csbwfs_re_page_url']!=''):
$reshareurl=$pluginOptionsVal['csbwfs_re_page_url'];
else:
$reshareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-re-p">';
if(CSBWFS_RE_CNT != ''):
$shareButtonContent .='<div class="csbwfs-count-post">'.CSBWFS_RE_CNT.'</div>';
endif;
$shareButtonContent .='<a onclick="window.open(\'//reddit.com/submit?url='.$reshareurl.'&amp;title='.$ShareTitle.'\',\'Reddit\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);" title="'.$csbwfs_re_title.'"><img width="30" height="30" src="'.$reImg.'" alt="'.$csbwfs_re_title.'"></a></div></div>';
endif;
}
/** Diggit */
if($csbwfskey=='di'){
if(isset($pluginOptionsVal['csbwfs_diggpublishBtn']) && $pluginOptionsVal['csbwfs_diggpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_digg_page_url']) && $pluginOptionsVal['csbwfs_digg_page_url']!=''):
$digshareurl=$pluginOptionsVal['csbwfs_digg_page_url'];
else:
$digshareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-digg-p"><a onclick="window.open(\'//www.digg.com/submit?url='.$digshareurl.'\',\'Diggit\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);" title="'.$csbwfs_digg_title.'"><img width="30" height="30" src="'.$diggImg.'" alt="'.$csbwfs_digg_title.'"></a></div></div>';
endif;
}
/** Yummly */
if($csbwfskey=='yu'){
if(isset($pluginOptionsVal['csbwfs_yumpublishBtn']) && $pluginOptionsVal['csbwfs_yumpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_yum_page_url']) && $pluginOptionsVal['csbwfs_yum_page_url']!=''):
$yushareurl=$pluginOptionsVal['csbwfs_yum_page_url'];
else:
$yushareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-yum-p"><a onclick="window.open(\'//www.yummly.com/urb/verify?url='.$yushareurl.'&amp;title='.$ShareTitle.'\',\'Yummly\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);" title="'.$csbwfs_yum_title.'"><img width="30" height="30" src="'.$yumImg.'" alt="'.$csbwfs_yum_title.'"></a></div></div>';
endif;
}
/** VK */
if($csbwfskey=='vk'){
if(isset($pluginOptionsVal['csbwfs_vkpublishBtn']) && $pluginOptionsVal['csbwfs_vkpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_vk_page_url']) && $pluginOptionsVal['csbwfs_vk_page_url']!=''):
$vkshareurl=$pluginOptionsVal['csbwfs_vk_page_url'];
else:
$vkshareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-vk-p"><a onclick="window.open(\'//vk.com/share.php?url='.$vkshareurl.'&amp;title='.$ShareTitle.'\',\'Vk\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);" title="'.$csbwfs_vk_title.'"><img width="30" height="30" src="'.$vkImg.'" alt="'.$csbwfs_vk_title.'"></a></div></div>';
endif;
}
/** Buffer */
if($csbwfskey=='bu'){
if(isset($pluginOptionsVal['csbwfs_bufpublishBtn']) && $pluginOptionsVal['csbwfs_bufpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_buf_page_url']) && $pluginOptionsVal['csbwfs_buf_page_url']!=''):
$bufshareurl=$pluginOptionsVal['csbwfs_buf_page_url'];
else:
$bufshareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-buf-p"><a onclick="window.open(\'//bufferapp.com/add?url='.$bufshareurl.'&amp;title='.$ShareTitle.'\',\'Buffer\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);"  title="'.$csbwfs_buf_title.'"><img width="30" height="30" src="'.$bufImg.'" alt="'.$csbwfs_buf_title.'"></a></div></div>';
endif;
}
/** WhatsApp */
if($csbwfskey=='wh'){
if(isMobilePro()):
if(isset($pluginOptionsVal['csbwfs_whatsapppublishBtn']) && $pluginOptionsVal['csbwfs_whatsapppublishBtn']!=''):
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-whats"><a href="whatsapp://send?text='.$ShareTitle.'&nbsp;'.$ShareDesc.'&nbsp;'.$shareurl.'"  target="_blank" title="Share on WhatsApp"> <img src="'.plugins_url('images/whatsapp.png',__FILE__).'" alt="Share With Whatsapp" width="30" height="30"></a></div></div>';
endif;
endif;
}
/** Line */
if($csbwfskey=='line'){
if(isMobilePro()):
if(isset($pluginOptionsVal['csbwfs_linepublishBtn']) && $pluginOptionsVal['csbwfs_linepublishBtn']!=''):
$shareButtonContent .='<div class="csbwfs-sbutton-post line"><div id="csbwfs-line-p"><a href="//line.me/R/msg/text/?'.$ShareTitle.'%0D%0A'.$shareurl.'"  title="LINE it!" > <img src="'.plugins_url('images/line.png',__FILE__).'" alt="LINE it!" width="30" height="30"></a></div></div>';
endif;
endif;
}
/** YT */	
if($csbwfskey=='yt'){ 	 
if(isset($pluginOptionsVal['csbwfs_ytpublishBtn']) && $pluginOptionsVal['csbwfs_ytpublishBtn']!=''):
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-yt-p"><a onclick="window.open(\''.$pluginOptionsVal['csbwfs_ytPath'].'\');" href="javascript:void(0);" title="'.$csbwfs_yt_title.'"><img src="'.$ytImg.'" alt="'.$csbwfs_yt_title.'" width="30" height="30"></a></div></div>';
endif;
}
/** Instagram */
if($csbwfskey=='in'){
if(isset($pluginOptionsVal['csbwfs_instpublishBtn']) && $pluginOptionsVal['csbwfs_instpublishBtn']!=''):
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-inst-p"><a onclick="window.open(\''.$pluginOptionsVal['csbwfs_inst_page_url'].'\');" href="javascript:void(0);" title="'.$csbwfs_inst_title.'"><img src="'.$instImg.'" alt="'.$csbwfs_inst_title.'"  width="30" height="30"></a></div></div>';
endif; 
}
/** Google Translate */
if($csbwfskey=='gt'){
if($pluginOptionsVal['csbwfs_gtpublishBtn']!=''):
$shareButtonContent .='<div class="csbwfs-sbutton-post" ><div id="csbwfs-gt-p"><a href="//translate.google.com/translate?u='.$shareurl.'" target="_blank" title="'.$csbwfs_gt_title.'"> <img src="'.$gtImg.'" alt="'.$csbwfs_gt_title.'"  width="30" height="30"></a></div></div>';
endif;
}
/** Mail*/
if($csbwfskey=='ma'){
if($pluginOptionsVal['csbwfs_mpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_mail_page_url']) && $pluginOptionsVal['csbwfs_mail_page_url']!=''):
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-ml-p"><a href="'.$pluginOptionsVal['csbwfs_mail_page_url'].'" title="'.$csbwfs_mail_title.'"><img src="'.$mImg.'" alt="'.$csbwfs_mail_title.'"   width="30" height="30"></a></div></div>';
else:
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-ml-p" class="csbwfs-mail"><a href="javascript:" title="'.$csbwfs_mail_title.'"><img  width="30" height="30" src="'.$mImg.'" alt="'.$csbwfs_mail_title.'" ></a></div></div>';
endif;
endif;
}
/** RSS Feed */	 
if($csbwfskey=='rs'){	 
if(isset($pluginOptionsVal['csbwfs_rsspublishBtn']) && $pluginOptionsVal['csbwfs_rsspublishBtn']!=''):
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-rss-p"><a onclick="window.open(\''.$pluginOptionsVal['csbwfs_rssPath'].'\');" href="javascript:void(0);" title="Browse RSS Feed"><img src="'.plugins_url('images/rss-p.png',__FILE__).'" alt="Browse RSS Feed" width="30" height="30"></a></div></div>';
endif;
}
/** Print*/
if($csbwfskey=='pr'){	
if($pluginOptionsVal['csbwfs_printpublishBtn']!=''):
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-print-p" class="csbwfs-print"><a href="javascript:" title="'.$csbwfs_print_title.'" ><img  width="30" height="30" src="'.$printImg.'" alt="'.$csbwfs_print_title.'" ></a></div></div>';
endif;
}
/** Gmail */
if($csbwfskey=='gm'){
if(isset($pluginOptionsVal['csbwfs_gmpublishBtn']) && $pluginOptionsVal['csbwfs_gmpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_gm_page_url']) && $pluginOptionsVal['csbwfs_gm_page_url']!=''):
$gmshareurl=$pluginOptionsVal['csbwfs_gm_page_url'];
else:
$gmshareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-gm-p"><a onclick="window.open(\'//mail.google.com/mail/u/0/?view=cm&amp;fs=1&amp;to='.get_option('admin_email').'&amp;su=\'+encodeURIComponent(document.title)+\'&amp;body='.$gmshareurl.'&amp;ui=2&amp;tf=1\',\'Gmail\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);"  title="'.$csbwfs_gm_title.'"><img width="30" height="30" src="'.$gmImg.'" alt="'.$csbwfs_gm_title.'"></a></div></div>';
endif;
}
/** Blogger */
if($csbwfskey=='bl'){
if(isset($pluginOptionsVal['csbwfs_blpublishBtn']) && $pluginOptionsVal['csbwfs_blpublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_bl_page_url']) && $pluginOptionsVal['csbwfs_bl_page_url']!=''):
$blshareurl=$pluginOptionsVal['csbwfs_bl_page_url'];
else:
$blshareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-bl-p"><a onclick="window.open(\'//www.blogger.com/blog-this.g?u='.$blshareurl.'&amp;t='.$ShareTitle.'\',\'Blogger\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);"  title="'.$csbwfs_bl_title.'"><img width="30" height="30" src="'.$blImg.'" alt="'.$csbwfs_bl_title.'"></a></div></div>';
endif;
}
/** Tumbler */
if($csbwfskey=='tu'){
if(isset($pluginOptionsVal['csbwfs_tupublishBtn']) && $pluginOptionsVal['csbwfs_tupublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_tu_page_url']) && $pluginOptionsVal['csbwfs_tu_page_url']!=''):
$tushareurl=$pluginOptionsVal['csbwfs_tu_page_url'];
else:
$tushareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-tu-p">';
if(CSBWFS_TU_CNT != ''):
$shareButtonContent .='<div class="csbwfs-count-post">'.CSBWFS_TU_CNT.'</div>';
endif;
$shareButtonContent .='<a onclick="window.open(\'//tumblr.com/widgets/share/tool?canonicalUrl='.$tushareurl.'&amp;title='.$ShareTitle.'\',\'Tumbler\',\'toolbar=0,status=0,width=540,height=600\');" href="javascript:void(0);"  title="'.$csbwfs_tu_title.'"><img width="30" height="30" src="'.$tuImg.'" alt="'.$csbwfs_tu_title.'"></a></div></div>';
endif;
}
/** Declias */
if($csbwfskey=='de'){
if(isset($pluginOptionsVal['csbwfs_depublishBtn']) && $pluginOptionsVal['csbwfs_depublishBtn']!=''):
if(isset($pluginOptionsVal['csbwfs_de_page_url']) && $pluginOptionsVal['csbwfs_de_page_url']!=''):
$deshareurl=$pluginOptionsVal['csbwfs_de_page_url'];
else:
$deshareurl=$shareurl;
endif;
$shareButtonContent .='<div class="csbwfs-sbutton-post"><div id="csbwfs-de-p"><a onclick="window.open(\'//delicious.com/save?v=5&provider=MRWEBSOLUTION&noui&jump=close&url=\'+encodeURIComponent(location.href)+\'&title=\'+encodeURIComponent(document.title), \'delicious\',\'toolbar=no,width=550,height=550\'); return false;" href="javascript:void(0);"  title="'.$csbwfs_de_title.'"><img width="30" height="30" src="'.$deImg.'" alt="'.$csbwfs_de_title.'"></a></div></div>';
endif;
}

}
$shareButtonContent.='</div>';
 // Returns the content.
    // Returns the content.
    global $post;
    $shareButtonContentReturn='';
    if(is_home() && $pluginOptionsVal['csbwfs_page_hide_home']==''):
    $shareButtonContentReturn='';
    //echo 'dfff case 1';
     endif;
    if(is_home() && $pluginOptionsVal['csbwfs_page_hide_home']=='yes'):
     $shareButtonContentReturn=$shareButtonContent;
    //  echo 'dfff case 2';
    endif;
    
	if(is_front_page() && $pluginOptionsVal['csbwfs_page_hide_home']==''):
    $shareButtonContentReturn='';
    // echo 'dfff case 3';
    endif;
    if(is_front_page() && $pluginOptionsVal['csbwfs_page_hide_home']=='yes'):
     $shareButtonContentReturn=$shareButtonContent;
      //echo 'dfff case 4';
    endif;
    
 //echo 'dfff'.$pluginOptionsVal['csbwfs_page_hide_post'];
     if(is_single() && $pluginOptionsVal['csbwfs_page_hide_post']==''):
     $shareButtonContentReturn='';
     // echo 'dfff case 5';
     endif;
     
    if(is_single() && $pluginOptionsVal['csbwfs_page_hide_post']=='yes'):
     $shareButtonContentReturn=$shareButtonContent;
      // echo 'dfff case 6';
    endif;
    
     if(is_page() && $pluginOptionsVal['csbwfs_page_hide_page']==''):
     $shareButtonContentReturn='';
      //echo 'dfff case 7';
     endif;
      if(is_page() && $pluginOptionsVal['csbwfs_page_hide_page']=='yes'):
     $shareButtonContentReturn=$shareButtonContent;
      //echo 'dfff case 8';
    endif;

     if(is_singular( 'product' ) && $pluginOptionsVal['csbwfs_page_hide_page']==''):
     $shareButtonContentReturn='';
     // echo 'dfff case 9';
     endif;
     if(is_singular( 'product' ) && $pluginOptionsVal['csbwfs_page_hide_page']=='yes'):
     $shareButtonContentReturn=$shareButtonContent;
      //echo 'dfff case 10';
    endif;
  
    /* custom post type */
    $postypeval=get_option('cswbfs_include_post_type');
     if($postypeval!=''):
      if(is_singular()){
      $customPostAry=explode(',',$postypeval);
      if(is_singular( $customPostAry )):
        $shareButtonContentReturn=$shareButtonContent;
       //  echo 'dfff case 11';
	   else:
	   $shareButtonContentReturn='';
	   // echo 'dfff case 12';
       endif;
      }
    endif;
    
    if(is_archive() && $pluginOptionsVal['csbwfs_page_hide_archive']==''):
     $shareButtonContentReturn='';
     // echo 'dfff case 13';
     endif;
    if(is_archive() && $pluginOptionsVal['csbwfs_page_hide_archive']=='yes'):
     $shareButtonContentReturn=$shareButtonContent;
      //echo 'dfff case 14';
    endif;
    /* hide on specific pages */
    if(is_singular()){
    if(isset($pluginOptionsVal['csbwfs_page_custom_page_ids']) && $pluginOptionsVal['csbwfs_page_custom_page_ids']!=''){
    $csbwfsPageIds=explode(',',$pluginOptionsVal['csbwfs_page_custom_page_ids']);
   // print_r($csbwfsPageIds); echo $pluginOptionsVal['csbwfs_page_hide_on'];
    // Show
    if(in_array($post->ID,$csbwfsPageIds) && $pluginOptionsVal['csbwfs_page_hide_on']=='show'):
       $shareButtonContentReturn=$shareButtonContent;
     //echo 'dfff case 15';
    endif;
   // Hide
    if(in_array($post->ID,$csbwfsPageIds) && $pluginOptionsVal['csbwfs_page_hide_on']=='hide'):
	  $shareButtonContentReturn='';
	  // echo 'dfff case 16';
       endif;
    }
   }
    if(is_404()):
     $shareButtonContentReturn='';
      //echo 'dfff case 17';
    endif;
  /** Buttons position on content */
   if(isset($pluginOptionsVal['csbwfs_btn_display']) && $pluginOptionsVal['csbwfs_btn_display']=='above')
    {
    return $shareButtonContentReturn.$content;
    }else {
		return $content.$shareButtonContentReturn;
	}
}

/*
* Facebook OG tag
*
*/
$pluginOptionsVal=get_csbwf_pro_sidebar_options();
if(isset($pluginOptionsVal['csbwfs_og_tags_enable']) && $pluginOptionsVal['csbwfs_og_tags_enable']=='yes'){
//define action for create new og meta boxes
add_action( 'add_meta_boxes', 'csbwfs_add_meta_box' );
//Define action for save "CSBWFS" OG Meta Box fields Value
add_action( 'save_post', 'csbwfs_save_meta_box_data' );
//Add OG Meta Tag in header
add_action('wp_head','csbwfs_add_og_tag_header',5);
}
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function csbwfs_add_meta_box() {
	$screens = array( 'post', 'page','product','event' ); //define post type
	foreach ( $screens as $screen ) {
		add_meta_box(
			'csbwfs_sectionid',
			__( 'Custom Floating Sidebar OG tag Information', 'csbwfs_textdomain' ),
			'csbwfs_meta_box_callback',
			$screen
		);
	}
}
/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
 global $csbwfs_meta_box;
 $csbwfs_prefix = 'csbwfs_og_';
    $csbwfs_meta_box = array(
    'id' => 'csbwfs-og-meta-box',
    'title' => 'Custom Floating Sidebar Pro OG tag Information',
    'page' => '',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
    array(
    'name' => 'OG Title: ',
    'desc' => '',
    'id' => $csbwfs_prefix . 'title',
    'type' => 'text',
    'std' => ''
    ),
    array(
    'name' => 'OG Description: ',
    'desc' => '',
    'id' => $csbwfs_prefix. 'description',
    'type' => 'text',
    'std' => ''
    ),
    array(
    'name' => 'OG Image: ',
    'desc' => '',
    'id' => $csbwfs_prefix. 'image_path',
    'type' => 'image',
    'std' => ''
    ),
    array(
    'name' => 'Canonical URL: ',
    'desc' => '',
    'id' => $csbwfs_prefix. 'canonical',
    'type' => 'text',
    'std' => ''
    )
    )
 );
function csbwfs_meta_box_callback( $post ) {
global $csbwfs_meta_box;
 	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'csbwfs_og_meta_box', 'csbwfs_meta_box_nonce' );
	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
   foreach ($csbwfs_meta_box['fields'] as $field) {
    $meta = get_post_meta( $post->ID, $field['id'], true );
    echo '<p>',
    '<label for="', $field['id'], '">', $field['name'], '</label>','';
    switch ($field['type']) {
    case 'text':
    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
    break;
    case 'image':
    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:60%" /><input type="button" id="meta-image-button" class="button" value="Choose or Upload an Image" />', '<br />', $field['desc'];
    break;
    case 'textarea':
    echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
    break;
    case 'select':
    echo '<select name="', $field['id'], '" id="', $field['id'], '" >';
    $optionVal=explode(',',$field['options']);
    foreach($optionVal as $optVal):
    if($meta==$optVal){
    $valseleted =' selected="selected"';}else {
		 $valseleted ='';
		}
    echo '<option value="', $optVal, '" ',$valseleted,' id="', $field['id'], '">', $optVal, '</option>';
    endforeach;
    echo '</select>',$field['desc'];
    break;
    echo '</p>';
}
} 
}
/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function csbwfs_save_meta_box_data( $post_id ) {
	global $csbwfs_meta_box;
	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */
	// Check if our nonce is set.
	if ( ! isset( $_POST['csbwfs_meta_box_nonce'] ) ) {
		return;
	}
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['csbwfs_meta_box_nonce'], 'csbwfs_og_meta_box' ) ) {
		return;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	/* OK, it's safe for us to save the data now. */
	foreach ($csbwfs_meta_box['fields'] as $field) 
	{
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old){
		 update_post_meta($post_id, $field['id'], $new);
		} 
		elseif ('' == $new && $old) {
		delete_post_meta($post_id, $field['id'], $old);
		}
	}
	// Update the meta field in the database.
}
/** send og meta to header section */

function csbwfs_add_og_tag_header()
{
global $meta_box, $post;
if ( ! is_singular() || empty( $post ) || empty( $post->ID ) ) {
	return;
}
echo '<!-- START CSBWFS OG Tags -->
<meta property="og:type" content="website">';
$canonicalUrl=get_permalink($post->ID);
//$canonicalcustomUrl=get_post_meta($post->ID,"csbwfs_og_canonical",true);
$lang=strtolower(get_bloginfo("language"));
//if($canonicalcustomUrl!=''){$canonicalUrl=$canonicalcustomUrl;}
if($canonicalUrl!=''){
echo '
<link rel="alternate" href="'.esc_url( $canonicalUrl ).'" hreflang="'.esc_attr( $lang ).'" />';
//echo '<link rel="canonical" href="'.$canonicalUrl.'" />';
}
$ogtile=get_post_meta($post->ID,"csbwfs_og_title",true);
$csbwfs_dft_og_title=get_option('csbwfs_dft_og_title');
if($ogtile=='' && $csbwfs_dft_og_title!=''){$ogtile=$csbwfs_dft_og_title;}
elseif($ogtile=='' && $csbwfs_dft_og_title==''){$ogtile=wp_title('',FALSE,'right');}else{}
if($ogtile!=''){
echo '
<meta property="og:title" content="'.esc_attr( $ogtile ).'">';}
$ogdescription=get_post_meta($post->ID,"csbwfs_og_description",true);
$csbwfs_dft_og_desc=get_option('csbwfs_dft_og_desc');
if($ogdescription=='' && $csbwfs_dft_og_desc!=''){$ogdescription=$csbwfs_dft_og_desc;}
if($ogdescription!=''){
echo '
<meta property="og:description" content="'.esc_attr( $ogdescription ).'">';}
$ogimage=get_post_meta($post->ID,"csbwfs_og_image_path",true);
$csbwfs_dft_og_img=get_option('csbwfs_dft_og_img');
if($ogimage=='' && $csbwfs_dft_og_img!=''){$ogimage=$csbwfs_dft_og_img;}
if($ogimage!=''){
echo '
<meta property="og:image" content="'.esc_url( $ogimage ).'">';}
echo '
<!-- END CSBWFS OG Tags -->
';
}
