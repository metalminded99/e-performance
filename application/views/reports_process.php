<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
    $( document ).ready( function(){
        $( "#frm_report_dept_proc" ).validationEngine();

        $( '#start_date1' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                        }
                                    );

        $( '#start_date2' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                            ,minDate: $( '#start_date1' ).val()
                                        }
                                    );

        $( '#end_date1' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                        }
                                    );

        $( '#end_date2' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                            ,minDate: $( '#end_date1' ).val()
                                        }
                                    );

        $( '#date_accomplised1' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                        }
                                    );

        $( '#date_accomplised2' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                            ,minDate: $( '#date_accomplised1' ).val()
                                        }
                                    );
    });

    $( '#start_date1' ).change( function(){
        $( '#start_date2' ).val('');
    } );

    $( '#end_date1' ).change( function(){
        $( '#end_date2' ).val('');
    } );

    $( '#date_accomplised1' ).change( function(){
        $( '#date_accomplised2' ).val('');
    } );
</script>
<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <?php 
                echo $emp_menu;
                if( $this->session->flashdata( 'message' ) ): 
                    $msg = $this->session->flashdata( 'message' );
                endif;
            ?>            
            <div class="row-fluid">           
                <div class="block span12">
                    <div class="block-heading" data-target="#widget1container">
                        Process Report
                    </div>
                    <div id="widget1container" class="block-body">
                        <form id="frm_report_dept_proc" action="" method="GET">
                            <div class="element">
                                <label for="start_date1">Start Date <span class="red">(required)</span></label>
                                <input id="start_date1" name="start_date1" class="text validate[required] datepicker" value="<?=isset( $_GET['start_date1'] ) ? $_GET['start_date1'] : '' ?>"/>
                                To
                                <input id="start_date2" name="start_date2" class="text validate[required] datepicker" value="<?=isset( $_GET['start_date2'] ) ? $_GET['start_date2'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="end_date1">End Date <span class="red">(required)</span></label>
                                <input id="end_date1" name="end_date1" class="text validate[required] datepicker" value="<?=isset( $_GET['end_date1'] ) ? $_GET['end_date1'] : '' ?>"/>
                                To
                                <input id="end_date2" name="end_date2" class="text validate[required] datepicker" value="<?=isset( $_GET['end_date2'] ) ? $_GET['end_date2'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="proc_title">Title (Optional)</label>
                                <input id="proc_title" name="proc_title" class="span9 text" value="<?=isset( $_GET['proc_title'] ) ? $_GET['proc_title'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="lname">Employee Last Name (Optional)</label>
                                <input id="lname" name="lname" class="span9 text" value="<?=isset( $_GET['lname'] ) ? $_GET['lname'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="fname">Employee First Name (Optional)</label>
                                <input id="fname" name="fname" class="span9 text" value="<?=isset( $_GET['fname'] ) ? $_GET['fname'] : '' ?>"/>
                            </div>                            
                            <div class="element">
                                <label for="date_accomplised1">Date Accomplished (Optional)</label>
                                <input id="date_accomplised1" name="date_accomplised1" class="text" value="<?=isset( $_GET['date_accomplised1'] ) ? $_GET['date_accomplised1'] : '' ?>"/>
                                To
                                <input id="date_accomplised2" name="date_accomplised2" class="text" value="<?=isset( $_GET['date_accomplised2'] ) ? $_GET['date_accomplised2'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="by">Order By (Optional)</label>
                                <select id="by" name="by">
                                    <option value="start_date">Start Date</option>
                                    <option value="end_date">End Date</option>
                                    <option value="due_date">Due Date</option>
                                    <option value="lname">Last Name</option>
                                    <option value="fname">First Name</option>
                                    <option value="date_accomplised">Date ACcomplished</option>
                                </select>
                                <select id="order" name="order">
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" onclick="">Generate</button>
                            </div>

                            <div class="clearfix"></div>
                        </form>

                        <?php if( isset($emp_process) ) { ?>
                        <table id="tbl_procs" class="table table-bordered" style="font-size: 12px;">
                            <thead>
                                <th>Employee</th>
                                <th>Goal Title</th>
                                <th>Description</th>
                                <th>Date Start</th>
                                <th>Date End</th>
                                <th>Date Accomplished</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                <?php 
                                    if( !empty( $emp_process ) ){
                                        foreach ($emp_process as $proc) {
                                ?>
                                <tr>
                                    <td><?=$proc['full_name']?></td>
                                    <td><?=$proc['proc_title']?></td>
                                    <td><?=$proc['proc_desc']?></td>
                                    <td><?=$proc['start_date']?></td>
                                    <td><?=$proc['end_date']?></td>
                                    <td><?=!is_null($proc['date_accomplished']) ? $proc['date_accomplished'] : '-------' ?></td>
                                    <td><?=!is_null($proc['date_accomplished']) ? 'Done' : 'Pending' ?></td>
                                </tr>
                                <?php 
                                        }
                                    }else{
                                ?>
                                <tr>
                                    <td colspan="7">No records found.</td>
                                </tr>
                                <? } ?>
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>