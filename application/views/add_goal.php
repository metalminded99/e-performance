<script type="text/javascript" src="<?=base_url().JS?>languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=base_url().JS?>jquery-ui.js"></script>
<script type="text/javascript">
    $( document ).ready( function(){
        $( "#frm_goal" ).validationEngine();

        $( '#due_date' ).datepicker(
                                        { 
                                            dateFormat: 'yy-mm-dd'
                                            ,changeMonth: true
                                            ,changeYear: true
                                            ,minDate: 0
                                        }
                                    );
        $('.cancel').bind('click', function(e) {
            var ans = confirm( 'Are you sure you want to quit?' );
            
            if( ans ){
                window.location = "<?=base_url()?>my_goal";
            }

            return false;
        });
    });
</script>
<div class="container-fluid">
    <div class="row-fluid">

        <!-- left side nav -->
        <?=$left_side_nav?>
        <!-- left side nav END -->

        <div class="span9">
            
            <div class="row-fluid">
                <div class="block span12">
                    <div class="block-heading" data-target="#widget2container">
                        <?=$action?>
                    </div>
                    <div id="widget2container" class="block-body">
                        <div class="row-fluid">
                            <div class="block span4">
                                <div class="block-heading" data-target="#widget2container">
                                    Reminder
                                </div>
                                <div id="widget2container" class="block-body">
                                Employee Goal should follow the SMART format:
                                <dl class="dl-horizontal" style="margin-left:-140px;">
                                    <dt>S</dt>
                                    <dd><u>specific</u></dd>

                                    <dt>M</dt>
                                    <dd><u>measurable</u></dd>

                                    <dt>A</dt>
                                    <dd><u>achievable</u></dd>

                                    <dt>R</dt>
                                    <dd><u>realistic</u></dd>

                                    <dt>T</dt>
                                    <dd><u>time-bound</u></dd>
                                </dl>
                                </div>
                            </div>

                            <div class="block span8">
                                <div id="widget2container" class="block-body">
                                    <form id="frm_goal" action="" method="POST">
                                        <div class="element">                                
                                            <?php if( isset( $goals['approved'] ) && $goals['approved'] > 0 ) { ?>
                                            <label for="goal_title">Title</label>
                                            <p class="label label-info"><?=isset( $goals['goal_title'] ) ? $goals['goal_title'] : '' ?></p>
                                            <?php } else { ?>
                                            <label for="goal_title">Title <span class="red">(required)</span></label>
                                            <input id="goal_title" name="goal_title" class="span9 text validate[required]" value="<?=isset( $goals['goal_title'] ) ? $goals['goal_title'] : '' ?>"/>
                                            <?php } ?>
                                        </div>
                                        <div class="element">
                                            <?php if( isset( $goals['approved'] ) && $goals['approved'] > 0 ) { ?>
                                            <label for="goal_desc">Description</label>
                                            <p class="label label-info"><?=isset( $goals['goal_desc'] ) ? $goals['goal_desc'] : '' ?></p>
                                            <?php } else { ?>
                                            <label for="goal_desc">Description <span class="red">(required)</span></label>
                                            <textarea id="goal_desc" name="goal_desc" row="10" class="span9 text validate[required]" style="resize:none;"/><?=isset( $goals['goal_desc'] ) ? $goals['goal_desc'] : '' ?></textarea>
                                            <?php } ?>
                                        </div>
                                        <div class="element">
                                            <?php if( isset( $goals['approved'] ) && $goals['approved'] > 0 ) { ?>
                                            <label for="due_date">Due date</label>
                                            <p class="label label-info"><?=isset( $goals['due_date'] ) ? $goals['due_date'] : '' ?></p>
                                            <?php } else { ?>
                                            <label for="due_date">Due date <span class="red">(required)</span></label>
                                            <input id="due_date" name="due_date" class="span5 validate[required] datepicker" value="<?=isset( $goals['due_date'] ) ? $goals['due_date'] : '' ?>"/>
                                            <?php } ?>
                                        </div>
                                        <div class="element">
                                            <?php if( isset( $goals['approved'] ) && $goals['approved'] > 0 ) { ?>
                                            <label for="days_to_remind">Remind me in days</label>
                                            <p class="label label-info"><?=isset( $goals['days_to_remind'] ) ? $goals['days_to_remind'] : '' ?></p>
                                            <?php } else { ?>
                                            <label for="days_to_remind">Remind me in days <span class="red">(required)</span></label>
                                            <input id="days_to_remind" name="days_to_remind" class="span2 validate[required, custom[onlyNumber]] datepicker" maxlength="3" value="<?=isset( $goals['days_to_remind'] ) ? $goals['days_to_remind'] : '' ?>"/>
                                            <?php } ?>                                
                                        </div>
                                        <div class="element">
                                            <?php if( isset( $goals['approved'] ) && $goals['approved'] > 0 ) { ?>
                                            <label for="deliverables">Deliverables</label>
                                            <p class="label label-info"><?=isset( $goals['deliverables'] ) ? $goals['deliverables'] : '' ?></p>
                                            <?php } else { ?>
                                            <label for="deliverables">Deliverables <span class="red">(required)</span></label>
                                            <textarea id="deliverables" name="deliverables" row="10" class="span9 text validate[required]"  style="resize:none;"/><?=isset( $goals['deliverables'] ) ? $goals['deliverables'] : '' ?></textarea>
                                            <?php } ?>                                
                                        </div>
                                        <div class="element">
                                            <?php if( isset( $goals['approved'] ) && $goals['approved'] > 0 ) { ?>
                                            <label for="success_measure">Measure of success</label>
                                            <p class="label label-info"><?=isset( $goals['success_measure'] ) ? $goals['success_measure'] : '' ?></p>
                                            <?php } else { ?>
                                            <label for="success_measure">Measure of success <span class="red">(required)</span></label>
                                            <textarea id="success_measure" name="success_measure" row="10" class="span9 text validate[required]"  style="resize:none;"/><?=isset( $goals['success_measure'] ) ? $goals['success_measure'] : '' ?></textarea>
                                            <?php } ?>                                
                                        </div>
                                        <?php if( $this->uri->segment(1) !== 'dept_goals' ){ ?>
                                        <div class="element">
                                            <?php if( isset( $goals['approved'] ) && $goals['approved'] > 0 ) { ?>
                                            <label for="dept_goal">Department goal link</label>
                                            <p class="label label-info"><?=isset( $goals['dg_title'] ) ? $goals['dg_title'] : '' ?></p>
                                            <?php } else { ?>
                                            <label for="dept_goal">Department goal link <span class="red">(required)</span></label>
                                            <select id="dept_goal_id" name="dept_goal_id" class="span6 validate[required]">
                                                <option value="">---- Select Departmetn Goal</option>
                                                <?php
                                                    if( isset( $dept_goals ) ){
                                                        foreach ($dept_goals as $dept_goal) {
                                                ?>
                                                <option value="<?=$dept_goal['goal_id']?>" <?=$dept_goal['goal_id'] == $goals['dg_id'] ? 'selected="true"' : ''?>><?=$dept_goal['goal_title']?></option>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>

                                        <?php if( isset( $goals['status'] ) ) { ?>
                                        <div class="element">
                                            <label for="status">Status</label>
                                            <?php 
                                                switch ( true ) {
                                                    case ( $goals['percentage'] == 100 ):
                                                        $label = '-success';
                                                        break;
                                                    
                                                    case ( $goals['percentage'] < 100 && $goals['percentage'] > 80 ):
                                                        $label = '-info';
                                                        break;
                                                    
                                                    case ( $goals['percentage'] < 80 && $goals['percentage'] > 60 ):
                                                        $label = '-inverse';
                                                        break;
                                                    
                                                    case ( $goals['percentage'] < 60 && $goals['percentage'] > 20 ):
                                                        $label = '';
                                                        break;
                                                    
                                                    case ( $goals['percentage'] < 20 && $goals['percentage'] > 0 ):
                                                        $label = '-warning';
                                                        break;
                                                    
                                                    default:
                                                        $label = '-important';
                                                        break;
                                                }

                                            ?>
                                            <p class="label label<?=$label?>"><?=$goals['status']?></p>
                                        </div>
                                        <? } ?>

                                        <?php if( isset( $goals['percentage'] ) ) { ?>
                                        <div class="element">
                                            <label for="percentage">Percentage</label>
                                            <?php if( $goals['approved'] > 0 ) { ?>
                                                <select id="percentage" name="percentage" class="span2">
                                                <?php foreach (range(0, 100, 10) as $perc) { ?>
                                                <option value="<?=$perc?>" <?=$perc == $goals['percentage'] ? 'selected="selected"' : ''?>><?=$perc?>%</option>
                                                <? } ?>
                                                </select>
                                            <?php } else { ?>
                                                <p class="label label-important">0%</p>
                                            <? } ?>
                                        </div>
                                        <? } ?>

                                        <?php 
                                            if( isset( $goals['date_approved'] ) ) {
                                                if( !is_null( $goals['date_approved'] ) ) { 
                                        ?>
                                        <div class="element">
                                            <label for="date_approved">Date Approved</label>
                                            <p class="label label-success"><?=$this->template_library->format_mysql_date( $goals['date_approved'], 'F d, Y h:ia' )?></p>
                                        </div>
                                        <? } } ?>

                                        <div class="modal-footer">
                                            <button type="button" class="btn cancel">Cancel</button>
                                            <button type="submit" class="btn btn-primary" onclick="">Save</button>
                                        </div>

                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>