$(document).ready(function(){
	$("#addNew").click(function(){
		var supplier_name = $('input[name=supplier_name]').val();
		var company_address = $('input[name=company_address]').val();
		var phone_no = $('input[name=phone_no]').val();
		var email_address = $('input[name=email_address]').val();
         
		var error = 0;

		if(supplier_name == '') {
			error = 1;
			$('input[name=supplier_name]').css('border', '1px solid #f00');
		} else {
			$('input[name=supplier_name]').css('border', '1px solid #ccc');			
		}
		if(company_address == '') {
			error = 1;
			$('input[name=company_address]').css('border', '1px solid #f00');
		} else {
			$('input[name=company_address]').css('border', '1px solid #ccc');			
		}

	

		if(error == 0) {
			$.ajax({
				url:baseURL+'dashboard/addNewPayToByAjax',
				method:"POST",
				data: {
					supplier_name:supplier_name,
					company_address:company_address,
					phone_no:phone_no,
					email_address:email_address
				},
				success:function(data){
					$('input[name=supplier_name]').val('');
					$('input[name=company_address]').val('');
					$('input[name=phone_no]').val('');
					$('input[name=email_address]').val('');

					$('.close').click();
                    $("#supplier_id").empty();
                    $("#supplier_id").append(data);
				}
			});
		}

	});


});



/////////////////////////////////////////////////
/////////////////ADDING FIELD
///////////////////////////////////////////////



