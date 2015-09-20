<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 22:01:46
 */

namespace Admin\Modelo;

use \Geral\Modelo as GeralM;

class ConfigEmail extends GeralM\Principal{
    protected $id, $titulo, $host, $porta = 25, $autent = 0, $cripto, $conta, $senha, $de_email, $de_nome, $responder_para,
	    $html = 0, $principal = 0, $debug = 0, $delete = 0;

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function _titulo($v = null){
        return $this->titulo = filter_var(!isset($v) ? $this->titulo : $v, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    } // Fim do método _titulo

    public function _host($v = null){
        return $this->host = filter_var(!isset($v) ? $this->host : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _host

    public function _porta($v = null){
        return $this->porta = filter_var(!isset($v) ? $this->porta : $v, FILTER_VALIDATE_INT,
            ['options' => ['default' => 25, 'min_range' => 1, 'max_range' => 65535]]);
    } // Fim do método _porta

    public function _autent($v = null){
        return $this->autent = filter_var(!isset($v) ? $this->autent : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _autent

    public function _cripto($v = null){
        return $this->cripto = filter_var(!isset($v) ? $this->cripto : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _cripto

    public function _conta($v = null){
        return $this->conta = filter_var(!isset($v) ? $this->conta : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _conta

    public function _senha($v = null){
        return $this->senha = filter_var(!isset($v) ? $this->senha : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _senha

    public function _de_email($v = null){
        return $this->de_email = filter_var(!isset($v) ? $this->de_email : $v, FILTER_VALIDATE_EMAIL);
    } // Fim do método _de_email

    public function _de_nome($v = null){
        return $this->de_nome = filter_var(!isset($v) ? $this->de_nome : $v, FILTER_SANITIZE_STRING);
    } // Fim do método _de_nome

    public function _responder_para($v = null){
        return $this->responder_para = filter_var(!isset($v) ? $this->responder_para : $v, FILTER_VALIDATE_EMAIL);
    } // Fim do método _responder_para

    public function _html($v = null){
        return $this->html = filter_var(!isset($v) ? $this->html : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _html

    public function _principal($v = null){
        return $this->principal = filter_var(!isset($v) ? $this->principal : $v, FILTER_VALIDATE_BOOLEAN);
    } // Fim do método _principal

	public function _debug($v = null){
		return $this->debug = filter_var(!isset($v) ? $this->debug : $v, FILTER_VALIDATE_BOOLEAN);
	} // Fim do método _debug



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
	protected function _salvar($s = true, array $ci = null, array $ce = null, $ipk = false){
        # Apenas um registro pode ter a flag 'principal' marcada. Portanto, caso
        # o registro atual tenha a flag, a mesma deve ser desmarcada em qualquer
        # outro registro
        $this->principal && $s and \DL3::$bd_conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}principal = 0");

        return parent::_salvar($s, $ci, $ce, $ipk);
    } // Fim do método _salvar




	/**
	 * Selecionar o registro marcado como principal
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function _selecionar_principal(){
	    return $this->_selecionarUK('principal', 1);
    } // Fim do método _selecionar_principal
} // Fim do Modelo ConfigEmail
