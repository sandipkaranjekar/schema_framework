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
	    		include_once(LAYOUT.'stylesheet.php');
	     		include_once(LAYOUT.'javascript.php');

			if(isset($_POST['submit']))
			{
				if(isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['contact']) && $_POST['contact'] != "" && isset($_POST['address']) && $_POST['address'] != "" && isset($_POST['designation']) && $_POST['designation'] != "" && isset($_POST['role']) && $_POST['role'] != "")
				{
					$date = date("Y-m-d", strtotime($_POST['dob']));

					$sql = "UPDATE users SET user_name = :user_name, user_email = :user_email, user_contact_no = :user_contact_no, user_address = :user_address, user_designation = :user_designation, roles_id = :roles_id, updated_at = now() WHERE id = :id";

					$flag = $db_pg->queryPrepared($sql, array(':user_name'=>$_POST['name'], ':user_email'=>$_POST['email'], ':user_contact_no'=>$_POST['contact'], ':user_address'=>$_POST['address'], ':user_designation'=>$_POST['designation'], ':roles_id'=>$_POST['role'], ':id'=>$_GET['id']))->rowcount();

					 if($flag != 0)
					  {
						if(!empty($_FILES['upload_photo']['name']))
						{
							if(($_FILES["upload_photo"]["type"] == "image/gif")
							|| ($_FILES["upload_photo"]["type"] == "image/jpeg")
							|| ($_FILES["upload_photo"]["type"] == "image/png")
							|| ($_FILES["upload_photo"]["type"] == "image/pjpeg"))
							{
								$uniqfilename = md5(uniqid());
								$ext = pathinfo($_FILES["upload_photo"]["name"], PATHINFO_EXTENSION);

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

								# select photo
								$sql_photos = "SELECT * FROM `users` WHERE `id` = :id";
								$data_photos = $db_pg->fetchQueryPrepared($sql_photos, array(':id' => $_GET['id']));
	
								# delete old photo
								$main_photos = $data_photos[0]['user_photo_path']."".$data_photos[0]['user_photo_name'];
	
								if(is_file($main_photos))
									@unlink($main_photos);
					
								$sql_ephoto = "UPDATE users SET user_photo_name = :user_photo_name, user_photo_type = :user_photo_type, user_photo_path = :user_photo_path, user_photo_size = :user_photo_size WHERE id = :id";
					$flag_ephoto = $db_pg->queryPrepared($sql_ephoto, array(':user_photo_name' => $photo_name, ':user_photo_type' => $photo_type, ':user_photo_path' => $original_path, ':user_photo_size' => $photo_size, ':id' => $_GET['id']))->rowcount();
						
								$flash_notice = "alert-success";
								$flash_msg = "Data updated successfully.";	  		
							}
							else
							{
								$flash_notice = "alert-error";
								$flash_msg = "Invalid photo";
							}
						}
						else
						{
							$flash_notice = "alert-success";
							$flash_msg = "Data updated successfully.";	
						}
					}
					else
					{
						$flash_notice = "";
					  	$flash_msg = "We are sorry.But something went wrong";
					}
				}
				else
				{
				  	$flash_notice = "alert-error";
				 	$flash_msg = "All feilds are compulsary.";
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
						if(isset($_GET['id']) && $_GET['id'] != "")
						{
							$sql_edit = "SELECT users.user_name, users.user_email, users.user_contact_no, users.user_address, users.user_designation, users.user_photo_path, users.user_photo_name, roles.id, roles.role_name FROM users INNER JOIN roles ON users.roles_id = roles.id WHERE users.id = :id";
							$result_edit = $db_pg->fetchQueryPrepared($sql_edit, array(':id' => $_GET['id']));
						}
						else
						{
							header("Location:".DOMAIN."/user_panel/users/");
						}

						if(isset($flash_notice) && isset($flash_msg))
						{
					?>
							<div class=" small_alert alert <?php echo $flash_notice; ?>">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?php echo $flash_msg; ?>
							</div>
					<?php
						}
					?>
					<form method="post" enctype="multipart/form-data" id="frm_registration">
						<div class="modalbox">
							<div class="modal-header">
					 			<h3><i class="icon-user"></i>&nbsp;&nbsp;Edit User registeration</h3>
							</div>
							<div class="modal-body" style="margin-left: 0px;">
								<div class="row-fluid">
									<div class="span8">
										<table border="0" align="center">
											<tr>
												<td>Name :</td>
												<td><input type="text" name="name" value="<?php echo $result_edit['0']['user_name']; ?>"></td>
											</tr>
											<tr>
												<td>E-Mail / username :</td>
												<td><input type="text" name="email" value="<?php echo $result_edit['0']['user_email']; ?>"></td>
											</tr>
											<tr>
												<td>Contact No. :</td>
												<td><input type="text" name="contact" id="contact" value="<?php echo $result_edit['0']['user_contact_no']; ?>"></td>
											</tr>
											<tr>
												<td>Address :</td>
												<td><textarea rows="3" name="address"><?php echo $result_edit['0']['user_address']; ?></textarea></td>
											</tr>
											<tr>
												<td>Designation :</td>
												<td>
													<select name="designation" id="designation">
														<option value="">Select</option>
														<option value="Sales" <?php echo $select = (($result_edit['0']['user_designation'] == 'Sales') ? "selected = 'selected'" : null); ?>>Sales</option>
														<option value="TL" <?php echo $select = (($result_edit[0]['user_designation'] == 'TL') ? "selected = 'selected'" : null); ?>>TL</option>
														<option value="Project manager" <?php echo $select = (($result_edit['0']['user_designation'] == 'Project manager') ? "selected = 'selected'" : null); ?>>Project manager</option>
														<option value="Manager" <?php echo $select = (($result_edit['0']['user_designation'] == 'Manager') ? "selected = 'selected'" : null); ?>>Manager</option>
														<option value="Other" <?php echo $select = (($result_edit['0']['user_designation'] == 'Other') ? "selected = 'selected'" : null); ?>>Other</option>
													</select>
												</td>
											</tr>
											<tr>
												<td>User role :</td>
												<td>
													<select name="role" id="role">
														<option value="">Select</option>
														<?php
															$sql_role = "SELECT * FROM roles";
															$result_role = $db_pg->fetchQuery($sql_role);
															foreach($result_role as $role => $value)
															{
						if($result_edit['0']['id'] == $value['id'])
						{
						?>
							<option value="<?php echo $value['id']; ?>" selected="selected"><?php echo $value['role_name']; ?></option>
						<?php
						}
						else
						{
						?>
							<option value="<?php echo $value['id']; ?>"><?php echo $value['role_name']; ?></option>
														<?php
						}
															 } 
														?>
													</select>
												</td>
											</tr>
										</table>
									</div>
									<div class="span4">
										<img class="thumbnail" src="<?php echo $result_edit['0']['user_photo_path']. $result_edit['0']['user_photo_name']; ?>" />
										<input type="file" name="upload_photo">
									</div>
								</div>
							</div>
							<div class="modalbox-footer">
								<input type="submit" value="Update" name="submit" class="btn btn-primary">
								<a class="btn" href="<?php echo DOMAIN; ?>/user_panel/users/"><i class="icon-reply"></i>&nbsp;&nbsp;Back</a>
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
