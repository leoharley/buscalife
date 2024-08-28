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
	
	var addFaturamentoForm = $("#addFaturamento");
	
	var validator = addFaturamentoForm.validate({
		
		rules:{
			Ds_Faturamento: {required: true}
		}
	});
});
