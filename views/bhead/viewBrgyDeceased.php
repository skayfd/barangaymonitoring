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
	include_once '../include/sidebar.php';
	include_once '../../classes/person.php';
	include_once '../../classes/barangay.php';

	$person = new Person($db);
	$barangay = new Barangay($db);

?>
<br>

	<div class="row">
		<div class="card-header container-fluid bg-light">
			<div clas="col-md-6 float-left">
			<h1 class="text-dark"><i class="fas fa-user-slash text-dark"></i> Deceased People</h1>	
				<center>
				<form target="_blank" name="formReport" action="report/dec_report" method="POST">
						<div class='row'>
							<div class='col-sm-4'>
								<label >Date From:</label>
								<input type="date" class="form-control" name="sDate" required>
							</div>
							<div class='col-sm-4'>
								<label >Date To:</label>
								<input type="date" class="form-control" name="eDate" required>
								<input type="hidden" name="referral" value="<?php echo $_SESSION['referral'] ?>">
							</div>
							<div class='col-sm-2'>
								<label >Print Peport for Deceased:</label>
								<button type='submit' class='form-control btn btn-primary'><i class="fas fa-print"></i></button>
							</div>
						</div>
				</form>
				</center>
			</div>
		</div>
	</div>
	<div class="row bg-light">
			<table id="tblpeople" class="table table-hover compact nowrap table-bordered" cellspacing="0">
			  <thead class="thead-light">
			    <tr>
			   	  <th style="width: 5%;">Person ID</th>
			      <th>Full Name</th>
			      <th>Gender</th>
			      <th>Address</th>
			      <th style="width: 20%;">Time of Death</th>
			    </tr>
			  </thead>
			  <tbody>
			  <?php
			  $stmt = $person->readallDeceasedbrgy();
			  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				echo '
			    <tr>
			      <th>'.$row['pid'].'</th>
			      <td>'.$row['fullname'].'</td>
			      <td>'.$row['gender'].'</td>
			      <td>'.$row['address'].'</td>
			      <td>'.$row['datequar'].'</td>';
			      //quaratined by
	      		  
			  }
			echo '
			  </tbody>
			</table>';
			?>
			
			<br>
		</div>


<script>
//pagination and table features(number of items per table and sorting)
$(document).ready(function() {
	 var table = $('#tblpeople').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
		"bLengthChange": true,
		"bInfo" : true,
		"order": [[ 7, "desc" ]],
		"sDom":"ltipr"
    } );


    // Setup - add a text input to each footer cell
   /** $('#tblpeople thead tr').clone(true).appendTo( '#tblpeople thead' );
    $('#tblpeople thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();

        $(this).html( '<input type="text" class="form-control input-sm" placeholder="Search '+title+'" />' );

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );


    } );*/
} );
</script>
<?php
	include_once '../include/footer.php';
?>