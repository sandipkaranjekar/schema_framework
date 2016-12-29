<?php 
session_start();
require_once('../../configuration.php');

if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Privilege</title>
		<?php
			require_once(LIB.'db_pg.php');
	    		include_once(LAYOUT.'stylesheet.php');
	     		include_once(LAYOUT.'javascript.php');

			if(isset($_POST['submit']))
			{
				if(isset($_POST['privileges_name']) && $_POST['privileges_name'] != "" && isset($_POST['privilege_descrip']) && $_POST['privilege_descrip'] != "" && isset($_POST['privilege_active']) && $_POST['privilege_active'] != "" && isset($_POST['sys_mod']) && $_POST['sys_mod'] != "")
				{
					$sql = "UPDATE privileges SET privilege_name = :privilege_name, privilege_description = :privilege_description, modules_id = :modules_id, is_active = :is_active, updated_at = CURRENT_TIMESTAMP WHERE id = :id";

					$flag = $db_pg->queryPrepared($sql, array(':privilege_name' => $_POST['privileges_name'], ':privilege_description' => $_POST['privilege_descrip'], ':modules_id' => $_POST['sys_mod'], ':is_active' => $_POST['privilege_active'], ':id' => $_GET['id']))->rowcount();

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
							$sql_edit_groups = "SELECT * FROM privileges WHERE id = :id";
							$result_edit_groups = $db_pg->fetchQueryPrepared($sql_edit_groups, array(':id' => $_GET['id']));	
						}
						else
						{
							header("Location:".DOMAIN."/user_panel/privileges/");
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
					<form method="post" id="frm_privilege">
						<div class="modalbox">
							<div class="modal-header">
					 			<h3><i class="icon-check"></i>&nbsp;&nbsp;Edit privileges</h3>
							</div>
							<div class="modal-body" style="margin-left: 0px;">
								<table border="0" align="center">
									<tr>
										<td>Privilege name :</td>
										<td><input type="text" name="privileges_name" value="<?php echo $result_edit_groups['0']['privilege_name']; ?>"></td>
									</tr>
									<tr>
										<td>Privilege description :</td>
										<td><textarea rows="3" name="privilege_descrip"><?php echo $result_edit_groups['0']['privilege_description']; ?></textarea></td>
									</tr>
									<tr>
										<td>System module :</td>
										<td>
											<select name="sys_mod">
												<option value="">Select</option>
												<?php
													$sql_sys_mod = "SELECT * FROM system_modules";
													$result_sys_mod = $db_pg->fetchQuery($sql_sys_mod);
													foreach($result_sys_mod as $key_sys_mod => $value_sys_mod)
													{
								if($result_edit_groups['0']['modules_id'] == $value_sys_mod['id'])
								{
								?>
									<option value="<?php echo $value_sys_mod['id']; ?>" selected="selected"><?php echo $value_sys_mod['system_module_name']; ?></option>
								<?php
								}
								else
								{
								?>
									<option value="<?php echo $value_sys_mod['id']; ?>"><?php echo $value_sys_mod['system_module_name']; ?></option>
								<?php
								}
													 } 
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Privilege action :</td>
										<td>
											<select name="privilege_active">
												<option value="">Select</option>
												<option value="1" <?php echo $select = (($result_edit_groups['0']['is_active'] == true) ? "selected = 'selected'" : null); ?>>Active</option>
												<option value="0" <?php echo $select = (($result_edit_groups['0']['is_active'] == false) ? "selected = 'selected'" : null); ?>>Inactive</option>
											</select>
										</td>
									</tr>
								</table>	
							</div>
							<div class="modalbox-footer">
								<input type="submit" value="Update" name="submit" class="btn btn-primary">
								<a class="btn" href="<?php echo DOMAIN; ?>/user_panel/privileges/"><i class="icon-reply"></i>&nbsp;&nbsp;Back</a>
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
