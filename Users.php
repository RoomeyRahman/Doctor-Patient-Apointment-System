<?php 
	class AllUser{
		protected $connection;
		protected $result;
		protected $assocRowFromPatient;
		protected $assocRowFromUser;
		protected $assocRowFromDoctor;
		protected $userIDSession;
		public static  $dbName="dpas";
		public static  $userName="root";
		public static  $hostName="localhost";
		public static  $password="";
		public static  $port="";

		
		//User constractor will give us a error if connection failed and return false
		function __construct(){
			$bool = 0;
			if($this->connection = mysqli_connect(AllUser::$hostName,AllUser::$userName,AllUser::$password,AllUser::$dbName)){
				$bool =1;
			} else {
				$this->getError();
			}
			return $bool;
		}
		
		//this function will give us any mysql error might need for debuging :D
		protected function getError(){
			if(mysqli_error($this->connection)){
				$error = mysqli_error($this->connection);
				echo("<p>Mysql connect error ".$error ."</p>");
			}
			if(mysqli_error($this->connection)){
				return(true);
			} else {
				return(false);
			} 
		}
		public function redPara($string){
			$string1="<p style='color:red'>".$string."</p>";
			return($string1);
		}
		
		public function greenPara($string){
			$string1="<p style='color:green'>".$string."</p>";
			return($string1);
		}
		public function loginValidation($post){
			$userName=$post['u_name'];
			$password = $post['password'];
			$sql1="select * from users where u_name='$userName' and password='$password';";
			$result = mysqli_query($this->connection,$sql1);
			$this->getError();
			$error= array();
			$error['error']="";
			if(mysqli_num_rows($result)>0){
				//user info
				$this->assocRowFromUser=mysqli_fetch_assoc($result);
				//doctor info if avilable
				if($this->assocRowFromUser[u_type]==0){
					$sql2="select * from doctor where d_id='".$this->assocRowFromUser['u_id']."' ;";
					$result2 = mysqli_query($this->connection,$sql2);
					$this->getError();
					$this->assocRowFromDoctor = mysqli_fetch_assoc($result2);
				} else {
					$sql2="select * from patient where p_id='".$this->assocRowFromUser['u_id']."' ;";
					$result2 = mysqli_query($this->connection,$sql2);
					$this->getError();
					$this->assocRowFromPatient = mysqli_fetch_assoc($result2);
				}
			} else {
				$error['error']=$this->redPara("Username OR Password Doesn't Match");
			}
			return($error);
		}
		//registration validation
		public function registrationValidation($post){
			
		}
		
		//get associative array for patient
		public function getAssocRowFromPatient(){
			return($this->assocRowFromPatient);
		}
		//get associative array for Doctor
		public function getAssocRowFromDoctor(){
			return($this->assocRowFromDoctor);
		}
		//get associative array for user
		public function getAssocRowFromUser(){
			return($this->assocRowFromUser);	
		}
		//Check patient or Doctor
		public function isPatient(){
			if(count($this->assocRowFromPatient)==0){
				return(false);
			} else {
				return(true);
			}
		}
		//validate appiontmetn form
		public function validateAppointmentForm($post,$p_id){
			$name=$post['p_name'];
			$email=$post['email'];
			$date = $post['date'];
			$time = $post['time'];
			$problem=$post['problem'];
			$doctorID = $post['appointmentto'];
			$sql="insert into appoinment (p_id,d_id,problem,time,date) values ('$p_id','$doctorID','$problem','$time','$date');";
			$result = mysqli_query($this->connection,$sql);
			$this->getError();
			$error=$this->greenPara("You Successfully request for an appointment.Update will be notified soon");
			return($error);
		}
		public function getDoctorQueryResult(){
			$sql= "select * from doctor;";
			$result= mysqli_query($this->connection,$sql);
			$this->getError();
			return $result;
		}
		public function getAppointemtQueryResult($doctorID){
			$sql ="select * from appoinment where d_id='$doctorID'  order by a_id asc;";
			$result = mysqli_query($this->connection,$sql);
			return($result);
		}
		public function getAppointemtQueryResultP($patientID){
			$sql ="select * from appoinment where p_id='$patientID'  order by a_id asc;";
			$result = mysqli_query($this->connection,$sql);
			return($result);
		}
		public function getNameEmailPatineInfo($patientId){
			$sql3="select name,email from patient where p_id='".$patientId."';";
			$result3 = mysqli_query($this->connection,$sql3);
			return($result3);
		}
		public function acceptAppointment($a_id){
			$sql ="update appoinment set status='1' where a_id='$a_id';";
			$result = mysqli_query($this->connection,$sql);
		}
		public function cancelAppointment($a_id){
			$sql ="update appoinment set status='0' where a_id='$a_id';";
			$result = mysqli_query($this->connection,$sql);
		}
		public function getAlluserInfo($u_id){
			$sql ="select * from users where u_id='$u_id';";
			$result = mysqli_query($this->connection,$sql);
		}
		
		public function getuserPatineInfo($patientId){
			$sql3="select * from patient where p_id='".$patientId."';";
			$result3 = mysqli_query($this->connection,$sql3);
			return($result3);
		}
		
		public function patientRegistrationFormValidation($post){
			$name=$post['p_name'];
			$email=$post['email'];
			$contact=$post['contact'];
			$address=$post['address'];
			$userName = $post['u_name'];
			$password = $post['password'];
			$confirmPass = $post['confirm'];
			$error=array();
			if($password!=$confirmPass){
				$error['password']="password does'nt match";
			}
			$sql1="select * from users where u_name='$userName';";
			$result1 = mysqli_query($this->connection,$sql1);
			$numRow = mysqli_num_rows($result1);
			if($numRow>0){
				$error['u_name']="Username Already Taken";
			}
			if(count($error)==0){
				$sql2="insert into users(u_name,password) values('$userName','$password');";
				$sql4="select u_id from users where u_name='$userName';";
				
				mysqli_query($this->connection,$sql2);
				$this->getError();
				$result=mysqli_query($this->connection,$sql4);
				$assoc=mysqli_fetch_assoc($result);
				$sql3="insert into patient(p_id,name,email,contact,address) values (".$assoc['u_id'].",'$name','$email','$contact','$address');";
				
				mysqli_query($this->connection,$sql3);
				$this->getError();
			}
		}
		public function doctorRegistrationFormValidation($post){
			$name=$post['d_name'];
			$email=$post['email'];
			$contact=$post['contact'];
			$chember=$post['chember'];
			$dept=$post['dept'];
			$userName = $post['u_name'];
			$password = $post['password'];
			$confirmPass = $post['confirm'];
			$error=array();
			if($password!=$confirmPass){
				$error['password']="password does'nt match";
			}
			$sql1="select * from users where u_name='$userName';";
			$result1 = mysqli_query($this->connection,$sql1);
			$numRow = mysqli_num_rows($result1);
			if($numRow>0){
				$error['u_name']="Username Already Taken";
			}
			if(count($error)==0){
				$sql2="insert into users(u_name,password) values('$userName','$password');";
				$sql4="select u_id from users where u_name='$userName';";
				
				mysqli_query($this->connection,$sql2);
				$this->getError();
				$result=mysqli_query($this->connection,$sql4);
				$assoc=mysqli_fetch_assoc($result);
				$sql3="insert into doctor(d_id,name,email,contact,dept,chember) values (".$assoc['u_id'].",'$name','$email','$contact','$dept','$chember');";
				
				mysqli_query($this->connection,$sql3);
				$this->getError();
			}
		}
		
	}
?>