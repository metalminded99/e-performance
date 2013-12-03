<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
    $( document ).ready( function(){
        $( "#frm_report_appraisal" ).validationEngine();

        $( '#date_submitted' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                        }
                                    );

        $( '#date_submitted2' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                            ,minDate: $( '#date_submitted' ).val()
                                        }
                                    );
    });

    $( '#date_submitted' ).change( function(){
        $( '#date_submitted2' ).val('');
    } );

    function PrintElem(elem, title)
    {
        Popup($('#'+elem).html(), title);
    }

    function Popup(data, title) 
    {
        var mywindow = window.open('', 'my div', 'height=500,width=800');
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
                        Appraisal Report
                    </div>
                    <div id="widget1container" class="block-body">
                        <form id="frm_report_appraisal" action="" method="GET">
                            <div class="element">
                                <label for="date_submitted">Submitted Date <span class="red">(required)</span></label>
                                <input id="date_submitted" name="date_submitted" class="text validate[required] datepicker" value="<?=isset( $_GET['date_submitted'] ) ? $_GET['date_submitted'] : '' ?>"/>
                                To
                                <input id="date_submitted2" name="date_submitted2" class="text validate[required] datepicker" value="<?=isset( $_GET['date_submitted2'] ) ? $_GET['date_submitted2'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="appraisal_title">Appraisal Title (Optional)</label>
                                <input id="appraisal_title" name="appraisal_title" class="span9 text" value="<?=isset( $_GET['appraisal_title'] ) ? $_GET['lname'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="lname">Employee Last Name (Optional)</label>
                                <input id="lname" name="lname" class="span9 text" value="<?=isset( $_GET['lname'] ) ? $_GET['lname'] : '' ?>"/>
                            </div>
                            <div class="element">
                                <label for="fname">Employee First Name (Optional)</label>
                                <input id="fname" name="fname" class="span9 text" value="<?=isset( $_GET['fname'] ) ? $_GET['fname'] : '' ?>"/>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" onclick="">Generate</button>
                            </div>

                            <div class="clearfix"></div>
                        </form>

                        <?php 
                            if( isset($appraisals) ) { 
                                if( !empty( $appraisals ) ){
                        ?>
                        <div class="pull-right" style="margin-bottom:5px;">
                            <a href="javascript:PrintElem('reports-container', 'Appraisal Report');" class="btn btn-small btn-info"><i class="icon-print"></i> Print</a>
                        </div>
                        <?php 
                                }
                        ?>
                        <div id="reports-container">
                            <h2>Appraisal Report</h2>

                            <h5>APPRAISAL AS OF: <u><?=$this->template_library->format_mysql_date( $this->input->get('date_submitted'), 'M d, Y' )?> - <?=$this->template_library->format_mysql_date( $this->input->get('date_submitted2'), 'M d, Y' )?></u></h5>
                            <table id="tbl_procs" class="table table-bordered" style="font-size: 12px;">
                                <thead>
                                    <th>Question</th>
                                    <th>Self Score</th>
                                    <th>Peer Score</th>
                                    <th>Manager Score</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        if( !empty( $appraisals ) ){
                                            foreach ($appraisals as $key => $val) {
                                                $app_info = explode('_', $key);
                                    ?>
                                    <tr>
                                        <td colspan="4">Appraisal Title: <strong><?=$app_info[1]?></strong></td>
                                    </tr>
                                    <?php 
                                                foreach ($val as $k => $v) {
                                                    $user_info = explode('_', $k);
                                    ?>
                                    <tr>
                                        <td colspan="4">Employee: <strong><?=$user_info[0]?> (Overall: <?=number_format($overall[$app_info[0]], 1)?>%)</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Job Title: <strong><?=$user_info[1]?></strong></td>
                                    </tr>
                                    <?php
                                                    foreach ($v as $cat => $sub) {
                                    ?>
                                    <tr>
                                        <td colspan="4">Main Category: <strong><?=$cat?></strong></td>
                                    </tr>
                                    <?php
                                                        foreach ($sub as $s => $questions) {
                                    ?>
                                    <tr>
                                        <td colspan="4">Sub Category: <i><?=$s?></i></td>
                                    </tr>
                                    <?php
                                                            for ($i=0; $i < count($questions); $i++) { 
                                                                foreach ($questions[$i] as $question => $score) {
                                    ?>
                                    <tr>
                                        <td><?=$question?></td>
                                        <td><?=$score['self'] > 0 ? $score['self'] : 'N/A' ?></td>
                                        <td><?=$score['peer'] > 0 ? $score['peer'] : 'N/A' ?></td>
                                        <td><?=$score['mngr'] > 0 ? $score['mngr'] : 'N/A' ?></td>
                                    </tr>
                                    <?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }else{
                                    ?>
                                    <tr>
                                        <td colspan="4">No records found.</td>
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