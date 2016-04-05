<?
    /******************************************************************************
     *
     * dbi.php
     *
     * Configuration file
     *
     * Created : 2014
     *
     ******************************************************************************/
	$my_db = new mysqli("localhost", "root", "86alslqjxkdlwld@%*)", "belif_billy2");
	//$my_db = new mysqli("localhost", "root", "7alslqjxkdlwld@%*)", "belif_billy2");
	if (mysqli_connect_error()) {
		exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
	}
?>
