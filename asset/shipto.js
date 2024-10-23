$(document).ready(function(){
	$("#addNew").click(function(){
		var ship_name1 = $('input[name=ship_name1]').val();
		var ship_address1 = $('input[name=ship_address1]').val();
		var ship_attention1 = $('input[name=ship_attention1]').val();
		var ship_telephone1 = $('input[name=ship_telephone1]').val();
		var ship_email1 = $('input[name=ship_email1]').val();
         
		var error = 0;

		if(ship_name1 == '') {
			error = 1;
			$('input[name=ship_name1]').css('border', '1px solid #f00');
		} else {
			$('input[name=ship_name1]').css('border', '1px solid #ccc');			
		}
		if(ship_address1 == '') {
			error = 1;
			$('input[name=ship_address1]').css('border', '1px solid #f00');
		} else {
			$('input[name=ship_address1]').css('border', '1px solid #ccc');			
		}

		if(ship_attention1 == '') {
			error = 1;
			$('input[name=ship_attention1]').css('border', '1px solid #f00');
		} else {
			$('input[name=ship_attention1]').css('border', '1px solid #ccc');			
		}


		if(error == 0) {
			$.ajax({
				url:baseURL+'dashboard/addNewShipToByAjax',
				method:"POST",
				data: {
					ship_name1:ship_name1,
					ship_address1:ship_address1,
					ship_attention1:ship_attention1,
					ship_telephone1:ship_telephone1,
					ship_email1:ship_email1
				},
				success:function(data){
					$('input[name=ship_name1]').val('');
					$('input[name=ship_address1]').val('');
					$('input[name=ship_attention1]').val('');
					$('input[name=ship_telephone1]').val('');
					$('input[name=ship_email1]').val('');

					$('.close').click();
                    $("#ship_id").empty();
                    $("#ship_id").append(data);
                    $('#ship_name').val(ship_name1);
		            $('#ship_address').val(ship_address1);
		            $('#ship_attention').val(ship_attention1);
		            $("#ship_telephone").val(ship_telephone1);
		            $("#ship_email").val(ship_email1);
				}
			});
		}

	});

$("#addNewCom").click(function(){
		var courier_company1 = $('input[name=courier_company1]').val();
		var courier_address1 = $('input[name=courier_address1]').val();
		var error = 0;
		if(courier_company1 == '') {
			error = 1;
			$('input[name=courier_company1]').css('border', '1px solid #f00');
		} else {
			$('input[name=courier_company1]').css('border', '1px solid #ccc');			
		}

		if(error == 0) {
			$.ajax({
				url:baseURL+'dashboard/addNewCourToByAjax',
				method:"POST",
				data: {
					courier_company1:courier_company1,
					courier_address1:courier_address1
				},
				success:function(data){
					$('input[name=courier_company1]').val('');
					$('input[name=courier_address1]').val('');
					$('.close').click();
                    $("#courier_company").empty();
                    $("#courier_company").append(data);
				}
			});
		}

	});
$("#addNewCom2").click(function(){
		var courier_company1 = $('input[name=courier_company3]').val();
		var courier_address1 = $('input[name=courier_address3]').val();
		var error = 0;
		if(courier_company1 == '') {
			error = 1;
			$('input[name=courier_company3]').css('border', '1px solid #f00');
		} else {
			$('input[name=courier_company3]').css('border', '1px solid #ccc');			
		}

		if(error == 0) {
			$.ajax({
				url:baseURL+'dashboard/addNewCourToByAjax',
				method:"POST",
				data: {
					courier_company1:courier_company1,
					courier_address1:courier_address1
				},
				success:function(data){
					$('input[name=courier_company1]').val('');
					$('input[name=courier_address1]').val('');
					$('.close').click();
                    $("#courier_company2").empty();
                    $("#courier_company2").append(data);
				}
			});
		}

	});

});



/////////////////////////////////////////////////
/////////////////ADDING FIELD
///////////////////////////////////////////////



