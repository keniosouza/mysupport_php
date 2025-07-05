<?php
/**
 * Classe Main.class.php
 * @filesource
 * @autor        Kenio de Souza
 * @copyright    Copyright 2016 Serenity Informatica
 * @package        model
 * @subpackage    model.class
 * @version        1.0
 */

/** Defino o local onde a classe esta localizada **/
namespace vendor\controller\main;

class Main
{

    private $string = null;
    private $long = null;
    private $elements = null;
    private $method = null;
    private $data = null;
    private $imageUrl = null;
    private $pathPermissionFile = null;
    private $password = null;
    private $token = null;

    /** Verifica se o token do usuário é válido */
    public function VerifyToken() : bool
    {

        /** Obtenho as configurações iniciais */
        $Config = $this->LoadConfigPublic()->app->security;

        /** Verifica se o token foi inicializado e não esta vazio */
        if(!empty($_SESSION['USERSTOKEN']) ){

            /** Caso o token tenha sido inicializado e não esteja vazio, verifica-se o mesmo é válido */
            $this->token = explode('-', $this->decryptData($_SESSION['USERSTOKEN']));

            /** Verifica se o hash é válido */
            if($this->token[2] == session_id()){

                /**Caso o usuario não esteja logado informo*/
                if((int)$_SESSION['USERSID'] == 0)
                {
                    /**Elimina as sessões atuais*/
                    session_destroy();

                    /**Gera um novo session_id*/
                    session_regenerate_id();

                    return false;
                }

                /**Caso o usuário esteja logado no sistema e o tempo de sessão tenha excedido o permitido */
                elseif($this->CheckTime($_SESSION['USERSSTARTTIME']) > $Config->session_time)
                {
                    /**Destruo as sessões atuais*/
                    session_destroy();

                    /**Gera um novo session_id*/
                    session_regenerate_id();

                    return false;

                    /** Caso esteja tudo certo, libera o acesso */
                }else{

                    /** Renova o tempo   da sessão do usuário */
                    $_SESSION['USERSSTARTTIME'] = date("Y-m-d H:i:s");

                    return true;

                }

            }else{

                /**Elimina as sessões atuais*/
                session_destroy();

                /**Gera um novo session_id*/
                session_regenerate_id();

                return false;

            }

        }else{

            /**Elimina as sessões atuais*/
            session_destroy();

            /**Gera um novo session_id*/
            session_regenerate_id();

            return false;
        }

    }

