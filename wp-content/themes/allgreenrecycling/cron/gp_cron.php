<?php
	global $wpdb;
	$_table_name = 'tblprocurementleads1';
	$_results = $wpdb->get_results( "SELECT * FROM $_table_name where IsInsertedInGP='N'");
	try {
		$leads_db = new PDO( 'mysql:host=allgreen.cmsfg3ols5pn.us-west-2.rds.amazonaws.com;dbname=allgreendb;charset=utf8mb4', 'root', 'ggA7LRiSrwis',[
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION
		] );
		foreach($_results as $_result)
		{
			$now = $_result->Stage_Time;
			$first_name = $_result->first_name;
			$last_name = $_result->last_name;
			$email = $_result->email;
			$phone = $_result->phone;
			$company = $_result->company;
			$zip = $_result->zip;
			$service = $_result->ServiceSelection;
			$ip_address = $_result->IPAddress;
			$session_id = $_result->session_Id;
			$referrer_url = $_result->AGRpage;
			$dd_onsite             = $_result->DD_OnSite;
			$e_organization        = $_result->E_Organization;
			$e_primary_purpose     = $_result->E_PrimaryPurpose;
			$e_secondary_purpose   = $_result->E_SecondaryPurpose;
			$e_past_event          = $_result->E_PastEvent;
			$e_waste_collected     = $_result->E_WasteCollected;
			$ewp_shipping_needs    = $_result->EWP_ShippingNeeds;
			$itad_assets           = $_result->ITAD_AssetInventoryList;
			$itad_data_protection  = $_result->ITAD_DataProtection;
			$itad_job_title        = $_result->ITAD_JobTitle;
			$itad_no_employees     = $_result->ITAD_NumberOfEmployees;
			$oss_max_size          = $_result->OSS_MaxShredSize;
			$oss_record_shred      = $_result->OSS_RecordShredding;
			$oss_witness_shred     = $_result->OSS_WitnessShredding;
			$pd_method             = $_result->PD_Method;
			$rl_exist_solution     = $_result->RL_ExistingSolution;
			$rl_material_condition = $_result->RL_MaterialCondition;
			$dd_oss_cd             = $_result->DD_OSS_CdDvdFloppy;
			$dd_oss_computer       = $_result->DD_OSS_Computers;
			$dd_oss_copy           = $_result->DD_OSS_CopyMachines;
			$dd_oss_hard_drive     = $_result->DD_OSS_HardDrives;
			$dd_oss_laptops        = $_result->DD_OSS_Laptops;
			$dd_oss_servers        = $_result->DD_OSS_Servers;
			$dd_oss_solid_state    = $_result->DD_OSS_SolidState;
			$dd_oss_tablets        = $_result->DD_OSS_Tablets;
			$dd_oss_tapes          = $_result->DD_OSS_Tapes;
			$pd_rl_equipment_type = $_result->PD_RL_EquipmentType;
			$ewp_pd_frequency          = $_result->EWP_PD_Frequency;
			$ewp_pd_volume             = $_result->EWP_PD_Volume;
			$rs_itad_computers_servers = $_result->RS_ITAD_ComputersServers;
			$rs_itad_tv_monitors       = $_result->RS_ITAD_TelevisionsMonitors;
			$rs_itad_laptops_tablets   = $_result->RS_ITAD_LaptopsTablets;
			$all_additional_info       = $_result->ALL_AdditionalNotes;
			$all_asset_reporting       = $_result->ALL_AssetReporting;
			$all_certification         = $_result->ALL_Certification;
			$all_selected_date         = $_result->ALL_Date;
			$all_formal_policy         = $_result->ALL_FormalPolicy;
			$all_primary_objective     = $_result->ALL_PrimaryObjective;
			$all_secondary_objective   = $_result->ALL_SecondaryObjective;
			$all_other_items           = $_result->ALL_OtherItems;
			$uploaded_filename         = $_result->UploadedFileName;
			 
			$stmt = $leads_db->query( 'SELECT * FROM tblprocurementleads WHERE session_Id = "'.$session_id.'" ');
			$row_count = $stmt->rowCount();

			if ( $row_count == 0 ){
				$leads_update = $leads_db->prepare( "INSERT INTO 
					tblprocurementleads
					(stage,stage_time,first_name,last_name,email,phone,company,zip,ServiceSelection,IPAddress,session_Id,AGRpage,address)
					VALUE (:stage,:stage_time, :first_name,:last_name,:email,:phone,:company,:zip,:service,:ip,:sessionid,:referrer,:address)" 
				);

				$leads_update->bindValue( ':stage', 1, PDO::PARAM_INT );
				$leads_update->bindValue( ':stage_time', $now, PDO::PARAM_STR );
				$leads_update->bindValue( ':first_name', $first_name, PDO::PARAM_STR );
				$leads_update->bindValue( ':last_name', $last_name, PDO::PARAM_STR );
				$leads_update->bindValue( ':email', $email, PDO::PARAM_STR );
				$leads_update->bindValue( ':phone', $phone, PDO::PARAM_STR );
				$leads_update->bindValue( ':company', $company, PDO::PARAM_STR );
				$leads_update->bindValue( ':zip', $zip, PDO::PARAM_STR );
				$leads_update->bindValue( ':service', $service , PDO::PARAM_STR );
				$leads_update->bindValue( ':ip', $ip_address, PDO::PARAM_STR );
				$leads_update->bindValue( ':sessionid', $session_id , PDO::PARAM_STR );
				$leads_update->bindValue( ':referrer', $referrer_url, PDO::PARAM_STR );
				$leads_update->bindValue( ':address', '', PDO::PARAM_STR );

				if ( $first_name != '' && $email != '') {
					$leads_update->execute();
					$wpdb->update('tblprocurementleads1', array('IsInsertedInGP'=>'Y'), array('session_id'=>$session_id));
				}
			}
		}

		$leads_update = $leads_db->prepare( "UPDATE tblprocurementleads SET
			stage = :stage,
            first_name = :first_name,
            last_name = :last_name,
            email = :email,
            phone = :phone,
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
            ITAD_NumberOfEmployees = :itad_no_employees,
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

            WHERE session_Id = :sessionid" 
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
		$leads_update->bindValue( ':ip', $ip_address, PDO::PARAM_STR );
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
		$leads_update->bindValue( ':oss_max_size',$oss_max_size, PDO::PARAM_STR );
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
		$leads_update->bindValue( ':all_additional_info', $all_additional_info, PDO::PARAM_STR );
		$leads_update->bindValue( ':uploaded_filename', $uploaded_filename, PDO::PARAM_STR );
		$leads_update->bindValue( ':sessionid',$session_id, PDO::PARAM_STR );
		
		if ( $first_name != '' && $email != '') {
			$leads_update->execute();
		}
	} catch ( PDOException $e ) {
		echo $e->getMessage();
		return;
	}
?>