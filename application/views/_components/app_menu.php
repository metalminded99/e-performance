<ul class="nav nav-pills">
    <li <?=$active == 'self' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>feedbacks">Self Feedback</a>
    </li>
    <li <?=$active == 'peer' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>feedbacks/peer">Peer Feedback</a>
    </li>
    <?php if( $this->session->userdata('lvl') == 2 ) { ?>
    <li <?=$active == 'mngr' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>feedbacks/mngr">Managers Feedback</a>
    </li>
    <? } ?>
</ul>