    /**Retorna o tempo entre datas*/
    public function CheckTime($datahora)
    {
        /** Prepara a data de entrada para ser tratada */
        $a_ano      = substr($datahora, 0,4);
        $a_mes      = substr($datahora, 5,2);
        $a_dia      = substr($datahora, 8,2);
        $a_hora     = substr($datahora, 11,2);
        $a_minuto   = substr($datahora, 14,2);
        $a_segundos = substr($datahora, 17,2);

        // Obtém um timestamp Unix para a data informada
        $dataacesso = mktime($a_hora, $a_minuto, $a_segundos, $a_mes, $a_dia, $a_ano);

        // Pego a data atual
        $dataatual  = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));

        $return = (($dataatual - $dataacesso)/60);//Pego a diferença entre o tempo

        return ceil($return);//Retorno a quantidade de minutos

    }

    /**
     * Retorna a string descriptografada usando a chave e método especificados.
     *
     * Esta função recebe uma string a ser descriptografada e utiliza a chave e o método
     * especificados no processo de descriptografia. A descriptografia é realizada pela função
     * `securedDecrypt`. Se a string a ser descriptografada não for informada, a função retorna
     * a string original sem descriptografia.
     *
     * @param string $data A string a ser descriptografada.
     *
     * @return string A string descriptografada ou a string original se não houver dados para descriptografia.
     */
    public function decryptData(string $data): string
    {

        /** Obtenho as configurações iniciais */
        $Config = $this->LoadConfigPublic()->app;

        // Parâmetro de entrada: a string a ser descriptografada.
        $this->data = $data;

        // Verifica se a string a ser descriptografada foi informada.
        if (!empty($this->data)) {

            // Chama a função securedDecrypt para realizar a descriptografia.
            return $this->securedDecrypt($Config->security->first_key, $Config->security->method, $this->data);

        } else {

            // Retorna a string original se não houver dados para descriptografia.
            return $this->data;

        }

    }


    /**
     * Retorna a string criptografada usando as chaves e método especificados.
     *
     * Esta função recebe uma string a ser criptografada e utiliza as chaves e o método
     * especificados no processo de criptografia. A criptografia é realizada pela função
     * `securedEncrypt`. Se a string a ser criptografada não for informada, a função retorna
     * a string original sem criptografia.
     *
     * @param string $data A string a ser criptografada.
     *
     * @return string A string criptografada ou a string original se não houver dados para criptografia.
     */
    public function encryptData(string $data): string
    {

        /** Obtenho as configurações iniciais */
        $Config = $this->LoadConfigPublic()->app;

        // Parâmetro de entrada: a string a ser criptografada.
        $this->data = $data;

        // Verifica se a string a ser criptografada foi informada.
        if (!empty($this->data)) {

            // Chama a função securedEncrypt para realizar a criptografia.
            return $this->securedEncrypt($Config->security->first_key, $Config->security->second_key, $Config->security->method, $this->data);

        } else {

            // Retorna a string original se não houver dados para criptografia.
            return $this->data;

        }

    }

    /** Inicializo a sessão */
    public function SessionStart()
    {

        @session_start();

    }

    /** Finalizo a sessão */
    public function SessionDestroy()
    {

        @session_destroy();

    }

    /** Função para carregar as informações */
    public function LoadConfigPublic()
    {

        /** Carrego o arquivo de configuração */
        return (object)json_decode(file_get_contents('config.json'));

    }

    /** Função para carregar as informações */
    public function LoadUserAcl()
    {

        /** Verifica se o usuário efetuou autenticação junto ao sistema */
        if( (isset($_SESSION['USERSID'])) && ($_SESSION['USERSID'] > 0) ) {

            /** Caminho absoluto do arquivo de permissão */
            $this->pathPermissionFile = 'temp/permissions/' . md5($_SESSION['USERSID']) . '.json';

            /** Verifica se o arquivo de permissão do usuário existe */
            if(is_file($this->pathPermissionFile)){

                /** Carrego o arquivo de configuração */
                return (object)json_decode(file_get_contents('temp/permissions/' . md5($_SESSION['USERSID']) . '.json'));

            }

        }

    }

    /** Antiinjection */
    public function antiInjectionArray($ar)
    {

        /** Verifica se a array foi informada */
        if (is_array($ar)) {

            $str = [];

            foreach ($ar as $value) {

                array_push($str, $this->antiInjection($value));

            }

            return $str;

        } else {

            return $ar;
        }
    }


    /** Antiinjection */
    public function antiInjection($string, string $long = '')
    {

        /** Parâmetros de entrada */
        $this->string = $string;
        $this->long = $long;

        /** Verifico o tipo de entrada */
        if (is_array($this->string)) {

            /** Retorno o texto sem formatação */
            $this->antiInjectionArray($this->string);

        } elseif (strcmp($this->long, 'S') === 0) {

            /** Retorno a string sem tratamento */
            return $this->string;

        } else {

            /** Remoção de espaçamentos */
            $this->string = trim($this->string);

            /** Remoção de tags PHP e HTML */
            $this->string = strip_tags($this->string);

            /** Adição de barras invertidas */
            $this->string = addslashes($this->string);

            /** Evita ataque XSS */
            $this->string = htmlspecialchars($this->string);

            /** Elementos do SQL Injection */
            $elements = array(
                ' drop ',
                ' select ',
                ' delete ',
                ' update ',
                ' insert ',
                ' alert ',
                ' destroy ',
                ' * ',
                ' database ',
                ' drop ',
                ' union ',
                ' TABLE_NAME ',
                ' 1=1 ',
                ' or 1 ',
                ' exec ',
                ' INFORMATION_SCHEMA ',
                ' like ',
                ' COLUMNS ',
                ' into ',
                ' VALUES ',
                ' from ',
                ' undefined '
            );

            /** Transformo as palavras em array */
            $palavras = explode(' ', str_replace(',', '', $this->string));

            /** Percorro todas as palavras localizadas */
            foreach ($palavras as $keyPalavra => $palavra) {

                /** Percorro todos os elementos do SQL Injection */
                foreach ($elements as $keyElement => $element) {

                    /** Verifico se a palavra esta na lista negra */
                    if (strcmp(strtolower($palavra), strtolower($element)) === 0) {

                        /** Realizo a troca da marcação pela palavra qualificada */
                        $this->string = str_replace($palavra, '', $this->string);

                    }

                }

            }

            /** Retorno o texto tratado */
            return $this->string;

        }

    }

    /**
     * Criptografa uma string usando duas chaves e um método específicos.
     *
     * Esta função recebe uma string a ser criptografada, duas chaves (uma para criptografia e outra para HMAC),
     * e um método de criptografia. A string é criptografada usando a função OpenSSL e HMAC com os parâmetros fornecidos.
     *
     * @param string $first_key A primeira chave de criptografia utilizada no processo.
     * @param string $second_key A segunda chave (HMAC) utilizada no processo.
     * @param string $method O método de criptografia usado durante o processo de criptografia.
     * @param string $str A string que será criptografada.
     *
     * @return string A string criptografada representada em base64.
     */
    public function securedEncrypt($first_key, $second_key, $method, $str)
    {

        // A string a ser criptografada é obtida do parâmetro $str.
        $data = $str;

        // Obtém o comprimento do IV (Vetor de Inicialização) para o método de criptografia.
        $iv_length = openssl_cipher_iv_length($method);

        // Gera um IV (Vetor de Inicialização) aleatório.
        $iv = openssl_random_pseudo_bytes($iv_length);

        // Criptografa a string usando OpenSSL.
        $first_encrypted = openssl_encrypt($data, $method, $first_key, OPENSSL_RAW_DATA, $iv);

        // Calcula o HMAC (hash-based message authentication code) da parte criptografada usando a segunda chave.
        $second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, true);

        // Combina o IV, o HMAC e a parte criptografada, e então codifica em base64.
        $output = base64_encode($iv . $second_encrypted . $first_encrypted);

        // Retorna a string criptografada representada em base64.
        return $output;

    }

    /**
     * Descriptografa uma string usando uma chave e um método específicos.
     *
     * Esta função recebe uma string criptografada, uma chave de descriptografia e um método de criptografia.
     * A string é descriptografada usando a função OpenSSL com os parâmetros fornecidos.
     *
     * @param string $first_key A chave de descriptografia utilizada no processo.
     * @param string $method O método de criptografia usado durante o processo de descriptografia.
     * @param string $input A string criptografada que será descriptografada.
     *
     * @return string|false A string descriptografada ou false em caso de falha na descriptografia.
     */
    public function securedDecrypt($first_key, $method, $input)
    {

        // A string a ser descriptografada é obtida decodificando a entrada em base64.
        $mix = base64_decode($input);

        // Obtém o comprimento do IV (Vetor de Inicialização) para o método de criptografia.
        $iv_length = openssl_cipher_iv_length($method);

        // Extrai o IV e a parte criptografada da string.
        $iv = substr($mix, 0, $iv_length);
        $first_encrypted = substr($mix, $iv_length + 64);

        // Descriptografa a string usando OpenSSL.
        $output = openssl_decrypt($first_encrypted, $method, $first_key, OPENSSL_RAW_DATA, $iv);

        // Retorna a string descriptografada ou false em caso de falha na descriptografia.
        return $output;

    }

    /**
     * Converte uma medida em centímetros para pontos.
     *
     * Esta função recebe uma medida em centímetros e a converte para pontos.
     * Um ponto é uma unidade de medida usada em tipografia e impressão.
     *
     * @param float $centimeter A medida em centímetros a ser convertida para pontos.
     *
     * @return float A medida convertida para pontos.
     */
    public function CentimeterToPoint($centimeter)
    {
        // A fórmula de conversão de centímetros para pontos é multiplicar por 28.34645669.
        return $centimeter * 28.34645669;
    }

    /**
     * Função para remover máscaras de uma string.
     *
     * Esta função recebe uma string contendo caracteres especiais de máscara,
     * como parênteses, ponto, hífen e barra, e remove esses caracteres, retornando
     * a string sem a formatação de máscara.
     *
     * @param string $string A string contendo a máscara a ser removida.
     *
     * @return string A string sem a formatação de máscara.
     */
    public function removeMask($string)
    {
        // Elementos que serão removidos da string.
        $this->elements = ['(', ')', '.', '-', '/'];

        // Parâmetro de entrada: a string com máscara.
        $this->string = $string;

        // Remove os elementos da string usando str_replace.
        $this->string = str_replace($this->elements, '', $this->string);

        // Retorna a string sem a formatação de máscara.
        return $this->string;
    }

    /**
     * Valida se uma string é um endereço de e-mail válido.
     *
     * Esta função utiliza a função filter_var para verificar se a string fornecida
     * representa um endereço de e-mail válido.
     *
     * @param string $string A string a ser validada como um endereço de e-mail.
     *
     * @return bool Retorna true se a string é um endereço de e-mail válido e false caso contrário.
     */
    public function validarEmail($string)
    {
        // Parâmetro de entrada: a string a ser validada como um endereço de e-mail.
        $this->string = $string;

        // Verifica se a string representa um endereço de e-mail válido usando FILTER_VALIDATE_EMAIL.
        return filter_var($this->string, FILTER_VALIDATE_EMAIL) !== false;

    }


    /**
     * Retorna a representação base64 de uma imagem a partir de sua URL.
     *
     * Esta função recebe a URL de uma imagem, carrega o conteúdo da imagem, recupera
     * sua extensão e retorna a representação base64 da imagem com as definições de visualização.
     *
     * @param string $imageUrl A URL da imagem da qual se deseja obter a representação base64.
     *
     * @return string|bool A representação base64 da imagem, ou false se a URL não foi fornecida.
     */
    public function imageB64($imageUrl)
    {

        // Verifica se a URL da imagem foi informada para realizar o procedimento.
        if ($imageUrl) {

            // Parâmetro de entrada: a URL da imagem.
            $this->imageUrl = $imageUrl;

            // Carrega a URL da imagem.
            $path = $this->imageUrl;

            // Recupera a extensão da imagem.
            $type = pathinfo($path, PATHINFO_EXTENSION);

            // Carrega o buffer da imagem.
            $data = file_get_contents($path);

            // Devolve a imagem em base64 já com as definições de visualização.
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            return $base64;
        }

        // Retorna false se a URL da imagem não foi fornecida.
        return false;

    }

    /** Valida a senha */
    public function validatePasswordStrength($pwd)
    {

        /** Verifica se a senha de acesso precisa ter
         * letras e números e pelo menos
         * uma letra maiúscula ou minúscula
         * e ter no mínimo oito(8) dígitos */
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[\w$@]{8,}$/', $pwd);

    }

    /**
     * Gera um hash para senha.
     *
     * @param string $password A senha a ser transformada em hash.
     *
     * @return string|false Retorna o hash da senha ou false se a senha não for fornecida.
     */
    public function generatePasswordHash($password)
    {
        // Verifica se a senha foi informada
        if (empty($password)) {

            return false;

        }

        // Padrão de criptografia
        $hashAlgorithm = PASSWORD_DEFAULT;

        // Nível de custo para a criptografia (quanto maior, mais seguro, mas também mais lento)
        $cost = 10;

        // Gera o hash da senha
        return password_hash($password, $hashAlgorithm, ['cost' => $cost]);

    }

    /**
     * Função substituirCaracteresEspeciais
     * Substitui caracteres especiais por seus equivalentes comuns em uma string.
     *
     * @param string $texto - A string original que contém caracteres especiais.
     *
     * @return string - A string modificada com os caracteres especiais substituídos.
     */
    function RemoveSpecialChars(string $string) {

        // Array associativo com os caracteres especiais e seus substitutos
        $caracteresEspeciais = array(
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'ã' => 'a',
            'õ' => 'o',
            'ç' => 'c',
            // Adicione outros caracteres especiais e substitutos conforme necessário
        );

        // Substituir os caracteres especiais na string usando str_replace
        // array_keys($caracteresEspeciais) retorna um array com as chaves (caracteres especiais)
        // array_values($caracteresEspeciais) retorna um array com os valores (substitutos)
        $string = str_replace(array_keys($caracteresEspeciais), array_values($caracteresEspeciais), $string);

        // Retornar a string modificada
        return $string;

    }

    /**
     * Método generateHexCode
     * Gera um código hexadecimal aleatório de 6 caracteres (incluindo o símbolo '#').
     *
     * @return string - Código hexadecimal gerado.
     */
    public function generateHexCode(): string
    {
        // Utiliza str_shuffle para embaralhar os caracteres 'ABCDEF0123456789'
        // e substr para obter os primeiros 6 caracteres.
        // Adiciona o símbolo '#' no início do código gerado.
        return '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
    }

    /**
     *@author Keven
     *@date 28/09/2022 12:25:45
     *@description Obtenho um alerta html formatado
     */
    public function generateAlertHtml(?string $type, ?string $title, ?string $data): string
    {
        /** Parâmetros de entrada */
        $this->type = (string)$type;
        $this->title = (string)$title;
        $this->data = (string)$data;
        /** estrutura HTML */
        $html = '<div class="alert alert-' . $this->type . ' animate slideIn" role="alert">';
        $html .= '  <h4 class="alert-heading">' . $this->title . "</h4>";
        $html .= "  <p>" . $this->data . "</p>";
        $html .= "</div>";
        /** Retorno de informação */
        return $html;
    }

    /**
     *@author Keven
     *@date 28/09/2022 12:25:45
     *@description Obtenho uma lista de informações a partir de uma array fornecida
     */
    public function generateList(?array $data): string
    {
        /** Parâmetros de entrada */
        $this->data = (array)$data;
        /** Início da lista */
        $result = "<ul>";
        /** Listagem dos Itens */
        foreach ($this->data as $keyData => $resultData) {
            /** Verifico se é exceção */
            if ($keyData !== "exception") {
                /** Item da Lista */
                $result .= "<li><b>[" . $keyData . "]</b> = " . $resultData . "</dt>";
            }
        }
        /** Encerro a Lista */
        $result .= "</ul>";
        /** Retorno de informação */
        return $result;
    }

    /**
     *@author KEVEN
     *@date 05/06/2023
     *@description Compressão de arquivos
     *@link https://reeteshghimire.com.np/2022/06/11/minify-html-javascript-and-css-using-php/
     */
    public function Minify($content): ? string
    {

        /** realizo a compressão dos arquivos */
        $output = preg_replace(array('/ {2,}/', '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'), array(' ', ''), $content);

        /** retorno da informação */
        return $output;
    }

    /**
     * Função deleteFolder
     * Exclui uma pasta e seus arquivos recursivamente.
     *
     * @param string $folderPath - Caminho da pasta a ser excluída.
     *
     * @return bool
     */
    function deleteFolder($folderPath) : bool {

        // Verifica se a pasta existe
        if (is_dir($folderPath)) {

            // Abre o diretório
            $directory = opendir($folderPath);

            // Loop para excluir cada arquivo dentro da pasta
            while (($file = readdir($directory)) !== false) {

                // Ignora os diretórios pai e atual
                if ($file != '.' && $file != '..') {

                    $filePath = $folderPath . '/' . $file;

                    // Se for um diretório, chama recursivamente a função para excluir seus arquivos
                    if (is_dir($filePath)) {

                        deleteFolder($filePath);

                    } else {

                        // Exclui o arquivo
                        unlink($filePath);

                    }

                }

            }

            // Fecha o diretório
            closedir($directory);

            // Exclui a pasta
            rmdir($folderPath);

            return true;

        } else {

            return false;

        }

    }

    /**
     * Função que verifica se uma palavra específica existe em uma string.
     *
     * @param string $string A string na qual a palavra será procurada.
     * @param string $palavra A palavra a ser procurada na string.
     * @return bool Retorna verdadeiro se a palavra for encontrada na string, falso caso contrário.
     */
    function CheckWord($string, $word) {

        // Converte a string e a palavra para minúsculas para fazer uma comparação case-insensitive
        $stringEmMinusculas = strtolower($string);
        $palavraEmMinusculas = strtolower($word);

        // Verifica se a palavra existe na string usando strpos
        // A função strpos retorna a posição da primeira ocorrência da palavra ou false se não for encontrada
        $existePalavra = strpos($stringEmMinusculas, $palavraEmMinusculas) !== false;

        // Retorna o resultado da verificação
        return $existePalavra;

    }

    /** Gera um password hash */
    public function passwordHash($password)
    {

        /** Parametros de entradas */
        $this->password = $password;

        /** Tipo de criptografia */
        $hash = PASSWORD_DEFAULT;

        /** Padrão de criptogrfia */
        $cost = array("cost" => 10);

        /** Gera o hash da senha */
        return password_hash($this->password, $hash, $cost);

    }

    /**
     * Formata um CNPJ ou CPF para o padrão adequado.
     *
     * @param string $documento O CNPJ ou CPF a ser formatado.
     * @return string O CNPJ ou CPF formatado.
     */
    function DocumentFormat($documento) {

        // Remove caracteres não numéricos
        $documento = preg_replace('/[^0-9]/', '', $documento);

        // Verifica se o documento é um CPF (11 dígitos) ou CNPJ (14 dígitos)
        if (strlen($documento) === 11) {
            // Formata o CPF
            $documentoFormatado = substr($documento, 0, 3) . '.' .
                substr($documento, 3, 3) . '.' .
                substr($documento, 6, 3) . '-' .
                substr($documento, 9);
        } elseif (strlen($documento) === 14) {
            // Formata o CNPJ
            $documentoFormatado = substr($documento, 0, 2) . '.' .
                substr($documento, 2, 3) . '.' .
                substr($documento, 5, 3) . '/' .
                substr($documento, 8, 4) . '-' .
                substr($documento, 12);
        } else {
            // Documento inválido
            return "Documento inválido. Deve conter 11 ou 14 dígitos.";
        }

        return $documentoFormatado;
    }

    /**
     * Função para formatar o tamanho do arquivo em uma unidade compreensível.
     *
     * Esta função recebe o tamanho do arquivo em bytes e o converte para uma unidade
     * de medida mais adequada, como kilobytes (KB), megabytes (MB), gigabytes (GB), etc.
     *
     * @param int $size Tamanho do arquivo em bytes.
     * @return string Tamanho formatado com duas casas decimais e a unidade correspondente.
     */
    function formatFileSize($size) {

        // Array de unidades de medida
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        // Loop para dividir o tamanho por 1024 até que seja menor que 1024
        for ($i = 0; $size > 1024; $i++) {

            $size /= 1024;

        }

        // Retorna o tamanho formatado com duas casas decimais e a unidade correspondente
        return round($size, 2) . ' ' . $units[$i];

    }

    /**
     * Função SetIcon
     *
     * Esta função verifica se um ícone desejado existe em um caminho especificado.
     *
     * @param string $path O caminho do ícone a ser verificado.
     * @param string $icon O nome do ícone desejado.
     *
     * @return string O caminho completo para o ícone se ele existir, caso contrário, retorna o caminho padrão 'image/' . $icon.
     */
    function SetIcon($path, $icon) : ? string
    {

        // Verifica se o arquivo no caminho especificado existe
        // Se existir, retorna o caminho completo
        // Se não existir, retorna o caminho padrão 'image/' . $icon
        return file_exists($path) ? $path : 'image/' . $icon;

    }

    /**
     * Função SetClass
     *
     * Esta função recebe um valor de prioridade e retorna uma string representando uma classe CSS associada a essa prioridade.
     *
     * @param int $data O valor de prioridade para o qual a classe CSS será determinada.
     *
     * @return string A classe CSS associada à prioridade. As possíveis classes são 'danger' (vermelho) para prioridade 1,
     * 'warning' (amarelo) para prioridade 2, 'primary' (azul) para prioridade 3 e 'success' (verde) para prioridade 4.
     */
    function SetClass($data) : ? string
    {

        /** Verifica o tipo de prioridade usando um switch */
        switch ($data){

            /** Caso seja Prioridade 1 (Urgente) */
            case 1:

                /** Atribui a classe 'danger' (vermelho) */
                $data = 'danger';
                break;

            /** Caso seja Prioridade 2 (Amarelo) */
            case 2:

                /** Atribui a classe 'warning' (amarelo) */
                $data = 'warning';
                break;

            /** Caso seja Prioridade 3 (Azul) */
            case 3:

                /** Atribui a classe 'primary' (azul) */
                $data = 'primary';
                break;

            /** Caso seja Prioridade 4 (Verde) */
            case 4:

                /** Atribui a classe 'success' (verde) */
                $data = 'success';
                break;
        }

        /** Retorna a classe CSS determinada para a prioridade fornecida */
        return $data;

    }

    /**
     * highlightWord
     *
     * Destaca todas as ocorrências de uma palavra específica em uma string.
     *
     * @param string $string A string na qual deseja-se destacar a palavra.
     * @param string $word A palavra que deseja-se destacar na string.
     * @return string A string original com todas as ocorrências da palavra destacadas.
     */
    function highlightWord($string, $word) {

        // Usando expressão regular para substituir todas as ocorrências da palavra
        return preg_replace('/\b(' . preg_quote($word, '/') . ')\b/i', '<mark>$1</mark>', $string);

    }

    function ContentLength($string)
    {

        return strlen(trim(strip_tags((string)$string)));

    }

    function RandomHash()
    {

        return md5(rand(1, 1000) . date('H:i:s'));

    }

    /**
     * Gera um arquivo a partir de uma string em formato base64 e o salva no caminho especificado.
     *
     * @param string $path O caminho onde o arquivo será salvo.
     * @param string $name O nome do arquivo a ser gerado.
     * @param string $base64 A string em formato base64 a ser convertida em arquivo.
     * @return void
     */
    function FileGenerate(string $path, string $name, $data)
    {

        /** Verifica se a pasta especificada existe. */
        if (!is_dir($path)) {

            /** Cria a pasta recursivamente se ela não existir. */
            mkdir($path, 0777, true);

        }

        /** Gera um arquivo temporário com a permissão necessária. */
        file_put_contents($path . '/' . $name, $data);

    }

}