<?php

	/*mysql connecting to fetch all the FL stations and their locations.
	change your username and password before running*/
	$con = mysql_connect("localhost","","") or die(mysql_error());
	mysql_select_db("peanut") or die(mysql_error());

?>
