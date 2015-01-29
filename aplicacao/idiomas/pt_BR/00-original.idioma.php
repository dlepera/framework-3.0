<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 00:54:11
 */

# Sucessos
define('SUCESSO_PADRAO_REGISTRO_SALVO', 'O registro de <b>%s</b> foi salvo com sucesso!');

# Erros
define('ERRO_PADRAO_SALVAR_REGISTRO', 'Erro! Não foi possível salvar o registro.<p>%s</p>');
define('ERRO_PADRAO_METODO_NAO_ENCONTRADO', 'Erro! O método <b>%s</b> não foi localizado na classe <b>%s</b>.');
define('ERRO_PADRAO_VALOR_INVALIDO', 'O valor da propriedade <b>%s</b> é inválido!');
define('ERRO_PADRAO_SESSAO_NAO_INICIADA', 'Sessão não iniciada!');
define('ERRO_PADRAO_ACAO_NAO_PERMITIDA', 'Desculpe, mas essa ação não é permitida!');

# Mensagens diversas
define('MSG_NAO_INFORMADO', 'Não informado');
define('MSG_PADRAO_NENHUM_REGISTRO_ENCONTRADO', 'Nenhum registro encontrado');
define('MSG_PADRAO_NENHUM_REGISTRO_SELECIONADO', 'Nenhum registro selecionado');



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
define('ERRO_MODELOPRINCIPAL_CRIARINSERT_CAMPO_OBRIGATORIO_NULO', 'Erro! O campo <b>%s</b> é obrigatório!');



/**
 * Geral\Controle\Principal
 * -----------------------------------------------------------------------------
 */
# Sucessos
define('SUCESSO_CONTROLEPRINCIPAL_REMOVER_UM', 'Registro removido com sucesso!');
define('SUCESSO_CONTROLEPRINCIPAL_REMOVER_VARIOS', 'Foram removidos %d registros de um total de %d com sucesso!');

# Erros
define('ERRO_CONTROLEPRINCIPAL_REMOVER', 'Erro! Nenhum registro pôde ser removido.');