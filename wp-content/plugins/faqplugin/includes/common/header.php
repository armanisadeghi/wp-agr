<!DOCTYPE html>
<html>
<head>
<title>FAQ Plugin</title>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!------------ data table style start ------------------------->
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
   
    <!------------ data table style start ------------------------->
	
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  
  
  
  <!------------ data table script start ------------------------->
   <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	 <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
  <script>
	$(document).ready(function() {
		$('.data-table').DataTable({
			"bSort" : false
		});
	});
	
	function confirmAction(url)
	{
		var confirmation = confirm('Do you want to proceed?');
		if(confirmation)
		{
			window.location.href = url;
		}
		else
		{
			return false;
		}
	}
</script>
  
 <!------------ data table script End ------------------------->
</head>   
<body>
<br>

<?php
	$success = getFlashData('success');
	if($success != '')
	{
?>
	<div class="alert alert-success"><?php echo $success; ?></div>
<?php
	}
?>

<?php
	$error = getFlashData('error');
	if($error != '')
	{
?>
	<div class="alert alert-danger"><?php echo $error; ?></div>
<?php
	}
?>