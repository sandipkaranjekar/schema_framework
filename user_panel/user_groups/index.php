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
				 			<h3><i class="icon-group"></i>&nbsp;&nbsp;User groups</h3>
						</div>
						<div class="modal-body" style="margin: 10px;">
							<div class="span12">
								<table class="table table-hover table-bordered">
									<tr>
										<th style="text-align: center">Sr. No.</th>
										<th style="text-align: center">Group name</th>
										<th style="text-align: center">Group description</th>
										<th style="text-align: center">Status</th>
										<?php if(userHasPrivileges("GROUP_SHOW") || userHasPrivileges("GROUP_EDIT") || userHasPrivileges("GROUP_DELETE")) { ?>
											<th style="text-align: center">Action</th>
										<?php } ?>
									</tr>
									<?php
						
										$sql_roles = "SELECT * FROM groups";
										$result_roles = $db_pg->fetchQuery($sql_roles);

										$count=1;
										if(!empty($result_roles))
										{
											foreach($result_roles as $key => $value)
											{
										?>
										<tr>
											<td style="text-align: center"><?php echo $count; ?></td>
											<td style="text-align: center"><?php echo $value['group_name']; ?></td>
											<td style="text-align: center"><?php echo $value['group_description']; ?></td>
											<td style="text-align: center">
												<?php
													if($value['is_active'] == 1)
														echo "Active";
													else
														echo "Inactive";
												?>
											</td>
											<?php if(userHasPrivileges("GROUP_SHOW") || userHasPrivileges("GROUP_EDIT") || userHasPrivileges("GROUP_DELETE")) { ?>
												<td style="text-align: center">
													<?php if(userHasPrivileges("GROUP_SHOW")) { ?>
														<a title="show" href="<?php echo DOMAIN; ?>/user_panel/user_groups/show.php?id=<?php echo $value['id']; ?>"><i class="icon-eye-open"></i></a>
													<?php } ?>
													<?php if(userHasPrivileges("GROUP_EDIT")) { ?>
														<a title="edit" href="<?php echo DOMAIN; ?>/user_panel/user_groups/edit.php?id=<?php echo $value['id']; ?>"><i class="icon-edit"></i></a>
													<?php } ?>
													<?php if(userHasPrivileges("GROUP_DELETE")) { ?>
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
												<td colspan="5"><center><strong>Sorry, no data found.</strong></center></td>
											</tr>
										<?php
										}
										?>
								</table>
							</div>
						</div>
						<div class="modalbox-footer" style="height: 30px;">
							<?php if(userHasPrivileges("GROUP_CREATE")) { ?>
								<a class="btn btn-primary" href="<?php echo DOMAIN; ?>/user_panel/user_groups/create.php">Add new group</a>
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
							entity: "groups",
							join_entity: "groups_privileges",
							role_id: "groups_id"
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
