<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 10:08:07
 */

$rotas['^(home|index|)$'] = array(
    'controle'  =>  '',
    'acao'      =>  ''
);



/*
 * Grupos de usuários
 * -----------------------------------------------------------------------------
 */
$rotas['^(grupos-de-usuarios/lista|grupos-de-usuarios)$'] = array(
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'mostrarlista'
);

$rotas['^grupos-de-usuarios/novo(/[a-z]+)?$'] = array(
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'mostrarform',
    'id'        =>  null,
    'params'    =>  '/-/-/:mst'
);

$rotas['^grupos-de-usuarios/(editar|alterar)/\d+'] = array(
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:pk'
);

$rotas['^grupos-de-usuarios/salvar$'] = array(
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'salvar'
);

$rotas['^grupos-de-usuarios/excluir-grupo$'] = array(
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'remover'
);

$rotas['^grupos-de-usuarios/carregar-select$'] = array(
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'carregarselect'
);

$rotas['^grupos-de-usuarios/alternar-publicacao/(publicar|ocultar)$'] = array(
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'alternarpublicacao',
    'params'    =>  '/-/-/:a'
);



/*
 * Usuários
 * -----------------------------------------------------------------------------
 */
$rotas['^(usuarios/lista|usuarios)$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'mostrarlista'
);

$rotas['^usuarios/novo$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'mostrarform'
);

$rotas['^usuarios/(editar|alterar)/\d+$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:pk'
);

$rotas['^usuarios/salvar$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'salvar'
);

$rotas['^usuarios/excluir-usuarios$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'remover'
);

$rotas['^usuarios/minha-conta$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'minhaconta'
);

$rotas['^usuarios/alterar-minha-senha$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'formalterarsenha'
);

$rotas['^usuarios/alterar-senha-usuario$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'alterarsenha'
);

$rotas['^usuarios/bloquear-usuarios$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'bloquear',
    'vlr'       =>  1
);

$rotas['^usuarios/desbloquear-usuarios$'] = array(
    'controle'  =>  'Usuario',
    'acao'      =>  'bloquear',
    'vlr'       =>  0
);



/*
 * Configuração de envio de e-mails
 * -----------------------------------------------------------------------------
 */
$rotas['^(envio-de-emails/lista|envio-de-emails)$'] = array(
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'mostrarlista'
);

$rotas['^envio-de-emails/novo$'] = array(
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'mostrarform'
);

$rotas['^envio-de-emails/(editar|alterar)/\d+'] = array(
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'mostrarform',
    'params'    =>  '/-/-/:pk'
);

$rotas['^envio-de-emails/salvar$'] = array(
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'salvar'
);

$rotas['^envio-de-emails/excluir-configuracao$'] = array(
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'remover'
);

$rotas['^envio-de-emails/testar-configuracao/\d+$'] = array(
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'testar',
    'params'    =>  '/-/-/:pk'
);