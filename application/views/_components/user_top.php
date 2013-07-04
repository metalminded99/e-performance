<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
        	<?php if( $this->session->userdata( 'user' ) ): ?>
            <ul class="nav pull-right">
                
                <li id="fat-menu" class="dropdown">
                    <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i> <?=ucwords( $this->session->userdata( 'fname' ).' '.$this->session->userdata( 'lname' ) )?>
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="<?=base_url()?>acct_setting/<?=$this->session->userdata( 'user_id' )?>">Settings</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="<?=base_url()?>logout">Logout</a></li>
                    </ul>
                </li>
                
            </ul>
        	<?php endif; ?>
            <a class="brand" href="<?=base_url()?>"><span class="first">IntelliCare</span> <span class="second">E-Performance</span></a>
        </div>
    </div>
</div>
