<?php
	session_start();
  $title = "Login";
  if(isset($_SESSION['uid'])){
    if($_SESSION['type'] == 1){
      header("Location: bhead/headhome");
    }
    if($_SESSION['type'] == 2){
      header("Location: bhead/memhome");
    }
    if($_SESSION['type'] == 3){
      header("Location: bhead/reqhome");
    }
  }

	include_once "include/header.php";

	$user = new User($db);

  if(isset($_SESSION['uid'])){
    echo $_SESSION['firstname'];
  }
	elseif(isset($_POST['submit'])){
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    if($user->login($user->password)){
      header("Location: ../index");
    }
    else{
      echo 
      '<script type="text/javascript">
            swal({ 
              icon: "error",
              title: "Wrong Email or Password!",
            });
      </script>';
    }
	}
?>
<div class="container">
	<div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5 text-white bg-secondary">
          <div class="card-body">
            <h1 class="card-title text-center">
              <img src="../assets/img/logo.png" width="250" height="250"><br>
              <i class="far fa-user"></i><i class="fas fa-sign-in-alt"></i>   User Login</h1>
            <hr class="my-4">
            <form class="form-signin" method="POST" action="login">
              <div class="form-label-group">
                <label for="inputEmail">Email address</label>
                <input type="email" name="email" id="inputEmail" class="form-control" value='<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>' required autofocus>              
              </div>

              <div class="form-label-group mt-2 col-md-13">
                <label for="inputPassword">Password</label>
                <input type="password" name="password" id="inputPassword" class="form-control" value='<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>' required>
              </div>
              <a class="text-light" href="forgotpw" for="inputPassword"><b>Forgot Password</b></a>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" name="submit" type="submit">Login</button>
              <hr class="my-4">
              <a class="btn btn-info btn-lg btn-block" href="regtype.php"><i class="fas fa-user-plus"></i> SIGN UP</a>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
<?php
	include_once "include/footer.php";
?>