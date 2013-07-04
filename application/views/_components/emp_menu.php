<ul class="nav nav-pills">
    <li <?=$active == 'info' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>employees/info/<?=$user_id?>">Employee Info</a>
    </li>
    <li <?=$active == 'goals' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>employees/info/goals/<?=$user_id?>">Goals</a>
    </li>
    <li <?=$active == 'plan' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>employees/info/dev_plan/<?=$user_id?>">Development Plan</a>
    </li>
    <li <?=$active == 'feedback' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>employees/info/feedback/<?=$user_id?>">360 Feedback</a>
    </li>
    <li <?=$active == 'journal' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>employees/info/journals/<?=$user_id?>">Performance Journals</a>
    </li>
    <li <?=$active == 'perf' ? 'class="active"' : '' ?>>
        <a href="<?=base_url()?>employees/info/performance/<?=$user_id?>">Performance Details</a>
    </li>
    <li>
        <a href="<?=base_url()?>employees"><i class="icon-chevron-left"></i>Back</a>
    </li>
</ul>