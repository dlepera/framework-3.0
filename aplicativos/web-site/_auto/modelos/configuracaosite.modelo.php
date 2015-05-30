<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace Geral\Modelo;

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



    public function __construct(){
        parent::__construct('dl_site_configuracoes', 'configuracao_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS C'
                . ' INNER JOIN dl_painel_temas AS T ON( T.tema_id = C.configuracao_tema )'
                . ' INNER JOIN dl_painel_formatos_data AS F ON( F.formato_data_id = C.configuracao_formato_data )';

        $this->_selecionarID(0);
    } // Fim do método __construct



    /**
     * Desabilitar os métodos de edição
     * -------------------------------------------------------------------------
     *
     * @return void
     */
    public function _salvar($s = true, $ci = null, $ce = null, $ipk = false){ return; }
    public function _remover(){ return; }
    public function _alternarpublicacao(){ return; }
} // Fim do Modelo ConfiguracaoSite