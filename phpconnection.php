<?php 
$db_host='localhost';
$db_user='root';
$db_pass='';
$conn = mysqli_connect($db_host, $db_user, $db_pass, 'fpt_aptech');
	if (!$conn) {
	    die("Không kết nối :" . mysqli_connect_error());
	    exit(); }
mysqli_set_charset($conn,"utf8");


