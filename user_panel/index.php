<?php 
session_start();
require_once('../configuration.php');
require_once(LIB.'db_pg.php');

if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Dashboard</title>
		<?php
	    		include_once(LAYOUT.'stylesheet.php');
	     		include_once(LAYOUT.'javascript.php');
			include_once(LIB.'rbac.php');

			$sql_projects = "SELECT * FROM projects WHERE id IN (SELECT projects_id FROM users_projects WHERE users_id = :users_id)";
			$result_projects = $db_pg->fetchQueryPrepared($sql_projects, array(':users_id' => $_SESSION['user_id']));
		?>
	</head>
	<body>
		 <div class="container-fluid">
    			<div class="row-fluid">
				<?php include_once(LAYOUT.'header.php'); ?>
			</div>
			<div class="row-fluid nav nav-tabs">
				<div class="offset1 span5">
					<a href="<?php echo DOMAIN; ?>/user_panel/"><h3 style="margin-top: -10px;"><i class="icon-dashboard"></i>&nbsp;Dashboard</h3></a>
				</div>
				<div class="span6">
					<ul class="unstyled pull-right" style="margin-right: 10px;">
					  	<li class="dropdown">
					    		<a class="btn btn-primary" href="#" class="dropdown-toggle" data-toggle="dropdown">
					     			<?php echo "Welcome"." ".$_SESSION['username']; ?>&nbsp;&nbsp;<i class="icon-user"></i>
					      			<b class="caret"></b>
					    		</a>
						    	<ul class="dropdown-menu" style="margin-left: 50px;">
						      		<li><a href="#"><i class="icon-user"></i> profile</a></li>
								<li><a href="<?php echo DOMAIN; ?>/lib/auth.php?login=logout"><i class="icon-off"></i> logout</a></li>
						    	</ul>
					  	</li>
					</ul>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span2">
					<ul>
						<li class="thumbnail aaa">
							<a href="<?php echo DOMAIN; ?>/user_panel/" class="dashboard_icon_color"><i class="icon-dashboard dashboard_icon"></i>&nbsp;&nbsp;Dashboard</a>
						</li>
					<?php if(userHasPrivileges("USER_LIST")) { ?>
						<li class="thumbnail aaa">
							<a href="<?php echo DOMAIN; ?>/user_panel/users/" class="dashboard_icon_color"><i class="icon-user dashboard_icon"></i>&nbsp;&nbsp;User list</a>
						</li>
					<?php } ?>
					<?php if(userHasPrivileges("ROLE_LIST")) { ?>
						<li class="thumbnail aaa">
							<a href="<?php echo DOMAIN; ?>/user_panel/user_roles/" class="dashboard_icon_color"><i class="icon-sitemap dashboard_icon"></i>&nbsp;&nbsp;User roles</a>
						</li>
					<?php } ?>
					<?php if(userHasPrivileges("GROUP_LIST")) { ?>
						<li class="thumbnail aaa">
							<a href="<?php echo DOMAIN; ?>/user_panel/user_groups/" class="dashboard_icon_color"><i class="icon-group dashboard_icon"></i>&nbsp;&nbsp;User groups</a>
						</li>
					<?php } ?>
					<?php if(userHasPrivileges("PRIVILEGE_LIST")) { ?>
						<li class="thumbnail aaa">
							<a href="<?php echo DOMAIN; ?>/user_panel/privileges/" class="dashboard_icon_color"><i class="icon-check dashboard_icon"></i>&nbsp;&nbsp;Privileges</a>
						</li>
					<?php } ?>
					<?php if(userHasPrivileges("SYSTEM_MODULE_LIST")) { ?>
						<li class="thumbnail aaa">
							<a href="<?php echo DOMAIN; ?>/user_panel/system_modules/" class="dashboard_icon_color"><i class="icon-cogs dashboard_icon"></i>&nbsp;&nbsp;System modules</a>
						</li>
					<?php } ?>
					</ul>
				</div>
				<div class="span10">
				
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
