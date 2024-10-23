<?php

class Report_model extends CI_Model {
	
	 function customer_list($type){
	 	if($type=='Regular'){
		  $result=$this->db->query("SELECT customer_id,CONCAT(customer_name,' (',total_value,')') as customer_name
                  FROM  customer_information")->result();
        return $result;
    }else{
         $result=$this->db->query("SELECT customer_id,CONCAT(customer_name,' (',total_value,')') as customer_name
                  FROM  customer_information WHERE customer_type='$type'")->result();
        return $result;
    }
	}

    function customer_wise_report() {
		$customer_id=$this->input->post('customer_id');
        $result=$this->db->query("SELECT a.*,b.bank_name
                  FROM  account_table a
				  LEFT JOIN bank_information b ON(b.bank_id=a.bank_id)
				  WHERE a.customer_id=$customer_id and a.payment_type='R' ORDER BY a.account_id ASC ")->result();
        return $result;
    }
    function dcustomer_wise_report() {
		$customer_id=$this->input->post('customer_id');
        $result=$this->db->query("SELECT a.*,b.bank_name,c.cheque_no
                  FROM  account_table a
				  LEFT JOIN bank_information b ON(b.bank_id=a.bank_id)
				  LEFT JOIN cheque_book c ON(a.cheque_id=c.cheque_id)
				  WHERE a.customer_id=$customer_id and a.payment_type='P' ORDER BY a.account_id ASC ")->result();
        return $result;
    }
    function customer_add_cost(){
    	$customer_id=$this->input->post('customer_id');
    	$result=$this->db->query("SELECT cost,detail FROM customer_additional_cost
    		WHERE customer_id=$customer_id")->result();
    	 return $result;
    }
    function customer_info(){
		 $customer_id=$this->input->post('customer_id');
		 $result=$this->db->query("SELECT c.*,p.*
                  FROM  customer_information c, project_information p
				  WHERE c.project_id=p.project_id and c.customer_id=$customer_id")->row();
        return $result;
	}
	///////////////////////
	function corporate_sim_user(){
		 $result=$this->db->query("SELECT e.*,p.post_name
                  FROM  employee_information e, post p
				  WHERE e.post_id=p.post_id AND e.c_sim_use='YES'")->result();
        return $result;
	}
	function employee_deposit_amount(){
		 $result=$this->db->query("SELECT e.*,p.post_name,
		 	(select SUM(s.deposit_amount) as total FROM employee_salary s 
		 		WHERE e.employee_id=s.employee_id) as deposit_amount
                  FROM  employee_information e, post p
				  WHERE e.post_id=p.post_id")->result();
        return $result;
	}
	///////////////////////
	function employee_list(){
		   $result=$this->db->query("SELECT l.loan_id,CONCAT(e.employee_name,' (',l.loan_amount,')') as employee_name
                  FROM  employee_loan l,employee_information e 
				  WHERE e.employee_id=l.employee_id")->result();
        return $result;
	  }

    function employee_loan_report() {
		$loan_id=$this->input->post('loan_id');
        $result=$this->db->query("SELECT * FROM  employee_loan_ad  
				  WHERE loan_id=$loan_id ORDER BY loan_ad_id ASC")->result();

        return $result;
    }
    function loan_info(){
		 $loan_id=$this->input->post('loan_id');
		$result=$this->db->query("SELECT l.*,e.*,p.post_name
                  FROM  employee_loan l,employee_information e,post p 
				  WHERE e.employee_id=l.employee_id and e.post_id=p.post_id and l.loan_id=$loan_id")->row();
        return $result;
	}
    
    
  
///////////////////////
	function book_list(){
		   $result=$this->db->query("SELECT book_no FROM cheque_book GROUP BY book_no")->result();
        return $result;
	  }

    function cheque_book_register($id) {
		$book_no=$this->input->post('book_no');
		$bank_id=$this->input->post('bank_id');
		if($id==1){
        $result=$this->db->query("SELECT ch.*,b.bank_name,a.*,
        	(SELECT SUM(a2.pay_amount) FROM account_table a2 
        		WHERE a2.cheque_id=ch.cheque_id ) as pay_amount,
    	s.supplier_name,c.contractor_name,e.employee_name,
    	l.landowner_name,br.broker_name
	    FROM account_table  a
		INNER JOIN cheque_book ch ON(a.cheque_id=ch.cheque_id)
		INNER JOIN bank_information b ON(a.bank_id=b.bank_id)
		LEFT JOIN supplier_information s ON(a.supplier_id=s.supplier_id)
		LEFT JOIN contractor_information c ON(a.contractor_id=c.contractor_id)
		LEFT JOIN employee_information e ON(a.employee_id=e.employee_id)
		LEFT JOIN landowner_information l ON(a.landowner_id=l.landowner_id)
		LEFT JOIN broker_information br ON(a.broker_id=br.broker_id)
		WHERE ch.book_no=$book_no and ch.bank_id=$bank_id
		GROUP BY ch.cheque_id
		ORDER BY ch.cheque_no ASC")->result();
        return $result;
    }elseif($id==2){
    	$result=$this->db->query("SELECT ch.*,b.bank_name,e.employee_name,a.*
		FROM employee_salary  a
		INNER JOIN cheque_book ch ON(a.cheque_id=ch.cheque_id)
		INNER JOIN bank_information b ON(a.bank_id=b.bank_id)
		INNER JOIN employee_information e ON(a.employee_id=e.employee_id)
		WHERE ch.book_no=$book_no  and ch.bank_id=$bank_id
		ORDER BY ch.cheque_no ASC")->result();
    	return $result;
    }elseif($id==3){
        $result=$this->db->query("SELECT ch.*,b.bank_name,e.employee_name,a.*
		FROM employee_loan  a
		INNER JOIN cheque_book ch ON(a.cheque_id=ch.cheque_id)
		INNER JOIN bank_information b ON(a.bank_id=b.bank_id)
		INNER JOIN employee_information e ON(a.employee_id=e.employee_id)
		WHERE ch.book_no=$book_no  and ch.bank_id=$bank_id
		ORDER BY ch.cheque_no ASC")->result();
    	return $result;
    }elseif($id==4){
        $result=$this->db->query("SELECT ch.*,b.bank_name,ab.*
		FROM assetbuy  ab
		INNER JOIN cheque_book ch ON(ab.cheque_id=ch.cheque_id)
		INNER JOIN bank_information b ON(ab.bank_id=b.bank_id)
		WHERE ch.book_no=$book_no  and ch.bank_id=$bank_id
		ORDER BY ch.cheque_no ASC")->result();
    	return $result;
    }
    }
    ///////////////////////
	function contractor_list(){
		   $result=$this->db->query("SELECT c.contractor_id,c.contractor_name
                  FROM  contractor_detail cd,contractor_information c 
				  WHERE  cd.contractor_id=c.contractor_id 
				  GROUP BY c.contractor_id")->result();
        return $result;
	  }
	function conproject_list(){
		$result=$this->db->query("SELECT p.project_id,p.project_name
                  FROM  contractor_detail cd,project_information p 
				  WHERE p.project_id=cd.project_id
				  GROUP BY p.project_id")->result();
        return $result;
	}

    function contractor_payment_statement() {
		$project_id=$this->input->post('project_id');
		$contractor_id=$this->input->post('contractor_id');
        $result=$this->db->query("SELECT aa.* FROM( 
			(SELECT cd.	contractor_detail_id as id,cd.bill_date as date1,
				cd.bill_no,cd.payment_amount,null as con_type_payment,cd.comments,
				0 as pay_amount,null as cheque_no,null as bank_name,1 as chk
			FROM contractor_detail cd
			WHERE cd.project_id=$project_id and cd.contractor_id=$contractor_id)
		   UNION 
		   (SELECT a.account_id as id, a.payment_date as date1, null as bill_no,0 as payment_amount, 
			a.con_type_payment,a.description as comments,a.pay_amount,c.cheque_no,b.bank_name,2 as chk
		   	FROM  account_table a
		   	LEFT JOIN bank_information b ON(a.bank_id=b.bank_id)
		   	LEFT JOIN cheque_book c ON(a.cheque_id=c.cheque_id)
		   	WHERE a.contractor_id=$contractor_id and a.project_id=$project_id)
          ) aa ORDER BY aa.date1,aa.chk ASC ")->result();
          return $result;
       }
    function contractor_info(){
		$contractor_id=$this->input->post('contractor_id');
		$result=$this->db->query("SELECT * FROM  contractor_information
				  WHERE contractor_id=$contractor_id")->row();
		
        return $result;
	}
	function project_list(){
		$result=$this->db->query("SELECT * FROM  project_information")->result();
        return $result;
	  }

	 function project_info(){
	  	$project_id=$this->input->post('project_id');
		$result=$this->db->query("SELECT * FROM  project_information 
			WHERE project_id=$project_id")->row();
        return $result;
	 }
	  function product_list(){
		$result=$this->db->query("SELECT * FROM  supplier_product")->result();
        return $result;
	  }
	   function product_info(){
	   	$sproduct_id=$this->input->post('sproduct_id');
		$result=$this->db->query("SELECT * FROM  supplier_product 
			WHERE sproduct_id=$sproduct_id")->row();
        return $result;
	  }
	 

    function product_purchase_sheet() {
    	$project_id=$this->input->post('project_id');
    	$sproduct_id=$this->input->post('sproduct_id');
        $result=$this->db->query("SELECT sd.*,s.supplier_name
		FROM supplier_detail  sd
		INNER JOIN supplier_information s ON(sd.supplier_id=s.supplier_id)
	    WHERE sd.project_id=$project_id AND sd.sproduct_id=$sproduct_id ORDER BY sd.purchase_date ASC")->result();
        return $result;
    }
     function share_info(){
	   	$share_id=$this->input->post('share_id');
		$result=$this->db->query("SELECT e.*,d.share_quantity,p.post_name 
			FROM employee_information e,director_share d,post p 
            WHERE e.employee_id=d.employee_id and e.post_id=p.post_id and share_id=$share_id")->row();
        return $result;
	  }
    function director_list(){
    	$result=$this->db->query("SELECT d.share_id,CONCAT(e.employee_name,' (',d.share_quantity,')') as employee_name
                  FROM employee_information e,director_share d 
                  WHERE e.employee_id=d.employee_id ORDER BY e.employee_id DESC")->result();
        return $result;
    }
    function share_money_sheet(){
    	$share_id=$this->input->post('share_id');
 
        $result=$this->db->query("SELECT s.*,b.bank_name
		FROM share_adjaustment  s
		LEFT JOIN bank_information b ON(s.bank_id=b.bank_id)
	    WHERE s.share_id=$share_id  ORDER BY s.ad_date ASC")->result();
        return $result;
    }
    function supplier_list(){
		   $result=$this->db->query("SELECT * FROM  supplier_information")->result();
        return $result;
	  }
       function supplier_info(){
		$supplier_id=$this->input->post('supplier_id');
		$result=$this->db->query("SELECT * FROM  supplier_information 
			WHERE supplier_id=$supplier_id")->row();
        return $result;
	}
	function supplier_payment_statement(){
		$supplier_id=$this->input->post('supplier_id');
		$from_date=alterDateFormat($this->input->post('from_date'));
		$to_date=alterDateFormat($this->input->post('to_date'));
		$result=$this->db->query("SELECT aa.* FROM( 
			(SELECT sd.supplier_detail_id, null as account_id, sd.unit_price,sd.quantity,sd.payment_amount,
				sd.purchase_date as date1,p.project_name,sp.sproduct_name,
				0 as  pay_amount, sd.mr_no as cheque_no,null as bank_name,sd.comments,1 as chk
			FROM supplier_detail sd, project_information p,supplier_product sp
			WHERE sd.project_id=p.project_id and sd.sproduct_id=sp.sproduct_id and 
			 sd.supplier_id=$supplier_id and  sd.purchase_date BETWEEN '$from_date' and '$to_date')
		UNION 
		(SELECT null as supplier_detail_id, a.account_id, null as unit_price,null as quantity,0 as payment_amount, 
			a.payment_date as date1,null as project_name,null as sproduct_name,
			a.pay_amount,c.cheque_no,b.bank_name,a.description as comments,2 as chk
		   	FROM  account_table a
		   	LEFT JOIN bank_information b ON(a.bank_id=b.bank_id)
		   	LEFT JOIN cheque_book c ON(a.cheque_id=c.cheque_id)
		   	WHERE  a.supplier_id=$supplier_id and a.payment_date BETWEEN '$from_date' and '$to_date'
			))as aa ORDER BY aa.date1,aa.chk ASC ")->result();
        return $result;
	}

   function broker_list(){
		   $result=$this->db->query("SELECT b.broker_id,CONCAT(b.broker_name,' >',p.project_name) as broker_name
		    FROM  broker_information b, project_information p
		    WHERE b.project_id=p.project_id")->result();
        return $result;
	  }
       function broker_info(){
		$broker_id=$this->input->post('broker_id');
		$result=$this->db->query("SELECT b.*,p.project_name 
			FROM  broker_information b,project_information p 
			WHERE b.project_id=p.project_id and b.broker_id=$broker_id")->row();
        return $result;
	}
     function broker_payment_statement(){
	 	$broker_id=$this->input->post('broker_id');
		$from_date=alterDateFormat($this->input->post('from_date'));
		$to_date=alterDateFormat($this->input->post('to_date'));
		   $result=$this->db->query("SELECT a.*,c.cheque_no,b.bank_name  
		   	FROM  account_table a
		   	LEFT JOIN bank_information b ON(a.bank_id=b.bank_id)
		   	LEFT JOIN cheque_book c ON(a.cheque_id=c.cheque_id)
		   	WHERE a.broker_id=$broker_id and a.payment_date BETWEEN '$from_date' and '$to_date' ")->result();
        return $result;
	  }
	  function landowner_list(){
		   $result=$this->db->query("SELECT l.landowner_id,
		   	CONCAT(l.landowner_name,' >',p.project_name) as landowner_name
		    FROM  landowner_information l, project_information p,landowner_detail ld
		    WHERE l.land_id=ld.land_id and ld.project_id=p.project_id")->result();
        return $result;
	  }
       function landowner_info(){
		$landowner_id=$this->input->post('landowner_id');
		$result=$this->db->query("SELECT l.*,p.project_name 
			FROM  landowner_information l,project_information p,landowner_detail ld 
			WHERE l.land_id=ld.land_id and ld.project_id=p.project_id and l.landowner_id=$landowner_id")->row();
        return $result;
	}
     function landowner_payment_statement(){
	 	$landowner_id=$this->input->post('landowner_id');
		$from_date=alterDateFormat($this->input->post('from_date'));
		$to_date=alterDateFormat($this->input->post('to_date'));
		   $result=$this->db->query("SELECT a.*,c.cheque_no,b.bank_name  
		   	FROM  account_table a
		   	LEFT JOIN bank_information b ON(a.bank_id=b.bank_id)
		   	LEFT JOIN cheque_book c ON(a.cheque_id=c.cheque_id)
		   	WHERE a.landowner_id=$landowner_id and a.payment_date BETWEEN '$from_date' and '$to_date' ")->result();
        return $result;
	  }
	  function project_wise_customer(){
	  	$project_id=$this->input->post('project_id');
	  	$result=$this->db->query("SELECT c.*,(select sum(a.pay_amount) from account_table a where a.customer_id=c.customer_id and a.payment_type='R') as paid_amount
	  	FROM customer_information c 
	  	WHERE c.customer_type='Regular' and c.project_id=$project_id")->result();
	  	return $result;
	  }
	   function project_wise_dcustomer(){
	  	$project_id=$this->input->post('project_id');
	  	$result=$this->db->query("SELECT c.*,(select sum(pay_amount) from account_table a where a.customer_id=c.customer_id and a.payment_type='P') as paid_amount
	  	FROM customer_information c 
	  	WHERE c.customer_type='Default' and c.project_id=$project_id")->result();
	  	return $result;
	  }
	   function project_wise_supplier(){
	  	$project_id=$this->input->post('project_id');
	  	$result=$this->db->query("SELECT s.*,
	  		(select sum(sd.payment_amount) from supplier_detail sd 
	  			where sd.supplier_id=s.supplier_id and sd.project_id=$project_id) as pay_amount,
	  	    (select sum(a.pay_amount) from account_table a
	  	    	where a.supplier_id=s.supplier_id and a.project_id=$project_id) as paid_amount
	  	FROM supplier_information s,supplier_detail sd2  
	  	WHERE s.supplier_id=sd2.supplier_id and sd2.project_id=$project_id
	  	GROUP BY s.supplier_id")->result();
	  	return $result;
	  }
	    function project_wise_contractor(){
	  	$project_id=$this->input->post('project_id');
	  	$result=$this->db->query("SELECT c.*,
	  		(select sum(cd.payment_amount) from contractor_detail cd 
	  			where cd.contractor_id=c.contractor_id and cd.project_id=$project_id) as pay_amount,
	  	    (select sum(a.pay_amount) from account_table a
	  	    	where a.contractor_id=c.contractor_id and a.project_id=$project_id) as paid_amount
	  	FROM contractor_information c,contractor_detail cd2  
	  	WHERE c.contractor_id=cd2.contractor_id and cd2.project_id=$project_id
	  	GROUP BY c.contractor_id")->result();
	  	return $result;
	  }
	   function project_wise_broker(){
	  	$project_id=$this->input->post('project_id');
	  	$result=$this->db->query("SELECT b.*,
	  	    (select sum(a.pay_amount) from account_table a
	  	    	where a.broker_id=b.broker_id and a.project_id=$project_id) as paid_amount
	  	FROM broker_information b 
	  	WHERE b.project_id=$project_id")->result();
	  	return $result;
	  }
	  function project_wise_landowner(){
	  	$project_id=$this->input->post('project_id');
	  	$result=$this->db->query("SELECT l.*,
	  	    (select sum(a.pay_amount) from account_table a
	  	    	where a.landowner_id=l.landowner_id and a.project_id=$project_id) as paid_amount
	  	FROM landowner_information l,landowner_detail ld 
	  	WHERE l.land_id=ld.land_id and ld.project_id=$project_id")->result();
	  	return $result;
	  }
	  function employee_salary_sheet(){
	  	$month=$this->input->post('month');
	  	$result=$this->db->query("SELECT es.*,e.employee_name,e.salary,p.post_name,c.cheque_no,b.bank_name
	  		FROM employee_salary es
	  		INNER JOIN employee_information e ON(es.employee_id=e.employee_id)
	  		INNER JOIN post p ON(e.post_id=p.post_id)
	  		LEFT JOIN bank_information b ON(es.bank_id=b.bank_id)
	  		LEFT JOIN cheque_book c ON(es.cheque_id=c.cheque_id)
	  	    WHERE es.category='2' and es.pay_month_date LIKE '%$month' ")->result();
	  	return $result;
	  }
	    function director_honourium_sheet(){
	  	$month=$this->input->post('month');
	  	$result=$this->db->query("SELECT es.*,e.employee_name,e.salary,p.post_name,c.cheque_no,b.bank_name
	  		FROM employee_salary es
	  		INNER JOIN employee_information e ON(es.employee_id=e.employee_id)
	  		INNER JOIN post p ON(e.post_id=p.post_id)
	  		LEFT JOIN bank_information b ON(es.bank_id=b.bank_id)
	  		LEFT JOIN cheque_book c ON(es.cheque_id=c.cheque_id)
	  	    WHERE es.category='1' and es.pay_month_date LIKE '%$month' ")->result();
	  	return $result;
	  }
	  function getcategory(){
        $result=$this->db->query("SELECT *  FROM expense_category")->result();
        return $result;
    }
    function expense_report(){
    	//$month=$this->input->post('month');

    	$from_date=alterDateFormat($this->input->post('from_date'));
		$to_date=alterDateFormat($this->input->post('to_date'));

    	$cat_id=$this->input->post('cat_id');
        if($cat_id=='Project'||$cat_id=='Office'){
        $result=$this->db->query("SELECT a.*,b.bank_name,p.project_name
    	 FROM assetbuy a
    	 LEFT JOIN bank_information b ON(a.bank_id=b.bank_id)
         LEFT JOIN project_information p ON(a.project_id=p.project_id)
         WHERE a.buy_type='$cat_id' and a.buy_date BETWEEN  '$from_date' and '$to_date' ")->result();
        }else{
    	$result=$this->db->query("SELECT a.*,b.bank_name,e.employee_name,e.sim_mob_no,p.post_name
    	 FROM account_table a
    	 LEFT JOIN bank_information b ON(a.bank_id=b.bank_id)
         LEFT JOIN employee_information e ON(a.employee_id=e.employee_id)
         LEFT JOIN post p ON(e.post_id=p.post_id)
         WHERE a.cat_id=$cat_id and a.payment_date BETWEEN  '$from_date' and '$to_date' ")->result();
        }
    	return $result;
    }
    function project_customerlist(){
    	$project_id=$this->input->post('project_id');
    	$result=$this->db->query("SELECT c.*,
    		(select sum(a.pay_amount) FROM account_table a 
    			where a.customer_id=c.customer_id and a.project_id=c.project_id and a.payment_type='R') as paid_amount
    		FROM customer_information c
    		WHERE c.project_id=$project_id")->result();
    	return $result;
    }
      function project_dcustomerlist(){
    	$project_id=$this->input->post('project_id');
    	$result=$this->db->query("SELECT c.*,
    		(select sum(a.pay_amount) FROM account_table a 
    			where a.customer_id=c.customer_id and a.project_id=c.project_id and a.payment_type='P') as paid_amount
    		FROM customer_information c
    		WHERE c.project_id=$project_id and c.customer_type='Default' ")->result();
    	return $result;
    }
     function project_supplierlist(){
    	$project_id=$this->input->post('project_id');
    	$result=$this->db->query("SELECT s.*,(select sum(sd.payment_amount) FROM supplier_detail sd where sd.supplier_id=s.supplier_id and sd.project_id=$project_id) as total_value,

    		(select sum(a.pay_amount) FROM account_table a 
    			where a.supplier_id=s.supplier_id and a.project_id=$project_id and a.payment_type='P') as paid_amount
    		FROM supplier_information s")->result();
    	return $result;
    }
      function project_contractorlist(){
    	$project_id=$this->input->post('project_id');
    	$result=$this->db->query("SELECT c.*,(select sum(cd.payment_amount) FROM contractor_detail cd where cd.contractor_id=c.contractor_id and cd.project_id=$project_id) as total_value,

    		(select sum(a.pay_amount) FROM account_table a 
    			where a.contractor_id=c.contractor_id and a.project_id=$project_id and a.payment_type='P') as paid_amount
    		FROM contractor_information c")->result();
    	return $result;
    }
    function project_landownerlist(){
    	$project_id=$this->input->post('project_id');
    	$result=$this->db->query("SELECT l.*,
    		(select sum(a.pay_amount) FROM account_table a 
    			where a.landowner_id=l.landowner_id and a.project_id=ld.project_id and a.payment_type='P') as paid_amount
    		FROM landowner_information l
    		INNER JOIN landowner_detail ld ON(l.land_id=ld.land_id)
    		WHERE  ld.project_id=$project_id")->result();
    	return $result;
    }
    function project_brokerlist(){
    	$project_id=$this->input->post('project_id');
    	$result=$this->db->query("SELECT b.*,
    		(select sum(a.pay_amount) FROM account_table a 
    			where a.broker_id=b.broker_id and a.project_id=b.project_id and a.payment_type='P') as paid_amount
    		FROM broker_information b
      		WHERE  b.project_id=$project_id")->result();
    	return $result;
    }
    function project_buylist(){
    	$project_id=$this->input->post('project_id');
    	$result=$this->db->query("SELECT * 
    		FROM assetbuy WHERE  project_id=$project_id")->result();
    	return $result;
    }
    function project_selllist(){
    	$project_id=$this->input->post('project_id');
    	$result=$this->db->query("SELECT * 
    		FROM oldassetsell WHERE  project_id=$project_id")->result();
    	return $result;
    }

 

  
}
