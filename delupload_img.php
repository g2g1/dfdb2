<?php
	session_start();
	include 'delconn.php';
	$profileImgUsername = $_SESSION['lusername'];
	

	if(isset($_POST['submit_upload'])){
	$file = $_FILES['file'];

	$fileName = $file['name'];
	$fileTmpName = $file['tmp_name'];
	$fileSize = $file['size'];
	$fileError = $file['error'];
	$fileType = $file['type'];

	$fileExt = explode('.',$fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array("jpeg","jpg","png","pdf");

	if(in_array($fileActualExt, $allowed)){
		if($fileError === 0){
			if($fileSize < 150000){
				$fileNewName = "profileimg_".$profileImgUsername.".".$fileActualExt;
				$fileDestination = "deluploads/".$fileNewName;
				move_uploaded_file($fileTmpName, $fileDestination);
				$sql = "UPDATE profileimg SET status = 0 WHERE userid='$profileImgUsername';";
				mysqli_query($conn1, $sql);
				Header("Location: delloginpage.php?uploadImg=success");
			}else{
				echo "Uploaded fiel is too big";
			}

		}else{
			echo "Error while uploading";

		}
 		}else{
 			echo "You can't upload file of this extension";
 		}


}
?>