<?php

global $wpdb;
$table = getFaqTableName();
$category_table = getCategoryTableName();

if(isset($_POST['submit'])){
    
    $error = array();
	
	if(!ISSET($_POST['qes']) || (ISSET($_POST['qes']) && $_POST['qes'] == ''))
	{
	    $error['qes'] = 'FAQ question is required';
	}
	
	if(!ISSET($_POST['ans']) || (ISSET($_POST['ans']) && $_POST['ans'] == ''))
	{
	    $error['ans'] = 'FAQ answer is required';
	}
	
	if(!ISSET($_POST['status']) || (ISSET($_POST['status']) && $_POST['status'] == ''))
	{
	    $error['status'] = 'FAQ status is required';
	}
	
	if(!ISSET($_POST['category_id']) || (ISSET($_POST['category_id']) && $_POST['category_id'] == ''))
	{
	    $error['category_id'] = 'FAQ category is required';
	}
	
	if(count($error) <= 0){
	   $data = array(
    	   'Question' => $_POST['qes'],
    	   'Answer' => $_POST['ans'],
    	   'Status' => $_POST['status'],
    	   'Category_id' => $_POST['category_id'],
    	   'ShortCode' => '[faqcat name="'.$_POST['qes'].'"]'
    	);
    	  
    	$format = array(
    		 '%s',
    		 '%s',
    		 '%s',
    		 '%s',
    		 '%s'
    	);
    	$success=$wpdb->insert( $table, $data, $format );
	}
	
	if($success){
		setFlashData('success','FAQ added');
		echo '<script>window.location.href="'.admin_url("admin.php?page=Manage_FAQs").'"</script>';
	}
	else{
		setFlashData('error','Something went wrong. Please try again');
		$_SESSION['error_validations'] = $error;
		$_SESSION['old_input'] = $_POST;
		echo '<script>window.location.reload()</script>';
		exit;
	}
}

$validation_errors = (ISSET($_SESSION['error_validations'])) ? $_SESSION['error_validations'] : '';
unset($_SESSION['error_validations']);
$old_inputs = (ISSET($_SESSION['old_input'])) ? $_SESSION['old_input'] : '';
unset($_SESSION['old_input']);

$categories = $wpdb->get_results( "SELECT * FROM ".$category_table);

?>
<div class="container">
  <h2>Add FAQ Form</h2>
  <form action ="<?php echo $_SERVER['REQUEST_URI']; ?>" method ="post">
    <div class="form-group">
      <label for="qes"> Question:</label>
      <input type="text" class="form-control" id="qes" placeholder="Enter question" name="qes">
      <?php if($validation_errors != '' && ISSET($validation_errors['qes'])){ ?>
          <span style="color:red;"><?php echo $validation_errors['qes']; ?></span>
      <?php } ?>
    </div>
   <div class="form-group">
      <label for="ans"> Answer:</label>
      <input type="text" class="form-control" id="ans" placeholder="Enter Answer" name="ans">
      <?php if($validation_errors != '' && ISSET($validation_errors['ans'])){ ?>
          <span style="color:red;"><?php echo $validation_errors['ans']; ?></span>
      <?php } ?>
    </div>
    <div class="form-group">
      <label for="catname">FAQ Category:</label><br>
      <select class="form-control" name="category_id">
          <option value="">Select Category</option>
          <?php foreach($categories as $category){ ?>
            <option value="<?php echo $category->ID; ?>"><?php echo $category->Name; ?></option>
          <?php } ?>
      </select>
      <?php if($validation_errors != '' && ISSET($validation_errors['category_id'])){ ?>
          <span style="color:red;"><?php echo $validation_errors['category_id']; ?></span>
      <?php } ?>
      </div>
      <div class="form-group">
      <label for="catname">FAQ Status:</label><br>
      <select class="form-control" name="status">
          <option <?php echo ($old_inputs != '' && ISSET($old_inputs['status']) && $old_inputs['status'] == 1) ? 'selected="selected"' : ''; ?> value="1">Enabled</option>
          <option <?php echo ($old_inputs != '' && ISSET($old_inputs['status']) && $old_inputs['status'] == 0) ? 'selected="selected"' : ''; ?> value="0">Disabled</option>
      </select>
      <?php if($validation_errors != '' && ISSET($validation_errors['status'])){ ?>
          <span style="color:red;"><?php echo $validation_errors['status']; ?></span>
      <?php } ?>
    </div>
   
    <button type="submit" name="submit" class="btn btn-default">Submit</button>
  </form>
</div>























