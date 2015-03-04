<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

class Institucional extends \Geral\Modelo\Principal{
    protected $id, $historia, $missao, $visao, $valores, $publicar = 1;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _historia($v=null){
        return $this->historia = filter_var(is_null($v) ? $this->historia : $v);
    } // Fim do método _historia

    public function _missao($v=null){
        return $this->missao = filter_var(is_null($v) ? $this->missao : $v);
    } // Fim do método _missao

    public function _visao($v=null){
        return $this->visao = filter_var(is_null($v) ? $this->visao : $v);
    } // Fim do método _visao

    public function _valores($v=null){
        return $this->valores = filter_var(is_null($v) ? $this->valores : $v);
    } // Fim do método _valores



    public function __construct($id=null){
        parent::__construct('dl_site_institucional', 'instit_');

        $this->bd_select = 'SELECT %s FROM %s';

        if( !empty((int)$id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Desativar o método _remover
     * -------------------------------------------------------------------------
     */
    public function _remover(){ return; }
} // Fim do Modelo Institucional