<?php
  session_start();
  $title = "Forgot Password";
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
  require_once '../vendor/autoload.php';
  include_once "../classes/pwd_reset.php";
?>
<div class="container">
	<br>
	<center><p class="h2">Reset Password</p></center><br>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="card">
			  <div class="card-body bg-muted">
			    <p class="card-text text-dark">Enter Your User account's email and we'll send you a link in order to change your password.</p>
			    <?php
			    	$pwd_reset = new pwd_reset($db);
			    	if(isset($_POST['submit'])){
			    		$pwd_reset->email = $_POST['email'];
			    		$pwd_reset->token = md5(time().$_POST['email']);

			    		require_once 'info.php';
			    		//create swiftmailer transport
			    		$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
						  ->setUsername(EMAIL)
						  ->setPassword(PASS)
						;
						// Create the Mailer using your created Transport
						$mailer = new Swift_Mailer($transport);
						//#for localhost address VVVVVV
						// $body = <<<EOD
						// <html>
						//     <head></head>
						//     <body>
						//         Please click this link to change your password: <a href="http://localhost/monitoring/views/util/chpass?key=$pwd_reset->token" target="_blank">http://localhost/monitoring/views/util/chpass?key=$pwd_reset->token</a>
						//         Please don't reply to this message. This is an automated mail from Barangay Monitoring. Thank you and Godbless.
						//     </body>
						// </html>
						// EOD;
						//#for localhost address ^^^^^^

						//#for HEROKU address VVVVVV
						$body = <<<EOD
						<html>
						    <head></head>
						    <body>
						        Please click this link to change your password: <a href="https://php-barangay-monitoring.herokuapp.com/views/util/chpass?key=$pwd_reset->token" target="_blank">https://php-barangay-monitoring.herokuapp.com/views/util/chpass?key=$pwd_reset->token</a>
						        Please don't reply to this message. This is an automated mail from Barangay Monitoring. Thank you and Godbless.
						    </body>
						</html>
						EOD;
						//#for HEROKU address ^^^^^^

						$message = (new Swift_Message('Password Reset Verification'))
						  ->setFrom(['barangaymonitoring@gmail.com' => 'Barangay Monitoring'])
						  ->setTo([$pwd_reset->email])
						  ->setBody(
						  	$body,
						    'text/html' // Mark the content-type as HTML
						  )
						  ;
						// Send the message
						$result = $mailer->send($message);
						if(!$result){
							echo "Something Went WRONG!";
						}
						else {
							$pwd_reset->createResetPW();//create pass token
							echo 
								'<script type="text/javascript">
						        	swal({ 
						        		icon: "success",
						        		title: "Link Sent!",
						        		text: "Please check your email we have sent you.",
						        	});
							    </script>';
						}
			    	}
			    ?>
			    <form method="POST" action="forgotpw">
				    <input type="email" name="email" class="form-control" placeholder="Enter your email address" required><br>
				    <button name="submit" class="btn btn-success btn-block">Send Link</button>
				</form>
			  </div>
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>

<?php
	include_once "include/footer.php";
?>