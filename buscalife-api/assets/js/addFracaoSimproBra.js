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
	
	var addFracaoSimproBraForm = $("#addFracaoSimproBra");
	
	var validator = addFracaoSimproBraForm.validate({
		
		rules:{
			Ds_Faturamento: {cnpj: true, required: true}
		},
		messages:{
			Ds_Faturamento: { cnpj: 'CNPJ inválido'}
		}
	});
});
