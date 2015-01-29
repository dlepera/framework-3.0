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
        return is_null($v) ? (string)$this->titulo
        : $this->titulo = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _titulo

    public function _host($v=null){
        return is_null($v) ? (string)$this->host
        : $this->host = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _host

    public function _porta($v=null){
        return is_null($v) ? (int)$this->porta
        : $this->porta = (int)filter_var($v, FILTER_SANITIZE_NUMBER_INT);
    } // Fim do método _porta

    public function _autent($v=null){
        if ( is_null($v) ) return (int)$this->autent;

        if( !empty($v) && ($v < 0 && $v > 0) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, 'autent'), 1500);

        return $this->autent = (int)filter_var($v, FILTER_SANITIZE_NUMBER_INT);
    } // Fim do método _autent

    public function _cripto($v=null){
        return is_null($v) ? (string)$this->cripto
        : $this->cripto = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _cripto

    public function _conta($v=null){
        return is_null($v) ? (string)$this->conta
        : $this->conta = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _conta

    public function _senha($v=null){
        return is_null($v) ? (string)$this->senha
        : $this->senha = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _senha

    public function _de_email($v=null){
        return is_null($v) ? (string)$this->de_email
        : $this->de_email = (string)filter_var($v, FILTER_VALIDATE_EMAIL);
    } // Fim do método _de_email

    public function _de_nome($v=null){
        return is_null($v) ? (string)$this->de_nome
        : $this->de_nome = (string)filter_var($v, FILTER_SANITIZE_STRING);
    } // Fim do método _de_nome

    public function _responder_para($v=null){
        return is_null($v) ? (string)$this->responder_para
        : $this->responder_para = (string)filter_var($v, FILTER_VALIDATE_EMAIL);
    } // Fim do método _responder_para

    public function _html($v=null){
        if ( is_null($v) ) return (int)$this->html;

        if( !empty($v) && ($v < 0 && $v > 0) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, 'html'), 1500);

        return $this->html = (int)filter_var($v, FILTER_SANITIZE_NUMBER_INT);
    } // Fim do método _html

    public function _principal($v=null){
        if ( is_null($v) ) return (int)$this->principal;

        if( !empty($v) && ($v < 0 && $v > 0) )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, 'principal'), 1500);

        return $this->principal = (int)filter_var($v, FILTER_SANITIZE_NUMBER_INT);
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
