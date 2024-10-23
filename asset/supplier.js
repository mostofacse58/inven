$(document).ready(function(){
	$("#addNewGuest").click(function(){
		var supplier_name = $('input[name=supplier_name]').val();
		var phone_no = $('input[name=phone_no]').val();
		var company_address = $('input[name=company_address]').val();
         
		var error = 0;

		if(supplier_name == '') {
			error = 1;
			$('input[name=supplier_name]').css('border', '1px solid #f00');
		} else {
			$('input[name=supplier_name]').css('border', '1px solid #ccc');			
		}
	

		if(phone_no == '') {
			error = 1;
			$('input[name=phone_no]').css('border', '1px solid #f00');
		} else {
			$('input[name=phone_no]').css('border', '1px solid #ccc');			
		}


		if(error == 0) {
			$.ajax({
				url:baseURL+'dashboard/addNewSupplierByAjax',
				method:"POST",
				data: {
					supplier_name:supplier_name,
					phone_no:phone_no,
					company_address:company_address
				},
				success:function(data){
					$('input[name=supplier_name]').val('');
					$('input[name=company_address]').val('');
					$('input[name=phone_no]').val('');

					$('.close').click();
                    $("#supplier_id").empty();
                    $("#supplier_id").append(data);
				}
			});
		}

	});
	$("#addNewLocation").click(function(){
		var location_name = $('input[name=location_name]').val();
		var error = 0;
		if(location_name == '') {
			error = 1;
			$('input[name=location_name]').css('border', '1px solid #f00');
		} else {
			$('input[name=location_name]').css('border', '1px solid #ccc');			
		}
		if(error == 0) {
			$.ajax({
				url:baseURL+'dashboard/addNewLocationByAjax',
				method:"POST",
				data: {
					location_name:location_name
				},
				success:function(data){
					$('input[name=location_name]').val('');
				    $('.close').click();
                    $("#location_id").empty();
                    $("#location_id").append(data);
				}
			});
		}

	});

});



/////////////////////////////////////////////////
/////////////////ADDING FIELD
///////////////////////////////////////////////



