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
			include_once(LIB.'rbac.php');
		?>
		<script>
			$(document).ready(function(){
				$("#tags").autocomplete({
					source: "autocomplete.php",
		    			minLength:1
				});
			});
		</script>
	</head>
	<body>
		 <div class="container-fluid">
    			<div class="row-fluid">
				<?php include_once(LAYOUT.'header.php'); ?>
			</div>

			<div class="row-fluid grid_960_system">
				<div class="span12">
					<div class="modalbox">
						<div class="modal-header">
				 			<h3><i class="icon-check"></i>&nbsp;&nbsp;Privilege</h3>
							<form method="post" style="margin-bottom: 0px;">
								<div class="row-fluid" class = "pull-right" style = "display: inline-block;">
									<div class="span7 offset5">
										<input type="text" class="input-xlarge search-query" name="term" id="tags" placeholder = "Privilege name">
										<button type="submit" class="btn btn-primary" name="submit"><i class="icon-search"></i>&nbsp;&nbsp;Search</button>
									</div>
								</div>
							</form>
						</div>
						<div class="modal-body" style="margin: 10px;">
							<div class="span12">
								<table class="table table-hover table-bordered">
									<tr>
										<th style="text-align: center">Sr. No.</th>
										<th style="text-align: center">Privilege name</th>
										<th style="text-align: center">Privilege description</th>
										<th style="text-align: center">System module</th>
										<th style="text-align: center">Status</th>
										<?php if(userHasPrivileges("PRIVILEGE_SHOW") || userHasPrivileges("PRIVILEGE_EDIT") || userHasPrivileges("PRIVILEGE_DELETE")) { ?>
											<th style="text-align: center">Action</th>
										<?php } ?>
									</tr>
									<?php
										if($_POST['term'] == "")
										{
											$sql_roles = "SELECT privileges.id, privileges.privilege_name, privileges.privilege_description, privileges.is_active, system_modules.system_module_name FROM privileges INNER JOIN system_modules ON privileges.modules_id = system_modules.id";
											$result = $db_pg->fetchQuery($sql_roles);
										}
										else
										{
											$sql_privilege = "SELECT privileges.id, privileges.privilege_name, privileges.privilege_description, privileges.is_active, system_modules.system_module_name FROM privileges INNER JOIN system_modules ON privileges.modules_id = system_modules.id WHERE privileges.privilege_name = :privilege_name";
											$result = $db_pg->fetchQueryPrepared($sql_privilege, array(':privilege_name' => $_POST['term']));
										}
										$count=1;
										if(!empty($result))
										{
											foreach($result as $key => $value)
											{
										?>
										<tr>
											<td style="text-align: center"><?php echo $count; ?></td>
											<td style="text-align: center"><?php echo $value['privilege_name']; ?></td>
											<td style="text-align: center"><?php echo $value['privilege_description']; ?></td>
											<td style="text-align: center"><?php echo $value['system_module_name']; ?></td>
											<td style="text-align: center">
												<?php
													if($value['is_active'] == 1)
														echo "Active";
													else
														echo "Inactive";
												?>
											</td>
											<?php if(userHasPrivileges("PRIVILEGE_SHOW") || userHasPrivileges("PRIVILEGE_EDIT") || userHasPrivileges("PRIVILEGE_DELETE")) { ?>
												<td style="text-align: center">
													<?php if(userHasPrivileges("PRIVILEGE_SHOW")) { ?>
														<a title="show" href="<?php echo DOMAIN; ?>/user_panel/privileges/show.php?id=<?php echo $value['id']; ?>"><i class="icon-eye-open"></i></a>
													<?php } ?>
													<?php if(userHasPrivileges("PRIVILEGE_EDIT")) { ?>
														<a title="edit" href="<?php echo DOMAIN; ?>/user_panel/privileges/edit.php?id=<?php echo $value['id']; ?>"><i class="icon-edit"></i></a>
													<?php } ?>
													<?php if(userHasPrivileges("PRIVILEGE_DELETE")) { ?>
														<a title="delete" id="delete_<?php echo $value['id']; ?>"><i class="icon-remove"></i></a>
													<?php } ?>	
												</td>
											<?php } ?>
									  	 </tr>
										<?php 
											$count++; 
											} // foreach ends
										}
										else
										{
										?>
											<tr><td colspan="6"><center><strong>Sorry, no data found.</strong></center></td></tr>
										<?php
										}
										?>										
								</table>
							</div>
						</div>
						<div class="modalbox-footer" style="height: 30px;">
							<?php if(userHasPrivileges("PRIVILEGE_CREATE")) { ?>
								<a class="btn btn-primary" href="<?php echo DOMAIN; ?>/user_panel/privileges/create.php">Add new privilege</a>
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
							entity: "privileges"
				    		},
				    		success: function(data){
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
