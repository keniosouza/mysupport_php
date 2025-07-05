<?php

/**
 * Registro de um carregador automático de classes utilizando spl_autoload_register.
 *
 * Esta função anônima serve como carregador automático de classes, registrando-se
 * usando a função spl_autoload_register. Ele transforma o nome da classe em um caminho
 * de arquivo e requer dinamicamente o arquivo da classe quando a classe é instanciada.
 *
 * @param string $className O nome completo da classe a ser carregada.
 * @return void
 */
spl_autoload_register(function ($className) {

    // Converte o nome da classe em um caminho de arquivo compatível com o sistema
    $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    // Requer dinamicamente o arquivo da classe
    require_once($filePath . '.class.php');

});