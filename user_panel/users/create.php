<?php 
session_start();
require_once('../../configuration.php');

if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>User registration</title>
		<?php
			require_once(LIB.'db_pg.php');
			require_once(LIB.'util.php');
	    		include_once(LAYOUT.'stylesheet.php');
	     		include_once(LAYOUT.'javascript.php');

			if(isset($_POST['submit']))
			{
				if(isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['gender']) && $_POST['gender'] != "" && isset($_POST['contact']) && $_POST['contact'] != "" && isset($_POST['dob']) && $_POST['dob'] != "" && isset($_POST['address']) && $_POST['address'] != "" && isset($_POST['designation']) && $_POST['designation'] != "" && isset($_POST['role']) && $_POST['role'] != "")
				{
					if(($_FILES["upload_photo"]["type"] == "image/gif")
					|| ($_FILES["upload_photo"]["type"] == "image/jpeg")
					|| ($_FILES["upload_photo"]["type"] == "image/png")
					|| ($_FILES["upload_photo"]["type"] == "image/pjpeg"))
					{
						$uniqfilename = md5(uniqid());
						$ext = pathinfo($_FILES["upload_photo"]["name"], PATHINFO_EXTENSION);
						
						$user_password = $util->randomPassword();
						$user_password12 = md5($user_password);
						$this_year = date("Y");
						$this_month = date("F");
					
						if(!is_dir("../../uploads/photos/".$this_year))
						{
							mkdir("../../uploads/photos/".$this_year, 0777, 'R');
							mkdir("../../uploads/photos/".$this_year."/".$this_month, 0777, 'R');
							mkdir("../../uploads/photos/".$this_year."/".$this_month."/originals", 0777, 'R');
						}
						else
						{
							if(!is_dir("../../uploads/photos/".$this_year."/".$this_month))
							{
								mkdir("../../uploads/photos/".$this_year."/".$this_month, 0777, 'R');
								mkdir("../../uploads/photos/".$this_year."/".$this_month."/originals", 0777, 'R');
							}
						}
						$original_path = "../../uploads/photos/".$this_year."/".$this_month."/originals/";

						move_uploaded_file($_FILES["upload_photo"]["tmp_name"], $original_path.$uniqfilename.".".$ext);

						$photo_size = $_FILES["upload_photo"]["size"];
						$photo_type = $_FILES["upload_photo"]["type"];
						$photo_name = $uniqfilename.".".$ext;
						$date = date("Y-m-d", strtotime($_POST['dob']));				
					
						$sql_photo = "INSERT INTO `users`(`id`, `user_name`, `user_email`, `user_password`, `user_gender`, `user_contact_no`, `user_dob`, `user_address`, `user_designation`, `roles_id`, `user_photo_name`, `user_photo_type`, `user_photo_path`, `user_photo_size`, `created_at`, `updated_at`) VALUES ('', :user_name, :user_email, :user_password, :user_gender, :user_contact_no, :user_dob, :user_address, :user_designation, :roles_id, :user_photo_name, :user_photo_type, :user_photo_path, :user_photo_size, now(), now())";
					  	$flag = $db_pg->queryPrepared($sql_photo, array(':user_name' => $_POST['name'], ':user_email' => $_POST['email'], ':user_password' => $user_password12, ':user_gender' => $_POST['gender'], ':user_contact_no' => $_POST['contact'], ':user_dob' => $date, ':user_address' => $_POST['address'], ':user_designation' => $_POST['designation'], ':roles_id' => $_POST['role'], ':user_photo_name' => $photo_name, ':user_photo_type' => $photo_type, ':user_photo_path' => $original_path, ':user_photo_size' => $photo_size))->rowcount();
					  
						if($flag != 0)
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
						$flash_message = "Invalid photo";
					}
				}
				else
				{
				  $flash_type = "alert-error";
				  $flash_message = "All feilds are compulsary.";
				}
		     	}
		?>
		<script>
			$(document).ready(function(){
				// date of birth date picker
				$("#dob").datepicker();
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
					<form method="post" enctype="multipart/form-data" id="frm_registration">
						<div class="modalbox">
							<div class="modal-header">
					 			<h3><i class="icon-user"></i>&nbsp;&nbsp;User registeration</h3>
							</div>
							<div class="modal-body" style="margin-left: 0px;">
								<div class="row-fluid">
									<div class="span8">
										<table border="0" align="center">
											<tr>
												<td>Name :</td>
												<td colspan="2"><input type="text" name="name" id="name"></td>
											</tr>
											<tr>
												<td>E-Mail / username :</td>
												<td colspan="2"><input type="text" name="email" id="email"></td>
											</tr>
											<tr>
												<td>Gender :</td>
												<td><label class="radio"><input type="radio" name="gender" id="gender" value="Male" checked="checked">Male</label></td>
												<td><label class="radio"><input type="radio" name="gender" id="gender" value="Female">Female</label></td>
											</tr>
											<tr>
												<td>Contact No :</td>
												<td colspan="2"><input type="text" name="contact" id="contact"></td>
											</tr>
											<tr>
												<td>Date of birth :</td>
												<td colspan="2"><input type="text" name="dob" id="dob"></td>
											</tr>
											<tr>
												<td>Address :</td>
												<td colspan="2"><textarea rows="3" name="address" id="address"></textarea></td>
											</tr>
											<tr>
												<td>Designation :</td>
												<td colspan="2">
													<select name="designation" id="designation">
														<option value="">Select</option>
														<option>Sales</option>
														<option>TL</option>
														<option>Project manager</option>
														<option>Manager</option>
														<option>Other</option>
													</select>
												</td>
											</tr>
											<tr>
												<td>User role :</td>
												<td colspan="2">
													<select name="role" id="role">
														<option value="">Select</option>
														<?php
															$sql_role = "SELECT * FROM roles";
															$result_role = $db_pg->fetchQuery($sql_role);
															foreach($result_role as $role => $value)
															{
														?>
														<option value="<?php echo $value['id']; ?>"><?php echo $value['role_name']; ?></option>
														<?php
															 } 
														?>
													</select>
												</td>
											</tr>
										</table>
									</div>
									<div class="span4">
										<img class="thumbnail" src="../../img/default.png">
										<input type="file" name="upload_photo">
									</div>
								</div>
							</div>
							<div class="modalbox-footer">
								<input type="submit" value="Create" name="submit" class="btn btn-primary">
								<input type="reset" value="Clear" class="btn" />
								<a class="btn" href="<?php echo DOMAIN; ?>/user_panel/users/index.php"><i class="icon-reply"></i>&nbsp;&nbsp;Back</a>
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

	</body>
</html>
<?php 
}
else
{
	header("Location:".DOMAIN."/");
}
?>
