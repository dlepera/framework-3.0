<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 17:03:07
 */

namespace WebSite\Modelo;

class GoogleAnalytics extends \Geral\Modelo\Principal{
    protected $id, $usuario, $senha, $perfil_id, $codigo_ua, $ativar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _usuario($v=null){
        return is_null($v) ? (string)$this->usuario
        : $this->usuario = (string)filter_var($v, FILTER_VALIDATE_EMAIL);
    } // Fim do méodo _usuario

    public function _senha($v=null){
        return is_null($v) ? (string)$this->senha
        : $this->senha = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do méodo _senha

    public function _perfil_id($v=null){
        return is_null($v) ? (int)$this->perfil_id
        : $this->perfil_id = (int)filter_var($v, FILTER_VALIDATE_INT);
    } // Fim do méodo _perfil_id

    public function _codigo_ua($v=null){
        return is_null($v) ? (string)$this->codigo_ua
        : $this->codigo_ua = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do méodo _codigo_ua

    public function _ativar($v=null){
        if( is_null($v) ) return (int)$this->ativar;

        if( !empty($v) && ($v < 0 || $v > 1) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, 'ativar'), 1500);

        return $this->ativar = (int)filter_var($v, FILTER_VALIDATE_INT);
    } // Fim do método _ativar



    public function __construct($id=null){
        parent::__construct('dl_site_google_analytics', 'ga_');

        if( !empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Salvar o registro no banco de dados
     * -------------------------------------------------------------------------
     *
     * @param int $s Define se o registro será salvo automaticamente ou se deve
     *  ser retornado a string da consulta SQL
     */
    public function _salvar($s=true){
        # Apenas um registro pode conter a Flag 'ativar' marcada, portanto, caso
        # a flag do registro atual esteja marcada, deve-se desmarcar a flag de
        # qualquer outro registro
        if( $this->ativar == 1 )
            \DL3::$bd_conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}ativar = 0");

        return parent::_salvar($s);
    } // Fim do método _salvar



    /**
     * Selecionar a configuração ativa
     * -------------------------------------------------------------------------
     */
    public function _selecionar_ativa(){
        $l = end($this->_listar("{$this->bd_prefixo}ativar = 1", null, "{$this->bd_prefixo}id AS ID"));

        if( $l === false )
            throw new \Exception(ERRO_GOOGLEANALYTICS_PRINCIPAL_NAO_ENCONTRADO, 1404);

        return $this->_selecionarID($l['ID']);
    } // Fim do método _selecionar_ativa
} // Fim do Modelo GoogleAnalytics