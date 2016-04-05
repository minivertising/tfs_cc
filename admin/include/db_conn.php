<?php
	$my_db = mysqli_connect("localhost", "root", "m!nv#Rtisin9", "clouding");
	if (mysqli_connect_error()) {
		exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
	}
?>
