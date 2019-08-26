<?php
	include('Users.php');
	$basicUser = new AllUser;
	$error = array();
	if($_POST){
		$error = $basicUser->patientRegistrationFormValidation($_POST);
	}
?>
<html>
	<head>
		<?php include('bootstrapIncluder.php');?>
	</head>
	<body>
			<div   class="col-sm-10 col-sm-offset-5 col-md-4 col-md-offset-4 main">
			<div class="row main">
				<div class="panel-heading">
	               <div class="panel-title text-center">
	               		<h1 class="title">DPAS</h1>
	               		<hr />
	               	</div>
	            </div> 
				<div class="main-login main-center">
					<form class="form-horizontal" method="post" action="registration.php">
					
					<div class="radio radio-primary">
            			<input type="radio" name="patient" checked>
            				<label for="radio">
                					Patient &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           					 </label>
           					 <input type="radio" name="doctor" onClick="window.location='d_registration.php'">
            				<label for="radio">
                					         Doctor
           					 </label>
      				  </div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Your Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="p_name" id="name"  placeholder="Enter your Name" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input required type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Contact</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input required type="text" class="form-control" name="contact" id="contact"  placeholder="Enter your Address"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Address</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="address" id="address"  placeholder="Enter your Address"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Username</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
									<input required type="text" class="form-control" name="u_name" id="u_name"  placeholder="Enter your Username"/>
								</div>
							</div>
						</div>
						
						<?php
							if(count($error)>0){
								echo($basicUser->redPara($error['u_name']));
							}
						?>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input required type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
								</div>
							</div>
						</div>
						<?php
							if(count($error)>0){
								echo($basicUser->redPara($error['password']));
							}
						?>

						<div class="form-group">
							<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input required type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password"/>
								</div>
							</div>
						</div>
						
						<?php
							if(count($error)>0){
								echo($basicUser->greenPara($error['password']));
							}
						?>

						<div class="form-group ">
							<button type="submit" class="btn btn-primary btn-lg btn-block login-button">Register</button>
						</div>
						<div class="login-register">
				            <a href="index.php">Login</a>
				         </div>
					</form>
					
						<?php
							if($_POST){
								if(count($error)==0){
								echo($basicUser->greenPara("Successfully Registered"));
								}
							}
							
						?>
				</div>
			</div>
		</div>
	</body>
</html>