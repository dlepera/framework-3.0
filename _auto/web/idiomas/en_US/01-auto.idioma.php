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


// Links ------------------------------------------------------------------------------------------------------------ //
define('TXT_LINK_IR_PARA_HOME', 'Go to home page');


// Listas ----------------------------------------------------------------------------------------------------------- //
# -> Títulos


// Formulários ------------------------------------------------------------------------------------------------------ //
# -> Legendas

# -> Rótulos
define('TXT_ROTULO_ALT_MASK_FONE', 'This phone has the 9th digit');

# -> Dicas
define('TXT_DICA_INFO_UPLOAD', '<b>Accepted extensions:</b> %s.<br/><b>Max file size:</b> %s.');

# -> Exemplos
define('TXT_EXEMPLO_MOEDA_BRL', 'R$ 12,34');

# -> Opções

# -> Botões


// Erros ------------------------------------------------------------------------------------------------------------ //
# -> Títulos
define('TXT_PAGINA_TITULO_ERRO_404', 'Error 404 - Page not found!');
define('TXT_PAGINA_TITULO_ERRO_403', 'Error 403 - Access denied!');
define('TXT_PAGINA_TITULO_ERRO_500', 'Error 500 - Internal error!');


// Diversos --------------------------------------------------------------------------------------------------------- //
define('TXT_DIVERSOS_ERRO_404', 'This page or directory does not exist on this server.<br/>Please, contact the administrator or try again later.');
define('TXT_DIVERSOS_ERRO_403', "You don't have permission to access this page, directory ou functionality.");
define('TXT_DIVERSOS_JS_DESATIVADO', 'Your browser is set to <b>not</b> allow <b>JavaScript</b>! The system does not work properly. Please enable JavaScript in your browser and refresh the page.');
define('TXT_DIVERSOS_IE_INCOMPATIVEL', 'This <b>IE</b> version is obsolet. Pleade, upgrade to the latest version of IE or install and use the <b> Google Chrome </b>.');


// Configurações AJAX ----------------------------------------------------------------------------------------------- //
define('TXT_AJAX_SALVANDO_REGISTRO', 'Saving this record... Please wait!');
define('TXT_AJAX_EXCLUINDO_REGISTROS', 'Deleting record(s)... Please wait!');
define('TXT_AJAX_ENVIANDO_EMAIL', 'Sending email... Please wait!');
define('TXT_AJAX_ACESSANDO', 'Loggin into system... Please wait!');
define('TXT_AJAX_ENCERRANDO_SESSAO', 'Leaving system... Please wait!');
define('TXT_AJAX_PUBLICANDO_REGISTRO', 'Publishing record(s)... Please wait!');
define('TXT_AJAX_OCULTANDO_REGISTRO', 'Hiding record(s)... Please wait!');
define('TXT_AJAX_SALVANDO_ARQUIVO', 'Uploading the file(s)... Please wait!');


// Classes ---------------------------------------------------------------------------------------------------------- //
# -> PDODL()
# ->-> Erros
define('ERRO_PDODL_CAMPOS', 'Error identify the table fields information: %s');
define('ERRO_PDODL_SGBD_NAO_SUPORTADO', 'This SGBD is not supported!');

# -> GeralM\Principal()
# ->-> Erros
define('ERRO_MODELOPRINCIPAL_CRIARUPDATE_CAMPO_OBRIGATORIO_NULO', 'The %s field is required, but it defined as NULL!');
define('ERRO_PRINCIPAL_ALTERNARPUBLICACAO_PROPRIEDADE_NAO_EXISTE', 'The <b>publicar</b> field not exists on this model.');

# -> GeralC\ConfigEmail()
# ->-> Erros
define('ERRO_PADRAO_CLASSE_NAO_ENCONTRADA', 'Class not found!');
define('ERRO_PADRAO_METODO_NAO_EXISTE', 'Method not exists!');

# -> Upload()
# ->-> Erros
define('ERRO_UPLOAD_SALVAR_BLOQ_EXTENSAO', 'The <b>%s</b> file not saved!<br/>Please, insert a file of any of the extensions: %s');

# -> Imagem()
# ->-> Erros
define('ERRO_IMAGEM_CONSTRUCT_EXTENSAO_GD_NAO_CARREGADA', 'The GD PHP extension is not installed or was not loaded.');
define('ERRO_IMAGEM_NAO_ENCONTRADA', 'Image was not found.');
define('ERRO_IMAGEM_REDIMENSIONAR_INFORME_ALTURA_X_LARGURA', 'To resize the image it needs to tell the width and / or height you want.');
define('ERRO_IMAGEM_ROTACIONAR_GRAUS_INVALIDOS', 'Enter a valid number of degrees to rotate the image.');
define('ERRO_IMAGEM_SALVAR_POR_FAVOR_INFORME_NOME_ARQUIVO', 'Enter the filename to save the picture.');

# -> Apoio\Formulario()
# ->-> Erros
define('ERRO_FORMULARO_TIPO_DE_CAMPO_DESCONHECIDO', 'Unknown field type!');