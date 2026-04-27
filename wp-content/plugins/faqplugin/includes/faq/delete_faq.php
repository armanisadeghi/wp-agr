<?php

global $wpdb;
$table = getFaqTableName();

$category = $wpdb->get_results( "SELECT * FROM ".$table." where ID = ".$_GET['id']);
if(count($category) <= 0)
{
	setFlashData('error','FAQ not found');
	echo '<script>window.location.href="'.admin_url("admin.php?page=Manage_FAQs").'"</script>';
}

$where = array(
	'ID' => $_GET['id']
);

$success=$wpdb->delete( $table, $where );

if($success){
	setFlashData('success','FAQ deleted');
	echo '<script>window.location.href="'.admin_url("admin.php?page=Manage_FAQs").'"</script>';
}
else{
	setFlashData('error','Something went wrong. Please try again');
	echo '<script>window.location.reload()</script>';
}

?>