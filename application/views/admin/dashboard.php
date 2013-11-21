<div class="full_w">
	<!-- <div class="h_title">Visits statistics</div>
		<script src="<?=base_url().JS?>highcharts_init.js"></script>
		<div id="container" style="min-width: 300px; height: 180px; margin: 0 auto"></div>
		<script src="<?=base_url().JS?>highcharts.js"></script> -->
	<div class="h_title">User statistics</div>
	<div class="stats">
		<div class="today">
			<h3>Employees</h3>
			<p class="count"><?=$users[0]['total']?></p>
			<p class="type">Total</p>
			<p class="count"><?=$users[0]['active']?></p>
			<p class="type">Activated</p>
		</div>
		<div class="week">
			<h3>Managers</h3>
			<p class="count"><?=$users[1]['total']?></p>
			<p class="type">Total</p>
			<p class="count"><?=$users[1]['active']?></p>
			<p class="type">Activated</p>
		</div>
	</div>
</div>