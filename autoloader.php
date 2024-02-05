<?php

// Define o namespace para o diretório raiz das classes
// O Valor deve ser alterado de acordo com o projeto
define( 'BADWORDS_FILTER_ROOT_NAMESPACE', 'BadwordsFilter' );

// Registra o autoload
spl_autoload_register( 'my_psr4_autoloader' );

// Função autoload personalizada
function my_psr4_autoloader($class) {
    
    // Verifica se o namespace contém referência ao diretório raiz
    if (!str_starts_with($class, BADWORDS_FILTER_ROOT_NAMESPACE)) return;
        
    $class_path = substr($class, strlen(BADWORDS_FILTER_ROOT_NAMESPACE . '\\')) . '.php';

    $file =  BADWORDS_FILTER_PATH . 'includes/' . $class_path;

    // Verifica se o arquivo existe e inclui caso exista
    if (file_exists($file)) require $file; 
}