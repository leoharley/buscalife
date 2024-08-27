<?php
include('inc/header.php');
?>
	<div class="jumbotron">
		<h4 class="text-center">
		<a href="whatsapp://send?text=<?= primeira_mensagem() ?>&phone=+55<?= display_whatsapp_profissional() ?>" target="_blank">LINK</a> para conversa no WhatsApp	
		</h4>
		<br/>
		<div class="form-group">
			<label for="atividade">Whatsapp:</label>
			<input type="text" name="whatsapp" id="whatsapp" tabindex="1" class="form-control"
				placeholder="Whatsapp" value="<?= display_whatsapp_profissional() ?>" required>
			<br><button class="btn btn-primary">Carregar	
		</div>
		<div class="form-group">
			<label for="atividade">Primeira mensagem:</label>
			<div id="primeira_mensagem">
			<?= display_primeira_mensagem(); ?>
			</div>
			<?php echo "<strong></strong>";//display_status_primeira_mensagem(); ?></span>
			<br><button class="btn btn-primary" id="btn_copiar_msg_1">Copiar para enviar</button>
		</div>
		<div class="form-group">
			<label for="atividade">Segunda mensagem:</label>
			<div id="segunda_mensagem">
			<?= display_segunda_mensagem(); ?>
			</div>
			<?php echo "<strong></strong>";//display_status_segunda_mensagem(); ?></span>
			<br><button class="btn btn-primary" id="btn_copiar_msg_2">Copiar para enviar</button>
		</div>
		<div class="form-group">
			<label for="atividade">Terceira mensagem:</label>
			<div id="terceira_mensagem">
			<?= display_terceira_mensagem(); ?>
			</div>
			<br><button class="btn btn-primary" id="btn_copiar_msg_3">Copiar para enviar</button>
		</div>
		<div class="form-group">
			<label for="atividade">Quarta mensagem:</label>
			<div id="quarta_mensagem">
			<?= display_quarta_mensagem(); ?>
			</div>
			<br><button class="btn btn-primary" id="btn_copiar_msg_4">Copiar para enviar</button>
		</div>
		<div class="form-group">
			<label for="atividade">Quinta mensagem:</label>
			<div id="quinta_mensagem">
			<?= display_quinta_mensagem(); ?>
			</div>
			<br><button class="btn btn-primary" id="btn_copiar_msg_5">Copiar para enviar</button>
		</div>
		<div class="form-group">
			<label for="atividade">Sexta mensagem:</label>
			<div id="sexta_mensagem">
			<?= display_sexta_mensagem(); ?>
			</div>
			<br><button class="btn btn-primary" id="btn_copiar_msg_6">Copiar para enviar</button>
		</div>


		<div class="form-group">
			<label for="conversa_whatsapp">Cole aqui a conversa que teve no WhatsApp:</label>
			<textarea id="conversa_whatsapp" name="conversa_whatsapp" rows="4" cols="40vh" class="form-control"
			style="resize:none">
			</textarea>
			<br><button class="btn btn-primary" id="btn_salvar_conversa_whats">Salvar</button>
		</div>
		<br/>		

	</div>
<?php
include('inc/footer.php');
?>

<script>
    $(document).ready(function(){
    $('#whatsapp').mask('(00) 00000-0000');
});

document.getElementById("btn_copiar_msg_1").onclick = function() {
	copyToClipboard(document.getElementById("primeira_mensagem"));
}

document.getElementById("btn_copiar_msg_2").onclick = function() {
	copyToClipboard(document.getElementById("segunda_mensagem"));
}

document.getElementById("btn_copiar_msg_3").onclick = function() {
	copyToClipboard(document.getElementById("terceira_mensagem"));
}

document.getElementById("btn_copiar_msg_4").onclick = function() {
	copyToClipboard(document.getElementById("quarta_mensagem"));
}

document.getElementById("btn_copiar_msg_5").onclick = function() {
	copyToClipboard(document.getElementById("quinta_mensagem"));
}

document.getElementById("btn_copiar_msg_6").onclick = function() {
	copyToClipboard(document.getElementById("sexta_mensagem"));
}

/**
* This will copy the innerHTML of an element to the clipboard
* @param element reference OR string
*/
function copyToClipboard(e) {
    var tempItem = document.createElement('input');

    tempItem.setAttribute('type','text');
    tempItem.setAttribute('display','none');
    
    let content = e;
    if (e instanceof HTMLElement) {
    		content = e.innerHTML;
    }
    
    tempItem.setAttribute('value',content);
    document.body.appendChild(tempItem);
    
    tempItem.select();
    document.execCommand('Copy');

    tempItem.parentElement.removeChild(tempItem);
}
</script>