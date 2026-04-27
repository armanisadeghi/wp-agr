<a class="btn btn-primary" style="float:right" href="<?php echo admin_url('admin.php?page=Manage_FAQs&action=add');?>">Add FAQs</a>
<br><br>
<table id="categorytable" class="table table-striped table-bordered data-table" style="width:100%">
	<thead>
		<tr>
		    <th>FAQ ID</th>
			<th>Question</th>
			<th>Answer</th>
			<th>Category</th>
			<th>Status</th>
			<th>Short Code</th>
			 <th>Action</th>
		   
		  
		</tr>
	</thead>
	<tbody>
	 <?php

	global $wpdb;
	$table = getFaqTableName();
	$category_table = getCategoryTableName();
	
	$result = $wpdb->get_results( "SELECT ".$table.".*, ".$category_table.".Name as category_name FROM ".$table." left join ".$category_table." on ".$category_table.".id = ".$table.".Category_id Order by ".$table.".ID DESC");
	
	foreach ( $result as $print )   { ?>
	  <tr>
	          <td>  <?php echo $print->ID; ?> </td>
			  <td>  <?php echo $print->Question; ?> </td>
			   <td>  <?php echo $print->Answer; ?> </td>
			   <td><?php echo $print->category_name; ?> </td>
			   <td><?php echo ($print->Status == 0) ? 'Disabled' : 'Enabled'; ?> </td>
			  <td>[faq-plugin id="<?php echo $print->ID; ?>" type="faq"] </td>
			  <td> <a href="<?php echo admin_url('admin.php?page=Manage_FAQs&action=edit&id='.$print->ID);?>"><span class="glyphicon glyphicon-edit" ></a> | 
				   <a onclick="confirmAction('<?php echo admin_url('admin.php?page=Manage_FAQs&action=delete&id='.$print->ID);?>')" href="javascript:void(0)"><span class="glyphicon glyphicon-trash" > </a>
			  </td>
			 
			  
	  </tr>
		<?php }
  ?>
	</tbody>
	<tfoot>
		<tr>
			<th>FAQ ID</th>
			<th>Question</th>
			<th>Answer</th>
			<th>Category</th>
			<th>Status</th>
			<th>Short Code</th>
			 <th>Action</th>
		   
		</tr>
	</tfoot>
</table>