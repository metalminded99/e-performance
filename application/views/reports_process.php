<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
    $( document ).ready( function(){
        $( "#frm_report_dept_proc" ).validationEngine();

        $( '#date_assinged' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                        }
                                    );

        $( '#date_assinged2' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                            ,minDate: $( '#date_assinged' ).val()
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

    $( '#date_assinged' ).change( function(){
        $( '#date_assinged2' ).val('');
    } );

    $( '#date_accomplised1' ).change( function(){
        $( '#date_accomplised2' ).val('');
    } );

    function PrintElem(elem, title)
    {
        Popup($('#'+elem).html(), title);
    }

    function Popup(data, title) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=800');
        mywindow.document.write('<html><head><title>'+title+'</title>');
        mywindow.document.write('<link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>bootstrap/bootstrap.min.css"><link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>bootstrap/bootstrap-responsive.min.css"><link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>theme.css">');
        mywindow.document.write('</head><body style="background:#fff;">');
        mywindow.document.write('<div clas="span12" style="background:#688bdb;"><img src="<?=base_url().IMG?>logo.png"></div>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();

        return true;
    }
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
                                <label for="date_assinged">Assigned Date <span class="red">(required)</span></label>
                                <input id="date_assinged" name="date_assinged" class="text validate[required] datepicker" value="<?=isset( $_GET['date_assinged'] ) ? $_GET['date_assinged'] : '' ?>"/>
                                To
                                <input id="date_assinged2" name="date_assinged2" class="text validate[required] datepicker" value="<?=isset( $_GET['date_assinged2'] ) ? $_GET['date_assinged2'] : '' ?>"/>
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

                        <?php 
                            if( isset($emp_process) ) { 
                                if( !empty( $emp_process ) ){
                        ?>
                        <div class="pull-right" style="margin-bottom:5px;">
                            <a href="javascript:PrintElem('reports-container', 'Process Report');" class="btn btn-small btn-info"><i class="icon-print"></i> Print</a>
                        </div>
                        <?php 
                                }
                        ?>
                        <div id="reports-container">
                            <h2>Process Report</h2>

                            <h5>Process AS OF: <u><?=$this->template_library->format_mysql_date( $this->input->get('date_assinged'), 'M d, Y' )?> - <?=$this->template_library->format_mysql_date( $this->input->get('date_assinged2'), 'M d, Y' )?></u></h5>
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
                        </div>
                        <div class="clearfix"></div>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>