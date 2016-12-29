<div class="span12">
	<ul class="nav nav-tabs navbar-inner nav-header">
		<?php
			if (isset($_SESSION['username']) && isset($_SESSION['user_id']))
     			{
		?>
			<li><a href="<?php echo DOMAIN; ?>/user_panel/dashboard.php">Home</a></li>
		<?php
			}
			else
			{
		?>
				<li><a href="<?php echo DOMAIN; ?>/user_panel/index.php">Home</a></li>
		<?php
			}
		?>
		<li><a href="<?php echo DOMAIN; ?>/includes/about_us.php">About us</a></li>
		<li><a href="<?php echo DOMAIN; ?>/includes/contact_us.php">Contact us</a></li>
	</ul>
</div>

