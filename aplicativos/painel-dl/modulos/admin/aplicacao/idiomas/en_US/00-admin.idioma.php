<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 10:08:52
 */

# Names de modelos
define('TXT_MODELO_GRUPOUSUARIO', 'user group');
define('TXT_MODELO_USUARIO', 'user');
define('TXT_MODELO_CONFIGEMAIL', 'e-mail send configuration');

# Títulos de páginas
define('TXT_PAGINA_TITULO_GRUPOS_USUARIOS', 'Users groups');
define('TXT_PAGINA_TITULO_NOVO_GRUPOUSUARIO', 'Insert a new user group');
define('TXT_PAGINA_TITULO_EDITAR_GRUPOUSUARIO', 'Update this user group');
define('TXT_PAGINA_TITULO_USUARIOS', 'Users');
define('TXT_PAGINA_TITULO_NOVO_USUARIO', 'Insert a new user');
define('TXT_PAGINA_TITULO_EDITAR_USUARIO', 'Update the user information');
define('TXT_PAGINA_TITULO_CONFIGURACOES_ENVIO_EMAIL', 'Send e-mail configurations');
define('TXT_PAGINA_TITULO_NOVO_CONFIGEMAIL', 'Insert a new e-mail configuration');
define('TXT_PAGINA_TITULO_EDITAR_CONFIGEMAIL', 'Update this e-mail configuration');

# Links
define('TXT_LINK_NOVO_GRUPO_USUARIO', 'New user group');
define('TXT_LINK_NOVO_USUARIO', 'New user');
define('TXT_LINK_NOVO_IDIOMA', 'New language');
define('TXT_LINK_NOVO_TEMA', 'New skin');
define('TXT_LINK_NOVO_CONFIGEMAIL', 'New e-mail configuration');
define('TXT_LINK_TESTAR_CONFIGURACAO', 'Configuration test');

# Tabelas
# -> Títulos
define('TXT_LISTA_TITULO_DESCR', 'Description');
define('TXT_LISTA_TITULO_GRUPO', 'Group');
define('TXT_LISTA_TITULO_NOME', 'Name');
define('TXT_LISTA_TITULO_EMAIL', 'E-mail');
define('TXT_LISTA_TITULO', 'Title');
define('TXT_LISTA_HOST', 'Host');
define('TXT_LISTA_PRINCIPAL', 'Default?');

# Formulários
# -> Legendas
define('TXT_LEGENDA_DADOS_PESSOAIS', 'Personal data');
define('TXT_LEGENDA_PREFERENCIAS', 'Preferences');
define('TXT_LEGENDA_ACESSO_SISTEMA', 'System access');
define('TXT_LEGENDA_SERVIDOR', 'SMTP Server');
define('TXT_LEGENDA_AUTENTICACAO', 'Auth');
define('TXT_LEGENDA_CONFIGURACOES_ENVIO', 'Send configuration');
define('TXT_LEGENDA_GRUPO', 'Group');
define('TXT_LEGENDA_MEMBROS', 'Members');
define('TXT_LEGENDA_PERMISSOES', 'Permissions');

# -> Rótulos
define('TXT_ROTULO_DESCR', 'Description');
define('TXT_ROTULO_NOME', 'Name');
define('TXT_ROTULO_EMAIL', 'E-mail');
define('TXT_ROTULO_TELEFONE', 'Phone');
define('TXT_ROTULO_SEXO', 'Genre');
define('TXT_ROTULO_IDIOMA', 'Language');
define('TXT_ROTULO_TEMA', 'Skin');
define('TXT_ROTULO_FORMATO_DATA', 'Date format');
define('TXT_ROTULO_NUM_REGISTROS', 'Number of records');
define('TXT_ROTULO_EXIBIR_ID', 'Show ID?');
define('TXT_ROTULO_FILTRO_MENU', 'Show the menu filter?');
define('TXT_ROTULO_GRUPO', 'Group');
define('TXT_ROTULO_LOGIN', 'Login');
define('TXT_ROTULO_SENHA', 'Password');
define('TXT_ROTULO_CONF_SENHA', 'Password confirm');
define('TXT_ROTULO_RESET', 'Reset password on next login');
define('TXT_ROTULO_BLOQ', 'Block user');
define('TXT_ROTULO_TITULO', 'Title');
define('TXT_ROTULO_HOST', 'Host');
define('TXT_ROTULO_REQUER_AUTENT', 'Auth is required?');
define('TXT_ROTULO_TIPO_CRIPTO', 'Crypt type');
define('TXT_ROTULO_CONTA', 'Account');
define('TXT_ROTULO_DE_NOME', 'From (name)');
define('TXT_ROTULO_DE_EMAIL', 'From (e-mail)');
define('TXT_ROTULO_RESPONDER_PARA', 'Reply to');
define('TXT_ROTULO_HTML', 'HTML?');
define('TXT_ROTULO_PRINCIPAL', 'Default?');
define('TXT_ROTULO_SELECIONAR_TODOS', 'Select all');

