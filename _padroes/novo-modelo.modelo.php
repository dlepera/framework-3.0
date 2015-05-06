<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace Modulo\Modelo;

class Modelo extends \Geral\Modelo\Principal{
    protected $id, $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _campo($v=null){
        return $this->campo = filter_var(is_null($v) ? $this->campo : $v, FILTER_DEFAULT);
    } // Fim do método _campo



    public function __construct($id=null){
        parent::__construct($tabela, $prefixo);

        if( !empty((int)$id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct
} // Fim do Modelo Modelo