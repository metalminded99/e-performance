<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <?php if( isset( $heading ) ) { ?>
            <h1 class="page-title"><?=$heading?></h1>
            <?php
                }
                if( isset( $add_link_text ) ) {
            ?>
            <div class="btn-toolbar">
                <a href="<?=$add_link?>" class="btn btn-primary"><i class="icon-plus"></i><?=$add_link_text?></a>
                <div class="btn-group"></div>
            </div>
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
                    <div class="block-heading" data-target="#widget1container">
                        Goals
                    </div>
                    <div id="widget1container" class="block-body">
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
                                        $cnt = $this->uri->segment(5) != '' ? $this->uri->segment(5) : 0;
                                        foreach ( $goals as $goal ) {
                                            $cnt++;
                                ?>
                                <tr>
                                    <td><?=$cnt?></td>
                                    <td><?=$this->template_library->shorten_words( $goal['goal_title'] )?></td>
                                    <td><?=$this->template_library->shorten_words( $goal['goal_desc'] )?></td>
                                    <td><?=$goal['due_date']?></td>
                                    <td><?=$goal['date_created']?></td>
                                    <td><?=$goal['status']?></td>

                                    <?php if( $this->session->userdata( 'lvl' ) == 3 ) { ?>
                                    <td>
                                        <a title="update" class="up_btn" href="<?=$update_url?>/<?=$goal['goal_id']?>" role="button"><i class="icon-edit"></i></a>
                                        <a id="<?=$goal['goal_id']?>" title="Remove" class="del_btn" href="#deleteModal" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
                                    </td>
                                    <? } ?>

                                    <?php if( $this->session->userdata( 'lvl' ) == 2 ) { ?>
                                    <td>
                                        <a id="<?=$goal['goal_id']?>" title="View details" class="view_btn optlnk" href="#detailModal" role="button" data-toggle="modal"><i class="icon-zoom-in"></i></a>&nbsp;
                                        <a id="<?=$goal['goal_id']?>" title="Approve" class="optlnk" href="#" role="button"><i class="icon-thumbs-up"></i></a>&nbsp;
                                        <a id="<?=$goal['goal_id']?>" title="Reject"class="optlnk" href="#" role="button"><i class="icon-thumbs-down"></i></a>&nbsp;
                                        <a id="<?=$goal['goal_id']?>" title="Completed" class="optlnk" href="#" role="button"><i class="icon-ok"></i></a>
                                    </td>
                                    <? } ?>

                                </tr>
                                <?php
                                        }
                                    } else {
                                ?>
                                <tr>
                                    <td colspan="5">
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

                <div class="modal small hide fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Goal Details</h3>
                    </div>
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
                            <label for="date_approved">Date Approved</label>
                            <p class="label label-info" id="date_approved"></p>
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
                        return true;
                    }
                });

                return true;
            });

            $('.del_btn').click( function() {
                item_id = $(this).prop('id');
            });

            <?php if( isset( $delete_url ) ) { ?>
            function delete_goal(){
                $.post( '<?=$delete_url?>', { goal_id : item_id }, function(data) {
                    window.location = data;
                });
            }
            <? } ?>

            <?php if( isset( $user_id ) ){ ?>
            function do_action( action ){
                var arr = [];
                $( '#tbl_goals tr td input[type=checkbox]' ).each( function() {
                    if( $(this).prop( 'checked' ) ) {
                        arr.push( $(this).val() );
                    }
                });
                
                $.post( '<?=base_url()?>/employees/info/goals/update', { item : arr, state : action, user : '<?=$user_id?>' }, function(data) {
                    window.location = data;
                    // console.log( data );
                });
            }
            <? } ?>
        </script>