# -> Dicas
define('TXT_DICA_EXIBIR_ID', 'Do you want see the record ID on the lists?');
define('TXT_DICA_FILTRO_MENU', 'Show a filter to menu');

# -> Opções
define('TXT_OPCAO_MASCULINO', 'Male');
define('TXT_OPCAO_FEMININO', 'Female');
define('TXT_OPCAO_NENHUMA', 'None');
define('TXT_OPCAO_TLS', 'TLS - Transport Layer Security');
define('TXT_OPCAO_SSL', 'SSL - Secure Socket Layer');

# Mensagens diversas
define('MSG_DICA_USUARIO_RESET', 'Força o user a resetar sua senha imediatamente ao próximo login.');
define('MSG_DICA_USUARIO_BLOQ', 'Bloqueia a conta de user para fazer login no sistema.');
define('MSG_DICA_USUARIO_NUM_REGISTROS', 'Define a quantidade de registros a serem exibidos por página');
define('MSG_DICA_EMAIL_HTML', 'When this option is checked the e-mail is send in HTML format.');
define('MSG_DICA_EMAIL_PRINCIPAL', 'Define qual configuração será usada para o envio quando mais de uma configuração for cadastrada no sisskin.');
define('MSG_USUARIO_BLOQUEADO', '<b>Warning: </b> This user is blocked and don\'t have access on this system.');
define('MSG_USUARIO_ALTERAR_FOTO', 'Set photo');

# E-mails
# -> Assuntos
define('TXT_EMAIL_ASSUNTO_TESTE', 'Test configuration');

# -> Conteúdos
define('TXT_EMAIL_CONTEUDO_TESTE', 'Este é apenas um teste da configuração.');



/**
 * Admin\Modelo\ConfigEmail
 * -----------------------------------------------------------------------------
 */
# Sucessos
define('SUCESSO_CONFIGEMAIL_TESTAR', 'A configuração foi testada com sucesso!');

# Erros
define('ERRO_CONFIGEMAIL_TESTAR', 'Erro! A configuração não conseguiu enviar o e-mail de teste.<p>%s</p>');



/**
 * Admin\Modelo\Usuario
 * Admin\Controle\Usuario
 * -----------------------------------------------------------------------------
 */
# Sucessos
define('SUCESSO_USUARIO_ALTERARSENHA', 'Password changed successfully!');
define('SUCESSO_USUARIO_BLOQUEAR_UM', 'User blocked successfully!');
define('SUCESSO_USUARIO_BLOQUEAR_VARIOS', 'Foram bloqueados %d users de um total de %d seleccionados!');
define('SUCESSO_USUARIO_DESBLOQUEAR_UM', 'User unblocked successfully!!');
define('SUCESSO_USUARIO_DESBLOQUEAR_VARIOS', 'foram desbloqueados %d users de um total de %d selecionados!');

# Erros
define('ERRO_USUARIO_ALTERARSENHA_USUARIO_NAO_ENCONTRADO', '<b>Erro ao tentar alterar sua senha</b><p>O user não foi localizado.</p>');
define('ERRO_USUARIO_ALTERARSENHA_SENHA_ATUAL_INCORRETA', '<b>Erro ao tentar alterar sua senha</b><p>A senha atual informada está incorreta.</p>');
define('ERRO_USUARIO_ALTERSENHA_SENHAS_NAO_COINCIDEM', '<b>Erro ao tentar alterar sua senha</b><p>As news senhas informadas devem ser iguais.</p>');
define('ERRO_USUARIO_BLOQUEAR', '<b>Erro ao tentar bloquear o(s) user(s)</b><p>Nenhum user foi bloqueado.</p>');
define('ERRO_USUARIO_DESBLOQUEAR', '<b>Erro ao tentar desbloquear o(s) user(s)</b><p>Nenhum user foi desbloqueado.</p>');
define('ERRO_USUARIO_SALVAR_EMAIL_JA_CADASTRADO', '<b>Invalid e-mail!</b><p>O e-mail informado já está sendo usado por outro user.</p>');