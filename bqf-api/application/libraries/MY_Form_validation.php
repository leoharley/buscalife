<?php

/**
 * Created by PhpStorm.
 * User: dimas.filho
 * Date: 22/06/15
 * Time: 10:46
 */
class MY_Form_validation extends CI_Form_validation
{

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Retira todos os caracteres que nao forem numericos de uma string
     *
     * @param string $value
     * @return string
     */
    public function _toNumber($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    /**
     * Faz a soma dos produtos de um determinado número decomposto, ate o dois.
     * Por exeplo, _soma (15346,5) efetuará a seguinte equaçao:
     * 5*1 + 4*5 + 3*3 + 2*4
     * Esta funçao e primordial para as funções de cpf e cnpj
     *
     * @param integer $value
     * @param integer $start
     * @return integer
     */
    public function _soma($value, $start)
    {
        for ($soma = 0, $i = $start, $j = 0; $i != 1; $i--, $j++) $soma += $i * $value{$j};
        return $soma;
    }
//    public function cep ($uf,$cep) {
//        $cep=self::_toNumber($cep);
//        $uf=strtoupper ($uf);
//        if      ($uf=='SP') $regex = '/^([1][0-9]{3}|[01][0-9]{4})' . '[0-9]{3}$/';
//        else if ($uf=='RJ') $regex = '/^[2][0-8][0-9]{3}'           . '[0-9]{3}$/';
//        else if ($uf=='MS') $regex = '/^[7][9][0-9]{3}'             . '[0-9]{3}$/';
//        else if ($uf=='MG') $regex = '/^[3][0-9]{4}'                . '[0-9]{3}$/';
//        else if ($uf=='MT') $regex = '/^[7][8][8][0-9]{2}'          . '[0-9]{3}$/';
//        else if ($uf=='AC') $regex = '/^[6][9]{2}[0-9]{2}'          . '[0-9]{3}$/';
//        else if ($uf=='AL') $regex = '/^[5][7][0-9]{3}'             . '[0-9]{3}$/';
//        else if ($uf=='AM') $regex = '/^[6][9][0-8][0-9]{2}'        . '[0-9]{3}$/';
//        else if ($uf=='AP') $regex = '/^[6][89][9][0-9]{2}'         . '[0-9]{3}$/';
//        else if ($uf=='BA') $regex = '/^[4][0-8][0-9]{3}'           . '[0-9]{3}$/';
//        else if ($uf=='CE') $regex = '/^[6][0-3][0-9]{3}'           . '[0-9]{3}$/';
//        else if ($uf=='DF') $regex = '/^[7][0-3][0-6][0-9]{2}'      . '[0-9]{3}$/';
//        else if ($uf=='ES') $regex = '/^[2][9][0-9]{3}'             . '[0-9]{3}$/';
//        else if ($uf=='GO') $regex = '/^[7][3-6][7-9][0-9]{2}'      . '[0-9]{3}$/';
//        else if ($uf=='MA') $regex = '/^[6][5][0-9]{3}'             . '[0-9]{3}$/';
//        else if ($uf=='PA') $regex = '/^[6][6-8][0-8][0-9]{2}'      . '[0-9]{3}$/';
//        else if ($uf=='PB') $regex = '/^[5][8][0-9]{3}'             . '[0-9]{3}$/';
//        else if ($uf=='PE') $regex = '/^[5][0-6][0-9]{2}'           . '[0-9]{3}$/';
//        else if ($uf=='PI') $regex = '/^[6][4][0-9]{3}'             . '[0-9]{3}$/';
//        else if ($uf=='PR') $regex = '/^[8][0-7][0-9]{3}'           . '[0-9]{3}$/';
//        else if ($uf=='RN') $regex = '/^[5][9][0-9]{3}'             . '[0-9]{3}$/';
//        else if ($uf=='RO') $regex = '/^[7][8][9][0-9]{2}'          . '[0-9]{3}$/';
//        else if ($uf=='RR') $regex = '/^[6][9][3][0-9]{2}'          . '[0-9]{3}$/';
//        else if ($uf=='RS') $regex = '/^[9][0-9]{4}'                . '[0-9]{3}$/';
//        else if ($uf=='SC') $regex = '/^[8][89][0-9]{3}'            . '[0-9]{3}$/';
//        else if ($uf=='SE') $regex = '/^[4][9][0-9]{3}'             . '[0-9]{3}$/';
//        else if ($uf=='TO') $regex = '/^[7][7][0-9]{3}'             . '[0-9]{3}$/';
//        else return false;
//        if(!preg_match($regex,$cep)) return false;
//        return true;
//    }
    /**
     * Valida um e-mail especificado
     *
     * @param string $email
     * @return bool
     */
//    public function email ($email) {
//        $email=trim (strtolower($email));
//        if (strlen($email)<6) return false;
//        if (!preg_match('/^[a-z0-9]+([\._-][a-z0-9]+)*@[a-z0-9_-]+(\.[a-z0-9]+){0,4}\.[a-z0-9]{1,4}$/',$email)) return false;
//        $domain=end (explode ('@',$email));
//        //if (!gethostbynamel ($domain)) return false;
//        return true;
//    }
    /**
     * Valida um cpf ou cnpj, dependendo da quantidade de caracteres numericos que a string contiver
     * O cpf ou cnpj podem ser passados com os pontos separadores ou barras
     *
     * @param string $value
     * @return array
     */
    public function cpfcnpj($value)
    {
        $value = self::_toNumber($value);
        if (strlen($value) == 11) return $this->valida_cpf($value);
        if (strlen($value) == 14) return $this->valida_cnpj($value);
    }

    /**
     * Valida CPF
     *
     * @author Luiz Otávio Miranda <contato@todoespacoonline.com/w>
     * @param string $cpf O CPF com ou sem pontos e traço
     * @return bool True para CPF correto - False para CPF incorreto
     *
     */
    public function valida_cpf($cpf = false)
    {
        $CI =& get_instance();
        $CI->form_validation->set_message('cpfcnpj','CPF inválido');
        // Exemplo de CPF: 025.462.884-23

        /**
         * Multiplica dígitos vezes posições
         *
         * @param string $digitos      Os digitos desejados
         * @param int    $posicoes     A posição que vai iniciar a regressão
         * @param int    $soma_digitos A soma das multiplicações entre posições e dígitos
         * @return int Os dígitos enviados concatenados com o último dígito
         *
         */
        function calc_digitos_posicoes($digitos, $posicoes = 10, $soma_digitos = 0)
        {
            // Faz a soma dos dígitos com a posição
            // Ex. para 10 posições:
            //   0    2    5    4    6    2    8    8   4
            // x10   x9   x8   x7   x6   x5   x4   x3  x2
            // 	 0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
            for ($i = 0; $i < strlen($digitos); $i++) {
                $soma_digitos = $soma_digitos + ($digitos[$i] * $posicoes);
                $posicoes--;
            }

            // Captura o resto da divisão entre $soma_digitos dividido por 11
            // Ex.: 196 % 11 = 9
            $soma_digitos = $soma_digitos % 11;

            // Verifica se $soma_digitos é menor que 2
            if ($soma_digitos < 2) {
                // $soma_digitos agora será zero
                $soma_digitos = 0;
            } else {
                // Se for maior que 2, o resultado é 11 menos $soma_digitos
                // Ex.: 11 - 9 = 2
                // Nosso dígito procurado é 2
                $soma_digitos = 11 - $soma_digitos;
            }

            // Concatena mais um dígito aos primeiro nove dígitos
            // Ex.: 025462884 + 2 = 0254628842
            $cpf = $digitos.$soma_digitos;

            // Retorna
            return $cpf;
        }

        // Verifica se o CPF foi enviado
        if (!$cpf) {
            return false;
        }

        // Remove tudo que não é número do CPF
        // Ex.: 025.462.884-23 = 02546288423
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se o CPF tem 11 caracteres
        // Ex.: 02546288423 = 11 números
        if (strlen($cpf) != 11) {
            return false;
        }

        // Captura os 9 primeiros dígitos do CPF
        // Ex.: 02546288423 = 025462884
        $digitos = substr($cpf, 0, 9);

        // Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
        $novo_cpf = calc_digitos_posicoes($digitos);

        // Faz o cálculo dos 10 dígitos do CPF para obter o último dígito
        $novo_cpf = calc_digitos_posicoes($novo_cpf, 11);

        // Verifica se o novo CPF gerado é idêntico ao CPF enviado
        if ($novo_cpf === $cpf) {
            // CPF válido
            return true;
        } else {
            // CPF inválido
            return false;
        }
    }

    /**
     * Valida CNPJ
     *
     * @author Luiz Otávio Miranda <contato@todoespacoonline.com/w>
     * @param string $cnpj
     * @return bool true para CNPJ correto
     *
     */
    public function valida_cnpj($cnpj)
    {
        $CI =& get_instance();
        $CI->form_validation->set_message('cpfcnpj','CNPJ inválido');
        // Deixa o CNPJ com apenas números
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Garante que o CNPJ é uma string
        $cnpj = (string)$cnpj;

        // O valor original
        $cnpj_original = $cnpj;

        // Captura os primeiros 12 números do CNPJ
        $primeiros_numeros_cnpj = substr($cnpj, 0, 12);

        /**
         * Multiplicação do CNPJ
         *
         * @param string $cnpj     Os digitos do CNPJ
         * @param int    $posicoes A posição que vai iniciar a regressão
         * @return int O
         *
         */
        function multiplica_cnpj($cnpj, $posicao = 5)
        {
            // Variável para o cálculo
            $calculo = 0;

            // Laço para percorrer os item do cnpj
            for ($i = 0; $i < strlen($cnpj); $i++) {
                // Cálculo mais posição do CNPJ * a posição
                $calculo = $calculo + ($cnpj[$i] * $posicao);

                // Decrementa a posição a cada volta do laço
                $posicao--;

                // Se a posição for menor que 2, ela se torna 9
                if ($posicao < 2) {
                    $posicao = 9;
                }
            }
            // Retorna o cálculo
            return $calculo;
        }

        // Faz o primeiro cálculo
        $primeiro_calculo = multiplica_cnpj($primeiros_numeros_cnpj);

        // Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
        // Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
        $primeiro_digito = ($primeiro_calculo % 11) < 2 ? 0 : 11 - ($primeiro_calculo % 11);

        // Concatena o primeiro dígito nos 12 primeiros números do CNPJ
        // Agora temos 13 números aqui
        $primeiros_numeros_cnpj .= $primeiro_digito;

        // O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
        $segundo_calculo = multiplica_cnpj($primeiros_numeros_cnpj, 6);
        $segundo_digito = ($segundo_calculo % 11) < 2 ? 0 : 11 - ($segundo_calculo % 11);

        // Concatena o segundo dígito ao CNPJ
        $cnpj = $primeiros_numeros_cnpj.$segundo_digito;

        // Verifica se o CNPJ gerado é idêntico ao enviado
        if ($cnpj === $cnpj_original) {
            return true;
        }
        return false;
    }


} 