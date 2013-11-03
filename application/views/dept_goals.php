<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <?php if( $this->session->userdata('lvl') > 2 ) { ?>
                <ul class="nav nav-pills">
                    <li <?=$this->uri->segment(1) == 'my_goal' ? 'class="active"' : '' ?>>
                        <a href="<?=base_url()?>my_goal">My Goals</a>
                    </li>
                    <li <?=$this->uri->segment(1) == 'dept_goals' ? 'class="active"' : '' ?>>
                        <a href="<?=base_url()?>dept_goals">Department Goals</a>
                    </li>
                </ul>
            <?php } ?>

            <?php
                if( $this->session->flashdata( 'message' ) ): 
                    $msg = $this->session->flashdata( 'message' );
            ?>
            <div class="alert alert-<?=$msg['class']?>">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?=$msg['str']?>
            </div>
            <?php endif; ?>
            
            <?php if( isset( $heading ) ) { ?>
            <h2 class="page-title"><?=$heading?></h2>
            <?php
                }
                if( isset( $add_link_text ) ) {
            ?>
            <div class="btn-toolbar">
            <?php 
                }
                if( $this->session->userdata( 'lvl' ) == 2 ) {
            ?>
                <a href="<?=$add_link?>" class="btn btn-primary"><i class="icon-plus"></i> <?=$add_link_text?></a>
                <div class="btn-group"></div>            
            <? } ?>
            </div>
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
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    if( count( $goals ) > 0 ){
                                        $cnt = isset( $counter ) ? $counter : 0;
                                        foreach ( $goals as $goal ) {
                                            $cnt++;
                                ?>
                                <tr>
                                    <td><?=$cnt?></td>
                                    <td><?=$this->template_library->shorten_words( $goal['goal_title'] )?></td>
                                    <td><?=$this->template_library->shorten_words( $goal['goal_desc'] )?></td>
                                    <td><?=$this->template_library->format_mysql_date( $goal['due_date'], 'F d, Y' )?></td>
                                    <td><?=$this->template_library->format_mysql_date( $goal['date_created'], 'F d, Y' )?></td>
                                    <td>
                                        <?php if( $this->session->userdata( 'lvl' ) == 2 ) { ?>
                                        <a title="Update" class="up_btn optlnk" href="<?=$update_url?>/<?=$goal['goal_id']?>" role="button"><i class="icon-edit"></i></a>
                                        <a id="<?=$goal['goal_id']?>" title="Remove" class="del_btn optlnk" href="#deleteModal" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
                                        <?php } else { ?>
                                        <a id="<?=$goal['goal_id']?>" title="View Details" class="view_btn optlnk" href="#detailModal" role="button" data-toggle="modal"><i class="icon-zoom-in"></i></a>
                                        <?php } ?>
                                    </td>
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
                    console.log(l);
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

            $('#select_all').click( function() {
                var all = $(this).prop('checked');
                toggle_checkbox( $('#tbl_goals tr td input[type=checkbox]'), all );
                if( all ){
                    $('#action').show();
                }else{
                    $('#action').hide();
                }
            });

            $('#tbl_goals tr td input[type=checkbox]').click( function() {
                if( $(this).prop( 'checked' ) ){
                    $('#action').show();
                }else{
                    $('#action').hide();
                }
            });

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