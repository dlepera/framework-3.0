<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/01/2015 12:00:59
 */

$rotas['^(home|index|)$'] = [
    'controle'  =>  '',
    'acao'      =>  ''
];


// Contatos recebidos do site --------------------------------------------------------------------------------------- //
$rotas['^(contatos-recebidos/lista|contatos-recebidos)$'] = [
    'controle'  =>  'ContatoSite',
    'acao'      =>  'mostrarlista'
];

$rotas['^contatos-recebidos/mostrar-detalhes/\d+$'] = [
    'controle'  =>  'ContatoSite',
    'acao'      =>  'mostrardetalhes',
    'params'    =>  '/-/-/:pk'
];

$rotas['^contatos-recebidos/apagar-contato$'] = [
    'controle'  =>  'ContatoSite',
    'acao'      =>  'remover'
];


// Assuntos para contato -------------------------------------------------------------------------------------------- //
$rotas['^(assuntos-contato/lista|assuntos-contato)$'] = [
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'mostrarlista'
];

$rotas['^assuntos-contato/novo(/[a-z]+)?$'] = [
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:mst'
];

$rotas['^assuntos-contato/(editar|alterar)/\d+$'] = [
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:pk'
];

$rotas['^assuntos-contato/remover-assunto$'] = [
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'remover'
];

$rotas['^assuntos-contato/salvar$'] = [
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'salvar'
];

$rotas['^assuntos-contato/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'alternarpublicacao',
    'params'    =>  '/-/-/:a'
];



// Tipos de dados para contato -------------------------------------------------------------------------------------- //
$rotas['^(tipos-de-dados/lista|tipos-de-dados)$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'mostrarlista'
];

$rotas['^tipos-de-dados/novo(/[a-z]+)?$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:mst'
];

$rotas['^tipos-de-dados/(editar|alterar)/\d+'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:pk'
];

$rotas['^tipos-de-dados/remover-tipo-de-dado$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'remover'
];

$rotas['^tipos-de-dados/salvar$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'salvar'
];

$rotas['^tipos-de-dados/carregar-select$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'carregarselect'
];

$rotas['^tipos-de-dados/opcoes-avancadas$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'opcoesavancadas'
];

$rotas['^tipos-de-dados/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'alternarpublicacao',
    'params'    =>  '/-/-/:a'
];


// Configurações do Google Analytics -------------------------------------------------------------------------------- //
$rotas['^(google-analytics/lista|google-analytics)$'] = [
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'mostrarlista'
];

$rotas['^google-analytics/novo(/[a-z]+)?$'] = [
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:mst'
];

$rotas['^google-analytics/(editar|alterar)/\d+'] = [
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:pk'
];

$rotas['^google-analytics/excluir-configuracao$'] = [
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'remover'
];

$rotas['^google-analytics/salvar$'] = [
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'salvar'
];

$rotas['^google-analytics/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'alternarpublicacao',
    'params'    =>  '/-/-/:a'
];


// Dados para contato ----------------------------------------------------------------------------------------------- //
$rotas['^(dados-para-contato/lista|dados-para-contato)$'] = [
    'controle'  =>  'DadoContato',
    'acao'      =>  'mostrarlista'
];

$rotas['^dados-para-contato/novo(/[a-z]+)?$'] = [
    'controle'  =>  'DadoContato',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:mst'
];

$rotas['^dados-para-contato/(editar|alterar)/\d+$'] = [
    'controle'  =>  'DadoContato',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:pk'
];

$rotas['^dados-para-contato/excluir-dados$'] = [
    'controle'  =>  'DadoContato',
    'acao'      =>  'remover'
];

$rotas['^dados-para-contato/salvar$'] = [
    'controle'  =>  'DadoContato',
    'acao'      =>  'salvar'
];

$rotas['^dados-para-contato/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'DadoContato',
    'acao'      =>  'alternarpublicacao',
    'params'    =>  '/-/-/:a'
];


// Álbum de fotos --------------------------------------------------------------------------------------------------- //
$rotas['^(albuns-de-fotos/lista|albuns-de-fotos)$'] = [
    'controle'  =>  'Album',
    'acao'      =>  'mostrarlista'
];

$rotas['^albuns-de-fotos/novo(/[a-z]+)?$'] = [
    'controle'  =>  'Album',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:mst'
];

$rotas['^albuns-de-fotos/(editar|alterar)/\d+$'] = [
    'controle'  =>  'Album',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:pk'
];

$rotas['^albuns-de-fotos/excluir-albuns$'] = [
    'controle'  =>  'Album',
    'acao'      =>  'remover'
];

$rotas['^albuns-de-fotos/salvar$'] = [
    'controle'  =>  'Album',
    'acao'      =>  'salvar'
];

$rotas['^albuns-de-fotos/alternar-publicacao/(publicar|ocultar)$'] = [
	'controle'  =>  'Album',
	'acao'      =>  'alternarpublicacao',
	'params'    =>  '/-/-/:a'
];

$rotas['^albuns-de-fotos/incluir-fotos$'] = [
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'upload'
];

$rotas['^albuns-de-fotos/salvar-foto$'] = [
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'salvar'
];

$rotas['^albuns-de-fotos/editar-foto/\d+(/[a-z]+)?$'] = [
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:pk/:mst'
];

$rotas['^albuns-de-fotos/excluir-fotos$'] = [
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'remover'
];


// Informações institucionais --------------------------------------------------------------------------------------- //
$rotas['^institucional$'] = [
    'controle'  =>  'Institucional',
    'acao'      =>  'mostrarinfos'
];

$rotas['^institucional/editar$'] = [
    'controle'  =>  'Institucional',
    'acao'      =>  'mostrarform'
];

$rotas['^institucional/salvar$'] = [
    'controle'  =>  'Institucional',
    'acao'      =>  'salvar'
];


// Configurações do site -------------------------------------------------------------------------------------------- //
$rotas['^configuracoes$'] = [
    'controle'  =>  'ConfiguracaoSite',
    'acao'      =>  'mostrarform'
];

$rotas['^configuracoes/salvar$'] = [
    'controle'  =>  'ConfiguracaoSite',
    'acao'      =>  'salvar'
];