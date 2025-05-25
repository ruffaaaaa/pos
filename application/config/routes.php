<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['translate_uri_dashes'] = FALSE;

//auth

$route['login'] = 'auth/login';  // Route for login processing

$route['dashboard'] = 'dashboard/index';  // Route for login processing
$route['suppliers'] = 'supplier/index';  // Route for login processing
$route['customers'] = 'customer/index';  // Route for login processing
$route['categories'] = 'category/index';  // Route for login processing
$route['products'] = 'product/index';  // Route for login processing    
$route['units'] = 'unit/index';  // Route for login processing
$route['users'] = 'user/index';  // Route for login processing

