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
define('MASK_CNPJ', '###.###.###/####-##');
