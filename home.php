<!doctype html>
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
<?php 
	
	if($_SESSION['patientAssoc'] != "")
	{ 
		$error=$allUser->redPara("");
	if($_POST){
		
		echo($userAssoc['u_id']);
		$error=$allUser->validateAppointmentForm($_POST,$userAssoc['u_id']);
	}
?>
		<div class="main">
<div class="container">
	<div class="row">
<div class="col-md-6">
                    <div class="well-block">
                        <div class="well-title">
                            <h2>Book an Appointment</h2>
                        </div>
                        <form action="home.php" method="post" >
                            <!-- Form start -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Patient's Name</label>
                                        <input id="name" e name="p_name" type="text" placeholder="Name" required class="form-control input-md">
                                    </div>
                                </div>
                                <!-- Text input-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="email">Email</label>
                                        <input id="email" name="email" type="text" placeholder="E-Mail" required class="form-control input-md">
                                    </div>
                                </div>
                                <!-- Text input-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="date">Preferred Date</label>
                                        <input id="date" name="date" type="date" placeholder="Preferred Date" required class="form-control input-md">
                                    </div>
                                </div>
                                <!-- Select Basic -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="time">Preferred Time</label>
                                        <select id="time" name="time" class="form-control">
                                            <option value="10:00" selected>10:00am to 10:15am</option>
                                            <option value="10:15">10:15 to 10:30</option>
                                            <option value="10:30">10:30 to 10:45</option>
                                            <option value="10:45">10:45 to 11:00</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="email">Problem</label>
                                        <textarea  id="problem" name="problem" type="text" placeholder="Problem" required class="form-control input-md"></textarea>
                                    </div>
                                </div>
                                <!-- Select Basic -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="appointmentfor">Appointment To</label>
                                        <select id="appointmentto" name="appointmentto" class="form-control">
                                            <?php 
	 $numRow = mysqli_num_rows($allUser->getDoctorQueryResult());
	 $count =0;
	 $result1=$allUser->getDoctorQueryResult();
	 while($result=mysqli_fetch_assoc($result1)){ 
		 $count++;
		 
											?>
													<option value="<?php echo($result['d_id']);?>"><?php echo($result['name'])?> (<?php echo($result['dept'])?>)</option>
											<?php
												if($count==$numRow){
													 break;
												 }
																													 }
                                           ?>
                                          
                                        </select>
                                    </div>
                                </div>
                                <!-- Button -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button id="singlebutton" name="singlebutton" class="btn btn-default">Make An Appointment</button>
                                        
                                    </div>
                                    <?php echo($error);?>
                                </div>
                            </div>
                        </form>
                        <!-- form end -->
                    </div>
                </div>	
                </div>
</div>
</div>
	<?php
										} else { ?>
								
		<table class="table table-inverse">
		  <thead>
			<tr>
			  <th width="9%">Serial</th>
			  <th width="17%">Patient Name</th>
			  <th width="8%">Email</th>
			  <th width="18%">Prefered Date</th>
			  <th width="18%">Prefered Time</th>
			  <th width="20%">Problem</th>
			</tr>
		  </thead>
		  <tbody>
		  <?php
			$temp=$allUser->getAppointemtQueryResult($userAssoc['u_id']);
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
			  <td><?php echo($result4['email'])?></td>
			  <td><?php echo($result['date'])?></td>
			  <td><?php echo($result['time'])?></td>
			  <td><?php echo($result['problem'])?></td>
			  <td><?php if($result['status']==0){echo('pending');}else{echo('Accepted');}?></td>
			  <td width="5%"><a href="accept.php?a_id=<?php echo($result['a_id'])?>">Accept</a></td>
			  <td width="5%"><a href="cancel.php?a_id=<?php echo($result['a_id'])?>">Cancel</a></td>
			</tr>
				
			<?php
													  }
			  	?>
			
		  </tbody>
		</table>

	<?php
											   }
	?>

	
</body>
</html>