<?php 
session_start();
require_once('../../configuration.php');

if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>User role creation</title>
		<?php
			require_once(LIB.'db_pg.php');
	    		include_once(LAYOUT.'stylesheet.php');
	     		include_once(LAYOUT.'javascript.php');

			if(isset($_POST['submit']))
			{
				if(isset($_POST['roles_name']) && $_POST['roles_name'] != "" && isset($_POST['role_descrip']) && $_POST['role_descrip'] != "" && isset($_POST['role_active']) && $_POST['role_active'] != "" && $_POST['role_exist'] == 'false')
				{
					$sql_role_creation = "INSERT INTO roles(id, role_name, role_description, is_active, created_at, updated_at) VALUES (nextval('roles_id_seq'::regclass), :role_name, :role_description, :is_active, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP) RETURNING id";

					 $flag_role_creation = $db_pg->queryPrepared($sql_role_creation, array(':role_name' => $_POST['roles_name'], ':role_description' => $_POST['role_descrip'], ':is_active' => $_POST['role_active']));

					$role_id = $flag_role_creation['0']['id'];

					$sql_roles_groups = "INSERT INTO roles_groups (roles_id, groups_id) VALUES (:role_id, :group_id);";

					if(isset($_POST['cb_role_name']) && $_POST['cb_role_name'] != "")
					{
						foreach($_POST['cb_role_name'] as $key => $value)
						{
							$db_pg->queryPrepared($sql_roles_groups, array(':role_id' => $role_id, ':group_id' => $value));
						}
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
					<form method="post" id="frm_role">
						<div class="modalbox">
							<div class="modal-header">
					 			<h3><i class="icon-sitemap"></i>&nbsp;&nbsp;User role creation</h3>
							</div>
							<div class="modal-body">
								<table border="0" align="center">
									<tr>
										<td>Role name :</td>
										<td>
											<input type="text" name="roles_name" id="roles_name">&nbsp;&nbsp;
											<span class="error already_exist"></span>
											<input type="hidden" class="role_exist" name="role_exist" />
										</td>
									</tr>
									<tr>
										<td>Role description :</td>
										<td><textarea rows="3" name="role_descrip" id="role_descrip"></textarea></td>
									</tr>
									<tr>
										<td>Group :</td>
										<td>
											<ul class="inline">
												<?php
													$sql_role_groups = "SELECT * FROM groups";
													$result_role_groups = $db_pg->fetchQuery($sql_role_groups);
													foreach($result_role_groups as $role => $value)
													{
												?>
												<li><label class='checkbox'><input type='checkbox' name='cb_role_name[]' value="<?php echo $value['id']; ?>" ><?php echo $value['group_name']; ?></label></li>
												<?php
													 } 
												?>
											</ul>
										</td>
									</tr>
									<tr>
										<td>Role action :</td>
										<td>
											<select name="role_active" id="role_active">
												<option value="">Select</option>
												<option value="1">Active</option>
												<option value="0">Inactive</option>
											</select>
										</td>
									</tr>
								</table>		
							</div>
							<div class="modalbox-footer">
								<input type="submit" value="Create" name="submit" class="btn btn-primary">
								<input type="reset" value="Clear" class="btn" />
								<a class="btn" href="<?php echo DOMAIN; ?>/user_panel/user_roles/index.php"><i class="icon-reply"></i>&nbsp;&nbsp;Back</a>
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
				$("#roles_name").blur(function(){
					
					var $ro_name = $(this).val();
					 $.ajax({    
				    		url: '<?php echo DOMAIN."/user_panel/commons/already_exist.php"; ?>',
				    		type:'GET',
				    		dataType: 'json',
				    		data: {
					    		role_name: $ro_name,
							entity1: "role_name",
							entity2: "roles"
				    		},
				    		success: function(data) {
							if(data.status == true)
							{
								$(".already_exist").html("Already exist.");
								$(".role_exist").val(true);
							}
							else
							{
								$(".already_exist").html("");
								$(".role_exist").val(false);
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
