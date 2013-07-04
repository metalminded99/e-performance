<div class="container-fluid">
    <div class="row-fluid">        
        <div class="span4 offset4 dialog">
            <div class="block">
                    <div class="block-heading" data-target="#widget4container">
                        <?=$action?> Skill for <?=$this->session->userdata('job_title')?>
                    </div>
                    <div id="widget4container" class="block-body">
                        <form action="" method="POST">
                            <label class="label label-info">Skill Code</label>
                            <input type="text" name="skill_code" id="skill_code" class="span12" maxlength="5" value="<?=isset( $skill_data[0]['skill_code'] ) ? $skill_data[0]['skill_code'] : ''?>">
                            <label class="label label-info">Skill Name</label>
                            <input type="text" name="skill_name" id="skill_name" class="span12" value="<?=isset( $skill_data[0]['skill_name'] ) ? $skill_data[0]['skill_name'] : ''?>">
                            <label class="label label-info">Skill Description</label>
                            <textarea name="skill_desc" id="skill_desc" class="span12" row="6" style="resize:none;"> <?=isset( $skill_data[0]['skill_desc'] ) ? $skill_data[0]['skill_desc'] : ''?></textarea>
                            <?=form_radio('active','1', isset( $skill_data[0]['active'] ) && $skill_data[0]['active'] == '1' ? TRUE : FALSE )?>
                            <label class="label label-info">Active</label>
                            <?=form_radio( 'active','0', isset( $skill_data[0]['active'] ) && $skill_data[0]['active'] == '0' ? TRUE : FALSE ) ?>
                            <label class="label label-info">Inactive</label>
                            <div class="clearfix"></div>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="#myModal" class="btn btn-danger" role="button" data-toggle="modal">Cancel</a>
                            <div class="clearfix"></div>
                        </form>                        
                    </div>
                </div>
            </div>

            <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Cancel Confirmation</h3>
                </div>
                <div class="modal-body">
                    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to leave?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true" onclick="window.location='<?=base_url()?>skills'">Yes</button>
                    <button class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>