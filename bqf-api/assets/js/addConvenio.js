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
	
	var addConvenioForm = $("#addConvenio");
	
	var validator = addConvenioForm.validate({
		
		rules:{
			CNPJ_Convenio: {cnpj: true, required: true}
		},
		messages:{
			CNPJ_Convenio: { cnpj: 'CNPJ inválido'}
		}
	});
});
