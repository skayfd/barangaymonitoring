
<br>
<div class="row">
			<div class="container">
				<div class="row">
					<!--<div class="col-md-4 text-dark">
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
					</div>-->
					<!--<div class="col-md-8">
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
				</div>-->
			</div>	
		</div>
		<br>

		<center><h3>Number of Entries and Exits Per Day</h3></center>
		<canvas id="myChart3" class="bg-dark"></canvas>			
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