<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 01:50:57
 */

use \Admin\Controle as AdminC;

class Controle{
    private $modulo, $controle, $acao, $params = [];

    /*
     * 'Gets' e 'Sets' das propriedades
     */
    public function __get($n){ return m_get($this, $n); } // Fim do método __get
    public function __set($n, $v){ return m_set($this, $n, $v); } // Fim do método __set

    public function _modulo($v = null){
        return $this->modulo = str_replace(' ', '', ucwords(str_replace('-', ' ', filter_var(!isset($v) ? $this->modulo : $v, FILTER_SANITIZE_STRING))));
    } // Fim do método _modulo

    public function _controle($v = null){
        return !isset($v) ? (string)$this->controle
        : $this->controle = (string)( !empty($this->modulo) ? "{$this->modulo}\\" : '') ."Controle\\{$v}";
    } // Fim do método _controle

    public function _acao($v = null){
        return $this->acao = filter_var(!isset($v) ? $this->acao : "_{$v}", FILTER_SANITIZE_STRING);
    } // Fim do método _acao

    public function _params($v = null){
        // CORRIGIR: Não funcionou dessa maneira
        // return $this->params = filter_var(!isset($v) ? $this->params : $v, null, FILTER_REQUIRE_ARRAY);
        return !isset($v) ? (array)$this->params : $this->params = (array)$v;
    } // Fim do método _params




	public function __construct($m, $c, $a, array $p = []){
        $this->_modulo($m);
        $this->_controle($c);
        $this->_acao($a);
        $this->_params($p);
    } // Fim do método __construct




	/**
	 * Validar o controle
	 *
	 * Verificar se o controle foi carregado e se o método / ação existe dentro dele
	 *
	 * @return bool Retorna true se o controle e ação são válidos ou false caso contrário
	 */
    public function _validar(){
        return class_exists($this->controle) || method_exists($this->controle, $this->acao);
    } // Fim do método _validar




	/**
	 * Exceutar o controle solicitado
	 */
    public function _executar(){
        if( !$this->_validar() )
            throw new Exception('A ação não pôde ser executada!', 1500);

	    return \DL3::$aut_o instanceof \Autenticacao && $_SESSION['usuario_conf_reset'] && $this->modulo !== 'admin' && $this->controle !== '\Admin\Controle\Usuario' && $this->acao !== '_alterarsenha'
	        ? $this->_chamar_metodo(new AdminC\Usuario(), '_formalterarsenha', [])
		    : $this->_chamar_metodo(new $this->controle(), $this->acao, !empty($this->params) ? $this->params : []);
    } // Fim do método _executar




	/**
	 * Chamar um determinado método
	 *
	 * @param mixed  $classe Instância da classe
	 * @param string $metodo Nome do método a ser executado
	 * @param array  $args   Vetor associativo dos parâmetros a serem passado ao método
	 *
	 * @return mixed
	 */
    public function _chamar_metodo($classe, $metodo, array $args = []){
		$rfx_m = new ReflectionMethod($classe, $metodo);
	    $params = array_map(function(&$v){ return (string)$v->name; }, $rfx_m->getParameters());
	    $pass = [];

	    foreach( $params as $p )
		    $pass[] = array_key_exists($p, $args) ? $args[$p] : null;

	    return call_user_func_array([$classe, $metodo], $pass);
    } // Fim do método _chamar_metodo
} // Fim da classe Controle