<?php 
session_start();
require_once('../../configuration.php');

if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>User group creation</title>
		<?php
			require_once(LIB.'db_pg.php');
	    		include_once(LAYOUT.'stylesheet.php');
	     		include_once(LAYOUT.'javascript.php');

			if(isset($_POST['submit']))
			{
				if(isset($_POST['groups_name']) && $_POST['groups_name'] != "" && isset($_POST['group_descrip']) && $_POST['group_descrip'] != "" && isset($_POST['group_active']) && $_POST['group_active'] != ""  && $_POST['group_exist'] == 'false')
				{
					$sql_role_creation = "INSERT INTO groups(id, group_name, group_description, is_active, created_at, updated_at) VALUES (nextval('groups_id_seq'::regclass), :group_name, :group_description, :is_active, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP) RETURNING id";

					 $flag_role_creation = $db_pg->queryPrepared($sql_role_creation, array(':group_name' => $_POST['groups_name'], ':group_description' => $_POST['group_descrip'], ':is_active' => $_POST['group_active']));
					

					$group_id = $flag_role_creation['0']['id'];

					$sql_groups_privileges = "INSERT INTO groups_privileges (groups_id, privilege_id) VALUES (:group_id, :privilege_id)";

					if(isset($_POST['cb_privilege_name']) && $_POST['cb_privilege_name'] != "")
					{
						foreach($_POST['cb_privilege_name'] as $key => $value)
							$db_pg->queryPrepared($sql_groups_privileges, array(':group_id' => $group_id, ':privilege_id' => $value));
					}
		
					if($flag_role_creation != 0)
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
			<div class="row-fluid grid_960_system text_justify">
				<div class="span12">
					<?php
						if(isset($flash_type) && isset($flash_message))
						{
					?>
							<div class="small_alert alert <?php echo $flash_type; ?>">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?php echo $flash_message; ?>
							</div>
					<?php
						}
					?>
					<form method="post" id="frm_group">
			 			<h3><i class="icon-group"></i>&nbsp;&nbsp;User group creation</h3><hr/>
						<table border="0">
							<tr>
								<td>Group name :</td>
								<td>
									<input type="text" name="groups_name" id="groups_name">&nbsp;&nbsp;
									<span class="error already_exist"></span>
									<input type="hidden" class="group_exist" name="group_exist">
								</td>
							</tr>
							<tr>
								<td>Group description :</td>
								<td><textarea rows="3" name="group_descrip" id="group_descrip"></textarea></td>
							</tr>
							<tr>
								<td colspan="2"><label class="checkbox"><input type="checkbox" id="cb_select_all" value="">Select all</label></td>
							</tr>
							<tr>
								<td colspan="2">
									<?php
										$sql_system_module = "SELECT id, system_module_name FROM system_modules ORDER BY system_module_order";
										$result_system_module = $db_pg->fetchQuery($sql_system_module);

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
									?>
													<tr><td><label class="checkbox"><input type="checkbox" name="cb_privilege_name[]" class="cb_privilege_name" value="<?php echo $value_groups_privileges['id']; ?>" ><?php echo $value_groups_privileges['privilege_name']; ?></label></td></tr>
									<?php
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
									<select name="group_active" id="group_active">
										<option value="">Select</option>
										<option value="true">Active</option>
										<option value="false">Inactive</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="submit" value="Create" name="submit" class="btn btn-primary">
									<input type="reset" value="Clear" class="btn" />
									<a class="btn" href="<?php echo DOMAIN; ?>/user_panel/user_groups/index.php"><i class="icon-reply"></i>&nbsp;&nbsp;Back</a>
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
		<script type="text/javascript">
			$(document).ready(function(){
				// already exist
				$("#groups_name").blur(function(){
					
					var $ro_name = $(this).val();
					 $.ajax({    
				    		url: '<?php echo DOMAIN."/user_panel/commons/already_exist.php"; ?>',
				    		type:'GET',
				    		dataType: 'json',
				    		data: {
					    		role_name: $ro_name,
							entity1: "group_name",
							entity2: "groups"
				    		},
				    		success: function(data) {
							if(data.status == true)
							{
								$(".already_exist").html("Already exist.");
								$(".group_exist").val(true);
							}
							else
							{
								$(".already_exist").html("");
								$(".group_exist").val(false);
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
