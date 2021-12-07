<?php
	session_start();
  $title = "Login";
  if(isset($_SESSION['uid'])){
    if($_SESSION['type'] == 1){
      header("Location: bhead/viewgroup");
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
<style>
  body {
    color: #999;
    background: #f5f5f5;
    font-family: 'Varela Round', sans-serif;
  }
  .form-control {
    box-shadow: none;
    border-color: #ddd;
  }
  .form-control:focus {
    border-color: #00b3b3; 
  }
  .login-form {
    width: 350px;
    margin: 0 auto;
    padding: 30px 0;
  }
  .login-form form {
    color: #434343;
    border-radius: 1px;
    margin-bottom: 15px;
    background: #fff;
    border: 1px solid #f3f3f3;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    padding: 30px;
  }
  .login-form h4 {
    text-align: center;
    font-size: 22px;
    margin-bottom: 20px;
  }
  .login-form .avatar {
    color: #fff;
    margin: 0 auto 30px;
    text-align: center;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    z-index: 9;
    background: #00b3b3;
    padding: 15px;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
  }
  .login-form .avatar img {
    width: 100%;
  }
  .login-form .form-group {
    margin-bottom: 20px;
  }
  .login-form .form-control, .login-form .btn {
    min-height: 40px;
    border-radius: 2px; 
    transition: all 0.5s;
  }
  .login-form .close {
    position: absolute;
    top: 15px;
    right: 15px;
  }
  .login-form .btn, .login-form .btn:active {
    background: #00b3b3 !important;
    border: none;
    line-height: normal;
  }
  .login-form .btn:hover, .login-form .btn:focus {
    background: #00b3b3 !important;
  }
  .login-form .checkbox-inline {
    float: left;
  }
  .login-form input[type="checkbox"] {
    position: relative;
    top: 2px;
  }
  .login-form .forgot-link {
    float: right;
  }
  .login-form .small {
    font-size: 13px;
  }
  .login-form a {
    color: #00b3b3;
  }
</style>

<br><br><br><br>
<div class="login-form">    
  <form class="form-signin" method="POST" action="login">
		<div class="avatar">
      <i><img src="../assets/img/logo.png" alt="Avatar"></i>
    </div>
    	<h4 class="modal-title">Login to Your Account</h4>
        <div class="form-group">
        <input type="email" name="email" id="inputEmail" placeholder="Email" class="form-control" value='<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>' required autofocus>
        </div>
        <div class="form-group">
        <input type="password" name="password" id="inputPassword" placeholder="Password" class="form-control" value='<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>' required>
        </div>
        <div class="form-group small clearfix">
            <label class="form-check-label"><input type="checkbox"> Remember me</label>
            <a href="forgotpw" class="forgot-link">Forgot Password?</a>
        </div> 
         
        <button name="submit" type="submit" class="btn btn-primary btn-lg btn-block login-btn">Login</button>            
    </form>			
    <div class="text-center small">Don't have an account? <a href="regcapsec">Sign up</a></div>
</div>




</div>
<?php
	include_once "include/footer.php";
?>