<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace Sobre\Modelo;

class Institucional extends \Geral\Modelo\Principal{
    protected $id, $historia, $missao, $visao, $valores, $publicar = 1;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _historia(){ return $this->historia = filter_var($this->historia);  } // Fim do método _historia
    public function _missao(){ return $this->missao = filter_var($this->missao); } // Fim do método _missao
    public function _visao(){ return $this->visao = filter_var($this->visao); } // Fim do método _visao
    public function _valores(){ return $this->valores = filter_var($this->valores); } // Fim do método _valores



    public function __construct($id=null){
        parent::__construct('dl_site_institucional', 'instit_');

        $this->bd_select = 'SELECT %s FROM %s';

        if( !empty((int)$id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Desativar os métodos _salvar e _remover
     * -------------------------------------------------------------------------
     */
    public function _salvar(){ return; }
    public function _remover(){ return; }
} // Fim do Modelo Institucional