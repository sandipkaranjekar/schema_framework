<?php
class util
{
    public $result;

    // random password generation
    public function randomPassword() 
    {
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
    }

    // get offset and end (pagination)
    public function pagination($currentpage, $numrows) 
    {
                // number of rows to show per page
		$rowsperpage = 10;
		// find out total pages
		$totalpages = ceil($numrows / $rowsperpage);

		// get the current page or set a default
		if ($currentpage == "" && is_numeric($currentpage)) {
		   // cast var as int
		   $currentpage = (int) $currentpage;
		} else {
		   // default page num
		   $currentpage = 1;
		} // end if

		// if current page is greater than total pages...
		if ($currentpage > $totalpages) {
		   // set current page to last page
		   $currentpage = $totalpages;
		} // end if
		// if current page is less than first page...
		if ($currentpage < 1) {
		   // set current page to first page
		   $currentpage = 1;
		} // end if

		// the offset of the list, based on current page 
		$offset = ($currentpage - 1) * $rowsperpage;
		/******  build the pagination links ******/
		// range of num links to show
		$range = 3;

		// if not on page 1, don't show back links
		if ($currentpage > 1) {
		   // show << link to go back to page 1
		   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> ";
		   // get previous page num
		   $prevpage = $currentpage - 1;
		   // show < link to go back to 1 page
		   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a> ";
		} // end if 

		// loop to show links to range of pages around current page
		for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
		   // if it's a valid page number...
		   if (($x > 0) && ($x <= $totalpages)) {
		      // if we're on current page...
		      if ($x == $currentpage) {
			 // 'highlight' it but don't make a link
			 echo " [<b>$x</b>] ";
		      // if not current page...
		      } else {
			 // make it a link
			 echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
		      } // end else
		   } // end if 
		} // end for
				 
		// if not on last page, show forward and last page links        
		if ($currentpage != $totalpages) {
		   // get next page
		   $nextpage = $currentpage + 1;
		    // echo forward link for next page 
		   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a> ";
		   // echo forward link for lastpage
		   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a> ";
		} // end if
		/****** end build pagination links ******/
    }
    
    
}
$util = new util();
?>
