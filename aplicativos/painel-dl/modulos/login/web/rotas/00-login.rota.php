<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 21/01/2015 16:08:22
 */

$rotas['^(home|index|)$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'mostrarform'
];



/*
 * Login e logout
 */
$rotas['^fazer-login$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'fazerlogin'
];

$rotas['^fazer-logout$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'fazerlogout'
];



/*
 * Esqueci minha senha
 */
$rotas['^esqueci-minha-senha$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'mostraresqueci'
];

$rotas['^recuperar-senha$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'recuperarsenha'
];

$rotas['^recuperar-senha/[a-z0-9]{32}$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'mostrarresetsenha',
    'params'    =>  '/-/:h'
];

$rotas['^resetar-senha-usuario$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'resetarsenha'
];