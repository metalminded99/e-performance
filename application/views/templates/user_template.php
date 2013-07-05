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
					<span class="number"><?=$goal_noti?></span>training
				</p>
				<p class="stat">
					<span class="number"><?=$goal_noti?></span>goal
				</p>
			</div>
			<h1 class="page-title">Dashboard</h1>
			<div class="row-fluid">
				<div class="block">
					<p class="block-heading" data-toggle="collapse" data-target="#chart-container">
						Performance Chart
					</p>
					<div id="chart-container" class="block-body collapse in">
						<div id="line-chart">
						</div>
					</div>
				</div>
			</div>
			
			<!-- user widgets -->
			<?=$user_widgets?>
			<!-- user widgets END -->

			<div class="row-fluid">
				<div class="block span6">
					<div class="block-heading" data-target="#widget2container">
						History<span class="label label-warning">+10</span>
					</div>
					<div id="widget2container" class="block-body">
						<table class="table">
						<tbody>
						<tr>
							<td>
								<p>
									<i class="icon-user"></i> Mark Otto
								</p>
							</td>
							<td>
								<p>
									Amount: $1,247
								</p>
							</td>
							<td>
								<p>
									Date: 7/19/2012
								</p>
								<a href="#">View Transaction</a>
							</td>
						</tr>
						<tr>
							<td>
								<p>
									<i class="icon-user"></i> Audrey Ann
								</p>
							</td>
							<td>
								<p>
									Amount: $2,793
								</p>
							</td>
							<td>
								<p>
									Date: 7/12/2012
								</p>
								<a href="#">View Transaction</a>
							</td>
						</tr>
						<tr>
							<td>
								<p>
									<i class="icon-user"></i> Mark Tompson
								</p>
							</td>
							<td>
								<p>
									Amount: $2,349
								</p>
							</td>
							<td>
								<p>
									Date: 3/10/2012
								</p>
								<a href="#">View Transaction</a>
							</td>
						</tr>
						<tr>
							<td>
								<p>
									<i class="icon-user"></i> Ashley Jacobs
								</p>
							</td>
							<td>
								<p>
									Amount: $1,192
								</p>
							</td>
							<td>
								<p>
									Date: 1/19/2012
								</p>
								<a href="#">View Transaction</a>
							</td>
						</tr>
						</tbody>
						</table>
					</div>
				</div>
				<div class="block span6">
					<p class="block-heading">
						Not Collapsible
					</p>
					<div class="block-body">
						<h2>Tip of the Day</h2>
						<p>
							Fava bean jícama seakale beetroot courgette shallot amaranth pea garbanzo carrot radicchio peanut leek pea sprouts arugula brussels sprout green bean. Spring onion broccoli chicory shallot winter purslane pumpkin gumbo cabbage squash beet greens lettuce celery. Gram zucchini swiss chard mustard burdock radish brussels sprout groundnut. Asparagus horseradish beet greens broccoli brussels sprout bitterleaf groundnut cress sweet pepper leek bok choy shallot celtuce scallion chickpea radish pea sprouts.
						</p>
						<p>
							<a class="btn btn-primary btn-large">Learn more &raquo;</a>
						</p>
					</div>
				</div>
			</div>
		</div>
