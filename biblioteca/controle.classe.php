<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 01:50:57
 */


class Controle{
    private $modulo, $controle, $acao, $params = array();

    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function __get($n){ return m_get($this, $n); } // Fim do método __get
    public function __set($n, $v){ return m_set($this, $n, $v); } // Fim do método __set

    public function _modulo($v=null){
        return $this->modulo = str_replace(' ', '', ucwords(str_replace('-', ' ', filter_var(is_null($v) ? $this->modulo : $v, FILTER_SANITIZE_STRING))));
    } // Fim do método _modulo

    public function _controle($v=null){
        return is_null($v) ? (string)$this->controle
        : $this->controle = (string)( !empty($this->modulo) ? "{$this->modulo}\\" : '') ."Controle\\{$v}";
    } // Fim do método _controle

    public function _acao($v=null){
        return $this->acao = filter_var(is_null($v) ? $this->acao : "_{$v}", FILTER_SANITIZE_STRING);
    } // Fim do método _acao

    public function _params($v=null){
        // Não funcionou dessa maneira
        // return $this->params = filter_var(is_null($v) ? $this->params : $v, null, FILTER_REQUIRE_ARRAY);
        return is_null($v) ? (array)$this->params : $this->params = (array)$v;
    } // Fim do método _params

    public function __construct($m, $c, $a, array $p = array()){
        $this->_modulo($m);
        $this->_controle($c);
        $this->_acao($a);
        $this->_params($p);
    } // Fim do método __construct



    /**
     * Validar o controle
     * -------------------------------------------------------------------------
     * Verificar se o controle foi carregado e se o método / ação existe dentro
     * dele
     *
     * @return bool - Retorna true se o controle e ação são válidos ou false
     *  caso contrário
     */
    public function _validar(){
        return class_exists($this->controle) || method_exists($this->controle, $this->acao);
    } // Fim do método _validar



    /**
     * Exceutar o controle solicitado
     * -------------------------------------------------------------------------
     */
    public function _executar(){
        if( !$this->_validar() )
            throw new Exception('A ação não pôde ser executada!', 1500);

        $c = new $this->controle();

        if( \DL3::$aut_o instanceof \Autenticacao && $_SESSION['usuario_conf_reset'] &&
            ($this->modulo != 'admin' && $this->controle != '\Admin\Controle\Usuario' && $this->acao != '_alterarsenha') ):

            return  call_user_func_array(
                array(new \Admin\Controle\Usuario(), '_formalterarsenha'), array()
            );
        endif;

        return call_user_func_array(
            array($c, $this->acao),
            !empty($this->params) ? $this->params : array()
        );
    } // Fim do método _executar
} // Fim da classe Controle