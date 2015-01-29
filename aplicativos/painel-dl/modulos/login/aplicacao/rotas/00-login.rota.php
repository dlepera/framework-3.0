<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 21/01/2015 16:08:22
 */

$rotas['^(home|index|)$'] = array(
    'controle'  =>  'Login',
    'acao'      =>  'mostrarform'
);



/**
 * Login e logout
 * -----------------------------------------------------------------------------
 */
$rotas['^fazer-login$'] = array(
    'controle'  =>  'Login',
    'acao'      =>  'fazerlogin'
);

$rotas['^fazer-logout$'] = array(
    'controle'  =>  'Login',
    'acao'      =>  'fazerlogout'
);



/**
 * Esqueci minha senha
 * -----------------------------------------------------------------------------
 */
$rotas['^esqueci-minha-senha$'] = array(
    'controle'  =>  'Login',
    'acao'      =>  'mostraresqueci'
);

$rotas['^recuperar-senha$'] = array(
    'controle'  =>  'Login',
    'acao'      =>  'recuperarsenha'
);

$rotas['^recuperar-senha/[a-z0-9]{32}$'] = array(
    'controle'  =>  'Login',
    'acao'      =>  'mostrarresetsenha',
    'params'    =>  '/-/:h'
);

$rotas['^resetar-senha-usuario$'] = array(
    'controle'  =>  'Login',
    'acao'      =>  'resetarsenha'
);