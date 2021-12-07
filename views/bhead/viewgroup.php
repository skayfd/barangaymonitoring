<?php
	ini_set('display_errors', 1);
	session_start();
	$title = "View Group";
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
<<<<<<< HEAD
  include_once '../include/sidebar/dashboard.php';
	include_once '../../classes/user.php';
=======
>>>>>>> parent of 3ffc982 (new ui)
	include_once '../../classes/barangay.php';
	include_once '../../classes/person.php';
	include_once '../../classes/record.php';

	$barangay = new Barangay($db);
	$person = new Person($db);
	$record = new Record($db);
?>
<<<<<<< HEAD
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
         <h1 class="h2"><?php 
				$stmt = $barangay->readrelatedGroup();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				echo "<i><b>".$row['brgyname']."</b></i>";
				}
			?></h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <h3><p><?php echo date('F d, Y');?> <span id="clock"></span></p></h3>
              </div>
              
            </div>
    </div>

        <div class="row">
            <div class="col">
                <div class="card border-success mb-3">
                    <div class="card-header bg-success">
                    <center><h5><b class="font font-text-dark border-white">Recovered:</b>
                        <?php
                            $stmt = $person->countRecoveredbrgy(); 
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            extract($row);
                                echo '<b>'.$row['count'].'</b>';
                            }
                        ?></h5>
                    </div>
                    <div>
                        <center><h5><a href="viewBrgyRecovered" class="text-success btn-link"><i>view</i></a></h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-danger mb-3">
                    <div class="card-header bg-danger">
                    <center><h5><b class="font font-text-dark border-white">PUI:</b>
                    <?php
                        $stmt = $person->countPUIbrgy(); 
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                            echo '<b>'.$row['count'].'</b>';
                        }
                    ?></h5>
                    </div>
                    <div>
                        <center><h5><a href="viewBrgyPUI" class="text-danger btn-link"><i>view</i></a></h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-warning mb-3">
                    <div class="card-header bg-warning">
                    <center><h5><b class="font font-text-dark border-white">PUM:</b>
                    <?php
                        $stmt = $person->countPUMbrgy(); 
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                            echo '<b>'.$row['count'].'</b>';
                        }
                    ?></h5>
                    </div>
                    <div>
                        <center><h5><a href="viewBrgyPUM" class="text-warning btn-link"><i>view</i></a></h5>
                    </div>
                </div>
            </div>
            <div class="col">
            <div class="card border-dark mb-3 text-white">
                    <div class="card-header bg-dark">
                    <center><h5><b class="font font-text-white">Deceased:</b>
                    <?php
                        $stmt = $person->countDeceasedbrgy(); 
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                            echo '<b>'.$row['count'].'</b>';
                        }
                    ?></h5>
                    </div>
                    <div>
                        <center><h5><a href="viewBrgyDeceased" class="text-dark btn-link"><i>view</i></a></h5>
                    </div>
                </div>
            </div>
        </div>
          <hr>

      <div class="table-responsive">
        <div class="table-wrapper">
        <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h1><b>People Registered in Barangay</b></h1></div>
                    <div class="col-sm-4">

                        <a type="button" class="btn btn-info add-new" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add New</a>
                    </div>
                </div>
            </div>
            <table id="tblpeople" class="table table-striped table-sm py-md-0">
                <thead>
                  <tr>
                    <th style="width: 4%;">ID no.</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Contact #</th>
                    <th scope="col">Address</th>
                    <th scope="col">Listed By</th>
                    <th scope="col">Barangay from</th>
                    <th scope="col">Date Added</th>
                    <th scope="col">Current Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $stmt = $person->readallpeople2();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                echo '
                  <tr>
                    <th><center>'.$row['pid'].'</th>
                    <td>'.$row['fullname'].'</td>
                    <td>'.$row['gender'].'</td>
                    <td>'.$row['contactno'].'</td>
                    <td>'.$row['address'].'</td>
                    <td>'.$row['addedby'].'</td>
                    <td><b>'.$row['barfrom'].'</b></td>
                    <td>'.$row['daterecorded'].'</td>
                    <td>';
                    if($row['personStatus'] == 'Recovered'){
                      echo '<p class="text-success"><b>RECOVERED</b></p>';
                    }
                    elseif($row['personStatus'] == 'PUM'){
                      echo '<p class="text-warning"><b>PUM</b></p>';
                    }
                  elseif($row['personStatus'] == 'Deceased'){
                  echo '<p class="text-dark"><b>DECEASED</b></p>';
                  }
                    elseif($row['personStatus'] == 'PUI'){
                      echo '<p class="text-danger"><b>POSITIVE</b></p>';
                    }
                    echo '</td>
                    <td>
                      ';
                      if($row['personStatus'] == 'PUI'){
                        echo '
                          <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-success btn-sm edit-object" edit-id="'.$row['pid'].'"><span data-feather="user-plus"></span></button>
                        <button type="button" class="btn btn-info btn-sm record-object" record-id="'.$row['pid'].'"><span data-feather="eye"></span></button>	
                        <a href="genId?id='.$row['pid'].'" target="_blank" class="btn btn-warning btn-sm"><span data-feather="printer"></span></a>
                        </div>
                      <center>
                      <button type="button" class="btn btn-warning btn-sm trace-object" trace-id="'.$row['pid'].'"><span data-feather="search"></span>Trace</button>
                      
                      </center>
                        ';
                      }
                      else if($row['personStatus'] == 'Deceased') {
                        echo '
                        <div class="btn-group" role="group" aria-label="Basic example">
                      <button type="button" class="btn btn-info btn-sm record-object" record-id="'.$row['pid'].'"><span data-feather="eye"></span></button>	
                      <button type="button" class="btn btn-dark btn-sm a-object" a-id="'.$row['pid'].'"><span data-feather="save"></span></button>	
                    </div>
                        ';
                      }
                    else {
                    echo '
                    <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-success btn-sm edit-object" edit-id="'.$row['pid'].'" ><span data-feather="user-plus"></span></button>
                    <button type="button" class="btn btn-info btn-sm record-object" record-id="'.$row['pid'].'"><span data-feather="eye"></span></button>
                    <a href="genId?id='.$row['pid'].'" target="_blank" class="btn btn-warning btn-sm"><span data-feather="printer"></span></a>
                    </div>
                        ';
                      }					  
                  echo '</td></tr>';
                }
              echo '
                </tbody>
              </table>';
              ?>
          </div>
        </div> 

