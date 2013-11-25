<h3>Overall Score: <?=$overall?>%</h3>
<div class="accordion" id="summary-accordion">
    <?php 
        $cnt = 0;
        foreach ($summary as $key => $val) { 
            $main = $key;
            foreach ($val as $ave) {
                $cnt++;
                $main_ave = key($val);
    ?>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#summary-accordion" href="#collapse<?=$cnt?>">
                <?=$main?> <span class="label label-info"><?=$main_ave?></span>
            </a>
        </div>
        <div id="collapse<?=$cnt?>" class="accordion-body collapse">
            <div class="accordion-inner">
                <table class="table table-hover">
                    <thead>
                        <th>Sub Category</th>
                        <th>Average</th>
                    </thead>
                    <tbody>
    <?php
                foreach ($ave as $sub_cat) {
    ?>
                        <tr>
                            <td>
                                <?=$sub_cat['sub_category_name'] ?>
                            </td>
                            <td>
                                <?=$sub_cat['ave'] ?>
                            </td>
                        </tr>
    <?php 
                } 
    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
            } 
        } 
    ?>
</div>