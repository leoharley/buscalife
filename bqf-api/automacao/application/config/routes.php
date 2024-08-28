<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = "login";
$route['404_override'] = 'login/error';


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';

$route['welcome'] = 'login/welcome';

$route['acesso'] = 'login/welcome';

$route['escolheEmpresa'] = 'login/escolheEmpresa';

/*********** ROUTES DE CADASTRO *******************/
$route['cadastroUsuario/:any/:any'] = "cadastro/cadastroUsuario/$1/$2";
$route['cadastroUsuario/:any'] = "cadastro/cadastroUsuario/$1";

$route['cadastroEmpresa/:any/:any'] = "cadastro/cadastroEmpresa/$1/$2";
$route['cadastroEmpresa/:any'] = "cadastro/cadastroEmpresa/$1";

$route['cadastroPerfil/:any/:any'] = "cadastro/cadastroPerfil/$1/$2";
$route['cadastroPerfil/:any'] = "cadastro/cadastroPerfil/$1";

$route['cadastroTelas/:any/:any'] = "cadastro/cadastroTelas/$1/$2";
$route['cadastroTelas/:any'] = "cadastro/cadastroTelas/$1";

$route['cadastroPermissao/:any/:any'] = "cadastro/cadastroPermissao/$1/$2";
$route['cadastroPermissao/:any'] = "cadastro/cadastroPermissao/$1";

$route['cadastroUsuarioEmpresa/:any/:any'] = "cadastro/cadastroUsuarioEmpresa/$1/$2";
$route['cadastroUsuarioEmpresa/:any'] = "cadastro/cadastroUsuarioEmpresa/$1";

/*********** ROUTES PARA AÇÕES DA TELA USUÁRIO *******************/
$route['adicionaUsuario'] = "cadastro/adicionaUsuario";
$route['editaUsuario'] = "cadastro/editaUsuario";
$route['apagaUsuario/:any'] = "cadastro/apagaUsuario/$1";

/*********** ROUTES PARA AÇÕES DA TELA EMPRESA *******************/
$route['adicionaEmpresa'] = "cadastro/adicionaEmpresa";
$route['editaEmpresa'] = "cadastro/editaEmpresa";
$route['apagaEmpresa/:any'] = "cadastro/apagaEmpresa/$1";

/*********** ROUTES PARA AÇÕES DA TELA PERFIL *******************/
$route['adicionaPerfil'] = "cadastro/adicionaPerfil";
$route['editaPerfil'] = "cadastro/editaPerfil";
$route['apagaPerfil/:any'] = "cadastro/apagaPerfil/$1";

/*********** ROUTES PARA AÇÕES DA TELA TELAS *******************/
$route['editaTelas'] = "cadastro/editaTelas";

/*********** ROUTES PARA AÇÕES DA TELA PERMISSAO *******************/
$route['editaPermissao'] = "cadastro/editaPermissao";

/*********** ROUTES PARA AÇÕES DA TELA USUÁRIO/EMPRESA *******************/
$route['adicionaUsuarioEmpresa'] = "cadastro/adicionaUsuarioEmpresa";
$route['editaUsuarioEmpresa'] = "cadastro/editaUsuarioEmpresa";
$route['apagaUsuarioEmpresa/:any'] = "cadastro/apagaUsuarioEmpresa/$1/$2";


/*********** ROUTES DO PRINCIPAL *******************/
$route['principalConvenio/:any/:any'] = "principal/principalConvenio/$1/$2";
$route['principalConvenio/:any'] = "principal/principalConvenio/$1";

$route['principalPlano/:any/:any'] = "principal/principalPlano/$1/$2";
$route['principalPlano/:any'] = "principal/principalPlano/$1";

$route['principalFaturamento/:any/:any'] = "principal/principalFaturamento/$1/$2";
$route['principalFaturamento/:any'] = "principal/principalFaturamento/$1";

$route['principalRegra/:any/:any'] = "principal/principalRegra/$1/$2";
$route['principalRegra/:any'] = "principal/principalRegra/$1";

$route['principalRegraGruPro/:any/:any'] = "principal/principalRegraGruPro/$1/$2";
$route['principalRegraGruPro/:any'] = "principal/principalRegraGruPro/$1";