<!--Add Person Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered bd-example-modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form method="POST" action="personAdd" enctype="multipart/form-data">
						<div style="border-radius:20px;">
								<h4>Add Person</h4>
								<p class="text-danger"><small>* are shown as required.</small></p>
								<hr>
							<div class="row">
								<div class="col-md-4">
									<label>First Name*</label>
									<input type="text" class="form-control" name="firstname" pattern="[A-Za-z\s]{3,}" title="3 or more letters required, numbers are not allowed" value='<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>' required>
								</div>
								<div class="col-md-4">
									<label>Middle Name</label>
									<input type="text" class="form-control" name="middlename" pattern="[A-Za-z\s]{3,}" placeholder="Optional" value='<?php echo isset($_POST['middlename']) ? $_POST['middlename'] : '' ?>'>
								</div>
								<div class="col-md-4">
									<label>Last Name*</label>
									<input type="text" class="form-control" name="lastname" pattern="[A-Za-z\s]{3,}" title="3 or more letters required, numbers are not allowed" value='<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>'required>
								</div>			
							</div><br>
							<div class="row">
								<div class="col-md-6">
									<label>Contact Number*</label>
									<input type="text" class="form-control" pattern=".{11,}" title="Please enter a valid contact number which contains 11 numbers." name="contactno" value='<?php echo isset($_POST['contactno']) ? $_POST['contactno'] : '' ?>' required>
								</div>
								<div class="col-md-6">
									<label>Gender*</label>
									<select class="custom-select" name = "gender" required>
									<option selected></option>
									<option value="Female">Female</option>
									<option value="Male">Male</option>
									</select>
								</div>
							</div><br>
							<div class="row">
								<div class="col-sm-12">
									<label>Address*</label>
									<textarea class="form-control" name="address" pattern="[A-Za-z]{3,}" title="3 or more letters required" required><?php echo isset($_POST['address']) ? $_POST['address'] : '' ?></textarea>
								</div>
							</div><br>
						</div>	      	
					


      </div>
      <div class="modal-footer">
          <input type="submit" name="submit" class="btn btn-primary" value="Create">
					<a href="viewlist" class="btn btn-danger" data-dismiss="modal">Back</a>
      </div>
      </form>
    </div>
  </div>
