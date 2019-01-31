var successPOP = "#add_success";
var slide2 = {transition: "slideup"};

//AJAX to add new entryand validate the Foodname if entry
$(document).ready(function() {
    $("#submit_entry").click(function(){
 
        var formData = $("#add_form").serialize();
		var slide = {transition: "slideup"};
		var x = document.getElementById('food');
		var invalidPop = "#invalid";
		var slide = {transition: "slideup"};
		
		if (x.value === "" || x.value === null) {
        $.mobile.changePage(invalidPop, slide);
        return false
		}else{
		
			$.ajax({
				type: "POST",
				url: "add_new_entry.php",
				cache: false,
				data: formData,
				success: addSuccess
			});
 
			return false;
		}
    });
 
    $("#cancel").click(function(){
        resetADDentryFields();
    });
 
    $("#refresh").click(function(){
        location.reload();
    });
});

//Pop up success window ------------
function addSuccess(){
	$.mobile.changePage(successPOP, slide2);
	resetADDentryFields();
}

//reset Add entry txt fields -------

function resetADDentryFields(){
	$("#food").val("");
	$("#ingreed").val("");
	$("#instruct").val("");
}