$route['principalIndice/:any/:any'] = "principal/principalIndice/$1/$2";
$route['principalIndice/:any'] = "principal/principalIndice/$1";

$route['principalIndiceGrupoPro/:any/:any'] = "principal/principalIndiceGrupoPro/$1/$2";
$route['principalIndiceGrupoPro/:any'] = "principal/principalIndiceGrupoPro/$1";

$route['principalRegraProibicao/:any/:any'] = "principal/principalRegraProibicao/$1/$2";
$route['principalRegraProibicao/:any'] = "principal/principalRegraProibicao/$1";

$route['principalFracaoSimproBra/:any/:any'] = "principal/principalFracaoSimproBra/$1/$2";
$route['principalFracaoSimproBra/:any'] = "principal/principalFracaoSimproBra/$1";

$route['principalFaturamentoItem/:any/:any'] = "principal/principalFaturamentoItem/$1/$2";
$route['principalFaturamentoItem/:any'] = "principal/principalFaturamentoItem/$1";

$route['principalUnidade/:any/:any'] = "principal/principalUnidade/$1/$2";
$route['principalUnidade/:any'] = "principal/principalUnidade/$1";

$route['principalExcecaoValores/:any/:any'] = "principal/principalExcecaoValores/$1/$2";
$route['principalExcecaoValores/:any'] = "principal/principalExcecaoValores/$1";

$route['consultaValoresTabela/:any/:any/:any'] = "principal/consultaValoresTabela/$1/$2/$3";


/*********** ROUTES DO PACOTE *******************/
$route['pacotePacote/:any/:any'] = "pacote/pacotePacote/$1/$2";
$route['pacotePacote/:any'] = "pacote/pacotePacote/$1";

$route['pacoteExcecaoPacote/:any/:any'] = "pacote/pacoteExcecaoPacote/$1/$2";
$route['pacoteExcecaoPacote/:any'] = "pacote/pacoteExcecaoPacote/$1";

$route['pacoteSubstancia/:any/:any'] = "pacote/pacoteSubstancia/$1/$2";
$route['pacoteSubstancia/:any'] = "pacote/pacoteSubstancia/$1";

$route['pacoteSetor/:any/:any'] = "pacote/pacoteSetor/$1/$2";
$route['pacoteSetor/:any'] = "pacote/pacoteSetor/$1";

$route['pacoteTela/:any/:any'] = "pacote/pacoteTela/$1/$2";
$route['pacoteTela/:any'] = "pacote/pacoteTela/$1";

$route['pacoteExcecaoProcedimento/:any/:any'] = "pacote/pacoteExcecaoProcedimento/$1/$2";
$route['pacoteExcecaoProcedimento/:any'] = "pacote/pacoteExcecaoProcedimento/$1";


/*********** ROUTES DA IMPORTAÇÃO *******************/
$route['importacaoFatItem'] = "importacao/importacaoFatItem";
$route['importaFatItem'] = "importacao/importaFatItem";
$route['apagaImportacaoFatItem/:any'] = "importacao/apagaImportacaoFatItem/$1";

$route['importacaoGrupoPro'] = "importacao/importacaoGrupoPro";
$route['importaGrupoPro'] = "importacao/importaGrupoPro";
$route['apagaImportacaoGrupoPro/:any'] = "importacao/apagaImportacaoGrupoPro/$1";

$route['importacaoProFat'] = "importacao/importacaoProFat";
$route['importaProFat'] = "importacao/importaProFat";
$route['apagaImportacaoProFat/:any'] = "importacao/apagaImportacaoProFat/$1";
$route['importacaoDeletaProFat'] = "importacao/importacaoDeletaProFat";

$route['importacaoTUSS'] = "importacao/importacaoTUSS";
$route['importacaoTUSS_progresso/:any/:any/:any/:any/:any/:any/:any/:any/:any'] = "importacao/importacaoTUSS_progresso/$1/$2/$3/$4/$5/$6/$7/$8/$9";
$route['importaTUSS'] = "importacao/importaTUSS";
$route['apagaImportacaoTUSS/:any'] = "importacao/apagaImportacaoTUSS/$1";

