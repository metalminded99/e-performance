<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <h1 class="page-title"><?=$heading?></h1>
			<div class="well">
				<?php 
					if( $this->session->flashdata( 'message' ) ): 
						$msg = $this->session->flashdata( 'message' );
				?>
                <div class="alert alert-<?=$msg['class']?>">
                	<button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=$msg['str']?>
                </div>
                <?php endif; ?>
			    <table class="table" id="job_attr">
			      <thead>
			        <tr>
						<th>#</th>
						<th>First Name</th>
						<th>Middle Name</th>
						<th>Last Name</th>
						<th>Gender</th>
						<th>Age</th>
						<th style="width: 26px;"></th>
			        </tr>
			      </thead>
			      <tbody>
			      	<?php 
			      		if( count( $employees ) > 0 ){ 
			      			$ctr = $counter;
			      			foreach ($employees as $employee) {
			      				$ctr++;
			      	?>
			        <tr>
			          	<td><?=$ctr?></td>						
						<td> <?=$employee['fname']?> </td>
						<td> <?=$employee['mname']?> </td>
						<td> <?=$employee['lname']?> </td>
						<td> <?=$employee['gender']?> </td>
						<?php
							$now_d = date( 'Y-m-d' );
						?>
						<td><?=$this->template_library->get_year_diff( $employee['birthday'], $now_d )?></td>
			          <td>
			              <a title="view" class="view_btn" role="button" href="<?=base_url()?>employees/info/<?=$employee['user_id']?>"><i class="icon-file"></i></a>
			          </td>
			        </tr>
			        <? 
			        		}
			    		} else { 
			    	?>
			        <tr>
			          <td colspan="<?=$th_cnt + 2?>"><center><span class="label label-invert" style="font-size:15px;">No records found!</span></center></td>
			        </tr>
			        <? } ?>
			      </tbody>
			    </table>
			</div>
			
			<div class="pagination">
			    <ul>
			        <?=$pagination?>
			    </ul>
			</div>
    	</div>