<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'monitoring');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
<?php
// Include config file
//require_once "config.php";
 
// Define variables and initialize with empty values
$datequar = "";
$datequar_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["pid"]) && !empty($_POST["datequar"])){
    // Get hpidden input value
    $pid = $_POST["pid"];
    $datequar = $_POST["datequar"];

    

    // Valpidate address address
    $input_datequar = trim($_POST["datequar"]);
    if(empty($input_datequar)){
        $datequar_err = "Please enter an Date.";     
    } else{
        $datequar = $input_datequar;
    }
    

    
    // Check input errors before inserting in database
    if(empty($datequar_err) ){
        // Prepare an update statement
        $sql = "UPDATE person SET datequar=? WHERE pid=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_datequar, $param_pid);
            
            // Set parameters
            $param_pid = $pid;
            $param_datequar = $datequar;
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: viewpum.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of pid parameter before processing further
    if(isset($_GET["pid"]) && !empty(trim($_GET["pid"]))){
        // Get URL parameter
        $pid =  trim($_GET["pid"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM person WHERE pid = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_pid);
            
            // Set parameters
            $param_pid = $pid;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve indivpidual field value
                    $pid = $row["pid"];
                    $datequar = $row["datequar"];
                } else{
                    // URL doesn't contain valpid pid. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain pid parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<?php
	session_start();
	$title = "People Recorded";
	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 2){
		if($_SESSION['status'] == 1){ header("Location: views/bmember/memhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}

	include_once '../include/header.php';
    include_once '../include/sidebar/viewpum.php';

?>
<br><br><br><br><br><br>
<center>
<div class="card" style="width: 30rem;">
  <div class="card-body">
    <h5 class="card-title">Change Date Quarantined</h5>

    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
        <table class="table">
            <thead>
                
            </thead>
            <tbody>
                <tr>
                    <th style="width: 30%;">ID no.:</th>
                    <td>
                    <input type="text" readonly class="form-control" name="pid" value="<?php echo $pid; ?>" >
                    </td>
                </tr>
                <tr>
                    <th style="width: 30%;">Date Quarantine:</th>
                    <td>
                    <div class="col-sm-9 <?php echo (!empty($datequar_err)) ? 'has-error' : ''; ?>">
                    <input type="text" class="form-control" name="datequar" value="<?php echo $datequar; ?>" required="required">
                    </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="viewpum.php" class="btn btn-secondary">Cancel</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
  </div>
</div>


<?php
	include_once '../include/footer.php';
?>