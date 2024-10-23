<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['pre_controller'] = array(
                                'class'    => 'userhistory',
                                'function' => 'pre_function',
                                'filename' => 'userhistory.php',
                                'filepath' => 'helper',
                                'params'   => array('beer', 'wine', 'snacks')
                                );
// It has to be a post controller hook since all the queries have finished executing & the system is about to exit
$hook['post_controller'] = array(
    'class' => 'Db_log', 
    'function' => 'logQueries',
    'filename' => 'db_log.php',
    'filepath' => 'hooks'
);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */