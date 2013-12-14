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
		<div class="modal small hide fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:450px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Process Details</h3>
            </div>
            <div id="comments">
                <div class="modal-body">
            		<h3 id="proc_title"></h3>
                    <div class="element">
                        <label for="Pending">Pending</label>
                        <p class="label label-info" id="Pending">0</p>
                    </div>
                    <div class="element">
                        <label for="On-going">On-going</label>
                        <p class="label label-info" id="On-going">0</p>
                    </div>
                    <div class="element">
                        <label for="Completed">Completed</label>
                        <p class="label label-info" id="Completed">0</p>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Back</button>
            </div>
        </div>
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
		$('#detailsModal').modal({show : false});
		<?php if( $this->session->userdata('lvl') == 2 ){ ?>

		function getProcData( proc ) {
			$.ajax({
                    type: "POST"
                    ,url: "<?=base_url();?>home/ajax_request"
                    ,dataType: 'json'
                    ,data: { action : 'proc_details', proc : proc },
                    success: function( data ) {
                    	if(data.length){
	                    	$.each( data, function( k, v ){
	                    		switch( v.status ) {
	                    			case 'Pending':
	                    				$('#Pending').html(v.total);
	                    				break;
	                    			case 'On-Going':
	                    				$('#On-Going').html(v.total);                    			
	                    				break;
	                    			case 'Completed':
	                    				$('#Completed').html(v.total);                    			
	                    				break;
	                    			default:
	                    				break;
	                    		}
	                    	});
	                    }
	                    $('#proc_title').html('Process: '+proc);
						$('#detailsModal').modal();
                    }
                });
		}

        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
		        ]
		    };
		});

        var proc = <?=$process_summary?>;
        var proc_data = [];
        var proc_plot = [];
        $.each( proc, function( k, v ){
			console.log('a', k, v);
			proc_data.push( [ k, v ] );
		});
		proc_plot = [{
						type: 'pie',
            			name: 'Process Percentage',
						data : proc_data,
						point:{
									events:{
										click: function (event) {
											getProcData(this.name);
										}
									}
						        }
					  }];
		console.log(proc_plot);
    	$('#process').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Process Status, <?=date('Y')?>'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                        }
                    }
                }
            },
            series: proc_plot
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
