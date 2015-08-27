<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 21/01/2015 16:14:15
 */

# Títulos de páginas
define('TXT_PAGINA_TITULO_LOGIN', 'Acessar o sistema');
define('TXT_PAGINA_TITULO_ESQUECI_MINHA_SENHA', 'Esqueci minha senha');
define('TXT_PAGINA_TITULO_MOSTRARRESETSENHA', 'Resetar senha');

# Formuários
# -> Campos
define('TXT_ROTULO_LOGIN', 'Login');
define('TXT_ROTULO_SENHA', 'Senha');
define('TXT_ROTULO_SENHA_NOVA', 'Sua nova senha');
define('TXT_ROTULO_SENHA_CONF', 'Confirme a sua nova senha');
define('TXT_ROTULO_LOGIN_OU_EMAIL', 'Informe seu <b>login</b> ou <b>e-mail</b> cadastrado');

# -> Botões
define('TXT_BOTAO_ENTRAR', 'Entrar');
define('TXT_BOTAO_ENVIAR', 'Enviar');

# Links
define('TXT_LINK_ESQUECI_MINHA_SENHA', 'Esqueci minha senha');
define('TXT_LINK_VOLTAR', 'Voltar');

# E-Mails
# -> Assuntos
define('TXT_EMAIL_ASSUNTO_RECUPERACAO_SENHA', 'Recuperação da senha');

# -> Corpo
define('MSG_EMAIL_CORPO_RECUPERAR_SENHA', '<h1>Olá %s!</h1>'
        . '<p>Você solicitou a recuperação da sua senha. Para resetar a sua senha, por favor clique no link abaixo:</p>'
        . '<p><b>Atenção:</b> caso você não tenha feito essa solicitação, <b><cite>NÃO</cite></b> continue com o processo e ignore esse e-mail.</b></p>'
        . '<p>'
        . '<a href="%s" target="_blank">%s</a>'
        . '</p>');



/**
 * AdminM\Usuario
 * -----------------------------------------------------------------------------
 */
# Erros
define('ERRO_USUARIO_FAZERLOGIN_USUARIO_OU_SENHA_INVALIDOS', 'Usuário e/ou senha inválidos!');
define('ERRO_USUARIO_FAZERLOGIN_USUARIO_BLOQUEADO', 'Esse usuário está bloqueado e não pode acessar o sistema nesse momento.');



/**
 * \Login\Controle\Login
 * -----------------------------------------------------------------------------
 */
# Sucessos
define('SUCESSO_LOGIN_FAZERLOGIN', 'Você entrou no sistema!');
define('SUCESSO_LOGIN_FAZERLOGOUT', 'Você saiu do sistema!');
define('SUCESSO_LOGIN_RESETARSENHA', '<b>Senha alterada com sucesso!</b><p>Você precisa fazer o login no sistema.</p>');

# Erros
define('ERRO_LOGIN_FAZERLOGIN', '<b>Erro desconhecido!</b><p>Não foi possível fazer o login.</p>');
define('ERRO_LOGIN_FAZERLOGOUT', '<b>Erro desconhecido!</b><p>Não foi possível sair do sistema.</p>');
define('ERRO_LOGIN_MOSTRARRESETSENHA', '<b>Erro!</b><p>Hash de recuperação inválida.</p>');
