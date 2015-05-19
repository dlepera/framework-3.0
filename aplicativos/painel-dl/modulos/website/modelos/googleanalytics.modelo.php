<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 17:03:07
 */

namespace WebSite\Modelo;

class GoogleAnalytics extends \Geral\Modelo\Principal{
    protected $id, $apelido, $usuario, $senha, $perfil_id, $codigo_ua, $principal = 0, $publicar = 1, $delete = 0;

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _apelido($v=null){
        return $this->apelido = filter_var(is_null($v) ? $this->apelido : $v, FILTER_SANITIZE_STRING);
    } // Fim do méodo _apelido

    public function _usuario($v=null){
        return $this->usuario = filter_var(is_null($v) ? $this->usuario : $v, FILTER_VALIDATE_EMAIL);
    } // Fim do méodo _usuario

    public function _senha($v=null){
        return $this->senha = filter_var(is_null($v) ? $this->senha : $v);
    } // Fim do méodo _senha

    public function _perfil_id($v=null){
        return $this->perfil_id = filter_var(is_null($v) ? $this->perfil_id : $v, FILTER_VALIDATE_INT);
    } // Fim do méodo _perfil_id

    public function _codigo_ua($v=null){
        return $this->codigo_ua = filter_var(is_null($v) ? $this->codigo_ua : $v, FILTER_SANITIZE_STRING);
    } // Fim do méodo _codigo_ua

    public function _principal($v=null){
        return $this->principal = filter_var(is_null($v) ? $this->principal : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _principal



    public function __construct($id=null){
        parent::__construct('dl_site_google_analytics', 'ga_');

        if( !empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Salvar o registro no banco de dados
     * -------------------------------------------------------------------------
     *
     * @param boolean $s - define se o registro será salvo ou apenas será gerada a query de insert/update
     * @param array $ci - vetor com os campos a serem considerados
     * @param array $ce - vetor com os campos a serem desconsiderados
     * @param bool $ipk - define se o campo PK será considerado para inserção
     */
    public function _salvar($s=true, $ci=null, $ce=null, $ipk=false){
        # Apenas um registro pode conter a Flag 'principal' marcada, portanto, caso
        # a flag do registro atual esteja marcada, deve-se desmarcar a flag de
        # qualquer outro registro
        if( $this->principal == 1 )
            \DL3::$bd_conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}principal = 0");

        return parent::_salvar($s, $ci, $ce, $ipk);
    } // Fim do método _salvar



    /**
     * Selecionar a configuração principal
     * -------------------------------------------------------------------------
     */
    public function _selecionar_principal(){
        $l = $this->_listar("{$this->bd_prefixo}principal", null, "{$this->bd_prefixo}id AS ID", 0, 1, -1);
        
        if( $l === false )
            throw new \Exception(ERRO_GOOGLEANALYTICS_PRINCIPAL_NAO_ENCONTRADO, 1404);

        return $this->_selecionarID($l['ID']);
    } // Fim do método _selecionar_principal
} // Fim do Modelo GoogleAnalytics