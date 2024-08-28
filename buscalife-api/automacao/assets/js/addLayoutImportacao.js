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
	
	var addLayoutImportacaoForm = $("#addLayoutImportacao");
	
	var validator = addLayoutImportacaoForm.validate({
		
		rules:{
			Ds_LayoutImportacao: {required: true}
		},
		messages:{
		}
	});
});
