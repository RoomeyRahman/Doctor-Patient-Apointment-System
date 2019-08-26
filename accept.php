<?php
	include('Users.php');
	$a_id = $_GET['a_id'];
	$basicUser = new AllUser;
	$basicUser->acceptAppointment($a_id);
	header("Location: home.php");
?>