<?php
/**
 * Created by PhpStorm.
 * User: dlepera
 * Date: 28/08/15
 * Time: 16:00
 */

// Modelos ---------------------------------------------------------------------------------------------------------- //
define('TXT_MODELO_GRUPOUSUARIO', 'user group');
define('TXT_MODELO_USUARIO', 'user');
define('TXT_MODELO_CONFIGEMAIL', 'configuration email');
define('TXT_MODELO_TEMA', 'skin');
define('TXT_MODELO_IDIOMA', 'language');


// Páginas ---------------------------------------------------------------------------------------------------------- //
# -> Titles
define('TXT_PAGINA_TITULO_GRUPOS_USUARIOS', 'Users groups');
define('TXT_PAGINA_TITULO_USUARIOS', 'Users');
define('TXT_PAGINA_TITULO_CONFIGURACOES_ENVIO_EMAIL', 'Email configurations');


// Links ------------------------------------------------------------------------------------------------------------ //
define('TXT_LINK_TESTAR_CONFIGURACAO', 'Send test');

# -> Title
define('TXT_LINK_TITLE_TESTAR_CONFIGURACAO_EMAIL', 'Send a test e-mail');


// Listas ----------------------------------------------------------------------------------------------------------- //
# -> Titles
define('TXT_LISTA_TITULO_DESCR', 'Description');
define('TXT_LISTA_TITULO_GRUPO', 'Group');
define('TXT_LISTA_TITULO_NOME', 'Name');
define('TXT_LISTA_TITULO_EMAIL', 'E-mail');
define('TXT_LISTA_TITULO', 'Title');
define('TXT_LISTA_TITULO_HOST', 'Host');
define('TXT_LISTA_TITULO_PRINCIPAL', 'Is default?');
define('TXT_LISTA_TITULO_BLOQUEADO', 'Is blocked?');


// Formulários ------------------------------------------------------------------------------------------------------ //
# -> Legendas
define('TXT_LEGENDA_DADOS_PESSOAIS', 'Personal data');
define('TXT_LEGENDA_PREFERENCIAS', 'Preferrences');
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
define('TXT_ROTULO_SEXO', 'Gender');
define('TXT_ROTULO_IDIOMA', 'Language');
define('TXT_ROTULO_TEMA', 'Skin');
define('TXT_ROTULO_FORMATO_DATA', 'Date format');
define('TXT_ROTULO_NUM_REGISTROS', 'Number of records');
define('TXT_ROTULO_EXIBIR_ID', 'Show ID?');
define('TXT_ROTULO_FILTRO_MENU', 'Show filter menu?');
define('TXT_ROTULO_GRUPO', 'Group');
define('TXT_ROTULO_LOGIN', 'Login name');
define('TXT_ROTULO_SENHA', 'Password');
define('TXT_ROTULO_CONF_SENHA', 'Password confirm');
define('TXT_ROTULO_RESET', 'Password will need been reseted on next login');
define('TXT_ROTULO_BLOQ', 'Block logon on system');
define('TXT_ROTULO_TITULO', 'Title');
define('TXT_ROTULO_HOST', 'Host');
define('TXT_ROTULO_REQUER_AUTENT', 'Require auth?');
define('TXT_ROTULO_TIPO_CRIPTO', 'Crypt type');
define('TXT_ROTULO_CONTA', 'Account');
define('TXT_ROTULO_DE_NOME', 'From (name)');
define('TXT_ROTULO_DE_EMAIL', 'From (e-mail)');
define('TXT_ROTULO_RESPONDER_PARA', 'Reply to');
define('TXT_ROTULO_HTML', 'HTML?');
define('TXT_ROTULO_PRINCIPAL', 'Is default?');
define('TXT_ROTULO_SELECIONAR_TODOS', 'Select all');
define('TXT_ROTULO_DEBUG', 'Enable debug?');
define('TXT_ROTULO_SENHA_NOVA', 'New password');
define('TXT_ROTULO_SENHA_NOVA_CONF', 'Password confirm');

