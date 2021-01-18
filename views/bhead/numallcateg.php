<canvas id="myChart2" class="bg-transparent"></canvas>
<script type="text/javascript">
	var ctx = document.getElementById('myChart2').getContext('2d');
	var chart = new Chart(ctx, {
	    // The type of chart we want to create
	    type: 'bar',

	    // The data for our dataset
	    data: {
	        labels: ['APOR', 'LSI', 'PUI', 'PUM'],
	        datasets: [{
	            label: 'Total Records',
	            backgroundColor: [
	            '#6eaa10',
	            '#0275d8',
	            '#931205',
	            '#d7b620'
	            ],
	            
	            data: [
	            // '3', '5', '8'
	            <?php
		            $stmt = $record->readAllAPOR();
		            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		            	echo $row['number'].',';
		            }
		            $stmt = $record->readAllLSI();
		            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		            	echo $row['number'].',';
		            }
		            $stmt = $record->readAllPUI();
		            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		            	echo $row['number'].',';
		            }
		            $stmt = $record->readAllPUM();
		            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		            	echo $row['number'].',';
		            }
	            ?>
	            ]
	        }]
	    },
	    // Configuration options go here
	    options: {
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
						beginAtZero:true,
						fontColor: 'white'
					}
				}]
			},
	    	legend: {
				display: false
        	},
	    }
	});
</script>