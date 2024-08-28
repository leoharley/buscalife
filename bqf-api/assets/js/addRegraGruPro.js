/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addRegraGruProForm = $("#addRegraGruPro");
	
	var validator = addRegraGruProForm.validate({
		
		rules:{
			Perc_Pago: {required: true}
		}
	});
});
