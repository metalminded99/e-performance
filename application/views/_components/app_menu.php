<ul class="nav nav-pills">
    <li <?=$active == 'self' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>feedbacks/self">Self Feedback</a>
    </li>
    <li <?=$active == 'peer' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>feedbacks/peer">Peer Feedback</a>
    </li>
    <li <?=$active == 'mngr' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>feedbacks/mngr">Managers Feedback</a>
    </li>
</ul>