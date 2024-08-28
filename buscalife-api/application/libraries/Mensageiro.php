<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Mensageiro
 *
 * @author dimas.filho
 */
class Mensageiro
{
    // Mensagens de Sucesso
    public static $MSG_S001 = "Dados salvos com sucesso!";

    // Mensagens de Alerta
    public static $MSG_A001 = "Atenção, você não tem permissão de acesso a este módulo!";
    public static $MSG_A002 = "Atenção, não foi encontrado o parametro necessário para carregar a página <strong>{0}</strong>! (Necessário : {1})";
    public static $MSG_A003 = "<p>O período de lançamento de informações da vigência {0} encerrou em {1}!</p>";

    // Mensagens de Erros
    public static $MSG_E001 = "Ocorreu um erro ao salvar! Tente novamente mais tarde!";
    public static $MSG_E002 = "Sua sessão expirou, você deve efetuar o login novamente, para acessar o sistema!";
    public static $MSG_E003 = "Você não tem permissão para acessar essa funcionalidade! <br> <strong>{0}</strong>";

    /**
     * recupera as mensagens de alerta
     *
     * @param string $number     número da mensagem
     * @param array  $parametros parametros a serem substituídos na mensagem
     * @return string
     */
    public static function GetAlert($number, $parametros = null)
    {
        $mensagem = "MSG_A".$number;

        return self::formatMessage(self::${"$mensagem"}, $parametros);
    }

    /**
     * <code>
     * $msg = 'O campo {0} é de preenchimento obrigatório';
     * echo Mensageiro.FormatMessage($msg, array('Nome'));
     * </code>
     * <br/>
     * O resultado será: O campo Nome é de preenchimento obrigatório
     *
     * @param string $msg        mensage com os parâmetros
     * @param array  $parametros parametros a serem substituídos na mensagem
     * @return string mensagem formatada
     */
    public static function formatMessage($msg, $parametros = null)
    {
        for ($i = 0; $i < count($parametros); $i++) {
            $param = null;
            if (is_array($parametros)) {
                $param = $parametros[$i];
            } else {
                $param = $parametros;
            }
            $msg = str_replace('{'.$i.'}', $param, $msg);
        }

        return $msg;
    }

    /**
     * recupera as mensagens de erro
     *
     * @param string $number     número da mensagem
     * @param array  $parametros parametros a serem substituídos na mensagem
     * @return string
     */
    public static function GetError($number, $parametros = null)
    {
        $mensagem = "MSG_E".$number;

        return self::formatMessage(self::${"$mensagem"}, $parametros);
    }

    /**
     * recupera as mensagens de sucesso
     *
     * @param string $number     número da mensagem
     * @param array  $parametros parametros a serem substituídos na mensagem
     * @return string
     */
    public static function GetSuccess($number, $parametros = null)
    {
        $mensagem = "MSG_S".$number;

        return self::formatMessage(self::${"$mensagem"}, $parametros);
    }
}