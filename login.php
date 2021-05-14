<?php
session_start();
$conn = mysqli_connect("localhost","root","","pwb_db");

if( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $cek = mysqli_query($conn,"SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($cek);

    if ($key === hash('sha256', $row['username']) ) {
        $_SESSION['login'] = true;
    }

     

}

if ( isset($_SESSION["login"]) ) {
    header("location: index.php");
    exit;
}



if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
   
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username  = '$username'");
	

    if (mysqli_num_rows($result) === 1 ){
        $row = mysqli_fetch_assoc($result);

        if($password == $row["password"]){
            $_SESSION["login"] = true;
            $_SESSION["name"] = $username;
            if (isset($_POST['rememberme']) ) {
                setcookie('id',$row['id'],time()+3600);
                setcookie('key',hash('sha256',$row['username']),time()+3600);
                setcookie('name',$username,time()+3600);
            }

            header("location: index.php");
            exit;

        }

    }

    $error = true;
}
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

<?php

?>
</head>
<body>
    <div class="container">
      <div class="row justify-content-center mt-5">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header bg-transparent mb-0"><h5 class="text-center">FORM <span class="font-weight-bold text-primary">LOGIN</span></h5></div>
            <div class="card-body">
              <form method="post"action="">
                <?php if(isset($error)) : ?>
					<p style="color:red;" align="center">Incorrect username or password!</p>
				<?php endif; ?>
                <div class="form-group">
                  <input type="text" name="username" class="form-control" placeholder="Username">
                </div>
                <br>
                <div class="form-group">
                  <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group custom-control custom-checkbox">
                  <input type="checkbox" name="rememberme" class="custom-control-input" id="customControlAutosizing">
                  <label class="custom-control-label" for="customControlAutosizing">Remember me</label>
                </div>
                <div align="center"class="form-group">
                  <input type="submit" name="login" value="Login" class="btn btn-primary btn-block">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>