<style type="text/css">

    .printable { display: none; }

    @media print
    {
        .non-printable { display: none; }
        .printable { display: block; }
    }
</style>
<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
    $( document ).ready( function(){
        $( "#frm_report_dept_goal" ).validationEngine();

        $( '#from_date' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                        }
                                    );

        $( '#to_date' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                            ,minDate: $( '#from_date' ).val()
                                        }
                                    );
    });

    $( '#from_date' ).change( function(){
        $( '#to_date' ).val('');
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
                        Employee Goals Report
                    </div>
                    <div id="widget1container" class="block-body">
                        <form id="frm_report_dept_goal" action="" method="GET" class="non-printable">
                            <div class="element">
                                <label for="from_date">Due Date <span class="red">(required)</span></label>
                                <input id="from_date" name="from_date" class="text validate[required] datepicker" value="<?=isset( $_GET['from_date'] ) ? $_GET['from_date'] : '' ?>"/>
                                To
                                <input id="to_date" name="to_date" class="text validate[required] datepicker" value="<?=isset( $_GET['to_date'] ) ? $_GET['to_date'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="goal_title">Title (Optional)</label>
                                <input id="goal_title" name="goal_title" class="span9 text" value="<?=isset( $_GET['goal_title'] ) ? $_GET['goal_title'] : '' ?>"/>
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
                                    <option value="Not Started">Not Started</option>
                                    <option value="Late">Late</option>
                                    <option value="Unapproved">Unapproved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="element">
                                <label for="by">Order By (Optional)</label>
                                <select id="by" name="by">
                                    <option value="due_date">Due Date</option>
                                    <option value="lname">Last Name</option>
                                    <option value="fname">First Name</option>
                                    <option value="percentage">Percentage</option>
                                    <option value="date_approved">Date Approved</option>
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
                            if( isset($emp_goals) ) { 
                                if( !empty( $emp_goals ) ){
                        ?>
                        <div class="pull-right" style="margin-bottom:5px;">
                            <a href="javascript:PrintElem('reports-container', 'Employee Goals Report');" class="btn btn-small btn-info"><i class="icon-print"></i> Print</a>
                        </div>
                        <?php 
                                }
                        ?>
                        <div id="reports-container">
                            <h2>Goal Achievement Report</h2>

                            <h5>DEPARTMENTAL GOALS AS OF: <u><?=$this->template_library->format_mysql_date( $this->input->get('from_date'), 'M d, Y' )?> - <?=$this->template_library->format_mysql_date( $this->input->get('to_date'), 'M d, Y' )?></u></h5>
                            <table id="tbl_goals" class="table table-bordered" style="font-size: 12px;">
                                <thead>
                                    <th>Employee</th>
                                    <th>Goal Title</th>
                                    <th>Description</th>
                                    <th>Due Date</th>
                                    <th>Date Approved</th>
                                    <th>Percentage</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        if( !empty( $emp_goals ) ){
                                            foreach ($emp_goals as $goal) {
                                    ?>
                                    <tr>
                                        <td><?=$goal['full_name']?></td>
                                        <td><?=$goal['goal_title']?></td>
                                        <td><?=$goal['goal_desc']?></td>
                                        <td><?=$goal['due']?></td>
                                        <td><?=$goal['approved']?></td>
                                        <td><?=$goal['percentage']?>%</td>
                                        <td><?=$goal['status']?></td>
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