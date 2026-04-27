<?php

/**
 * Divide name into first and last name
 *
 * @param string $name name from input value
 * @param int $is_first Returns first name is set 1 else last name
 *
 * @return string
 */
function divide_name( $name, $is_first = 1 ) {
	$val   = explode( " ", $name );
	$value = array_shift( $val );

	return trim( $is_first ? $value : implode( " ", $val ) );
}

/**
 * Insert information from first step in gravity form to green pulse server
 *
 * @param array $partial_entry partial entry information from form
 * @param $form
 */
function mok_leads_initial_save( $partial_entry, $form ) {

	try {
		$leads_db = new PDO( 'mysql:host=gp.allgreenrecycling.com;dbname=allgreendb;charset=utf8mb4', 'allgreen1234', 'cp7EjwSquPMEZtdY', [
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION
		] );
	} catch ( PDOException $e ) {
		echo $e->getMessage();
		return;
		
	}
	try {
		$datetime     = new DateTime( 'now', new DateTimeZone( get_option( 'timezone_string' ) ) );
		$now          = $datetime->format( 'Y/m/d H:i:s' );
		$first_name   = array_key_exists( '1.3', $partial_entry ) ? divide_name( $partial_entry['1.3'] ) : '';
		$last_name    = array_key_exists( '1.3', $partial_entry ) ? divide_name( $partial_entry['1.3'], 0 ) : '';
		$email        = array_key_exists( '3', $partial_entry ) ? $partial_entry['3'] : '';
		$phone        = array_key_exists( '4', $partial_entry ) ? $partial_entry['4'] : '';
		$company      = array_key_exists( '2', $partial_entry ) ? $partial_entry['2'] : '';
		$zip          = array_key_exists( '5.5', $partial_entry ) ? $partial_entry['5.5'] : '';
		$leads_update = $leads_db->prepare( "INSERT INTO 
tblprocurementleads 
(stage,stage_time,first_name,last_name,email,phone,company,zip,ServiceSelection,IPAddress,session_Id,AGRpage,address)
VALUE (:stage,:stage_time, :first_name,:last_name,:email,:phone,:company,:zip,:service,:ip,:sessionid,:referrer,:address)" );
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
		$leads_update->bindValue( ':sessionid', 'gformtitanium' . date( 'dmy' ) . substr( $partial_entry['3'], 0, 25 ), PDO::PARAM_STR );
		$leads_update->bindValue( ':referrer', $partial_entry['source_url'], PDO::PARAM_STR );
		$leads_update->bindValue( ':address', '', PDO::PARAM_STR );
		if ( $first_name != '' && $email != '' && $partial_entry['id'] != '' ) {
			$stmt      = $leads_db->query( 'SELECT * FROM tblprocurementleads WHERE session_Id = "gformtitanium' . date( 'dmy' ) . substr( strtolower( $partial_entry['3'] ), 0, 25 ) . '"' );
			$row_count = $stmt->rowCount();
			if ( $row_count == 0 ):
				$leads_update->execute();
			endif;
		}
	} catch ( PDOException $e ) {
		echo $e->getMessage();
		
		exit;
	}
}

add_action( 'gform_partialentries_post_entry_saved', 'mok_leads_initial_save', 10, 2 );

/**
 * Insert information from last step in gravity form to green pulse server
 *
 * @param array $partial_entry partial entry information from form
 * @param $form
 */
function mok_leads_final_save( $partial_entry, $form ) {
	try {
		$leads_db = new PDO( 'mysql:host=gp.allgreenrecycling.com;dbname=allgreendb;charset=utf8mb4', 'allgreen1234', 'cp7EjwSquPMEZtdY', [
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION
		] );
	} catch ( PDOException $e ) {
		echo $e->getMessage();
		return;
		
	}
	try {
		$datetime              = new DateTime( 'now', new DateTimeZone( get_option( 'timezone_string' ) ) );
		$now                   = $datetime->format( 'Y/m/d H:i:s' );
		$stage                 = $partial_entry['partial_entry_percent'] != '' ? 1 : 2;
		$first_name            = array_key_exists( '1.3', $partial_entry ) ? divide_name( $partial_entry['1.3'] ) : '';
		$last_name             = array_key_exists( '1.3', $partial_entry ) ? divide_name( $partial_entry['1.3'], 0 ) : '';
		$email                 = array_key_exists( '3', $partial_entry ) ? $partial_entry['3'] : '';
		$phone                 = array_key_exists( '4', $partial_entry ) ? $partial_entry['4'] : '';
		$company               = array_key_exists( '2', $partial_entry ) ? $partial_entry['2'] : '';
		$zip                   = array_key_exists( '5.5', $partial_entry ) ? $partial_entry['5.5'] : '';
		$service               = array_key_exists( '7', $partial_entry ) ? corresponding_service( $partial_entry[7] ) : '';
		$dd_onsite             = array_key_exists( '15', $partial_entry ) ? service_bool_val( $partial_entry[15] ) : 0;
		$e_organization        = array_key_exists( '38', $partial_entry ) ? service_event_org_val( $partial_entry[38] ) : 0;
		$e_primary_purpose     = array_key_exists( '39', $partial_entry ) ? service_second_obj_val( $partial_entry[39] ) : 0;
		$e_secondary_purpose   = array_key_exists( '40', $partial_entry ) ? service_second_obj_val( $partial_entry[40] ) : 0;
		$e_past_event          = array_key_exists( '41', $partial_entry ) ? service_bool_val( $partial_entry[41] ) : 0;
		$e_waste_collected     = array_key_exists( '49', $partial_entry ) ? service_event_collection_val( $partial_entry[49] ) : 0;
		$ewp_shipping_needs    = array_key_exists( '51', $partial_entry ) ? service_shipping_needs_val( $partial_entry[51] ) : 0;
		$itad_assets           = array_key_exists( '18', $partial_entry ) ? service_bool_val( $partial_entry[18] ) : 0;
		$itad_data_protection  = array_key_exists( '15', $partial_entry ) ? service_bool_val( $partial_entry[15] ) : 0;
		$itad_job_title        = array_key_exists( '19', $partial_entry ) ? $partial_entry[19] : 0;
		$itad_no_employees     = array_key_exists( '20', $partial_entry ) ? $partial_entry[20] : 0;
		$oss_max_size          = array_key_exists( '35', $partial_entry ) ? max_shred_size( $partial_entry[35] ) : 0;
		$oss_record_shred      = array_key_exists( '37', $partial_entry ) ? service_bool_val( $partial_entry[37] ) : 0;
		$oss_witness_shred     = array_key_exists( '36', $partial_entry ) ? service_bool_val( $partial_entry[36] ) : 0;
		$pd_method             = array_key_exists( '44', $partial_entry ) ? service_pd_method_val( $partial_entry[44] ) : 0;
		$rl_exist_solution     = array_key_exists( '50', $partial_entry ) ? service_rl_existing_solution_val( $partial_entry[50] ) : 0;
		$rl_material_condition = array_key_exists( '48', $partial_entry ) ? service_rl_material_condition_val( $partial_entry[48] ) : 0;
		$dd_oss_cd             = array_key_exists( '31', $partial_entry ) ? corresponding_combo_value( $partial_entry[31] ) : 0;
		$dd_oss_computer       = array_key_exists( '23', $partial_entry ) ? corresponding_combo_value( $partial_entry[23] ) : 0;
		$dd_oss_copy           = array_key_exists( '29', $partial_entry ) ? corresponding_combo_value( $partial_entry[29] ) : 0;
		$dd_oss_hard_drive     = array_key_exists( '27', $partial_entry ) ? corresponding_combo_value( $partial_entry[27] ) : 0;
		$dd_oss_laptops        = array_key_exists( '25', $partial_entry ) ? corresponding_combo_value( $partial_entry[25] ) : 0;
		$dd_oss_servers        = array_key_exists( '24', $partial_entry ) ? corresponding_combo_value( $partial_entry[24] ) : 0;
		$dd_oss_solid_state    = array_key_exists( '30', $partial_entry ) ? corresponding_combo_value( $partial_entry[30] ) : 0;
		$dd_oss_tablets        = array_key_exists( '26', $partial_entry ) ? corresponding_combo_value( $partial_entry[26] ) : 0;
		$dd_oss_tapes          = array_key_exists( '28', $partial_entry ) ? corresponding_combo_value( $partial_entry[28] ) : 0;
		if ( array_key_exists( '43', $partial_entry ) ):
			$pd_rl_equipment_type = $partial_entry[43];
		else:
			$pd_rl_equipment_type = array_key_exists( '47', $partial_entry ) ? $partial_entry[47] : '';
		endif;
		$ewp_pd_frequency          = array_key_exists( '45', $partial_entry ) ? service_freq_val( $partial_entry[45] ) : 0;
		$ewp_pd_volume             = array_key_exists( '46', $partial_entry ) ? service_volume_val( $partial_entry[46] ) : 0;
		$rs_itad_computers_servers = array_key_exists( '14', $partial_entry ) ? corresponding_combo_value( $partial_entry[14] ) : 0;
		$rs_itad_tv_monitors       = array_key_exists( '10', $partial_entry ) ? corresponding_combo_value( $partial_entry[10] ) : 0;
		$rs_itad_laptops_tablets   = array_key_exists( '11', $partial_entry ) ? corresponding_combo_value( $partial_entry[11] ) : 0;
		$all_additional_info       = array_key_exists( '13', $partial_entry ) ? $partial_entry[13] : '';
		$all_asset_reporting       = array_key_exists( '16', $partial_entry ) ? service_bool_val( $partial_entry[16] ) : 0;
		$all_certification         = array_key_exists( '17', $partial_entry ) ? service_certification( $partial_entry[17] ) : 0;
		$all_selected_date         = array_key_exists( '33', $partial_entry ) ? $partial_entry[33] : '';
		$all_formal_policy         = array_key_exists( '34', $partial_entry ) ? service_bool_val( $partial_entry[34] ) : 0;
		$all_primary_objective     = array_key_exists( '9', $partial_entry ) ? service_obj_val( $partial_entry[9] ) : 0;
		$all_secondary_objective   = array_key_exists( '22', $partial_entry ) ? service_obj_val( $partial_entry[22] ) : 0;
		$all_other_items           = array_key_exists( '12', $partial_entry ) ? corresponding_combo_value( $partial_entry[12] ) : 0;
		$uploaded_filename         = array_key_exists( '18', $partial_entry ) ? json_decode( $partial_entry[18] )[0] : '';
		$stmt                      = $leads_db->query( 'SELECT * FROM tblprocurementleads WHERE session_Id = "gformtitanium' . date( 'dmy' ) . substr( strtolower( $partial_entry['3'] ), 0, 25 ) . '"' );
		$row_count                 = $stmt->rowCount();
		if ( $row_count == 0 ):
			$leads_update = $leads_db->prepare( "INSERT INTO 
tblprocurementleads 
(stage,stage_time,first_name,last_name,email,phone,company,zip,ServiceSelection,IPAddress,session_Id,AGRpage,address)
VALUE (:stage,:stage_time, :first_name,:last_name,:email,:phone,:company,:zip,:service,:ip,:sessionid,:referrer,:address)" );
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
			$leads_update->bindValue( ':sessionid', 'gformtitanium' . date( 'dmy' ) . substr( strtolower( $partial_entry['3'] ), 0, 25 ), PDO::PARAM_STR );
			$leads_update->bindValue( ':referrer', $partial_entry['source_url'], PDO::PARAM_STR );
			$leads_update->bindValue( ':address', '', PDO::PARAM_STR );
			if ( $first_name != '' && $email != '' && $partial_entry['id'] != '' ) {
				$leads_update->execute();
			}
		endif;
		$leads_update = $leads_db->prepare( "UPDATE tblprocurementleads SET
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
                UploadedFileName = :uploaded_filename
            WHERE session_Id = :sessionid" );
		$leads_update->bindValue( ':stage', $stage, PDO::PARAM_INT );
		$leads_update->bindValue( ':stage_time', $now, PDO::PARAM_STR );
		$leads_update->bindValue( ':first_name', $first_name, PDO::PARAM_STR );
		$leads_update->bindValue( ':last_name', $last_name, PDO::PARAM_STR );
		$leads_update->bindValue( ':email', $email, PDO::PARAM_STR );
		$leads_update->bindValue( ':phone', $phone, PDO::PARAM_STR );
		$leads_update->bindValue( ':company', $company, PDO::PARAM_STR );
		$leads_update->bindValue( ':zip', $zip, PDO::PARAM_STR );
		$leads_update->bindValue( ':service', $service, PDO::PARAM_STR );
		$leads_update->bindValue( ':ip', $partial_entry['ip'], PDO::PARAM_STR );
		$leads_update->bindValue( ':automatic_scheduler', 0, PDO::PARAM_INT );
		$leads_update->bindValue( ':dd_onsite', $dd_onsite, PDO::PARAM_STR );
		$leads_update->bindValue( ':e_organization', $e_organization, PDO::PARAM_STR );
		$leads_update->bindValue( ':e_primary_purpose', $e_primary_purpose, PDO::PARAM_STR );
		$leads_update->bindValue( ':e_secondary_purpose', $e_secondary_purpose, PDO::PARAM_STR );
		$leads_update->bindValue( ':e_past_event', $e_past_event, PDO::PARAM_STR );
		$leads_update->bindValue( ':e_waste_collected', $e_waste_collected, PDO::PARAM_STR );
		$leads_update->bindValue( ':ewp_shipping_needs', $ewp_shipping_needs, PDO::PARAM_STR );
		$leads_update->bindValue( ':itad_assets', $itad_assets, PDO::PARAM_STR );
		$leads_update->bindValue( ':itad_data_protection', $itad_data_protection, PDO::PARAM_STR );
		$leads_update->bindValue( ':itad_job_title', $itad_job_title, PDO::PARAM_STR );
		$leads_update->bindValue( ':itad_no_employees', $itad_no_employees, PDO::PARAM_STR );
		$leads_update->bindValue( ':oss_max_size', $oss_max_size, PDO::PARAM_STR );
		$leads_update->bindValue( ':oss_record_shred', $oss_record_shred, PDO::PARAM_STR );
		$leads_update->bindValue( ':oss_witness_shred', $oss_witness_shred, PDO::PARAM_STR );
		$leads_update->bindValue( ':pd_method', $pd_method, PDO::PARAM_STR );
		$leads_update->bindValue( ':rl_exist_solution', $rl_exist_solution, PDO::PARAM_STR );
		$leads_update->bindValue( ':rl_material_condition', $rl_material_condition, PDO::PARAM_STR );
		$leads_update->bindValue( ':dd_oss_cd', $dd_oss_cd, PDO::PARAM_STR );
		$leads_update->bindValue( ':dd_oss_computer', $dd_oss_computer, PDO::PARAM_STR );
		$leads_update->bindValue( ':dd_oss_copy', $dd_oss_copy, PDO::PARAM_STR );
		$leads_update->bindValue( ':dd_oss_hard_drive', $dd_oss_hard_drive, PDO::PARAM_STR );
		$leads_update->bindValue( ':dd_oss_laptops', $dd_oss_laptops, PDO::PARAM_STR );
		$leads_update->bindValue( ':dd_oss_servers', $dd_oss_servers, PDO::PARAM_STR );
		$leads_update->bindValue( ':dd_oss_solid_state', $dd_oss_solid_state, PDO::PARAM_STR );
		$leads_update->bindValue( ':dd_oss_tablets', $dd_oss_tablets, PDO::PARAM_STR );
		$leads_update->bindValue( ':dd_oss_tapes', $dd_oss_tapes, PDO::PARAM_STR );
		$leads_update->bindValue( ':pd_rl_equipment_type', $pd_rl_equipment_type, PDO::PARAM_STR );
		$leads_update->bindValue( ':ewp_pd_frequency', $ewp_pd_frequency, PDO::PARAM_STR );
		$leads_update->bindValue( ':ewp_pd_volume', $ewp_pd_volume, PDO::PARAM_STR );
		$leads_update->bindValue( ':rs_itad_computers_servers', $rs_itad_computers_servers, PDO::PARAM_STR );
		$leads_update->bindValue( ':rs_itad_tv_monitors', $rs_itad_tv_monitors, PDO::PARAM_STR );
		$leads_update->bindValue( ':rs_itad_laptops_tablets', $rs_itad_laptops_tablets, PDO::PARAM_STR );
		$leads_update->bindValue( ':all_additional_info', $all_additional_info, PDO::PARAM_STR );
		$leads_update->bindValue( ':all_asset_reporting', $all_asset_reporting, PDO::PARAM_STR );
		$leads_update->bindValue( ':all_certification', $all_certification, PDO::PARAM_STR );
		$leads_update->bindValue( ':all_selected_date', $all_selected_date, PDO::PARAM_STR );
		$leads_update->bindValue( ':all_fees', 0, PDO::PARAM_INT );
		$leads_update->bindValue( ':all_formal_policy', $all_formal_policy, PDO::PARAM_STR );
		$leads_update->bindValue( ':all_primary_objective', $all_primary_objective, PDO::PARAM_STR );
		$leads_update->bindValue( ':all_secondary_objective', $all_secondary_objective, PDO::PARAM_STR );
		$leads_update->bindValue( ':all_other_items', $all_other_items, PDO::PARAM_STR );
		$leads_update->bindValue( ':uploaded_filename', $uploaded_filename, PDO::PARAM_STR );
		$leads_update->bindValue( ':sessionid', 'gformtitanium' . date( 'dmy' ) . substr( strtolower( $partial_entry['3'] ), 0, 25 ), PDO::PARAM_STR );
		if ( $first_name != '' && $email != '' && $partial_entry['id'] != '' ) {
			$leads_update->execute();
		}
	} catch ( PDOException $ex ) {
		echo $ex->getMessage();
	}

}

add_action( 'gform_after_submission_11', 'mok_leads_final_save', 10, 2 );
add_action( 'gform_partialentries_post_entry_updated', 'mok_leads_final_save', 10, 2 );

/**
 * @param $value
 *
 * @return int
 */
function corresponding_service( $value ) {
	switch ( $value ):
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
	switch ( $value ):
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
	switch ( $value ):
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
	switch ( $value ):
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
	switch ( $value ):
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
	switch ( $value ):
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
	switch ( $value ):
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
	switch ( $value ):
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
	switch ( $value ):
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
	switch ( $value ):
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
	switch ( $value ):
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
	switch ( $value ):
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
	switch ( $value ):
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
	switch ( $value ):
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
