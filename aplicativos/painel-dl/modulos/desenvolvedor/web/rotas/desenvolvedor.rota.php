<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 07/01/2015 16:45:46
 */

$rotas['^(home|index|)$'] = [
    'controle'  =>  '',
    'acao'      =>  ''
];



/*
 * Módulos
 */
$rotas['^(modulos/lista|modulos)$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'mostrarlista'
];

$rotas['^modulos/novo$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'mostrarform'
];

$rotas['^modulos/(editar|alterar)/\d+$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:id'
];

$rotas['^modulos/atualizar-modulo$'] = $rotas['^modulos/instalar-modulo$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'salvar'
];

$rotas['^modulos/desinstalar-modulo$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'remover'
];

$rotas['^modulos/inserir-funcionalidade$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'novafunc'
];

$rotas['^modulos/apagar-funcionalidade$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'removerfunc'
];

$rotas['^modulos/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'alternarpublicacao',
    'params'    =>  '/-/-/:a'
];

/*
 *  Filtro de módulos para o menu
 */
$rotas['^modulos/filtro-menu$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'filtromenu',
    'bm'        =>  filter_input(INPUT_POST, 'bm')
];



/*
 * Temas
 */
$rotas['^(temas/lista|temas)$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'mostrarlista'
];

$rotas['^temas/novo(/[a-z]+)?$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:mst'
];

$rotas['^temas/(editar|alterar)/\d+$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:id'
];

$rotas['^temas/atualizar-tema$'] = $rotas['^temas/instalar-tema$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'salvar'
];

$rotas['^temas/desinstalar-tema$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'remover'
];

$rotas['^temas/carregar-select$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'carregarselect'
];

$rotas['^temas/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'alternarpublicacao',
    'params'    =>  '/-/-/:a'
];



/*
 * Idiomas
 */
$rotas['^(idiomas/lista|idiomas)$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'mostrarlista'
];

$rotas['^idiomas/novo(/[a-z]+)?$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:mst'
];

$rotas['^idiomas/(editar|alterar)/\d+$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:id'
];

$rotas['^idiomas/salvar$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'salvar'
];

$rotas['^idiomas/remover-idioma$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'remover'
];

$rotas['^idiomas/carregar-select$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'carregarselect'
];

$rotas['^idiomas/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'alternarpublicacao',
    'params'    =>  '/-/-/:a'
];