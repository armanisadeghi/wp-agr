<a class="btn btn-primary" style="float:right" href="<?php echo admin_url('admin.php?page=Manage_Categories&action=add');?>">Add Category</a>
<br><br>
<table id="categorytable" class="table table-striped table-bordered data-table" style="width:100%">
	<thead>
		<tr>
		    <th>Category ID</th>
			<th>Category Name</th>
			<th>Category Description</th>
			<th>Short Code</th>
			<th>Status</th>
			 <th>Action</th>
		   
		  
		</tr>
	</thead>
	<tbody>
	 <?php

	global $wpdb;
	$table = getCategoryTableName();
	
	$result = $wpdb->get_results( "SELECT * FROM ".$table." Order by ID DESC");
	foreach ( $result as $print )   { ?>
	  <tr>
	          <td>  <?php echo $print->ID; ?> </td>
			  <td>  <?php echo $print->Name; ?> </td>
			  <td>  <?php echo $print->Description; ?> </td>
			  <td>[faq-plugin id="<?php echo $print->ID; ?>" type="category"] </td>
			  <td><?php echo ($print->Status == 0) ? 'Disabled' : 'Enabled'; ?> </td>
			  <td> <a href="<?php echo admin_url('admin.php?page=Manage_Categories&action=edit&id='.$print->ID);?>"><span class="glyphicon glyphicon-edit" ></a> | 
				   <a onclick="confirmAction('<?php echo admin_url('admin.php?page=Manage_Categories&action=delete&id='.$print->ID);?>')" href="javascript:void(0)"><span class="glyphicon glyphicon-trash" > </a>
			  </td>
			 
			  
	  </tr>
		<?php }
  ?>
	</tbody>
	<tfoot>
		<tr>
			 <th>Category ID</th>
			<th>Category Name</th>
			<th>Category Description</th>
			<th>Short Code</th>
			<th>Status</th>
			 <th>Action</th>
		   
		</tr>
	</tfoot>
</table>