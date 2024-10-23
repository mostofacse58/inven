<?php

/*
 * This is our Db_log hook file
 * 
 */

class Db_log {

    var $CI;

    function __construct() {
        $this->CI = & get_instance(); // Create instance of CI
    }

    // function logQueries() {

    //     $filepath = APPPATH . 'logs/QueryLog-' . date('Y-m-d') . '.php'; // Filepath. File is created in logs folder with name QueryLog
    //     $handle = fopen($filepath, "a+"); // Open the file

    //     $times = $this->CI->db->query_times; // We get the array of execution time of each query that got executed by our application(controller)
        
    //     foreach ($this->CI->db->queries as $key => $query) { // Loop over all the queries  that are stored in db->queries array
    //         $sql = $query ; // Write it along with the execution time
    //         fwrite($handle, $sql . ";\n\n");
    //     }

    //     fclose($handle); // Close the file
    // }

   function logQueries() {   
        $CI =& get_instance();
        $times = $CI->db->query_times;
        $dbs    = array();
        $output = NULL;    
        $queries = $CI->db->queries;

        if (count($queries) == 0)
        {
            $output .= "no queries\n";
        }
        else
        {
            foreach ($queries as $key=>$query)
            {
                $output .= $query . "\n";
            }
            $took = round(doubleval($times[$key]), 3);
            $output .= "===[took:{$took}]\n\n";
        }

        $CI->load->helper('file');
        if ( ! write_file(APPPATH  . "/logs/queries.log.txt", $output, 'a+'))
        {
             log_message('debug','Unable to write query the file');
        }  
    }

}

?>
