<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 00:54:11
 */

# Sucessos
define('SUCESSO_PADRAO_REGISTRO_SALVO', 'The <b>%s</b> saved successfully!');

# Erros
define('ERRO_PADRAO_SALVAR_REGISTRO', 'Error! Não foi possível salvar o registro.<p>%s</p>');
define('ERRO_PADRAO_METODO_NAO_ENCONTRADO', 'Error! The method <b>%s</b> not found on class <b>%s</b>.');
define('ERRO_PADRAO_VALOR_INVALIDO', 'The property values <b>%s</b> is invalid!');
define('ERRO_PADRAO_SESSAO_NAO_INICIADA', 'Sessão não iniciada!');
define('ERRO_PADRAO_ACAO_NAO_PERMITIDA', 'Sorry, but this action is denied!');

# Mensagens diversas
define('MSG_NAO_INFORMADO', 'Uninformed');
define('MSG_PADRAO_NENHUM_REGISTRO_ENCONTRADO', 'No records found');
define('MSG_PADRAO_NENHUM_REGISTRO_SELECIONADO', 'No records selected');



/**
 * Geral\Modelo\ConfigEmail
 * -----------------------------------------------------------------------------
 */
# Erros
define('ERRO_CONFIGEMAIL_SELECIONARPRINCIPAL', '<b>Erro! O e-mail não pôde ser enviado</b><p>Não foi possível encontrar a configuração de envio principal.</p>');



/**
 * Geral\Modelo\Principal
 * -----------------------------------------------------------------------------
 */
# Erros
define('ERRO_MODELOPRINCIPAL_CRIARINSERT_CAMPO_OBRIGATORIO_NULO', 'Error! The field <b>%s</b> is required!');



/**
 * Geral\Controle\Principal
 * -----------------------------------------------------------------------------
 */
# Sucessos
define('SUCESSO_CONTROLEPRINCIPAL_REMOVER_UM', 'Registro removido com sucesso!');
define('SUCESSO_CONTROLEPRINCIPAL_REMOVER_VARIOS', 'Foram removidos %d registros de um total de %d com sucesso!');
define('SUCESSO_CONTROLEPRINCIPAL_ALTERNARPUBLICACAO_UM_PUBLICAR', 'Registro publicado com sucesso!');
define('SUCESSO_CONTROLEPRINCIPAL_ALTERNARPUBLICACAO_VARIOS_PUBLICAR', 'Foram publicados %d registros de um total de %d com sucesso!');
define('SUCESSO_CONTROLEPRINCIPAL_ALTERNARPUBLICACAO_UM_OCULTAR', 'Registro ocultado com sucesso!');
define('SUCESSO_CONTROLEPRINCIPAL_ALTERNARPUBLICACAO_VARIOS_OCULTAR', 'Foram ocultados %d registros de um total de %d com sucesso!');


# Erros
define('ERRO_CONTROLEPRINCIPAL_REMOVER', 'Erro! Nenhum registro pôde ser removido.');
define('ERRO_CONTROLEPRINCIPAL_ALTERNARPUBLICACAO_PUBLICAR', 'Erro! Não foi possível publicar esse registro.');
define('ERRO_CONTROLEPRINCIPAL_ALTERNARPUBLICACAO_OCULTAR', 'Erro! Não foi possível ocultar esse registro.');