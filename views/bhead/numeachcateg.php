<canvas id="myChart"></canvas>
<script type="text/javascript">
	var ctx = document.getElementById('myChart').getContext('2d');
	var chart = new Chart(ctx, {
	    // The type of chart we want to create
	    type: 'doughnut',

	    // The data for our dataset
	    data: {
	        labels: ['APOR', 'PUI', 'PUM', 'LSI'],
	        datasets: [{
	            label: 'Number of People Categorized',
	            backgroundColor: [
	            '#5cb85c',
	            '#d9534f',
	            '#f0ad4e',
	            '#5bc0de'
	            ],
	            
	            data: [
	            // '3', '5', '8'
	            <?php
		            $stmt = $record->readStatus();
		            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		            	echo $row['number'].',';
		            }
	            ?>
	            ]
	        }]
	    },
	    // Configuration options go here
	    options: {
	    	legend: {
              labels: {
                 fontColor: 'white'
              }
            }
	    }
	});
</script>