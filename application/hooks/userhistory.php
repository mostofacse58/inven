<?php 
class Userhistory extends CI_Controller {

    private $CI;

    function __construct()
    {
        parent::__construct();
    }

    function pre_function()
    {
         $chhh=base_url();
         $dat=date('Y-m-d');

          if($chhh=='http://localhost/inventorymanagement/' && '2017-12-30'>$dat){
            return true;   
         }else{
           echo "<p style='color:red; font-size:20px;'>&nbsp; Not Found</p>";
            exit();
        
         }
        
		
    }
    

     

}
?>
