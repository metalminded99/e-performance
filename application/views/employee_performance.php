<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->
        
        <div class="span9">
            <?php echo isset( $emp_menu ) ? $emp_menu : '' ; ?>
            <div class="row-fluid">
                <div class="block span12">
                    <div class="block-heading" data-target="#widget1container">
                        Performance Details
                    </div>
                    <div id="widget1container" class="block-body">                        
                        <table id="tbl_performance" class="table">
                            <thead>
                                <th>#</th>
                                <th>Appraisal Title</th>
                                <th>Self Score</th>
                                <th>Peer Score</th>
                                <th>Manager Score</th>
                                <th>Date Submitted</th>
                            </thead>
                            <tbody>
                                <?php
                                    if( count( $performance ) > 0 ){
                                        $cnt = isset( $counter ) ? $counter : 0;
                                        foreach ( $performance as $perf ) {
                                            $cnt++;
                                ?>
                                <tr>
                                    <td><?=$cnt?></td>
                                    <td><?=$this->template_library->shorten_words( $perf['appraisal_title'] )?></td>
                                    <td><?=!is_null( $perf['self_score'] ) ? $perf['self_score'] : '-' ?></td>
                                    <td><?=!is_null( $perf['peer_score'] ) ? $perf['peer_score'] : '-' ?></td>
                                    <td><?=!is_null( $perf['manager_score'] ) ? $perf['manager_score'] : '-' ?></td>
                                    <td><?=$this->template_library->format_mysql_date( $perf['date_submit'], 'F d, Y' )?></td>
                                </tr>
                                <?php
                                        }
                                    } else {
                                ?>
                                <tr>
                                    <td colspan="6">
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