</div>       


<div class="modal fade" id="recordPerson" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="addRecordLabel">View Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal-body bg-white" id="addRecordContent2">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--Datepicker for Trace-->
<div class="modal fade" id="tracemodal" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="addRecordLabel"> Trace Date</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body bg-white" id="addRecordContent3">
		
      </div>


    </div>
  </div>
</div>
<div class="modal fade" id="addRecord" tabindex="-1" role="dialog" aria-labelledby="addRecordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="addRecordLabel">Add Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="modal-body bg-white" id="addRecordContent">
			
			</div>
      </div>
    </div>
  </div>
</div>
<!-- Change Modal Width of view record -->
<style>
.modal-lg {
    max-width: 80%;
}
.modal {
    overflow: hidden;
}
.modal .modal-body {
    height: auto;
    overflow: auto;
}
.modal .modal-fixed {
    position: fixed;
    background-color:white;
}
</style>
<script>
//script for APOR/PUM/PUI/LSI
$(document).on('click', '.edit-object', function(){
    var pid = $(this).attr("edit-id");
  
    $.ajax({
		url:'addRecord.php',
		method: "POST",
		data:{pid:pid},
		success:function(data){
		  $('#addRecordContent').html(data);
		  $('#addRecord').modal('show');
		}
    });
});
//script for View Records
$(document).on('click', '.record-object', function(){
    var pid = $(this).attr("record-id");
  
    $.ajax({
		url:'viewrecord.php',
		data:{pid:pid},
		success:function(data){
		  $('#addRecordContent2').html(data);
		  $('#recordPerson').modal('show');
		}
    });
});
//script for tracing date
$(document).on('click', '.trace-object', function(){
    var pid = $(this).attr("trace-id");
  
    $.ajax({
		url:'tracedate.php',
		data:{pid:pid},
		success:function(data){
		  $('#addRecordContent3').html(data);
		  $('#tracemodal').modal('show');
		}
    });
});
//script for archiving person
$(document).on('click', '.a-object', function(){
    var pid = $(this).attr("a-id");
	var r = confirm("Are you sure you want to archive this person?");
	if (r == true) {
    $.ajax({
		url:'cascadeArchivePerson.php',
		method: "POST",
		data:{pid:pid},
		success:function(data){
		  window.location.reload();
		  alert("Archiving success");
		}
    });}
	else{
		window.alert("Archiving cancelled");
	}
});

//pagination and table features(number of items per table and sorting)
$(document).ready(function() {
	 var table = $('#tblpeople').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        "aLengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
		"bLengthChange": true,
		"bInfo" : true,
		"order": [[ 7, "desc" ]],
    } );
} );
</script>

<script>
	function showTime() {
	var d = new Date();
	document.getElementById("clock").innerHTML = d.toLocaleTimeString();
	}
	setInterval(showTime, 1000);
