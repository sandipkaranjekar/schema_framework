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
			
			if(isset($_GET['id']) && $_GET['id'] != "")
			{
				$sql_show_privileges = "SELECT privileges.id, privileges.privilege_name, privileges.privilege_description, privileges.is_active, system_modules.system_module_name FROM privileges INNER JOIN system_modules ON privileges.modules_id = system_modules.id WHERE privileges.id = :id";

				$result_show_privileges = $db_pg->fetchQueryPrepared($sql_show_privileges, array(':id' => $_GET['id']));
			}
			else
			{
				header("Location:".DOMAIN."/user_panel/privileges/");
			}
		?>
	</head>
	<body>
		 <div class="container-fluid">
    			<div class="row-fluid">
				<?php include_once(LAYOUT.'header.php'); ?>
			</div>

			<div class="row-fluid grid_960_system">
				<div class="span12">
					<form method="post">
						<div class="modalbox">
							<div class="modal-header" style="margin: 10px;">
					 			<h3><i class="icon-check"></i>&nbsp;&nbsp;Privilege</h3>
							</div>
							<div class="modal-body" style="margin: 10px;">
								<table border="0" align="center" cellpadding="10">
									<tr>
										<td><b>Privilege name</b></td>
										<td><b>:</b></td>
										<td><?php echo $result_show_privileges['0']['privilege_name']; ?></td>
									</tr>

									<tr>
										<td><b>Privilege description</b></td>
										<td><b>:</b></td>
										<td><?php echo $result_show_privileges['0']['privilege_description']; ?></td>
									</tr>
									
									<tr>
										<td><b>System module</b></td>
										<td><b>:</b></td>
										<td><?php echo $result_show_privileges['0']['system_module_name']; ?></td>
									</tr>
	
									<tr>
										<td><b>Status</b></td>
										<td><b>:</b></td>
										<td>
											<?php
												if($result_show_privileges['0']['is_active'] == 1)
													echo "Active";
												else
													echo "Inactive";
											?>
										</td>
									</tr>
								</table>	
							</div>
							<div class="modalbox-footer" style="height: 30px;">
								<?php if(userHasPrivileges("PRIVILEGE_EDIT")) { ?>
									<a class="btn btn-primary" href="<?php echo DOMAIN; ?>/user_panel/privileges/edit.php?id=<?php echo $_GET['id']; ?>">Edit</a>
								<?php } ?>
								<a class="btn" href="<?php echo DOMAIN; ?>/user_panel/privileges/"><i class="icon-reply"></i>&nbsp;&nbsp;Back</a>
							</div>
						</div>
					</form>		
				</div>
			</div>
			
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
