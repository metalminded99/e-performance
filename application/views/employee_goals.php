<?php 
    $module = $this->uri->segment(1);
    $cnt = $this->uri->segment(5)!= '' ? $this->uri->segment(5) : 0;
    if( $module == 'employees' ){
        $uri = base_url().'employees/info/goals/'.$this->uri->segment(4).'/';
        if( $this->uri->total_segments() == 5 )
            $cnt = $this->uri->segment(6) != '' ? $this->uri->segment(6) : 0;
    }
    else{
        $uri = base_url().'my_goal/';
    }
?>
<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <?php 
                if( $this->uri->segment(1) == 'my_goal' ) { 
                    $landing_page = base_url().'my_goal';
            ?>
            <ul class="nav nav-pills">
                <li <?=$this->uri->segment(1) == 'my_goal' ? 'class="active"' : '' ?>>
                    <a href="<?=base_url()?>my_goal">My Goals</a>
                </li>
                <li <?=$this->uri->segment(1) == 'dept_goal' ? 'class="active"' : '' ?>>
                    <a href="<?=base_url()?>dept_goals">Department Goals</a>
                </li>
            </ul>
            <?php } if( isset( $heading ) ) { ?>
            <h2 class="page-title"><?=$heading?>: <?=$this->uri->segment(2) != '' ? str_replace( '_', ' ', ucwords( $this->uri->segment(2) ) ) : 'Pending'?></h2>
            <?php
                }

                echo isset( $emp_menu ) ? $emp_menu : '' ;
                if( $this->session->flashdata( 'message' ) ): 
                    $msg = $this->session->flashdata( 'message' );
            ?>
                <div class="alert alert-<?=$msg['class']?>">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=$msg['str']?>
                </div>
            <?php 
                endif;
            ?>
            <div class="row-fluid">
                <div class="block span12">
                    <div id="widget1container" class="block-body">
                        <div class="">
                            <ul class="nav nav-tabs">
                                <li class="<?=$this->uri->segment(2) == '' || $this->uri->segment(5) == '' ? 'active' : ''?>">
                                    <a href="<?=$uri?>"><i class="icon-time"></i>&nbsp;Pending <span class="badge badge-info"><?=$p_cnt?></span></a>
                                </li>

                                <li class="<?=$this->uri->segment(2) == 'on_going' || $this->uri->segment(5) == 'on_going' ? 'active' : ''?>">
                                    <a href="<?=$uri?>on_going"><i class="icon-road"></i>&nbsp;On-going <span class="badge badge-info"><?=$og_cnt?></span></a>
                                </li>

                                <li class="<?=$this->uri->segment(2) == 'completed' || $this->uri->segment(5) == 'completed' ? 'active' : ''?>">
                                    <a href="<?=$uri?>completed"><i class="icon-check"></i>&nbsp;Completed <span class="badge badge-success"><?=$co_cnt?></span></a>
                                </li>

                                <li class="<?=$this->uri->segment(2) == 'warning' || $this->uri->segment(5) == 'warning' ? 'active' : ''?>">
                                    <a href="<?=$uri?>warning"><i class="icon-bullhorn"></i>&nbsp;Warning <span class="badge badge-warning"><?=$w_cnt?></span></a>
                                </li>

                                <li class="<?=$this->uri->segment(2) == 'at_risk' || $this->uri->segment(5) == 'at_risk' ? 'active' : ''?>">
                                    <a href="<?=$uri?>at_risk"><i class="icon-fire"></i>&nbsp;At Risk <span class="badge badge-important"><?=$ar_cnt?></span></a>
                                </li>

                                <li class="<?=$this->uri->segment(2) == 'rejected' || $this->uri->segment(5) == 'rejected' ? 'active' : ''?>">
                                    <a href="<?=$uri?>rejected"><i class="icon-thumbs-down"></i>&nbsp;Rejected <span class="badge badge-important"><?=$r_cnt?></span></a>
                                </li>
                            </ul>
                        </div>
                        <?php if( $this->session->userdata('lvl') == 3 ) { ?>
                        <div class="pull-right">
                            <a href="<?=base_url()?>my_goal/add" class="btn btn-small btn-primary"><i class="icon-plus"></i>&nbsp;Add Goal</a>
                        </div>
                        <?php } ?>
                        <table id="tbl_goals" class="table">
                            <thead>
                                <th>#</th>
                                <th>Goal Title</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Date Created</th>
                                <th>Status</th>
                                <th>Options</th>
                            </thead>
                            <tbody>
                                <?php
                                    if( count( $goals ) > 0 ){
                                        foreach ( $goals as $goal ) {
                                            $cnt++;
                                ?>
                                <tr>
                                    <td><?=$cnt?></td>
                                    <td><?=$this->template_library->shorten_words( $goal['goal_title'] )?></td>
                                    <td><?=$this->template_library->shorten_words( $goal['goal_desc'] )?></td>
                                    <td><?=$goal['due_date']?></td>
                                    <td><?=$goal['date_created']?></td>
                                    <td>
                                        <?php 
                                            if( $goal['status'] == 'Rejected' ){
                                                echo $goal['status'];
                                            }
                                            elseif( $goal['approved'] == 1 ) {
                                                echo $goal['status'];
                                            } 
                                            else {
                                                echo 'For Approval';
                                            }
                                        ?>
                                    </td>

                                    <?php if( $this->session->userdata( 'lvl' ) == 3 ) { ?>
                                    <td>
                                        <?php if( $goal['status'] == 'Pending' ){ ?>
                                        <a title="update" class="up_btn optlnk" href="<?=base_url()?>my_goal/update/<?=$goal['goal_id']?>" role="button"><i class="icon-edit"></i></a>&nbsp;
                                        <?php } ?>

                                        <a id="<?=$goal['goal_id']?>" title="More details" class="view_btn optlnk" href="#detailModal" role="button" data-toggle="modal"><i class="icon-zoom-in"></i></a>&nbsp;
                                        
                                        <?php if( $goal['status'] == 'Pending' && $goal['approved'] == 1 ){ ?>
                                        <a onclick="javascript:do_action(<?=$goal['goal_id']?>, 'start')" title="Start" class="optlnk" href="javascript:void(0);" role="button"><i class="icon-play"></i></a>&nbsp;
                                        
                                        <?php } elseif( $goal['status'] == 'On-going' ) { ?>
                                        <a onclick="javascript:do_action(<?=$goal['goal_id']?>, 'complete')" title="Completed" class="optlnk" href="javascript:void(0);" role="button"><i class="icon-ok"></i></a>&nbsp;
                                        <?php } elseif( $goal['status'] != 'Completed' ) { ?>
                                        <a id="<?=$goal['goal_id']?>" title="Remove" class="del_btn optlnk" href="#deleteModal" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
                                        <?php } ?>
                                    </td>
                                    <? } ?>

                                    <?php if( $this->session->userdata( 'lvl' ) == 2 ) { ?>
                                    <td>
                                        <?php if( $goal['status'] == 'Rejected' ) { ?>
                                        <a id="<?=$goal['goal_id']?>" title="View details" class="comment_btn optlnk" href="#commentModal" role="button" data-toggle="modal"><i class="icon-zoom-in"></i></a>&nbsp;
                                        <?php }else{ ?>
                                        <a id="<?=$goal['goal_id']?>" title="View details" class="view_btn optlnk" href="#detailModal" role="button" data-toggle="modal"><i class="icon-zoom-in"></i></a>&nbsp;
                                        <?php }if( !$goal['approved'] && $goal['status'] == 'Pending' ) { ?>
                                        <a onclick="javascript:do_action(<?=$goal['goal_id']?>, 'approve')" title="Approve" class="optlnk" href="javascript:void(0);" role="button"><i class="icon-thumbs-up"></i></a>&nbsp;
                                        <a onclick="$('#reject_modal').validationEngine();" title="Reject" class="optlnk" href="#rejectModal" role="button" data-toggle="modal"><i class="icon-thumbs-down"></i></a>&nbsp;
                                        <?php } ?>
                                    </td>
                                    <? } ?>

                                </tr>
                                <?php
                                        }
                                    } else {
                                ?>
                                <tr>
                                    <td colspan="7">
                                        <center>
                                            <span class="label">No records found</label>
                                        </center>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <div class="pagination">
                    <ul>
                        <?=$pagination?>
                    </ul>
                </div>

                <div class="modal small hide fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Delete Confirmation</h3>
                    </div>
                    <div class="modal-body">
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete this goal?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="btn btn-danger" data-dismiss="modal" onclick="delete_goal();">Delete</button>
                    </div>
                </div>

                <div class="modal small hide fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <form id="reject_modal" onsubmit="return false;">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Reject Confirmation</h3>
                        </div>
                        <div class="modal-body">
                            <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Please enter comment to reject goal.</p>
                            <br/6>
                            <textarea id="reject_comment" name="reject_comment" class="validate[required]" style="resize:none;width: 100%;"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                            <button class="btn btn-danger" onclick="javascript:do_action(<?=$goal['goal_id']?>, 'reject', $('#reject_comment').val())">Reject</button>
                        </div>
                    </form>
                </div>

                <div class="modal small hide fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-top: -250px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Goal Details</h3>
                    </div>
                    <div id="details">
                        <div class="modal-body">
                             <div class="element">
                                <label for="days_to_remind">Days to Remind</label>
                                <p class="label label-info" id="days_to_remind"></p>
                            </div>
                            <div class="element">
                                <label for="deliverables">Deliverables</label>
                                <p class="label label-info" id="deliverables"></p>
                            </div>
                            <div class="element">
                                <label for="success_measure">Measure of success</label>
                                <p class="label label-info" id="success_measure"></p>
                            </div>
                            <div class="element">
                                <label for="status">Status</label>
                                <p class="label label-info" id="status"></p>
                            </div>
                            <div class="element">
                                <label for="percentage">Percentage</label>
                                <p class="label label-info" id="percentage"></p>
                            </div>
                            <div class="element">
                                <label for="dg_title">Department goal link</label>
                                <p class="label label-info" id="dg_title"></p>
                            </div>
                            <div class="element">
                                <label for="date_approved">Date Approved</label>
                                <p class="label label-info" id="date_approved"></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Back</button>
                    </div>
                </div>

                <div class="modal small hide fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-top: -250px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Goal Details</h3>
                    </div>
                    <div id="comments">
                        <div class="modal-body">
                            <h3>Notes</h3>
                            <blockquote>
                                <p id="comment"></p>
                                <small id="date_commented"></small>
                            </blockquote>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Back</button>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            var item_id;
            var json_goals = <?=json_encode( $goals )?>;

            $( document ).ready( function() {
                $('.optlnk').tooltip();
                $( "#reject_modal" ).validationEngine();
            });

            $('.view_btn').click( function() {
                goal_id = $(this).prop('id');

                $.each( json_goals, function( i, l ) {
                    if( goal_id === json_goals[ i ].goal_id  ){
                        $.each( l, function( key, val ) {
                            if( $( '#'+key ).length ){
                                var rval = val;

                                if( key == 'percentage' )
                                    rval = val + '%';

                                if( val == null )
                                    rval = 'N/A';

                                $( '#'+key ).text( rval );
                            }
                        });
                    }
                });
            });

            $('.comment_btn').click( function() {
                goal_id = $(this).prop('id');

                $.post( '<?=base_url()?>my_goal/check_status', { action : 'check_status', goal_id : goal_id }, function(data) {
                    $.each( data, function( key, val ) {
                        if( $( '#'+key ).length ){
                            $( '#'+key ).text( val );
                        }
                    });
                }, 'json');
            });

            $('.del_btn').click( function() {
                item_id = $(this).prop('id');
            });

            <?php if( $this->uri->segment(1) == 'my_goal' ) { ?>
            function delete_goal(){
                $.post( '<?=base_url()?>my_goal/delete', { goal_id : item_id }, function(data) {
                    window.location = data;
                });
            }
            <?php } ?>

            function do_action( goal, action, comment ){
                if( action == 'reject' ){
                    if( comment == '' )
                        return false;

                    $('#reject_comment').val('');
                    $('#rejectModal').modal('hide');
                }
                $.post( '<?=base_url()?>/my_goal/ajax_request', { state : action, goal : goal, comment : comment }, function(data) {
                    window.location = '<?=isset($landing_page) ? $landing_page : base_url().uri_string() ?>';
                });
            }
        </script>