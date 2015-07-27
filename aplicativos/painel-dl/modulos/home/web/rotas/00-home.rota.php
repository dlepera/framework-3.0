<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 17:12:08
 */

$rotas['^(index|home|)$'] = [
    'controle'  =>  'WebSite',
    'acao'      =>  'index'
];



/*
 * Obter informações do Google Analytics
 */
$rotas['^google-analytics/acessos/2[0-9]{3}\-[0-1]{1}[0-9]{1}\-[0-3]{1}[0-9]{1}/2[0-9]{3}\-[0-1]{1}[0-9]{1}\-[0-3]{1}[0-9]{1}/(month|week|day)$'] = [
    'controle'  =>  'WebSite',
    'acao'      =>  'ganalytics',
    'params'    =>  '/-/-/:dt_incio/:dt_fim/:dimensao'
];