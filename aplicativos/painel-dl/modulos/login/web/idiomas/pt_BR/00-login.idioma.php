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
define('TXT_PAGINA_TITULO_LOGIN', 'Acessar o sistema');
define('TXT_PAGINA_TITULO_ESQUECI_MINHA_SENHA', 'Esqueci minha senha');
define('TXT_PAGINA_TITULO_MOSTRARRESETSENHA', 'Resetar senha');


// Links ------------------------------------------------------------------------------------------------------------ //
define('TXT_LINK_ESQUECI_MINHA_SENHA', 'Esqueci minha senha');
define('TXT_LINK_VOLTAR', 'Voltar');


// Listas ----------------------------------------------------------------------------------------------------------- //
# -> Títulos


// Formulários ------------------------------------------------------------------------------------------------------ //
# -> Legendas

# -> Rótulos
define('TXT_ROTULO_LOGIN', 'Usuário ou e-mail');
define('TXT_ROTULO_SENHA', 'Senha');
define('TXT_ROTULO_SENHA_NOVA', 'Sua nova senha');
define('TXT_ROTULO_SENHA_CONF', 'Confirme a sua nova senha');
define('TXT_ROTULO_LOGIN_OU_EMAIL', 'Informe seu <b>login</b> ou <b>e-mail</b> cadastrado');

# -> Dicas

# -> Exemplos

# -> Opções

# -> Botões
define('TXT_BOTAO_ENTRAR', 'Entrar');
define('TXT_BOTAO_ENVIAR', 'Enviar');


// E-mail ----------------------------------------------------------------------------------------------------------- //
# -> Assuntos
define('TXT_EMAIL_ASSUNTO_RECUPERACAO_SENHA', 'Recuperação da senha');

# -> Corpo
define('TXT_EMAIL_CORPO_RECUPERAR_SENHA', '<h1>Olá %s!</h1>'
	. '<p>Você solicitou a recuperação da sua senha. Para resetar a sua senha, por favor clique no link abaixo:</p>'
	. '<p><b>Atenção:</b> caso você não tenha feito essa solicitação, <b><u>NÃO</u></b> continue com o processo e ignore esse e-mail.</b></p>'
	. '<p>'
	. '<a href="%s" target="_blank">%s</a>'
	. '</p>');


// Diversos --------------------------------------------------------------------------------------------------------- //
define('TXT_DIVERSOS_AVISO_USUARIO_RESET_SENHA', '<b>Atenção!</b> Se você não for <b>%s</b> <span style="text-transform:uppercase;text-decoration:underline;font-weight:bold;">não</span> continue esse procedimento!');


// Classes ---------------------------------------------------------------------------------------------------------- //
# -> AdminM\Usuario()
# ->-> Erros
define('ERRO_USUARIO_FAZERLOGIN_USUARIO_OU_SENHA_INVALIDOS', 'Usuário e/ou senha inválidos!');
define('ERRO_USUARIO_FAZERLOGIN_USUARIO_BLOQUEADO', 'Esse usuário está bloqueado e não pode acessar o sistema nesse momento.');

# -> LoginC\Login()
# ->-> Sucessos
define('SUCESSO_LOGIN_FAZERLOGIN', 'Você entrou no sistema!');
define('SUCESSO_LOGIN_FAZERLOGOUT', 'Você saiu do sistema!');
define('SUCESSO_LOGIN_RESETARSENHA', '<b>Senha alterada com sucesso!</b><p>Você precisa fazer o login no sistema.</p>');
define('SUCESSO_LOGIN_RECUPERARSENHA', 'Foi enviado um e-mail para <b>%s</b> com as informações necessárias para recuperar o acesso ao sistema.');

# ->-> Erros
define('ERRO_LOGIN_FAZERLOGIN', '<b>Erro desconhecido!</b><p>Não foi possível fazer o login.</p>');
define('ERRO_LOGIN_FAZERLOGOUT', '<b>Erro desconhecido!</b><p>Não foi possível sair do sistema.</p>');
define('ERRO_LOGIN_MOSTRARRESETSENHA', '<b>Erro!</b><p>Hash de recuperação inválida.</p>');
define('ERRO_LOGIN_RECUPERARSENHA_USUARIO_NAO_LOCALIZADO', 'Login ou e-mail informado não foi localizado!');