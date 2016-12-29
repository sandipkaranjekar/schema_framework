<?php

	session_start();

   	 // user privileges
    	function userHasPrivileges($privilege)
    	{
		$flag_privilege = in_array($privilege, $_SESSION['privileges']);
		return $flag_privilege;
    	}
?>
