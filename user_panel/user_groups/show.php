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
			
			if(isset($_GET['id']) && $_GET['id'] != "")
			{
				$sql_show_groups = "SELECT * FROM groups WHERE id = :id";
				$result_show_groups = $db_pg->fetchQueryPrepared($sql_show_groups, array(':id' => $_GET['id']));
			}
			else
			{
				header("Location:".DOMAIN."/user_panel/user_groups/");
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
					 			<h3><i class="icon-group"></i>&nbsp;&nbsp;User groups</h3>
							</div>
							<div class="modal-body" style="margin: 10px;">
								<table border="0" align="center" cellpadding="10">
									<tr>
										<td><b>Group name</b></td>
										<td><b>:</b></td>
										<td><?php echo $result_show_groups['0']['group_name']; ?></td>
									</tr>

									<tr>
										<td><b>Group description</b></td>
										<td><b>:</b></td>
										<td><?php echo $result_show_groups['0']['group_description']; ?></td>
									</tr>
	
									<tr>
										<td><b>Status</b></td>
										<td><b>:</b></td>
										<td>
											<?php
												if($result_show_groups['0']['is_active'] == 1)
													echo "Active";
												else
													echo "Inactive";
											?>
										</td>
									</tr>
								</table>	
							</div>
							<div class="modalbox-footer" style="height: 30px;">
								<?php if(userHasPrivileges("GROUP_EDIT")) { ?>
									<a class="btn btn-primary" href="<?php echo DOMAIN; ?>/user_panel/user_groups/edit.php?id=<?php echo $_GET['id']; ?>">Edit</a>
								<?php } ?>
								<a class="btn" href="<?php echo DOMAIN; ?>/user_panel/user_groups/"><i class="icon-reply"></i>&nbsp;&nbsp;Back</a>
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
