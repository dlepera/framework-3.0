<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/01/2015 12:01:15
 */

# Nomes de modelos
define('TXT_MODELO_CONTATOSITE', 'site form');
define('TXT_MODELO_ASSUNTOCONTATO', 'subject');
define('TXT_MODELO_TIPODADOCONTATO', 'tipo de dado para contato');
define('TXT_MODELO_GOOGLEANALYTICS', 'configuração do google analytics');
define('TXT_MODELO_DADOCONTATO', 'contact data');
define('TXT_MODELO_ALBUM'. 'photo album');
define('TXT_MODELO_FOTO', 'photo');

# Títulos de páginas
define('TXT_TITULO_CONTATOS_RECEBIDOS', 'Received contacts');
define('TXT_TITULO_DETALHES_CONTATO', 'Contact details');
define('TXT_TITULO_CONTATO', 'Contact');
define('TXT_TITULO_ENVIO_EMAIL', 'E-mail send');
define('TXT_TITULO_ASSUNTOS_CONTATO', 'Subjects');
define('TXT_TITULO_NOVO_ASSUNTO', 'Inser a new subject');
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
define('TXT_TITULO_QUEM_LEU', 'Who read?');
define('TXT_TITULO_HISTORIA', 'History');
define('TXT_TITULO_MISSAO', 'Mission');
define('TXT_TITULO_VISAO', 'Vision');
define('TXT_TITULO_VALORES', 'Values');
define('TXT_TITULO_INFOS_INSTITUCIONAIS', 'Institucional information');
define('TXT_TITULO_EDITAR_INSTITUCIONAL', 'Editar informações institucionais');

# Tabelas
# -> Títulos
define('TXT_TABELA_TITULO_DATA', 'Date');
define('TXT_TABELA_TITULO_ASSUNTO', 'Subject');
define('TXT_TABELA_TITULO_NOME', 'Name');
define('TXT_TABELA_TITULO_EMAIL', 'E-mail');
define('TXT_TABELA_TITULO_DESCR', 'Description');
define('TXT_TABELA_TITULO_REDE_SOCIAL', 'Social network?');
define('TXT_TABELA_TITULO_APELIDO', 'Nickname');
define('TXT_TABELA_TITULO_USUARIO', 'User');
define('TXT_TABELA_TITULO_PERFIL', 'Profile');
define('TXT_TABELA_TITULO_PRINCIPAL', 'Default?');
define('TXT_TABELA_TITULO_TIPO', 'Type');

# Formulários
# -> Legendas
define('TXT_LEGENDA_CONTA_GOOGLE', 'Google Account');
define('TXT_LEGENDA_CONFIGURACOES', 'Configurations');
define('TXT_LEGENDA_ALBUM_FOTOS', 'Photo albums');
define('TXT_LEGENDA_FOTOS', 'Photo\'s album');
define('TXT_LEGENDA_OPCOES_AVANCADAS', 'Advanced options');
define('TXT_LEGENDA_TIPO_DADO', 'Data type');
define('TXT_LEGENDA_HISTORIA', 'History');
define('TXT_LEGENDA_MISSAO', 'Mission');
define('TXT_LEGENDA_VISAO', 'Vision');
define('TXT_LEGENDA_VALORES', 'Values');

# -> Campos
define('TXT_ROTULO_NOME', 'Name');
define('TXT_ROTULO_EMAIL', 'E-mail');
define('TXT_ROTULO_TELEFONE', 'Phone');
define('TXT_ROTULO_MENSAGEM', 'Messagee');
define('TXT_ROTULO_ASSUNTO', 'Subject');
define('TXT_ROTULO_STATUS', 'Status');
define('TXT_ROTULO_DT_ENVIO', 'Send date');
define('TXT_ROTULO_MSG_ERRO', 'Error message');
define('TXT_ROTULO_DATA', 'Date');
define('TXT_ROTULO_DESCR', 'Description');
define('TXT_ROTULO_COR', 'Color');
define('TXT_ROTULO_ICONE', 'Icon');
define('TXT_ROTULO_REDE_SOCIAL', 'Social network?');
define('TXT_ROTULO_PRINCIPAL', 'Default?');
define('TXT_ROTULO_APELIDO', 'Neckname (opcional)');
define('TXT_ROTULO_USUARIO', 'User');
define('TXT_ROTULO_SENHA', 'Password');
define('TXT_ROTULO_PERFIL', 'Profile');
define('TXT_ROTULO_TIPO', 'Type');
define('TXT_ROTULO_FOTOS', 'Photos');
define('TXT_ROTULO_TITULO', 'Title');
define('TXT_ROTULO_CAPA', 'Is the cover?');
define('TXT_ROTULO_CODIGO_UA', 'UA code');
define('TXT_ROTULO_MASCARA', 'Mask');
define('TXT_ROTULO_EXPREG', 'Regular expression');

# -> Botões
define('TXT_BOTAO_SALVAR_FOTOS', 'Save photos');

# -> Dicas
define('MSG_DICA_ALBUMFOTO_CAPA', 'Defines this photo like a album cover.');
define('TXT_DICA_TIPODADO_MASCARA', 'Defines a mask like to record.<br/>'
        . '<b>Ex.:</b> Phone - (##) ####-####<br/>'
        . '<b>Obs.:</b> The # character represent eithr character. Os demais caracteres presentes na máscara ficarão fixos!');
define('TXT_DICA_TIPODADO_EXPREG', 'Expressão regular para ser usada na validação do registro inserido.');

# Links
define('TXT_LINK_NOVO_ASSUNTO', 'New subject');
define('TXT_LINK_NOVO_TIPO_DADO', 'Novo tipo de dado para contato');
define('TXT_LINK_NOVO_GA', 'New configuration');
define('TXT_LINK_NOVO_DADOCONTATO', 'Novo dado para contato');
define('TXT_LINK_NOVO_ALBUM', 'New album');
define('TXT_LINK_EDITAR_INFOS_INSTITUCIONAIS', 'Set the institucional informations');

# Mensagens diversas
define('MSG_CONTATO_DT_ENVIO', 'Contact sended on %s');
define('MSG_EMAIL_ENVIADO', 'E-mail sended');
define('MSG_EMAIL_FALHOU', 'O envio do e-mail falhou');
define('MSG_CAPA', 'Cover');
define('MSG_GA_ALERTA_UTILIZACAO_MUITOS', '<b>Warning!</b> A utilização de muitas contas do Google Analytics pode prejudicar o desempenho do site.');



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