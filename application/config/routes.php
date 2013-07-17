<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['admin/login'] = "admin/admin";
$route['control_panel/dashboard'] = "admin/admin/home";

# Admin manage users
$route['control_panel/manage_user'] = "admin/manage_user";
$route['control_panel/manage_user/(:num)'] = "admin/manage_user/index/$1";
$route['control_panel/manage_user/(:any)'] = "admin/manage_user/$1";

# Admin manage department
$route['control_panel/manage_department'] = "admin/manage_department";
$route['control_panel/manage_department/(:num)'] = "admin/manage_department/index/$1";
$route['control_panel/manage_department/(:any)'] = "admin/manage_department/$1";

# Admin manage department
$route['control_panel/manage_job'] = "admin/manage_job";
$route['control_panel/manage_job/(:num)'] = "admin/manage_job/index/$1";
$route['control_panel/manage_job/(:any)'] = "admin/manage_job/$1";

# Admin manage skills
$route['control_panel/manage_skills'] = "admin/manage_skills";
$route['control_panel/manage_skills/(:num)'] = "admin/manage_skills/index/$1";
$route['control_panel/manage_skills/(:any)'] = "admin/manage_skills/$1";

# Admin manage abilities
$route['control_panel/manage_abilities'] = "admin/manage_abilities";
$route['control_panel/manage_abilities/(:num)'] = "admin/manage_abilities/index/$1";
$route['control_panel/manage_abilities/(:any)'] = "admin/manage_abilities/$1";

# Admin manage duties
$route['control_panel/manage_duties'] = "admin/manage_duties";
$route['control_panel/manage_duties/(:num)'] = "admin/manage_duties/index/$1";
$route['control_panel/manage_duties/(:any)'] = "admin/manage_duties/$1";

# Admin manage activities
$route['control_panel/manage_activities'] = "admin/manage_activities";
$route['control_panel/manage_activities/(:num)'] = "admin/manage_activities/index/$1";
$route['control_panel/manage_activities/(:any)'] = "admin/manage_activities/$1";

# Admin manage trainings
$route['control_panel/manage_trainings'] = "admin/manage_trainings";
$route['control_panel/manage_trainings/(:num)'] = "admin/manage_trainings/index/$1";
$route['control_panel/manage_trainings/(:any)'] = "admin/manage_trainings/$1";

# Admin manage process
$route['control_panel/manage_process'] = "admin/manage_process";
$route['control_panel/manage_process/(:num)'] = "admin/manage_process/index/$1";
$route['control_panel/manage_process/(:any)'] = "admin/manage_process/$1";

# Admin manage contents
$route['control_panel/manage_contents/(:any)'] = "admin/manage_contents/$1";

# User routes
$route['logout'] = "login/logout";
$route['acct_setting/(:num)'] = "home/acct_setting/$1";
$route['acct_setting/change_password'] = "home/change_password";
$route['acct_setting/update_contact'] = "home/update_contact";

$route['skills/(:num)'] = "skills/index/$1";
$route['abilities/(:num)'] = "abilities/index/$1";
$route['activities/(:num)'] = "abilities/index/$1";
$route['dept_goals/(:num)'] = "dept_goals/index/$1";
$route['journals/(:num)'] = "journals/index/$1";

$route['employees/info/goals/(:num)'] = "employees/goals/$1";
$route['employees/info/goals/(:num)/(:num)'] = "employees/goals/$1/$2";
$route['employees/info/goals/update'] = "employees/goal_update";

$route['employees/info/dev_plan/(:num)'] = "employees/dev_plan/$1";
$route['employees/info/dev_plan/(:num)/(:num)'] = "employees/dev_plan/$1/$2";
$route['employees/info/dev_plan/update'] = "employees/dev_plan_update";

$route['employees/info/journals/(:num)'] = "employees/journals/$1";
$route['employees/info/journals/(:num)/(:num)'] = "employees/journals/$1/$2";
$route['employees/info/journals/update'] = "employees/journals_update";

$route['control_panel/(:any)'] = "admin/admin/$1";
$route['404_override'] = 'not_found';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
