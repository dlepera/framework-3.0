<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 22:01:46
 */

namespace Admin\Modelo;

class ConfigEmail extends \Geral\Modelo\Principal{
    protected $id, $titulo, $host, $porta = 25, $autent = 0, $cripto, $conta, $senha,
            $de_email, $de_nome, $responder_para, $html = 0, $principal = 0, $delete = 0;

    /**
     * 'Gets' e 'Sets' das senhariedades
     * -------------------------------------------------------------------------
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



    public function __construct($id=null){
        parent::__construct('dl_painel_email_config', 'config_email_');

        if( !empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método __construct



    /**
     * Salvar o registro em banco de dados
     * -------------------------------------------------------------------------
     *
     * @param int $s - Define se o registro será salvo automaticamente ou se
     *  o método deve retornar a consulta SQL criada
     */
    protected function _salvar($s = true){
        # Apenas um registro pode ter a flag 'principal' marcada. Portanto, caso
        # o registro atual tenha a flag, a mesma deve ser desmarcada em qualquer
        # outro registro
        if( $this->principal && $s )
            \DL3::$bd_conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}principal = 0");

        return parent::_salvar($s);
    } // Fim do método _salvar
} // Fim do Modelo ConfigEmail
