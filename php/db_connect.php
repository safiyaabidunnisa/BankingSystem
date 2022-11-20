<?php

	$con = mysqli_connect("localhost","root","");
	if(mysqli_connect_error())
	{
		die("Unable to connect".mysqli_connect_error());
	}
	mysqli_select_db($con,"bankDB");

?>