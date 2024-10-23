function investorForm(){
    var company_name = $('input[name=company_name]').val();
    var legal_structure = $('select[name=legal_structure]').val();
    var country_id = $('select[name=country_id]').val();
    var email_office = $('input[name=email_office]').val();
    var mobile_office = $('input[name=mobile_office]').val();
    var first_name = $('input[name=first_name]').val();
    var last_name = $('input[name=last_name]').val();
    var designation = $('input[name=designation]').val();
    var mobile = $('input[name=mobile]').val();
    var email_address = $('input[name=email_address]').val();
    var password = $('input[name=password]').val();
    var error = 0;
        if(company_name == '') {
            error = 1;
            $('input[name=company_name]').css('border', '1px solid #f00');
        } else {
            $('input[name=company_name]').css('border', '1px solid #ccc');         
        }
        if(legal_structure == '') {
            error = 1;
            $('select[name=legal_structure]').css('border', '1px solid #f00');
        } else {
            $('select[name=legal_structure]').css('border', '1px solid #ccc');         
        }
        if(country_id == '') {
            error = 1;
            $('select[name=country_id]').css('border', '1px solid #f00');
        } else {
            $('select[name=country_id]').css('border', '1px solid #ccc');         
        }
        if(email_office == '') {
            error = 1;
            $('input[name=email_office]').css('border', '1px solid #f00');
        } else {
            $('input[name=email_office]').css('border', '1px solid #ccc');         
        }
        if(mobile_office == '') {
            error = 1;
            $('input[name=mobile_office]').css('border', '1px solid #f00');
        } else {
            $('input[name=mobile_office]').css('border', '1px solid #ccc');         
        }
        if(first_name == '') {
            error = 1;
            $('input[name=first_name]').css('border', '1px solid #f00');
        } else {
            $('input[name=first_name]').css('border', '1px solid #ccc');         
        }
        if(last_name == '') {
            error = 1;
            $('input[name=last_name]').css('border', '1px solid #f00');
        } else {
            $('input[name=last_name]').css('border', '1px solid #ccc');         
        }
        if(designation == '') {
            error = 1;
            $('input[name=designation]').css('border', '1px solid #f00');
        } else {
            $('input[name=designation]').css('border', '1px solid #ccc');         
        }
        if(mobile == '') {
            error = 1;
            $('input[name=mobile]').css('border', '1px solid #f00');
        } else {
            $('input[name=mobile]').css('border', '1px solid #ccc');         
        }
         if(email_address == '') {
            error = 1;
            $('input[name=email_address]').css('border', '1px solid #f00');
        } else {
            $('input[name=email_address]').css('border', '1px solid #ccc');         
        }
         if(password == '') {
            error = 1;
            $('input[name=password]').css('border', '1px solid #f00');
        } else {
            $('input[name=password]').css('border', '1px solid #ccc');         
        }
        if(error==true){
        return false;
        }else{
         return true;   
        }
    }
    function corporatesForm(){
    var company_name = $('input[name=company_name]').val();
    var legal_structure = $('select[name=legal_structure]').val();
    var regi_no = $('select[name=regi_no]').val();
    var country_id = $('select[name=country_id]').val();
    var email_office = $('input[name=email_office]').val();
    var mobile_office = $('input[name=mobile_office]').val();
    var first_name = $('input[name=first_name]').val();
    var last_name = $('input[name=last_name]').val();
    var designation = $('input[name=designation]').val();
    var mobile = $('input[name=mobile]').val();
    var email_address = $('input[name=email_address]').val();
    var password = $('input[name=password]').val();
    var error = 0;
        if(company_name == '') {
            error = 1;
            $('input[name=company_name]').css('border', '1px solid #f00');
        } else {
            $('input[name=company_name]').css('border', '1px solid #ccc');         
        }
        if(legal_structure == '') {
            error = 1;
            $('select[name=legal_structure]').css('border', '1px solid #f00');
        } else {
            $('select[name=legal_structure]').css('border', '1px solid #ccc');         
        }
        if(regi_no == '') {
            error = 1;
            $('select[name=regi_no]').css('border', '1px solid #f00');
        } else {
            $('select[name=regi_no]').css('border', '1px solid #ccc');         
        }
        if(country_id == '') {
            error = 1;
            $('select[name=country_id]').css('border', '1px solid #f00');
        } else {
            $('select[name=country_id]').css('border', '1px solid #ccc');         
        }
        if(email_office == '') {
            error = 1;
            $('input[name=email_office]').css('border', '1px solid #f00');
        } else {
            $('input[name=email_office]').css('border', '1px solid #ccc');         
        }
        if(mobile_office == '') {
            error = 1;
            $('input[name=mobile_office]').css('border', '1px solid #f00');
        } else {
            $('input[name=mobile_office]').css('border', '1px solid #ccc');         
        }
        if(first_name == '') {
            error = 1;
            $('input[name=first_name]').css('border', '1px solid #f00');
        } else {
            $('input[name=first_name]').css('border', '1px solid #ccc');         
        }
        if(last_name == '') {
            error = 1;
            $('input[name=last_name]').css('border', '1px solid #f00');
        } else {
            $('input[name=last_name]').css('border', '1px solid #ccc');         
        }
        if(designation == '') {
            error = 1;
            $('input[name=designation]').css('border', '1px solid #f00');
        } else {
            $('input[name=designation]').css('border', '1px solid #ccc');         
        }
        if(mobile == '') {
            error = 1;
            $('input[name=mobile]').css('border', '1px solid #f00');
        } else {
            $('input[name=mobile]').css('border', '1px solid #ccc');         
        }
         if(email_address == '') {
            error = 1;
            $('input[name=email_address]').css('border', '1px solid #f00');
        } else {
            $('input[name=email_address]').css('border', '1px solid #ccc');         
        }
         if(password == '') {
            error = 1;
            $('input[name=password]').css('border', '1px solid #f00');
        } else {
            $('input[name=password]').css('border', '1px solid #ccc');         
        }
        if(error==true){
        return false;
        }else{
         return true;   
        }
    }
    function financialForm(){
    var company_name = $('input[name=company_name]').val();
    var regi_no = $('select[name=regi_no]').val();
    var country_id = $('select[name=country_id]').val();
    var email_office = $('input[name=email_office]').val();
    var first_name = $('input[name=first_name]').val();
    var last_name = $('input[name=last_name]').val();
    var designation = $('input[name=designation]').val();
    var mobile = $('input[name=mobile]').val();
    var email_address = $('input[name=email_address]').val();
    var password = $('input[name=password]').val();
    var error = 0;
        if(company_name == '') {
            error = 1;
            $('input[name=company_name]').css('border', '1px solid #f00');
        } else {
            $('input[name=company_name]').css('border', '1px solid #ccc');         
        }
        if(regi_no == '') {
            error = 1;
            $('select[name=regi_no]').css('border', '1px solid #f00');
        } else {
            $('select[name=regi_no]').css('border', '1px solid #ccc');         
        }
        if(country_id == '') {
            error = 1;
            $('select[name=country_id]').css('border', '1px solid #f00');
        } else {
            $('select[name=country_id]').css('border', '1px solid #ccc');         
        }
        if(email_office == '') {
            error = 1;
            $('input[name=email_office]').css('border', '1px solid #f00');
        } else {
            $('input[name=email_office]').css('border', '1px solid #ccc');         
        }
       
        if(first_name == '') {
            error = 1;
            $('input[name=first_name]').css('border', '1px solid #f00');
        } else {
            $('input[name=first_name]').css('border', '1px solid #ccc');         
        }
        if(last_name == '') {
            error = 1;
            $('input[name=last_name]').css('border', '1px solid #f00');
        } else {
            $('input[name=last_name]').css('border', '1px solid #ccc');         
        }
        if(designation == '') {
            error = 1;
            $('input[name=designation]').css('border', '1px solid #f00');
        } else {
            $('input[name=designation]').css('border', '1px solid #ccc');         
        }
        if(mobile == '') {
            error = 1;
            $('input[name=mobile]').css('border', '1px solid #f00');
        } else {
            $('input[name=mobile]').css('border', '1px solid #ccc');         
        }
         if(email_address == '') {
            error = 1;
            $('input[name=email_address]').css('border', '1px solid #f00');
        } else {
            $('input[name=email_address]').css('border', '1px solid #ccc');         
        }
         if(password == '') {
            error = 1;
            $('input[name=password]').css('border', '1px solid #f00');
        } else {
            $('input[name=password]').css('border', '1px solid #ccc');         
        }
        if(error==true){
        return false;
        }else{
         return true;   
        }
    }