	<div class="span3">
		<div class="sidebar-nav">
			<div class="nav-header" data-toggle="collapse" data-target="#main-menu">
				<i class="icon-home"></i>Navigation
			</div>
			<ul id="main-menu" class="nav nav-list collapse in">
				<li><a href="<?=base_url()?>">Home</a></li>
				<li><a href="<?=base_url()?>process">Process</a></li>

				<?php if( $this->session->userdata( 'lvl' ) == '3' ) { ?>
				<li><a href="<?=base_url()?>journals">Journals</a></li>
				<li><a href="<?=base_url()?>my_goal">Goals</a></li>
				<li><a href="<?=base_url()?>my_trainings">Trainings</a></li>
				<?php } ?>

				<?php if( $this->session->userdata( 'lvl' ) == '2' ) { ?>
				<li><a href="<?=base_url()?>employees">Employees</a></li>
				<li><a href="<?=base_url()?>dept_goals">Department Goal</a></li>
				<li><a href="<?=base_url()?>appraisal">Appraisals</a></li>
				<li><a href="<?=base_url()?>potential_appraisal">Potential Promotions</a></li>
				<?php } ?>

				<li><a href="<?=base_url()?>feedbacks<?=$this->session->userdata('lvl') == 2 ? '/mngr' : '' ?>">360 Feedback</a></li>
			</ul>

			<?php if( $this->session->userdata( 'lvl' ) == '2' ) { ?>
			<div class="nav-header" data-toggle="collapse" data-target="#reports-menu">
				<i class="icon-book"></i>Reports
			</div>
			<ul id="reports-menu" class="nav nav-list collapse in">
				<li><a href="<?=base_url()?>reports/emp_goals">Employee Goals</a></li>
				<li><a href="<?=base_url()?>reports/dev_plans">Development Plans</a></li>
				<li><a href="<?=base_url()?>reports/process">Process</a></li>
				<li><a href="<?=base_url()?>reports/appraisal">Appraisal</a></li>
			</ul>
			<?php } ?>

			<div class="nav-header" data-toggle="collapse" data-target="#settings-menu">
				<i class="icon-wrench"></i>Settings
			</div>
			<ul id="settings-menu" class="nav nav-list collapse in">
				<li><a href="<?=base_url()?>acct_setting/<?=$this->session->userdata( 'user_id' )?>">Account</a></li>
			</ul>
		</div>
	</div>