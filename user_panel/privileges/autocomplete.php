<?php 
session_start();
require_once('../../configuration.php');
require_once(LIB.'db_pg.php');

if(isset($_SESSION['username']) && isset($_SESSION['user_id']))
{
	$term = $_REQUEST['term'];
	$sql_search_version = "SELECT privilege_name FROM privileges WHERE privilege_name LIKE :term AND is_active = true";
	$result_search_version = $db_pg->fetchQueryPrepared($sql_search_version, array(':term' => $term.'%'));
	$return_search_version = array();

	foreach($result_search_version as $privilege => $value)
	{
		array_push($return_search_version, $value['privilege_name']);
	}
	echo json_encode($return_search_version);
}
else
{
	header("Location:".DOMAIN."/");
}
?>
