<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace Modulo\Modelo;

use \Geral\Modelo as GeralM;

class Modelo extends GeralM\Principal{
    protected $id, $publicar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _campo($v = null){
        return $this->campo = filter_var(!isset($v) ? $this->campo : $v, FILTER_DEFAULT);
    } // Fim do método _campo



    public function __construct($pk = ''){
        parent::__construct('tabela', 'prefixo');

        $this->_selecionarPK($pk);
    } // Fim do método __construct
} // Fim do Modelo Modelo