$route['importacaoRegraGruPro'] = "importacao/importacaoRegraGruPro";
$route['importaRegraGruPro'] = "importacao/importaRegraGruPro";
$route['apagaImportacaoRegraGruPro/:any'] = "importacao/apagaImportacaoRegraGruPro/$1";

$route['importacaoFracaoSimproBra'] = "importacao/importacaoFracaoSimproBra";
$route['importaFracaoSimproBra'] = "importacao/importaFracaoSimproBra";
$route['apagaImportacaoFracaoSimproBra/:any'] = "importacao/apagaImportacaoFracaoSimproBra/$1";

$route['importacaoProduto'] = "importacao/importacaoProduto";
$route['importaProduto'] = "importacao/importaProduto";
$route['apagaImportacaoProduto/:any'] = "importacao/apagaImportacaoProduto/$1";

$route['importacaoProducao'] = "importacao/importacaoProducao";
$route['importaProducao'] = "importacao/importaProducao";
$route['apagaImportacaoProducao/:any'] = "importacao/apagaImportacaoProducao/$1";

$route['importacaoContrato'] = "importacao/importacaoContrato";
$route['importacaoContrato_progresso/:any/:any/:any/:any/:any/:any/:any/:any/:any'] = "importacao/importacaoContrato_progresso/$1/$2/$3/$4/$5/$6/$7/$8/$9";
$route['importaContrato'] = "importacao/importaContrato";
$route['apagaImportacaoContrato/:any'] = "importacao/apagaImportacaoContrato/$1";

$route['importacaoItensEmpacotados'] = "importacao/importacaoItensEmpacotados";
$route['importacaoItensEmpacotados_progresso/:any/:any/:any/:any/:any/:any/:any/:any/:any'] = "importacao/importacaoItensEmpacotados_progresso/$1/$2/$3/$4/$5/$6/$7/$8/$9";
$route['importaItensEmpacotados'] = "importacao/importaItensEmpacotados";
$route['apagaImportacaoItensEmpacotados/:any'] = "importacao/apagaImportacaoItensEmpacotados/$1";

$route['importacaoPacote'] = "importacao/importacaoPacote";
$route['importacaoPacote_progresso/:any/:any/:any/:any/:any/:any/:any/:any/:any'] = "importacao/importacaoPacote_progresso/$1/$2/$3/$4/$5/$6/$7/$8/$9";
$route['importaPacote'] = "importacao/importaPacote";
$route['apagaImportacaoPacote/:any'] = "importacao/apagaImportacaoPacote/$1";

$route['importacaoPorteMedico'] = "importacao/importacaoPorteMedico";
$route['importaPorteMedico'] = "importacao/importaPorteMedico";
$route['apagaImportacaoPorteMedico/:any'] = "importacao/apagaImportacaoPorteMedico/$1";

$route['importacaoExcecaoValores'] = "importacao/importacaoExcecaoValores";
$route['importaExcecaoValores'] = "importacao/importaExcecaoValores";
$route['apagaImportacaoExcecaoValores/:any'] = "importacao/apagaImportacaoExcecaoValores/$1";

$route['importacaoSimproMsg'] = "importacao/importacaoSimproMsg";
$route['importaSimproMsg'] = "importacao/importaSimproMsg";

$route['importacaoSimproMae'] = "importacao/importacaoSimproMae";
$route['importacaoSimproMae_progresso/:any/:any/:any/:any/:any/:any/:any/:any'] = "importacao/importacaoSimproMae_progresso/$1/$2/$3/$4/$5/$6/$7/$8";
$route['importaSimproMae'] = "importacao/importaSimproMae";

$route['importacaoBrasindiceMsg'] = "importacao/importacaoBrasindiceMsg";
$route['importaBrasindiceMsg'] = "importacao/importaBrasindiceMsg";

$route['importacaoBrasindiceMae'] = "importacao/importacaoBrasindiceMae";
$route['importaBrasindiceMae'] = "importacao/importaBrasindiceMae";

$route['importacaoAnaliseBI'] = "importacao/importacaoAnaliseBI";
$route['importaAnaliseBI'] = "importacao/importaAnaliseBI";

$route['importacaoDePara/:any/:any'] = "importacao/importacaoDePara/$1/$2";
$route['importacaoDePara/:any'] = "importacao/importacaoDePara/$1";

