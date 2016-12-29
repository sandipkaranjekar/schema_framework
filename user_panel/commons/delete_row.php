<?php
	session_start(); 
	require_once('../../configuration.php');
        require_once(LIB.'/db_pg.php');
	if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
	{
		//parse the request body to support PUT & DELETE
		parse_str(file_get_contents("php://input"), $post_vars);
		$id = $post_vars['id'];
		$table_name = $post_vars['entity'];
		$role_id = $post_vars['role_id'];
			
		$flag = false;
		if($id){

			// user image delete
			if($table_name == "users")
			{
				$sql_delete_photo = "SELECT * FROM $table_name WHERE `id` = :id";
				$data_delete_photo = $db_pg->fetchQueryPrepared($sql_delete_photo, array(':id' => $id));

				$image_url = $data_delete_photo['0']['user_photo_path']."".$data_delete_photo['0']['user_photo_name'];
				if(is_file($image_url))
					@unlink($image_url);
			}

			// user image delete
			if($table_name == "project_versions")
			{
				$sql_delete_file = "SELECT * FROM $table_name WHERE `id` = :id";
				$data_delete_file = $db_pg->fetchQueryPrepared($sql_delete_file, array(':id' => $id));

				$file_url = $data_delete_file['0']['version_file_path']."".$data_delete_file['0']['version_file_name'];
				if(is_file($file_url))
					@unlink($file_url);
			}

			$sql_delete = "DELETE FROM $table_name WHERE `id` = :id";
			$data_delete = $db_pg->queryPrepared($sql_delete, array(':id' => $id))->rowCount();
			
			if($data_delete == 1)
			{
				if(!empty($post_vars['join_entity']))
				{
					$join_entity = $post_vars['join_entity'];
					$sql_join_delete = "DELETE FROM $join_entity WHERE $role_id = :id";
					$data_join_delete = $db_pg->queryPrepared($sql_join_delete, array(':id' => $id))->rowCount();
				}
				$flag = true;
			}
			$status = array("status" => $flag);
			echo json_encode($status);
		}
	}
	else
	{
		header("Location:".DOMAIN."/");
	}
?>
