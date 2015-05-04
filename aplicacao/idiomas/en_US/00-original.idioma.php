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
define('ERRO_PADRAO_SALVAR_REGISTRO', 'Error! Record not saved.<p>%s</p>');
define('ERRO_PADRAO_METODO_NAO_ENCONTRADO', 'Error! The <b>%s</b> method not found on <b>%s</b> class.');
define('ERRO_PADRAO_VALOR_INVALIDO', 'The <b>%s</b> property value is invalid!');
define('ERRO_PADRAO_SESSAO_NAO_INICIADA', 'Session not started!');
define('ERRO_PADRAO_ACAO_NAO_PERMITIDA', 'Sorry, but this session is denied!');

# Mensagens diversas
define('MSG_NAO_INFORMADO', 'Uninformed');
define('MSG_PADRAO_NENHUM_REGISTRO_ENCONTRADO', 'Records not found');
define('MSG_PADRAO_NENHUM_REGISTRO_SELECIONADO', 'No records selected');



/**
 * Geral\Modelo\ConfigEmail
 * -----------------------------------------------------------------------------
 */
# Erros
define('ERRO_CONFIGEMAIL_SELECIONARPRINCIPAL', '<b>Error! The e-mail not be sented</b><p>Default send configuration not found.</p>');



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
define('SUCESSO_CONTROLEPRINCIPAL_REMOVER_UM', 'Record removed successfully!');
define('SUCESSO_CONTROLEPRINCIPAL_REMOVER_VARIOS', '%d records were removed from a total of %d');

# Erros
define('ERRO_CONTROLEPRINCIPAL_REMOVER', 'Error! No records were removed.');