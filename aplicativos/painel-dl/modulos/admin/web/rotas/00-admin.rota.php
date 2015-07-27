<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 10:08:07
 */

$rotas['^(home|index|)$'] = [
    'controle'  =>  '',
    'acao'      =>  ''
];



/*
 * Grupos de usuários
 */
$rotas['^(grupos-de-usuarios/lista|grupos-de-usuarios)$'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'mostrarlista'
];

$rotas['^grupos-de-usuarios/novo(/[a-z]+)?$'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:mst'
];

$rotas['^grupos-de-usuarios/(editar|alterar)/\d+'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:pk'
];

$rotas['^grupos-de-usuarios/salvar$'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'salvar'
];

$rotas['^grupos-de-usuarios/excluir-grupo$'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'remover'
];

$rotas['^grupos-de-usuarios/carregar-select$'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'carregarselect'
];

$rotas['^grupos-de-usuarios/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'alternarpublicacao',
    'params'    =>  '/-/-/:a'
];



/*
 * Usuários
 * -----------------------------------------------------------------------------
 */
$rotas['^(usuarios/lista|usuarios)$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'mostrarlista'
];

$rotas['^usuarios/novo$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'mostrarform'
];

$rotas['^usuarios/(editar|alterar)/\d+$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:pk'
];

$rotas['^usuarios/salvar$'] = [
	'controle'  =>  'Usuario',
	'acao'      =>  'salvar'
];

$rotas['^usuarios/salvar-foto$'] = [
	'controle'  =>  'Usuario',
	'acao'      =>  'salvar_foto'
];

$rotas['^usuarios/excluir-usuarios$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'remover'
];

$rotas['^usuarios/minha-conta$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'minhaconta'
];

$rotas['^usuarios/alterar-minha-senha$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'formalterarsenha'
];

$rotas['^usuarios/alterar-senha-usuario$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'alterarsenha'
];

$rotas['^usuarios/bloquear-usuarios$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'bloquear',
    'vlr'       =>  1
];

$rotas['^usuarios/desbloquear-usuarios$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'bloquear',
    'vlr'       =>  0
];



/*
 * Configuração de envio de e-mails
 * -----------------------------------------------------------------------------
 */
$rotas['^(envio-de-emails/lista|envio-de-emails)$'] = [
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'mostrarlista'
];

$rotas['^envio-de-emails/novo$'] = [
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'mostrarform'
];

$rotas['^envio-de-emails/(editar|alterar)/\d+'] = [
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:pk'
];

$rotas['^envio-de-emails/salvar$'] = [
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'salvar'
];

$rotas['^envio-de-emails/excluir-configuracao$'] = [
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'remover'
];

$rotas['^envio-de-emails/testar-configuracao/\d+$'] = [
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'testar',
    'params'    =>  '/-/-/:pk'
];