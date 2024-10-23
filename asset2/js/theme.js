//[Master Javascript]

//Project:	Lawyer - Onepage Html Responsive Template
//Version:	1.1
//Last change:	14/02/2017 [fixed bug]
//Primary use:	Lawyer - Onepage Html Responsive Template 


//theme script here

$(document).ready(function(){
    "use strict"; // Start of use strict

 

    // Highlight the top nav as scrolling occurs
    $('body').scrollspy({
        target: '.navbar-fixed-top'
    });

	// Closes the Responsive Menu on Menu Item Click
	$('.navbar-collapse ul li a').on('click', function(event) {
		$(this).closest('.collapse').collapse('toggle');
	});



    // Initialize and Configure Scroll Reveal Animation
	
   	    
	
	

	
	
	function toggleChevron(e) {
    $(e.target)
        .prev('.panel-heading')
        .find("i.indicator")
        .toggleClass(' fa-plus fa-minus');
	}
	$('#accordion').on('hidden.bs.collapse', toggleChevron);
	$('#accordion').on('shown.bs.collapse', toggleChevron);
   
}); // End of use strict