$route['atualizarFatItemPelaSimpro'] = "importacao/atualizarFatItemPelaSimpro";
$route['atualizaFatItemPelaSimpro'] = "importacao/atualizaFatItemPelaSimpro";

$route['atualizarFatItemPelaBrasindice'] = "importacao/atualizarFatItemPelaBrasindice";
$route['atualizaFatItemPelaBrasindice'] = "importacao/atualizaFatItemPelaBrasindice";

$route['layoutImportacao/:any/:any'] = "importacao/layoutImportacao/$1/$2";
$route['layoutImportacao/:any'] = "importacao/layoutImportacao/$1";

$route['adicionaDePara'] = "importacao/adicionaDePara";
$route['editaDePara'] = "importacao/editaDePara";
$route['apagaDePara/:any'] = "importacao/apagaDePara/$1";

$route['adicionaLayoutImportacao'] = "importacao/adicionaLayoutImportacao";
$route['editaLayoutImportacao'] = "importacao/editaLayoutImportacao";
$route['apagaLayoutImportacao/:any'] = "importacao/apagaLayoutImportacao/$1";

$route['consultaCamposTabela/:any'] = "importacao/consultaCamposTabela/$1";

$route['consultaPacoteExcecao/:any'] = "pacote/consultaPacoteExcecao/$1";

/*********** ROUTES DA EXPORTAÇÃO *******************/
$route['exportaFatItem/:any'] = "exportacao/exportaFatItem/$1";

$route['exportaGrupoPro/:any'] = "exportacao/exportaGrupoPro/$1";

$route['exportaProFat/:any'] = "exportacao/exportaProFat/$1";

$route['exportaTUSS/:any'] = "exportacao/exportaTUSS/$1";

$route['exportaRegraGruPro/:any'] = "exportacao/exportaRegraGruPro/$1";

$route['exportaFracaoSimproBra/:any'] = "exportacao/exportaFracaoSimproBra/$1";

$route['exportaProduto/:any'] = "exportacao/exportaProduto/$1";

$route['exportaProducao/:any'] = "exportacao/exportaProducao/$1";

$route['exportaContrato/:any'] = "exportacao/exportaContrato/$1";

$route['exportaPorteMedico/:any'] = "exportacao/exportaPorteMedico/$1";

$route['exportaExcecaoValores/:any'] = "exportacao/exportaExcecaoValores/$1";

$route['exportacaoBI'] = "exportacao/exportacaoBI";
$route['exportacaoBI_progresso'] = "exportacao/exportacaoBI_progresso";
$route['exportacaoBI_finalizar'] = "exportacao/exportacaoBI_finalizar";

$route['exportacaoTbBI_progresso'] = "exportacao/exportacaoTbBI_progresso";

$route['exportaTbBI'] = "exportacao/exportaTbBI";
$route['exportaBI'] = "exportacao/exportaBI";

$route['geraCsvBI'] = "exportacao/geraCsvBI";

$route['exportaBI_AE/:any/:any/:any'] = "ExportacaoAcessoExterno/exportaBI_AE/$1/$2/$3";

$route['exportacaoRelatorioRegra'] = "exportacao/exportacaoRelatorioRegra";

$route['exportaRelatorioRegra'] = "exportacao/exportaRelatorioRegra";
//$route['exportaRelatorioRegraPDF'] = "exportacao/exportaRelatorioRegraPDF";

$route['gerarTbBI'] = "exportacao/gerarTbBI";

/*********** ROUTES PARA AÇÕES DA TELA CONVÊNIO *******************/
$route['adicionaConvenio'] = "principal/adicionaConvenio";
$route['editaConvenio'] = "principal/editaConvenio";
$route['apagaConvenio/:any'] = "principal/apagaConvenio/$1";

/*********** ROUTES PARA AÇÕES DA TELA PLANO *******************/
$route['adicionaPlano'] = "principal/adicionaPlano";
$route['editaPlano'] = "principal/editaPlano";
$route['apagaPlano/:any'] = "principal/apagaPlano/$1";
$route['apagaPlano_Sub/:any/:any'] = "principal/apagaPlano_Sub/$1/$2";

