<?php 
session_start();
require_once('../../configuration.php');

if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>User groups</title>
		<?php
			require_once(LIB.'db_pg.php');
	    		include_once(LAYOUT.'stylesheet.php');
	     		include_once(LAYOUT.'javascript.php');

			if(isset($_POST['submit']))
			{
				if(isset($_POST['groups_name']) && $_POST['groups_name'] != "" && isset($_POST['group_descrip']) && $_POST['group_descrip'] != "" && isset($_POST['group_active']) && $_POST['group_active'] != "")
				{
					$sql = "UPDATE groups SET group_name = :group_name, group_description = :group_description, is_active = :is_active, updated_at = CURRENT_TIMESTAMP WHERE id = :id";

					$flag = $db_pg->queryPrepared($sql, array(':group_name' => $_POST['groups_name'], ':group_description' => $_POST['group_descrip'], ':is_active' => $_POST['group_active'], ':id' => $_GET['id']))->rowcount();

					if(isset($_POST['cb_privilege_name']) && $_POST['cb_privilege_name'] != "")
					{
						$privilege_update = array();
						foreach($_POST['cb_privilege_name'] as $key => $value)
							array_push($privilege_update, $value);
					
						$sql_privileges_ids = "SELECT privilege_id FROM groups_privileges where groups_id = :group_id";
						$result_privileges_ids = $db_pg->fetchQueryPrepared($sql_privileges_ids, array(':group_id'=> $_GET['id']));

						$privileges_ids_arr = array();

						foreach($result_privileges_ids as $key_privileges_id =>$value_privileges_id)
							array_push($privileges_ids_arr, $value_privileges_id['privilege_id']);
					
						$inter = array_intersect($privileges_ids_arr, $privilege_update);
					
						$diff_delete = array_diff($privileges_ids_arr, $privilege_update);
					
						$diff_insert = array_diff($privilege_update, $privileges_ids_arr);
					
						$sql_delete = "DELETE FROM groups_privileges WHERE `groups_id` = :group_id AND `privilege_id` = :privilege_id";
					
						foreach($diff_delete as $key_delete => $value_delete)
						{
							$db_pg->queryPrepared($sql_delete, array(':group_id' => $_GET['id'], ':privilege_id' => $value_delete));
						}
					
						$sql_insert = "INSERT INTO `groups_privileges` (`groups_id`, `privilege_id`) VALUES (:group_id, :privilege_id);";

						foreach($diff_insert as $key_insert => $value_insert)
						{
							$db_pg->queryPrepared($sql_insert, array(':group_id' => $_GET['id'], ':privilege_id' => $value_insert));
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
		<script>
			$(document).ready(function(){
				$("#cb_select_all").live("click", function(){
					$(".cb_privilege_name").attr('checked', this.checked);
				});
			});
		</script>
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
							$sql_edit_groups = "SELECT * FROM groups WHERE id = :id";
							$result_edit_groups = $db_pg->fetchQueryPrepared($sql_edit_groups, array(':id' => $_GET['id']));
						}
						else
						{
							header("Location:".DOMAIN."/user_panel/user_groups/");
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
					<form method="post" id="frm_group">
			 			<h3><i class="icon-group"></i>&nbsp;&nbsp;Edit User groups</h3><hr/>
						<table border="0">
							<tr>
								<td>Group name :</td>
								<td><input type="text" name="groups_name" value="<?php echo $result_edit_groups['0']['group_name']; ?>"></td>
							</tr>
							<tr>
								<td>Group description :</td>
								<td><textarea rows="3" name="group_descrip"><?php echo $result_edit_groups['0']['group_description']; ?></textarea></td>
							</tr>
							<tr>
								<td colspan="2"><label class="checkbox"><input type="checkbox" id="cb_select_all" value="">Select all</label></td>
							</tr>
							<tr>
								<td colspan="2">
									<?php
									// select id, system_module_name from system_modules

									$sql_system_module = "SELECT id, system_module_name FROM system_modules ORDER BY system_module_order";
									$result_system_module = $db_pg->fetchQuery($sql_system_module);
	
									// select group ids from roles_groups
											
									$sql_privileges_ids = "SELECT privilege_id FROM groups_privileges WHERE groups_id = :group_id";
									$result_privileges_ids = $db_pg->fetchQueryPrepared($sql_privileges_ids, array(':group_id'=> $result_edit_groups['0']['id']));
									$privileges_ids_arr = array();

									foreach($result_privileges_ids as $key_privileges_id =>$value_privileges_id)
										array_push($privileges_ids_arr, $value_privileges_id['privilege_id']);

									$count = 0;
									foreach($result_system_module as $key_system_module => $value_system_module)
									{
									?>
										<div class="attendance_alignment">
											<div><h4><?php echo $value_system_module['system_module_name']; ?></h4><hr/></div>
									<?php
										$sql_groups_privileges = "SELECT * FROM privileges WHERE modules_id = :modules_id";
										$result_groups_privileges = $db_pg->fetchQueryPrepared($sql_groups_privileges, array(':modules_id' => $value_system_module['id']));
										foreach($result_groups_privileges as $key_groups_privileges => $value_groups_privileges)
										{
											if($count == 0)
											{
									?>
												<table border="0" class="table table-hover table-bordered">
									<?php
											}				
											if(in_array($value_groups_privileges['id'], $privileges_ids_arr))
											{
											?>
												<tr><td><label class="checkbox"><input type="checkbox" name="cb_privilege_name[]" class="cb_privilege_name" value="<?php echo $value_groups_privileges['id']; ?>" checked="checked"><?php echo $value_groups_privileges['privilege_name']; ?></label></td></tr>
											<?php
											}
											else
											{
											?>
												<tr><td><label class="checkbox"><input type="checkbox" name="cb_privilege_name[]" class="cb_privilege_name" value="<?php echo $value_groups_privileges['id']; ?>"><?php echo $value_groups_privileges['privilege_name']; ?></label></td></tr>
									<?php
											}
											$count++;
											if($count == 5)
											{
												echo "</table>";
												$count = 0;
											}
										} // groups_privileges foreach ends
										echo "</div>";
									}// system_module foreach ends 
									?>
								</td>
							</tr>
							<tr>
								<td>Group action :</td>
								<td>
									<select name="group_active">
										<option value="">Select</option>
										<option value="true" <?php echo $select = (($result_edit_groups['0']['is_active'] == true) ? "selected = 'selected'" : null); ?>>Active</option>
										<option value="false" <?php echo $select = (($result_edit_groups['0']['is_active'] == false) ? "selected = 'selected'" : null); ?>>Inactive</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="submit" value="Update" name="submit" class="btn btn-primary">
									<a class="btn" href="<?php echo DOMAIN; ?>/user_panel/user_groups/"><i class="icon-reply"></i>&nbsp;&nbsp;Back</a>
								</td>
							</tr>
						</table>	
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
