<?php
	define('KB', 1024);
	define('MB', 1048576);
	define('GB', 1073741824);
	define('TB', 1099511627776);
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	session_start();
	$title = "Barangay Head Registration";
	include_once "include/header.php";
	include_once '../classes/barangay.php';

	require_once '../vendor/autoload.php';

	$barangay = new Barangay($db);

	if(isset($_SESSION['uid'])){
		if($_SESSION['type'] == 1){
			if($_SESSION['status'] == 1){ header("Location: views/bhead/headhome"); }
			else { header("Location: views/verification/accountonhold"); }
			}
		elseif($_SESSION['type'] == 2){
			if($_SESSION['status'] == 1){ header("Location: views/bmember/memhome"); }
			else { header("Location: views/verification/accountonhold"); }
		}
		elseif($_SESSION['type'] == 3){
			if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
			else { header("Location: views/verification/accountonhold"); }
		}
	}
?>
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-6">
			<div class="card text-white bg-secondary">
			  <h4 class="card-header"><p class="fas fa-user-plus" style="font-size:50px;"></p> User Registration</h4>
			  <div class="card-body">
			    	<form method="POST" action="regcapsec" enctype="multipart/form-data">
			    	<?php
			    		$user = new User($db);

			    		if(isset($_POST['submit'])){
			    			$user->firstname = $_POST['firstname'];
			    			$user->middlename = $_POST['middlename'];
			    			$user->lastname = $_POST['lastname'];
			    			$user->email = $_POST['email'];
			    			$password = $_POST['password'];
			    			$passcon = $_POST['passcon'];

			  				$baridfile = 0;
			  				$baridsize = 0;

			    			//hash pw for added security(note2self:$user->password in order to get the data)
			    			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			    			//further info on this: https://stackoverflow.com/questions/30279321/how-to-use-phps-password-hash-to-hash-and-verify-passwords

			    			//random referral code generator(5 digits of random characters)
			    			// $randomreferral = substr(md5(microtime()),rand(0,26),5);
			    			$vkey = md5(time().$passcon);

			    			//check password match
			    			if($password == $passcon){
			    				if($user->existingmail()){
			    					echo 
			    				'<script type="text/javascript">
						        	swal({ 
						        		icon: "error",
						        		title: "Email Used!",
						        	});
							    </script>';
			    				}
			    				else {
			    					$user->password = $hashed_password;//--->stores hashed pass

			    					$result = $_POST['referral'];
			    					$result_explode = explode('|', $result);	

					    			$user->referral = $result_explode[0];
					    			$user->bid = $result_explode[1];
					    			$user->token = $vkey;

					    			require_once 'info.php';
					    			// Create the Transport
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
									//         Please verify your email by clicking this link: <a href="http://localhost/monitoring-main/views/util/userverification?key=$user->token" target="_blank">http://localhost/monitoring-main/views/util/userverification?key=$user->token</a>
									//         Please don't reply to this message. This is an automated mail from Barangay Monitoring. Thank you and Godbless.
									//     </body>
									// </html>
									// EOD;
									//#for localhost address ^^^^^^

									//#for Heroku address VVVVVV
									$body = <<<EOD
									<html>
									    <head></head>
									    <body>
									        Please verify your email by clicking this link: <a href="https://php-barangay-monitoring.herokuapp.com/views/util/userverification?key=$user->token" target="_blank">https://php-barangay-monitoring.herokuapp.com/views/util/userverification?key=$user->token</a>
									        Please don't reply to this message. This is an automated mail from Barangay Monitoring. Thank you and Godbless.
									    </body>
									</html>
									EOD;
									//#for HEROKU address ^^^^^^

									// Create a message
									$message = (new Swift_Message('Email Verification'))
									  ->setFrom(['barangaymonitoring@gmail.com' => 'Barangay Monitoring'])
									  ->setTo([$user->email])
									  ->setBody(
									  	$body,
									    'text/html' // Mark the content-type as HTML
									  )
									  ;

									// Send the message
									$result = $mailer->send($message);

									//check result if sent or not
									if(!$result){
										echo "Something Went WRONG!";
									}
									else {
										//barangay id
										if (!file_exists($_FILES['barid']['tmp_name']) || !is_uploaded_file($_FILES['barid']['tmp_name'])){
										    $temp = explode(".", $_FILES["barid"]["name"]);
											$newfilename = substr(md5(microtime()),rand(0,26),21) . '.' . end($temp);
											move_uploaded_file($_FILES['barid']['tmp_name'], "../assets/img/".$newfilename);
											$imgname = "../../assets/img/".$newfilename;
											$user->barid = $imgname;
										}
										else {
											if($_FILES['barid']['type'] == 'image/jpeg' || $_FILES['barid']['type'] == 'image/jpg' || $_FILES['barid']['type'] == 'image/png'){
												//check size
												if($_FILES['barid']['size'] > 1*MB){
													$baridsize = 1;
												}
												else {
													$temp = explode(".", $_FILES["barid"]["name"]);
													$newfilename = substr(md5(microtime()),rand(0,26),21) . '.' . end($temp);
													move_uploaded_file($_FILES['barid']['tmp_name'], "../assets/img/".$newfilename);
													$imgname = "../../assets/img/".$newfilename;
													$user->barid = $imgname;
												}			
											}
											else {
												$baridfile = 1;
											}
										}


										//check if file is valid
										if($baridfile == 1){
											echo
											'
											<script type="text/javascript">
									        	swal({ 
									        		icon: "error",
									        		title: "INVALID FILE!",
									        		text: "Please check if your file is an image.",
									        	});
										    </script>
											';
										}
										else {
											//check if file exceeds size
											if($baridsize == 1){
												echo
												'
												<script type="text/javascript">
										        	swal({ 
										        		icon: "error",
										        		title: "FILE TOO BIG!",
										        		text: "Please check if your file exceeds 1MB.",
										        	});
											    </script>
												';
											}
											else {
												$user->createuser();//create user
												echo 

							    				'<script type="text/javascript">
										        	swal({ 
										        		icon: "success",
										        		title: "Account Created!",
										        		text: "You may now use your account.",
										        	});
											    </script>';
											}
										}
									}
			    				}
			    			}
			    			else {
			    				echo 
			    				'<script type="text/javascript">
						        	swal({ 
						        		icon: "error",
						        		title: "Password Mismatch!",
						        	});
							    </script>';
			    			}
			    		}
			    		//end of if isset
			    	?>
				   		<div class="row">
				   			<div class="col-md-12">
							    <label class="col-form-label col-form-label-sm">First Name</label>
							    <input type="text" name="firstname" class="form-control form-control-sm" pattern="[A-Za-z ]{3,}" title="3 or more letters required" placeholder="Enter your first name" value='<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>' required>
				   			</div>
				   		</div>
				   		<div class="row">
				   			<div class="col-md-12">
				   				<label class="col-form-label col-form-label-sm">Middle Name</label>
							    <input type="text" name="middlename" class="form-control form-control-sm" pattern="[A-Za-z ]{1,}" placeholder="Optional" value='<?php echo isset($_POST['middlename']) ? $_POST['middlename'] : '' ?>'>
				   			</div>
				   		</div>
				   		<div class="row">
				   			<div class="col-md-12">
				   				<label class="col-form-label col-form-label-sm">Last Name</label>
							    <input type="text" name="lastname" class="form-control form-control-sm" pattern="[A-Za-z\s]{3,}" title="3 or more letters required" placeholder="Enter your last name" value='<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>' required>
				   			</div>
				   		</div>
				   		<div class="row">
				   			<div class="col-md-12">
				   				<label class="col-form-label col-form-label-sm">Email</label>
							    <input type="email" name="email" class="form-control form-control-sm" placeholder="Enter your email" value='<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>' required>
				   			</div>
				   		</div>
				   		<div class="row">
				   			<div class="col-md-12">
				   				<label class="col-form-label col-form-label-sm">Barangay</label>
							    <select class="form-control" name="referral" required>
									<option selected></option>
									<?php
										$stmt = $barangay->readbar();
										while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
											extract($row);
											echo "
											<option value='".$row['referral']."|".$row['bid']."'>".$row['brgyname']."</option>";
										}
									?>
								</select>
				   			</div>
				   		</div>
				   		<div class="row">
				   			<div class="col-md-6">
				   				<label class="col-form-label col-form-label-sm">Password</label>
							    <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="form-control form-control-sm" required>
				   			</div>
				   			<div class="col-md-6">
				   				<label class="col-form-label col-form-label-sm">Confirm Password</label>
							    <input type="password" name="passcon" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="form-control form-control-sm"  required>
				   			</div>
				   		</div>&nbsp
				   		<hr>
				   		<p><small><i class="fas fa-exclamation-circle"></i><em> File must be an Image(jpg/png) and under 1MB</em></small></p>
				   		<div class="row">
				   			<div class="col-md-12">
				   				<label class="col-form-label col-form-label-sm">Barangay ID</label>		
				   				<input type="file" class="form-control-file" accept='image/*' name="barid" required>	
				   			</div>
				   		</div>

				   		<br>
				   		<input class="btn btn-primary" type="submit" name="submit" value="Register">
			   		</form>
			  </div>
			</div>
		</div>
		<div class="col-md-3">
		</div>
	</div>
</div>
<?php
	include_once "include/footer.php";
?>