/*********** ROUTES PARA AÇÕES DA TELA FATURAMENTO *******************/
$route['adicionaFaturamento'] = "principal/adicionaFaturamento";
$route['editaFaturamento'] = "principal/editaFaturamento";
$route['apagaFaturamento/:any'] = "principal/apagaFaturamento/$1";

/*********** ROUTES PARA AÇÕES DA TELA REGRA *******************/
$route['adicionaRegra'] = "principal/adicionaRegra";
$route['editaRegra'] = "principal/editaRegra";
$route['apagaRegra/:any'] = "principal/apagaRegra/$1";

/*********** ROUTES PARA AÇÕES DA TELA REGRA GRUPOPRO*******************/
$route['adicionaRegraGruPro'] = "principal/adicionaRegraGruPro";
$route['editaRegraGruPro'] = "principal/editaRegraGruPro";
$route['apagaRegraGruPro/:any'] = "principal/apagaRegraGruPro/$1";
$route['apagaRegraGruPro_Sub/:any/:any'] = "principal/apagaRegraGruPro_Sub/$1/$2";

/*********** ROUTES PARA AÇÕES DA TELA ÍNDICE *******************/
$route['adicionaIndice'] = "principal/adicionaIndice";
$route['editaIndice'] = "principal/editaIndice";
$route['apagaIndice/:any'] = "principal/apagaIndice/$1";

/*********** ROUTES PARA AÇÕES DA TELA ÍNDICE GRUPO PRO *******************/
$route['adicionaIndiceGrupoPro'] = "principal/adicionaIndiceGrupoPro";
$route['editaIndiceGrupoPro'] = "principal/editaIndiceGrupoPro";
$route['apagaIndiceGrupoPro/:any'] = "principal/apagaIndiceGrupoPro/$1";
$route['apagaIndiceGrupoPro_Sub/:any/:any'] = "principal/apagaIndiceGrupoPro_Sub/$1/$2";

/*********** ROUTES PARA AÇÕES DA TELA DE REGRA PROIBIÇÃO *******************/
$route['adicionaRegraProibicao'] = "principal/adicionaRegraProibicao";
$route['editaRegraProibicao'] = "principal/editaRegraProibicao";
$route['apagaRegraProibicao/:any'] = "principal/apagaRegraProibicao/$1";

/*********** ROUTES PARA AÇÕES DA TELA DE FRAÇÃO SIMPRO BRA *******************/
$route['adicionaFracaoSimproBra'] = "principal/adicionaFracaoSimproBra";
$route['editaFracaoSimproBra'] = "principal/editaFracaoSimproBra";
$route['apagaFracaoSimproBra/:any'] = "principal/apagaFracaoSimproBra/$1";

/*********** ROUTES PARA AÇÕES DA TELA DE FATURAMENTO ITEM *******************/
$route['adicionaFaturamentoItem'] = "principal/adicionaFaturamentoItem";
$route['editaFaturamentoItem'] = "principal/editaFaturamentoItem";
$route['apagaFaturamentoItem/:any'] = "principal/apagaFaturamentoItem/$1";
$route['apagaFaturamentoItem_Sub/:any/:any'] = "principal/apagaFaturamentoItem_Sub/$1/$2";

/*********** ROUTES PARA AÇÕES DA TELA DE UNIDADE *******************/
$route['adicionaUnidade'] = "principal/adicionaUnidade";
$route['editaUnidade'] = "principal/editaUnidade";
$route['apagaUnidade/:any'] = "principal/apagaUnidade/$1";

/*********** ROUTES PARA AÇÕES DA TELA EXCEÇÃO VALORES *******************/
$route['adicionaExcecaoValores'] = "principal/adicionaExcecaoValores";
$route['editaExcecaoValores'] = "principal/editaExcecaoValores";
$route['apagaExcecaoValores/:any'] = "principal/apagaExcecaoValores/$1";
$route['buscaProFat'] = "principal/buscaProFat";

/*********** ROUTES PARA AÇÕES DA TELA DE PACOTE *******************/
$route['adicionaPacote'] = "pacote/adicionaPacote";
$route['editaPacote'] = "pacote/editaPacote";
$route['apagaPacote/:any'] = "pacote/apagaPacote/$1";

