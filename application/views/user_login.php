    <div class="container-fluid">
        
        <div class="row-fluid">
    <div class="dialog span4">
        <div class="block">
            <div class="block-heading">Sign In</div>
            <div class="block-body">
                <?php if( $this->session->flashdata( 'message' ) ): ?>
                <div class="alert alert-error">
                    <?=$this->session->flashdata( 'message' )?>
                </div>
                <?php endif; ?>
                <form id="frmUserLogin" action="" method="POST">
                    <label>Username</label>
                    <input type="text" name="user_name" class="span12" autocomplete="off">
                    <label>Password</label>
                    <input type="password" name="user_password" class="span12" autocomplete="off">
                    <button type="submit" class="btn btn-primary pull-right">Sign In</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        
        <p><a href="<?=base_url()?>">Forgot your password?</a></p>
    </div>
</div>
