<?php

$dbhost = "localhost";
$username = "root";
$databasename = "coinmarketcap";
$password = "";

$connection = new mysqli($dbhost, $username, $password, $databasename);

if($connection->connect_error)
{
	echo "Connection Failed! ".$connection->connect_error;
}
?>