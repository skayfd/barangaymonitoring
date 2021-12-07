<style>
    #tblpui{
        width: 500px;height: 200px;
        overflow:scroll;
    }
</style>
<div class="row bg-light">
		<div id="tblpui" class="container table-responsive overflow-auto">
			<table id="tblpeople" class="table table-hover compact nowrap table-bordered" cellspacing="0">
			  <thead class="thead-light">
			    <tr>
			   	  <th scope="col" style="width: 55%;"></th>
			      <th scope="col" stlyr="width: 50%;"></th>
			    </tr>
			  </thead>
			  <tbody>
			  <?php
			  $stmt = $person->readallPUI();
			  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				echo '
			    <tr>
                  <td><b>
                    Person ID:<br>
                    Full Name:<br>
                    Gender:<br>
                    Contact Number:<br>
                    Address:<br>
                   
                    Marked Positive by:<br>
                    <input type="button" class="btn btn-warning btn-sm edit3-object" edit3-id="'.$row['pid'].'" value="Mark as PUM"/>
                    </b></td>
			      <td scope="row">'.$row['pid'].'
                  <br>'.$row['fullname'].'
			      <br>'.$row['gender'].'
			      <br>'.$row['contactno'].'
			      <br>'.$row['address'].'

                  ';
			      //quaratined by
			      $person->pid = $row['pid'];
			      $stmt2 = $person->positiveBy();
			      while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
			      	extract($row2);
			      	echo '
			      	<br>'
				    	.$row2['markedby']. 	
		      		'';
			      }
	      		  echo '
	      		  <br>
					
					<input type="button" class="btn btn-success btn-sm edit4-object" edit4-id="'.$row['pid'].'" value="Change status to Cleared"/>
				  
			   </td> </tr>';
			  }
			echo '
			  </tbody>
			</table>';
			?>
	    </div>
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
