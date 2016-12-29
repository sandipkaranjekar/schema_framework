<?php 
session_start();
require_once('../../configuration.php');
require_once(LIB.'db_pg.php');

if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
{
	$rol_name = $_GET['role_name'];
	$field_name = $_GET['entity1'];
	$table_name = $_GET['entity2'];
	
	$sql_exist = "SELECT $field_name FROM $table_name WHERE $field_name = :role_name";
	$result_exist = $db_pg->fetchQueryPrepared($sql_exist, array(':role_name' => $rol_name));	
	
	if(!empty($result_exist))
		$flag = true;
	else
		$flag = false;

	$status = array("status" => $flag);
	echo json_encode($status);	
}
else
{
	header("Location:".DOMAIN."/");
}		
?>
