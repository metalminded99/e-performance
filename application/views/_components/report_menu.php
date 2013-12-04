<ul class="nav nav-pills">
    <li <?=$active == 'egoals' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>reports/emp_goals">Employee Goals</a>
    </li>
    <li <?=$active == 'plan' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>reports/dev_plans">Development Plans</a>
    </li>
    <li <?=$active == 'proc' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>reports/process">Process</a>
    </li>
    <li <?=$active == 'appraisal' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>reports/appraisal">Appraisal</a>
    </li>
    <li <?=$active == 'potential' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>reports/potential">Potential Promotions</a>
    </li>
</ul>