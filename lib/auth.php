<?php
     session_start();
     require_once('../configuration.php');
     require_once(LIB.'db_pg.php');

	if (!isset($_SESSION['username']) && !isset($_SESSION['user_id']))
     	{
         	$uname = $_REQUEST['username'];
         	$pass = md5($_REQUEST['password']);
		 if($uname != '' && $pass != '')
		 {
		    	$sql = "SELECT * FROM users WHERE user_email = :uname AND user_password = :pass AND is_active = true";
		    	$result = $db_pg->fetchQueryPrepared($sql, array(':uname'=>$uname,':pass'=>$pass));
			if(!empty($result))
			{
				$_SESSION['username'] = $result[0]['user_name'];
				$_SESSION['user_id'] = $result[0]['id'];

				$sql_privileges = "SELECT privilege_name FROM privileges WHERE privileges.id in (select privilege_id from groups_privileges where groups_id IN (SELECT groups_id FROM roles_groups WHERE roles_id = :role_id))";
		
				$result_privileges = $db_pg->fetchQueryPrepared($sql_privileges, array(':role_id' => $result[0]['roles_id']));
		
				$temp_privileges = array();
				foreach($result_privileges as $key_privilege => $value_privilege)
					array_push($temp_privileges, $value_privilege['privilege_name']);

				$_SESSION['privileges'] = $temp_privileges;

				header("Location:".DOMAIN."/user_panel/index.php");
			}
		    	else
		    	{
		      		$login="false";
		      		header("Location:".DOMAIN."/index.php?login=$login");
		    	} 
       		}
       		else
       		{
            		$login="blank";
           		 header("Location:".DOMAIN."/index.php?login=$login");
       		}
    	}
    	else
    	{
         	if(isset($_GET['login']))
         	{
           		$login = $_GET['login'];
           		if($login == 'logout')
           		{
             			session_destroy();
             			header("Location:".DOMAIN."/index.php?login=logout");
          		 }
        	 }
   	 }
?>
