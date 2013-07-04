	<div id="top">
		<div class="left">
		</div>
		<div class="right">
			<div class="align-right">
				<p>
					Welcome, 
					<strong>
						<?=ucfirst($this->session->userdata('fname'))?>
					</strong> 
					[ <a href="<?=base_url()?>control_panel/logout">logout</a> ]
				</p>
				<p>Last login: <strong><?=ucfirst($this->session->userdata('last_login'))?></strong></p>
			</div>
		</div>
	</div>