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
	
	var addExcecaoValoresForm = $("#addExcecaoValores");
	
	var validator = addExcecaoValoresForm.validate({
		
		rules:{
			Ds_ExcValores: {required: true}
		}
	});
});
