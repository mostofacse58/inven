$(document).ready(function () {
    
   

$('#search-content').on('keyup',function() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("search-content");
    filter = input.value.toUpperCase();
    ul = document.querySelector('.sidebar');
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    });

});