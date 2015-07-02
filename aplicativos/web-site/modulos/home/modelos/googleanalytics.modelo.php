<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 17:03:07
 */

namespace Home\Modelo;

use \Geral\Modelo as GeralM;

class GoogleAnalytics extends GeralM\Principal{
    protected $id, $usuario, $senha, $perfil_id, $codigo_ua, $ativar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _usuario(){ return filter_var($this->usuario, FILTER_VALIDATE_INT); } // Fim do méodo _usuario
    public function _senha(){ return filter_var($this->senha); } // Fim do méodo _senha
    public function _perfil_id(){ return filter_var($this->perfil_id, FILTER_VALIDATE_INT); } // Fim do méodo _perfil_id
    public function _codigo_ua(){ return filter_var($this->codigo_ua, FILTER_SANITIZE_STRING); } // Fim do méodo _codigo_ua
    public function _ativar(){ return filter_var($this->ativar, FILTER_VALIDATE_BOOLEAN); } // Fim do método _ativar



    public function __construct($pk = null){
        parent::__construct('dl_site_google_analytics', 'ga_');

        $this->_selecionarPK($pk);
    } // Fim do método __construct



    /**
     * Desativar os métodos _salvar e _remover
     */
    protected function _salvar(){ return; } // Fim do método _salvar
    protected function _remover() { return; } // Fim do método _remover



    /**
     * Selecionar a configuração ativa
     */
    public function _selecionar_ativa(){
        $l = $this->_listar("{$this->bd_prefixo}ativar = 1", null, "{$this->bd_prefixo}id AS ID", 0, 1, 0);

        if( $l === false )
            throw new \Exception(ERRO_GOOGLEANALYTICS_PRINCIPAL_NAO_ENCONTRADO, 1404);

        return $this->_selecionarPK($l['ID']);
    } // Fim do método _selecionar_ativa
} // Fim do Modelo GoogleAnalytics