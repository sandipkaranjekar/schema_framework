<?php
	session_start();

	function bread_crumb()
	{		
		// current url
		$request_url = DOMAIN.$_SERVER['REQUEST_URI'];
		$crumbs_curr = explode("/", $request_url);
	
		// match for index.php in url
		$url_length_curr = count($crumbs_curr);
		$match_curr = strpos($crumbs_curr[$url_length_curr - 1], "index.php");
		
		// if url is requested for index page then only if block executes
		if($crumbs_curr[$url_length_curr - 1] == "" || $match_curr !== false)
		{
			// Get folder name i.e. text for bread crumb
			$crumb_text = ucfirst(str_replace("_", " ", $crumbs_curr[$url_length_curr - 2]));
			$temp = array();
			$temp['crumb_txt'] = $crumb_text;
			$temp['crumb_link'] = $request_url;

			$flag = true;
			// check url already present and remove next all url from current one
			foreach($_SESSION['bread_crumb_arr'] as $key_bread_crumb => $value_bread_crumb)
			{
				if($value_bread_crumb['crumb_txt'] == $crumb_text)
				{
					$flag = false;
					$_SESSION['bread_crumb_arr'] = array_slice($_SESSION['bread_crumb_arr'], 0, $key_bread_crumb+1);
					break;
				}
			}
			if($flag)
				array_push($_SESSION['bread_crumb_arr'], $temp);
		}
		// creating session for back link
		$count = count($_SESSION['bread_crumb_arr']);
		$_SESSION['back_url'] = $_SESSION['bread_crumb_arr'][$count - 1]['crumb_link'];
		
		// show bread crumbs
		foreach($_SESSION['bread_crumb_arr'] as $key_bread_crumb => $value_bread_crumb)
		{
			echo "<a href=".$value_bread_crumb['crumb_link'].">".$value_bread_crumb['crumb_txt']."</a>";
			if($key_bread_crumb + 1 != $count)
				echo "&nbsp;&nbsp;>&nbsp;&nbsp;";
		}
	}
?>
