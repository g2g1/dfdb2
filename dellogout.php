<?php
if(isset($_POST['submit_logout'])){
	session_unset();
	session_destroy();
	Header("Location: delindex.php");

}

?>