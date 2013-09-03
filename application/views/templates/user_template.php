<script src="<?=base_url().JS?>highcharts/highcharts.js"></script>
<script src="<?=base_url().JS?>highcharts/modules/exporting.js"></script>
<script type = "text/javascript" > 
	var series_plot = [];
	<?php if( !isset( $mngr_summary ) ){ ?>
	
	var self_score = <?=$self_score?>;
	var peer_score = <?=$peer_score?>;
	var manager_score = <?=$manager_score?>;

	var self_plot = [];
	if( self_score == 0 ) {
		self_plot = [ 0, 0, 0, 0 ];
	} else {
		self_plot = [ parseFloat(self_score[2].ave), parseFloat(self_score[3].ave), parseFloat(self_score[1].ave), parseFloat(self_score[0].ave) ];
	}

	var peer_plot = [];
	if( peer_score == 0 ) {
		peer_plot = [ 0, 0, 0, 0 ];
	} else {
		peer_plot = [ parseFloat(peer_score[2].ave), parseFloat(peer_score[3].ave), parseFloat(peer_score[1].ave), parseFloat(peer_score[0].ave) ];
	}

	var mngr_plot = [];
	if( manager_score == 0 ) {
		mngr_plot = [ 0, 0, 0, 0 ];
	} else {
		mngr_plot = [ parseFloat(manager_score[2].ave), parseFloat(manager_score[3].ave), parseFloat(manager_score[1].ave), parseFloat(manager_score[0].ave) ];
	}

	series_plot = [{
			            name: 'Self score',
			            data: self_plot
			        }, {
			            name: 'Peer score',
			            data: peer_plot
			        }, {
			            name: 'Manager score',
			            data: mngr_plot
			        }]

	<?php } else { ?>
		var mngr_summary = <?=$mngr_summary?>;
		if( mngr_summary == 0 ) {
			mngr_summary = [ 0, 0, 0, 0 ];
			series_plot.push(
								{
									name	: ''
									,data	: mngr_summary
								}
							);
		} else {
			$.each( mngr_summary, function( key, val ) {
				series_plot.push(
									{
										name	: key
										,data	: [
													parseFloat(mngr_summary[key]['core'])
													,parseFloat(mngr_summary[key]['perf'])
													,parseFloat(mngr_summary[key]['abl'])
													,parseFloat(mngr_summary[key]['skills'])
												  ]
									}
								);
			} );
		}
	<?php } ?>

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
	        series: series_plot
	    });
	});
</script>

<div class="container-fluid">
	<div class="row-fluid">

		<!-- left side nav -->
		<?=$left_side_nav?>
		<!-- left side nav END -->
		

		<div class="span9">
			<div class="stats">
				<p class="stat">
					<span class="number"><?=$goal_noti?></span>Process task
				</p>
				<p class="stat">
					<span class="number"><?=$trainings_noti?></span>Training
				</p>
				<p class="stat">
					<?php 
						if( $goal_noti > 0 ) {
					?>
					<a href="<?=base_url()?>my_goal">
						<span class="number"><?=$goal_noti?></span>
					</a>
					<?php 
						} else {
					?>
					<span class="number"><?=$goal_noti?></span>
					<?php
						} 
					?>
					Goal
				</p>
				<p class="stat">
					<?php 
						if( $feedback_noti > 0 ) {
					?>
					<a href="<?=base_url()?>feedbacks">
						<span class="number"><?=$feedback_noti?></span>
					</a>
					<?php 
						} else {
					?>
					<span class="number"><?=$feedback_noti?></span>
					<?php
						} 
					?>
					Feedback
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
