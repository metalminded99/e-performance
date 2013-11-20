<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
    $( document ).ready( function(){
        $( "#frm_report_dept_goal" ).validationEngine();

        $( '#date_start1' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                        }
                                    );

        $( '#date_start2' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                        }
                                    );

        $( '#date_end1' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                            ,minDate: $( '#date_start' ).val()
                                        }
                                    );

        $( '#date_end2' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                            ,minDate: $( '#date_start' ).val()
                                        }
                                    );
    });

    $( '#date_start' ).change( function(){
        $( '#date_end' ).val('');
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
                        Development Plans Report
                    </div>
                    <div id="widget1container" class="block-body">
                        <form id="frm_report_dept_goal" action="" method="GET">
                            <div class="element">
                                <label for="date_start1">Date Start <span class="red">(required)</span></label>
                                <input id="date_start1" name="date_start1" class="text validate[required] datepicker" value="<?=isset( $_GET['date_start1'] ) ? $_GET['date_start1'] : '' ?>"/>
                                To
                                <input id="date_start2" name="date_start2" class="text validate[required] datepicker" value="<?=isset( $_GET['date_start2'] ) ? $_GET['date_start2'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="date_end1">Date End <span class="red">(required)</span></label>
                                <input id="date_end1" name="date_end1" class="text validate[required] datepicker" value="<?=isset( $_GET['date_end1'] ) ? $_GET['date_end1'] : '' ?>"/>
                                To
                                <input id="date_end2" name="date_end2" class="text validate[required] datepicker" value="<?=isset( $_GET['date_end2'] ) ? $_GET['date_end2'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="training_title">Title (Optional)</label>
                                <input id="training_title" name="training_title" class="span9 text" value="<?=isset( $_GET['training_title'] ) ? $_GET['training_title'] : '' ?>"/>
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
                                <label for="status">Status (Optional)</label>
                                <select id="status" name="status">
                                    <option value="All">All</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="element">
                                <label for="by">Order By (Optional)</label>
                                <select id="by" name="by">
                                    <option value="date_start">Date Start</option>
                                    <option value="date_end">Date End</option>
                                    <option value="training_title">Title</option>
                                    <option value="lname">Last Name</option>
                                    <option value="fname">First Name</option>
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
                            if( isset($emp_dev_plans) ) { 
                                if( !empty( $emp_dev_plans ) ){
                        ?>
                        <div class="pull-right" style="margin-bottom:5px;">
                            <a href="javascript:PrintElem('reports-container', 'Process Report');" class="btn btn-small btn-info"><i class="icon-print"></i> Print</a>
                        </div>
                        <?php 
                                }
                        ?>
                        <div id="reports-container">
                            <h2>Development Plans Report</h2>

                            <h5>Development Plans AS OF: <u><?=$this->template_library->format_mysql_date( $this->input->get('date_start1'), 'M d, Y' )?> - <?=$this->template_library->format_mysql_date( $this->input->get('date_end2'), 'M d, Y' )?></u></h5>
                            <table id="tbl_goals" class="table table-bordered" style="font-size: 12px;">
                                <thead>
                                    <th>Employee</th>
                                    <th>Training Title</th>
                                    <th>Description</th>
                                    <th>Date Start</th>
                                    <th>Date End</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        if( !empty( $emp_dev_plans ) ){
                                            foreach ($emp_dev_plans as $dev_plan) {
                                    ?>
                                    <tr>
                                        <td><?=$dev_plan['full_name']?></td>
                                        <td><?=$dev_plan['training_title']?></td>
                                        <td><?=$dev_plan['training_desc']?></td>
                                        <td><?=$dev_plan['start_date']?></td>
                                        <td><?=$dev_plan['end_date']?></td>
                                        <td><?=$dev_plan['status']?></td>
                                    </tr>
                                    <?php 
                                            }
                                        }else{
                                    ?>
                                    <tr>
                                        <td colspan="6">No records found.</td>
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