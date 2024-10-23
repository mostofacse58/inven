$(document).ready(function(){

	$("#addNewGuest").click(function(){
		var guest_name = $('input[name=guest_name]').val();
		var passport_no = $('input[name=passport_no]').val();
		var guest_type = $('#guest_type').val();
		var mobile_no = $('input[name=mobile_no]').val();
		var email_address = $('input[name=email_address]').val();
         
		var error = 0;

		if(guest_name == '') {
			error = 1;
			$('input[name=guest_name]').css('border', '1px solid #f00');
		} else {
			$('input[name=guest_name]').css('border', '1px solid #ccc');			
		}

		if(guest_type == '') {
			error = 1;
			$('select[name=guest_type]').css('border', '1px solid #f00');
		} else {
			$('select[name=guest_type]').css('border', '1px solid #ccc');			
		}

		if(error == 0) {
			$.ajax({
				url:baseURL+'flightschedule/addNewGuestByAjax',
				method:"POST",
				data: {
					guest_name:guest_name,
					passport_no:passport_no,
					guest_type:guest_type,
					mobile_no:mobile_no,
					email_address:email_address
				},
				success:function(data){
					$('input[name=guest_name]').val('');
					$('input[name=passport_no]').val('');
					$('select[name=guest_type]').val('');
					$('input[name=mobile_no]').val('');

					$('.close').click();
                    $("#guest_id").empty();
                    $("#guest_id").append(data);
				}
			});
		}

	});

});



/////////////////////////////////////////////////
/////////////////ADDING FIELD
///////////////////////////////////////////////



