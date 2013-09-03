<ul class="nav nav-pills">
    <li <?=$active == 'dgoals' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>reports/dept_goals">Department Goals</a>
    </li>
    <li <?=$active == 'egoals' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>reports/emp_goals">Employee Goals</a>
    </li>
    <li <?=$active == 'plan' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>reports/dev_plans">Development Plans</a>
    </li>
    <li <?=$active == 'proc' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>reports/process">Process</a>
    </li>
</ul>