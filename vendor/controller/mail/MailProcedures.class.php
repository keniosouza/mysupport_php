<?php
/**
 * Classe ProductsValidate.class.php
 * @filesource
 * @autor        Kenio de Souza
 * @copyright    Copyright 2022 - Souza Consultoria Tecnológica
 * @package        vendor
 * @subpackage    controller/products
 * @version        1.0
 * @date            18/04/2022
 */

/** Defino o local onde esta a classe */
namespace vendor\controller\mail;

class MailProcedures
{

    public function TextDecode(string $data)
    {

        //Realizo um decodificação simples do texto
        $decoded = imap_utf8($data);

        //Verifico se o texto possui elementos Quoted Printable, se existir ele irá pegar o texto decodificado do Header
        if ($this->isQuotedPrintable($decoded)){

            //Realizo a decodificação do Cabeçalho
            $decoded = imap_mime_header_decode($data);

            //Obtenho apenas o texto decodificado
            $decoded = $decoded[0]->text;

        }

        //Retorno da Informação
        return $decoded;

    }

    public function BodyDecode(string $data)
    {

        //Verifico se o texto possui elementos Quoted Printable, se existir ele irá pegar o texto decodificado d
        if ($this->isBase64($data)){

            //Realizo a decodificação do Cabeçalho
            $data = base64_decode($data);

        }

        //Verifico se o texto possui elementos Quoted Printable, se existir ele irá pegar o texto decodificado d
        if ($this->isQuotedPrintable($data)){

            //Realizo a decodificação do Cabeçalho
            $data = quoted_printable_decode($data);

        }

        //Retorno da Informação
        return $data;

    }

    function isQuotedPrintable($text) {
        // Verifica se existem padrões típicos de Quoted-Printable no texto
        if (preg_match('/=[0-9A-Fa-f]{2}/', $text)) {
            return true;
        }
        // Verifica se o texto possui quebra de linha com '=' no final
        if (preg_match('/=$/m', $text)) {
            return true;
        }
        return false;
    }

    function isBase64($string) {

        // Verifica se todos os caracteres são válidos em Base64
        return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string);

    }

}
