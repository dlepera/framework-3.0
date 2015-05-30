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
    protected $id, $titulo, $host, $porta = 25, $autent, $cripto, $conta, $senha,
            $de_email, $de_nome, $responder_para, $html = 1, $principal = 1,
            $delete = 0;

    public function __construct($id=0){
        parent::__construct('dl_painel_email_config', 'config_email_');

        if( !empty($id) )
            $this->_selecionarID((int)$id);
    } // Fim do método mágico de construção da classe



    /**
     * 'Gets' e 'Sets' das propriedades
     * -------------------------------------------------------------------------
     */
    public function _titulo($v=null){
        return is_null($v) ? (string)$this->titulo
        : $this->titulo = (string)$v;
    } // Fim do método _titulo

    public function _host($v=null){
        return is_null($v) ? (string)$this->host
        : $this->host = (string)$v;
    } // Fim do método _host

    public function _porta($v=null){
        return is_null($v) ? (int)$this->porta
        : $this->porta = (int)$v;
    } // Fim do método _porta

    public function _autent($v=null){
        if( is_null($v) )
            return (int)$this->autent;

        if( (int)$v < 0 || (int)$v > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);

        return $this->autent = (int)$v;
    } // Fim do método _autent

    public function _cripto($v=null){
        return is_null($v) ? (string)$this->cripto
        : $this->cripto = (string)$v;
    } // Fim do método _cripto

    public function _conta($v=null){
        return is_null($v) ? (string)$this->conta
        : $this->conta = (string)$v;
    } // Fim do método _conta

    public function _senha($v=null){
        return is_null($v) ? (string)$this->senha
        : $this->senha = (string)$v;
    } // Fim do método _senha

    public function _de_email($v=null){
        if( is_null($v) )
            return $this->de_email;

        if( !$this->de_email = filter_var($v, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE) )
            throw new \Exception(sprintf(ERRO_PADRAO_FORMATO_NAO_CORRESPONDE, __METHOD__), 1500);

        return $this->de_email = (string)$v;
    } // Fim do método _de_email

    public function _de_nome($v=null){
        return is_null($v) ? (string)$this->de_nome
        : $this->de_nome = (string)$v;
    } // Fim do método _de_nome

    public function _responder_para($v=null){
        if( is_null($v) )
            return (string)$this->responder_para;

        if( !$this->responder_para = filter_var($v, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE) )
            throw new \Exception(sprintf(ERRO_PADRAO_FORMATO_NAO_CORRESPONDE, __METHOD__), 1500);

        return $this->responder_para = (string)$v;
    } // Fim do método _responder_para

    public function _html($v=null){
        if( is_null($v) )
            return (int)$this->html;

        if( (int)$v < 0 || (int)$v > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);

        return $this->html = (int)$v;
    } // Fim do método _html

    public function _principal($v=null){
        if( is_null($v) )
            return (int)$this->principal;

        if( (int)$v < 0 || (int)$v > 1 )
            throw new \Exception(sprintf(ERRO_PADRAO_VALOR_INVALIDO, __METHOD__), 1500);

        return $this->principal = (int)$v;
    } // Fim do método _principal



    /**
     * Salvar determinado registro
     * -------------------------------------------------------------------------
     *
     * @param boolean $s - define se o registro será salvo ou apenas será gerada a query de insert/update
     * @param array $ci - vetor com os campos a serem considerados
     * @param array $ce - vetor com os campos a serem desconsiderados
     * @param bool $ipk - define se o campo PK será considerado para inserção
     */
    protected function _salvar($s = true, $ci = null, $ce = null, $ipk = false){
        # Apenas 1 configuração pode ser definida como principal.
        # Portanto caso a configuração atual esteja sendo configurada
        # como principal, deve-se remover a flag de qualquer outro registro
        if( $this->principal === 1 && $s )
            \DL3::$bd_pdo->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}principal = 0 WHERE {$this->bd_prefixo}principal = 1");

        return parent::_salvar($s, $ci, $ce, $ipk);
    } // Fim do método _salvar



    /**
     * Selecionar apenas a configuração principal
     * -------------------------------------------------------------------------
     *
     * Selecionar apenas o registro que está definido como principal e carregá-lo
     * no modelo
     */
    public function _selecionarprincipal(){
        $lis_m = $this->_listar("{$this->bd_prefixo}principal", null, "{$this->bd_prefixo}id", 0, 1, 0);

        if( $lis_m === false )
            throw new \Exception(ERRO_CONFIGEMAIL_SELECIONARPRINCIPAL, 1404);

        $this->_selecionarID($lis_m["{$this->bd_prefixo}id"]);
    } // Fim do método _selecionarprincipal
} // Fim do modelo ConfigModelo
