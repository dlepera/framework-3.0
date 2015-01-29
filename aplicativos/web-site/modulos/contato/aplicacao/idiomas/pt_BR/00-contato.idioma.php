<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 18:41:04
 */

# Nome de módulos
define('TXT_MODELO_CONTATOSITE', 'contato do site');

# Títulos de páginas
define('TXT_TITULO_CONTATO', 'Contato');

# Formulários
# -> Campos
define('TXT_LABEL_NOME', 'Nome');
define('TXT_LABEL_EMAIL', 'E-mail');
define('TXT_LABEL_FONE', 'Telefone');
define('TXT_LABEL_ASSUNTO', 'Assunto');
define('TXT_LABEL_MENSAGEM', 'Mensagem');

# -> Botões
define('TXT_BOTAO_ENVIAR', 'Enviar');
define('TXT_BOTAO_CANCELAR', 'Cancelar');

# -> Opções
define('TXT_OPCAO_SELECIONE_UMA_OPCAO', 'Selecione uma opção');

# E-mails
# -> Assuntos
define('TXT_EMAIL_ASSUNTO_CONTATOSITE', '[%s] - Assunto: %s');

# -> Conteúdos
define('TXT_EMAIL_CONTEUDO_CONTATOSITE', '<p>Foi enviado um contato através do formulário do site <b>%s</b>.</p>'
        . '<p><b>'. TXT_LABEL_NOME .':</b> %s<br/>'
        . '<b>'. TXT_LABEL_EMAIL .':</b> %s<br/>'
        . '<b>'. TXT_LABEL_FONE .':</b> %s<br/>'
        . '<b>'. TXT_LABEL_ASSUNTO .':</b> %s<br/>'
        . '<b>'. TXT_LABEL_MENSAGEM .':</b><br/>%s</p>');



/**
 * Contato\Controle\ContatoSite
 * -----------------------------------------------------------------------------
 */
# Sucesso
define('SUCESSO_CONTATOSITE_ENVIADO', '<b>Agradecemos por entrar em contato conosco!</b><p>Responderemos o mais rápido possível.</p>');

# Erros
define('ERRO_CONTATOSITE_ENVIO_EMAIL', '<b>Erro! O e-mail não pôde ser enviado</b><p>Mas não se preocupe.'
        . ' Nós gravamos seu contato em nossa base de dados e ainda lhe responderemos o mais breve possível.</p>'
        . '<p><b>Detalhes do problema:</b><br/>%s</p>');
