	<div class="span3">
		<div class="sidebar-nav">
			<div class="nav-header" data-toggle="collapse" data-target="#main-menu">
				<i class="icon-home"></i>Navigation
			</div>
			<ul id="main-menu" class="nav nav-list collapse in">
				<li><a href="<?=base_url()?>">Home</a></li>

				<?php if( $this->session->userdata( 'lvl' ) == '3' ) { ?>
				<li><a href="<?=base_url()?>journals">Journals</a></li>
				<li><a href="<?=base_url()?>feedbacks">360 Feedback</a></li>
				<li><a href="<?=base_url()?>my_goal">Goals</a></li>
				<li><a href="<?=base_url()?>my_trainings">Trainings</a></li>
				<?php } ?>

				<?php if( $this->session->userdata( 'lvl' ) == '2' ) { ?>
				<li><a href="<?=base_url()?>employees">Employees</a></li>
				<li><a href="<?=base_url()?>dept_goals">Department Goal</a></li>
				<?php } ?>
			</ul>
			<div class="nav-header" data-toggle="collapse" data-target="#settings-menu">
				<i class="icon-wrench"></i>Settings
			</div>
			<ul id="settings-menu" class="nav nav-list collapse in">
				<li><a href="<?=base_url()?>acct_setting/<?=$this->session->userdata( 'user_id' )?>">Account</a></li>
			</ul>
		</div>
	</div>