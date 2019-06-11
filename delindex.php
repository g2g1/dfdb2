<?php
session_start();

include 'config.php';
include 'conn.php';
include 'delconn.php';


$empty_fields = false;
$success = false;
$invalid_symbols = false;
$invalid_email = false;
$taken = false;

$login_empty = false;
$login_invalid_name = false;
$login_invalid_password = false;





$username = isset($_GET['username']) ? $_GET['username'] : '';
    $password = isset($_GET['password']) ? $_GET['password'] : '';
    $email = isset($_GET['email']) ? $_GET['email'] : '';




$action = isset($_GET['action']) ? $_GET['action'] : '';
$inserted = isset($_GET['inserted']) ? $_GET['inserted'] : false;

switch($action){

     case 'add':
   
   $sql1 = "SELECT * FROM deltest WHERE username ='$username';";
  $result = mysqli_query($conn1, $sql1);
  $resultCheck = mysqli_num_rows($result);
  
 


    if(empty($username) || empty($password) || empty($email)){
        $empty_fields = true;

        
  
    }elseif(!preg_match("/^[a-zA-Z]*$/", $username)){
        $invalid_symbols = true;
}elseif($resultCheck > 0){
     $taken = true;
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $invalid_email = true;
        
    
    }else{




        $sql = "INSERT INTO deltest(username, password, email) VALUES(:username, :password, :email)";
        $success = false;

        try {
            $stmt = $conn -> prepare($sql);
            $res = $stmt -> execute([
                'username' => $username,
                'password' => $password,
                'email' => $email

            ]);
            header("Location: delindex.php?inserted=true");
         
            $success = true;


        }catch(Exception $e){
            echo 'Exception ->';
            var_dump($e->getMessage());

            ?>
            <div class="alert alert-danger">
              <strong>database error!</strong>
            </div>
            <?php

        }

       $sql2 = "INSERT INTO profileimg (userid, status) VALUES(:userid, :status);";

       try{
          $stmt2 = $conn -> prepare($sql2);
          $res2 = $stmt2 -> execute([
            'userid' => $username,
            'status' => 1

          ]);

       }catch(Exception $e){
        echo 'Exception ->';
        var_dump($e->getMessage());

        ?> <div class="alert alert-danger">
              <strong>database error!</strong>
            </div>
            <?php

       }



    }
    break;
    case 'delete':
    $id = $_GET['id'];
    $query = "UPDATE deltest SET deleted = 1 WHERE id =" . $id;
    $stmt = $conn->query($query);

    break;
   
}






// select all users
$query = "	SELECT 
				* FROM deltest
			    
			WHERE deleted = 0";
$stmt = $conn -> query($query);

$users = $stmt -> fetchAll();

// echo '<pre>';
// print_r($_GET);
// echo '</pre>';


?><!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

  <div class="topnav">
  <form action="dellogin.php" method="post">
            <input type="text" name="lusername" placeholder="username">
            <input type="text" name="lpassword" placeholder="password">
            <button type="submit" name="submit1">Login</button>


          </form>
</div>

<div class="container">
    <h2>Add new students</h2>

    <?php 
      if($empty_fields){
          ?><div class="alert alert-danger">
              <strong>Fill all required fields!</strong> 
            </div> <?php
      }elseif($invalid_email){
                    ?><div class="alert alert-danger">
                        <strong>Invalid email!</strong> 
                      </div> <?php

      }elseif($invalid_symbols){                
          ?><div class="alert alert-danger">
                        <strong>Insert valid symbols!</strong> 
                      </div> <?php

      }elseif($taken){
          ?><div class="alert alert-danger">
                        <strong>Username is taken!</strong> 
                      </div> <?php

      }elseif($inserted){ ?>
          <div class="alert alert-success">
              <strong>Inserted Successfully!</strong>
          </div>
<?php
      }




      





?>



<?php 


 $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($fullUrl, "login=empty")){
    $login_empty = true;
}elseif(strpos($fullUrl, "login=invalidname")){
$login_invalid_name = true;

}elseif(strpos($fullUrl, "login=invalidpassword")){
$login_invalid_password = true;

}

 if($login_empty){
          ?><div class="alert alert-danger">
              <strong>Fill all required fields!</strong> 
            </div> <?php
      }elseif($login_invalid_name){
                    ?><div class="alert alert-danger">
                        <strong>Invalid name!</strong> 
                      </div> <?php

      }elseif($login_invalid_password){                
          ?><div class="alert alert-danger">
                        <strong>invalid password!</strong> 
                      </div><?php
                    }
                    ?>








<form action="delindex.php" method="get">
    <div class="form-group">
        <label for="usr">Username:</label>
        <input type="text" class="form-control" name="username" placeholder="username">
      </div>

      <div class="form-group">
        <label for="usr">password:</label>
        <input type="text" class="form-control" name="password" placeholder="password">
      </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" class="form-control" name="email" id="email" placeholder="Email">
      </div>

<button type="submit" class="btn">Add Student</button>
<input type="hidden" name="action" value="add">

</form>

  <h2>Students List</h2>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Student ID</th>
        <th>Username</th>
        <th>password</th>
        
      </tr>
    </thead>
    <tbody>

    	<?php

    	foreach ($users as $user) {
    		?>
    		<tr>
				<td><?php echo $user['id'] ?></td>
				<td><?php echo $user['username'] ?></td>
				<td><?=$user['password']?></td>
        <td><?=$user['email']?></td>
			  <td>
					<a href="?action=delete&id=<?=$user['id']?>">
						<img style="width: 25px; cursor: pointer;" src="photos4web1/justredcross.png">
					</a>
				</td>
			</tr>
    		<?php
    	}

    	?>

    </tbody>
  </table>
</div>

</body>
</html>