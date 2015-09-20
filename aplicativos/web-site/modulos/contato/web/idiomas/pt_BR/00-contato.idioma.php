<?php
/**
 * Created by PhpStorm.
 * User: dlepera
 * Date: 28/08/15
 * Time: 16:00
 */

// Modelos ---------------------------------------------------------------------------------------------------------- //
define('TXT_MODELO_CONTATOSITE', 'contato do site');


// Páginas ---------------------------------------------------------------------------------------------------------- //
# -> Títulos
define('TXT_PAGINA_TITULO_CONTATO', 'Contato');


// Links ------------------------------------------------------------------------------------------------------------ //


// Listas ----------------------------------------------------------------------------------------------------------- //
# -> Títulos


// Formulários ------------------------------------------------------------------------------------------------------ //
# -> Legendas

# -> Rótulos
define('TXT_ROTULO_NOME', 'Nome');
define('TXT_ROTULO_EMAIL', 'E-mail');
define('TXT_ROTULO_FONE', 'Telefone');
define('TXT_ROTULO_ASSUNTO', 'Assunto');
define('TXT_ROTULO_MENSAGEM', 'Mensagem');

# -> Dicas

# -> Exemplos

# -> Opções
define('TXT_OPCAO_SELECIONE_UMA_OPCAO', 'Selecione uma opção');

# -> Botões
define('TXT_BOTAO_ENVIAR', 'Enviar');
define('TXT_BOTAO_CANCELAR', 'Cancelar');


// E-mails ---------------------------------------------------------------------------------------------------------- //
# -> Assuntos
define('TXT_EMAIL_ASSUNTO_CONTATOSITE', '[%s] - Assunto: %s');

# -> Conteúdos
define('TXT_EMAIL_CONTEUDO_CONTATOSITE', '<p>Foi enviado um contato através do formulário do site <b>%s</b>.</p>'
	. '<p><b>'. TXT_ROTULO_NOME .':</b> %s<br/>'
	. '<b>'. TXT_ROTULO_EMAIL .':</b> %s<br/>'
	. '<b>'. TXT_ROTULO_FONE .':</b> %s<br/>'
	. '<b>'. TXT_ROTULO_ASSUNTO .':</b> %s<br/>'
	. '<b>'. TXT_ROTULO_MENSAGEM .':</b><br/>%s</p>');


// Diversos --------------------------------------------------------------------------------------------------------- //


// Classes ---------------------------------------------------------------------------------------------------------- //
# -> Contato\Controle\ContatoSite
# ->-> Sucesso
define('SUCESSO_CONTATOSITE_ENVIADO', '<b>Agradecemos por entrar em contato conosco!</b><p>Responderemos o mais rápido possível.</p>');

# ->-> Erros
define('ERRO_CONTATOSITE_ENVIO_EMAIL', '<b>Erro! O e-mail não pôde ser enviado</b><p>Mas não se preocupe.'
	. ' Nós gravamos seu contato em nossa base de dados e ainda lhe responderemos o mais breve possível.</p>'
	. '<p><b>Detalhes do problema:</b><br/>%s</p>');