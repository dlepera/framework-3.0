<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 20:30:28
 */

namespace Contato\Modelo;

class DadoContato extends \Geral\Modelo\Principal{
    protected $id, $tipo, $descr, $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _tipo(){ return (int)$this->tipo; } // Fim do método _tipo
    public function _descr(){ return (string)$this->descr; } // Fim do método _descr



    public function __construct($id=null){
        parent::__construct('dl_site_dados_contato', 'dado_contato_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS DC'
                . " INNER JOIN {$this->bd_tabela}_tipos AS TD ON( TD.tipo_dado_id = DC.dado_contato_tipo )"
                . ' WHERE DC.%sdelete = 0';

        if( !empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Desativar os métodos _salvar e _remover
     * -------------------------------------------------------------------------
     */
    protected function _salvar(){ return; }
    protected function _remover(){ return; }
} // Fim do Modelo DadoContato