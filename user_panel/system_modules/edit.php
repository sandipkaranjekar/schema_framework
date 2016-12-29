<?php 
session_start();
require_once('../../configuration.php');

if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>System module</title>
		<?php
			require_once(LIB.'db_pg.php');
	    		include_once(LAYOUT.'stylesheet.php');
	     		include_once(LAYOUT.'javascript.php');

			if(isset($_POST['submit']))
			{
				if(isset($_POST['sys_mod_name']) && $_POST['sys_mod_name'] != "" && isset($_POST['sys_mod_descrip']) && $_POST['sys_mod_descrip'] != "" && isset($_POST['sys_mod_order']) && $_POST['sys_mod_order'] != "" && isset($_POST['sys_mod_active']) && $_POST['sys_mod_active'] != "")
				{
					$sql = "UPDATE system_modules SET system_module_name = :system_module_name, system_module_description = :system_module_description, system_module_order = :system_module_order, is_active = :is_active, updated_at = CURRENT_TIMESTAMP WHERE id = :id";

					$flag = $db_pg->queryPrepared($sql, array(':system_module_name' => $_POST['sys_mod_name'], ':system_module_description' => $_POST['sys_mod_descrip'], ':system_module_order' => $_POST['sys_mod_order'], ':is_active' => $_POST['sys_mod_active'], ':id' => $_GET['id']))->rowcount();

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
							$sql_edit_sys_mod = "SELECT * FROM system_modules WHERE id = :id";
							$result_edit_sys_mod = $db_pg->fetchQueryPrepared($sql_edit_sys_mod, array(':id' => $_GET['id']));	
						}
						else
						{
							header("Location:".DOMAIN."/user_panel/system_modules/");
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
					<form method="post" id="frm_sys_mod">
						<div class="modalbox">
							<div class="modal-header">
					 			<h3><i class="icon-cogs"></i>&nbsp;&nbsp;Edit System module</h3>
							</div>
							<div class="modal-body" style="margin-left: 0px;">
								<table border="0" align="center">
									<tr>
										<td>System module name :</td>
										<td><input type="text" name="sys_mod_name" value="<?php echo $result_edit_sys_mod['0']['system_module_name']; ?>"></td>
									</tr>
									<tr>
										<td>System module description :</td>
										<td><textarea rows="3" name="sys_mod_descrip"><?php echo $result_edit_sys_mod['0']['system_module_description']; ?></textarea></td>
									</tr>
									<tr>
										<td>System module order :</td>
										<td><input type="text" name="sys_mod_order" id="sys_mod_order" value="<?php echo $result_edit_sys_mod['0']['system_module_order']; ?>"></td>
									</tr>
									<tr>
										<td>System module action :</td>
										<td>
											<select name="sys_mod_active">
												<option value="">Select</option>
												<option value="1" <?php echo $select = (($result_edit_sys_mod['0']['is_active'] == true) ? "selected = 'selected'" : null); ?>>Active</option>
												<option value="0" <?php echo $select = (($result_edit_sys_mod['0']['is_active'] == false) ? "selected = 'selected'" : null); ?>>Inactive</option>
											</select>
										</td>
									</tr>
								</table>	
							</div>
							<div class="modalbox-footer">
								<input type="submit" value="Update" name="submit" class="btn btn-primary">
								<a class="btn" href="<?php echo DOMAIN; ?>/user_panel/system_modules/"><i class="icon-reply"></i>&nbsp;&nbsp;Back</a>
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
