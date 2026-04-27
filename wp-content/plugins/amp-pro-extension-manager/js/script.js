jQuery(document).ready(function(){
	jQuery("#active_licence").click(function(){
		let _this = jQuery(this);
		var afwpp_secure_nonce = jQuery("#ampforwppro_nonce").val();
		var bundle_license_key = jQuery("#bundle_license_key").val();
		if(bundle_license_key!=""){
			var start;
			var dots = '.';
			_this.html("Validating"+dots);
			var interval = 0;
			start = setInterval(function(){
				dots +='.';
				interval++;
				if(interval==3){
					interval=0;
					dots = '.';
				}
				_this.html("Validating"+dots);
			}, 800);
		
			jQuery.ajax({
		        url: ajaxurl,
		        method: 'post',
		        data: {
		        		action: 'ampforwppro_validate_licence',
		        		license: bundle_license_key,
		               	verify_nonce: afwpp_secure_nonce,
		               	afwpp_type:'ampforwppro'
		              },
		        success: function(response){
		        	response = response.replace("0", "");
		        	var reps = JSON.parse(response);
		        	if(reps.success==1){
		        		clearInterval(start);
		        		jQuery("#active_licence").html("License validated")
		        		jQuery('#refresh_license').click();
		        		jQuery('#refresh_license').html('<div><span class="lmsg refresh-lib"><i class="dashicons dashicons-update-alt spin" id="refresh_license_icon"></i> Please wait while we upgrade library</span></div>');
			        	/*setTimeout(function(){
			        		location.reload();
			        	},500);*/
			        }else{
			        	clearInterval(start);
			        	jQuery("#error_msg").html(reps.message);
			        	jQuery("#error_div").removeClass('hide');
			        	jQuery("#active_licence").html("Activate license");
			        	let err_messg = reps.message
			        	jQuery("#err_message").html(err_messg);
			        }
		        }
		    });
		}else{
			jQuery("#error_msg").html("Please enter valid license key");
			jQuery("#error_div").removeClass('hide');
		}
    });
    jQuery(".afwpp_activate_ext").click(function(){
    		let _this = jQuery(this);
    		let current_status = _this.html();
    		let thisid = _this.attr('id');
    		let plugin_path = jQuery("#plugin_path-"+thisid).val();
    		let is_active = jQuery("#is_active-"+thisid).val();
    	
			var start_interval;
    		if(current_status=="Activate" || current_status=="Activate License" || current_status=="Activate Plugin"){
				var dots = '.';
				_this.html("Activating"+dots);
				var interval = 0;
				start_interval = setInterval(function(){
					dots +='.';
					interval++;
					if(interval==3){
						interval=0;
						dots = '.';
					}
					_this.html("Activating"+dots);
				}, 800);
    		}else if(current_status=="Deactivate"){
				var dots = '.';
				_this.html("Deactivating"+dots);
				var interval = 0;
				start_interval = setInterval(function(){
					dots +='.';
					interval++;
					if(interval==3){
						interval=0;
						dots = '.';
					}
					_this.html("Deactivating"+dots);
				}, 800);
    		}
    		var afwpp_secure_nonce = jQuery("#ampforwppro_nonce").val();
			jQuery.ajax({
		        url: ajaxurl,
		        method: 'post',
		        data: {
		        		action: 'ampforwppro_activate_licence',
		        		id: thisid,
		        		c_status: current_status,
		               	verify_nonce: afwpp_secure_nonce,
		               	afwpp_type:'ampforwppro',
		               	plugin_path:plugin_path,
		               	is_active:is_active
		              },
		        success: function(response){
		        	response = response.replace("0", "");
		        	if(response.indexOf('"success":1') != -1){
						location.reload();
					}
        			var reps = JSON.parse(response);
		        	if(reps.success==1){
			        	location.reload();
			        }else{			        	
			        	_this.closest('.ext-info').find('#proextns-errors-div p').html(reps.message);
			        	_this.closest('.ext-info').find('#proextns-errors-div').show();			        	
			        	_this.closest('.ext-info').find('#proextns-errors-div').delay(3000).fadeOut();
			        	_this.html(current_status);
			        	clearInterval(start_interval);
			        }
		        }
		    });
			
    });

    jQuery("#revoke_license").click(function(){
      var chck = confirm("You are about to remove License key, do you wish to continue?");
      if(chck == true){	
    	let _this = jQuery(this);
		var dots = '.';
		_this.html("Deactivating"+dots);
		var interval = 0;
		var start_interval = setInterval(function(){
			dots +='.';
			interval++;
			if(interval==3){
				interval=0;
				dots = '.';
			}
			_this.html("Deactivating"+dots);
		},800);

    	var afwpp_secure_nonce = jQuery("#ampforwppro_nonce").val();
		jQuery.ajax({
	        url: ajaxurl,
	        method: 'post',
	        data: {
	        		action: 'ampforwppro_remove_licence',
	        		verify_nonce: afwpp_secure_nonce,
	              },
	        success: function(response){
	        	response = response.replace("0", "");
    			var reps = JSON.parse(response);
	        	if(reps.success==1){
		        	location.reload();
		        }else{
		        	clearInterval(start_interval);
		        	_this.html("Deactivate");
		        	jQuery("#error_msg").html(reps.message);
		        	jQuery("#error_div").removeClass('hide');
		        	
		        }
	        }
	    });
	  }  
    });
   jQuery("#refresh_license").click(function(){
   		let _this = jQuery(this);
   		var afwpp_secure_nonce = jQuery("#ampforwppro_nonce").val();
   		var payment_id = jQuery("#payment_id").val();
   		var download_id = jQuery("#download_id").val();
   		var renew_status = jQuery("#renew_status").val();
		jQuery("#refresh_license_icon").addClass( 'spin' );
   		jQuery.ajax({
	        url: ajaxurl,
	        method: 'post',
	        data: {
	        		action: 'afwpp_refresh_bundle',
	        		verify_nonce: afwpp_secure_nonce,
	        		renew_status: renew_status,
	              },
	        success: function(response){
	        	response = response.replace("0", "");
	        	var resp = JSON.parse(response);
	        	if(resp.success==1 || resp.success==3){
	        		jQuery("#refresh_license_icon").removeClass( 'spin' );
				    location.reload();
			    }else{
			    	jQuery("#refresh_license_icon").removeClass( 'spin' );
			    	jQuery("#error_msg").html(resp.message);
			    	jQuery("#error_div").removeClass('hide');
			    }
	        }
	    });
   	
   });

   jQuery("#refresh_license_top").click(function(){
   		let _this = jQuery(this);
   		var afwpp_secure_nonce = jQuery("#ampforwppro_nonce").val();
   		var payment_id = jQuery("#payment_id").val();
   		var download_id = jQuery("#download_id").val();
   		var renew_status = jQuery("#renew_status").val();
		jQuery("#refresh_license_icon_top").addClass( 'spin' );
   		jQuery.ajax({
	        url: ajaxurl,
	        method: 'post',
	        data: {
	        		action: 'afwpp_refresh_bundle',
	        		verify_nonce: afwpp_secure_nonce,
	        		renew_status: renew_status,
	              },
	        success: function(response){
	        	response = response.replace("0", "");
	        	var resp = JSON.parse(response);
	        	if(resp.success==1 || resp.success==3){
	        		jQuery("#refresh_license_icon_top").removeClass( 'spin' );
				    location.reload();
			    }else{
			    	jQuery("#refresh_license_icon_top").removeClass( 'spin' );
			    	jQuery("#error_msg").html(resp.message);
			    	jQuery("#error_div").removeClass('hide');
			    }
	        }
	    });
   	
   });
   //code to run when Expired and in between 0-7 days to get data if he has done the Renewal   
   		setTimeout(function(){ 
   		var rem_days = jQuery("#remaining_days").val();
   		if ( rem_days <= 7 ) {
   		jQuery("#auto_fresh").click();
			let _this = jQuery(this);
   		var afwpp_secure_nonce = jQuery("#ampforwppro_nonce").val();
   		var payment_id = jQuery("#payment_id").val();
   		var download_id = jQuery("#download_id").val();
   		var renew_status = jQuery("#renew_status").val();

   		var lmsg2 = jQuery(".lmsg2");
   		jQuery.ajax({
	        url: ajaxurl,
	        method: 'post',
	        data: {
	        		action: 'afwpp_refresh_bundle',
	        		verify_nonce: afwpp_secure_nonce,
	        		renew_status: renew_status,
	              },
	        success: function(response){
	        	var resp = JSON.parse(response);
	        	if(resp.success==1){
	        		var l_exp =  resp.license_exp__ ;
	        		lmsg2.html("<span id=\"attnl\">__</span> Expires in " + l_exp + " days" );
			    }else{
			    	jQuery("#error_msg").html(resp.message);
			    }
	        }
	    });
	    jQuery.ajax({
	        url: ajaxurl,
	        method: 'post',
	        data: {
	        		action: 'afwpp_run_oncef7',
	        		verify_nonce: afwpp_secure_nonce,
	        		renew_status: renew_status,
	              },
	        success: function(response){
	        	var resp = JSON.parse(response);
	        }
	    });
   	}
   },1000);

   //Code to run just once for 1 version number
   
   		jQuery(document).ready(function(){
   		var rem_days = jQuery("#remaining_days").val();
   		var ver_num = jQuery("#ver_num").val();
   		var expired = jQuery(".expired").text();
   		if ( ver_num == '1.10.11' && expired !== ' Expired ' ) {
   		jQuery("#auto_fresh2").click();
      let _this = jQuery(this);
   		var afwpp_secure_nonce = jQuery("#ampforwppro_nonce").val();
   		var payment_id = jQuery("#payment_id").val();
   		var download_id = jQuery("#download_id").val();
   		var renew_status = jQuery("#renew_status").val();
   		var lmsg2 = jQuery(".lmsg2");
   		jQuery.ajax({
	        url: ajaxurl,
	        method: 'post',
	        data: {
	        		action: 'afwpp_refresh_bundle',
	        		verify_nonce: afwpp_secure_nonce,
	        		renew_status: renew_status,
	              },
	        success: function(response){
	        	var resp = JSON.parse(response);
	        	if(resp.success==1){
	        		var l_exp =  resp.license_exp__ ;
	        		lmsg2.html("<span id=\"attnl\">__</span> Expires in " + l_exp + " days" );
			    }else{
			    	jQuery("#error_msg").html(resp.message);
			    	// location.reload();
			    }
	        }
	    });
   	}
    } );
   		
   		setTimeout(function(){ 
   		var rem_days = jQuery("#remaining_days").val();	
   		var expired = jQuery(".expired").text();   	
   		jQuery("#auto_fresh").click();
      let _this = jQuery(this);
   		var afwpp_secure_nonce = jQuery("#ampforwppro_nonce").val();
   		var payment_id = jQuery("#payment_id").val();
   		var download_id = jQuery("#download_id").val();
   		var renew_status = jQuery("#renew_status").val();
   		var ver_num = jQuery("#ver_num").val();
   		var expired = jQuery(".expired").text();
   		if ( ver_num == '1.10.11' && expired !== ' Expired ' ) {   			
   		jQuery.ajax({
	        url: ajaxurl,
	        method: 'post',
	        data: {
	        		action: 'afwpp_run_once',
	        		verify_nonce: afwpp_secure_nonce,
	        		renew_status: renew_status,
	              },
	        success: function(response){
	        	var resp = JSON.parse(response);
	        	if(resp.success==1){
			    }else{
			    	jQuery("#error_msg").html(resp.message);
			    	console.log(resp.message)
			    }
	        }
	    });
   	 
   	}
   },5000);
   
   jQuery(".extension-tab").click(function(){
   		var nav = jQuery(this).attr('id');
   		jQuery('.extension-tab').each(function(){
   			jQuery(this).removeClass('active');
   		});
   		jQuery(this).addClass('active');
   		if(nav=='all'){
   			jQuery(".ext-list-block ul li").removeClass('hide');
   		}else{
	   		jQuery(".ext-list-block ul li").each(function(){
	   			if(jQuery(this).hasClass(nav)){
	   				jQuery(this).removeClass('hide');
	   			}else{
	   				jQuery(this).addClass('hide');
	   			}
	   		});
	   	}
   });
});