/*********** ROUTES PARA AÇÕES DA TELA DE EXCECAO PACOTE *******************/
$route['adicionaExcecaoPacote'] = "pacote/adicionaExcecaoPacote";
$route['editaExcecaoPacote'] = "pacote/editaExcecaoPacote";
$route['apagaExcecaoPacote/:any/:any'] = "pacote/apagaExcecaoPacote/$1/$2";

/*********** ROUTES PARA AÇÕES DA TELA DE SUBSTANCIA *******************/
$route['adicionaSubstancia'] = "pacote/adicionaSubstancia";
$route['editaSubstancia'] = "pacote/editaSubstancia";
$route['apagaSubstancia/:any'] = "pacote/apagaSubstancia/$1";

/*********** ROUTES PARA AÇÕES DA TELA DE SETOR *******************/
$route['adicionaSetor'] = "pacote/adicionaSetor";
$route['editaSetor'] = "pacote/editaSetor";
$route['apagaSetor/:any'] = "pacote/apagaSetor/$1";

/*********** ROUTES PARA AÇÕES DA TELA DE EXCEÇÃO PROCEDIMENTO *******************/
$route['adicionaExcecaoProcedimento'] = "pacote/adicionaExcecaoProcedimento";
$route['editaExcecaoProcedimento'] = "pacote/editaExcecaoProcedimento";
$route['apagaExcecaoProcedimento/:any'] = "pacote/apagaExcecaoProcedimento/$1";

$route['principalProibicao'] = "principal/principalProibicao";

$route['principalPlanoModal'] = "principal/principalPlanoModal";

$route['exclusaoDeDados'] = "principal/exclusaoDeDados";
$route['excluiDados'] = "principal/excluiDados";


/*********** ROUTES PARA A DASA AVISAR CARGA DISPONÍVEL *******************/
$route['notificacargadasa'] = "api/notificaCargaDasa";
$route['listaNotificacaoCarga'] = "importacao/listaNotificacaoCarga";
$route['limpaNotificacaoCarga/:any'] = "importacao/limpaNotificacaoCarga/$1";

/*********** ADMIN CONTROLLER ROUTES *******************/
$route['noaccess'] = 'login/noaccess';
$route['telaNaoAutorizada'] = 'login/telaNaoAutorizada';
$route['acaoNaoAutorizada'] = 'login/acaoNaoAutorizada';
$route['userListing'] = 'admin/userListing';
$route['userListing/(:num)'] = "admin/userListing/$1";
$route['addNew'] = "admin/addNew";
$route['addNewUser'] = "admin/addNewUser";
$route['editOld'] = "admin/editOld";
$route['editOld/(:num)'] = "admin/editOld/$1";
$route['editUser'] = "admin/editUser";
$route['deleteUser'] = "admin/deleteUser";
$route['log-history'] = "admin/logHistory";
$route['log-history-backup'] = "admin/logHistoryBackup";
$route['log-history/(:num)'] = "admin/logHistorysingle/$1";
$route['log-history/(:num)/(:num)'] = "admin/logHistorysingle/$1/$2";
$route['backupLogTable'] = "admin/backupLogTable";
$route['backupLogTableDelete'] = "admin/backupLogTableDelete";
$route['log-history-upload'] = "admin/logHistoryUpload";
$route['logHistoryUploadFile'] = "admin/logHistoryUploadFile";

/*********** MANAGER CONTROLLER ROUTES *******************/
$route['tasks'] = "manager/tasks";
$route['addNewTask'] = "manager/addNewTask";
$route['addNewTasks'] = "manager/addNewTasks";
$route['editOldTask/(:num)'] = "manager/editOldTask/$1";
$route['editTask'] = "manager/editTask";
$route['deleteTask/(:num)'] = "manager/deleteTask/$1";

/*********** USER CONTROLLER ROUTES *******************/
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['endTask/(:num)'] = "user/endTask/$1";
$route['etasks'] = "user/etasks";
$route['userEdit'] = "user/loadUserEdit";
$route['updateUser'] = "user/updateUser";


/*********** LOGIN CONTROLLER ROUTES *******************/
$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

/* End of file routes.php */
/* Location: ./application/config/routes.php */