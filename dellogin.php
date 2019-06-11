<?php
session_start();

include 'delconn.php';




if(isset($_POST['submit1'])){
	$lusername = mysqli_real_escape_string($conn1, $_POST['lusername']);
	$lpassword = mysqli_real_escape_string($conn1, $_POST['lpassword']);
	echo "post submit is set";
	if(empty($lusername) ||empty($lpassword)){
		Header("Location: delindex.php?login=empty");
		

	}else{
		$sql = "SELECT * FROM deltest WHERE username='$lusername'";
		$result = mysqli_query($conn1, $sql);
		$resultCheck = mysqli_num_rows($result);
		if($resultCheck < 1){
			Header("Location: delindex.php?login=invalidname");
			

		}else{
			if($row = mysqli_fetch_assoc($result)){
				$dbpass = $row['password'];
				if($lpassword != $dbpass){
					Header("Location: delindex.php?login=invalidpassword");
					
				}elseif($lpassword == $dbpass){
					 $_SESSION['lusername'] = $row['username'];
					 $_SESSION['lpassword'] = $row['password'];
					 $_SESSION['email'] = $row['email'];
					 Header("Location: delloginpage.php?login=success");


				}
			}

		}
	}





}