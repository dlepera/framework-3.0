<?php
/**
 * Created by PhpStorm.
 * User: dlepera
 * Date: 11/08/15
 * Time: 20:14
 */



# Erros
# -> Títulos
define('TXT_PAGINA_TITULO_ERRO_404', 'Erro 404 - Página não encontrada!');
define('TXT_PAGINA_TITULO_ERRO_403', 'Erro 403 - Você não tem permissão!');
define('TXT_PAGINA_TITULO_ERRO_500', 'Erro 500 - Erro interno do servidor!');


# -> Diversos
define('TXT_DIVERSOS_ERRO_404', 'Essa página ou diretório não existe em nosso servidor.<br/>Por favor, entre em contato com o administrador ou tente novamente mais tarde.');
define('TXT_DIVERSOS_ERRO_403', 'Você não tem permissão para acessar essa página, diretório ou funcionalidade.');
define('TXT_DIVERSOS_JS_DESATIVADO', 'Seu navegador está configurado para <b>não</b> utilizar <b>JavaScript</b>! O sistema não funcionará corretamente. Por favor, ative o JavaScript do seu navegador e atualize a página.');
define('TXT_DIVERSOS_IE_INCOMPATIVEL', 'Essa versão do <b>Internet Explorer</b> é antiga e não é suportada pelo sistema. Por favor, atualize para a versão mais recente do IE ou instale e utilize o <b>Google Chrome</b>.');

# Links
define('TXT_LINK_IR_PARA_HOME', 'Ir para a página inicial');

# Formulário
# -> Rótulos
define('TXT_ROTULO_ALT_MASK_FONE', 'Esse telefone possui o 9º dígito');

# -> Dicas
define('TXT_DICA_INFO_UPLOAD', '<b>Extensões aceitas:</b> %s.<br/><b>Tamanho máximo do arquivo:</b> %s.');

# -> Exemplos
define('TXT_EXEMPLO_MOEDA_BRL', 'R$ 12,34');


/*
 * PDODL
 */
# Erros
define('ERRO_PDODL_CAMPOS', 'Erro ao identificar informações dos campos da tabela: %s');
define('ERRO_PDODL_SGBD_NAO_SUPORTADO', 'Esse SGBD não é suportado pelo sistema!');



/*
 * GeralM\Principal()
 */
# Erros
define('ERRO_MODELOPRINCIPAL_CRIARUPDATE_CAMPO_OBRIGATORIO_NULO', 'O campo %s é obrigatório, mas está definido como NULL!');
define('ERRO_PRINCIPAL_ALTERNARPUBLICACAO_PROPRIEDADE_NAO_EXISTE', 'O campo <b>publicar</b> não existe para esse registro.');



/*
 * GeralC\ConfigEmail()
 */
# Erros
define('ERRO_PADRAO_CLASSE_NAO_ENCONTRADA', 'Classe não encontrada!');
define('ERRO_PADRAO_METODO_NAO_EXISTE', 'Método não existe!');



/*
 * Upload()
 */
# Erros
define('ERRO_UPLOAD_SALVAR_BLOQ_EXTENSAO', 'O arquivo <b>%s</b> não foi salvo!<br/>Por favor, insira um arquivo com uma das seguintes extensões: %s');



/*
 * Imagem()
 */
# Erros
define('ERRO_IMAGEM_CONSTRUCT_EXTENSAO_GD_NAO_CARREGADA', 'A extensão GD do PHP não está instalada no servidor ou não foi carregada.');
define('ERRO_IMAGEM_NAO_ENCONTRADA', 'A imagem informada não foi encontrada.');
define('ERRO_IMAGEM_REDIMENSIONAR_INFORME_ALTURA_X_LARGURA', 'Para redimensionar a imagem é necessário informar a largura e / ou a altura que deseja.');
define('ERRO_IMAGEM_ROTACIONAR_GRAUS_INVALIDOS', 'Informe um número de graus válido para rotacionar a imagem.');
define('ERRO_IMAGEM_SALVAR_POR_FAVOR_INFORME_NOME_ARQUIVO', 'Informe o nome do arquivo para salvar a foto.');



/*
 * Apoio\Formulario()
 */
# Erros
define('ERRO_FORMULARO_TIPO_DE_CAMPO_DESCONHECIDO', 'Tipo de campo desconhecido!');