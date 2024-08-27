<?php
include('inc/header_redirecionamento.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        padding: 20px;
        text-align: center;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    .btn:hover {
        background-color: #0056b3;
    }
    .alert {
        padding: 20px;
        color: white;
        background: #04AA6D !important;
        border: 1px solid #808080;
        }
    #copiado_msg {
        animation: pulse 2s linear infinite;
        position:relative;
        display:none;
        }    
</style>
        <h3>Finalizar cadastro</h3>
        <p>Tudo certo! Agora só falta o pagamento da taxa do certificado para ter o seu cadastro verificado. O seu certificado será enviado para o seu whatsapp em até 24 horas após o pagamento.
            Caso não seja possível a emissão, o valor da taxa será estornado automaticamente em até 01 (um) dia útil.
        </p>
        <a href=# class="btn" data-toggle="modal" data-target="#exampleModal">Pagar taxa do certificado (PIX)</a>
        <br/>
        <br/>
        <a href=# class="btn">Pagar taxa do certificado (Cartão Crédito)</a>
        <br/><br/>
                

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">      
            <div class="modal-body">
                <div class="form-group">
                    <h4>Pix Copia e Cola:</h4>
                    <textarea id="pix_copia_cola" name="pix_copia_cola" class="form-control"
                    style="margin-bottom:5px!important;resize:none;background:white!important;height:80px" readonly>00020126590014br.gov.bcb.pix0127contato@buscaquemfaz.com.br0206dasdas520400005303986540530.005802BR5901N6001C62070503***63043A4D</textarea>
                    <button class="btn-primary btn-sm" sytle="padding:1px!important" id="btn_copiar_pix"><i class="fa fa-copy" style="margin-right:10px"></i>Copiar</button>
                    <div id="copiado_msg" style="color:green">Copiado</div><br/><br/>
                    <img src="../images/qrcode_pix.png" width="40%" height="auto">
                    <h4>Chave: certificado@buscaquemfaz.com.br</h4>
                    <br/>
                    <small>O pagamento 
		        </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>        
            </div>
            </div>
        </div>
    </div>


<?php
include('inc/footer.php');
?>
<script>
document.getElementById("btn_copiar_pix").onclick = function() {
	copytext("00020126590014br.gov.bcb.pix0127contato@buscaquemfaz.com.br0206dasdas520400005303986540530.005802BR5901N6001C62070503***63043A4D");
    document.getElementById("copiado_msg").style.display = "block";
    document.getElementById("copiado_msg").style.visibility = "visible";
    setTimeout(function(){ document.getElementById("copiado_msg").style.visibility = "hidden"}, 1500);
}

/**
* This will copy the innerHTML of an element to the clipboard
* @param element reference OR string
*/
function copytext(text) {
    var textField = document.createElement('textarea');
    textField.innerText = text;
    document.body.appendChild(textField);
    textField.select();
    textField.focus(); //SET FOCUS on the TEXTFIELD
    document.execCommand('copy');
    textField.remove();
    console.log('should have copied ' + text);
}
</script>    