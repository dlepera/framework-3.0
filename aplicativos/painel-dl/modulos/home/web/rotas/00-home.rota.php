<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 17:12:08
 */


// Home ------------------------------------------------------------------------------------------------------------- //
$rotas['^(index|home|)$'] = [
    'controle'  =>  'WebSite',
    'acao'      =>  'index'
];


// Sobre o sistema -------------------------------------------------------------------------------------------------- //
$rotas['^sobre-o-sistema$'] = [
	'controle' => 'WebSite',
	'acao' => 'sobre'
];


// Obter informações do Google Analytics ---------------------------------------------------------------------------- //
$rotas['^google-analytics/acessos/2[0-9]{3}\-[0-1]{1}[0-9]{1}\-[0-3]{1}[0-9]{1}/2[0-9]{3}\-[0-1]{1}[0-9]{1}\-[0-3]{1}[0-9]{1}/(month|week|day)$'] = [
    'controle'  =>  'WebSite',
    'acao'      =>  'ganalytics',
    'params'    =>  '/-/-/:dt_inicio/:dt_fim/:dimensao'
];