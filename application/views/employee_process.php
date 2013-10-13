<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <h1 class="page-title">Process Lists</h1>
            <div class="">
                <ul class="nav nav-tabs">
                    <li class="<?=$this->uri->segment(2) == '' ? 'active' : ''?>">
                        <a href="<?=base_url()?>process"><i class="icon-time"></i>&nbsp;Pending</a>
                    </li>

                    <li class="<?=$this->uri->segment(2) == 'on_going' ? 'active' : ''?>">
                        <a href="<?=base_url()?>process/on_going"><i class="icon-road"></i>&nbsp;On-going</a>
                    </li>

                    <li class="<?=$this->uri->segment(2) == 'completed' ? 'active' : ''?>">
                        <a href="<?=base_url()?>process/completed"><i class="icon-check"></i>&nbsp;Completed</a>
                    </li>

                    <li class="<?=$this->uri->segment(2) == 'rejected' ? 'active' : ''?>">
                        <a href="<?=base_url()?>process/rejected"><i class="icon-minus-sign"></i>&nbsp;Rejected</a>
                    </li> 
                </ul>
            </div>
            <?php
                if( $this->session->flashdata( 'msg' ) ): 
            ?>
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Well done!</strong> <?=$this->session->flashdata( 'msg' )?>
                </div>
            <?php 
                endif;
            ?>
            <div class="row-fluid">
                <div class="block span12">                    
                    <div class="block-heading" data-target="#widget1container">
                        Process
                    </div>                    
                    <div id="widget1container" class="block-body">
                        <table id="tbl_process" class="table">
                            <thead>
                                <th>#</th>
                                <th>Process Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Date Assigned</th>
                                <th>Status</th>
                                <th>Options</th>
                            </thead>
                            <tbody>
                                <?php
                                    if( count( $process ) > 0 ){
                                        $cnt = $count;
                                        foreach ( $process as $proc ) {
                                            $cnt++;
                                ?>
                                <tr>
                                    <td><?=$cnt?></td>
                                    <td><?=$this->template_library->shorten_words( $proc['proc_title'] )?></td>
                                    <td><?=$this->template_library->format_mysql_date($proc['start_date'], 'M d, Y')?></td>
                                    <td><?=$this->template_library->format_mysql_date($proc['end_date'], 'M d, Y')?></td>
                                    <td><?=$this->template_library->format_mysql_date($proc['date_assigned'], 'M d, Y')?></td>
                                    <td><?=$proc['status']?></td>
                                    <td>
                                        <a onclick="javascript:view_details(<?=$proc['proc_id']?>)" title="More details" class="view_btn optlnk" href="#detailModal" role="button" data-toggle="modal"><i class="icon-zoom-in"></i></a>&nbsp;
                                        
                                        <?php if( $proc['status'] == 'Pending' ){ ?>
                                        <a onclick="javascript:do_action(<?=$proc['proc_id']?>, 'start')" title="Start" class="optlnk" href="#" role="button"><i class="icon-play"></i></a>&nbsp;
                                        <?php } elseif( $proc['status'] == 'On-going' ) { ?>
                                        <a onclick="javascript:do_action(<?=$proc['proc_id']?>, 'completed')" title="Completed" class="optlnk" href="#" role="button"><i class="icon-ok"></i></a>

                                        <?php } if( $proc['status'] == 'Completed' || $proc['status'] == 'Rejected' ) { ?>
                                        <a onclick="javascript:do_action(<?=$proc['proc_id']?>, 'start')" title="Restart" class="optlnk" href="#" role="button"><i class="icon-repeat"></i></a>
                                        <?php } if( $proc['status'] != 'Rejected' ) { ?>
                                        <a onclick="javascript:do_action(<?=$proc['proc_id']?>, 'reject')" title="Reject"class="optlnk" href="#" role="button"><i class="icon-exclamation-sign"></i></a>&nbsp;
                                        <?php } ?>
                                        
                                    </td>
                                </tr>
                                <?php
                                        }
                                    } else {
                                ?>
                                <tr>
                                    <td colspan="8">
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
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete this process?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="btn btn-danger" data-dismiss="modal" onclick="delete_process();">Delete</button>
                    </div>
                </div>

                <div class="modal small hide fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">More Details</h3>
                    </div>
                    <div class="modal-body">
                         <div class="element">
                            <label for="proc_desc">Descriptions:</label>
                            <p class="label label-info" id="proc_desc"></p>
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
            var json_process = <?=json_encode( $process )?>;

            $( document ).ready( function() {
                $('.optlnk').tooltip();
            });

            function view_details( proc_id ) {
                console.log(proc_id);
                $.each( json_process, function( i, l ) {
                    console.log(json_process[ i ].proc_id);
                    if( proc_id == json_process[ i ].proc_id  ){
                        $.each( l, function( key, val ) {
                            if( $( '#'+key ).length ){
                                var rval = val;

                                $( '#'+key ).text( rval );
                            }
                        });
                        return true;
                    }
                });

                return true;
            }

            function do_action( proc_id, action ) {
                $.ajax({
                    type: "POST"
                    ,url: "<?=base_url();?>process/ajax_request"
                    ,data: { proc_id : proc_id, action : action },
                    success: function( data ) {
                        window.location = '<?=base_url()?>process/<?=$uri?>'; 
                    }
                });
                return true;
            }
        </script>