<?php

require_once "db.php";
require_once "session.php";

$error="";

if($_SERVER["REQUEST METHOD"]=="POST" && isset($_POST['submit'])){
	$uname=trim($_POST['uname0']);
	$passw=trim($_POST['upass0']);
	
	if (empty($uname)){
		$error.='<p class="error">Enter Username</p>';
	}
	if (empty($passw)){
		$error='<p class="error">Enter password</p>';
	}
	if(empty($error)){
	
		if($query=$con->prepare("select * from usertable where name=?")){
			$query->bind_param('s',$uname);
			$query->execute();
			$row=$query->fetch();
			if($row){
				if(password_verify($passw,$row['pass'])){
					$_SESSION['userid']=$row['id'];
					$_SESSION['user']=$row;
					header("location:website.html");
					exit;
				}
				else{
					$error .= '<p class="error">Invalid password</p>';
				}
			else{
				$error .= '<p class="error">No user with that name found</p>'
			}
		}
		$query->close();
		mysqli_close($con);
}


?>