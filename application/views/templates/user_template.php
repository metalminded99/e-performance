<script src="<?=base_url().JS?>highcharts/highcharts.js"></script>
<script src="<?=base_url().JS?>highcharts/modules/exporting.js"></script>
<script type = "text/javascript" > 
	$(function () {
	    $('#container').highcharts({
	        chart: {
	            type: 'bar'
	        },
	        title: {
	            text: 'Historic World Population by Region'
	        },
	        subtitle: {
	            text: 'Source: Wikipedia.org'
	        },
	        xAxis: {
	            categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
	            title: {
	                text: null
	            }
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                text: 'Population (millions)',
	                align: 'high'
	            },
	            labels: {
	                overflow: 'justify'
	            }
	        },
	        tooltip: {
	            valueSuffix: ' millions'
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
	            name: 'Year 1800',
	            data: [107, 31, 635, 203, 2]
	        }, {
	            name: 'Year 1900',
	            data: [133, 156, 947, 408, 6]
	        }, {
	            name: 'Year 2008',
	            data: [973, 914, 4054, 732, 34]
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
