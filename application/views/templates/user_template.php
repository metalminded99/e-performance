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
		$('#process').highcharts({
	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: 'Process Status, 2013'
	        },
	        tooltip: {
	    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: false
	                },
	                showInLegend: true
	            }
	        },
	        credits: {
	            enabled: false
	        },
	        series: [{
	            type: 'pie',
	            name: 'Process',
	            data: [
	                ['Firefox',   45.0],
	                ['IE',       26.8],
	                {
	                    name: 'Chrome',
	                    y: 12.8,
	                    sliced: true,
	                    selected: true
	                },
	                ['Safari',    8.5],
	                ['Opera',     6.2],
	                ['Others',   0.7]
	            ]
	        }]
	    });

		$('#scores').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Monthly Average Rainfall'
            },
            subtitle: {
                text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rainfall (mm)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
	        credits: {
	            enabled: false
	        },
            series: [{
                name: 'Tokyo',
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
    
            }, {
                name: 'New York',
                data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]
    
            }, {
                name: 'London',
                data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]
    
            }, {
                name: 'Berlin',
                data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]
    
            }]
        });

		$('#compentency').highcharts({
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
	            x: -340,
	            y: 0,
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

		$('#goals').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Stacked bar chart'
            },
            xAxis: {
                categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total fruit consumption'
                }
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
	        credits: {
	            enabled: false
	        },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
                series: [{
                name: 'John',
                data: [5, 3, 4, 7, 2]
            }, {
                name: 'Jane',
                data: [2, 2, 3, 2, 1]
            }, {
                name: 'Joe',
                data: [3, 4, 4, 2, 5]
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
			<div class="stats">
				<p class="stat">
					<span class="number"><?=$process_noti?></span>Process task
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
				<!--- Pie Chart -->
				<div class="block span6">
					<p class="block-heading" data-toggle="collapse" data-target="#chart-container">
						Process Status
					</p>
					<div id="process-container" class="block-body collapse in">
						<div id="process" style="width: auto; height: 350px; margin: 0 auto"></div>
					</div>
				</div>

				<!--- Basic Bar Chart -->
				<div class="block span6">
					<p class="block-heading" data-toggle="collapse" data-target="#chart-container">
						Score Distribution
					</p>
					<div id="scores-container" class="block-body collapse in">
						<div id="scores" style="width: auto; height: 350px; margin: 0 auto"></div>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<!--- Bar Chart -->
				<div class="block span6">
					<p class="block-heading" data-toggle="collapse" data-target="#chart-container">
						Competency Scores
					</p>
					<div id="compentency-container" class="block-body collapse in">
						<div id="compentency" style="width: auto; height: 350px; margin: 0 auto"></div>
					</div>
				</div>

				<!--- Stacked Bar Chart -->
				<div class="block span6">
					<p class="block-heading" data-toggle="collapse" data-target="#chart-container">
						Goal Status
					</p>
					<div id="goals-container" class="block-body collapse in">
						<div id="goals" style="width: auto; height: 350px; margin: 0 auto"></div>
					</div>
				</div>
			</div>
			
			<!-- user widgets -->
			<?=$user_widgets?>
			<!-- user widgets END -->
		</div>