# -> Dicas
define('TXT_DICA_EXIBIR_ID', 'Do you want to see the record ID lists?');
define('TXT_DICA_FILTRO_MENU', 'Shows a filter to search for menu items');
define('TXT_DICA_USUARIO_RESET', 'Forces the user to reset your password immediately to the next login.');
define('TXT_DICA_USUARIO_BLOQ', 'Blocks the user account to log into the system.');
define('TXT_DICA_USUARIO_NUM_REGISTROS', 'Sets the amount of records to display per page');
define('TXT_DICA_EMAIL_HTML', 'When this option is selected, the e-mails are sent in HTML format. Otherwise, only plain text without formatting.');
define('TXT_DICA_EMAIL_PRINCIPAL', 'Define which configuration will be used for sending when more than one setting is registered in the system.');
define('TXT_DICA_DEBUG', 'Enable PHPMailer debugger makes the class display more detailed messages for better understanding errors.');

# -> Exemplos
define('TXT_EXEMPLO_HOST_SMTP', 'E.g.: smtp.domain.com.br');
define('TXT_EXEMPLO_EMAIL', 'E.g.: yourname@domain.com.br');

# -> Opções
define('TXT_OPCAO_MASCULINO', 'Male');
define('TXT_OPCAO_FEMININO', 'Female');
define('TXT_OPCAO_NENHUMA', 'Noen');
define('TXT_OPCAO_TLS', 'TLS - Transport Layer Security');
define('TXT_OPCAO_SSL', 'SSL - Secure Socket Layer');


// Diversos --------------------------------------------------------------------------------------------------------- //
define('MSG_USUARIO_BLOQUEADO', "<b>Attention:</b> This user is blocked and haven't access to system.");
define('MSG_USUARIO_ALTERAR_FOTO', 'Change photo');


// E-mails ---------------------------------------------------------------------------------------------------------- //
# -> Assuntos
define('TXT_EMAIL_ASSUNTO_TESTE', 'Configuration test');

# -> Conteúdos
define('TXT_EMAIL_CONTEUDO_TESTE', <<<HTML
This is only a test of configuration (%s).<br/>
SMTP: %s:%d<br/>
Source: %s
HTML
);


// Classes ---------------------------------------------------------------------------------------------------------- //
/*
 * AdminM\Usuario()
 * AdminC\Usuario()
 */
# Sucessos
define('SUCESSO_USUARIO_ALTERARSENHA', 'Your password has changed successfully!');
define('SUCESSO_USUARIO_BLOQUEAR_UM', 'User blocked successfully!');
define('SUCESSO_USUARIO_BLOQUEAR_VARIOS', '%d were blocked users a total of %d selected!');
define('SUCESSO_USUARIO_DESBLOQUEAR_UM', 'User unblocked successfully!');
define('SUCESSO_USUARIO_DESBLOQUEAR_VARIOS', '%d were unblocked users a total of %d selected!');
define('SUCESSO_USUARIOS_SALVAR_FOTO', 'Profile photo saved successfully!');

# Erros
define('ERRO_USUARIO_ALTERARSENHA_USUARIO_NAO_ENCONTRADO', '<b>Error trying to change your password</b><p>User was not found..</p>');
define('ERRO_USUARIO_ALTERARSENHA_SENHA_ATUAL_INCORRETA', '<b>Error trying to change your password</b><p>Current password is incorrect.</p>');
define('ERRO_USUARIO_ALTERSENHA_SENHAS_NAO_COINCIDEM', '<b>Error trying to change your password</b><p>New passwords not match.</p>');
define('ERRO_USUARIO_BLOQUEAR', '<b>Error trying to block user(s)</b><p>No user blocked.</p>');
define('ERRO_USUARIO_DESBLOQUEAR', '<b>Error trying to block user(s)</b><p>No user unblocked.</p>');
define('ERRO_USUARIO_SALVAR_LOGIN_JA_CADASTRADO', '<b>Invalid login!</b><p>This login is already in use for another user.</p><p>Please, choose a different login.</p>');
define('ERRO_USUARIO_SALVAR_EMAIL_JA_CADASTRADO', '<b>Invalid email!</b><p>O e-mail informado já está sendo usado por outro user.</p><p>Please, choose a different email.</p>');
define('ERRO_USUARIO_SALVAR_FOTO_OUTRO_USUARIO', 'You can not save photos to the profile of another user!');
define('ERRO_USUARIO_VALIDAR_SENHA_IGUAL_LOGIN', 'The password can not be the same login used by the user!');


/*
 * AdminM\ConfigEmail()
 */
# Sucessos
define('SUCESSO_CONFIGEMAIL_TESTAR', 'Configuration test is successfully!');

# Erros
define('ERRO_CONFIGEMAIL_TESTAR', "Error! Test email was not sent.<p>%s</p>");