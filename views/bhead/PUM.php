<style>
    #tblpum{
        width: 400px;height: 300px;
        overflow:scroll;
    }
</style>
<br>
<div class="container">

	<div class="row bg-light">
		<div id="tblpum" class="container table-responsive overflow-auto">

        	<table id="tblpeople" class="table table-hover compact nowrap table-bordered" cellspacing="0">
			  <thead class="thead-light">
			    <tr>
			   	  <th scope="col">Person ID</th>
			      <th scope="col">Full Name</th>
			      <th scope="col">Gender</th>
			      <th scope="col">Contact Number</th>
			      <th scope="col">Address</th>
			      <th scope="col">Listed By</th>
			      <th scope="col">Barangay from</th>
			      <th scope="col">Date Quarantined</th>
			      <th scope="col">No. of Days in Quarantine</th>
			      <th scope="col">Qarantined By</th>
			      <th scope="col">Change Status</th>
			    </tr>
			  </thead>
			  <tbody>
			  <?php
			  $stmt = $person->readallPUM();
			  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				echo '
			    <tr>
			      <th scope="row"><center>'.$row['pid'].'<br><a href="genId?id='.$row['pid'].'" target="_blank" class="btn btn btn-warning btn-sm"><i class="far fa-id-badge"></i> Create ID</a></center></th>
			      <td>'.$row['fullname'].'</td>
			      <td>'.$row['gender'].'</td>
			      <td>'.$row['contactno'].'</td>
			      <td>'.$row['address'].'</td>
			      <td>'.$row['addedby'].'</td>
			      <td><b>'.$row['barfrom'].'</b></td>
			      <td>'.$row['datequar'].'</td>
			      <td>';
			      //number of days quarantined
			      if($row['days'] >= 14){
			      	echo '<p class="text-success"><b>Finished Self Quarantine</b></p>';
			      }
			      else {
			      	echo "<center><b><p class='text-info'>".$row['days']."</p></b></center>";
			      }
			      //quarantined by
			      $person->pid = $row['pid'];
			      $stmt2 = $person->readQuarBy();
			      while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
			      	extract($row2);
			      	echo '
			      	<td>'
				    	.$row2['quarby']. 	
		      		'</td>';
			      }

	      		  echo '
	      		  <td>
					<input type="button" class="btn btn-success btn-sm edit4-object" edit4-id="'.$row['pid'].'" value="Change status to Cleared"/><hr>
					<input type="button" class="btn btn-danger btn-sm edit5-object" edit5-id="'.$row['pid'].'" value="Mark as Covid Positive"/>
				  </td>
			    </tr>';
			  }
			echo '
			  </tbody>
			</table>';
			?>
			
			<br>
		</div>
	</div><br>
</div>

<script>
//script for marking PUI
$(document).on('click', '.edit3-object', function(){
    var pid = $(this).attr("edit3-id");
	var r = confirm("Are you sure you want to update the status?");
	if (r == true) {
    $.ajax({
		url:'statusClick.php',
		method: "POST",
		data:{pid:pid},
		success:function(data){
		  window.location.reload();
		  alert("Status Updated");
		}
    });}
	else{
		window.alert("Status update cancelled");
	}
});
//script for marking changing to resident
$(document).on('click', '.edit4-object', function(){
    var pid = $(this).attr("edit4-id");
	var r = confirm("Are you sure you want to update the status?");
	if (r == true) {
    $.ajax({
		url:'statusClick2.php',
		method: "POST",
		data:{pid:pid},
		success:function(data){
		  window.location.reload();
		  alert("Status Updated");
		}
    });}
	else{
		window.alert("Status update cancelled");
	}
});
//script for marking resident as a COVID positive patient
$(document).on('click', '.edit5-object', function(){
    var pid = $(this).attr("edit5-id");
	var r = confirm("Are you sure you want to update the status?");
	if (r == true) {
    $.ajax({
		url:'statusClick3.php',
		method: "POST",
		data:{pid:pid},
		success:function(data){
		  window.location.reload();
		  alert("Status Updated");
		}
    });}
	else{
		window.alert("Status update cancelled");
	}
});
</script>
