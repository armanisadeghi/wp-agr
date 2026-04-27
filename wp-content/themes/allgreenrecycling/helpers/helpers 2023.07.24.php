<?php
/**
 * Insert information from first step in gravity form to green pulse server
 *
 * @param array $partial_entry partial entry information from form
 * @param $form
 */

session_start();

$urlforwarding = "{lpurl}?utm_source=adwords_{network}&utm_medium={_adgroup}&utm_campaign={_campaign}&utm_content={_ad}_{device}_{ifsearch:{adposition}}{ifcontent:{placement}}&utm_term={matchtype}_{keyword}";

function divide_name( $name, $is_first = 1 ) {
	$val   = explode( ' ', $name );
	$value = array_shift( $val );

	return trim( $is_first ? $value : implode( ' ', $val ) );
}

function mok_leads_initial_save( $partial_entry, $form ) {
	$sess_val = session_id();
	$sess_val = substr( $sess_val, 0, 5 );
	
	try {

		$leads_db = new PDO(
			'mysql:host=allgreen.cmsfg3ols5pn.us-west-2.rds.amazonaws.com;dbname=allgreendb;charset=utf8mb4', 'root', 'ggA7LRiSrwis', [
				PDO::ATTR_EMULATE_PREPARES => false,
				PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
			]
		);

		$form_id      = $form['fields'][0]->formId;
		$datetime     = new DateTime( 'now', new DateTimeZone( get_option( 'timezone_string' ) ) );
		$now          = $datetime->format( 'Y/m/d H:i:s' );
		$first_name   = array_key_exists( '57.3', $partial_entry ) ? divide_name( $partial_entry['57.3'] ) : '';
		$last_name    = array_key_exists( '57.3', $partial_entry ) ? divide_name( $partial_entry['57.3'], 0 ) : '';
		$email        = array_key_exists( '3', $partial_entry ) ? $partial_entry['3'] : '';
		$phone        = array_key_exists( '4', $partial_entry ) ? $partial_entry['4'] : '';
		$company      = array_key_exists( '2', $partial_entry ) ? $partial_entry['2'] : '';
		$zip          = array_key_exists( '5.5', $partial_entry ) ? $partial_entry['5.5'] : '';
		$session_id   = 'gformtitanium' . $form_id . date( 'dmy' ) . $sess_val . strtolower( substr( $partial_entry['3'], 0, 15 ) );
		$urlforwarding = $GLOBALS["urlforwarding"];
				
		$leads_update = $leads_db->prepare(
			'INSERT INTO 
tblprocurementleads 
(stage,stage_time,first_name,last_name,email,phone,company,zip,ServiceSelection,IPAddress,session_Id,AGRpage,address,urlforwarding)
VALUE (:stage,:stage_time, :first_name,:last_name,:email,:phone,:company,:zip,:service,:ip,:sessionid,:referrer,:address,:urlforwarding)'
		);
		$leads_update->bindValue( ':stage', 1, PDO::PARAM_INT );
		$leads_update->bindValue( ':stage_time', $now, PDO::PARAM_STR );
		$leads_update->bindValue( ':first_name', $first_name, PDO::PARAM_STR );
		$leads_update->bindValue( ':last_name', $last_name, PDO::PARAM_STR );
		$leads_update->bindValue( ':email', $email, PDO::PARAM_STR );
		$leads_update->bindValue( ':phone', $phone, PDO::PARAM_STR );
		$leads_update->bindValue( ':company', $company, PDO::PARAM_STR );
		$leads_update->bindValue( ':zip', $zip, PDO::PARAM_STR );
		$leads_update->bindValue( ':service', corresponding_service( $partial_entry[7] ), PDO::PARAM_STR );
		$leads_update->bindValue( ':ip', $partial_entry['ip'], PDO::PARAM_STR );
		$leads_update->bindValue( ':sessionid', $session_id, PDO::PARAM_STR );
		$leads_update->bindValue( ':referrer', $partial_entry['source_url'], PDO::PARAM_STR );
		$leads_update->bindValue( ':address', '', PDO::PARAM_STR );
		$leads_update->bindValue( ':urlforwarding', $urlforwarding, PDO::PARAM_STR );
		
		if ( $first_name != '' && $email != '' && $partial_entry['id'] != '' ) {

			$stmt      = $leads_db->query( 'SELECT * FROM tblprocurementleads WHERE session_Id = "gformtitanium' . $form_id . date( 'dmy' ) . $sess_val . substr( strtolower( $partial_entry['3'] ), 0, 15 ) . '"' );
			$row_count = $stmt->rowCount();
			if ( $row_count == 0 ) :
				$leads_update->execute();
			endif;
		}
	} catch ( PDOException $e ) {
		$leads_db     = new PDO(
			'mysql:host=127.0.0.1;dbname=wp_allgreenrecyc;charset=utf8mb4', 'allgreenrecyc', 'zbF7JpxMC0loskI4guHk', [
				PDO::ATTR_EMULATE_PREPARES => false,
				PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
			]
		);
		$form_id      = $form['fields'][0]->formId;
		$datetime     = new DateTime( 'now', new DateTimeZone( get_option( 'timezone_string' ) ) );
		$now          = $datetime->format( 'Y/m/d H:i:s' );
		$first_name   = array_key_exists( '57.3', $partial_entry ) ? divide_name( $partial_entry['57.3'] ) : '';
		$last_name    = array_key_exists( '57.3', $partial_entry ) ? divide_name( $partial_entry['57.3'], 0 ) : '';
		$email        = array_key_exists( '3', $partial_entry ) ? $partial_entry['3'] : '';
		$phone        = array_key_exists( '4', $partial_entry ) ? $partial_entry['4'] : '';
		$company      = array_key_exists( '2', $partial_entry ) ? $partial_entry['2'] : '';
		$zip          = array_key_exists( '5.5', $partial_entry ) ? $partial_entry['5.5'] : '';
		$session_id   = 'gformtitanium' . $form_id . date( 'dmy' ) . $sess_val . strtolower( substr( $partial_entry['3'], 0, 15 ) );
		$urlforwarding = $GLOBALS["urlforwarding"];
		
		$leads_update = $leads_db->prepare(
			'INSERT INTO 
tblprocurementleads1 
(stage,stage_time,first_name,last_name,email,phone,company,zip,ServiceSelection,IPAddress,session_Id,AGRpage,address,urlforwarding)
VALUE (:stage,:stage_time, :first_name,:last_name,:email,:phone,:company,:zip,:service,:ip,:sessionid,:referrer,:address,:urlforwarding)'
		);
		$leads_update->bindValue( ':stage', 1, PDO::PARAM_INT );
		$leads_update->bindValue( ':stage_time', $now, PDO::PARAM_STR );
		$leads_update->bindValue( ':first_name', $first_name, PDO::PARAM_STR );
		$leads_update->bindValue( ':last_name', $last_name, PDO::PARAM_STR );
		$leads_update->bindValue( ':email', $email, PDO::PARAM_STR );
		$leads_update->bindValue( ':phone', $phone, PDO::PARAM_STR );
		$leads_update->bindValue( ':company', $company, PDO::PARAM_STR );
		$leads_update->bindValue( ':zip', $zip, PDO::PARAM_STR );
		$leads_update->bindValue( ':service', corresponding_service( $partial_entry[7] ), PDO::PARAM_STR );
		$leads_update->bindValue( ':ip', $partial_entry['ip'], PDO::PARAM_STR );
		$leads_update->bindValue( ':sessionid', 'gformtitanium' . date( 'dmy' ) . $sess_val . substr( $partial_entry['3'], 0, 15 ), PDO::PARAM_STR );
		$leads_update->bindValue( ':referrer', $partial_entry['source_url'], PDO::PARAM_STR );
		$leads_update->bindValue( ':address', '', PDO::PARAM_STR );
		$leads_update->bindValue( ':urlforwarding', '', PDO::PARAM_STR );
		
		if ( $first_name != '' && $email != '' && $partial_entry['id'] != '' ) {
			$stmt      = $leads_db->query( 'SELECT * FROM tblprocurementleads1 WHERE session_Id = "gformtitanium' . $form_id . date( 'dmy' ) . $sess_val . substr( strtolower( $partial_entry['3'] ), 0, 15 ) . '"' );
			$row_count = $stmt->rowCount();
			if ( $row_count === 0 ) :
				$leads_update->execute();
			endif;
		}
	}

}

