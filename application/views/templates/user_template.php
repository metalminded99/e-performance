<script src="<?=base_url().JS?>highcharts/highcharts.js"></script>
<script src="<?=base_url().JS?>highcharts/modules/exporting.js"></script>
<script type = "text/javascript" > 
	var self_score = <?=$self_score?>;
	var peer_score = <?=$peer_score?>;
	var manager_score = <?=$manager_score?>;

	$(function () {		
	    $('#container').highcharts({
	        chart: {
	            type: 'bar'
	        },
	        title: {
	            text: 'Appraisal Summary'
	        },
	        subtitle: {
	            text: 'Feedback scores'
	        },
	        xAxis: {
	            categories: ['Core Competency', 'Performance Output', 'Abilities', 'Skills'],
	            title: {
	                text: null
	            }
	        },
	        yAxis: {
	            min			: 0,
	            tInterval	: 1,
				max			: 5,
	            title: {
	                text: 'Ratings (Average)',
	                align: 'high'
	            },
	            labels: {
	                overflow: 'justify'
	            }
	        },
	        tooltip: {
	            valueSuffix: ''
	        },
	        plotOptions: {
	            bar: {
	                dataLabels: {
	                    enabled: true
	                }
	            }
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'top',
	            x: -100,
	            y: 100,
	            floating: true,
	            borderWidth: 1,
	            backgroundColor: '#FFFFFF',
	            shadow: true
	        },
	        credits: {
	            enabled: false
	        },
	        series: [{
	            name: 'Self score',
	            data: [ parseFloat(self_score[2].ave), parseFloat(self_score[3].ave), parseFloat(self_score[1].ave), parseFloat(self_score[0].ave) ]
	        }, {
	            name: 'Peer score',
	            data: [ parseFloat(peer_score[2].ave), parseFloat(peer_score[3].ave), parseFloat(peer_score[1].ave), parseFloat(peer_score[0].ave) ]
	        }, {
	            name: 'Manager score',
	            data: [	parseFloat(manager_score[2].ave), parseFloat(manager_score[3].ave), parseFloat(manager_score[1].ave), parseFloat(manager_score[0].ave) ]
	        }]
	    });
	});
</script>

<div class="container-fluid">
	<div class="row-fluid">

		<!-- left side nav -->
		<?=$left_side_nav?>
		<!-- left side nav END -->
		

		<div class="span9">
			<!-- <script type="text/javascript" src="lib/jqplot/jquery.jqplot.min.js"></script>
			<script type="text/javascript" charset="utf-8" src="javascripts/graphDemo.js"></script>-->
			<div class="stats">
				<p class="stat">
					<span class="number"><?=$goal_noti?></span>process task
				</p>
				<p class="stat">
					<span class="number"><?=$trainings_noti?></span>training
				</p>
				<p class="stat">
					<span class="number"><?=$goal_noti?></span>goal
				</p>
				<p class="stat">
					<span class="number">
						<?php 
							if( $feedback_noti > 0 ) {
						?>
						<a href="<?=base_url()?>feedbacks"><?=$feedback_noti?></a>
						<?php 
							} else {
								echo $feedback_noti;
							} 
						?>
					</span>Feedback
				</p>
			</div>
			<h1 class="page-title">Dashboard</h1>
			<div class="row-fluid">
				<div class="block">
					<p class="block-heading" data-toggle="collapse" data-target="#chart-container">
						Performance Chart
					</p>
					<div id="chart-container" class="block-body collapse in">
						<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
					</div>
				</div>
			</div>
			
			<!-- user widgets -->
			<?=$user_widgets?>
			<!-- user widgets END -->
		</div>
