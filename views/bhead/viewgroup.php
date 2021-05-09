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
	include_once '../../classes/barangay.php';
	include_once '../../classes/person.php';
	include_once '../../classes/record.php';

	$barangay = new Barangay($db);
	$person = new Person($db);
	$record = new Record($db);
?>
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
		
		<!--notification button -->
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
		</style>

	  </div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<a href="viewpeoplein">
				<div class="card bg-success">
				  <center>
				  	<p class="fas fa-user-friends text-light" style="font-size:90px;"></p>
					<h3 class="text-light">People Inside: 
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
<?php
	include_once '../include/footer.php';
?>