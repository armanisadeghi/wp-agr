<?php

global $wpdb;
$table = getCategoryTableName();

if(isset($_POST['submit'])){
    
    $error = array();
	
	if(!ISSET($_POST['name']) || (ISSET($_POST['name']) && $_POST['name'] == ''))
	{
	    $error['name'] = 'Category name is required';
	}
	
	if(!ISSET($_POST['status']) || (ISSET($_POST['status']) && $_POST['status'] == ''))
	{
	    $error['status'] = 'Category status is required';
	}
	
	if(!ISSET($_POST['description']) || (ISSET($_POST['description']) && $_POST['description'] == ''))
	{
	    $error['description'] = 'Category description is required';
	}
	
	if(count($error) <= 0){
	    $category = $wpdb->get_results( "SELECT * FROM ".$table." where Name = '".$_POST['name']."' and ID != ".$_GET['id']);
    	if(count($category) > 0)
    	{
    		$error['name'] = 'Category name already exist';
    	}
    	else
    	{
    	   $data = array(
        	   'Name' => $_POST['name'],
        	   'Description' => $_POST['description'],
        	   'status' => $_POST['status'],
        	   'ShortCode' => '[faqcat name="'.$_POST['name'].'"]'
        	);
        	  
        	$format = array(
        		 '%s',
        		 '%s',
        		 '%s',
        		 '%s'
        	);
        	
        	$where = array(
        		'ID' => $_GET['id']
        	);
        	
        	$success=$wpdb->update( $table, $data, $where, $format );
    	}
	}
	if($success){
		setFlashData('success','Category updated');
		echo '<script>window.location.href="'.admin_url("admin.php?page=Manage_Categories").'"</script>';
	}
	else{
		setFlashData('error','Something went wrong. Please try again');
		$_SESSION['error_validations'] = $error;
		$_SESSION['old_input'] = $_POST;
		echo '<script>window.location.reload()</script>';
		exit;
	}
}

$category = $wpdb->get_results( "SELECT * FROM ".$table." where ID = ".$_GET['id']);
if(count($category) <= 0)
{
	setFlashData('error','Category not found');
	echo '<script>window.location.href="'.admin_url("admin.php?page=Manage_Categories").'"</script>';
}

$validation_errors = (ISSET($_SESSION['error_validations'])) ? $_SESSION['error_validations'] : '';
unset($_SESSION['error_validations']);
$old_inputs = (ISSET($_SESSION['old_input'])) ? $_SESSION['old_input'] : '';
unset($_SESSION['old_input']);

?>
<div class="container">
  <h2>Edit Category Form</h2>
  <form action ="<?php echo $_SERVER['REQUEST_URI']; ?>" method ="post">
    <div class="form-group">
      <label for="catname">Category Name:</label>
      <input type="text" class="form-control" id="name" value="<?php echo $category[0]->Name ?>" placeholder="Enter Name" name="name">
      <?php if($validation_errors != '' && ISSET($validation_errors['name'])){ ?>
          <span style="color:red;"><?php echo $validation_errors['name']; ?></span>
      <?php } ?><br>
      <label for="catname">Category Description:</label>
      <textarea type="text" class="form-control" id="description" placeholder="Enter Description" name="description"><?php echo $category[0]->Description; ?></textarea>
      <?php if($validation_errors != '' && ISSET($validation_errors['description'])){ ?>
          <span style="color:red;"><?php echo $validation_errors['description']; ?></span>
      <?php } ?><br>
      <label for="catname">Category Status:</label><br>
      <select name="status">
          <option <?php echo ($category[0]->Status == 0) ? 'selected="selected"' : ''; ?> value="0">Disabled</option>
          <option <?php echo ($category[0]->Status == 1) ? 'selected="selected"' : ''; ?> value="1">Enabled</option>
      </select>
      <?php if($validation_errors != '' && ISSET($validation_errors['status'])){ ?>
          <span style="color:red;"><?php echo $validation_errors['status']; ?></span>
      <?php } ?>
    </div>
    <button type="submit" name="submit" class="btn btn-default">Submit</button>
  </form>
</div>