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
				if(isset($_POST['sys_mod_name']) && $_POST['sys_mod_name'] != "" && isset($_POST['sys_mod_descrip']) && $_POST['sys_mod_descrip'] != "" && isset($_POST['sys_mod_order']) && $_POST['sys_mod_order'] != "" && isset($_POST['sys_mod_active']) && $_POST['sys_mod_active'] != "" && $_POST['sys_mod_exist'] == 'false')
				{
					$sql_add_sys_mod = "INSERT INTO system_modules(id, system_module_name, system_module_description, system_module_order, is_active, created_at, updated_at) VALUES (nextval('system_modules_id_seq'::regclass), :system_module_name, :system_module_description, :system_module_order, :is_active, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

					echo $flag_add_sys_mod = $db_pg->queryPrepared($sql_add_sys_mod, array(':system_module_name' => $_POST['sys_mod_name'], ':system_module_description' => $_POST['sys_mod_descrip'], ':system_module_order' => $_POST['sys_mod_order'], ':is_active' => $_POST['sys_mod_active']))->rowcount();
		
					if($flag_add_sys_mod != 0)
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
					<form method="post" id="frm_sys_mod">
						<div class="modalbox">
							<div class="modal-header">
					 			<h3><i class="icon-cogs"></i>&nbsp;&nbsp;Add system module</h3>
							</div>
							<div class="modal-body" style="margin-left: 0px;">
								<table border="0" align="center">
									<tr>
										<td>System module name :</td>
										<td>
											<input type="text" name="sys_mod_name" id="sys_mod_name">&nbsp;&nbsp;
											<span class="error already_exist"></span>
											<input type="hidden" class="sys_mod_exist" name="sys_mod_exist">
										</td>
									</tr>
									<tr>
										<td>System module description :</td>
										<td><textarea rows="3" name="sys_mod_descrip" id="sys_mod_descrip"></textarea></td>
									</tr>
									<tr>
										<td>System module order :</td>
										<td><input type="text" name="sys_mod_order" id="sys_mod_order"></td>
									</tr>
									<tr>
										<td>System module action :</td>
										<td>
											<select name="sys_mod_active">
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
		<script type="text/javascript">
			$(document).ready(function(){
				// already exist
				$("#sys_mod_name").blur(function(){
					
					var $ro_name = $(this).val();
					 $.ajax({    
				    		url: '<?php echo DOMAIN."/user_panel/commons/already_exist.php"; ?>',
				    		type:'GET',
				    		dataType: 'json',
				    		data: {
					    		role_name: $ro_name,
							entity1: "system_module_name",
							entity2: "system_modules"
				    		},
				    		success: function(data) {
							if(data.status == true)
							{
								$(".already_exist").html("Already exist.");
								$(".sys_mod_exist").val(true);
							}
							else
							{
								$(".already_exist").html("");
								$(".sys_mod_exist").val(false);
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
