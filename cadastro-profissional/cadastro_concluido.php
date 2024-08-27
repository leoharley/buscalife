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
        <div class="col-xs-12">
            <div style="text-align:center">
                <img src="img/logo.png" style="margin-top:20px;width:10%;height: auto;">
                <h5><strong>BuscaQuemFaz.com.br</strong></h5>
            </div>            
        </div>
        <div class="col-xs-12">
            <h3>Cadastro concluído com sucesso!</h3>
            <p>Tudo certo! Agora é só aguardar os contatos da nossa inteligência artificial solicitando orçamentos e passando o contato de clientes.</p>
        </div>
        
                
<?php
include('inc/footer.php');
?>