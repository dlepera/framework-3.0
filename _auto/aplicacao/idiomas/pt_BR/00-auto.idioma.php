<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: dlepera88@gmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 08/05/2015 11:16:24
 */

# Expressões regulares
define('EXPREG_COR_HEXA', '~^#[0-9A-Fa-f]{3,6}$~');

# Máscaras
# -> Dados para contato
define('MASK_TELEFONE_FIXO', '(##) ####-####');
define('MASK_TELEFONE_CELULAR_8', MASK_TELEFONE_FIXO);
define('MASK_TELEFONE_CELULAR_9', '(##) # ####-####');

# -> Documentos
define('MASK_CPF', '###.###.###-##');
define('MASK_CNPJ', '##.###.###/####-##');



/*
 * PDODL
 */
# Erros
define('ERRO_PDODL_CAMPOS', 'Erro ao identificar informações dos campos da tabela: %s');
define('ERRO_PDODL_SGBD_NAO_SUPORTADO', 'Esse SGBD não é suportado pelo sistema!');



/*
 * GeralM\Principal
 */
# Erros
define('ERRO_MODELOPRINCIPAL_CRIARUPDATE_CAMPO_OBRIGATORIO_NULO', 'O campo %s é obrigatório, mas está definido como NULL!');



/*
 * Upload
 */
define('ERRO_UPLOAD_SALVAR_BLOQ_EXTENSAO', 'O arquivo <b>%s</b> não foi salvo!<br/>Por favor, insira um arquivo com uma das seguintes extensões: %s');