add_action( 'gform_partialentries_post_entry_saved', 'mok_leads_initial_save', 10, 2 );

/******** form submit*************/
function mok_leads_final_save( $entry, $form, $field ) {
	$sess_val = session_id();
	$sess_val = substr( $sess_val, 0, 5 );
	$form_id  = $form['fields'][0]->formId;
	$output   = '';
	foreach ( $form['fields'] as &$field ) {

		if ( is_array( $field['inputs'] ) ) {
			foreach ( $field['inputs'] as &$input ) {
				$label = $input['label'];
				$value = $entry[ (string) $input['id'] ];
				if ( ! empty( $value ) ) {
					$output .= $label . '!-@' . $value . '#@';
				}
			}
		} else {
			$label = $field['label'];
			$value = $entry[ $field['id'] ];
			if ( ! empty( $value ) ) {
				$output .= $label . '!-@' . $value . '#@';
			}
		}
	}
	
	
	$_array = array();
	$lines  = explode( '#@', $output );
	foreach ( $lines as $line ) {
		list($key, $value) = explode( '!-@', $line );
		$_array[ $key ]    = $value;
	}

	$datetime   = new DateTime( 'now', new DateTimeZone( get_option( 'timezone_string' ) ) );
	$now        = $datetime->format( 'Y/m/d H:i:s' );
	$stage      = 1;
	$first_name = $_array['First'];
	if ( $_array['Name'] ) {
		$first_name = $_array['Name'];
	}
	$last_name = $_array['Last'];
	if ( $last_name === '' ) {
		$last_name   = explode( ' ', $first_name );
		$_count_name = count( $last_name );
		if ( $_count_name === 1 ) {
			$last_name = ' ';
		} else {
			$_first_name_val = array_slice( $last_name, 0, -1 );
			$_first_name_val = implode( ' ', $_first_name_val );
			$last_name       = end( $last_name );
			$first_name      = $_first_name_val;
		}
	}
	$email                 = $_array['Email'];
	$company               = array_key_exists('Company',$_array) && ''!== $_array['Company']?$_array['Company']:'';
	$phone                 = $_array['Phone'];
	$zip                   = array_key_exists('ZIP / Postal Code',$_array) && ''!== $_array['ZIP / Postal Code']?$_array['ZIP / Postal Code']:'';
	$_country              = $_array['Country'];
	$service               = array_key_exists('Desired Service',$_array) && ''!== $_array['Desired Service']?$_array['Desired Service']:'';
	
	$_ip_address           = $_array['IP Address'];
	$_ip_address           = ( $_ip_address === '' ) ? $_SERVER['REMOTE_ADDR'] : $_ip_address;
	$_user_agent           = $_array['User Agent'];
	$_campaign_name = $_array['campaign_name'];
	$_campaign_source = $_array['campaign_source'];
	$_landing_url = $_array['landing_url'];
	$_http_referrer        = $_array['HTTP REFERRER'];	
	
	$_referrer_url         = $_array['Referrer URL'];
	$_referrer_url         = $_array['referal_url'];
	$_referrer_url         = ( $_referrer_url === '' ) ? $_SERVER['REQUEST_URI'] : $_referrer_url;
		
	$session_id            = 'gformtitanium' . $form_id . date( 'dmy' ) . $sess_val . strtolower( substr( $email, 0, 15 ) );
	$dd_onsite             = $_array['Is Data Destruction Required?'];
	$e_organization        = $_array['Types of Organization'];
	$e_primary_purpose     = $_array['Primary purpose'];
	$e_secondary_purpose   = $_array['Secondary purpose'];
	$e_past_event          = $_array['Have you held an e-waste event in the past?'];
	$e_waste_collected     = $_array['How much did you collect at your last event?'];
	$ewp_shipping_needs    = $_array['Shipping Needs?'];
	$itad_assets           = $_array['Do you have an asset inventory list?'];
	$itad_data_protection  = $_array['Is Data Destruction Required?'];
	$itad_job_title        = $_array['What is your Job Title?'];
	$itad_no_employees     = $_array['Number of Employees?'];
	$oss_max_size          = $_array['Do you have a maximum shred Size?'];
	$oss_record_shred      = $_array['Are you interested in a video of the process?'];
	$oss_witness_shred     = $_array['Are you interested in witnessing shredding?'];
	$pd_method             = $_array['Is there a preference for destruction methods?'];
	$rl_exist_solution     = $_array['Existing Solution?'];
	$rl_material_condition = $_array['Equipment Condition'];
	$dd_oss_cd             = $_array['CD/DVD/Flopy'];
	$dd_oss_computer       = $_array['Computers'];
	$dd_oss_copy           = $_array['Copy Machines'];
	$dd_oss_hard_drive     = $_array['Hard Drives'];
	$dd_oss_laptops        = $_array['Laptops'];
	$dd_oss_servers        = $_array['Servers'];
	$dd_oss_solid_state    = $_array['Solid State'];
	$dd_oss_tablets        = $_array['Tablets'];
	$dd_oss_tapes          = $_array['Tapes'];
	if ( array_key_exists( 'What type of equipment is to be destroyed?', $_array ) ) :
		$pd_rl_equipment_type = $_array['What type of equipment is to be destroyed?'];
		else :
			$pd_rl_equipment_type = $_array['What Type of Equipment?'] ? $_array['What Type of Equipment?'] : '';
		endif;
		$ewp_pd_frequency          = $_array['Frequency of Accumulation?'];
		$ewp_pd_volume             = $_array['Volume?'];
		$rs_itad_computers_servers = $_array['Computers / Servers'];
		$rs_itad_tv_monitors       = $_array['Televisions / Monitors'];
		$rs_itad_laptops_tablets   = $_array['Laptops / Tablets'];
		$all_additional_info       = $_array['Any Additional Information?'];
		if ( $_array['Notes'] ) {
			$all_additional_info = $_array['Notes'];
		}
		$all_asset_reporting     = $_array['Is Asset Reporting Required?'];
		$all_certification       = $_array['Certification Requirements'];
		$all_selected_date       = $_array['Do you have a Deadline for this job?'];
		$all_formal_policy       = $_array['Do you Have a Formal Destruction Policy?'];
		$all_primary_objective   = $_array['Primary Objective'];
		$all_secondary_objective = $_array['Secondary Objective'];
		$all_other_items         = $_array['Other Items'];
		$uploaded_filename       = $_array['Do you have an asset inventory list?'];
		$urlforwarding = $GLOBALS["urlforwarding"];
		
		try {
			$leads_db = new PDO(
				'mysql:host=allgreen.cmsfg3ols5pn.us-west-2.rds.amazonaws.com;dbname=allgreendb;charset=utf8mb4', 'root', 'ggA7LRiSrwis', [
					PDO::ATTR_EMULATE_PREPARES => false,
					PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
				]
			);

			$stmt      = $leads_db->query( 'SELECT * FROM tblprocurementleads WHERE session_Id = "gformtitanium' . $form_id . date( 'dmy' ) . $sess_val . substr( strtolower( $email ), 0, 15 ) . '"' );
			$row_count = $stmt->rowCount();
			if ( $row_count === 0 ) {
				$leads_update = $leads_db->prepare(
					'INSERT INTO 
				tblprocurementleads 
				(stage,stage_time,first_name,last_name,email,phone,company,zip,ServiceSelection,IPAddress,session_Id,AGRpage,address,urlforwarding,user_agent,campaign_name,campaign_source,landing_url,http_referrer)
				VALUE (:stage,:stage_time, :first_name,:last_name,:email,:phone,:company,:zip,:service,:ip,:sessionid,:referrer,:address,:urlforwarding,:user_agent,:campaign_name,:campaign_source,:landing_url,:http_referrer)'
				);
				$leads_update->bindValue( ':stage', 1, PDO::PARAM_INT );
				$leads_update->bindValue( ':stage_time', $now, PDO::PARAM_STR );
				$leads_update->bindValue( ':first_name', $first_name, PDO::PARAM_STR );
				$leads_update->bindValue( ':last_name', $last_name, PDO::PARAM_STR );
				$leads_update->bindValue( ':email', $email, PDO::PARAM_STR );
				$leads_update->bindValue( ':phone', $phone, PDO::PARAM_STR );
				$leads_update->bindValue( ':company', $company, PDO::PARAM_STR );
				$leads_update->bindValue( ':zip', $zip, PDO::PARAM_STR );
				$leads_update->bindValue( ':service', $service, PDO::PARAM_STR );
				$leads_update->bindValue( ':ip', $_ip_address, PDO::PARAM_STR );
				$leads_update->bindValue( ':user_agent', $_user_agent, PDO::PARAM_STR );
				$leads_update->bindValue( ':campaign_name', $_campaign_name, PDO::PARAM_STR );
				$leads_update->bindValue( ':campaign_source', $_campaign_source, PDO::PARAM_STR );
				$leads_update->bindValue( ':landing_url', $_landing_url, PDO::PARAM_STR );
				$leads_update->bindValue( ':http_referrer', $_http_referrer, PDO::PARAM_STR );
				$leads_update->bindValue( ':sessionid', 'gformtitanium' . $form_id . date( 'dmy' ) . $sess_val . strtolower( substr( $email, 0, 15 ) ), PDO::PARAM_STR );
				$leads_update->bindValue( ':referrer', $_referrer_url, PDO::PARAM_STR );
				$leads_update->bindValue( ':address', '', PDO::PARAM_STR );
				$leads_update->bindValue( ':urlforwarding', '', PDO::PARAM_STR );
				if ( $form_id != 12 ) {
					if ( $first_name != '' && $email != '' ) {
						$leads_update->execute();
					}
				}
			}

			$leads_update = $leads_db->prepare(
				'UPDATE tblprocurementleads SET
                stage = :stage,
                first_name = :first_name,
                last_name= :last_name,
                email= :email,
                phone= :phone,
                company = :company,
                zip = :zip,
                ServiceSelection = :service,
                IPAddress = :ip,
				AGRpage = :referrer,
                stage_time = :stage_time,
                AutomaticScheduler = :automatic_scheduler,
                DD_OnSite = :dd_onsite,
                E_Organization = :e_organization,
                E_PrimaryPurpose = :e_primary_purpose,
                E_SecondaryPurpose = :e_secondary_purpose,
                E_PastEvent = :e_past_event,
                E_WasteCollected = :e_waste_collected,
                EWP_ShippingNeeds = :ewp_shipping_needs,
                ITAD_AssetInventoryList = :itad_assets,
                ITAD_DataProtection = :itad_data_protection,
                ITAD_JobTitle = :itad_job_title,
                ITAD_NumberOfEmployees =:itad_no_employees,
                OSS_MaxShredSize = :oss_max_size,
                OSS_RecordShredding = :oss_record_shred,
                OSS_WitnessShredding = :oss_witness_shred,
                PD_Method = :pd_method,
                RL_ExistingSolution = :rl_exist_solution,
                RL_MaterialCondition = :rl_material_condition,
                DD_OSS_CdDvdFloppy = :dd_oss_cd,
                DD_OSS_Computers = :dd_oss_computer,
                DD_OSS_CopyMachines = :dd_oss_copy,
                DD_OSS_HardDrives = :dd_oss_hard_drive,
                DD_OSS_Laptops = :dd_oss_laptops,
                DD_OSS_Servers = :dd_oss_servers,
                DD_OSS_SolidState = :dd_oss_solid_state,
                DD_OSS_Tablets = :dd_oss_tablets,
                DD_OSS_Tapes = :dd_oss_tapes,
                PD_RL_EquipmentType = :pd_rl_equipment_type,
                EWP_PD_Frequency = :ewp_pd_frequency,
                EWP_PD_Volume = :ewp_pd_volume,
                RS_ITAD_ComputersServers = :rs_itad_computers_servers,
                RS_ITAD_TelevisionsMonitors = :rs_itad_tv_monitors,
                RS_ITAD_LaptopsTablets = :rs_itad_laptops_tablets,
                ALL_AdditionalNotes = :all_additional_info,
                ALL_AssetReporting = :all_asset_reporting,
                ALL_Certification = :all_certification,
                ALL_Date = :all_selected_date,
                ALL_Fees = :all_fees,
                ALL_FormalPolicy = :all_formal_policy,
                ALL_PrimaryObjective = :all_primary_objective,
                ALL_SecondaryObjective = :all_secondary_objective,
                ALL_OtherItems = :all_other_items,
                UploadedFileName = :uploaded_filename,
				urlforwarding = :urlforwarding, 
				user_agent = :user_agent,
				campaign_name = :campaign_name,
				campaign_source = :campaign_source,
				landing_url = :landing_url,
				http_referrer = :http_referrer
            WHERE session_Id = :sessionid'
			);
			$leads_update->bindValue( ':stage', 1, PDO::PARAM_INT );
			$leads_update->bindValue( ':stage_time', $now, PDO::PARAM_STR );
			$leads_update->bindValue( ':first_name', $first_name, PDO::PARAM_STR );
			$leads_update->bindValue( ':last_name', $last_name, PDO::PARAM_STR );
			$leads_update->bindValue( ':email', $email, PDO::PARAM_STR );
			$leads_update->bindValue( ':phone', $phone, PDO::PARAM_STR );
			$leads_update->bindValue( ':company', $company, PDO::PARAM_STR );
			$leads_update->bindValue( ':zip', $zip, PDO::PARAM_STR );
			$leads_update->bindValue( ':service', corresponding_service( $service ), PDO::PARAM_STR );
			$leads_update->bindValue( ':ip', $_ip_address, PDO::PARAM_STR );
			$leads_update->bindValue( ':referrer', $_referrer_url, PDO::PARAM_STR );
			$leads_update->bindValue( ':user_agent', $_user_agent, PDO::PARAM_STR );
			$leads_update->bindValue( ':campaign_name', $_campaign_name, PDO::PARAM_STR );
			$leads_update->bindValue( ':campaign_source', $_campaign_source, PDO::PARAM_STR );
			$leads_update->bindValue( ':landing_url', $_landing_url, PDO::PARAM_STR );
			$leads_update->bindValue( ':http_referrer', $_http_referrer, PDO::PARAM_STR );			
			$leads_update->bindValue( ':automatic_scheduler', 0, PDO::PARAM_INT );
			$leads_update->bindValue( ':dd_onsite', service_bool_val( $dd_onsite ), PDO::PARAM_STR );
			$leads_update->bindValue( ':e_organization', service_event_org_val( $e_organization ), PDO::PARAM_STR );
			$leads_update->bindValue( ':e_primary_purpose', service_second_obj_val( $e_primary_purpose ), PDO::PARAM_STR );
			$leads_update->bindValue( ':e_secondary_purpose', service_second_obj_val( $e_secondary_purpose ), PDO::PARAM_STR );
			$leads_update->bindValue( ':e_past_event', service_bool_val( $e_past_event ), PDO::PARAM_STR );
			$leads_update->bindValue( ':e_waste_collected', service_event_collection_val( $e_waste_collected ), PDO::PARAM_STR );
			$leads_update->bindValue( ':ewp_shipping_needs', service_shipping_needs_val( $ewp_shipping_needs ), PDO::PARAM_STR );
			$leads_update->bindValue( ':itad_assets', service_bool_val( $itad_assets ), PDO::PARAM_STR );
			$leads_update->bindValue( ':itad_data_protection', service_bool_val( $itad_data_protection ), PDO::PARAM_STR );
			$leads_update->bindValue( ':itad_job_title', $itad_job_title, PDO::PARAM_STR );
			$leads_update->bindValue( ':itad_no_employees', $itad_no_employees, PDO::PARAM_STR );
			$leads_update->bindValue( ':oss_max_size', max_shred_size( $oss_max_size ), PDO::PARAM_STR );
			$leads_update->bindValue( ':oss_record_shred', service_bool_val( $oss_record_shred ), PDO::PARAM_STR );
			$leads_update->bindValue( ':oss_witness_shred', service_bool_val( $oss_witness_shred ), PDO::PARAM_STR );
			$leads_update->bindValue( ':pd_method', service_pd_method_val( $pd_method ), PDO::PARAM_STR );
			$leads_update->bindValue( ':rl_exist_solution', service_rl_existing_solution_val( $rl_exist_solution ), PDO::PARAM_STR );
			$leads_update->bindValue( ':rl_material_condition', service_rl_material_condition_val( $rl_material_condition ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_cd', corresponding_combo_value( $dd_oss_cd ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_computer', corresponding_combo_value( $dd_oss_computer ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_copy', corresponding_combo_value( $dd_oss_copy ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_hard_drive', corresponding_combo_value( $dd_oss_hard_drive ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_laptops', corresponding_combo_value( $dd_oss_laptops ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_servers', corresponding_combo_value( $dd_oss_servers ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_solid_state', corresponding_combo_value( $dd_oss_solid_state ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_tablets', corresponding_combo_value( $dd_oss_tablets ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_tapes', corresponding_combo_value( $dd_oss_tapes ), PDO::PARAM_STR );
			$leads_update->bindValue( ':pd_rl_equipment_type', $pd_rl_equipment_type, PDO::PARAM_STR );
			$leads_update->bindValue( ':ewp_pd_frequency', service_freq_val( $ewp_pd_frequency ), PDO::PARAM_STR );
			$leads_update->bindValue( ':ewp_pd_volume', service_volume_val( $ewp_pd_volume ), PDO::PARAM_STR );
			$leads_update->bindValue( ':rs_itad_computers_servers', corresponding_combo_value( $rs_itad_computers_servers ), PDO::PARAM_STR );
			$leads_update->bindValue( ':rs_itad_tv_monitors', corresponding_combo_value( $rs_itad_tv_monitors ), PDO::PARAM_STR );
			$leads_update->bindValue( ':rs_itad_laptops_tablets', corresponding_combo_value( $rs_itad_laptops_tablets ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_additional_info', $all_additional_info, PDO::PARAM_STR );
			$leads_update->bindValue( ':all_asset_reporting', service_bool_val( $all_asset_reporting ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_certification', service_certification( $all_certification ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_selected_date', $all_selected_date, PDO::PARAM_STR );
			$leads_update->bindValue( ':all_fees', 0, PDO::PARAM_INT );
			$leads_update->bindValue( ':all_formal_policy', service_bool_val( $all_formal_policy ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_primary_objective', service_obj_val( $all_primary_objective ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_secondary_objective', service_obj_val( $all_secondary_objective ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_other_items', corresponding_combo_value( $all_other_items ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_additional_info', $all_additional_info, PDO::PARAM_STR );
			$leads_update->bindValue( ':uploaded_filename', $uploaded_filename, PDO::PARAM_STR );
			$leads_update->bindValue( ':sessionid', $session_id, PDO::PARAM_STR );
			$leads_update->bindValue( ':urlforwarding', $urlforwarding, PDO::PARAM_STR );
			if ( $first_name != '' && $email != '' ) {
				$leads_update->execute();
				session_regenerate_id();
			}
		} catch ( PDOException $e ) {
			$leads_db = new PDO(
				'mysql:host=127.0.0.1;dbname=wp_allgreenrecyc;charset=utf8mb4', 'allgreenrecyc', 'zbF7JpxMC0loskI4guHk', [
					PDO::ATTR_EMULATE_PREPARES => false,
					PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
				]
			);

			$stmt      = $leads_db->query( 'SELECT * FROM tblprocurementleads1 WHERE session_Id = "gformtitanium' . $form_id . date( 'dmy' ) . $sess_val . substr( strtolower( $email ), 0, 15 ) . '"' );
			$row_count = $stmt->rowCount();
			if ( $row_count == 0 ) {
				$leads_update = $leads_db->prepare(
					'INSERT INTO 
			tblprocurementleads1
			(stage,stage_time,first_name,last_name,email,phone,company,zip,ServiceSelection,IPAddress,session_Id,AGRpage,address,urlforwarding)
			VALUE (:stage,:stage_time, :first_name,:last_name,:email,:phone,:company,:zip,:service,:ip,:sessionid,:referrer,:address,:urlforwarding)'
				);
				$leads_update->bindValue( ':stage', 1, PDO::PARAM_INT );
				$leads_update->bindValue( ':stage_time', $now, PDO::PARAM_STR );
				$leads_update->bindValue( ':first_name', $first_name, PDO::PARAM_STR );
				$leads_update->bindValue( ':last_name', $last_name, PDO::PARAM_STR );
				$leads_update->bindValue( ':email', $email, PDO::PARAM_STR );
				$leads_update->bindValue( ':phone', $phone, PDO::PARAM_STR );
				$leads_update->bindValue( ':company', $company, PDO::PARAM_STR );
				$leads_update->bindValue( ':zip', $zip, PDO::PARAM_STR );
				$leads_update->bindValue( ':service', $service, PDO::PARAM_STR );
				$leads_update->bindValue( ':ip', $_ip_address, PDO::PARAM_STR );
				$leads_update->bindValue( ':sessionid', 'gformtitanium' . $form_id . date( 'dmy' ) . $sess_val . substr( strtolower( $email ), 0, 15 ), PDO::PARAM_STR );
				$leads_update->bindValue( ':referrer', $_referrer_url, PDO::PARAM_STR );
				$leads_update->bindValue( ':address', '', PDO::PARAM_STR );
				$leads_update->bindValue( ':urlforwarding', '', PDO::PARAM_STR );
				
				if ( $form_id != 12 ) {
					if ( $first_name != '' && $email != '' ) {
						$leads_update->execute();
					}
				}
			}
			$leads_update = $leads_db->prepare(
				'UPDATE tblprocurementleads1 SET
                stage = :stage,
                first_name = :first_name,
                last_name= :last_name,
                email= :email,
                phone= :phone,
                company = :company,
                zip = :zip,
                ServiceSelection = :service,
                IPAddress = :ip,
                stage_time = :stage_time,
                AutomaticScheduler = :automatic_scheduler,
                DD_OnSite = :dd_onsite,
                E_Organization = :e_organization,
                E_PrimaryPurpose = :e_primary_purpose,
                E_SecondaryPurpose = :e_secondary_purpose,
                E_PastEvent = :e_past_event,
                E_WasteCollected = :e_waste_collected,
                EWP_ShippingNeeds = :ewp_shipping_needs,
                ITAD_AssetInventoryList = :itad_assets,
                ITAD_DataProtection = :itad_data_protection,
                ITAD_JobTitle = :itad_job_title,
                ITAD_NumberOfEmployees =:itad_no_employees,
                OSS_MaxShredSize = :oss_max_size,
                OSS_RecordShredding = :oss_record_shred,
                OSS_WitnessShredding = :oss_witness_shred,
                PD_Method = :pd_method,
                RL_ExistingSolution = :rl_exist_solution,
                RL_MaterialCondition = :rl_material_condition,
                DD_OSS_CdDvdFloppy = :dd_oss_cd,
                DD_OSS_Computers = :dd_oss_computer,
                DD_OSS_CopyMachines = :dd_oss_copy,
                DD_OSS_HardDrives = :dd_oss_hard_drive,
                DD_OSS_Laptops = :dd_oss_laptops,
                DD_OSS_Servers = :dd_oss_servers,
                DD_OSS_SolidState = :dd_oss_solid_state,
                DD_OSS_Tablets = :dd_oss_tablets,
                DD_OSS_Tapes = :dd_oss_tapes,
                PD_RL_EquipmentType = :pd_rl_equipment_type,
                EWP_PD_Frequency = :ewp_pd_frequency,
                EWP_PD_Volume = :ewp_pd_volume,
                RS_ITAD_ComputersServers = :rs_itad_computers_servers,
                RS_ITAD_TelevisionsMonitors = :rs_itad_tv_monitors,
                RS_ITAD_LaptopsTablets = :rs_itad_laptops_tablets,
                ALL_AdditionalNotes = :all_additional_info,
                ALL_AssetReporting = :all_asset_reporting,
                ALL_Certification = :all_certification,
                ALL_Date = :all_selected_date,
                ALL_Fees = :all_fees,
                ALL_FormalPolicy = :all_formal_policy,
                ALL_PrimaryObjective = :all_primary_objective,
                ALL_SecondaryObjective = :all_secondary_objective,
                ALL_OtherItems = :all_other_items,
                UploadedFileName = :uploaded_filename,
				urlforwarding = :urlforwarding 
            WHERE session_Id = :sessionid'
			);
			$leads_update->bindValue( ':stage', 1, PDO::PARAM_INT );
			$leads_update->bindValue( ':stage_time', $now, PDO::PARAM_STR );
			$leads_update->bindValue( ':first_name', $first_name, PDO::PARAM_STR );
			$leads_update->bindValue( ':last_name', $last_name, PDO::PARAM_STR );
			$leads_update->bindValue( ':email', $email, PDO::PARAM_STR );
			$leads_update->bindValue( ':phone', $phone, PDO::PARAM_STR );
			$leads_update->bindValue( ':company', $company, PDO::PARAM_STR );
			$leads_update->bindValue( ':zip', $zip, PDO::PARAM_STR );
			$leads_update->bindValue( ':service', corresponding_service( $service ), PDO::PARAM_STR );
			$leads_update->bindValue( ':ip', $_ip_address, PDO::PARAM_STR );
			$leads_update->bindValue( ':automatic_scheduler', 0, PDO::PARAM_INT );
			$leads_update->bindValue( ':dd_onsite', service_bool_val( $dd_onsite ), PDO::PARAM_STR );
			$leads_update->bindValue( ':e_organization', service_event_org_val( $e_organization ), PDO::PARAM_STR );
			$leads_update->bindValue( ':e_primary_purpose', service_second_obj_val( $e_primary_purpose ), PDO::PARAM_STR );
			$leads_update->bindValue( ':e_secondary_purpose', service_second_obj_val( $e_secondary_purpose ), PDO::PARAM_STR );
			$leads_update->bindValue( ':e_past_event', service_bool_val( $e_past_event ), PDO::PARAM_STR );
			$leads_update->bindValue( ':e_waste_collected', service_event_collection_val( $e_waste_collected ), PDO::PARAM_STR );
			$leads_update->bindValue( ':ewp_shipping_needs', service_shipping_needs_val( $ewp_shipping_needs ), PDO::PARAM_STR );
			$leads_update->bindValue( ':itad_assets', service_bool_val( $itad_assets ), PDO::PARAM_STR );
			$leads_update->bindValue( ':itad_data_protection', service_bool_val( $itad_data_protection ), PDO::PARAM_STR );
			$leads_update->bindValue( ':itad_job_title', $itad_job_title, PDO::PARAM_STR );
			$leads_update->bindValue( ':itad_no_employees', $itad_no_employees, PDO::PARAM_STR );
			$leads_update->bindValue( ':oss_max_size', max_shred_size( $oss_max_size ), PDO::PARAM_STR );
			$leads_update->bindValue( ':oss_record_shred', service_bool_val( $oss_record_shred ), PDO::PARAM_STR );
			$leads_update->bindValue( ':oss_witness_shred', service_bool_val( $oss_witness_shred ), PDO::PARAM_STR );
			$leads_update->bindValue( ':pd_method', service_pd_method_val( $pd_method ), PDO::PARAM_STR );
			$leads_update->bindValue( ':rl_exist_solution', service_rl_existing_solution_val( $rl_exist_solution ), PDO::PARAM_STR );
			$leads_update->bindValue( ':rl_material_condition', service_rl_material_condition_val( $rl_material_condition ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_cd', corresponding_combo_value( $dd_oss_cd ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_computer', corresponding_combo_value( $dd_oss_computer ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_copy', corresponding_combo_value( $dd_oss_copy ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_hard_drive', corresponding_combo_value( $dd_oss_hard_drive ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_laptops', corresponding_combo_value( $dd_oss_laptops ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_servers', corresponding_combo_value( $dd_oss_servers ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_solid_state', corresponding_combo_value( $dd_oss_solid_state ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_tablets', corresponding_combo_value( $dd_oss_tablets ), PDO::PARAM_STR );
			$leads_update->bindValue( ':dd_oss_tapes', corresponding_combo_value( $dd_oss_tapes ), PDO::PARAM_STR );
			$leads_update->bindValue( ':pd_rl_equipment_type', $pd_rl_equipment_type, PDO::PARAM_STR );
			$leads_update->bindValue( ':ewp_pd_frequency', service_freq_val( $ewp_pd_frequency ), PDO::PARAM_STR );
			$leads_update->bindValue( ':ewp_pd_volume', service_volume_val( $ewp_pd_volume ), PDO::PARAM_STR );
			$leads_update->bindValue( ':rs_itad_computers_servers', corresponding_combo_value( $rs_itad_computers_servers ), PDO::PARAM_STR );
			$leads_update->bindValue( ':rs_itad_tv_monitors', corresponding_combo_value( $rs_itad_tv_monitors ), PDO::PARAM_STR );
			$leads_update->bindValue( ':rs_itad_laptops_tablets', corresponding_combo_value( $rs_itad_laptops_tablets ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_additional_info', $all_additional_info, PDO::PARAM_STR );
			$leads_update->bindValue( ':all_asset_reporting', service_bool_val( $all_asset_reporting ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_certification', service_certification( $all_certification ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_selected_date', $all_selected_date, PDO::PARAM_STR );
			$leads_update->bindValue( ':all_fees', 0, PDO::PARAM_INT );
			$leads_update->bindValue( ':all_formal_policy', service_bool_val( $all_formal_policy ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_primary_objective', service_obj_val( $all_primary_objective ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_secondary_objective', service_obj_val( $all_secondary_objective ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_other_items', corresponding_combo_value( $all_other_items ), PDO::PARAM_STR );
			$leads_update->bindValue( ':all_additional_info', $all_additional_info, PDO::PARAM_STR );
			$leads_update->bindValue( ':uploaded_filename', $uploaded_filename, PDO::PARAM_STR );
			$leads_update->bindValue( ':sessionid', $session_id, PDO::PARAM_STR );
			$leads_update->bindValue( ':urlforwarding', '', PDO::PARAM_STR );
			
			if ( $first_name != '' && $email != '' ) {
				$leads_update->execute();
				session_regenerate_id();
			}
		}

		update_uploaded_filename($entry, $session_id);
}

add_action( 'gform_after_submission', 'mok_leads_final_save', 10, 3 );
add_action( 'gform_partialentries_post_entry_updated', 'mok_leads_final_save', 10, 3 );

//created by AR on 7/20/2023 to update file name
function update_uploaded_filename($entry, $session_id){

	$uploaded_file_name = '';
	if($entry['form_id'] == 11 && !empty($entry['74'])){
		$uploaded_file_name = basename($entry['74']);

		$leads_db = new PDO(
			'mysql:host=allgreen.cmsfg3ols5pn.us-west-2.rds.amazonaws.com;dbname=allgreendb;charset=utf8mb4', 'root', 'ggA7LRiSrwis', [
				PDO::ATTR_EMULATE_PREPARES => false,
				PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
			]
		);

		$leads_update = $leads_db->prepare(
			'UPDATE tblprocurementleads SET
			UploadedFileName = :uploaded_filename
			WHERE session_Id = :sessionid'
		);
		$leads_update->bindValue( ':uploaded_filename', $uploaded_file_name, PDO::PARAM_STR );
		$leads_update->bindValue( ':sessionid', $session_id, PDO::PARAM_STR );
		$leads_update->execute();
		session_regenerate_id();

	}
	
}

function corresponding_service( $value ) {
	switch ( $value ) :
		case 'Recycling Services':
			$service = 1;
			break;
		case 'IT Asset Disposition':
			$service = 2;
			break;
		case 'Data Destruction':
			$service = 3;
			break;
		case 'On-Site Shredding':
			$service = 4;
			break;
		case 'E-Waste Collection Event':
			$service = 5;
			break;
		case 'Product Destruction':
			$service = 6;
			break;
		case 'Reverse Logistics':
			$service = 7;
			break;
		case 'Downstream Recycling "For E-Waste Collectors"':
			$service = 8;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}


/**
 * @param $value
 *
 * @return int|string
 */
function corresponding_combo_value( $value ) {
	switch ( $value ) :
		case 1:
			$val = 1;
			break;
		case 2:
			$val = 2;
			break;
		case 3:
			$val = 3;
			break;
		case 4:
			$val = 4;
			break;
		case '5 - 9':
			$val = 5;
			break;
		case '10 - 14':
			$val = 6;
			break;
		case '15 - 24':
			$val = 7;
			break;
		case '25 - 49':
			$val = 8;
			break;
		case '50+':
			$val = 9;
			break;
		default:
			$val = 0;
			break;
	endswitch;

	return $val;
}

/**
 * @param $value
 *
 * @return string
 */
function service_obj_val( $value ) {
	switch ( $value ) :
		case 'Centralized Process':
			$service = 1;
			break;
		case 'Certifications':
			$service = 2;
			break;
		case 'Data Security':
			$service = 3;
			break;
		case 'Local':
			$service = 4;
			break;
		case 'Name Confidentiality':
			$service = 5;
			break;
		case 'No Cost':
			$service = 6;
			break;
		case 'Quick Turnaround':
			$service = 7;
			break;
		case 'Reputable Company':
			$service = 8;
			break;
		case 'Responsible Recycling':
			$service = 9;
			break;
		case 'Save Money':
			$service = 10;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}

/**
 * @param $value
 *
 * @return string
 */
function service_bool_val( $value ) {
	return $value == 'Yes' ? 1 : 0;
}

/**
 * @param $value
 *
 * @return string
 */
function service_certification( $value ) {
	switch ( $value ) :
		case 'Advanced - R2 Responsible Recycling':
			$service = 1;
			break;
		case 'Basic - EPA & State Licensing':
			$service = 2;
			break;
		case 'Highest Standard - e-Stewards Certified':
			$service = 3;
			break;
		case 'None':
			$service = 4;
			break;
		case 'Other - Please specify in notes below.':
			$service = 5;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}

/**
 * @param $value
 *
 * @return string
 */
function max_shred_size( $value ) {
	switch ( $value ) :
		case 'No':
			$service = 1;
			break;
		case '3 inches':
			$service = 2;
			break;
		case '1 inch':
			$service = 3;
			break;
		case '1/2 inch':
			$service = 4;
			break;
		case '3/8 inch':
			$service = 5;
			break;
		case '8 mm':
			$service = 6;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}

/**
 * @param $value
 *
 * @return string
 */
function service_event_org_val( $value ) {
	switch ( $value ) :
		case 'Business Park':
			$service = 1;
			break;
		case 'Church':
			$service = 2;
			break;
		case 'City':
			$service = 3;
			break;
		case 'County':
			$service = 4;
			break;
		case 'Library':
			$service = 5;
			break;
		case 'Retail Center':
			$service = 6;
			break;
		case 'School':
			$service = 7;
			break;
		case 'Other For-Profit Organization':
			$service = 8;
			break;
		case 'Other Non-Profit Organizations':
			$service = 9;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}

/**
 * @param $value
 *
 * @return string
 */
function service_second_obj_val( $value ) {
	switch ( $value ) :
		case 'Advertisement or Marketing':
			$service = 1;
			break;
		case 'Environmental':
			$service = 2;
			break;
		case 'Foot Traffic':
			$service = 3;
			break;
		case 'Green Education':
			$service = 4;
			break;
		case 'Raise Funds':
			$service = 5;
			break;
		case 'Service to Tenants or Residence':
			$service = 6;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}

/**
 * @param $value
 *
 * @return string
 */
function service_pd_method_val( $value ) {
	switch ( $value ) :
		case 'Crushing':
			$service = 1;
			break;
		case 'Fine Shredding':
			$service = 2;
			break;
		case 'Manual Dismantling':
			$service = 3;
			break;
		case 'None':
			$service = 4;
			break;
		case 'Shredding':
			$service = 5;
			break;
		case 'Other - Please specify in notes below.':
			$service = 6;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}

/**
 * @param $value
 *
 * @return string
 */
function service_freq_val( $value ) {
	switch ( $value ) :
		case 'Weekly':
			$service = 1;
			break;
		case 'Monthly':
			$service = 2;
			break;
		case 'Quarterly':
			$service = 3;
			break;
		case 'Semi-Annually':
			$service = 4;
			break;
		case 'Annual':
			$service = 5;
			break;
		case 'Sporadic':
			$service = 6;
			break;
		case 'Other - Please specify in notes below.':
			$service = 7;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}

/**
 * @param $value
 *
 * @return string
 */
function service_volume_val( $value ) {
	switch ( $value ) :
		case '0 - 999 lbs':
			$service = 1;
			break;
		case '1,000 - 4,999 lbs':
			$service = 2;
			break;
		case '5,000 - 9,999 lbs':
			$service = 3;
			break;
		case '10,000 - 24,999 lbs':
			$service = 4;
			break;
		case '25,000 lbs or More':
			$service = 5;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}

/**
 * @param $value
 *
 * @return string
 */
function service_event_collection_val( $value ) {
	switch ( $value ) :
		case '0 - 5,000lbs':
			$service = 1;
			break;
		case '5,001 - 10,000 lbs':
			$service = 2;
			break;
		case '10,001 - 20,000 lbs':
			$service = 3;
			break;
		case '20,001 - 30,000 lbs':
			$service = 4;
			break;
		case '+ 30,000 lbs':
			$service = 5;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}

/**
 * @param $value
 *
 * @return string
 */
function service_rl_material_condition_val( $value ) {
	switch ( $value ) :
		case 'Defective':
			$service = 1;
			break;
		case 'Recalled':
			$service = 2;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}

/**
 * @param $value
 *
 * @return string
 */
function service_rl_existing_solution_val( $value ) {
	switch ( $value ) :
		case 'None':
			$service = 1;
			break;
		case 'In-House':
			$service = 2;
			break;
		case 'Outsourced':
			$service = 3;
			break;
		case 'Other - Please Specify in Notes':
			$service = 4;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}

/**
 * @param $value
 *
 * @return string
 */
function service_shipping_needs_val( $value ) {
	switch ( $value ) :
		case 'Delivery to our Facility':
			$service = 1;
			break;
		case 'Pickup from your Facility':
			$service = 2;
			break;
		case 'Other - Please specify in notes below':
			$service = 3;
			break;
		default:
			$service = 0;
			break;
	endswitch;

	return $service;
}

