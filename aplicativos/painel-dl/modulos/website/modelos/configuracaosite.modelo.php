<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

class ConfiguracaoSite extends \Geral\Modelo\Principal{
    protected $id, $tema = 1, $formato_data = 1;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _tema($v=null){
        return $this->tema = filter_var(is_null($v) ? $this->tema : $v, FILTER_VALIDATE_INT);
    } // Fim do método _tema

    public function _formato_data($v=null){
        return $this->formato_data = filter_var(is_null($v) ? $this->formato_data : $v, FILTER_VALIDATE_INT);
    } // Fim do método _formato_data



    public function __construct($id=null){
        parent::__construct('dl_site_configuracoes', 'configuracao_');

        $this->bd_select = 'SELECT %s FROM %s';

        if( !empty((int)$id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Não permitir exclusão nem alteração de publicação
     * -------------------------------------------------------------------------
     * 
     * @return void
     */
    public function _remover(){ return; }
    public function _alternarpublicacao(){ return; }
} // Fim do Modelo ConfiguracaoSite