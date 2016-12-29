<?php 
session_start();
require_once('../../configuration.php');

if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Privilege creation</title>
		<?php
			require_once(LIB.'db_pg.php');
	    		include_once(LAYOUT.'stylesheet.php');
	     		include_once(LAYOUT.'javascript.php');

			if(isset($_POST['submit']))
			{
				if(isset($_POST['privileges_name']) && $_POST['privileges_name'] != "" && isset($_POST['privilege_descrip']) && $_POST['privilege_descrip'] != "" && isset($_POST['privilege_active']) && $_POST['privilege_active'] != "" && isset($_POST['sys_mod']) && $_POST['sys_mod'] != "" && $_POST['privilege_exist'] == 'false')
				{
					$sql_privilege_creation = "INSERT INTO privileges(id, privilege_name, privilege_description, modules_id, is_active, created_at, updated_at) VALUES (nextval('privileges_id_seq'::regclass), :privilege_name, :privilege_description, :modules_id, :is_active, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
					 $flag_privilege_creation = $db_pg->queryPrepared($sql_privilege_creation, array(':privilege_name' => $_POST['privileges_name'], ':privilege_description' => $_POST['privilege_descrip'], ':modules_id' => $_POST['sys_mod'], ':is_active' => $_POST['privilege_active']))->rowcount();
		
					if($flag_privilege_creation != 0)
					{
						$flash_type = "alert-success";
					  	$flash_message = "Data inserted successfully.";
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
				  $flash_message = "All feilds are compulsary.Try for new one.";
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
					 			<h3><i class="icon-check"></i>&nbsp;&nbsp;Privilege creation</h3>
							</div>
							<div class="modal-body" style="margin-left: 0px;">
								<table border="0" align="center">
									<tr>
										<td>Privilege name :</td>
										<td>
											<input type="text" name="privileges_name" id="privileges_name">&nbsp;&nbsp;
											<span class="error already_exist"></span>
											<input type="hidden" class="privilege_exist" name="privilege_exist">
										</td>
									</tr>
									<tr>
										<td>Privilege description :</td>
										<td><textarea rows="3" name="privilege_descrip" id="privilege_descrip"></textarea></td>
									</tr>
									<tr>
										<td>System module :</td>
										<td>
											<select name="sys_mod" id="sys_mod">
												<option value="">Select</option>
												<?php
													$sql_sys_mod = "SELECT * FROM system_modules";
													$result_sys_mod = $db_pg->fetchQuery($sql_sys_mod);
													foreach($result_sys_mod as $key_sys_mod => $value_sys_mod)
													{
												?>
												<option value="<?php echo $value_sys_mod['id']; ?>"><?php echo $value_sys_mod['system_module_name']; ?></option>
												<?php
													 } 
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Privilege action :</td>
										<td>
											<select name="privilege_active" id="privilege_active">
												<option value="">Select</option>
												<option value="true">Active</option>
												<option value="false">Inactive</option>
											</select>
										</td>
									</tr>
								</table>		
							</div>
							<div class="modalbox-footer">
								<input type="submit" value="Create" name="submit" class="btn btn-primary">
								<input type="reset" value="Clear" class="btn" />
								<a class="btn" href="<?php echo DOMAIN; ?>/user_panel/privileges/index.php"><i class="icon-reply"></i>&nbsp;&nbsp;Back</a>
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
		<script type="text/javascript">
			$(document).ready(function(){
				// already exist
				$("#privileges_name").blur(function(){
					
					var $ro_name = $(this).val();
					 $.ajax({    
				    		url: '<?php echo DOMAIN."/user_panel/commons/already_exist.php"; ?>',
				    		type:'GET',
				    		dataType: 'json',
				    		data: {
					    		role_name: $ro_name,
							entity1: "privilege_name",
							entity2: "privileges"
				    		},
				    		success: function(data) {
							if(data.status == true)
							{
								$(".already_exist").html("Already exist.");
								$(".privilege_exist").val(true);
							}
							else
							{
								$(".already_exist").html("");
								$(".privilege_exist").val(false);
							}
						}
					 });
				
				});
			});
		</script>
	</body>
</html>
<?php 
}
else
{
	header("Location:".DOMAIN."/");
}
?>
