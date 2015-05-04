<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 21/01/2015 16:14:15
 */

# Títulos de páginas
define('TXT_TITULO_LOGIN', 'System access');
define('TXT_TITULO_ESQUECI_MINHA_SENHA', 'I forgot my password');
define('TXT_TITULO_MOSTRARRESETSENHA', 'Reset password');

# Formuários
# -> Campos
define('TXT_ROTULO_LOGIN', 'Login');
define('TXT_ROTULO_SENHA', 'Password');
define('TXT_ROTULO_SENHA_NOVA', 'Your new password');
define('TXT_ROTULO_SENHA_CONF', 'New password confirm');
define('TXT_ROTULO_LOGIN_OU_EMAIL', 'Please, type your <b>login</b> or <b>e-mail</b>');

# -> Botões
define('TXT_BOTAO_ENTRAR', 'Login');
define('TXT_BOTAO_ENVIAR', 'Send');

# Links
define('TXT_LINK_ESQUECI_MINHA_SENHA', 'I forgot my password');
define('TXT_LINK_VOLTAR', 'Go back');

# E-Mails
# -> Assuntos
define('TXT_EMAIL_ASSUNTO_RECUPERACAO_SENHA', 'Password recovery');

# -> Corpo
define('MSG_EMAIL_CORPO_RECUPERAR_SENHA', '<h1>Hello %s!</h1>'
        . '<p>Você solicitou a recuperação da sua senha. Para resetar a sua senha, por favor clique no link abaixo:</p>'
        . '<p><b>Attention:</b> caso você não tenha feito essa solicitação, <b><u>NÃO</u></b> continue com o processo e ignore esse e-mail.</b></p>'
        . '<p>'
        . '<a href="%s" target="_blank">%s</a>'
        . '</p>');



/**
 * \Admin\Modelo\Usuario
 * -----------------------------------------------------------------------------
 */
# Erros
define('ERRO_USUARIO_FAZERLOGIN_USUARIO_OU_SENHA_INVALIDOS', 'User and/or passwrod incorrects!');
define('ERRO_USUARIO_FAZERLOGIN_USUARIO_BLOQUEADO', 'Esse usuário está bloqueado e não pode acessar o sistema nesse momento.');



/**
 * \Login\Controle\Login
 * -----------------------------------------------------------------------------
 */
# Sucessos
define('SUCESSO_LOGIN_FAZERLOGIN', 'You login on the system!');
define('SUCESSO_LOGIN_FAZERLOGOUT', 'You logout of the system!');
define('SUCESSO_LOGIN_RESETARSENHA', '<b>Password changed successfully!</b><p>Please, do logon on the system again.</p>');

# Erros
define('ERRO_LOGIN_FAZERLOGIN', '<b>Unknow error!</b><p>Não foi possível fazer o login.</p>');
define('ERRO_LOGIN_FAZERLOGOUT', '<b>Unknow error!</b><p>Não foi possível sair do sistema.</p>');
define('ERRO_LOGIN_MOSTRARRESETSENHA', '<b>Error!</b><p>Recovery hash incorrect.</p>');
