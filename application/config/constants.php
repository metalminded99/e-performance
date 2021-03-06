<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|------------------------------------------------------------------------------
| Database tables
|------------------------------------------------------------------------------
*/

define('USER'			, 'tbl_users');
define('DEPT'			, 'tbl_department');
define('JOBS'			, 'tbl_jobs');
define('NEWS'			, 'tbl_news');
define('HISTORY'		, 'tbl_history');

define('SKILLS'			, 'tbl_skills');
define('ABILITIES'		, 'tbl_abilities');
define('DUTIES'			, 'tbl_duties');
define('ACTIVITIES'		, 'tbl_activities');
define('TRAININGS'		, 'tbl_trainings');
define('TRAINING_SKILLS', 'tbl_training_skills');
define('TRAINING_ABL'	, 'tbl_training_abilities');

define('EMP_GOALS'		, 'tbl_emp_goals');
define('DEPT_GOALS'		, 'tbl_dept_goals');

define('JOB_SKILLS'		, 'tbl_job_skills');
define('JOB_DUTIES'		, 'tbl_job_duties');
define('JOB_ACTIVITIES'	, 'tbl_job_activities');
define('JOB_ABILITIES'	, 'tbl_job_abilities');

define('JOURNALS'		, 'tbl_emp_journals');
define('DEV_PLAN'		, 'tbl_emp_development');

/*
|------------------------------------------------------------------------------
| Path
|------------------------------------------------------------------------------
*/

define('CSS'		, 'css/');
define('JS'			, 'js/');
define('IMG'		, 'img/');
define('COMPONENTS'	, '_components/');
define('UPLOADS'	, 'uploads/');

/*
|------------------------------------------------------------------------------
| Values
|------------------------------------------------------------------------------
*/

define('PER_PAGE', 5);

/*
|------------------------------------------------------------------------------
| Uploads
|------------------------------------------------------------------------------
*/
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

/*
|------------------------------------------------------------------------------
| User Templates
|------------------------------------------------------------------------------
*/
define('TOP'	, 'user_top');
define('HEADER'	, 'user_header');
define('FOOTER'	, 'user_footer');

/* End of file constants.php */
/* Location: ./application/config/constants.php */