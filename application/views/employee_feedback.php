<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <div class="row-fluid">
                <div class="block span12">
                    <div class="block-heading" data-target="#widget1container">
                        360&deg; Feedback
                    </div>
                    <div id="widget1container" class="block-body">
                        <form id="frm_feedback" action = "" method = "POST" >
                            <div class="element">
                                <label for = "peers">Peer List <span class="red">(required)</span></label>
                                <select id="peers" name="peers">
                                    <option value="">---------- Select Peer ----------</option>
                                    <?php 
                                        if ( count( $peers ) > 0 ) {
                                            foreach ( $peers as $peer ) {
                                    ?>
                                    <option value="<?=$peer['user_id']?>"><?=$peer['fname']?> <?=$peer['lname']?></option>
                                    <?php
                                            }
                                        } 
                                    ?>
                                </select>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="block span12">
                    <div class="block-heading" data-target="#widget1container">
                        History
                    </div>
                    <div id="widget1container" class="block-body">                        
                        <table id="tbl_feedback_history" class="table">
                            <thead>
                                <th>#</th>
                                <th>Peer Name</th>
                                <th>Status</th>
                                <th>Date Assigned</th>
                            </thead>
                            <tbody>
                                <?php
                                    if( count( $feedback_history ) > 0 ){
                                        $cnt = isset( $counter ) ? $counter : 0;
                                        foreach ( $feedback_history as $feedback ) {
                                            $cnt++;
                                ?>
                                <tr>
                                    <td><?=$cnt?></td>
                                    <td><?=$feedback['full_name']?></td>
                                    <td><?=$feedback['status']?></td>
                                    <td><?=$this->template_library->format_mysql_date( $feedback['date_created'], 'F d, Y' )?></td>
                                </tr>
                                <?php
                                        }
                                    } else {
                                ?>
                                <tr>
                                    <td colspan="4">
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
            </div>
        </div>
        <script type="text/javascript">
            var item_id;
            var json_feedback_history = <?=json_encode( $feedback_history )?>;

            $( document ).ready( function() {
                init();
            });

            function init(){
                $('#job_attr tr td input[type=checkbox]').each( function() {
                    $(this).prop('checked', false);
                });
            }

            $('.view_btn').click( function() {
                feedback_id = $(this).prop('id');

                $.each( json_feedback_history, function( i, l ) {
                    if( feedback_id === json_feedback_history[ i ].feedback_id  ){
                        $('#feedback_title').text( json_feedback_history[ i ].feedback_title );
                        $('#feedback_desc').text( json_feedback_history[ i ].feedback_desc );
                        return true;
                    }
                });

                return true;
            });

            $('.del_btn').click( function() {
                item_id = $(this).prop('id');
            });

            <?php if( isset( $delete_url ) ) { ?>
            function delete_feedback(){
                $.post( '<?=$delete_url?>', { feedback_id : item_id }, function(data) {
                    window.location = data;
                });
            }
            <? } ?>

            $('#select_all').click( function() {
                var all = $(this).prop('checked');
                toggle_checkbox( $('#tbl_feedback_history tr td input[type=checkbox]'), all );
                if( all ){
                    $('#action').show();
                }else{
                    $('#action').hide();
                }
            });

            $('#tbl_feedback_history tr td input[type=checkbox]').click( function() {
                if( $(this).prop( 'checked' ) ){
                    $('#action').show();
                }else{
                    $('#action').hide();
                }
            });

            <?php if( isset( $user_id ) ){ ?>
            function do_action( action ){
                var arr = [];
                $( '#tbl_feedback_history tr td input[type=checkbox]' ).each( function() {
                    if( $(this).prop( 'checked' ) ) {
                        arr.push( $(this).val() );
                    }
                });
                
                $.post( '<?=base_url()?>/employees/info/feedback_history/update', { item : arr, state : action, user : '<?=$user_id?>' }, function(data) {
                    window.location = data;
                    // console.log( data );
                });
            }
            <? } ?>
        </script>