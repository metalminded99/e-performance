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

                if( $this->session->userdata( 'lvl' ) == 2 ) {
            ?>
            <div class="btn-toolbar">
                <div id="action" class="btn-group" style="display:none;">
                    <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="do_action( 'Not Started' );">Approve</a></li>
                        <li><a href="#" onclick="do_action( 'Completed' );">Completed</a></li>
                        <li class="divider"></li>
                        <li><a href="#" onclick="do_action( 'Rejected' );">Rejected</a></li>
                    </ul>
                </div>
                <div class="btn-group"></div>
            </div>
            <? } ?>
            <div class="row-fluid">
                <div class="block span12">
                    <div class="block-heading" data-target="#widget1container">
                        Journals
                    </div>
                    <div id="widget1container" class="block-body">
                        <table id="tbl_journals" class="table">
                            <thead>
                                <?php if( isset( $counter ) ){ ?>
                                <th>#</th>
                                <?php } else { ?>
                                <th><input type="checkbox" id="select_all"></th>
                                <?php } ?>
                                <th>Journal Title</th>
                                <th>Description</th>
                                <th>Date Created</th>
                                <?php if( $this->session->userdata( 'lvl' ) == 3 ) { ?>
                                <th></th>
                                <? } ?>
                            </thead>
                            <tbody>
                                <?php
                                    if( count( $journals ) > 0 ){
                                        $cnt = isset( $counter ) ? $counter : 0;
                                        foreach ( $journals as $journal ) {
                                            $cnt++;
                                ?>
                                <tr>
                                    <?php if( isset( $counter ) ){ ?>
                                    <td><?=$cnt?></td>
                                    <?php } else { ?>
                                    <td><input type="checkbox" name="journal[]" value="<?=$journal['journal_id']?>"></td>
                                    <?php } ?>
                                    <td><?=$this->template_library->shorten_words( $journal['journal_title'] )?></td>
                                    <td><?=$this->template_library->shorten_words( $journal['journal_desc'] )?></td>
                                    <td><?=$this->template_library->format_mysql_date( $journal['date_created'], 'F d, Y' )?></td>

                                    <?php if( $this->session->userdata( 'lvl' ) == 3 ) { ?>
                                    <td>
                                        <a title="update" class="up_btn" href="<?=$update_url?>/<?=$journal['journal_id']?>" role="button"><i class="icon-edit"></i></a>
                                        <a id="<?=$journal['journal_id']?>" title="Remove" class="del_btn" href="#deleteModal" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
                                    </td>
                                    <? } ?>

                                    <?php if( $this->session->userdata( 'lvl' ) == 2 ) { ?>
                                    <td>
                                        <a id="<?=$journal['journal_id']?>" title="View details" class="view_btn" href="#detailModal" role="button" data-toggle="modal"><i class="icon-file"></i></a>
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
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete this journal?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="btn btn-danger" data-dismiss="modal" onclick="delete_journal();">Delete</button>
                    </div>
                </div>

                <div class="modal hide fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Journal Details</h3>
                    </div>
                    <div class="modal-body">
                         <div class="element">
                            <label class="label label-info">Title</label>
                            <p id="journal_title"></p>
                            <div class="clearfix"></div>
                        </div>
                        <div class="element">
                            <label class="label label-info">Content</label>
                            <p id="journal_desc"></p>
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
            var json_journals = <?=json_encode( $journals )?>;

            $( document ).ready( function() {
                init();
            });

            function init(){
                $('#job_attr tr td input[type=checkbox]').each( function() {
                    $(this).prop('checked', false);
                });
            }

            $('.view_btn').click( function() {
                journal_id = $(this).prop('id');

                $.each( json_journals, function( i, l ) {
                    if( journal_id === json_journals[ i ].journal_id  ){
                        $('#journal_title').text( json_journals[ i ].journal_title );
                        $('#journal_desc').text( json_journals[ i ].journal_desc );
                        return true;
                    }
                });

                return true;
            });

            $('.del_btn').click( function() {
                item_id = $(this).prop('id');
            });

            <?php if( isset( $delete_url ) ) { ?>
            function delete_journal(){
                $.post( '<?=$delete_url?>', { journal_id : item_id }, function(data) {
                    window.location = data;
                });
            }
            <? } ?>

            $('#select_all').click( function() {
                var all = $(this).prop('checked');
                toggle_checkbox( $('#tbl_journals tr td input[type=checkbox]'), all );
                if( all ){
                    $('#action').show();
                }else{
                    $('#action').hide();
                }
            });

            $('#tbl_journals tr td input[type=checkbox]').click( function() {
                if( $(this).prop( 'checked' ) ){
                    $('#action').show();
                }else{
                    $('#action').hide();
                }
            });

            <?php if( isset( $user_id ) ){ ?>
            function do_action( action ){
                var arr = [];
                $( '#tbl_journals tr td input[type=checkbox]' ).each( function() {
                    if( $(this).prop( 'checked' ) ) {
                        arr.push( $(this).val() );
                    }
                });
                
                $.post( '<?=base_url()?>/employees/info/journals/update', { item : arr, state : action, user : '<?=$user_id?>' }, function(data) {
                    window.location = data;
                    // console.log( data );
                });
            }
            <? } ?>
        </script>