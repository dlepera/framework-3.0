<?php
/**
 * Created by PhpStorm.
 * User: dlepera
 * Date: 28/08/15
 * Time: 16:00
 */

// Modelos ---------------------------------------------------------------------------------------------------------- //


// Páginas ---------------------------------------------------------------------------------------------------------- //
# -> Títulos
define('TXT_PAGINA_TITULO_LOGIN', 'System access');
define('TXT_PAGINA_TITULO_ESQUECI_MINHA_SENHA', 'I forgot my password');
define('TXT_PAGINA_TITULO_MOSTRARRESETSENHA', 'Reset password');


// Links ------------------------------------------------------------------------------------------------------------ //
define('TXT_LINK_ESQUECI_MINHA_SENHA', 'I forgot my password');
define('TXT_LINK_VOLTAR', 'Go back');


// Listas ----------------------------------------------------------------------------------------------------------- //
# -> Títulos


// Formulários ------------------------------------------------------------------------------------------------------ //
# -> Legendas

# -> Rótulos
define('TXT_ROTULO_LOGIN', 'Login or e-mail');
define('TXT_ROTULO_SENHA', 'Password');
define('TXT_ROTULO_SENHA_NOVA', 'New password');
define('TXT_ROTULO_SENHA_CONF', 'Password confirm');
define('TXT_ROTULO_LOGIN_OU_EMAIL', 'Type your <b>login</b> or <b>e-mail</b> registered');

# -> Dicas

# -> Exemplos

# -> Opções

# -> Botões
define('TXT_BOTAO_ENTRAR', 'Enter');
define('TXT_BOTAO_ENVIAR', 'Send');


// E-mail ----------------------------------------------------------------------------------------------------------- //
# -> Assuntos
define('TXT_EMAIL_ASSUNTO_RECUPERACAO_SENHA', 'Password recovery');

# -> Corpo
define('TXT_EMAIL_CORPO_RECUPERAR_SENHA', '<h1>Hello %s!</h1>'
	. '<p>Você solicitou a recuperação da sua senha. Para resetar a sua senha, por favor clique no link abaixo:</p>'
	. '<p><b>Atenção:</b> caso você não tenha feito essa solicitação, <b><u>NÃO</u></b> continue com o processo e ignore esse e-mail.</b></p>'
	. '<p>'
	. '<a href="%s" target="_blank">%s</a>'
	. '</p>');


// Diversos --------------------------------------------------------------------------------------------------------- //
define('TXT_DIVERSOS_AVISO_USUARIO_RESET_SENHA', '<b>Attention!</b> If you are not <b>%s</b> <span style="text-transform:uppercase;text-decoration:underline;font-weight:bold;">not</span> to continue this procedure!');


// Classes ---------------------------------------------------------------------------------------------------------- //
# -> AdminM\Usuario()
# ->-> Erros
define('ERRO_USUARIO_FAZERLOGIN_USUARIO_OU_SENHA_INVALIDOS', 'Login and/or password are invalid!');
define('ERRO_USUARIO_FAZERLOGIN_USUARIO_BLOQUEADO', "This user account is blocked in this moment and don't have access on system.");

# -> LoginC\Login()
# ->-> Sucessos
define('SUCESSO_LOGIN_FAZERLOGIN', 'You entered the system!');
define('SUCESSO_LOGIN_FAZERLOGOUT', 'You left the system!');
define('SUCESSO_LOGIN_RESETARSENHA', '<b>Your password was changed successfully!</b><p>You need to login to the system again.</p>');
define('SUCESSO_LOGIN_RECUPERARSENHA', 'An email was sent to <b>%s</b> with the information needed to regain access to the system.');

# ->-> Erros
define('ERRO_LOGIN_FAZERLOGIN', '<b>Unknown error!</b><p>Unable to login.</p>');
define('ERRO_LOGIN_FAZERLOGOUT', '<b>Unknown error!</b><p>Unable to left the system.</p>');
define('ERRO_LOGIN_MOSTRARRESETSENHA', '<b>Error!</b><p>Invalid hash recovery.</p>');
define('ERRO_LOGIN_RECUPERARSENHA_USUARIO_NAO_LOCALIZADO', 'Login or e-mail was not found!');