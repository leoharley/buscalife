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
	
	var addEmpresaForm = $("#addEmpresa");
	
	var validator = addEmpresaForm.validate({
		
		rules:{
			fname :{ required : true },
			email : { required : true, email : true, remote : { url : baseURL + "checkEmailExists", type :"post"} },
			Senha : { required : true },
			resenha : {required : true, equalTo: "#password"},
			mobile : { required : true, digits : true },
			role : { required : true, selected : true},
			CNPJ: {cnpj: true, required: true}
		},
		messages:{
			fname :{ required : "Campo obrigatório" },
			email : { required : "Campo obrigatório", email : "Please enter valid email address", remote : "Email already taken" },
			Senha : { required : "Campo obrigatório" },
			resenha : {required : "Campo obrigatório", equalTo: "Senha não é igual" },
			mobile : { required : "Campo obrigatório", digits : "Please enter numbers only" },
			role : { required : "Campo obrigatório", selected : "Please select atleast one option" },
			CNPJ: { cnpj: 'CNPJ inválido'}			
		}
	});
});
