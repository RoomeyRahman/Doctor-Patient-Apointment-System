<!doctype html>
<html>
<head><!doctype html>
<?php
	include('Users.php');
	session_start();
	$userAssoc = $_SESSION['userAssoc'];
	if(!isset($_SESSION['userAssoc'])){
		//header('Location: index.php');
	}
	$allUser=new AllUser;

?>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<?php include('bootstrapIncluder.php')?>
</head>

<body>
<?php include('sidebar.php');?>
								
		<table class="table table-inverse">
		  <thead>
			<tr>
			  <th width="9%">Serial</th>
			  <th width="17%">Patient Name</th>
			  <th width="17%">Date</th>
			  <th width="20%">Message</th>
			</tr>
		  </thead>
		  <tbody>
		  <?php
			$temp=$allUser->getAppointemtQueryResultP($userAssoc['u_id']);
			$count = 0;
			while($result = mysqli_fetch_assoc($temp)){
				$count++;
			  ?>
			<tr>
			  <th scope="row"><?php echo($count)?></th>
			  <?php
			  	$result3 = $allUser->getNameEmailPatineInfo($result['p_id']);
				$result4 = mysqli_fetch_assoc($result3);
				 ?>
			  <td><?php echo($result4['name'])?></td>
			  <td><?php echo($result['date'])?></td>
			  
			  <td><?php if($result['status']==1){echo("your appointment is accepted");} else {echo('your appointment is in pending');}?></td>
			 
			</tr>
				
			<?php
													  }
			  	?>
			
		  </tbody>
		</table>
