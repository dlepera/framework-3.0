<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 20/05/2014 14:52:19
 */

namespace Geral\Modelo;

class ConfigEmail extends Principal{
    # Propriedades do modelo
    protected $id, $titulo, $host, $porta = 25, $autent, $cripto, $conta, $senha, $de_email, $de_nome, $responder_para,
	    $html = 1, $principal = 1, $delete = 0;

	/*
	 * 'Gets' e 'Sets' das propriedades
	 */
	public function _titulo($v=null){
		return $this->titulo = filter_var(is_null($v) ? $this->titulo : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _titulo

	public function _host($v=null){
		return $this->host = filter_var(is_null($v) ? $this->host : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _host

	public function _porta($v=null){
		return $this->porta = filter_var(is_null($v) ? $this->porta : $v, FILTER_VALIDATE_INT);
	} // Fim do método _porta

	public function _autent($v=null){
		return $this->autent = filter_var(is_null($v) ? $this->autent : $v, FILTER_VALIDATE_BOOLEAN);
	} // Fim do método _autent

	public function _cripto($v=null){
		return $this->cripto = filter_var(is_null($v) ? $this->cripto : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _cripto

	public function _conta($v=null){
		return $this->conta = filter_var(is_null($v) ? $this->conta : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _conta

	public function _senha($v=null){
		return $this->senha = filter_var(is_null($v) ? $this->senha : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _senha

	public function _de_email($v=null){
		return $this->de_email = filter_var(is_null($v) ? $this->de_email : $v, FILTER_VALIDATE_EMAIL);
	} // Fim do método _de_email

	public function _de_nome($v=null){
		return $this->de_nome = filter_var(is_null($v) ? $this->de_nome : $v, FILTER_SANITIZE_STRING);
	} // Fim do método _de_nome

	public function _responder_para($v=null){
		return $this->responder_para = filter_var(is_null($v) ? $this->responder_para : $v, FILTER_VALIDATE_EMAIL);
	} // Fim do método _responder_para

	public function _html($v=null){
		return $this->html = filter_var(is_null($v) ? $this->html : $v, FILTER_VALIDATE_BOOLEAN);
	} // Fim do método _html

	public function _principal($v=null){
		return $this->principal = filter_var(is_null($v) ? $this->principal : $v, FILTER_VALIDATE_BOOLEAN);
	} // Fim do método _principal



	public function __construct($pk = null){
		parent::__construct('dl_painel_email_config', 'config_email_');

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
	protected function _salvar($s=true, $ci=null, $ce=null, $ipk=false){
		# Apenas um registro pode ter a flag 'principal' marcada. Portanto, caso
		# o registro atual tenha a flag, a mesma deve ser desmarcada em qualquer
		# outro registro
		$this->principal && $s AND \DL3::$bd_conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}principal = 0");

		return parent::_salvar($s);
	} // Fim do método _salvar



    /**
     * Selecionar apenas a configuração principal
     *
     * Selecionar apenas o registro que está definido como principal e carregá-lo no modelo
     */
    public function _selecionarprincipal(){
        $lis_m = $this->_listar("{$this->bd_prefixo}principal", null, "{$this->bd_prefixo}id", 0, 1, 0);

        if( $lis_m === false )
            throw new \Exception(ERRO_CONFIGEMAIL_SELECIONARPRINCIPAL, 1404);

        $this->_selecionarPK($lis_m["{$this->bd_prefixo}id"]);
    } // Fim do método _selecionarprincipal
} // Fim do modelo ConfigModelo
