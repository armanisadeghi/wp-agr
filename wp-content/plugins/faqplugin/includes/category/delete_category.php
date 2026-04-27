<?php

global $wpdb;
$table = getCategoryTableName();

$category = $wpdb->get_results( "SELECT * FROM ".$table." where ID = ".$_GET['id']);
if(count($category) <= 0)
{
	setFlashData('error','Category not found');
	echo '<script>window.location.href="'.admin_url("admin.php?page=Manage_Categories").'"</script>';
}

$where = array(
	'ID' => $_GET['id']
);

$success=$wpdb->delete( $table, $where );

if($success){
	setFlashData('success','Category deleted');
	echo '<script>window.location.href="'.admin_url("admin.php?page=Manage_Categories").'"</script>';
}
else{
	setFlashData('error','Something went wrong. Please try again');
	echo '<script>window.location.reload()</script>';
}

?>