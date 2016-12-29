<?php 
session_start();
require_once('../../configuration.php');

if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>User roles</title>
		<?php
			require_once(LIB.'db_pg.php');
	    		include_once(LAYOUT.'stylesheet.php');
	     		include_once(LAYOUT.'javascript.php');

			if(isset($_POST['submit']))
			{
				if(isset($_POST['roles_name']) && $_POST['roles_name'] != "" && isset($_POST['role_descrip']) && $_POST['role_descrip'] != "" && isset($_POST['role_active']) && $_POST['role_active'] != "")
				{
					$sql = "UPDATE roles SET role_name = :role_name, role_description = :role_description, is_active = :is_active, updated_at = CURRENT_TIMESTAMP WHERE id = :id";

					$flag = $db_pg->queryPrepared($sql, array(':role_name' => $_POST['roles_name'], ':role_description' => $_POST['role_descrip'], ':is_active' => $_POST['role_active'], ':id' => $_GET['id']))->rowcount();
			
					if(isset($_POST['cb_role_name']) && $_POST['cb_role_name'] != "")
					{
						$group_update = array();
						foreach($_POST['cb_role_name'] as $key => $value)
							array_push($group_update, $value);
					
						$sql_groups_ids = "SELECT groups_id FROM roles_groups where roles_id = :role_id";
						$result_groups_ids = $db_pg->fetchQueryPrepared($sql_groups_ids, array(':role_id'=> $_GET['id']));
						$group_ids_arr = array();
						foreach($result_groups_ids as $key_group_id =>$value_group_id)
							array_push($group_ids_arr, $value_group_id['groups_id']);
					
						$inter = array_intersect($group_ids_arr, $group_update);
					
						$diff_delete = array_diff($group_ids_arr, $group_update);
					
						$diff_insert = array_diff($group_update, $group_ids_arr);
					
						$sql_delete = "DELETE FROM roles_groups WHERE `roles_id` = :role_id AND `groups_id` = :group_id";
					
						foreach($diff_delete as $key_delete => $value_delete)
						{
							$db_pg->queryPrepared($sql_delete, array(':role_id' => $_GET['id'], ':group_id' => $value_delete));
						}
					
						$sql_insert = "INSERT INTO `bug_tracker`.`roles_groups` (`roles_id`, `groups_id`) VALUES (:role_id, :group_id);";

						foreach($diff_insert as $key_insert => $value_insert)
						{
							$db_pg->queryPrepared($sql_insert, array(':role_id' => $_GET['id'], ':group_id' => $value_insert));
						}
					
					}
					 
					if($flag != 0)
					{
						$flash_type = "alert-success";
					  	$flash_message = "Data updated successfully.";
					}
					else
					{
						$flash_type = "";
					  	$flash_message = "We are sorry.But something went wrong";  
					}
				}
				else
				{
				  $flash_type = "alert-error";
				  $flash_message = "All feilds are compulsary.";
				}
	     		}
		?>
	</head>
	<body>
		 <div class="container-fluid">
			<!-- Header -->
    			<div class="row-fluid">
				<?php include_once(LAYOUT.'header.php'); ?>
			</div>

			<!-- Content -->
			<div class="row-fluid grid_960_system">
				<div class="span12">
					<?php
						if(isset($_GET['id']) && $_GET['id'] != "")
						{
							$sql_edit_roles = "SELECT * FROM roles WHERE id = :id";
							$result_edit_roles = $db_pg->fetchQueryPrepared($sql_edit_roles, array(':id' => $_GET['id']));
						}
						else
						{
							header("Location:".DOMAIN."/user_panel/user_roles/");
						}	
			
						if(isset($flash_type) && isset($flash_message))
						{
					?>
							<div class=" small_alert alert <?php echo $flash_type; ?>">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?php echo $flash_message; ?>
							</div>
					<?php
						}
					?>
					<form method="post" id="frm_role">
						<div class="modalbox">
							<div class="modal-header">
					 			<h3><i class="icon-sitemap"></i>&nbsp;&nbsp;Edit User roles</h3>
							</div>
							<div class="modal-body">
								<table border="0" align="center">
									<tr>
										<td>Role name :</td>
										<td><input type="text" name="roles_name" value="<?php echo $result_edit_roles['0']['role_name']; ?>"></td>
									</tr>
									<tr>
										<td>Role description :</td>
										<td><textarea rows="3" name="role_descrip"><?php echo $result_edit_roles['0']['role_description']; ?></textarea></td>
									</tr>
									<tr>
										<td>Group :</td>
										<td>
											<?php
											// select group ids from roles_groups
													
											$sql_groups_ids = "SELECT groups_id FROM roles_groups where roles_id = :role_id";
											$result_groups_ids = $db_pg->fetchQueryPrepared($sql_groups_ids, array(':role_id'=> $result_edit_roles[0]['id']));
											$group_ids_arr = array();
											foreach($result_groups_ids as $key_group_id =>$value_group_id)
												array_push($group_ids_arr, $value_group_id['groups_id'])
											?>
											<ul class="inline">
												<?php
													$sql_role_groups = "SELECT * FROM groups";
													$result_role_groups = $db_pg->fetchQuery($sql_role_groups);
													foreach($result_role_groups as $role => $value)
													{
						if(in_array($value['id'], $group_ids_arr))
						{
						?>
							<li><label class='checkbox'><input type="checkbox" name="cb_role_name[]" value="<?php echo $value['id']; ?>" checked="checked"><?php echo $value['group_name']; ?></label></li>
						<?php
						}
						else
						{
						?>
							<li><label class='checkbox'><input type="checkbox" name="cb_role_name[]" value="<?php echo $value['id']; ?>"><?php echo $value['group_name']; ?></label></li>
												<?php
						}
													 } 
												?>
											</ul>
										</td>
									</tr>
									<tr>
										<td>Role action :</td>
										<td>
											<select name="role_active">
												<option value="">Select</option>
												<option value="1" <?php echo $select = (($result_edit_roles['0']['is_active'] == true) ? "selected = 'selected'" : null); ?>>Active</option>
												<option value="0" <?php echo $select = (($result_edit_roles['0']['is_active'] == false) ? "selected = 'selected'" : null); ?>>Inactive</option>
											</select>
										</td>
									</tr>
								</table>	
							</div>
							<div class="modalbox-footer">
								<input type="submit" value="Update" name="submit" class="btn btn-primary">
								<a class="btn" href="<?php echo DOMAIN; ?>/user_panel/user_roles/"><i class="icon-reply"></i>&nbsp;&nbsp;Back</a>
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<!-- Footer -->
			<div class="row-fluid footer_bg">
				<?php include_once(LAYOUT.'footer.php'); ?>
			</div>
		</div>

	</body>
</html>
<?php 
}
else
{
	header("Location:".DOMAIN."/");
}
?>
