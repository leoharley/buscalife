<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Busca Quem Faz | Os Melhores Profissionais Localizados por IA</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0">
        <meta name="description" content="A conversational AI system that listens, learns, and challenges">
        <meta property="og:title" content="Busca Quem Faz">
        <meta property="og:image" content="">
        <meta property="og:description" content="A conversational AI system that listens, learns, and challenges">
        <meta property="og:url" content="https://chat.acy.dev">
        <link rel="stylesheet" href="css/style.css">

        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="img/favicon.ico" type="image/x-icon">
        <script src="js/icons.js"></script>
        
        <link rel="manifest" href="img/site.webmanifest">
        <script src="script.js?ver=1.2" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/markdown-it@latest/dist/markdown-it.min.js"></script>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@latest/build/styles/base16/dracula.min.css">
        <script>
            const user_image        = `<img src="img/user.png" alt="User Avatar">`;
            const gpt_image         = `<img src="img/gpt.png" alt="GPT Avatar">`;
        </script>
        <!-- Google Fonts Link For Icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        <style>
            .alert {
            position: relative;
            }
            .alert .glyphicon {
            position: absolute;
            right: 16px;
            top: 19px;
            }
            
            .hljs {
                color: #e9e9f4;
                background: #28293629;
                border-radius: var(--border-radius-1);
                border: 1px solid var(--blur-border);
                font-size: 15px;
            }

            #message-input {
                margin-right: 30px;
                height: 80px;
            }

            #message-input::-webkit-scrollbar {
                width: 5px;
            }

            /* Track */
            #message-input::-webkit-scrollbar-track {
                background: #f1f1f1; 
            }
            
            /* Handle */
            #message-input::-webkit-scrollbar-thumb {
                background: #c7a2ff; 
            }

            /* Handle on hover */
            #message-input::-webkit-scrollbar-thumb:hover {
                background: #8b3dff; 
            }

            
            /* The Modal (background) */
            .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: -80px;
            width: 100%; /* Full width */
            height: 120%!important; /* Full height */
            padding-bottom: 40px!important;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.6); /* Black w/ opacity */
            }

            /* Modal Content */
            .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            }

            /* The Close Button */
            .close {
            color: #aaaaaa;
            font-size: 28px;
            font-weight: bold;
            left:98%;
            top:-18px;
            }

            .close:hover,
            .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
            }

            .close2 {
            color: #aaaaaa;
            font-size: 28px;
            font-weight: bold;
            left:98%;
            top:-18px;
            }

            .close2:hover,
            .close2:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
            }

            .close3 {
            color: #aaaaaa;
            font-size: 28px;
            font-weight: bold;
            left:98%;
            top:-18px;
            }

            .close3:hover,
            .close3:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
            }
        </style>

        <script src="js/highlight.min.js"></script>
        <script src="js/highlightjs-copy.min.js"></script>
        <script>window.conversation_id = `{{chat_id}}`</script>
    </head>
    
    <body> 

        <div class="floating-button-menu menu-off">
            <div class="floating-button-menu-links">
              <a href=# id="faq">FAQ - Perguntas Frequentes</a>
              <a href=# id="termos_uso_2">Termos de Uso</a>
              <a href=# id="politica_privacidade_2">Política de Privacidade</a>
              <a href="#four">Ajuda</a>
            </div>
              <div class="floating-button-menu-label">?</div>
          </div>
          <div class="floating-button-menu-close"></div>     
          
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
        <script  src="js/floatmenu.js"></script>


        <div class="row">
            <div class="box conversations">
                <div class="top">
                    <button class="new_convo" onclick="new_conversation()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24" class="icon-md" style="color:white!important"><path d="M15.673 3.913a3.121 3.121 0 1 1 4.414 4.414l-5.937 5.937a5 5 0 0 1-2.828 1.415l-2.18.31a1 1 0 0 1-1.132-1.13l.311-2.18A5 5 0 0 1 9.736 9.85zm3 1.414a1.12 1.12 0 0 0-1.586 0l-5.937 5.937a3 3 0 0 0-.849 1.697l-.123.86.86-.122a3 3 0 0 0 1.698-.849l5.937-5.937a1.12 1.12 0 0 0 0-1.586M11 4A1 1 0 0 1 10 5c-.998 0-1.702.008-2.253.06-.54.052-.862.141-1.109.267a3 3 0 0 0-1.311 1.311c-.134.263-.226.611-.276 1.216C5.001 8.471 5 9.264 5 10.4v3.2c0 1.137 0 1.929.051 2.546.05.605.142.953.276 1.216a3 3 0 0 0 1.311 1.311c.263.134.611.226 1.216.276.617.05 1.41.051 2.546.051h3.2c1.137 0 1.929 0 2.546-.051.605-.05.953-.142 1.216-.276a3 3 0 0 0 1.311-1.311c.126-.247.215-.569.266-1.108.053-.552.06-1.256.06-2.255a1 1 0 1 1 2 .002c0 .978-.006 1.78-.069 2.442-.064.673-.192 1.27-.475 1.827a5 5 0 0 1-2.185 2.185c-.592.302-1.232.428-1.961.487C15.6 21 14.727 21 13.643 21h-3.286c-1.084 0-1.958 0-2.666-.058-.728-.06-1.369-.185-1.96-.487a5 5 0 0 1-2.186-2.185c-.302-.592-.428-1.233-.487-1.961C3 15.6 3 14.727 3 13.643v-3.286c0-1.084 0-1.958.058-2.666.06-.729.185-1.369.487-1.961A5 5 0 0 1 5.73 3.545c.556-.284 1.154-.411 1.827-.475C8.22 3.007 9.021 3 10 3A1 1 0 0 1 11 4"></path></svg>
                        <span>Nova conversa</span>
                    </button>
                </div>
                <div class="top">

                    <?php 
                    if (!isset($_SESSION['email'])) {
                        echo '
                        <button class="registro_btn" id="registro_btn" onclick="go_register()">
                        <span>Cadastre-se </span>
                        </button>
                    
                        <button class="entrar_btn" id="entrar_btn" onclick="go_login()">
                            <span>Edsntrar</span>
                        </button>
                        ';
                    } else {
                        echo '

                        <div class="alert alert-success alert-message" role="alert" style="text-align:center;">
                        <small>
                        <p>
                           '.$_SESSION['email'].'<br/><a href="login/sair.php">SAIR</a></small>
                        </p>
                        </small>
                        </div>

                        ';
                    }
                    
                    
                    ?>
                    


                </div>
            </div>
            <div class="conversation disable-scrollbars">

                <div class="stop_generating stop_generating-hidden">
                    <button id="cancelButton">
                        <span>Stop Generating</span>
                        <i class="fa-regular fa-stop"></i>
                    </button>
                </div>
                
                <div class="chat-container"></div>
    
                <!-- Typing container -->
                <div class="typing-container">
                    <div class="typing-content">
                        <div class="typing-textarea">
                        <textarea id="chat-input" name="chat-input" spellcheck="false" placeholder="Me diz que serviço está precisando?" required></textarea>
                        <span name="location-input"></span>

                        <span id="send-btn" class="material-symbols-rounded">send</span>
                        </div>
                        <div class="typing-controls">
                        <span id="theme-btn" class="material-symbols-rounded">light_mode</span>
                        <span id="delete-btn" class="material-symbols-rounded">delete</span>
                    </div>
                    
                    <div class="msg_termos">
                        <p>Ao enviar mensagens, você concorda com os nossos <a href=# id="termos_uso">Termos</a> e leu a nossa <a href=# id="politica_privacidade">Política de Privacidade</a>.</p>
                    </div>
                    
                </div>
                
        </div>

        <div class="mobile-sidebar">
            <i class="fa-solid fa-bars"></i>
        </div>

        <!-- The Modal -->
        <div id="modal_termos_de_uso" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
            <span class="close">&times;</span>
            <div style="color:#808080;margin-top:-20px">

            <strong><h3>Termos de Uso do "Busca Quem Faz"</h3></strong><br/>

            Bem-vindo aos Termos de Uso do Busca Quem Faz. Este documento regula o uso dos nossos serviços online. Ao acessar ou usar nosso site, você concorda com estes termos. Leia atentamente antes de prosseguir.<br/><br/>

            <strong>1. Descrição do Serviço</strong>

            <p style="margin-left:20px">a. Nosso site permite que usuários indiquem e encontrem profissionais em diferentes áreas de atuação.</p>
            <p style="margin-left:20px">b. Não somos responsáveis pela qualidade dos serviços prestados pelos profissionais listados.</p>
            
            <br/>
            <strong>2. Cadastro de Usuário</strong>

            <p style="margin-left:20px">a. Para utilizar nosso serviço, você deve se cadastrar fornecendo informações precisas e completas.</p>
            <p style="margin-left:20px">b. Você é responsável por manter a confidencialidade de sua conta e senha.</p>
            
            <br/>
            <strong>3. Uso Permitido</strong>

            <p style="margin-left:20px">a. Você concorda em usar nosso site apenas para fins legais e de acordo com estes termos.</p>
            <p style="margin-left:20px">b. Não utilize o site de forma que possa danificar, desabilitar, sobrecarregar ou prejudicar o funcionamento do site.</p>

            <br/>
            <strong>4. Indicações e Responsabilidade</strong>

            <p style="margin-left:20px">a. As indicações de profissionais são fornecidas pelos usuários e não garantimos sua precisão ou atualidade.</p>
            <p style="margin-left:20px">b. Você é responsável por verificar a qualificação e a adequação dos profissionais antes de contratá-los.</p>
            
            <br/>
            <strong>5. Propriedade Intelectual</strong>

            <p style="margin-left:20px">a. Todo o conteúdo do site, incluindo texto, gráficos, logotipos, ícones e imagens, são de nossa propriedade ou licenciados para nós.</p>
            <p style="margin-left:20px">b. Você não tem permissão para reproduzir, distribuir ou criar obras derivadas do conteúdo sem nossa autorização prévia por escrito.</p>
            
            <br/>
            <strong>6. Limitação de Responsabilidade</strong>

            <p style="margin-left:20px">a. Em nenhuma circunstância seremos responsáveis por danos indiretos, incidentais, especiais, consequentes ou punitivos decorrentes do uso do site.</p>
            
            <br/>
            <strong>7. Modificações</strong>

            <p style="margin-left:20px">a. Reservamo-nos o direito de modificar ou encerrar o serviço a qualquer momento, sem aviso prévio.</p>
            <p style="margin-left:20px">b. Podemos modificar estes termos a qualquer momento, e as alterações entrarão em vigor imediatamente após sua publicação no site.</p>
            
            <br/>
            <strong>8. Disposições Gerais</strong>

            <p style="margin-left:20px">a. Estes termos constituem o acordo integral entre você e nós em relação ao uso do site.</p>
            <p style="margin-left:20px">b. Qualquer falha nossa em exercer ou aplicar qualquer direito ou disposição destes termos não constituirá uma renúncia a tal direito ou disposição.</p>
            
            <br/>
            <p>Ao usar nosso site, você concorda com estes Termos de Uso. Se não concordar com algum dos termos, por favor, não use o site.</p>

            </div>
            </div>
        </div>

        <!-- The Modal -->
        <div id="modal_politica_de_privacidade" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
            <span class="close2">&times;</span>
            <div style="color:#808080;margin-top:-20px">

            <strong><h3>Política de Privacidade do "Busca Quem Faz"</h3></strong><br/>

            Esta Política de Privacidade descreve como nós do Busca Quem Faz, coletamos, usamos e protegemos suas informações pessoais quando você utiliza nosso site de indicação de profissionais. Valorizamos sua privacidade e estamos comprometidos em proteger seus dados pessoais.<br/><br/>

            <strong>1. Informações Coletadas</strong>

            <p style="margin-left:20px">a. Informações Fornecidas por Você: Coletamos informações que você nos fornece voluntariamente ao se cadastrar no site, como nome, endereço de e-mail, telefone, cidade e outras informações relevantes.</p>
            <p style="margin-left:20px">b. Informações de Uso: Coletamos automaticamente certas informações sobre seu uso do site, incluindo seu endereço IP, tipo de navegador, páginas visitadas, tempo gasto em cada página e dados de dispositivos utilizados para acessar o site.</p>
            
            <br/>
            <strong>2. Uso das Informações</strong>

            <p style="margin-left:20px">a. Utilizamos suas informações para operar e manter o site, incluindo o processamento de suas indicações de profissionais.</p>
            <p style="margin-left:20px">b. Podemos utilizar suas informações para entrar em contato com você sobre o seu uso do site, enviar atualizações sobre nossos serviços ou responder a suas perguntas e solicitações.</p>
            <p style="margin-left:20px">c. Utilizamos informações de uso para melhorar o desempenho do site, personalizar sua experiência e realizar análises para fins internos.</p>
            
            <br/>
            <strong>3. Compartilhamento de Informações</strong>

            <p style="margin-left:20px">a. Não vendemos, alugamos ou negociamos suas informações pessoais com terceiros para fins de marketing sem seu consentimento explícito.</p>
            <p style="margin-left:20px">b. Podemos compartilhar suas informações pessoais com prestadores de serviços que nos ajudam a operar o site ou realizar funções em nosso nome, como processamento de pagamentos ou envio de e-mails.</p>
            <p style="margin-left:20px">c. Podemos divulgar suas informações pessoais se formos obrigados por lei ou se acreditarmos que tal divulgação é necessária para proteger nossos direitos legais, segurança ou a segurança de outros.</p>

            <br/>
            <strong>4. Segurança das Informações</strong>

            <p style="margin-left:20px">a. Implementamos medidas de segurança adequadas para proteger suas informações pessoais contra acesso não autorizado, alteração, divulgação ou destruição.</p>
            <p style="margin-left:20px">b. No entanto, nenhum método de transmissão pela Internet ou método de armazenamento eletrônico é completamente seguro. Portanto, não podemos garantir segurança absoluta das informações.</p>
            
            <br/>
            <strong>5. Seus Direitos</strong>

            <p style="margin-left:20px">a. Você tem o direito de acessar, corrigir, atualizar ou excluir suas informações pessoais a qualquer momento.</p>
            <p style="margin-left:20px">b. Se desejar exercer esses direitos ou tiver dúvidas sobre nossas práticas de privacidade, entre em contato conosco através dos métodos descritos abaixo.</p>
            
            <br/>
            <strong>6. Alterações nesta Política</strong>

            <p style="margin-left:20px">a. Podemos atualizar esta Política de Privacidade periodicamente para refletir mudanças em nossas práticas de informação. Recomendamos revisar esta página regularmente para estar ciente de quaisquer atualizações.</p>
            
            <br/>
            <strong>7. Contato</strong>

            <p style="margin-left:20px">Se você tiver perguntas, preocupações ou sugestões sobre esta Política de Privacidade ou nossas práticas de privacidade, entre em contato conosco através do e-mail: atendimento@buscaquemfaz.com.br</p>
                        
            <br/>            
            <p>Esta Política de Privacidade entra em vigor a partir da data de publicação e se aplica a todas as informações coletadas através do nosso site.</p>

            </div>
            </div>
        </div>


        <!-- The Modal -->
        <div id="modal_faq" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
            <span class="close3">&times;</span>
            <div style="color:#808080;margin-top:-20px">

            <strong><h3>Perguntas Frequentes (FAQ) - "Busca Quem Faz"</h3></strong><br/>

            <strong>1. Como funciona o serviço?</strong>

            <li style="margin-left:20px">O Busca Quem Faz consiste de sistema com inteligência artificial onde permite que usuários encontrem profissionais em diversas áreas, como saúde, serviços domésticos, tecnologia, entre outros. Você pode literalmente conversar com o sistema para encontrar um profissional pelo nome, por serviços que o profissional já fez, por categoria de serviços, pode saber também o grau de recomendação dos prestadores de serviços, valores do serviços e disponibilidade de horário.</li>
            
            <br/>
            <strong>2. Quem pode utilizar o site?</strong>

            <li style="margin-left:20px">O site está disponível para qualquer pessoa que deseje encontrar profissionais qualificados em sua área de atuação.</li>
            
            <br/>
            <strong>3. Os profissionais listados são verificados?</strong>

            <li style="margin-left:20px">Os profissionais listados quando o cliente procura por uma categoria de serviço obrigatoriamente possuem certificado de verificação composto de diversos tipos de "nada-consta" emitidos recentemente. Se você buscar pelo nome de um profissional específico, este não necessariamente possui o certificado de verificação.</li>

            <br/>
            <strong>4. Como são as avaliações dos profissionais?</strong>

            <li style="margin-left:20px">A nossa inteligência artificial faz o cruzamento de diversas fontes para calcular o grau de recomendação dos profissionais, entre elas o feedback espontâneo dos clientes, as diversas informações obtidas pelos algoritmos que geram os certificados de verificação, e o retorno das pesquisas automáticas enviadas para os clientes que foram atendidos pelo profissional.</li>
            
            <br/>
            <strong>5. O site cobra alguma taxa para os clientes utilizarem o serviço?</strong>

            <li style="margin-left:20px">Não cobramos taxas dos usuários para acessar ou utilizar o site de indicação de profissionais. É um serviço gratuito para ajudar na conexão entre usuários e profissionais.</li>
                    
            <br/>
            <strong>6. Como faço para entrar em contato com o suporte do site?</strong>

            <li style="margin-left:20px">Para suporte ou dúvidas adicionais, você pode entrar em contato conosco conversando diretamente com a nossa inteligência artificial ou pelo e-mail atendimento@buscaquemfaz.com.br. Estamos disponíveis para ajudar com qualquer questão relacionada ao uso do nosso serviço.</li>
            
            <br/>
            <strong>7. O site protege minhas informações pessoais?</strong>

            <li style="margin-left:20px">Sim, valorizamos sua privacidade. Todas as informações pessoais são tratadas de acordo com nossa Política de Privacidade, garantindo medidas de segurança adequadas para proteger seus dados contra acesso não autorizado ou uso indevido.</li>
                        
            <br/>
            <strong>8. Como posso saber se o site é confiável?</strong>

            <li style="margin-left:20px">Nosso compromisso com a transparência, segurança e facilidade de uso reflete-se em nossas práticas operacionais e na maneira como tratamos suas informações. Além disso, estamos abertos ao feedback dos usuários para continuamente melhorar nossos serviços.</li>
            
            <br/>
            <p>Esperamos que estas respostas tenham esclarecido suas dúvidas. Se você tiver mais perguntas ou precisar de assistência adicional, não hesite em nos contatar. Estamos aqui para ajudar!</p>

            </div>
            </div>
        </div>

    </body>
</html>