<?php
	global $wpdb;
	$_table_name = 'tblprocurementleads1';
	$_delete_record = $wpdb->delete( $_table_name, array( 'IsInsertedInGP' => 'Y' ) );
?>