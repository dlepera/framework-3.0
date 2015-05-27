<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 04/01/2015 22:45:58
 */

/**
 * Definir algumas constantes que serão utilizadas durante a execução das
 * classes
 * -----------------------------------------------------------------------------
 */
define('DL3_ABSPATH', dirname(__FILE__) .'/');
define('DL3_AMBIENTE', filter_input(INPUT_GET, 'dl3_a'));
define('DL3_APLICATIVO', filter_input(INPUT_GET, 'dl3_c'));
define('DL3_URL', filter_input(INPUT_GET, 'dl3_u'));

# Incluir a classe que FrameworkDL3
require_once 'biblioteca/frameworkdl-3.0.classe.php';

try{
    $__dl3 = new FrameworkDL3();
} catch (Exception $ex) {
    // echo '<pre>', var_dump($ex), '</pre>';
    echo json_encode(array(
        'mensagem'  =>  $ex->getMessage(),
        'tipo'      =>  'msg-erro'
    ));
}