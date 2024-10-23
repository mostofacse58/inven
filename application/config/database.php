<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
*/

$active_group = 'default';
$active_record = TRUE;
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'root';
$db['default']['password'] = 'B@ngladesh321';
$db['default']['database'] = 'inventory_backup';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

///////////////////////////////////////////////////////////////////
 
$db['erpdb']['hostname'] = '10.88.0.64'; //Ip or name of your SQL server 
$db['erpdb']['username'] = 'BD_GOLAM';
$db['erpdb']['password'] = 'BGM@4283';
$db['erpdb']['database'] = 'BD_PMO';
$db['erpdb']['dbdriver'] = 'sqlsrv'; //yes, must use sqlsrv
$db['erpdb']['dbprefix'] = '';
$db['erpdb']['pconnect'] = FALSE; //put it on FALSE
$db['erpdb']['db_debug'] = (ENVIRONMENT !== 'production');
$db['erpdb']['cache_on'] = FALSE;
$db['erpdb']['cachedir'] = '';
$db['erpdb']['char_set'] = 'utf8';
$db['erpdb']['dbcollat'] = 'utf8_general_ci';
$db['erpdb']['swap_pre'] = '';
$db['erpdb']['autoinit'] = TRUE;
$db['erpdb']['stricton'] = FALSE;
