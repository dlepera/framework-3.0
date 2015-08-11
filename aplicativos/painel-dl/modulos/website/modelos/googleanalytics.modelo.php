<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 17:03:07
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class GoogleAnalytics extends GeralM\Principal{
    protected $id, $apelido, $usuario, $senha, $perfil_id, $codigo_ua, $principal = 0, $publicar = 1, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _apelido($v = null){
        return $this->apelido = filter_var(!isset($v) ? $this->apelido : $v, FILTER_SANITIZE_STRING);
    } // Fim do méodo _apelido

    public function _usuario($v = null){
        return $this->usuario = filter_var(!isset($v) ? $this->usuario : $v, FILTER_VALIDATE_EMAIL);
    } // Fim do méodo _usuario

    public function _senha($v = null){
        return $this->senha = filter_var(!isset($v) ? $this->senha : $v);
    } // Fim do méodo _senha

    public function _perfil_id($v = null){
        return $this->perfil_id = filter_var(!isset($v) ? $this->perfil_id : $v, FILTER_VALIDATE_INT);
    } // Fim do méodo _perfil_id

    public function _codigo_ua($v = null){
        return $this->codigo_ua = filter_var(!isset($v) ? $this->codigo_ua : $v, FILTER_SANITIZE_STRING);
    } // Fim do méodo _codigo_ua

    public function _principal($v = null){
        return $this->principal = filter_var(!isset($v) ? $this->principal : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _principal



    public function __construct($pk = null){
        parent::__construct('dl_site_google_analytics', 'ga_');
        $this->_selecionarPK($pk);
    } // Fim do método __construct




    /**
     * Salvar determinado registro
     *
     * @param boolean $s   Define se o registro será salvo ou apenas será gerada a query de insert/update
     * @param array   $ci  Vetor com os campos a serem considerados
     * @param array   $ce  Vetor com os campos a serem desconsiderados
     * @param bool    $ipk Define se o campo PK será considerado para inserção
     *
     * @return mixed
     * @throws \Exception
     */
	protected function _salvar($s = true, $ci = null, $ce = null, $ipk = false){
        # Apenas um registro pode conter a Flag 'principal' marcada, portanto, caso
        # a flag do registro atual esteja marcada, deve-se desmarcar a flag de
        # qualquer outro registro
        $this->principal and \DL3::$bd_conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}principal = 0");

        return parent::_salvar($s, $ci, $ce, $ipk);
    } // Fim do método _salvar




    /**
     * Selecionar a configuração principal
     */
    public function _selecionar_principal(){
	    return $this->_selecionarUK('principal', 1);
    } // Fim do método _selecionar_principal
} // Fim do Modelo GoogleAnalytics