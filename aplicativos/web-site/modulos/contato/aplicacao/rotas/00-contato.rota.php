<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 01:14:21
 */


$rotas['^(index|home|)$'] = [
    'controle'  =>  'ContatoSite',
    'acao'      =>  'mostrarform'
];

$rotas['^enviar$'] = [
    'controle'  =>  'ContatoSite',
    'acao'      =>  'enviar'
];