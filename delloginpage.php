<?php
 session_start();
 include 'delconn.php';

echo $_SESSION['lusername'];
?>

<form action="dellogout.php" method="post">
	<button type="submit" name="submit_logout">Logout</button>

</form>
<form action="delupload_img.php" method="post" enctype="multipart/form-data">
	<input type="file" name="file">
	<button type="submit" name="submit_upload">Upload</button>

</form>



<?php
	 $luserImg = $_SESSION['lusername'];
	 

		$sql = "SELECT * FROM deltest WHERE username='$luserImg';";
		$result = mysqli_query($conn1, $sql);
		if(mysqli_num_rows($result) > 0){
		$sqlImg = "SELECT * FROM profileimg WHERE userid='$luserImg';";
		$resultImg = mysqli_query($conn1, $sqlImg);
		while($rowImg = mysqli_fetch_assoc($resultImg)){
			echo "<div>";
			if($rowImg['status'] == 0){
				
				echo "<img src='deluploads/profileimg_".$luserImg.".jpg'>";
				

			}else{
				echo "<img src='deluploads/profile_default.jpg'>";
			}
		
			echo "</div>";

		

	}
}






?>
