<script src="<?=base_url().JS?>highcharts/highcharts.js"></script>
<script src="<?=base_url().JS?>highcharts/modules/exporting.js"></script>
<script type = "text/javascript" > 
	function toInt(n){ return Number((n).toFixed(1)); };

	var series_plot = [];

	<?php if( isset( $performance_summary ) ){ ?>
	var perf_summary = <?=$performance_summary?>;
	$.each( perf_summary, function( k, v ){
		var perf_data = [];
		$.each( v, function( i, a ){
			perf_data.push( toInt( a ) );
		});
		series_plot = [{
						name : k,
						data : perf_data
					  }];
	});
	console.log( series_plot );
	<?php } ?>

	<?php if( isset( $goals_summary ) ){ ?>
	var goals_summary	= <?=$goals_summary?>;
	var goal_series 	= [];
	var goals_cat		= [];
	var pending 		= [];
	var on_going 		= [];
	var completed 		= [];
	var at_risk		 	= [];
	var warning 		= [];
	var late 			= [];
	var rejected 		= [];

	$.each( goals_summary, function( k, v ){
		var goal_data = [];

		goals_cat.push( k );
		$.each( v, function( i, a ){
			switch( i ) {
				case 'Pending':
					pending.push( a );
					break;
				case 'On-going':
					on_going.push( a );
					break;
				case 'Completed':
					completed.push( a );
					break;
				case 'Warning':
					warning.push( a );
					break;
				case 'At Risk':
					at_risk.push( a );
					break;
				case 'Late':
					late.push( a );
					break;
				case 'Rejected':
					rejected.push( a );
					break;
				default:
					break;
			}
		});
	});
	<?php } ?>

	$(function () {
		<?php if( $this->session->userdata('lvl') == 2 ){ ?>
		var colors = Highcharts.getOptions().colors,
            categories = ['Goals', '360 feedback', 'Training', 'Department Goal', 'Job Specification'],
            name = 'Browser brands',
            data = [{
                    y: 30.11,
                    color: colors[0],
                    drilldown: {
                        name: 'Goals Status',
                        categories: ['Pending', 'On-Going', 'Completed', 'Rejected'],
                        data: [10.85, 7.35, 33.06, 2.81],
                        color: colors[0]
                    }
                }, {
                    y: 21.63,
                    color: colors[1],
                    drilldown: {
                        name: '360 feedback Status',
                        categories: ['Pending', 'On-Going', 'Completed', 'Rejected'],
                        data: [0.20, 0.83, 1.58, 13.12],
                        color: colors[1]
                    }
                }, {
                    y: 11.94,
                    color: colors[2],
                    drilldown: {
                        name: 'Training Status',
                        categories: ['Pending', 'On-Going', 'Completed', 'Rejected'],
                        data: [0.12, 0.19, 0.12, 0.36],
                        color: colors[2]
                    }
                }, {
                    y: 17.15,
                    color: colors[3],
                    drilldown: {
                        name: 'Department Goal Status',
                        categories: ['Pending', 'On-Going', 'Completed', 'Rejected'],
                        data: [4.55, 1.42, 0.23, 0.21],
                        color: colors[3]
                    }
                }, {
                    y: 12.14,
                    color: colors[4],
                    drilldown: {
                        name: 'Job Specification Status',
                        categories: ['Pending', 'On-Going', 'Completed', 'Rejected'],
                        data: [ 0.12, 0.37, 1.65, 4.55],
                        color: colors[4]
                    }
                }];
    
    
        // Build the data arrays
        var browserData = [];
        var versionsData = [];
        for (var i = 0; i < data.length; i++) {
    
            // add browser data
            browserData.push({
                name: categories[i],
                y: data[i].y,
                color: data[i].color
            });
    
            // add version data
            for (var j = 0; j < data[i].drilldown.data.length; j++) {
                var brightness = 0.2 - (j / data[i].drilldown.data.length) / 5 ;
                versionsData.push({
                    name: data[i].drilldown.categories[j],
                    y: data[i].drilldown.data[j],
                    color: Highcharts.Color(data[i].color).brighten(brightness).get()
                });
            }
        }

    	$('#process').highcharts({
	        chart: {
                type: 'pie'
            },
            title: {
                text: 'Process Status'
            },
            yAxis: {
                title: {
                    text: 'Total Process Percentage'
                }
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            tooltip: {
        	    valueSuffix: '%'
            },
	        credits: {
	            enabled: false
	        },
            series: [{
                name: 'Percentage',
                data: browserData,
                size: '60%',
                dataLabels: {
                    formatter: function() {
                        return this.y > 5 ? this.point.name : null;
                    },
                    color: 'white',
                    distance: -30
                }
            }, {
                name: 'Percentage',
                data: versionsData,
                size: '80%',
                innerSize: '60%',
                dataLabels: {
                    formatter: function() {
                        // display only if larger than 1
                        return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ this.y +'%'  : null;
                    }
                }
            }]
	    });

		$('#compentency').highcharts({
	        title: {
                text: 'Yearly Employee Performance Average',
                x: -20 //center
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Scores'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ''
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
	        credits: {
	            enabled: false
	        },
            series: series_plot
	    });
		<?php } ?>

		$('#scores').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Monthly Score Average'
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
                    text: 'Scores'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
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
            series: series_plot
        });

		$('#goals').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Goals Status'
            },
            xAxis: {
                categories: goals_cat
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total goals per status'
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
                series:	 [{ name : 'Pending', data : pending },
						 { name : 'On-Going', data : on_going } ,
						 { name : 'Completed', data : completed  },
						 { name : 'Warning', data : warning },
						 { name : 'At Risk', data : at_risk },
						 { name : 'Late', data : late },
						 { name : 'Rejected', data : rejected }]
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
					<?php 
						if( $process_noti > 0 ) {
					?>
					<a href="<?=base_url()?>process">
						<span class="number"><?=$process_noti?></span>
					</a>
					<?php 
						} else {
					?>
					<span class="number">0</span>
					<?php
						} 
					?>
					Process task
				</p>
				<p class="stat">
					<?php 
						if( $trainings_noti > 0 ) {
					?>
					<a href="<?=base_url()?>my_trainings">
						<span class="number"><?=$trainings_noti?></span>
					</a>
					<?php 
						} else {
					?>
					<span class="number">0</span>
					<?php
						} 
					?>
					Training
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
					<span class="number">0</span>
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
					<span class="number">0</span>
					<?php
						} 
					?>
					Feedback
				</p>
			</div>
			<h1 class="page-title">Dashboard</h1>
			<?php if( $this->session->userdata('lvl') == 2 ){ ?>
			<div class="row-fluid">
				<!--- Pie Chart -->
				<div class="block span12">
					<p class="block-heading">
						Process Status
					</p>
					<div id="process-container" class="block-body collapse in">
						<div id="process" style="width: auto; height: 350px; margin: 0 auto"></div>
					</div>
				</div>
			</div>

			<div class="row-fluid">
				<!--- Bar Chart -->
				<div class="block span12">
					<p class="block-heading" data-toggle="collapse" data-target="#chart-container">
						Performance Scores
					</p>
					<div id="compentency-container" class="block-body collapse in">
						<div id="compentency" style="width: auto; height: 350px; margin: 0 auto"></div>
					</div>
				</div>
			</div>
			<?php } ?>

			<div class="row-fluid">
				<!--- Basic Bar Chart -->
				<div class="block span12">
					<p class="block-heading" data-toggle="collapse" data-target="#chart-container">
						<?=$this->session->userdata('lvl') == 2 ? 'Score Distribution' : 'My Monthly Score'?>
					</p>
					<div id="scores-container" class="block-body collapse in">
						<div id="scores" style="width: auto; height: 350px; margin: 0 auto"></div>
					</div>
				</div>
			</div>			

			<div class="row-fluid">
				<!--- Stacked Bar Chart -->
				<div class="block span12">
					<p class="block-heading" data-toggle="collapse" data-target="#chart-container">
						<?=$this->session->userdata('lvl') == 2 ? 'Goal Status' : 'My Goal Status'?>
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
