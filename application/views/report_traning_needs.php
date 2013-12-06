<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
    $( document ).ready( function(){
        $( "#frm_potential" ).validationEngine();

        $( '#date_submit1' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                        }
                                    );

        $( '#date_submit2' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                        }
                                    );

    });

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
                        Potential Promotions Report
                    </div>
                    <div id="widget1container" class="block-body">
                        <form id="frm_potential" action="" method="GET">
                            <div class="element">
                                <label for="date_submit1">Date Start <span class="red">(required)</span></label>
                                <input id="date_submit1" name="date_submit1" class="text validate[required] datepicker" value="<?=isset( $_GET['date_submit1'] ) ? $_GET['date_submit1'] : '' ?>"/>
                                To
                                <input id="date_submit2" name="date_submit2" class="text validate[required] datepicker" value="<?=isset( $_GET['date_submit2'] ) ? $_GET['date_submit2'] : '' ?>"/>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" onclick="">Generate</button>
                            </div>

                            <div class="clearfix"></div>
                        </form>

                        <?php 
                            if( isset($needs) ) { 
                                if( !empty( $needs ) ){
                        ?>
                        <div class="pull-right" style="margin-bottom:5px;">
                            <a href="javascript:PrintElem('reports-container', 'Process Report');" class="btn btn-small btn-info"><i class="icon-print"></i> Print</a>
                        </div>
                        <?php 
                                }
                        ?>
                        <div id="reports-container">
                            <h2>Training Needs Report</h2>

                            <h5>TRAINING NEEDS AS OF: <u><?=$this->template_library->format_mysql_date( $this->input->get('date_submit1'), 'M d, Y' )?> - <?=$this->template_library->format_mysql_date( $this->input->get('date_submit2'), 'M d, Y' )?></u></h5>

                            <p>MANAGER: <?=ucwords( $this->session->userdata('fname') ) . ' ' . ucwords( $this->session->userdata('lname') ) ?></p>
                            <p>DEPARTMENT: <?=ucwords( $this->session->userdata('dept_name') ) ?></p>
                            <p>JOB: <?=ucwords( $this->session->userdata('job_title') ) ?></p>
                            <h3>OUT OF <?=$emp_cnt?> EMPLOYEES</h3>
                            <table id="tbl_goals" class="table table-bordered" style="font-size: 12px;">
                                <thead>
                                    <th width="40%">Main Category</th>
                                    <th width="40%">Sub Category</th>
                                    <th width="20%">Overall Score</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        if( !empty( $needs ) ){
                                            foreach ($needs as $key => $val) {
                                    ?>
                                    <tr>
                                        <td colspan="3" style="background:#0C125D;color:#fff;"><strong><?=$key?></strong></td>
                                    </tr>
                                    <?php foreach ($val as $sc) { ?>
                                    <tr>
                                        <td></td>
                                        <td><?=$sc['sub_category_name']?></td>
                                        <td><?=number_format($sc['ave'], 2)?></td>
                                    </tr>    
                                    <?php 
                                                } 
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