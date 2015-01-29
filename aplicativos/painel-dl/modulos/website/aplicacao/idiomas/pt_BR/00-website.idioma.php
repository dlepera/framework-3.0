<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/01/2015 12:01:15
 */

# Nomes de modelos
define('TXT_MODELO_CONTATOSITE', 'contato do site');
define('TXT_MODELO_ASSUNTOCONTATO', 'assunto de contato');
define('TXT_MODELO_TIPODADOCONTATO', 'Tipo de dado para contato');
define('TXT_MODELO_GOOGLEANALYTICS', 'configuração do google analytics');
define('TXT_MODELO_DADOCONTATO', 'dado para contato');
define('TXT_MODELO_ALBUM'. 'álbum de fotos');
define('TXT_MODELO_FOTO', 'foto');

# Títulos de páginas
define('TXT_TITULO_CONTATOS_RECEBIDOS', 'Contatos recebidos');
define('TXT_TITULO_DETALHES_CONTATO', 'Detalhes do contato');
define('TXT_TITULO_CONTATO', 'Contato');
define('TXT_TITULO_ENVIO_EMAIL', 'Envio do e-mail');
define('TXT_TITULO_ASSUNTOS_CONTATO', 'Assuntos de contato');
define('TXT_TITULO_NOVO_ASSUNTO', 'Cadastrar um novo assunto de contato');
define('TXT_TITULO_EDITAR_ASSUNTO', 'Editar esse assunto de contato');
define('TXT_TITULO_TIPOS_DADO_CONTATO', 'Tipos de dados para contato');
define('TXT_TITULO_NOVO_TIPO_DADO', 'Cadastrar um novo tipo de dado para contato');
define('TXT_TITULO_EDITAR_TIPO_DADO', 'Editar esse tipo de dado para contato');
define('TXT_TITULO_CONFIGURACOES_GA', 'Configurações do Google Analytics');
define('TXT_TITULO_NOVO_GA', 'Nova configuração do Google Analytics');
define('TXT_TITULO_EDITAR_GA', 'Editar essa configuração do Google Analytics');
define('TXT_TITULO_DADOS_CONTATO', 'Dados para contato');
define('TXT_TITULO_NOVO_DADOCONTATO', 'Cadastrar um novo dado para contato');
define('TXT_TITULO_EDITAR_DADOCONTATO', 'Editar esse dado para contato');
define('TXT_TITULO_ALBUNS_FOTOS', 'Álbuns de fotos');
define('TXT_TITULO_NOVO_ALBUM', 'Cadastrar um novo álbum de fotos');
define('TXT_TITULO_EDITAR_ALBUM', 'Editar esse álbum de fotos');
define('TXT_TITULO_EDITAR_FOTO', 'Editar as informações dessa foto');

# Tabelas
# -> Títulos
define('TXT_TABELA_TITULO_DATA', 'Data');
define('TXT_TABELA_TITULO_ASSUNTO', 'Assunto');
define('TXT_TABELA_TITULO_NOME', 'Nome');
define('TXT_TABELA_TITULO_EMAIL', 'E-mail');
define('TXT_TABELA_TITULO_DESCR', 'Descrição');
define('TXT_TABELA_TITULO_REDE_SOCIAL', 'Rede Social?');
define('TXT_TABELA_TITULO_USUARIO', 'Usuário');
define('TXT_TABELA_TITULO_PERFIL', 'Perfil');
define('TXT_TABELA_TITULO_ATIVO', 'Ativo?');
define('TXT_TABELA_TITULO_TIPO', 'Tipo');

# Formulários
# -> Legendas
define('TXT_LEGENDA_CONTA_GOOGLE', 'Conta Google');
define('TXT_LEGENDA_CONFIGURACOES', 'Configurações');
define('TXT_LEGENDA_ALBUM_FOTOS', 'Álbum de fotos');
define('TXT_LEGENDA_FOTOS', 'Fotos do álbum');

# -> Campos
define('TXT_LABEL_NOME', 'Nome');
define('TXT_LABEL_EMAIL', 'E-mail');
define('TXT_LABEL_TELEFONE', 'Telefone');
define('TXT_LABEL_MENSAGEM', 'Mensagem');
define('TXT_LABEL_ASSUNTO', 'Assunto');
define('TXT_LABEL_STATUS', 'Status');
define('TXT_LABEL_DT_ENVIO', 'Data do envio');
define('TXT_LABEL_MSG_ERRO', 'Mensagem de erro');
define('TXT_LABEL_DATA', 'Data');
define('TXT_LABEL_DESCR', 'Descrição');
define('TXT_LABEL_COR', 'Cor');
define('TXT_LABEL_ICONE', 'Ícone');
define('TXT_LABEL_REDE_SOCIAL', 'Rede social?');
define('TXT_LABEL_ATIVAR', 'Ativar?');
define('TXT_LABEL_USUARIO', 'Usuário');
define('TXT_LABEL_SENHA', 'Senha');
define('TXT_LABEL_PERFIL', 'Perfil');
define('TXT_LABEL_TIPO', 'Tipo');
define('TXT_LABEL_FOTOS', 'Fotos');
define('TXT_LABEL_TITULO', 'Título');
define('TXT_LABEL_CAPA', 'É a capa?');
define('TXT_LABEL_CODIGO_UA', 'Código UA');

# -> Botões
define('TXT_BOTAO_SALVAR_FOTOS', 'Salvar fotos');

# -> Dicas
define('MSG_DICA_ALBUMFOTO_CAPA', 'Definir essa foto como a capa do álbum.');

# Links
define('TXT_LINK_NOVO_ASSUNTO', 'Novo assunto');
define('TXT_LINK_NOVO_TIPO_DADO', 'Novo tipo de dado para contato');
define('TXT_LINK_NOVO_GA', 'Nova configuração');
define('TXT_LINK_NOVO_DADOCONTATO', 'Novo dado para contato');
define('TXT_LINK_NOVO_ALBUM', 'Novo ábum');

# Mensagens diversas
define('MSG_CONTATO_DT_ENVIO', 'Contato enviado em %s');
define('MSG_EMAIL_ENVIADO', 'E-mail enviado');
define('MSG_EMAIL_FALHOU', 'O envio do e-mail falhou');
define('MSG_CAPA', 'Capa');



/**
 * WebSite\Controle\ContatoSite
 * -----------------------------------------------------------------------------
 */
# Erros
define('ERRO_CONTATOSITE_MOSTRADETALHES_NAO_ENCONTRADO', '<b>Erro!</b><p>O contato solicitado não foi encontrado.</p>');



/**
 * WebSite\Modelo\FotoAlbum
 * -----------------------------------------------------------------------------
 */
# Sucessos
define('SUCESSO_FOTOALBUM_UPLOAD', 'Fotos salvas com sucesso!');

# Erros
define('ERRO_FOTOALBUM_UPLOAD_NENHUM_ARQUIVO_ENVIADO', '<b>Erro!</b><p>Nenhuma foto foi enviada.<br/>Por favor, selecione uma ou mais fotos e tente novamente.</p>');
define('ERRO_FOTOALBUM_UPLOAD_SALVAR', '<b>Ocorreu um erro ao tentar salvar as fotos</b><p>As fotos não puderam ser salvas.<br/>Por favor, tente novamente mais tarde.</p>');