<?php
	session_start();
	$title = "Home";

	include_once '../include/header.php';
	include_once '../../classes/barangay.php';
	include_once '../../classes/user.php';
	include_once '../../classes/record.php';
	include_once '../../classes/person.php';

	if(!isset($_SESSION['uid'])){
		header("Location: ../login.php");
	}
	elseif($_SESSION['type'] == 1){
		if($_SESSION['status'] == 1){ header("Location: views/bhead/headhome"); }
	}
	elseif($_SESSION['type'] == 3){
		if($_SESSION['status'] == 1){ header("Location: views/request/reqhome"); }
	}

	$barangay = new Barangay($db);
	$user = new User($db);
	$person = new Person($db);
	$record = new Record($db);
?>
<script src="../../assets/chartjs/chart.js"></script>
<script src="../../assets/chartjs/chartjs-plugin-colorschemes.js"></script>
<br/>
<div class="container">
	<!-- member home, note to self(create ui na) -->
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
	    <h3 class="lead" style="color:black">
	    	<?php
	    		echo "<i class='fas fa-map-marker-alt'></i>&nbspAddress: <b>".$row['streetname']."</b>";
	    		}//ending brace of while loop
	    	?>
		</h3>
		<p class="lead" style="color:black">
			<?php
				$stmt = $user->readProfile();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
					echo '<i class="fas fa-user-tie"></i> Name: <b>'.$row['firstname'].' '.$row['lastname'].'</b>'; 
				} 
			?>
		</p>
	  </div>
	</div>

	<div class="container">
		<div class="row">	
			<div class="col-md-4">
				<a href="viewpeoplemem" id="pinside">
					<div class="card bg-success">
					  <center>
					  	<p class="fas fa-user-friends" style="font-size:90px;"></p>
						<h3>Officials Inside: 
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
				<a href="viewpeoplelist" id="pinside">
					<div class="card bg-info">
					  <center>
					  	<p class="fas fa-user-friends" style="font-size:90px;"></p>
						<h3>People Listed: 
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
				<a href="viewallrecords" id="pinside">
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
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<center><h3>Number of Entries Per Day</h3></center>
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
					            label: 'Entries',					  
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
							    scheme: 'office.Austin6' //scheme from chartjs-plugin-colorschemes
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
			</div>
			<div class="col-md-1"></div>
		</div><br>
		
	</div>
</div>
<style>
#pinside {
  color: white;
  background-color: transparent;
  text-decoration: none;
}
#myChart2, #myChart3 {
	background-color: white;
}
</style>
<?php
	include_once '../include/footer.php';
?>