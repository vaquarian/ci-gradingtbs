<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['user/user_list/(:any)'] = 'user/user_list/$1';
$route['user/user_edit/(:any)'] = 'user/user_edit/$1';
$route['user'] = 'user/index';
$route['generate_password/(:any)/(:any)'] = 'access/generate_password/$1/$2';
$route['generate_password/(:any)'] = 'access/generate_password/$1';
$route['password/(:any)'] = 'access/update_password/$1';
$route['change_password'] = 'access/index';
$route['role/role_list/(:any)'] = 'role/role_list/$1';
$route['role/role_edit/(:any)'] = 'role/role_edit/$1';
$route['role'] = 'role/index';
$route['level/level_list/(:any)'] = 'level/level_list/$1';
$route['level'] = 'level/index';
$route['mill/mill_list/(:any)'] = 'mill/mill_list/$1';
$route['mill/mill_edit/(:any)'] = 'mill/mill_edit/$1';
$route['mill'] = 'mill/index';
$route['group_parent/group_parent_list/(:any)'] = 'group_parent/group_parent_list/$1';
$route['group_parent/group_parent_edit/(:any)'] = 'group_parent/group_parent_edit/$1';
$route['group_parent'] = 'group_parent/index';
$route['group/group_list/(:any)/(:any)'] = 'group/group_list/$1/$2';
$route['group/group_list/(:any)'] = 'group/group_list/$1';
$route['group/group_edit/(:any)'] = 'group/group_edit/$1';
$route['group'] = 'group/index';
$route['region/region_list/(:any)/(:any)'] = 'region/region_list/$1/$2';
$route['region/region_list/(:any)'] = 'region/region_list/$1';
$route['region/region_edit/(:any)'] = 'region/region_edit/$1';
$route['region'] = 'region/index';
$route['estate/estate_list/(:any)/(:any)'] = 'estate/estate_list/$1/$2';
$route['estate/estate_list/(:any)'] = 'estate/estate_list/$1';
$route['estate/estate_edit/(:any)'] = 'estate/estate_edit/$1';
$route['estate'] = 'estate/index';
$route['division/division_list/(:any)/(:any)'] = 'division/division_list/$1/$2';
$route['division/division_list/(:any)'] = 'division/division_list/$1';
$route['division/division_edit/(:any)'] = 'division/division_edit/$1';
$route['division'] = 'division/index';
$route['holiday/holiday_list/(:any)'] = 'holiday/holiday_list/$1';
$route['holiday/holiday_edit/(:any)'] = 'holiday/holiday_edit/$1';
$route['holiday'] = 'holiday/index';
$route['criteria/criteria_list/(:any)'] = 'criteria/criteria_list/$1';
$route['criteria/criteria_edit/(:any)'] = 'criteria/criteria_edit/$1';
$route['criteria'] = 'criteria/index';
$route['position/position_list/(:any)'] = 'position/position_list/$1';
$route['position/position_edit/(:any)'] = 'position/position_edit/$1';
$route['position'] = 'position/index';
$route['spb/spb_list/(:any)'] = 'spb/spb_list/$1';
$route['spb/barcode'] = 'spb/spb_detail';
$route['spb/spb_approval'] = 'spb/spb_approval';
$route['input_spb'] = 'spb/index';
$route['grading/grading_list/(:any)'] = 'grading/grading_list/$1';
$route['grading'] = 'grading/index';
$route['priority/priority_list/(:any)'] = 'priority/priority_list/$1';
$route['priority/export/(:any)'] = 'priority/priority_export/$1';
$route['grading_priority'] = 'priority/index';
$route['parameter'] = 'parameter/index';
$route['extreme'] = 'extreme/index';
$route['extreme_template/template_list/(:any)'] = 'extreme_template/template_list/$1';
$route['extreme_template/template_edit/(:any)'] = 'extreme_template/template_edit/$1';
$route['extreme_template'] = 'extreme_template/index';
$route['report_template/template_list/(:any)'] = 'report_template/template_list/$1';
$route['report_template/template_edit/(:any)'] = 'report_template/template_edit/$1';
$route['report_template'] = 'report_template/index';
$route['grading_report/export/(:any)'] = 'grading_report/report_export/$1';
$route['grading_report/load'] = 'grading_report/report_filter';
$route['grading_report/load_json'] = 'grading_report/report_json';
$route['grading_report/json'] = 'grading_report/index';
$route['grading_report'] = 'grading_report/index';
$route['target_report/export/(:any)'] = 'target_report/report_export/$1';
$route['target_report/load'] = 'target_report/report_filter';
$route['target_report'] = 'target_report/index';
$route['daily_report/export/(:any)'] = 'daily_report/report_export/$1';
$route['daily_report/load'] = 'daily_report/report_filter';
$route['daily_report/email'] = 'daily_report/send_report';
$route['daily_report'] = 'daily_report/index';
$route['log/log_list/(:any)'] = 'audit/log_list/$1';
$route['audit'] = 'audit/index';
$route['login/go'] = 'user_authentication/login_process';
$route['unset/(:any)'] = 'user_authentication/unsess/$1';
$route['forgot'] = 'user_authentication/send_userid';
$route['clear'] = 'user_authentication/index';
$route['login'] = 'user_authentication/index';
$route['logout'] = 'user_authentication/logout';
$route['(:any)'] = 'home/view/$1';
$route['default_controller'] = 'home/view';