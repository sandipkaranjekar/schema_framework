<?php 
session_start();
require_once('../../configuration.php');

if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>User list</title>
		<?php
			require_once(LIB.'db_pg.php');
	    		include_once(LAYOUT.'stylesheet.php');
	     		include_once(LAYOUT.'javascript.php');
			include_once(LIB.'rbac.php');
		?>
	</head>
	<body>
		 <div class="container-fluid">
    			<div class="row-fluid">
				<?php include_once(LAYOUT.'header.php'); ?>
			</div>
			<div class="row-fluid grid_960_system">
				<div class="span12">
					<div class="modalbox">
						<div class="modal-header" style="margin: 10px;">
				 			<h3><i class="icon-user"></i>&nbsp;&nbsp;User list</h3>
						</div>
						<div class="modal-body" style="margin: 10px;">
							<div class="span12">
								<table class="table table-hover table-bordered">
									<tr>
										<th style="text-align: center">Sr. No.</th>
										<th style="text-align: center">Name</th>
										<th style="text-align: center">E-mail</th>
										<th style="text-align: center">Contact No</th>
										<th style="text-align: center">Address</th>
										<th style="text-align: center">Designation</th>
										<th style="text-align: center">User Role</th>
										<?php if(userHasPrivileges("USER_SHOW") || userHasPrivileges("USER_EDIT") || userHasPrivileges("USER_DELETE")) { ?>
											<th style="text-align: center">Action</th>
										<?php } ?>
									</tr>
									<?php
						
										$sql_users = "SELECT users.id, users.user_name, users.user_email, users.user_contact_no, users.user_address, users.user_designation, roles.role_name FROM users INNER JOIN roles ON users.roles_id = roles.id";
										$result_users = $db_pg->fetchQuery($sql_users);

										$count=1;
										if(!empty($result_users))
										{
											foreach($result_users as $key => $value)
											{
										?>
										<tr>
											<td style="text-align: center"><?php echo $count; ?></td>
											<td style="text-align: center"><?php echo $value['user_name']; ?></td>
											<td style="text-align: center"><?php echo $value['user_email']; ?></td>
											<td style="text-align: center"><?php echo $value['user_contact_no']; ?></td>
											<td style="text-align: center"><?php echo $value['user_address']; ?></td>
											<td style="text-align: center"><?php echo $value['user_designation']; ?></td>
											<td style="text-align: center"><?php echo $value['role_name']; ?></td>
											<?php if(userHasPrivileges("USER_SHOW") || userHasPrivileges("USER_EDIT") || userHasPrivileges("USER_DELETE")) { ?>
												<td style="text-align: center">
													<?php if(userHasPrivileges("USER_SHOW")) { ?>
														<a title="show" href="<?php echo DOMAIN; ?>/user_panel/users/show.php?id=<?php echo $value['id']; ?>"><i class="icon-eye-open"></i></a>
													<?php } ?>
													<?php if(userHasPrivileges("USER_EDIT")) { ?>
														<a title="edit" href="<?php echo DOMAIN; ?>/user_panel/users/edit.php?id=<?php echo $value['id']; ?>"><i class="icon-edit"></i></a>
													<?php } ?>
													<?php if(userHasPrivileges("USER_DELETE")) { ?>
														<a title="delete" id="delete_<?php echo $value['id']; ?>"><i class="icon-remove"></i></a>	
													<?php } ?>
												</td>
											<?php } ?>
									  	 </tr>
										<?php 
											$count++; 
											} // foreach ends
										} // if ends
										else
										{
										?>
											<tr>
												<td colspan="8"><center><strong>Sorry, no data found.</strong></center></td>
											</tr>
										<?php
										}
										?>		
								</table>
							</div>
						</div>
						<div class="modalbox-footer" style="height: 30px;">
							<?php if(userHasPrivileges("USER_CREATE")) { ?>
								<a class="btn btn-primary" href="<?php echo DOMAIN; ?>/user_panel/users/create.php">User registration</a>
							<?php } ?>
							&nbsp;&nbsp;<a class="btn" href="<?php echo DOMAIN; ?>/user_panel/"><i class="icon-reply"></i>&nbsp;&nbsp;Back</a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row-fluid footer_bg">
				<?php include_once(LAYOUT.'footer.php'); ?>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				// delete script
				$("a[id^='delete_']").live("click", function(){
				var $id = this.id;
				var $delete_id = $id.substr(7);
				if (confirm('Are you sure want delete.')) {
					 $.ajax({    
				    		url: '<?php echo DOMAIN."/user_panel/commons/delete_row.php"; ?>',
				    		type:'DELETE',
				    		dataType: 'json',
				    		data: {
					    		id: $delete_id,
							entity: "users"
				    		},
				    		success: function(data) {
							if(data.status == true)
								location.reload();
						}
					 });
				}
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
