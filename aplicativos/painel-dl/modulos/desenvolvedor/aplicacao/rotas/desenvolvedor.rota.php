<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 07/01/2015 16:45:46
 */

$rotas['^(home|index|)$'] = array(
    'controle'  =>  '',
    'acao'      =>  ''
);



/**
 * Módulos
 * -----------------------------------------------------------------------------
 */
$rotas['^(modulos/lista|modulos)$'] = array(
    'controle'  =>  'Modulo',
    'acao'      =>  'mostrarlista'
);

$rotas['^modulos/novo$'] = array(
    'controle'  =>  'Modulo',
    'acao'      =>  'mostrarform'
);

$rotas['^modulos/(editar|alterar)/\d+$'] = array(
    'controle'  =>  'Modulo',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:id'
);

$rotas['^modulos/atualizar-modulo$'] = $rotas['^modulos/instalar-modulo$'] = array(
    'controle'  =>  'Modulo',
    'acao'      =>  'salvar'
);

$rotas['^modulos/desinstalar-modulo$'] = array(
    'controle'  =>  'Modulo',
    'acao'      =>  'remover'
);

$rotas['^modulos/inserir-funcionalidade$'] = array(
    'controle'  =>  'Modulo',
    'acao'      =>  'novafunc'
);

$rotas['^modulos/apagar-funcionalidade$'] = array(
    'controle'  =>  'Modulo',
    'acao'      =>  'removerfunc'
);



/**
 * Temas
 * -----------------------------------------------------------------------------
 */
$rotas['^(temas/lista|temas)$'] = array(
    'controle'  =>  'Tema',
    'acao'      =>  'mostrarlista'
);

$rotas['^temas/novo(/[0-1])?$'] = array(
    'controle'  =>  'Tema',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:tr'
);

$rotas['^temas/(editar|alterar)/\d+$'] = array(
    'controle'  =>  'Tema',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:id'
);

$rotas['^temas/atualizar-tema$'] = $rotas['^temas/instalar-tema$'] = array(
    'controle'  =>  'Tema',
    'acao'      =>  'salvar'
);

$rotas['^temas/desinstalar-tema$'] = array(
    'controle'  =>  'Tema',
    'acao'      =>  'remover'
);

$rotas['^temas/carregar-select$'] = array(
    'controle'  =>  'Tema',
    'acao'      =>  'carregarselect'
);



/**
 * Idiomas
 * -----------------------------------------------------------------------------
 */
$rotas['^(idiomas/lista|idiomas)$'] = array(
    'controle'  =>  'Idioma',
    'acao'      =>  'mostrarlista'
);

$rotas['^idiomas/novo(/[0-1])?$'] = array(
    'controle'  =>  'Idioma',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:tr'
);

$rotas['^idiomas/(editar|alterar)/\d+$'] = array(
    'controle'  =>  'Idioma',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:id'
);

$rotas['^idiomas/salvar$'] = array(
    'controle'  =>  'Idioma',
    'acao'      =>  'salvar'
);

$rotas['^idiomas/remover-idioma$'] = array(
    'controle'  =>  'Idioma',
    'acao'      =>  'remover'
);

$rotas['^idiomas/carregar-select$'] = array(
    'controle'  =>  'Idioma',
    'acao'      =>  'carregarselect'
);