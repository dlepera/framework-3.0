<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/01/2015 12:00:59
 */

$rotas['^(home|index|)$'] = array(
    'controle'  =>  '',
    'acao'      =>  ''
);



/**
 * Contatos recebidos do site
 * -----------------------------------------------------------------------------
 */
$rotas['^(contatos-recebidos/lista|contatos-recebidos)$'] = array(
    'controle'  =>  'ContatoSite',
    'acao'      =>  'mostrarlista'
);

$rotas['^contatos-recebidos/mostrar-detalhes/\d+$'] = array(
    'controle'  =>  'ContatoSite',
    'acao'      =>  'mostrardetalhes',
    'params'    =>  '/-/-/:id'
);

$rotas['^contatos-recebidos/apagar-contato$'] = array(
    'controle'  =>  'ContatoSite',
    'acao'      =>  'remover'
);



/**
 * Assuntos para contato
 * -----------------------------------------------------------------------------
 */
$rotas['^(assuntos-contato/lista|assuntos-contato)$'] = array(
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'mostrarlista'
);

$rotas['^assuntos-contato/novo(/[0-1]{1})?$'] = array(
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:tr'
);

$rotas['^assuntos-contato/(editar|alterar)/\d+$'] = array(
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:id'
);

$rotas['^assuntos-contato/remover-assunto$'] = array(
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'remover'
);

$rotas['^assuntos-contato/salvar$'] = array(
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'salvar'
);



/**
 * Tipos de dados para contato
 * -----------------------------------------------------------------------------
 */
$rotas['^(tipos-de-dados/lista|tipos-de-dados)$'] = array(
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'mostrarlista'
);

$rotas['^tipos-de-dados/novo(/[0-1]{1})?$'] = array(
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:tr'
);

$rotas['^tipos-de-dados/(editar|alterar)/\d+'] = array(
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:id'
);

$rotas['^tipos-de-dados/remover-tipo-de-dado$'] = array(
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'remover'
);

$rotas['^tipos-de-dados/salvar$'] = array(
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'salvar'
);

$rotas['^tipos-de-dados/carregar-select$'] = array(
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'carregarselect'
);

$rotas['^tipos-de-dados/opcoes-avancadas$'] = array(
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'opcoesavancadas'
);



/**
 * Configurações do Google Analytics
 * -----------------------------------------------------------------------------
 */
$rotas['^(google-analytics/lista|google-analytics)$'] = array(
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'mostrarlista'
);

$rotas['^google-analytics/novo(/[0-1]{1})?$'] = array(
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:tr'
);

$rotas['^google-analytics/(editar|alterar)/\d+'] = array(
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:id'
);

$rotas['^google-analytics/excluir-configuracao$'] = array(
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'remover'
);

$rotas['^google-analytics/salvar$'] = array(
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'salvar'
);



/**
 * Dados para contato
 * -----------------------------------------------------------------------------
 */
$rotas['^(dados-para-contato/lista|dados-para-contato)$'] = array(
    'controle'  =>  'DadoContato',
    'acao'      =>  'mostrarlista'
);

$rotas['^dados-para-contato/novo(/[0-1]{1})?$'] = array(
    'controle'  =>  'DadoContato',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:tr'
);

$rotas['^dados-para-contato/(editar|alterar)/\d+$'] = array(
    'controle'  =>  'DadoContato',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:id'
);

$rotas['^dados-para-contato/excluir-dados$'] = array(
    'controle'  =>  'DadoContato',
    'acao'      =>  'remover'
);

$rotas['^dados-para-contato/salvar$'] = array(
    'controle'  =>  'DadoContato',
    'acao'      =>  'salvar'
);



/**
 * Álbum de fotos
 * -----------------------------------------------------------------------------
 */
$rotas['^(albuns-de-fotos/lista|albuns-de-fotos)$'] = array(
    'controle'  =>  'Album',
    'acao'      =>  'mostrarlista'
);

$rotas['^albuns-de-fotos/novo(/[0-1]{1})?$'] = array(
    'controle'  =>  'Album',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:tr'
);

$rotas['^albuns-de-fotos/(editar|alterar)/\d+$'] = array(
    'controle'  =>  'Album',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:id'
);

$rotas['^albuns-de-fotos/excluir-albuns$'] = array(
    'controle'  =>  'Album',
    'acao'      =>  'remover'
);

$rotas['^albuns-de-fotos/salvar$'] = array(
    'controle'  =>  'Album',
    'acao'      =>  'salvar'
);

$rotas['^albuns-de-fotos/incluir-fotos$'] = array(
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'upload'
);

$rotas['^albuns-de-fotos/salvar-foto$'] = array(
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'salvar'
);

$rotas['^albuns-de-fotos/editar-foto/\d+(/[0-1{1}])?$'] = array(
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:id/:tr'
);

$rotas['^albuns-de-fotos/excluir-fotos$'] = array(
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'remover'
);