</script>
=======
<script src="../../assets/chartjs/chart.js"></script>
<script src="../../assets/chartjs/chartjs-plugin-colorschemes.js"></script>
<br>
<div class="container">
	<div class="jumbotron">
	  <div class="container">
	    <h1 class="display-4" style="color:black">
	    	<?php 
	    		$stmt = $barangay->readrelatedGroup();
	    		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
					echo "<b><i class='fas fa-campground'></i>&nbsp".$row['brgyname']."</b>";
			?>
		</h1>
		<p>
			<h5 class="lead" style="color:black">
			<?php
				// echo "<i class='fas fa-key'></i>&nbspYour Referral Code: <b><u>".$row['referral']."</u></b>";
				}//ending brace of while loop
			?>
			</h5>
		</p>
		<a href="reportpage" class="btn btn-info"><i class="far fa-file-alt"></i> Make Report</a>
		<a href="archives" class="btn btn-warning text-dark"><i class="fas fa-archive"></i> Archives</a>
		<a href="viewhistory" class="btn btn-dark"><i class="fas fa-receipt"></i> History/Activity Log</a>
		<!-- <a href="viewpum" class="btn btn-danger"><i class="fas fa-user-clock"></i> View PUMs Under Quarantine: <span class="badge badge-light"><?php $stmt0 = $person->countPUM(); while($row = $stmt0->fetch(PDO::FETCH_ASSOC)){ extract($row); echo $row['count']; }?></span></a> -->
		<br><br>
		
		<!--notification button PUM -->
		<a href="viewpum" class="notification btn-danger">
		  <?php
			  $stmt0 = $person->countPUM(); 
			  while($row = $stmt0->fetch(PDO::FETCH_ASSOC)){ 
			  	extract($row); 
			  	if($row['count'] == 0){
			  		echo '<span><i class="fas fa-user-clock"></i> PUMs Under Quarantine</span>';
			  	}
			  	else {
			  		echo '
			  		<span><i class="fas fa-user-clock"></i> PUMs Under Quarantine</span>
		  			<span class="badge">'.$row['count'].'</span>
			  		';
			  	}		  	
			  }
		  ?>
		</a>&nbsp&nbsp
		<!--notification button PUI -->
		<a href="viewpui" class="notification2 btn-danger">
		  <?php
			  $stmt0 = $person->countPUI(); 
			  while($row = $stmt0->fetch(PDO::FETCH_ASSOC)){ 
			  	extract($row); 
			  	if($row['count'] == 0){
			  		echo '<span><i class="fas fa-user-clock"></i> PUIs</span>';
			  	}
			  	else {
			  		echo '
			  		<span><i class="fas fa-user-clock"></i> PUIs</span>
		  			<span class="badge">'.$row['count'].'</span>
			  		';
			  	}		  	
			  }
		  ?>
		</a>

		<style>
			.notification {
			  background-color: #ff5100;
			  color: white;
			  text-decoration: none;
			  padding: 15px 26px;
			  position: relative;
			  display: inline-block;
			  border-radius: 2px;
			}

			.notification:hover {
			  background: black;
			}

			.notification .badge {
			  position: absolute;
			  top: -10px;
			  right: -10px;
			  padding: 5px 10px;
			  border-radius: 50%;
			  background: white;
			  color: black;
			}

			.notification2 {
			  background-color: #b30c00;
			  color: white;
			  text-decoration: none;
			  padding: 15px 26px;
			  position: relative;
			  display: inline-block;
			  border-radius: 2px;
			}

			.notification2:hover {
			  background: black;
			}

			.notification2 .badge {
			  position: absolute;
			  top: -10px;
			  right: -10px;
			  padding: 5px 10px;
			  border-radius: 50%;
			  background: white;
			  color: black;
			}
		</style>

	  </div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<a href="viewpeoplein">
				<div class="card bg-success">
				  <center>
				  	<p class="fas fa-user-friends text-light" style="font-size:90px;"></p>
					<h3 class="text-light">Barangay Officials Inside: 
						<?php
							$stmt = $barangay->numberofPeople();
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
								extract($row);
								echo "<b>".$row['total']."</b>";
							}
						?>							
					</h3>
				  </center>
				</div>	
			</a>			
		</div>
		<div class="col-md-4">
			<a href="viewlist">
				<div class="card bg-info">
				  <center>
				  	<p class="fas fa-user-friends text-light" style="font-size:90px;"></p>
				  	<h3 class="text-light">People Listed: 
				  		<?php 
				  			$stmt = $person->numberofPeopleList();
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
								extract($row);
								echo "<b>".$row['total']."</b>";
							}		
				  		?>					  			
				  	</h3>
				  </center>
				</div>
			</a>	
		</div>
		<div class="col-md-4">
				<a href="viewallrecords">
					<div class="card bg-warning">
					  <center>
					  	<p class="fas fa-clipboard-list text-dark" style="font-size:90px;"></p>
						<h3 class="text-dark">All Records: 
							<?php
								$stmt = $record->countRecords();
								while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
									extract($row);
									echo "<b>".$row['total']."</b>";
								}
							?>							
						</h3>
					  </center>
					</div>	
				</a>
			</div>
	</div><br>
		<center><h3>Number of Entries and Exits Per Day</h3></center>
		<canvas id="myChart3" class="bg-transparent"></canvas>			
		<script type="text/javascript">
			var ctx = document.getElementById('myChart3').getContext('2d');
			var chart = new Chart(ctx, {
			    // The type of chart
			    type: 'line',

			    // The data for our dataset
			    data: {
			        labels: [
					<?php
						$stmt = $record->readDateEntries();
						while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
							//echo "'".$row['date']." ".$row['time']."',"; //includes time pero it's a bit iffy
							echo "'".$row['date']."',";
						}
					?>					        
			        ],
			        datasets: [{
			            label: 'Records',					  
			            pointStyle: 'triangle',
			            radius: 9,
			            // fill: false,
			            hoverRadius: 13,
			            // steppedLine: 'middle',
			            // backgroundColor: ['#f8641c'],
			            
			            data: [
			            <?php
				            $stmt = $record->readDateEntries();
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
								echo "'".$row['entrycount']."',";
							}
			            ?>
			            ]
			        }]
			    },
			    // Configuration options go here
			    options: {
					plugins: {
					    colorschemes: {
					    scheme: 'brewer.YlGn3' //scheme from chartjs-plugin-colorschemes
					    }
					},				    	
			    	aspectRatio: 4,
					scales: { //set to match dark theme
						xAxes: [{

							gridLines:{
								color: 'white',
								zeroLineColor: 'white'
							},
							ticks: {
								fontColor: 'white'
							}
						}],
						yAxes: [{
							gridLines:{
								color: 'white',
								zeroLineColor: 'white'
							},
							ticks: {
								fontColor: 'white'
							}
						}]
					},
					legend: {
		              labels: {
		                 fontColor: 'white'
		              }
		            }
			    },
			    plugins: [{
			      	beforeDraw: function(c) {
			        var chartHeight = c.chart.height;
			        c.scales['y-axis-0'].options.ticks.fontSize = chartHeight * 6 / 100; //fontSize: 6% of canvas height
			      }
			   	}]
			});		
		</script>
		<br>
		<div class="row">
		<div class="container">
		<div class="row">
			<div class="col-md-6 text-light">
				<center><h3>Number of People in Each Category</h3></center>
				<?php
					$stmt = $record->countStatus();
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		            	if($row['number'] >= '1'){
							require 'numeachcateg.php';
						}
						else {
							echo "<center><p class='lead text-warning'>Need More Records to Display <i class='fas fa-chart-pie'></i></p></center>";
						}
		            }
				?>
			</div>
			<div class="col-md-6 text-light">
				<center><h3>Total Number of All Records Per Category</h3></center>
				<?php
					$stmt = $record->countStatus();
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		            	if($row['number'] >= '1'){
							require 'numallcateg.php';
						}
						else {
							echo "<center><p class='lead text-warning'>Need More Records to Display <i class='fas fa-chart-bar'></i></p></center>";
						}
		            }
				?>
			</div>
		</div>
		</div>	
		</div><br>
	</div>
	
<style>
a:link, a:visited {
  color: white;
  text-align: center;
  text-decoration: none;
}
a:hover, a:active {
  background-color: none;
}
</style>
>>>>>>> parent of 3ffc982 (new ui)
<?php
	include_once '../include/footer.php';
?>