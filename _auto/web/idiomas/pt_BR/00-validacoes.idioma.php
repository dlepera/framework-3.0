<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: dlepera88@gmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 08/05/2015 11:16:24
 */

// Expressões regulares --------------------------------------------------------------------------------------------- //
define('EXPREG_COR_HEXA', '~^#[0-9A-Fa-f]{3,6}$~');
define('EXPREG_TELEFONE_GERAL', '~^\([0-9]{2}\)\s([0-9]\s)?[0-9]{4}\-[0-9]{4}$~');
define('EXPREG_CPF', '~^([0-9]{3}\.){2}[0-9]{3}\-[0-9]{2}$~');
define('EXPREG_CNPJ', '~^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$~');


// Máscaras --------------------------------------------------------------------------------------------------------- //
# -> Dados para contato
define('MASK_TELEFONE_FIXO', '(##) ####-####');
define('MASK_TELEFONE_CELULAR_8', MASK_TELEFONE_FIXO);
define('MASK_TELEFONE_CELULAR_9', '(##) # ####-####');

# -> Documentos
define('MASK_CPF', '###.###.###-##');
define('MASK_CNPJ', '##.###.###/####-##');


// Mensagens de retorno --------------------------------------------------------------------------------------------- //
define('TXT_VALIDACAO_ARQUIVO_UPLOAD', "Extensão e/ou tamanho do(s) arquivo(s) inválido!");
define('TXT_VALIDACAO_CPF_INVALIDO', 'CPF inválido!');
define('TXT_VALIDACAO_CNPJ_INVALIDO', 'CNPJ inválido!');
define('TXT_VALIDACAO_GTIN', 'Número inválido para qualquer padrão GTIN: EAN 8, EAN 13 ou DUN 14');