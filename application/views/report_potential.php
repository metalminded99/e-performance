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
                                <label for="date_submit1">Date Created <span class="red">(required)</span></label>
                                <input id="date_submit1" name="date_submit1" class="text validate[required] datepicker" value="<?=isset( $_GET['date_submit1'] ) ? $_GET['date_submit1'] : '' ?>"/>
                                To
                                <input id="date_submit2" name="date_submit2" class="text validate[required] datepicker" value="<?=isset( $_GET['date_submit2'] ) ? $_GET['date_submit2'] : '' ?>"/>
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
                                <label for="by">Order By (Optional)</label>
                                <select id="by" name="by">
                                    <option value="date_submit">Date Submit</option>
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
                            if( isset($potentials) ) { 
                                if( !empty( $potentials ) ){
                        ?>
                        <div class="pull-right" style="margin-bottom:5px;">
                            <a href="javascript:PrintElem('reports-container', 'Process Report');" class="btn btn-small btn-info"><i class="icon-print"></i> Print</a>
                        </div>
                        <?php 
                                }
                        ?>
                        <div id="reports-container">
                            <h2>Potential Promotions Report</h2>

                            <h5>Potential Promotions AS OF: <u><?=$this->template_library->format_mysql_date( $this->input->get('date_submit1'), 'M d, Y' )?> - <?=$this->template_library->format_mysql_date( $this->input->get('date_submit2'), 'M d, Y' )?></u></h5>
                            <table id="tbl_goals" class="table table-bordered" style="font-size: 12px;">
                                <thead>
                                    <th width="35%">Employee</th>
                                    <th width="30%">Job Title</th>
                                    <th width="20%">Percentage</th>
                                    <th width="15%">Date Submitted</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        if( !empty( $potentials ) ){
                                            foreach ($potentials as $potential) {
                                    ?>
                                    <tr>
                                        <td><?=$potential['full_name']?></td>
                                        <td><?=$potential['job_title']?></td>
                                        <td><?=number_format($potential['ave'], 2)?>%</td>
                                        <td><?=$potential['date_submit']?></td>
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